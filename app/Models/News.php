<?php

namespace App\Models;

use App\Models\News_category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    //
    protected $table = 'newses';

    use SoftDeletes;

    protected $fillable = ['u_id','l_id','title','stitle','text','description','user_id','image','tag'];

    public function user(){
        return $this->belongsTo('App\Models\Auth\User','user_id','id');
    }

    public function lng(){
        return $this->belongsTo('App\Models\Lng','l_id','u_id');
    }

    public function categories(){
        return $this->belongsToMany(News_category::class,'category_newses','news_id','category_id'
        , 'u_id','u_id');
    }
   
}
