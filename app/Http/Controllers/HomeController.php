<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Gllery;
use App\Models\Menu;
use App\Models\Review;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function RestaurantDetails($id)
    {
        $client = Client::find($id);
        $menus = Menu::where('client_id', $client->id)->get()->filter(function ($menu) {
            return $menu->products->isNotEmpty();
        });
        $gallerys = Gllery::where('client_id', $id)->get();
        $reviews = Review::where('client_id', $client->id)->where('status', 1)->get();
        $totalReviews = $reviews->count();
        $ratingSum = $reviews->sum('rating');
        $averageRating = $totalReviews > 0 ? $ratingSum / $totalReviews : 0;
        $roundedAverageRating = round($averageRating, 1);

        $ratingCounts = [
            '5' => $reviews->where('rating', 5)->count(),
            '4' => $reviews->where('rating', 4)->count(),
            '3' => $reviews->where('rating', 3)->count(),
            '2' => $reviews->where('rating', 2)->count(),
            '1' => $reviews->where('rating', 1)->count(),
        ];
        $ratingPercentages = array_map(function ($count) use ($totalReviews) {
            return $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
        }, $ratingCounts);
        return view('frontend.details_page', compact('client', 'menus', 'gallerys', 'reviews', 'roundedAverageRating', 'totalReviews', 'ratingCounts', 'ratingPercentages'));
    }

    public function AddWishList(Request $request, $id)
    {
        if (Auth::check()) {
            $exists = Wishlist::where('user_id', Auth::id())->where('client_id', $id)->first();
            if (!$exists) {
                Wishlist::insert([
                    'user_id' => Auth::id(),
                    'client_id' => $id,
                    'created_at' => Carbon::now(),
                ]);
                return response()->json(['success' => 'Your Wishlist Addedd Successfully']);
            } else {
                return response()->json(['error' => 'This product has already on your wishlist']);
            }
        } else {
            return response()->json(['error' => 'First Login Your Account']);
        }
    }
}
