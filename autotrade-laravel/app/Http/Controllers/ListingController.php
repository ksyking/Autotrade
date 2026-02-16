<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    /**
     * Show the "Create Listing" form.
     * Uses the same dropdown sources as SearchController@index.
     */
    public function create()
    {
        // Dropdown sources (distinct values from DB)
        $makes         = DB::table('vehicles')->select('make')->distinct()->orderBy('make')->pluck('make');
        $models        = DB::table('vehicles')->select('model')->distinct()->orderBy('model')->pluck('model');

        $bodyTypes     = DB::table('vehicles')->select('body_type')->whereNotNull('body_type')->distinct()->orderBy('body_type')->pluck('body_type');
        $drivetrains   = DB::table('vehicles')->select('drivetrain')->whereNotNull('drivetrain')->distinct()->orderBy('drivetrain')->pluck('drivetrain');
        $fuels         = DB::table('vehicles')->select('fuel_type')->whereNotNull('fuel_type')->distinct()->orderBy('fuel_type')->pluck('fuel_type');
        $transmissions = DB::table('vehicles')->select('transmission')->whereNotNull('transmission')->distinct()->orderBy('transmission')->pluck('transmission');

        $extColors     = DB::table('listings')->select('color_ext')->whereNotNull('color_ext')->distinct()->orderBy('color_ext')->pluck('color_ext');
        $intColors     = DB::table('listings')->select('color_int')->whereNotNull('color_int')->distinct()->orderBy('color_int')->pluck('color_int');

        $states        = DB::table('listings')->select('state')->whereNotNull('state')->distinct()->orderBy('state')->pluck('state');
        $cities        = DB::table('listings')->select('city')->whereNotNull('city')->distinct()->orderBy('city')->pluck('city');

        $minYearDB     = (int) (DB::table('vehicles')->min('year') ?? 1980);
        $maxYearDB     = (int) (DB::table('vehicles')->max('year') ?? date('Y'));
        $yearOptions   = range($maxYearDB, $minYearDB); // descending

        return view('listings.create', compact(
            'makes',
            'models',
            'bodyTypes',
            'drivetrains',
            'fuels',
            'transmissions',
            'extColors',
            'intColors',
            'states',
            'cities',
            'yearOptions'
        ));
    }

    /**
     * Handle form submission and insert new vehicle + listing + photos.
     */
    public function store(Request $request)
    {
        $userId = Auth::id();

        // Validation
        $data = $request->validate([
            // Listing-facing fields
            'title'           => ['required', 'string', 'max:255'],
            'description'     => ['nullable', 'string'],
            'price'           => ['required', 'numeric', 'min:0'],
            'mileage'         => ['nullable', 'integer', 'min:0'],
            'color_ext'       => ['nullable', 'string', 'max:100'],
            'color_int'       => ['nullable', 'string', 'max:100'],
            'city'            => ['nullable', 'string', 'max:100'],
            'state'           => ['nullable', 'string', 'max:100'],
            'condition_grade' => ['nullable', 'integer', 'min:1', 'max:5'],

            // Vehicle fields (we’ll create a vehicle row for this listing)
            'year'         => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'make'         => ['required', 'string', 'max:100'],
            'model'        => ['required', 'string', 'max:100'],
            'trim'         => ['nullable', 'string', 'max:100'],
            'body_type'    => ['nullable', 'string', 'max:100'],
            'drivetrain'   => ['nullable', 'string', 'max:100'],
            'fuel_type'    => ['nullable', 'string', 'max:100'],
            'transmission' => ['nullable', 'string', 'max:100'],

            // Photos (optional)
            'photos'       => ['nullable', 'array', 'max:5'],
            'photos.*'     => ['file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'], // 5MB each
        ]);

        // Wrap in a transaction so vehicle + listing + photos stay in sync
        DB::beginTransaction();

        try {
            // 1) Create vehicle row
            $vehicleId = DB::table('vehicles')->insertGetId([
                'make'         => $data['make'],
                'model'        => $data['model'],
                'trim'         => $data['trim'] ?? null,
                'year'         => $data['year'],
                'body_type'    => $data['body_type'] ?? null,
                'drivetrain'   => $data['drivetrain'] ?? null,
                'fuel_type'    => $data['fuel_type'] ?? null,
                'transmission' => $data['transmission'] ?? null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            // 2) Build aggregated search text (professor recommendation)
            $parts = [
                $data['title'] ?? null,
                $data['year'] ?? null,
                $data['make'] ?? null,
                $data['model'] ?? null,
                $data['trim'] ?? null,
                $data['body_type'] ?? null,
                $data['drivetrain'] ?? null,
                $data['fuel_type'] ?? null,
                $data['transmission'] ?? null,
                $data['color_ext'] ?? null,
                $data['color_int'] ?? null,
                $data['city'] ?? null,
                $data['state'] ?? null,
                $data['description'] ?? null,
            ];

            $searchText = trim(
                preg_replace('/\s+/', ' ',
                    implode(' ', array_filter($parts, fn ($v) => $v !== null && $v !== ''))
                )
            );

            // 3) Upload photos (if any)
            // This uses the DEFAULT disk (local now, s3 later via FILESYSTEM_DISK=s3)
            $disk = config('filesystems.default');

            $primaryUrl = null;
            $primaryKey = null;

            $photoRows = [];
            $files = $request->file('photos', []);

            foreach ($files as $i => $file) {
                // Store in a predictable folder by user
                $key = $file->store("listings/{$userId}", $disk); // e.g. listings/12/abcd123.jpg
                $url = Storage::disk($disk)->url($key);

                $isPrimary = ($i === 0);
                if ($isPrimary) {
                    $primaryUrl = $url;
                    $primaryKey = $key;
                }

                $photoRows[] = [
                    'photo_url'  => $url,
                    'photo_key'  => $key,
                    'is_primary' => $isPrimary,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // 4) Create listing row (insertGetId so we can attach photos)
            $listingId = DB::table('listings')->insertGetId([
                'seller_id'         => $userId,
                'vehicle_id'        => $vehicleId,
                'title'             => $data['title'],
                'description'       => $data['description'] ?? null,

                // NEW fields
                'search_text'       => $searchText !== '' ? $searchText : null,
                'primary_photo_url' => $primaryUrl,
                'primary_photo_key' => $primaryKey,

                // Existing fields
                'color_ext'         => $data['color_ext'] ?? null,
                'color_int'         => $data['color_int'] ?? null,
                'mileage'           => $data['mileage'] ?? null,
                'price'             => $data['price'],
                'city'              => $data['city'] ?? null,
                'state'             => $data['state'] ?? null,
                'condition_grade'   => $data['condition_grade'] ?? null,
                'is_active'         => true,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            // 5) Insert photo rows into listing_photos
            if (!empty($photoRows)) {
                foreach ($photoRows as &$row) {
                    $row['listing_id'] = $listingId;
                }
                DB::table('listing_photos')->insert($photoRows);
            }

            DB::commit();

            return redirect()
                ->route('seller.dashboard')
                ->with('status', 'Listing created successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();

            // Optional cleanup: if upload succeeded but DB failed, you may want to delete uploaded keys.
            // Keeping it simple for now (school project). If you want, I can add cleanup logic.

            return back()
                ->withInput()
                ->withErrors(['general' => 'Could not create listing. Please try again.']);
        }
    }
}
