<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function StoreReview(Request $request)
    {
        $client = $request->client_id;
        $request->validate([
            'comment' => 'required'
        ]);
        Review::insert([
            'client_id' => $client,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'rating' => $request->rating,
            'created_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Review Will Approlve By Admin',
            'alert-type' => 'success'
        );
        $previousUrl = $request->headers->get('referer');
        $redirectUrl = $previousUrl ? $previousUrl . '#pills-reviews' : route('res.details', ['id' => $client]) . '#pills-reviews';
        return redirect()->to($redirectUrl)->with($notification);
    }
    // End Method
    public function AdminPendingReview()
    {
        $pedingReview = Review::where('status', 0)->orderBy('id', 'desc')->get();
        return view('admin.backend.review.view_pending_review', compact('pedingReview'));
    }
    // End Method
    public function AdminApproveReview()
    {
        $approveReview = Review::where('status', 1)->orderBy('id', 'desc')->get();
        return view('admin.backend.review.view_approve_review', compact('approveReview'));
    }
    public function ReviewChangeStatus(Request $request)
    {
        $review = Review::find($request->review_id);
        $review->status = $request->status;
        $review->save();
        return response()->json(['success' => 'Status Change Successfully']);
    }
    public function ClientAllReviews()
    {
        $id = Auth::guard('client')->id();
        $allreviews = Review::where('status', 1)->where('client_id', $id)->orderBy('id', 'desc')->get();
        return view('client.backend.review.view_all_review', compact('allreviews'));
    }
}
