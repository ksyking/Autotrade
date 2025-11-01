<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        // --- Dropdown sources (distinct values from DB) ---
        $makes        = DB::table('vehicles')->select('make')->distinct()->orderBy('make')->pluck('make');
        $models       = DB::table('vehicles')->select('model')->distinct()->orderBy('model')->pluck('model');

        $bodyTypes    = DB::table('vehicles')->select('body_type')->whereNotNull('body_type')->distinct()->orderBy('body_type')->pluck('body_type');
        $drivetrains  = DB::table('vehicles')->select('drivetrain')->whereNotNull('drivetrain')->distinct()->orderBy('drivetrain')->pluck('drivetrain');
        $fuels        = DB::table('vehicles')->select('fuel_type')->whereNotNull('fuel_type')->distinct()->orderBy('fuel_type')->pluck('fuel_type');
        $transmissions= DB::table('vehicles')->select('transmission')->whereNotNull('transmission')->distinct()->orderBy('transmission')->pluck('transmission');

        $extColors    = DB::table('listings')->select('color_ext')->whereNotNull('color_ext')->distinct()->orderBy('color_ext')->pluck('color_ext');
        $intColors    = DB::table('listings')->select('color_int')->whereNotNull('color_int')->distinct()->orderBy('color_int')->pluck('color_int');

        $states       = DB::table('listings')->select('state')->whereNotNull('state')->distinct()->orderBy('state')->pluck('state');
        $cities       = DB::table('listings')->select('city')->whereNotNull('city')->distinct()->orderBy('city')->pluck('city');

        $minYearDB    = (int) (DB::table('vehicles')->min('year') ?? 1980);
        $maxYearDB    = (int) (DB::table('vehicles')->max('year') ?? date('Y'));
        $yearOptions  = range($maxYearDB, $minYearDB); // descending for UX

        // --- Inputs ---
        $q            = trim((string) $request->input('q', ''));
        $make         = trim((string) $request->input('make', ''));
        $model        = trim((string) $request->input('model', ''));
        $minYear      = $request->input('min_year');
        $maxYear      = $request->input('max_year');
        $minPrice     = $request->input('min_price');
        $maxPrice     = $request->input('max_price');
        $maxMiles     = $request->input('max_miles');
        $bodyType     = trim((string) $request->input('body_type', ''));
        $drivetrain   = trim((string) $request->input('drivetrain', ''));
        $fuelType     = trim((string) $request->input('fuel_type', ''));
        $transmission = trim((string) $request->input('transmission', ''));
        $colorExt     = trim((string) $request->input('color_ext', ''));
        $colorInt     = trim((string) $request->input('color_int', ''));
        $state        = strtoupper(trim((string) $request->input('state', '')));
        $city         = trim((string) $request->input('city', ''));
        $condGrade    = $request->input('condition_grade');
        $sort         = $request->input('sort', 'newest');

        // --- Base query ---
        $query = DB::table('listings')
            ->join('vehicles', 'listings.vehicle_id', '=', 'vehicles.id')
            ->join('users', 'listings.seller_id', '=', 'users.id')
            ->select(
                'listings.id','listings.title','listings.price','listings.mileage',
                'listings.city','listings.state','listings.color_ext','listings.color_int',
                'listings.condition_grade','listings.created_at',
                'vehicles.make','vehicles.model','vehicles.year','vehicles.body_type',
                'vehicles.drivetrain','vehicles.fuel_type','vehicles.transmission'
            )
            ->where('listings.is_active', 1);

        // Free-text search
        if ($q !== '') {
            $query->where(function ($w) use ($q) {
                $like = "%{$q}%";
                $w->where('listings.title','like',$like)
                  ->orWhere('vehicles.make','like',$like)
                  ->orWhere('vehicles.model','like',$like)
                  ->orWhere('users.display_name','like',$like);
            });
        }

        // Filters
        if ($make   !== '') $query->where('vehicles.make',  $make);
        if ($model  !== '') $query->where('vehicles.model', $model);
        if (is_numeric($minYear))   $query->where('vehicles.year', '>=', (int)$minYear);
        if (is_numeric($maxYear))   $query->where('vehicles.year', '<=', (int)$maxYear);
        if (is_numeric($minPrice))  $query->where('listings.price', '>=', (float)$minPrice);
        if (is_numeric($maxPrice))  $query->where('listings.price', '<=', (float)$maxPrice);
        if (is_numeric($maxMiles))  $query->where('listings.mileage','<=', (int)$maxMiles);
        if ($bodyType   !== '')     $query->where('vehicles.body_type',  $bodyType);
        if ($drivetrain !== '')     $query->where('vehicles.drivetrain', $drivetrain);
        if ($fuelType   !== '')     $query->where('vehicles.fuel_type',  $fuelType);
        if ($transmission !== '')   $query->where('vehicles.transmission', $transmission);
        if ($colorExt   !== '')     $query->where('listings.color_ext',  $colorExt);
        if ($colorInt   !== '')     $query->where('listings.color_int',  $colorInt);
        if ($state      !== '')     $query->where('listings.state',      $state);
        if ($city       !== '')     $query->where('listings.city','like',$city);
        if (is_numeric($condGrade)) $query->where('listings.condition_grade','>=',(int)$condGrade);

        // Sorting
        switch ($sort) {
            case 'price_asc':     $query->orderBy('listings.price', 'asc'); break;
            case 'price_desc':    $query->orderBy('listings.price', 'desc'); break;
            case 'mileage_asc':   $query->orderBy('listings.mileage', 'asc'); break;
            case 'mileage_desc':  $query->orderBy('listings.mileage', 'desc'); break;
            case 'year_asc':      $query->orderBy('vehicles.year', 'asc'); break;
            case 'year_desc':     $query->orderBy('vehicles.year', 'desc'); break;
            case 'newest':
            default:              $query->orderBy('listings.created_at', 'desc'); break;
        }

        $listings = $query->limit(50)->get();

        return view('home', compact(
            'listings','makes','models','bodyTypes','drivetrains','fuels','transmissions',
            'extColors','intColors','states','cities','yearOptions'
        ));
    }

    public function json(Request $request)
    {
        // (Unchanged from earlier except for $sort support, already added previously)
        $q            = trim((string) $request->input('q', ''));
        $make         = trim((string) $request->input('make', ''));
        $model        = trim((string) $request->input('model', ''));
        $minYear      = $request->input('min_year');
        $maxYear      = $request->input('max_year');
        $minPrice     = $request->input('min_price');
        $maxPrice     = $request->input('max_price');
        $maxMiles     = $request->input('max_miles');
        $bodyType     = trim((string) $request->input('body_type', ''));
        $drivetrain   = trim((string) $request->input('drivetrain', ''));
        $fuelType     = trim((string) $request->input('fuel_type', ''));
        $transmission = trim((string) $request->input('transmission', ''));
        $colorExt     = trim((string) $request->input('color_ext', ''));
        $colorInt     = trim((string) $request->input('color_int', ''));
        $state        = strtoupper(trim((string) $request->input('state', '')));
        $city         = trim((string) $request->input('city', ''));
        $condGrade    = $request->input('condition_grade');
        $sort         = $request->input('sort', 'newest');

        $query = DB::table('listings')
            ->join('vehicles', 'listings.vehicle_id', '=', 'vehicles.id')
            ->join('users', 'listings.seller_id', '=', 'users.id')
            ->select(
                'listings.id','listings.title','listings.price','listings.mileage',
                'listings.city','listings.state','listings.color_ext','listings.color_int',
                'listings.condition_grade','listings.created_at',
                'vehicles.make','vehicles.model','vehicles.year','vehicles.body_type',
                'vehicles.drivetrain','vehicles.fuel_type','vehicles.transmission'
            )
            ->where('listings.is_active', 1);

        if ($q !== '') {
            $query->where(function ($w) use ($q) {
                $like = "%{$q}%";
                $w->where('listings.title','like',$like)
                  ->orWhere('vehicles.make','like',$like)
                  ->orWhere('vehicles.model','like',$like)
                  ->orWhere('users.display_name','like',$like);
            });
        }

        if ($make   !== '') $query->where('vehicles.make',  $make);
        if ($model  !== '') $query->where('vehicles.model', $model);
        if (is_numeric($minYear))   $query->where('vehicles.year', '>=', (int)$minYear);
        if (is_numeric($maxYear))   $query->where('vehicles.year', '<=', (int)$maxYear);
        if (is_numeric($minPrice))  $query->where('listings.price', '>=', (float)$minPrice);
        if (is_numeric($maxPrice))  $query->where('listings.price', '<=', (float)$maxPrice);
        if (is_numeric($maxMiles))  $query->where('listings.mileage','<=', (int)$maxMiles);
        if ($bodyType   !== '')     $query->where('vehicles.body_type',  $bodyType);
        if ($drivetrain !== '')     $query->where('vehicles.drivetrain', $drivetrain);
        if ($fuelType   !== '')     $query->where('vehicles.fuel_type',  $fuelType);
        if ($transmission !== '')   $query->where('vehicles.transmission', $transmission);
        if ($colorExt   !== '')     $query->where('listings.color_ext',  $colorExt);
        if ($colorInt   !== '')     $query->where('listings.color_int',  $colorInt);
        if ($state      !== '')     $query->where('listings.state',      $state);
        if ($city       !== '')     $query->where('listings.city','like',$city);
        if (is_numeric($condGrade)) $query->where('listings.condition_grade','>=',(int)$condGrade);

        switch ($sort) {
            case 'price_asc':     $query->orderBy('listings.price', 'asc'); break;
            case 'price_desc':    $query->orderBy('listings.price', 'desc'); break;
            case 'mileage_asc':   $query->orderBy('listings.mileage', 'asc'); break;
            case 'mileage_desc':  $query->orderBy('listings.mileage', 'desc'); break;
            case 'year_asc':      $query->orderBy('vehicles.year', 'asc'); break;
            case 'year_desc':     $query->orderBy('vehicles.year', 'desc'); break;
            case 'newest':
            default:              $query->orderBy('listings.created_at', 'desc'); break;
        }

        return response()->json($query->limit(50)->get());
    }
}
