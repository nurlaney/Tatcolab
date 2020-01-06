<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category_news extends Model
{
    protected $table = 'category_newses';

    protected $fillable = ['category_id','news_id'];
}
