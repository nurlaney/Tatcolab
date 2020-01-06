<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;
    //
    protected $fillable = ['l_id','u_id','sub_id','ordering','title','logo','tag','on_main_page'];

    public function lng(){
        return $this->belongsTo('App\Models\Lng','l_id','u_id');
    }
    public function products(){
        return $this->belongsToMany(Product::class,'product_categories','brand_id','product_id',
            'u_id','u_id');
    }
}
