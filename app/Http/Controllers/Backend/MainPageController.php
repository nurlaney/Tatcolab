<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\General;
use App\Models\Lng;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function collect;
use function redirect;
use function view;
use File;

class MainPageController extends Controller
{
    public function getNewArrivals(){
        
        $products_on_sale = Product::select()->where('l_id',1)->where('on_sale',1)->get();
        $products_on_arrivals = Product::select()->where('l_id',1)->where('on_arrivals',1)->get();
        $products = Product::select()->where('l_id',1)->get();
        
        $products_sale = Product::select()->where('l_id',1)->where('discount_price','>','0')->get();
        
        $categories_on_main = Category::select()->where('l_id',1)->where('on_main_page',1)->get();
        $categories = Category::select()->where('l_id',1)->get();
        
        $brands_on_main = Brand::select()->where('l_id',1)->where('on_main_page',1)->get();
        $brands = Brand::select()->where('l_id',1)->get();
        
        
        return view('backend.main_page.items',['products'=>$products,'products_on_sale'=>$products_on_sale,'products_on_arrivals'=>$products_on_arrivals,
                                                'categories_on_main'=>$categories_on_main,'categories'=>$categories,'products_sale'=>$products_sale,'brands_on_main'=>$brands_on_main,
                                                'brands'=>$brands]);
    }
    
    public function getFeatured(){
        
        $products_on_featured = Product::select()->where('l_id',1)->where('on_featured',1)->get();
        $products = Product::select()->where('l_id',1)->get();
        
        
        return view('backend.main_page.featured',['products'=>$products,'products_on_featured'=>$products_on_featured]);
    }
    
    public function storeItems(Request $request){
        if($request->has('products_on_sale')){
            foreach($request->products_on_sale as $u_id){
                $products = Product::select()->where('u_id',$u_id)->get();
                foreach($products as $product){
                    $product->on_sale = 1;
                    $product->save();
                }
            }
        }
        if($request->has('products_on_arrivals')){
            foreach($request->products_on_arrivals as $u_id){
                $products = Product::select()->where('u_id',$u_id)->get();
                foreach($products as $product){
                    $product->on_arrivals = 1;
                    $product->save();
                }
            }
        }
        if($request->has('categories')){
            foreach($request->categories as $u_id){
                $categories = Category::select()->where('u_id',$u_id)->get();
                foreach($categories as $category){
                    $category->on_main_page = 1;
                    $category->save();
                }
            }
        }
        if($request->has('brands')){
            foreach($request->brands as $u_id){
                $brands = Brand::select()->where('u_id',$u_id)->get();
                foreach($brands as $brand){
                    $brand->on_main_page = 1;
                    $brand->save();
                }
            }
        }
        
        return redirect()->back()->withFlashSuccess('Items added successfully');
    }
    
    public function storeFeatured(Request $request){
        
        if($request->has('featured')){
            foreach($request->featured as $u_id){
                $products = Product::select()->where('u_id',$u_id)->get();
                foreach($products as $product){
                    $product->on_featured = 1;
                    $product->save();
                }
            }
        }
        
        return redirect()->back()->withFlashSuccess('Items added successfully');
    }
    
    public function removeArrivals($u_id){
        $products = Product::select()->where('u_id',$u_id)->get();
        foreach($products as $product){
            $product->on_arrivals = 0;
            $product->save();
        }
        return redirect()->back()->withFlashSuccess('Item removed from main page');
    }
    
    public function removeSale($u_id){
        $products = Product::select()->where('u_id',$u_id)->get();
        foreach($products as $product){
            $product->on_sale = 0;
            $product->save();
        }
        return redirect()->back()->withFlashSuccess('Item removed from main page');
    }
    
    public function removeFeatured($u_id){
        $products = Product::select()->where('u_id',$u_id)->get();
        foreach($products as $product){
            $product->on_featured = 0;
            $product->save();
        }
        return redirect()->back()->withFlashSuccess('Item removed from main page');
    }
    
    public function removeCategory($u_id){
        $categories = Category::select()->where('u_id',$u_id)->get();
        foreach($categories as $category){
            $category->on_main_page = 0;
            $category->save();
        }
        return redirect()->back()->withFlashSuccess('Item removed from main page');
    }
    public function removeBrand($u_id){
        $brands = Brand::select()->where('u_id',$u_id)->get();
        foreach($brands as $brand){
            $brand->on_main_page = 0;
            $brand->save();
        }
        return redirect()->back()->withFlashSuccess('Item removed from main page');
    }
    
    public function getFluidBanner(){
        $banners = Banner::select()->where('l_id',1)->get();
        
        return view('backend.main_page.fluid_banner',['banners'=>$banners]);
    }
    
    public function editFluidBanner($id){
        $lngs = Lng::all();
        $lngs->load('banners');
        $l_id = Lng::select('u_id')->whereNotIn('u_id', function ($q) use (&$id){
            $q->select('l_id')->from('banners')->where('u_id',$id);
        })->get();
        foreach ($l_id as $lid){
            $newBanner = Banner::select()->where('u_id',$id)->first();
            $newBannerArray = collect($newBanner->toArray())->only(['u_id', 'image','button_path'])->toArray();
            $newBannerArray['l_id']=$lid->u_id;
            $banner = new Banner($newBannerArray);
            $banner->save();
        }
        
        $banner = Banner::select()->where('u_id',$id)->get();
        $banner->load('lng');
        
        return view('backend.main_page.fluid_edit',['banners'=>$banner,'lngs'=>$lngs,]);

    }
    
    public function updateFluidBanner(Request $request,$id){
        $banners = Banner::select()->where(['u_id' => $id])->get();

        if($request->hasFile('image')){
            $image_path = public_path()."/img/site/".$banners->first()->image;
            
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            
            $file=$request->image;
            $name=uniqid().'.'.$file->getClientOriginalExtension();

            $file->move('img/site',$name);
            $input['image']=$name;

        }
        
        $input['button_path'] = $request->button_path;
        
        $attrs = $request->all();
        $ats = array_keys($attrs);
        
        foreach ($banners as $banner) {
            for ($i = 0; $i < count($ats); $i++) {
                if (count(explode($banner->l_id, $ats[$i])) > 1) {
                    $attr = explode($banner->l_id, $ats[$i])[0];
                    $input[$attr] = $attrs[$ats[$i]];
                }
            }
            
            $banner->update($input);
            
        }

        
        return redirect()->route('admin.main_page.fluid_banner')->withFlashSuccess('Banner updated successfully');
    }
    
}
