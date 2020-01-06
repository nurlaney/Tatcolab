<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_category extends Model
{
    protected $fillable = ['category_id','brand_id','product_id'];
}
