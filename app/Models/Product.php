<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
        use SoftDeletes;

    protected $fillable = ['u_id','l_id','title','ordering','brief_info','description','price','discount_price','first_image','second_image','tag','on_arrivals','on_sale','on_featured'];

    public function lng(){
        return $this->belongsTo('App\Models\Lng','l_id','u_id');
    }

    public function brands(){
        return $this->belongsToMany(Brand::class,'product_categories','product_id','brand_id'
        , 'u_id','u_id');
    }
    public function categories(){
        return $this->belongsToMany(Category::class,'product_categories','product_id','category_id'
        , 'u_id','u_id');
    }
    public function users(){
        return $this->belongsToMany(User::class,'carts','product_id','user_id'
        , 'u_id','id');
    }
    public function users_wishlist(){
        return $this->belongsToMany(User::class,'wishlists','product_id','user_id'
        , 'u_id','id');
    }
}
