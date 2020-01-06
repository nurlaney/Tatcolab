<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

/**
 * Class HomeController.
 */
class HomeController extends SiteController
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $menu= $this->getNav();
        $slider = $this->getSlide();
    
        return view('frontend.index',["menu"=>$menu,'slider'=>$slider]);
        
        
    }
}
