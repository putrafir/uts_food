<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function AminAllReports(Request $request)
    {
        $date = new DateTime($request->date);
        $formatDate = $date->format('d F Y');

        $orderDate = Order::where('order_date', $formatDate)->latest()->get();
        return view('admin.backend.report.all_report', compact('orderDate', 'formatDate'));
    }
    public function AminSearchByDate(Request $request)
    {
        $date = new DateTime($request->date);
        $formatDate = $date->format('d F Y');

        $orderDate = Order::where('order_date', $formatDate)->latest()->get();
        return view('admin.backend.report.search_by_date', compact('orderDate', 'formatDate'));
    }
    public function AminSearchByMonth(Request $request)
    {
        $month = $request->month;
        $years = $request->year_name;
        $orderMonth = Order::where('order_month', $month)->where('order_year', $years)->latest()->get();
        return view('admin.backend.report.search_by_month', compact('orderMonth', 'month', 'years'));
    }
    // End Method
    public function AminSearchByYear(Request $request)
    {
        $years = $request->year;
        $orderYear = Order::where('order_year', $years)->latest()->get();
        return view('admin.backend.report.search_by_year', compact('orderYear', 'years'));
    }


    //client report

    public function ClientAllReports()
    {
        return view('client.backend.report.all_report');
    }
    public function ClientSearchByDate(Request $request)
    {
        $date = new DateTime($request->date);
        $formatDate = $date->format('d F Y');
        $cid = Auth::guard('client')->id();
        $orders = Order::where('order_date', $formatDate)
            ->whereHas('OrderItems', function ($query) use ($cid) {
                $query->where('client_id', $cid);
            })
            ->latest()
            ->get();
        $orderItemGroupData = OrderItem::with(['order', 'product'])
            ->whereIn('order_id', $orders->pluck('id'))
            ->where('client_id', $cid)
            ->orderBy('order_id', 'desc')
            ->get()
            ->groupBy('order_id');
        return view('client.backend.report.search_by_date', compact('orderItemGroupData', 'formatDate'));
    }


    public function ClientSearchByMonth(Request $request)
    {
        $month = $request->month;
        $years = $request->year_name;
        $cid = Auth::guard('client')->id();
        $orders = Order::where('order_month', $month)->where('order_year', $years)
            ->whereHas('OrderItems', function ($query) use ($cid) {
                $query->where('client_id', $cid);
            })
            ->latest()
            ->get();
        $orderItemGroupData = OrderItem::with(['order', 'product'])
            ->whereIn('order_id', $orders->pluck('id'))
            ->where('client_id', $cid)
            ->orderBy('order_id', 'desc')
            ->get()
            ->groupBy('order_id');
        return view('client.backend.report.search_by_month', compact('orderItemGroupData', 'month', 'years'));
    }
    // End Method
    public function ClientSearchByYear(Request $request)
    {

        $years = $request->year;
        $cid = Auth::guard('client')->id();
        $orders = Order::where('order_year', $years)
            ->whereHas('OrderItems', function ($query) use ($cid) {
                $query->where('client_id', $cid);
            })
            ->latest()
            ->get();
        $orderItemGroupData = OrderItem::with(['order', 'product'])
            ->whereIn('order_id', $orders->pluck('id'))
            ->where('client_id', $cid)
            ->orderBy('order_id', 'desc')
            ->get()
            ->groupBy('order_id');
        return view('client.backend.report.search_by_year', compact('orderItemGroupData', 'years'));
    }
}
