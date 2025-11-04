<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class BuyerDashboardController extends Controller
{
    public function index()
    {
        // simple “what’s new” list for buyers
        $listings = DB::table('listings as l')
            ->join('vehicles as v', 'v.id', '=', 'l.vehicle_id')
            ->select('l.*', 'v.make', 'v.model', 'v.year', 'v.body_type', 'v.fuel_type', 'v.transmission', 'v.drivetrain')
            ->where('l.is_active', 1)
            ->orderByDesc('l.created_at')
            ->limit(12)
            ->get();

        return view('buyer.dashboard', compact('listings'));
    }
}
