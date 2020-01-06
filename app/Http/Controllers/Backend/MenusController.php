<?php
namespace App\Http\Controllers\Backend;


use App\Models\Lng;
use App\Models\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;



class  MenusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $menus = Menu::withTrashed()->select()->where('type',0)->where('l_id',1)->orderBy('u_id')->paginate(5);

        //$menus->load('lng');


        return view('backend.menus.index', ['menus'=>$menus]);



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        $menus = Menu::select()->where('sub_id',0)->where('l_id',1)->where('type',0)->orderBy('u_id')->get();
        $lngs = Lng::all();
        return view('backend.menus.create',['menus'=>$menus,'lngs'=>$lngs]);
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
        $lastUid = Menu::withTrashed()->where('type',0)->orderBy('u_id','desc')->first();
        if($lastUid == null){
            $uid = 1;
        } else $uid=$lastUid->u_id+1;
        $input['u_id'] = $uid;

        $file = $request->picture;
        $filename=uniqid(time() . '_'    ).".".$file->getClientOriginalExtension();
            $file->move('img/site', $filename);
            
        $input['picture'] = $filename;
        //*******************
        $file = $request->bg_image;
        $filename=uniqid(time() . '_'    ).".".$file->getClientOriginalExtension();
            $file->move('img/site', $filename);
            
        $input['bg_image'] = $filename;
        
        $input['sub_id'] = $request->sub_id;
        $input['type'] = 0;

        $attrs = $request->except('sub_id', 'picture', 'bg_image');
        $ats = array_keys($attrs);

        foreach ($lngs as $lng){
            $input['l_id'] = $lng->u_id;
            for($i = 0; $i<count($ats); $i++){
                if(count(explode($lng->u_id,$ats[$i]))>1) {
                    $attr = explode($lng->u_id, $ats[$i])[0];
                    $input[$attr] = $attrs[$ats[$i]];
                }

            }
            $menu = new Menu($input);
            $menu->save();
        }
        return redirect()->route('admin.menus');
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
        $thisMenus = Menu::select()->where('type',0)->where('l_id',1)->orderBy('u_id')->get();


        $lngs = Lng::all();

        $lngs->load('menus');
        $l_id = Lng::select('u_id')->whereNotIn('u_id', function ($q) use (&$id){
            $q->select('l_id')->from('menus')->where('u_id',$id);
        })->get();
        foreach ($l_id as $lid){
            $newMenu = Menu::select()->where('u_id',$id)->first();
            $newMenuArray = collect($newMenu->toArray())->only(['u_id', 'sub_id', 'ordering', 'picture','bg_image'])->toArray();
            $newMenuArray['l_id']=$lid->u_id;
            $menu  = new Menu($newMenuArray);
            $menu->save();
        }
        $menus = Menu::select()->where('u_id',$id)->where('type',0)->get();
        return view('backend.menus.edit',['menus'=>$thisMenus,'menusL'=>$menus,'lngs'=>$lngs]);
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
        $menus = Menu::select()->where(['u_id'=>$id])->get();
        if(is_uploaded_file($request->picture)){
            $file = $request->picture;
            $filename=uniqid($menus[0]->u_id . '_'    ).".".$file->getClientOriginalExtension();
            $file->move('img/site', $filename);
            $input['picture'] = $filename;
        }
        if(is_uploaded_file($request->bg_image)){
            $file = $request->bg_image;
            $filename=uniqid($menus[0]->u_id . '_'    ).".".$file->getClientOriginalExtension();
            $file->move('img/site', $filename);
            $input['bg_image'] = $filename;
        }
        $input['sub_id'] = $request->sub_id;

        $attrs = $request->except('sub_id', 'picture', 'bg_image');
        $ats = array_keys($attrs);
        foreach ($menus as $menu){
            for($i = 0; $i<count($ats); $i++){
                if(count(explode($menu->l_id,$ats[$i]))>1) {
                    $attr = explode($menu->l_id, $ats[$i])[0];
                    $input[$attr] = $attrs[$ats[$i]];
                }

            }
            $menu->update($input);
            $menu->save();
        }

        return redirect()->route('admin.menus')->withFlashSuccess('Update was successful');
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
        $menus = Menu::select()->where('u_id',$id)->get();
        foreach ($menus as $menu){
            $menu->delete();
        }
        return redirect()->route('admin.menus');
    }

    public function forceDelete($id){
        $status = Menu::withTrashed()->where('u_id',$id)->forceDelete();
        if($status)
            return redirect()->route('admin.menus')->withFlashSuccess('Silindi');
        return redirect()->route('admin.menus')->withDangerSuccess('Sehv bas verdi');
    }

    public function restore($id){
        Menu::withTrashed()->where('u_id',$id)->restore();
        return redirect()->route('admin.menus');
    }
}
