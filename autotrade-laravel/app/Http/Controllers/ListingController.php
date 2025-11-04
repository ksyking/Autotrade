<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    public function create()
    {
        // Pre-populate dropdowns from vehicles table
        $makes  = DB::table('vehicles')->select('make')->distinct()->orderBy('make')->pluck('make');
        $models = DB::table('vehicles')->select('model')->distinct()->orderBy('model')->pluck('model');
        $years  = DB::table('vehicles')->select('year')->distinct()->orderByDesc('year')->pluck('year');
        $body   = DB::table('vehicles')->select('body_type')->distinct()->orderBy('body_type')->pluck('body_type');
        $drive  = DB::table('vehicles')->select('drivetrain')->distinct()->orderBy('drivetrain')->pluck('drivetrain');
        $fuel   = DB::table('vehicles')->select('fuel_type')->distinct()->orderBy('fuel_type')->pluck('fuel_type');
        $trans  = DB::table('vehicles')->select('transmission')->distinct()->orderBy('transmission')->pluck('transmission');

        return view('listings.create', compact('makes','models','years','body','drive','fuel','trans'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            // Vehicle fields
            'make'         => ['required','string','max:80'],
            'model'        => ['required','string','max:80'],
            'trim'         => ['nullable','string','max:80'],
            'year'         => ['required','integer','min:1900','max:2100'],
            'body_type'    => ['nullable','string','max:40'],
            'drivetrain'   => ['nullable','string','max:40'],
            'fuel_type'    => ['nullable','string','max:40'],
            'transmission' => ['nullable','string','max:40'],

            // Listing fields
            'title'        => ['required','string','max:150'],
            'description'  => ['nullable','string'],
            'color_ext'    => ['nullable','string','max:40'],
            'color_int'    => ['nullable','string','max:40'],
            'mileage'      => ['required','integer','min:0'],
            'price'        => ['required','numeric','min:0'],
            'city'         => ['nullable','string','max:100'],
            'state'        => ['nullable','string','max:2'],
            'condition_grade' => ['nullable','integer','min:1','max:5'],
            'is_active'    => ['nullable', Rule::in([0,1])],
        ]);

        // Create a vehicle row (simple approach for demo)
        $vehicleId = DB::table('vehicles')->insertGetId([
            'make'         => $data['make'],
            'model'        => $data['model'],
            'trim'         => $data['trim'] ?? null,
            'year'         => $data['year'],
            'body_type'    => $data['body_type'] ?? null,
            'drivetrain'   => $data['drivetrain'] ?? null,
            'fuel_type'    => $data['fuel_type'] ?? null,
            'transmission' => $data['transmission'] ?? null,
        ]);

        // Insert the listing
        DB::table('listings')->insert([
            'seller_id'       => Auth::id(),
            'vehicle_id'      => $vehicleId,
            'title'           => $data['title'],
            'description'     => $data['description'] ?? null,
            'color_ext'       => $data['color_ext'] ?? null,
            'color_int'       => $data['color_int'] ?? null,
            'mileage'         => $data['mileage'],
            'price'           => $data['price'],
            'city'            => $data['city'] ?? null,
            'state'           => $data['state'] ?? null,
            'condition_grade' => $data['condition_grade'] ?? null,
            'is_active'       => isset($data['is_active']) ? (int)$data['is_active'] : 1,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        return redirect()->route('seller.dashboard')->with('ok', 'Listing created!');
    }
}
