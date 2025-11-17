<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>AUTOTRADE • Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .compare-active{ border-color:#0d6efd!important; color:#0d6efd!important; background:#e7f1ff!important;}
    #compareDrawer{
      position: fixed; left:0; right:0; bottom:0; z-index: 1030;
      transform: translateY(110%); transition: transform .2s ease-in-out;
    }
    #compareDrawer.show{ transform: translateY(0); }
    .chip{background:#f8f9fa;border:1px solid #e9ecef;border-radius:9999px;padding:.25rem .6rem}
  </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
  <div class="container d-flex justify-content-between align-items-center">
    <a class="navbar-brand fw-bold" href="/">AUTOTRADE</a>

    <div class="d-flex gap-2 align-items-center">
      @auth
        <a href="{{ route('buyer.dashboard') }}" class="btn btn-outline-light btn-sm">Buyer</a>
        <a href="{{ route('seller.dashboard') }}" class="btn btn-outline-light btn-sm">Seller</a>
        <a href="{{ route('listings.create') }}" class="btn btn-primary btn-sm">List a Vehicle</a>

        <span class="text-white-50 small ms-2 d-none d-md-inline">Hi, {{ Auth::user()->display_name ?? Auth::user()->email }}</span>
        <form method="POST" action="{{ route('logout') }}" class="d-inline">
          @csrf
          <button type="submit" class="btn btn-light btn-sm ms-2">Logout</button>
        </form>
      @else
        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Login</a>
        <a href="{{ route('register') }}" class="btn btn-light btn-sm">Sign Up</a>
      @endauth

      <a href="{{ route('compare') }}" class="btn btn-outline-light btn-sm position-relative ms-2">
        Compare
        <span id="compareCount" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
          {{ count(session('compare_ids', [])) }}
        </span>
      </a>
    </div>
  </div>
</nav>

<main class="container py-4">
  {{-- SEARCH / FILTERS --}}
  <form id="filterForm" method="GET" action="{{ route('home') }}" class="card shadow-sm mb-4">
    <div class="card-body">
      <div class="row g-3 align-items-end">
        <div class="col-12">
          <label class="form-label fw-semibold" for="q">Search</label>
          <input type="text" id="q" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search by make, model, title, or seller">
        </div>

        {{-- Make / Model --}}
        <div class="col-6 col-md-3">
          <label class="form-label fw-semibold" for="make">Make</label>
          <select id="make" name="make" class="form-select">
            <option value="">Any</option>
            @foreach ($makes as $m)
              <option value="{{ $m }}" @selected(request('make')===$m)>{{ $m }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-6 col-md-3">
          <label class="form-label fw-semibold" for="model">Model</label>
          <select id="model" name="model" class="form-select">
            <option value="">Any</option>
            @foreach ($models as $m)
              <option value="{{ $m }}" @selected(request('model')===$m)>{{ $m }}</option>
            @endforeach
          </select>
        </div>

        {{-- Year range --}}
        <div class="col-6 col-md-3">
          <label class="form-label fw-semibold" for="min_year">Min Year</label>
          <select id="min_year" name="min_year" class="form-select">
            <option value="">Any</option>
            @foreach ($yearOptions as $y)
              <option value="{{ $y }}" @selected(request('min_year')==$y)>{{ $y }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-6 col-md-3">
          <label class="form-label fw-semibold" for="max_year">Max Year</label>
          <select id="max_year" name="max_year" class="form-select">
            <option value="">Any</option>
            @foreach ($yearOptions as $y)
              <option value="{{ $y }}" @selected(request('max_year')==$y)>{{ $y }}</option>
            @endforeach
          </select>
        </div>

        {{-- Price --}}
        <div class="col-6 col-md-3">
          <label class="form-label fw-semibold" for="min_price">Min Price ($)</label>
          <input type="number" id="min_price" name="min_price" value="{{ request('min_price') }}" class="form-control" min="0" step="500">
        </div>
        <div class="col-6 col-md-3">
          <label class="form-label fw-semibold" for="max_price">Max Price ($)</label>
          <input type="number" id="max_price" name="max_price" value="{{ request('max_price') }}" class="form-control" min="0" step="500">
        </div>

        {{-- Max mileage --}}
        <div class="col-6 col-md-3">
          <label class="form-label fw-semibold" for="max_miles">Max Mileage</label>
          <input type="number" id="max_miles" name="max_miles" value="{{ request('max_miles') }}" class="form-control" min="0" step="1000">
        </div>

        {{-- Vehicle details --}}
        <div class="col-6 col-md-3">
          <label class="form-label fw-semibold" for="body_type">Body Type</label>
          <select id="body_type" name="body_type" class="form-select">
            <option value="">Any</option>
            @foreach ($bodyTypes as $v)
              <option value="{{ $v }}" @selected(request('body_type')===$v)>{{ $v }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-6 col-md-3">
          <label class="form-label fw-semibold" for="drivetrain">Drivetrain</label>
          <select id="drivetrain" name="drivetrain" class="form-select">
            <option value="">Any</option>
            @foreach ($drivetrains as $v)
              <option value="{{ $v }}" @selected(request('drivetrain')===$v)>{{ $v }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-6 col-md-3">
          <label class="form-label fw-semibold" for="fuel_type">Fuel</label>
          <select id="fuel_type" name="fuel_type" class="form-select">
            <option value="">Any</option>
            @foreach ($fuels as $v)
              <option value="{{ $v }}" @selected(request('fuel_type')===$v)>{{ $v }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-6 col-md-3">
          <label class="form-label fw-semibold" for="transmission">Transmission</label>
          <select id="transmission" name="transmission" class="form-select">
            <option value="">Any</option>
            @foreach ($transmissions as $v)
              <option value="{{ $v }}" @selected(request('transmission')===$v)>{{ $v }}</option>
            @endforeach
          </select>
        </div>

        {{-- Colors --}}
        <div class="col-6 col-md-3">
          <label class="form-label fw-semibold" for="color_ext">Exterior Color</label>
          <select id="color_ext" name="color_ext" class="form-select">
            <option value="">Any</option>
            @foreach ($extColors as $c)
              <option value="{{ $c }}" @selected(request('color_ext')===$c)>{{ $c }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-6 col-md-3">
          <label class="form-label fw-semibold" for="color_int">Interior Color</label>
          <select id="color_int" name="color_int" class="form-select">
            <option value="">Any</option>
            @foreach ($intColors as $c)
              <option value="{{ $c }}" @selected(request('color_int')===$c)>{{ $c }}</option>
            @endforeach
          </select>
        </div>

        {{-- Location --}}
        <div class="col-6 col-md-3">
          <label class="form-label fw-semibold" for="state">State</label>
          <select id="state" name="state" class="form-select">
            <option value="">Any</option>
            @foreach ($states as $s)
              <option value="{{ $s }}" @selected(request('state')===$s)>{{ $s }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-6 col-md-3">
          <label class="form-label fw-semibold" for="city">City</label>
          <select id="city" name="city" class="form-select">
            <option value="">Any</option>
            @foreach ($cities as $c)
              <option value="{{ $c }}" @selected(request('city')===$c)>{{ $c }}</option>
            @endforeach
          </select>
        </div>

        {{-- Condition --}}
        <div class="col-6 col-md-3">
          <label class="form-label fw-semibold" for="condition_grade">Min Condition (1–5)</label>
          <select id="condition_grade" name="condition_grade" class="form-select">
            <option value="">Any</option>
            @for ($i = 1; $i <= 5; $i++)
              <option value="{{ $i }}" @selected(request('condition_grade')==$i)>{{ $i }}</option>
            @endfor
          </select>
        </div>

        {{-- Sort --}}
        <div class="col-12 col-md-3 ms-auto">
          <label class="form-label fw-semibold" for="sort">Sort by</label>
          @php $s = request('sort','newest'); @endphp
          <select id="sort" name="sort" class="form-select">
            <option value="newest"      {{ $s==='newest' ? 'selected' : '' }}>Newest</option>
            <option value="price_asc"   {{ $s==='price_asc' ? 'selected' : '' }}>Price: Low → High</option>
            <option value="price_desc"  {{ $s==='price_desc' ? 'selected' : '' }}>Price: High → Low</option>
            <option value="mileage_asc" {{ $s==='mileage_asc' ? 'selected' : '' }}>Mileage: Low → High</option>
            <option value="mileage_desc"{{ $s==='mileage_desc' ? 'selected' : '' }}>Mileage: High → Low</option>
            <option value="year_desc"   {{ $s==='year_desc' ? 'selected' : '' }}>Year: New → Old</option>
            <option value="year_asc"    {{ $s==='year_asc' ? 'selected' : '' }}>Year: Old → New</option>
          </select>
        </div>

        <div class="col-12 d-flex gap-2 mt-2">
          <button type="submit" class="btn btn-primary">Search</button>
          <a href="{{ route('home') }}" class="btn btn-outline-secondary">Reset</a>
        </div>

      </div>
    </div>
  </form>

  <h1 class="h4 mb-3">Results</h1>

  @isset($listings)
    <div id="results" class="vstack gap-3">
      @forelse ($listings as $l)
        <div class="card shadow-sm">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <div class="fw-semibold">{{ $l->year }} {{ $l->make }} {{ $l->model }}</div>
              <div class="text-muted small">{{ $l->title }}</div>
              <div class="mt-1 d-flex flex-wrap gap-2">
                <span class="badge bg-light text-dark">Price: ${{ number_format($l->price, 2) }}</span>
                <span class="badge bg-light text-dark">Mileage: {{ number_format($l->mileage) }} mi</span>
                <span class="badge bg-secondary">{{ $l->body_type }}</span>
                <span class="badge bg-secondary">{{ $l->drivetrain }}</span>
                <span class="badge bg-secondary">{{ $l->fuel_type }}</span>
                <span class="badge bg-secondary">{{ $l->transmission }}</span>
              </div>
            </div>
            <button type="button"
                    class="btn btn-outline-secondary btn-sm compare-btn {{ in_array($l->id, session('compare_ids', [])) ? 'compare-active' : '' }}"
                    data-compare-id="{{ $l->id }}">
              {{ in_array($l->id, session('compare_ids', [])) ? 'Added' : 'Compare' }}
            </button>
          </div>
        </div>
      @empty
        <div class="alert alert-secondary">No listings match your filters.</div>
      @endforelse
    </div>
  @else
    <div class="alert alert-info">Controller not sending data yet — once wired, listings will render here.</div>
  @endisset

</main>

{{-- Sticky compare drawer --}}
<div id="compareDrawer" class="bg-white border-top shadow-sm">
  <div class="container py-2 d-flex align-items-center justify-content-between">
    <div class="d-flex flex-wrap gap-2 align-items-center" id="drawerChips"></div>
    <div class="d-flex gap-2">
      <a id="drawerCompareLink" href="{{ route('compare') }}" class="btn btn-primary btn-sm">Compare</a>
      <button id="drawerClear" class="btn btn-outline-secondary btn-sm" type="button">Clear</button>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("filterForm");
  const results = document.getElementById("results");
  const drawer = document.getElementById("compareDrawer");
  const drawerChips = document.getElementById("drawerChips");
  const drawerCompareLink = document.getElementById("drawerCompareLink");
  const drawerClear = document.getElementById("drawerClear");
  const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  // initialize from session
  window.compareIds = @json(session('compare_ids', []));

  function updateCompareBadge() {
    const el = document.getElementById('compareCount');
    if (el) el.textContent = (window.compareIds || []).length;
  }

  function setBtnState(btn, active) {
    if (active) { btn.classList.add('compare-active'); btn.textContent = 'Added'; }
    else { btn.classList.remove('compare-active'); btn.textContent = 'Compare'; }
  }

  // --- SAFER: use FormData and guard refreshDrawer() so no JS error stops updates
  async function toggleCompare(id) {
    const isSelected = (window.compareIds || []).includes(id);
    const url = isSelected ? "{{ route('compare.remove') }}" : "{{ route('compare.add') }}";

    const fd = new FormData();
    fd.append('_token', csrf);
    fd.append('id', id);

    const res = await fetch(url, {
      method: 'POST',
      headers: { 'Accept': 'application/json' },
      body: fd
    });

    if (!res.ok) {
      let data = {};
      try { data = await res.json(); } catch (e) {}
      if (data.reason === 'full') alert('You can compare up to 4 vehicles.');
      else if (res.status === 419) alert('Session expired. Please refresh and try again.');
      else alert('Could not update compare list.');
      return;
    }

    const data = await res.json();
    window.compareIds = data.ids || [];
    updateCompareBadge();
    if (typeof refreshDrawer === 'function') refreshDrawer(); // guard it
    document.querySelectorAll(`[data-compare-id="${id}"]`).forEach(b => setBtnState(b, window.compareIds.includes(id)));
  }

  // Click handler for the in-card Compare buttons
  document.body.addEventListener('click', (e) => {
    const btn = e.target.closest('.compare-btn');
    if (btn) {
      const id = parseInt(btn.dataset.compareId, 10);
      toggleCompare(id);
    }
  });

  // Optional: Clear button in the drawer
  if (drawerClear) {
    drawerClear.addEventListener('click', async () => {
      const fd = new FormData();
      fd.append('_token', csrf);
      const res = await fetch("{{ route('compare.clear') }}", {
        method: 'POST',
        headers: { 'Accept': 'application/json' },
        body: fd
      });
      if (res.ok) {
        window.compareIds = [];
        updateCompareBadge();
        if (typeof refreshDrawer === 'function') refreshDrawer();
        // also reset all compare buttons
        document.querySelectorAll('.compare-btn').forEach(b => setBtnState(b, false));
      } else {
        alert('Could not clear compare list.');
      }
    });
  }

  // In case the session already had items when page loads
  updateCompareBadge();

  // If you later add an implementation for refreshDrawer(), it will be called above.
  // (Leaving it undefined won’t break anything due to the guard.)
});
</script>
</body>
</html>