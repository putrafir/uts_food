<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCuponRequest;
use App\Http\Requests\UpdateCuponRequest;
use App\Models\Cupon;

class CuponController extends Controller
{
    public function AllCoupon()
    {
        $coupon = Cupon::latest()->get();
        return view('client.backend.coupon.all_coupon', compact('coupon'));
    }
}
