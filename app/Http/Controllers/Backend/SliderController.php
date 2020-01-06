<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Lng;
use File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Slider;
use function collect;
use function public_path;
use function redirect;
use function view;

class SliderController extends Controller
{
    public function index()
    {
        //
        $sliders = Slider::withTrashed()->where('l_id',1)->orderBy('u_id')->paginate();
        $sliders->load('lng');
        return view('backend.sliders.index',['sliders'=>$sliders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        $lngs = Lng::all();
        return view('backend.sliders.create',['lngs'=>$lngs]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
        $lngs = Lng::all();
        $lastUid = Slider::withTrashed()->orderBy('u_id','desc')->first();
        if($lastUid == null){
            $uid = 1;
        } else $uid=$lastUid->u_id+1;

        $input = $request->except('_token');
        $file = $request->picture;

        $image_name=uniqid().'.'.$file->getClientOriginalExtension();

        $file->move('img/site/',$image_name);
        $input['u_id'] = $uid;
        $input['picture'] = $image_name;



        $attrs = $request->all();
        $ats = array_keys($attrs);

        foreach ($lngs as $lng){
            $input['l_id'] = $lng->u_id;
            for($i = 0; $i<count($ats); $i++){
                if(count(explode($lng->u_id,$ats[$i]))>1) {
                    $attr = explode($lng->u_id, $ats[$i])[0];
                    $input[$attr] = $attrs[$ats[$i]];
                }

            }
            //dd($input);
            $slider = new Slider($input);
            $slider->save();
        }

        return redirect()->route('admin.sliders');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
        $lngs = Lng::all();
        $lngs->load('sliders');
        $l_id = Lng::select('u_id')->whereNotIn('u_id', function ($q) use (&$id){
            $q->select('l_id')->from('sliders')->where('u_id',$id);
        })->get();

        foreach ($l_id as $lid){
            $newSlider = Slider::select()->where('u_id',$id)->first();
            $newSliderArray = collect($newSlider->toArray())->only(['u_id', 'picture'])->toArray();
            $newSliderArray['l_id']=$lid->u_id;
            $slider  = new Slider($newSliderArray);
            $slider->save();
        }
        $sliders = Slider::select()->where('u_id',$id)->get();
        return view('backend.sliders.edit',['sliders'=>$sliders,'lngs'=>$lngs]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
        $sliders = Slider::select()->where('u_id',$id)->get();

        if(is_uploaded_file($request->picture)){
            $image_path = public_path()."/img/site/".$sliders->first()->picture;

            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            
            $file = $request->picture;

            $image_name=uniqid().'.'.$file->getClientOriginalExtension();

            $file->move('img/site/', $image_name);
            $input['picture'] =$image_name;

        }
        
        $attrs = $request->all();
        $ats = array_keys($attrs);

        foreach ($sliders as $slider) {
            for ($i = 0; $i < count($ats); $i++) {
                if (count(explode($slider->l_id, $ats[$i])) > 1) {
                    $attr = explode($slider->l_id, $ats[$i])[0];
                    $input[$attr] = $attrs[$ats[$i]];
                }
            }
            $slider->update($input);
        }


        return redirect()->route('admin.sliders');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
        $sliders = Slider::select()->where('u_id',$id)->get();
        foreach ($sliders as $slider){
            $slider->delete();
        }
        return redirect()->route('admin.sliders');
    }

    public function forceDelete($id){
        $status = Slider::withTrashed()->where('u_id',$id)->forceDelete();
        if($status)
            return redirect()->route('admin.sliders')->withFlashSuccess('Silindi');
        return redirect()->route('admin.sliders')->withDangerSuccess('Sehv bas verdi');
    }

    public function restore($id){
        Slider::withTrashed()->where('u_id',$id)->restore();
        return redirect()->route('admin.sliders');
    }
    
}

