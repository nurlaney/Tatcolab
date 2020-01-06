<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lng extends Model
{
   public function sliders(){
        return $this->hasMany('App\Models\Slider','l_id','u_id');
    }
    public function menus(){
        return $this->hasMany('App\Models\Menu','u_id','l_id');
    }
    public function generals(){
        return $this->hasMany('App\Models\General','u_id','l_id');
    }
    public function categories(){
        return $this->hasMany('App\Models\Category','u_id','l_id');
    }
    public function brands(){
        return $this->hasMany('App\Models\Brand','u_id','l_id');
    }
    public function newses(){
        return $this->hasMany('App\Models\News','u_id','l_id');
    }
    public function news_categories(){
        return $this->hasMany('App\Models\News_category','u_id','l_id');
    }
    public function products(){
        return $this->hasMany('App\Models\Product','u_id','l_id');
    }
    public function banners(){
        return $this->hasMany('App\Models\Banner','u_id','l_id');
    }
}

