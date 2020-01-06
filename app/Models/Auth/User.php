<?php

namespace App\Models\Auth;

use App\Models\Auth\Traits\Attribute\UserAttribute;
use App\Models\Auth\Traits\Method\UserMethod;
use App\Models\Auth\Traits\Relationship\UserRelationship;
use App\Models\Auth\Traits\Scope\UserScope;
use App\Models\Product;

/**
 * Class User.
 */
class User extends BaseUser
{
    use UserAttribute,
        UserMethod,
        UserRelationship,
        UserScope;
    
    public function products(){
        return $this->belongsToMany(Product::class,'carts','user_id','product_id',
            'id','u_id');
    }
    public function products_wishlist(){
        return $this->belongsToMany(Product::class,'wishlists','user_id','product_id',
            'id','u_id');
    }
}
