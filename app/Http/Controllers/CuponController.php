<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCuponRequest;
use App\Http\Requests\UpdateCuponRequest;
use App\Models\Cupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CuponController extends Controller
{
    public function AllCoupon()
    {
        $coupon = Cupon::latest()->get();
        return view('client.backend.coupon.all_coupon', compact('coupon'));
    }

    public function AddCoupon()
    {

        return view('client.backend.coupon.add_coupon');
    }
    // End Method 
    public function StoreCoupon(Request $request)
    {

        Cupon::create([
            'coupon_name' => strtoupper($request->coupon_name),
            'coupon_desc' => $request->coupon_desc,
            'discount' => $request->discount,
            'validity' => $request->validity,
            'client_id' => Auth::guard('client')->id(),
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Coupon Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.coupon')->with($notification);
    }
}
