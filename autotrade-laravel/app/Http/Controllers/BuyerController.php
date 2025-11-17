<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BuyerController extends Controller
{
    /**
     * Show the buyer dashboard with live stats (count rendered server-side initially).
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();

        $watchlistCount = DB::table('favorites')
            ->where('user_id', $user->id)
            ->count();

        $stats = [
            'watchlistCount' => $watchlistCount,
            'savedCount'     => $watchlistCount, // alias
            'purchases'      => 0,               // placeholder
            'offers'         => 0,               // placeholder
        ];

        return view('buyer.dashboard', compact('user', 'stats'));
    }

    /**
     * Browse vehicles (VEHICLES table) with rich filters.
     * Uses the Query Builder to avoid model/table binding issues.
     */
    public function browse(Request $request)
    {
        // Inputs
        $search      = trim((string) $request->input('q', ''));
        $make        = $request->input('make');
        $model       = $request->input('model');
        $minYear     = $request->input('min_year');
        $maxYear     = $request->input('max_year');
        $bodyType    = $request->input('body_type');
        $drivetrain  = $request->input('drivetrain');
        $fuelType    = $request->input('fuel_type');
        $trans       = $request->input('transmission');
        $sort        = $request->input('sort', 'newest');

        // Base query on vehicles table
        $q = DB::table('vehicles');

        // Free-text search across make/model/trim
        if ($search !== '') {
            $q->where(function ($x) use ($search) {
                $x->where('make',  'like', "%{$search}%")
                  ->orWhere('model','like', "%{$search}%")
                  ->orWhere('trim', 'like', "%{$search}%");
            });
        }

        // Field filters
        if (!empty($make))       $q->where('make', 'like', "%{$make}%");
        if (!empty($model))      $q->where('model','like', "%{$model}%");
        if (!empty($minYear))    $q->where('year', '>=', (int) $minYear);
        if (!empty($maxYear))    $q->where('year', '<=', (int) $maxYear);
        if (!empty($bodyType))   $q->where('body_type', $bodyType);
        if (!empty($drivetrain)) $q->where('drivetrain', $drivetrain);
        if (!empty($fuelType))   $q->where('fuel_type', $fuelType);
        if (!empty($trans))      $q->where('transmission', $trans);

        // Sorting
        switch ($sort) {
            case 'year_asc':  $q->orderBy('year', 'asc'); break;
            case 'year_desc': $q->orderBy('year', 'desc'); break;
            default:          $q->orderByDesc('id'); // newest
        }

        // Results
        $vehicles = $q->paginate(12)->appends($request->query());

        // Option lists
        $yearOptions = range((int) date('Y'), 1990);

        $makes = DB::table('vehicles')
            ->whereNotNull('make')->where('make', '!=', '')
            ->distinct()->orderBy('make')->pluck('make')->all();

        $models = DB::table('vehicles')
            ->whereNotNull('model')->where('model', '!=', '')
            ->distinct()->orderBy('model')->pluck('model')->all();

        $bodyTypes = DB::table('vehicles')
            ->whereNotNull('body_type')->where('body_type', '!=', '')
            ->distinct()->orderBy('body_type')->pluck('body_type')->all();

        $drivetrains = DB::table('vehicles')
            ->whereNotNull('drivetrain')->where('drivetrain', '!=', '')
            ->distinct()->orderBy('drivetrain')->pluck('drivetrain')->all();

        $fuels = DB::table('vehicles')
            ->whereNotNull('fuel_type')->where('fuel_type', '!=', '')
            ->distinct()->orderBy('fuel_type')->pluck('fuel_type')->all();

        $transList = DB::table('vehicles')
            ->whereNotNull('transmission')->where('transmission', '!=', '')
            ->distinct()->orderBy('transmission')->pluck('transmission')->all();

        return view('buyer.vehicles.index', [
            'vehicles'     => $vehicles,
            'user'         => Auth::user(),
            'yearOptions'  => $yearOptions,
            'makes'        => $makes,
            'models'       => $models,
            'bodyTypes'    => $bodyTypes,
            'drivetrains'  => $drivetrains,
            'fuels'        => $fuels,
            'trans'        => $transList,
            'sort'         => $sort,
        ]);
    }

    /**
     * Toggle favorite (watchlist) for a vehicle via POST.
     */
    public function toggleFavorite($vehicleId)
    {
        $userId = Auth::id();

        $inserted = DB::table('favorites')->insertOrIgnore([
            'user_id'    => $userId,
            'vehicle_id' => (int) $vehicleId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($inserted === 0) {
            DB::table('favorites')
                ->where('user_id', $userId)
                ->where('vehicle_id', (int) $vehicleId)
                ->delete();
            $status = 'removed';
        } else {
            $status = 'added';
        }

        return redirect()
            ->route('buyer.vehicles')
            ->with('message', "Vehicle {$status} to watchlist.");
    }

    /**
     * Remove favorite explicitly via DELETE (used by watchlist page).
     */
    public function unfavorite($vehicleId)
    {
        DB::table('favorites')
            ->where('user_id', Auth::id())
            ->where('vehicle_id', (int) $vehicleId)
            ->delete();

        return back()->with('message', 'Removed from watchlist.');
    }

    /**
     * Show current user's watchlist (favorites joined to vehicles).
     */
    public function watchlist(Request $request)
    {
        $vehicles = DB::table('favorites')
            ->join('vehicles', 'vehicles.id', '=', 'favorites.vehicle_id')
            ->where('favorites.user_id', Auth::id())
            ->select('vehicles.*')
            ->orderByDesc('vehicles.year')
            ->paginate(12);

        return view('buyer.watchlist', compact('vehicles'));
    }

    /**
     * JSON endpoint for live watchlist count.
     */
    public function watchlistCount(Request $request)
    {
        $count = DB::table('favorites')
            ->where('user_id', Auth::id())
            ->count();

        return response()->json(['count' => $count], 200);
    }
}