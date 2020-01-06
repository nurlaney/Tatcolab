<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Lng;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function back;
use function collect;
use function redirect;
use function view;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $brands = Brand::withTrashed()->select()->orderBy('u_id')->where('l_id',1)->orderBy('u_id')->paginate(5);

        $brands->load('lng');


        return view('backend.brands.index', ['brands'=>$brands]);



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        $brands = Brand::select()->where('l_id',1)->orderBy('u_id')->get();
        $lngs = Lng::all();
        return view('backend.brands.create',['brands'=>$brands,'lngs'=>$lngs]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        
        $lngs = Lng::all();
        $lastUid = Brand::withTrashed()->orderBy('u_id','desc')->first();
        if ($lastUid == null) {
            $uid = 1;
        } else {
            $uid = $lastUid->u_id + 1;
        }
        $input['u_id'] = $uid;

        $input['sub_id'] = $request->sub_id;
        $input['tag'] = $request->tag;
        $file = $request->logo;
        $file->move('images',$file->getClientOriginalName());
        $input['logo'] = $file->getClientOriginalName();
        
        $attrs = $request->except('sub_id','logo');
        $ats = array_keys($attrs);

        foreach ($lngs as $lng){
            $input['l_id'] = $lng->u_id;
            for($i = 0; $i<count($ats); $i++){
                if(count(explode($lng->u_id,$ats[$i]))>1) {
                    $attr = explode($lng->u_id, $ats[$i])[0];
                    $input[$attr] = $attrs[$ats[$i]];
                }

            }
            if($input['title']){
                $say=Brand::select()->where(['title'=>$input['title'],'l_id'=>$input['l_id']])->get();
                $say=$say->count();
                if($say>0){
                    $sec=Brand::select()->where(['u_id'=>$input['u_id']])->get();

                    foreach($sec as $c){
                       $c->forceDelete();
                    }
                   return back()->with('xeta',$input['title'].' adı evvelceden istifade olunub'); 
                }

            }

            
            $brand = new Brand($input);
            $brand->save();
        }
        return redirect()->route('admin.brands');
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
        $thisbrands = Brand::select()->where('l_id',1)->orderBy('u_id')->get();


        $lngs = Lng::all();

        $lngs->load('brands');
        $l_id = Lng::select('u_id')->whereNotIn('u_id', function ($q) use (&$id){
            $q->select('l_id')->from('brands')->where('u_id',$id);
        })->get();
        foreach ($l_id as $lid){
            $brand = Brand::select()->where('u_id',$id)->first();
            $brand = collect($brand->toArray())->only(['u_id', 'sub_id', 'ordering', 'logo','title'])->toArray();
            $brand['l_id']=$lid->u_id;
            $brands  = new Brand($brand);
            $brands->save();
        }
        $brands = Brand::select()->where('u_id',$id)->get();
        return view('backend.brands.edit',['brands'=>$thisbrands,'brandsL'=>$brands,'lngs'=>$lngs]);
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
        $brands = Brand::select()->where(['u_id'=>$id])->get();
        if(is_uploaded_file($request->logo)){
            $file = $request->logo;
            $filename=uniqid(time() . '_'    ).".".$file->getClientOriginalExtension();
            $file->move('img/site', $filename);
            $input['logo'] = $filename;
        }
        
        $input['sub_id'] = $request->sub_id;

        $input['tag'] = $request->tag;
        $attrs = $request->except('sub_id', 'logo');
        $ats = array_keys($attrs);
        foreach ($brands as $brand){
            for($i = 0; $i<count($ats); $i++){
                if(count(explode($brand->l_id,$ats[$i]))>1) {
                    $attr = explode($brand->l_id, $ats[$i])[0];
                    $input[$attr] = $attrs[$ats[$i]];
                }

            }
            if($request->hasFile('logo')){
                $brand->logo = $input['logo'];
            }
            $brand->update($input);
            
        }

        return redirect()->route('admin.brands');
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
        $brands = Brand::select()->where('u_id',$id)->get();
        foreach ($brands as $brand){
            $brand->delete();
        }
        return redirect()->route('admin.brands');
    }

    public function forceDelete($id){
        $status = Brand::withTrashed()->where('u_id',$id)->forceDelete();
        if ($status) {
            return redirect()->route('admin.brands')->withFlashSuccess('Silindi');
        }
        return redirect()->route('admin.brands')->withDangerSuccess('Sehv bas verdi');
    }

    public function restore($id){
        Brand::withTrashed()->where('u_id',$id)->restore();
        return redirect()->route('admin.brands');
    }
}

