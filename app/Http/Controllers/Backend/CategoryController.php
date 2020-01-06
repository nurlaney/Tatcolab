<?php

namespace App\Http\Controllers\Backend;
use App\Models\Lng;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $categories = Category::withTrashed()->select()->where('l_id',1)->orderBy('u_id')->paginate(5);

        $categories->load('lng');


        return view('backend.categories.index', ['categories'=>$categories]);



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        $categories = Category::select()->where('l_id',1)->orderBy('u_id')->get();
        $lngs = Lng::all();
        return view('backend.categories.create',['categories'=>$categories,'lngs'=>$lngs]);
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
        $lastUid = Category::withTrashed()->orderBy('u_id','desc')->first();
        if ($lastUid == null) {
            $uid = 1;
        } else {
            $uid = $lastUid->u_id + 1;
        }
        $input['u_id'] = $uid;
        $input['tag'] = $request->tag;
        if($request->hasFile('image')){
            $file = $request->image;
            
            $filename = uniqid(time() . '_'    ).".".$file->getClientOriginalExtension();
            
            $file->move('img/site', $filename);
            
            $input['image'] = $filename;
            
        }
        
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
            $category = new Category($input);
            $category->image = $input['image'];
            $category->save();
        }
        return redirect()->route('admin.categories');
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
        $thisCategories = Category::select()->where('l_id',1)->orderBy('u_id')->get();


        $lngs = Lng::all();

        $lngs->load('categories');
        $l_id = Lng::select('u_id')->whereNotIn('u_id', function ($q) use (&$id){
            $q->select('l_id')->from('categories')->where('u_id',$id);
        })->get();
        foreach ($l_id as $lid){
            $newCategory = Category::select()->where('u_id',$id)->first();
            $newCategoryArray = collect($newCategory->toArray())->only(['u_id', 'sub_id', 'ordering', 'picture','bg_image'])->toArray();
            $newcategoryArray['l_id']=$lid->u_id;
            $categories  = new Category($newCategoryArray);
            $categories->save();
        }
        $categories = Category::select()->where('u_id',$id)->get();
        return view('backend.categories.edit',['categories'=>$thisCategories,'categoriesL'=>$categories,'lngs'=>$lngs]);
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
        $categories = Category::select()->where(['u_id'=>$id])->get();
        if($request->hasFile('image')){
            $file = $request->image;
            
            $filename = uniqid(time() . '_'    ).".".$file->getClientOriginalExtension();
            
            $file->move('img/site', $filename);
            
            $input['image'] = $filename;
            
        }
        $input['tag'] = $request->tag;
        $input['sub_id'] = $request->sub_id;

        $attrs = $request->except('sub_id', 'image');
        $ats = array_keys($attrs);
        foreach ($categories as $category){
            for($i = 0; $i<count($ats); $i++){
                if(count(explode($category->l_id,$ats[$i]))>1) {
                    $attr = explode($category->l_id, $ats[$i])[0];
                    $input[$attr] = $attrs[$ats[$i]];
                }

            }
            if($request->hasFile('image')){
                $category->image = $input['image'];
            }
            
            $category->update($input);
            
        }
        

        return redirect()->route('admin.categories')->withFlashSuccess('Update was successful');
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
        $categories = Category::select()->where('u_id',$id)->get();
        foreach ($categories as $category){
            $category->delete();
        }
        return redirect()->route('admin.categories');
    }

    public function forceDelete($id){
        $status = Category::withTrashed()->where('u_id',$id)->forceDelete();
        if($status){
            return redirect()->route('admin.categories')->withFlashSuccess('Silindi');
        }
        return redirect()->route('admin.categories')->withDangerSuccess('Sehv bas verdi');
    }

    public function restore($id){
        Category::withTrashed()->where('u_id',$id)->restore();
        return redirect()->route('admin.categories');
    }
}
