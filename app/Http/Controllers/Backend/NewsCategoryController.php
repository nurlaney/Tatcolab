<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Lng;
use App\Models\News_category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function collect;
use function redirect;
use function view;

class NewsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $categories = News_category::withTrashed()->select()->where('l_id',1)->orderBy('u_id')->paginate(5);

        $categories->load('lng');
        
        return view('backend.news_categories.index', ['categories'=>$categories]);



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        $categories = News_category::select()->where('l_id',1)->orderBy('u_id')->get();
        $lngs = Lng::all();
        return view('backend.news_categories.create',['categories'=>$categories,'lngs'=>$lngs]);
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
        $lastUid = News_category::withTrashed()->orderBy('u_id','desc')->first();
        if($lastUid == null){
            $uid = 1;
        } else $uid=$lastUid->u_id+1;
        $input['u_id'] = $uid;
        $input['tag'] = $request->tag;
        $input['sub_id'] = $request->sub_id;
        
        $attrs = $request->except('sub_id');
        $ats = array_keys($attrs);
        
        foreach ($lngs as $lng){
            $input['l_id'] = $lng->u_id;
            for($i = 0; $i<count($ats); $i++){
                if(count(explode($lng->u_id,$ats[$i]))>1) {
                    $attr = explode($lng->u_id, $ats[$i])[0];
                    $input[$attr] = $attrs[$ats[$i]];
                }
            }
            
            $category = new News_category($input);
            $category->save();
        }
        return redirect()->route('admin.news_categories');
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
        $thisCategories = News_category::select()->where('l_id',1)->orderBy('u_id')->get();


        $lngs = Lng::all();

        $lngs->load('news_categories');
        $l_id = Lng::select('u_id')->whereNotIn('u_id', function ($q) use (&$id){
            $q->select('l_id')->from('news_categories')->where('u_id',$id);
        })->get();
        foreach ($l_id as $lid){
            $newsCategory = News_category::select()->where('u_id',$id)->first();
            $newsCategoryArray = collect($newsCategory->toArray())->only(['u_id', 'sub_id', 'ordering', 'picture','bg_image'])->toArray();
            $newsCategoryArray['l_id']=$lid->u_id;
            $categories  = new News_category($newsCategoryArray);
            $categories->save();
        }
        $categories = News_category::select()->where('u_id',$id)->get();
        return view('backend.news_categories.edit',['categories'=>$thisCategories,'categoriesL'=>$categories,'lngs'=>$lngs]);
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
        $categories = News_category::select()->where(['u_id'=>$id])->get();
        if(is_uploaded_file($request->picture)){
            $file = $request->picture;
            $file->move('images', $file->getClientOriginalName());
            $input['picture'] = $file->getClientOriginalName();
        }
        if(is_uploaded_file($request->bg_image)){
            $file = $request->bg_image;
            $file->move('images', $file->getClientOriginalName());
            $input['bg_image'] = $file->getClientOriginalName();
        }
        $input['sub_id'] = $request->sub_id;
        $input['tag'] = $request->tag;
        $attrs = $request->except('sub_id', 'picture', 'bg_image');
        $ats = array_keys($attrs);
        foreach ($categories as $category){
            for($i = 0; $i<count($ats); $i++){
                if(count(explode($category->l_id,$ats[$i]))>1) {
                    $attr = explode($category->l_id, $ats[$i])[0];
                    $input[$attr] = $attrs[$ats[$i]];
                }

            }
            $category->update($input);
            //$categories->save();
        }

        return redirect()->route('admin.news_categories')->withFlashSuccess('Update was successful');
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
        $categories = News_category::select()->where('u_id',$id)->get();
        foreach ($categories as $category){
            $category->delete();
        }
        return redirect()->route('admin.news_categories');
    }

    public function forceDelete($id){
        $status = News_category::withTrashed()->where('u_id',$id)->forceDelete();
        if($status){
            return redirect()->route('admin.news_categories')->withFlashSuccess('Silindi');
        }
        return redirect()->route('admin.news_categories')->withDangerSuccess('Sehv bas verdi');
    }

    public function restore($id){
        News_category::withTrashed()->where('u_id',$id)->restore();
        return redirect()->route('admin.news_categories');
    }
}

