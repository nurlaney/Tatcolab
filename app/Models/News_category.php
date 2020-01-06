<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News_category extends Model
{
    use SoftDeletes;
    protected $fillable = ['title','u_id','l_id','sub_id','ordering','tag'];

    public function newses(){
        return $this->belongsToMany(News::class,'category_newses','category_id','news_id',
            'u_id','u_id');
    }

    public function lng(){
        return $this->belongsTo('App\Models\Lng','l_id','id');
    }
}
