<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['u_id','l_id','first_text','second_text','button_path','button_text','image'];

    public function lng(){
        return $this->belongsTo('App\Models\Lng','l_id','u_id');
    }
}