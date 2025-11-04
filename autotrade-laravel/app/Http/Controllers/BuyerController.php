<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerController extends Controller
{
    /**
     * Show the buyer dashboard.
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();

        // You can pass real data later; this is fine for now
        $stats = [
            'watchlistCount' => 0,
            'savedCount'     => 0,
            'purchases'      => 0,
            'offers'         => 0,
        ];

        return view('buyer.dashboard', compact('user', 'stats'));
    }
}
