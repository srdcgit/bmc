<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Establishment;
use App\Models\Event;
use App\Models\Menu;
use App\Models\Shop;
use App\Models\Slider;
use App\Models\Testimonial;
use App\Models\VendorsType;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){

        return view('web.index');
    }
    public function about(){
        return view('web.about');
    }
    public function contact(){
        return view('web.contact');
    }
    public function events(){
        $events = Event::all();
        return view('web.events', compact('events'));
    }
    public function shops($name)
    {
        $establishment = Establishment::where('name',str_replace('_', ' ',$name))->first();
        $shops = Shop::where('establishment_id',$establishment->id)->get();
        return view('web.shop-listing',compact('establishment','shops'));
    }
}
