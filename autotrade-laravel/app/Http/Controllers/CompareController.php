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
        $id  = (int) $request->input('id');
        $ids = collect($request->session()->get('compare_ids', []));

        if (!$ids->contains($id)) {
            if ($ids->count() >= 4) {
                return response()->json([
                    'ok' => false,
                    'reason' => 'full',
                    'message' => 'You can compare up to 4 vehicles.',
                    'ids' => $ids->values()->all()
                ], 400);
            }
            $ids->push($id);
            $request->session()->put('compare_ids', $ids->values()->all());
        }

        return response()->json([
            'ok' => true,
            'ids' => $ids->values()->all(),
            'count' => $ids->count()
        ]);
    }

    // Remove item from compare
    public function remove(Request $request)
    {
        $id  = (int) $request->input('id');
        $ids = collect($request->session()->get('compare_ids', []))
            ->reject(fn($v) => (int) $v === $id)
            ->values();

        $request->session()->put('compare_ids', $ids->all());

        return response()->json([
            'ok' => true,
            'ids' => $ids->all(),
            'count' => $ids->count()
        ]);
    }

    // Optional: clear all and redirect
    public function clear(Request $request)
    {
        $request->session()->forget('compare_ids');
        return redirect()->route('compare');
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
}
