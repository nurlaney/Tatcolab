<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;
    //
    protected $fillable = ['text','bg_image','l_id','u_id','sub_id','ordering','title','description','keyword','name','text','url_tag','picture','type'];

    public function lng(){
        return $this->belongsTo('App\Models\Lng','l_id','u_id');
    }
}
