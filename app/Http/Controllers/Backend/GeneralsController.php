<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\General;
use App\Models\Lng;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function collect;
use function redirect;
use function view;

class GeneralsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $generals = General::select()->where('l_id',1)->first();

        //$generals->load('lng');

        return view('backend.generals.index', ['generals'=>$generals]);



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $lngs = Lng::all();
        return view('admin.generals.create',['lngs'=>$lngs]);
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
        $lastUid = General::select()->orderBy('u_id','desc')->first();
        if($lastUid == null){
            $uid = 1;
        } else $uid=$lastUid->u_id+1;
        $input['u_id'] = $uid;

        $file = $request->logo;
        $file->move('images',$file->getClientOriginalName());
        $input['logo'] = $file->getClientOriginalName();
        //*******************
        
        $attrs = $request->except( 'logo');
        $ats = array_keys($attrs);

        foreach ($lngs as $lng){
            $input['l_id'] = $lng->u_id;
            for($i = 0; $i<count($ats); $i++){
                if(count(explode($lng->u_id,$ats[$i]))>1) {
                    $attr = explode($lng->u_id, $ats[$i])[0];
                    $input[$attr] = $attrs[$ats[$i]];
                }

            }
            $general = new General($input);
            $general->save();
        }
        return redirect()->route('admin.generals.index');
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
        $thisGenerals = General::all();


        $lngs = Lng::all();

        //$lngs->load('generals');
        $l_id = Lng::select('u_id')->whereNotIn('u_id', function ($q) use (&$id){
            $q->select('l_id')->from('generals')->where('u_id',$id);
        })->get();
        foreach ($l_id as $lid){
            $newGeneral = General::select()->where('u_id',$id)->first();
            $newGeneralArray = collect($newGeneral->toArray())->only(['u_id','logo'])->toArray();
            $newGeneralArray['l_id']=$lid->u_id;
            $general  = new General($newGeneralArray);
            $general->save();
        }
        $generals = General::select()->where('u_id',$id)->get();
        return view('backend.generals.edit',['generals'=>$thisGenerals,'generalsL'=>$generals,'lngs'=>$lngs]);
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
        
        $Generals = General::select()->where(['u_id'=>$id])->get();
        if($request->hasFile('logo')){
            
            $file = $request->logo;
            $filename=uniqid($Generals[0]->u_id . '_'    ).".".$file->getClientOriginalExtension();
            $file->move('img/site', $filename);
            
            $input['logo'] = $filename;
        }
        
        $input['sub_id'] = $request->sub_id;

        $attrs = $request->except('sub_id', 'picture', 'bg_image');
        $ats = array_keys($attrs);
        foreach ($Generals as $General){
            for($i = 0; $i<count($ats); $i++){
                if(count(explode($General->l_id,$ats[$i]))>1) {
                    $attr = explode($General->l_id, $ats[$i])[0];
                    $input[$attr] = $attrs[$ats[$i]];
                }

            }
            $General->update($input);
            $General->save();
        }

        return redirect()->route('admin.generals')->withFlashSuccess('General field was succesfully updated');
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
        $Generals = General::select()->where('u_id',$id)->get();
        foreach ($Generals as $General){
            $General->delete();
        }
        return redirect()->route('admin.generals.index');
    }

    public function forceDelete($id){
        $status = General::withTrashed()->where('u_id',$id)->forceDelete();
        if($status)
            return redirect()->route('admin.generals.index')->withFlashSuccess('Silindi');
        return redirect()->route('admin.generals.index')->withDangerSuccess('Sehv bas verdi');
    }

    public function restore($id){
        General::withTrashed()->where('u_id',$id)->restore();
        return redirect()->route('admin.generals.index');
    }
}
