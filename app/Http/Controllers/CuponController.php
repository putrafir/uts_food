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
        $cid = Auth::guard('client')->id();
        $coupon = Cupon::where('client_id', $cid)->latest()->get();
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


    public function EditCoupon($id)
    {

        $coupon = Cupon::find($id);
        return view('client.backend.coupon.edit_coupon', compact('coupon'));
    }
    // End Method 
    public function UpdateCoupon(Request $request)
    {
        $cop_id = $request->id;
        Cupon::find($cop_id)->update([
            'coupon_name' => strtoupper($request->coupon_name),
            'coupon_desc' => $request->coupon_desc,
            'discount' => $request->discount,
            'validity' => $request->validity,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Coupon Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.coupon')->with($notification);
    }
    // End Method 
    public function DeleteCoupon($id)
    {
        Cupon::find($id)->delete();
        $notification = array(
            'message' => 'Coupon Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
