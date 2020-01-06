<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Lng;
use App\Models\Menu;
use App\Models\Product;
use App\Models\Product_picture;
use App\Models\Linked_product;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Symfony\Component\HttpFoundation\Response;
use function abort;
use function back;
use function collect;
use function public_path;
use function redirect;
use function view;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        $products = Product::withTrashed()->where('l_id',1)->orderBy('u_id')->paginate(10);
        $products->load('lng');
        
        return view('backend.products.index',['products'=>$products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        //sadece 3 dil ucun isleyecek
        if(!empty($request->name1)){
            $this->validate($request,[
                'name1'=>'unique:products,name',
            ]);
        }
        if(!empty($request->name2)){
            $this->validate($request,[
                'name2'=>'unique:products,name',
            ]);
        }
        if(!empty($request->name3)){
            $this->validate($request,[
                'name3'=>'unique:products,name',
            ]);
        }
        //
        $lngs = Lng::all();
        $brands = Brand::select()->where('l_id', Lng::select()->where('default',1)->first()->u_id)->get();
        $categories = Category::select()->where('l_id', Lng::select()->where('default',1)->first()->u_id)->get();
        
        $products = Product::select()->where('l_id',1)->get();
        //dd($categories);
        return view('backend.products.create',['lngs'=>$lngs,'brand_options'=>$brands,'category_options'=>$categories,'products'=>$products]);
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
        $lastUid = Product::withTrashed()->orderBy('u_id','desc')->first();
        if ($lastUid == null) {
            $uid = 1;
        } else {
            $uid = $lastUid->u_id + 1;
        }
        $file = $request->first_image;
        $name=uniqid().'.'.$file->getClientOriginalExtension();
        $file2 = $request->second_image;
        $name2=uniqid().'.'.$file->getClientOriginalExtension();

        $input['tag'] = $request->tag;
        $input['u_id'] = $uid;
        $input['price'] = $request->price;
        $input['discount_price'] = $request->discount_price;
        
        $input['first_image'] =$name;
        $input['second_image'] =$name2;
        
        $input['user_id'] = $request->user_id;
        $input['categories'] = $request->categories;
        $input['brands'] = $request->brands;


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
            if($input['title']){
                $say=Product::select()->where(['title'=>$input['title'],'l_id'=>$input['l_id']])->get();
                $say=$say->count();
                if($say>0){
                    $sec=Product::select()->where(['u_id'=>$input['u_id']])->get();

                    foreach($sec as $c){
                       $c->forceDelete();
                    }
                   return back()->with('xeta',$input['title'].' adı evvelceden istifade olunub'); 
                }

            }
            
            
            //dd($input);
            $products = new Product($input);
            $products->save();
        }
        
        if($request->has('linked_products')){
            
            foreach($request->linked_products as $id)  {      
                $linked = new Linked_product();
                $linked->main_product = $products->u_id;
                $linked->linked_product = $id;
                
                $linked->save();
            }
        }
        
        $file->move('img/site/',$name);
         $file2->move('img/site/',$name2);
        $products->categories()->attach($input['categories']);
        $products->brands()->attach($input['brands']);
        
        
        
        if($request->hasFile('picture')){
            $files = $request->picture;
            foreach ($files as $file){
                $file_name=uniqid().'.'.$file->getClientOriginalExtension();
                $file->move('img/site',$file_name);

                $product_picture= new Product_picture();
                $product_picture->product_id=$uid;
                $product_picture->name=$file_name;
                $product_picture->save();
            }
        }

        
        
        return redirect()->route('admin.products')->withFlashSuccess('New product was added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($lng, $url_tag)
    {
        $this->template = 'site.news.show';
        $lang = Lng::select()->where('short_name', $lng)->first();
        if (!$lang) {
            abort(404);
        }

        $menu = Menu::select()->where(['l_id' => $lang->u_id, 'url_tag' => 'news'])->first();
        $this->vars['seo'] = $menu;

//        $products = News::select()->where('l_id',$lang->u_id)->orderByRaw('RAND()')->take(6)->get();
//        $this->vars['products'] = $products;

        $advert = News::select()->where(['name'=>$url_tag, 'l_id'=>$lang->u_id])->first();
        $this->vars['advert'] = $advert;

        $categories_all=$advert->categories()->where('l_id',$lang->u_id)->get();
        $this->vars['categories_all'] = $categories_all;

        $last = News::select()->where(['l_id'=>$lang->u_id])->orderBy('created_at','desc')->take(5)->get();
        $this->vars['last'] = $last;


        $products = News::select()->where('l_id',$lang->u_id)->orderByRaw('RAND()')->take(5)->get();
        $this->vars['products'] = $products;


        $this->vars['lng'] = $lang->u_id;



        $categories=Category::select()->where(['l_id'=>$lang->u_id])->get();
        $this->vars['categories'] = $categories;




        if ($advert) {
            $prevAdvert = News::select()->where([['l_id', '=', $lang->u_id], ['u_id', '<', $advert->u_id]])->first();
            $nextAdvert = News::select()->where([['l_id', '=', $lang->u_id], ['u_id', '>', $advert->u_id]])->first();
            $this->vars['prevAdvert'] = $prevAdvert;
            $this->vars['nextAdvert'] = $nextAdvert;
            $this->vars['seo']['description'] = $advert->description;
            $this->vars['seo']['image'] = $advert->image;
        }

        return $this->renderOutput($lng);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $lngs = Lng::all();
        $lngs->load('products');
        $categories = Category::select()->where('l_id', Lng::select()->where('default',1)->first()->u_id)->get();
        $brands = Brand::select()->where('l_id', Lng::select()->where('default',1)->first()->u_id)->get();
        $l_id = Lng::select('u_id')->whereNotIn('u_id', function ($q) use (&$id){
            $q->select('l_id')->from('products')->where('u_id',$id);
        })->get();
        foreach ($l_id as $lid){
            $newProduct = Product::select()->where('u_id',$id)->first();
            $newProductArray = collect($newProduct->toArray())->only(['u_id', 'first_image','second_image','user_id'])->toArray();
            $newProductArray['l_id']=$lid->u_id;
            $product = new Product($newProductArray);
            $product->save();
        }
        
        $product = Product::select()->where('u_id',$id)->get();
        $product->load('lng');
        
        $option_products = Product::select()->where('l_id',1)->get();
        $linked_products_all = Linked_product::select()->where('main_product',$product[0]->u_id)->get();
        
        $linked_products = [];
        
        foreach($linked_products_all as $linked){
            $linked_products[] = $linked->linked_product;
        }
        
        $product_pictures = Product_picture::select()->where('product_id',$product[0]->u_id)->get();
        
        return view('backend.products.edit',['products'=>$product,'lngs'=>$lngs,'category_options'=>$categories,
            'brand_options'=>$brands,'product_pictures'=>$product_pictures,'option_products'=>$option_products,'linked_products'=>$linked_products]);
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
        
        $products = Product::select()->where(['u_id' => $id])->get();

        if($request->hasFile('first_image')){
            $image_path = public_path()."/img/site/".$products->first()->first_image;
            
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            
            $file=$request->first_image;
            $name=uniqid().'.'.$file->getClientOriginalExtension();

            $file->move('img/site',$name);
            $input['first_image']=$name;

        }
        
        if($request->hasFile('second_image')){
            $image_path2 = public_path()."/img/site/".$products->first()->second_image;
            
            if(File::exists($image_path2)) {
                File::delete($image_path2);
            }
            $file2=$request->second_image;
            $name2=uniqid().'.'.$file2->getClientOriginalExtension();

            $file2->move('img/site/',$name2);
            $input['second_image']=$name2;

        }
        $input['tag'] = $request->tag;
        $input['price']=$request->price;
        $input['discount_price']=$request->discount_price;

        $attrs = $request->all();
        $ats = array_keys($attrs);
        
        foreach ($products as $product) {
            for ($i = 0; $i < count($ats); $i++) {
                if (count(explode($product->l_id, $ats[$i])) > 1) {
                    $attr = explode($product->l_id, $ats[$i])[0];
                    $input[$attr] = $attrs[$ats[$i]];
                }
            }
            
            if($input['title']){

                $say=Product::select()->where(['title'=>$input['title'],'l_id'=>$product['l_id']])->where('u_id','<>',$product['u_id'])->get();
                $say=$say->count();

                if($say>0){
                   return back()->with('xeta',$input['title'].' adi evvelceden istifade olunub'); 
                }

            }
            
            $product->update($input);
            
        }
        
        if($request->has('linked_products')){
            
            $linked_products = Linked_product::select()->where('main_product',$products[0]->u_id)->get();
            
            foreach($linked_products as $linked){
                $linked->delete();
            }
            
            foreach($request->linked_products as $id)  {      
                $linked = new Linked_product();
                $linked->main_product = $products[0]->u_id;
                $linked->linked_product = $id;
                
                $linked->save();
            }
        }

        
        $product->categories()->detach();
        $product->brands()->detach();
        
        if($request->has('categories')){
            $product->categories()->attach($request->categories);
        }
        if($request->has('brands')){
            $product->brands()->attach($request->brands);
        }
        
        if($request->hasFile('picture')){
            $files = $request->picture;
            foreach ($files as $file){
                $file_name=uniqid().'.'.$file->getClientOriginalExtension();
                $file->move('img/site',$file_name);

                $product_picture= new Product_picture();
                $product_picture->product_id=$id;
                $product_picture->name=$file_name;
                $product_picture->save();
            }
        }
        
        
        return redirect()->route('admin.products');
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
        $products = Product::select()->where('u_id',$id)->get();
        foreach ($products as $product){
            $product->delete();
        }
        
        return redirect()->route('admin.products');
    }

    public function forceDelete($id){
        $status = Product::withTrashed()->where('u_id',$id)->first();


        $image_path = public_path()."/images/".$status->first_image;
        $image_path2 = public_path()."/images/".$status->second_image;

        if(File::exists($image_path)) {
            File::delete($image_path);
        }

        if(File::exists($image_path2)) {
            File::delete($image_path2);
        }
        
        $status->categories()->detach();
        $status = Product::withTrashed()->where('u_id',$id)->forceDelete();


        if ($status) {
            return redirect()->route('admin.products')->withFlashSuccess('Silindi');
        }
        return redirect()->route('admin.products')->withFlashDanger('Səhv baş verdi!');
    }

    public function restore($id){
        Product::withTrashed()->where('u_id',$id)->restore();
        return redirect()->route('admin.products');
    }
    
    public function deleteSinglePhoto($id){
        $picture = Product_picture::select()->where('id',$id)->first();
        
        $image_path = public_path()."/images/".$picture->name;
        
        if(File::exists($image_path)){
            File::delete($image_path);
        }
        
        $picture->delete();
        
        if ($picture) {
            return redirect()->back()->withFlashSuccess('Silindi');
        }
        return redirect()->back()->withFlashDanger('Səhv baş verdi!');
    }
}

