<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SellerDashboardController extends Controller
{
    public function index()
    {
        $uid = Auth::id();

        $myListings = DB::table('listings as l')
            ->join('vehicles as v', 'v.id', '=', 'l.vehicle_id')
            ->select('l.*', 'v.make', 'v.model', 'v.year', 'v.body_type')
            ->where('l.seller_id', $uid)
            ->orderByDesc('l.created_at')
            ->get();

        return view('seller.dashboard', compact('myListings'));
    }
}
