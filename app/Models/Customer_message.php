<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer_Message extends Model
{
    use SoftDeletes;
    protected $table = 'customer_messages';

    protected $fillable = ['name','email','phone','message','read'];
}
