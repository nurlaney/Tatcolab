<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    //
    protected $fillable = ['l_id','u_id','sub_id','ordering','title','tag','image','on_main_page'];
    
    public function products(){
        return $this->belongsToMany(Product::class,'product_categories','category_id','product_id',
            'u_id','u_id');
    }
    
    public function lng(){
        return $this->belongsTo('App\Models\Lng','l_id','u_id');
    }
}
