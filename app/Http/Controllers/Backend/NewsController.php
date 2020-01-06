<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Lng;
use App\Models\Menu;
use App\Models\News;
use App\Models\News_category;
use File;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function abort;
use function back;
use function collect;
use function public_path;
use function redirect;
use function view;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        $newses = News::withTrashed()->where('l_id',1)->orderBy('u_id')->paginate();
        $newses->load('lng');
        $newses->load('user');
        
        return view('backend.news.index',['newses'=>$newses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        //sadce 3 dil ucun isleyecek
        if(!empty($request->name1)){
            $this->validate($request,[
                'name1'=>'unique:newses,name',
            ]);
        }
        if(!empty($request->name2)){
            $this->validate($request,[
                'name2'=>'unique:newses,name',
            ]);
        }
        if(!empty($request->name3)){
            $this->validate($request,[
                'name3'=>'unique:newses,name',
            ]);
        }
        //
        $lngs = Lng::all();
        $news_categories = News_category::select()->where('l_id', Lng::select()->where('default',1)->first()->u_id)->get();
         
        //dd($categories);
        return view('backend.news.create',['lngs'=>$lngs,'options'=>$news_categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
     /*   $subscribers = Subscriber::select()->where('short_name',app()->getLocale())->get();
        
        foreach($subscribers as $subscriber){
            
            Mail::to($subscriber->email)->send(new Subscription('az'));
        
        }
      */  
        $lngs = Lng::all();
        $lastUid = News::withTrashed()->orderBy('u_id','desc')->first();
        if ($lastUid == null) {
            $uid = 1;
        } else {
            $uid = $lastUid->u_id + 1;
        }
        
        $file = $request->image;
        $name=uniqid().'.'.$file->getClientOriginalExtension();

        $input['tag'] = $request->tag;
        $input['u_id'] = $uid;
        $input['image'] =$name;
        $input['user_id'] = $request->user_id;
        $input['categories'] = $request->categories;
        

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
                $say=News::select()->where(['title'=>$input['title'],'l_id'=>$input['l_id']])->get();
                $say=$say->count();
                if($say>0){
                    $sec=News::select()->where(['u_id'=>$input['u_id']])->get();

                    foreach($sec as $c){
                       $c->forceDelete();
                    }
                   return back()->with('xeta',$input['title'].' adı evvelceden istifade olunub'); 
                }

            }
        
            
            $news = new News($input);
            $news->save();
        }
        
        $file->move('img/site',$name);
        $news->categories()->attach($input['categories']);
        
        
        
        return redirect()->route('admin.news');
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
        if (!$lang) abort(404);

        $menu = Menu::select()->where(['l_id' => $lang->u_id, 'url_tag' => 'news'])->first();
        $this->vars['seo'] = $menu;

//        $randNewses = News::select()->where('l_id',$lang->u_id)->orderByRaw('RAND()')->take(6)->get();
//        $this->vars['randNewses'] = $randNewses;

        $advert = News::select()->where(['name'=>$url_tag, 'l_id'=>$lang->u_id])->first();
        $this->vars['advert'] = $advert;

        $categories_all=$advert->categories()->where('l_id',$lang->u_id)->get();
        $this->vars['categories_all'] = $categories_all;

        $last = News::select()->where(['l_id'=>$lang->u_id])->orderBy('created_at','desc')->take(5)->get();
        $this->vars['last'] = $last;


        $randNewses = News::select()->where('l_id',$lang->u_id)->orderByRaw('RAND()')->take(5)->get();
        $this->vars['randNewses'] = $randNewses;


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
        $lngs->load('newses');
        $categories = News_category::select()->where('l_id', Lng::select()->where('default',1)->first()->u_id)->get();
        $l_id = Lng::select('u_id')->whereNotIn('u_id', function ($q) use (&$id){
            $q->select('l_id')->from('newses')->where('u_id',$id);
        })->get();
        foreach ($l_id as $lid){
            $newNews = News::select()->where('u_id',$id)->first();
            $newNewsArray = collect($newNews->toArray())->only(['u_id', 'image','user_id'])->toArray();
            $newNewsArray['l_id']=$lid->u_id;
            $news = new News($newNewsArray);
            $news->save();
        }
        $news = News::select()->where('u_id',$id)->get();
        $news->load('lng');
        return view('backend.news.edit',['newses'=>$news,'lngs'=>$lngs,'options'=>$categories]);
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
        $newses = News::select()->where('u_id', $id)->get();
        
        if($request->hasFile('image')){
            
            $image_path = public_path()."/img/site/".$newses->first()->image;

            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            
            $file=$request->image;
            $name=uniqid().'.'.$file->getClientOriginalExtension();
            
            $file->move('img/site/',$name);
            $input['image']=$name;
            
        }
        $input['tag'] = $request->tag;

        $attrs = $request->except('image');
        $ats = array_keys($attrs);
        foreach ($newses as $news) {
            for ($i = 0; $i < count($ats); $i++) {
                if (count(explode($news->l_id, $ats[$i])) > 1) {
                    $attr = explode($news->l_id, $ats[$i])[0];
                    $input[$attr] = $attrs[$ats[$i]];
                }
            }
            if($request->hasFile('image')){
                $news->image = $input['image'];
            }
            if($input['title']){
                $say=News::select()->where('title',$input['title'])->where('l_id',$news['l_id'])->where('u_id','<>',$news['u_id'])->get();
                
               $say=$say->count();
               
               if($say>0){
                  return back()->with('xeta',$input['name'].' adi evvelceden istifade olunub'); 
               }
            }
            
            
            $news->update($input);
            
        }
        
        $news->categories()->detach();
        if($request->has('categories')){
            $news->categories()->attach($request->categories);
        }
        return redirect()->route('admin.news');
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
        $newses = News::select()->where('u_id',$id)->get();
        foreach ($newses as $news){
            $image_path = public_path()."/img/site/".$news->image;

            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            $news->delete();
        }
        return redirect()->route('admin.news');
    }

    public function forceDelete($id){
        $status = News::withTrashed()->where('u_id',$id)->first();


        $image_path = public_path()."/img/site/".$status->image;

        if(File::exists($image_path)) {
            File::delete($image_path);
        }

        $status->categories()->detach();
        $status = News::withTrashed()->where('u_id',$id)->forceDelete();


        if($status)
            return redirect()->route('admin.news')->withFlashSuccess('Silindi');
        return redirect()->route('admin.news')->withDangerSuccess('Sehv bas verdi');
    }

    public function restore($id){
        News::withTrashed()->where('u_id',$id)->restore();
        return redirect()->route('admin.news');
    }
}

