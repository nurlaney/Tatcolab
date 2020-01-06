<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Footer;
use App\Models\Menu;
use App\Models\General;
use App\Models\Slider;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function getNav(){
        $menus= Menu::select()->where("l_id",1)->get();
        $generals = General::select()->where("l_id",1)->first();
        return view("frontend.includes.nav", ["menus"=>$menus, "generals"=>$generals]);
    }
        public function getSlide(){
        $sliders=Slider::select()->where("l_id",1)->get();
        return view("frontend.includes.slider",["sliders"=>$sliders]);
        }
    
}
