<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['u_id','l_id','first_title','second_title','button_path','button_text','picture','ordering'];
    
    public function lng(){
        return $this->belongsTo('App\Models\Lng','l_id','id');
    }
}
