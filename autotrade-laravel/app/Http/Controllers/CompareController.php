<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompareController extends Controller
{
    // Show compare page — supports permalink via ?ids=12,34
    public function index(Request $request)
    {
        // If URL contains ids=..., prefer those; else use session
        $idsParam = trim((string) $request->query('ids', ''));
        if ($idsParam !== '') {
            $ids = collect(explode(',', $idsParam))
                ->map(fn($v) => (int) $v)
                ->filter()
                ->values()
                ->all();

            // Also sync session so homepage badge matches
            $request->session()->put('compare_ids', $ids);
        } else {
            $ids = collect($request->session()->get('compare_ids', []))
                ->map(fn($v) => (int) $v)
                ->filter()
                ->values()
                ->all();
        }

        $listings = collect();

        if (!empty($ids)) {
            $listings = DB::table('listings')
                ->join('vehicles', 'listings.vehicle_id', '=', 'vehicles.id')
                ->select(
                    'listings.id','listings.title','listings.price','listings.mileage',
                    'listings.city','listings.state','listings.color_ext','listings.color_int',
                    'listings.condition_grade',
                    'vehicles.make','vehicles.model','vehicles.year','vehicles.body_type',
                    'vehicles.drivetrain','vehicles.fuel_type','vehicles.transmission'
                )
                ->whereIn('listings.id', $ids)
                ->get()
                ->sortBy(fn($row) => array_search($row->id, $ids))
                ->values();
        }

        return view('compare', [
            'listings' => $listings,
            'ids'      => $ids,
            'shareUrl' => url('/compare') . (empty($ids) ? '' : ('?ids=' . implode(',', $ids))),
        ]);
    }

    // Add item to compare (max 4)
public function add(Request $request)
{
    // Accept JSON {id: ...} or form field "vehicle_id"
    $id = (int) ($request->input('id') ?? $request->input('vehicle_id') ?? $request->query('id'));

    if (!$id) {
        // If JSON was expected, return JSON; otherwise redirect back with a message
        if ($request->expectsJson()) {
            return response()->json(['ok' => false, 'error' => 'missing_id'], 422);
        }
        return back()->with('message', 'Missing vehicle id.');
    }

    $ids = collect((array) session('compare_ids', []))
        ->map(fn ($v) => (int) $v)
        ->unique()
        ->values()
        ->all();

    if (!in_array($id, $ids, true)) {
        if (count($ids) >= 4) {
            // Enforce max of 4
            if ($request->expectsJson()) {
                return response()->json(['ok' => false, 'reason' => 'full', 'ids' => $ids], 422);
            }
            return back()->with('message', 'You can compare up to 4 vehicles.');
        }
        $ids[] = $id;
    }

    session(['compare_ids' => $ids]);

    if ($request->expectsJson()) {
        return response()->json(['ok' => true, 'ids' => $ids], 200);
    }

    return back()->with('message', 'Added to compare.');
}


    // Remove item from compare
public function remove(Request $request)
{
    $id = (int) ($request->input('id') ?? $request->input('vehicle_id') ?? $request->query('id'));

    $ids = collect((array) session('compare_ids', []))
        ->map(fn ($v) => (int) $v)
        ->filter(fn ($v) => $v !== $id)
        ->values()
        ->all();

    session(['compare_ids' => $ids]);

    if ($request->expectsJson()) {
        return response()->json(['ok' => true, 'ids' => $ids], 200);
    }

    return back()->with('message', 'Removed from compare.');
}
    // Optional: clear all and redirect
public function clear(Request $request)
{
    session()->forget('compare_ids');

    if ($request->expectsJson()) {
        return response()->json(['ok' => true, 'ids' => []], 200);
    }

    return back()->with('message', 'Compare list cleared.');
}

    // NEW: JSON summary for sticky drawer chips
    public function summary(Request $request)
    {
        $idsParam = trim((string) $request->query('ids', ''));
        $ids = $idsParam !== ''
            ? collect(explode(',', $idsParam))->map(fn($v)=>(int)$v)->filter()->values()->all()
            : collect($request->session()->get('compare_ids', []))->map(fn($v)=>(int)$v)->filter()->values()->all();

        if (empty($ids)) {
            return response()->json([]);
        }

        $rows = DB::table('listings')
            ->join('vehicles', 'listings.vehicle_id', '=', 'vehicles.id')
            ->select('listings.id', 'vehicles.make', 'vehicles.model', 'vehicles.year', 'listings.title', 'listings.price')
            ->whereIn('listings.id', $ids)
            ->get()
            ->sortBy(fn($row) => array_search($row->id, $ids))
            ->values();

        return response()->json($rows);
    }
    
    public function show(\Illuminate\Http\Request $request)
    {
    return $this->index($request);
    }
}
