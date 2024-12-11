<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Gllery;
use App\Models\Menu;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function RestaurantDetails($id)
    {
        $client = Client::find($id);
        $menus = Menu::where('client_id', $client->id)->get()->filter(function ($menu) {
            return $menu->products->isNotEmpty();
        });
        $gallerys = Gllery::where('client_id', $id)->get();

        return view('frontend.details_page', compact('client', 'menus', 'gallerys'));
    }


    public function Test($id)
    {
        $client = Client::find($id);


        $menus = Menu::where('client_id', $client->id)->get()->filter(function ($menu) {
            return $menu->products->isNotEmpty();
        });
        $gallerys = Gllery::where('client_id', $id)->get();

        return view('frontend.details_page', compact('client', 'menus', 'gallerys'));
    }
    //End Method
}
