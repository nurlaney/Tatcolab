<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class General extends Model
{
    protected $fillable = ['u_id','l_id','address','address_embed','email','phone','logo','copyright','fb','instagram','youtube','about'];

    public function lng(){
        return $this->belongsTo('App\Models\Lng','l_id','u_id');
    }
}
