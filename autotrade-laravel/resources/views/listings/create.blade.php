<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>List a Vehicle • AUTOTRADE</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark">
  <div class="container d-flex justify-content-between">
    <a href="{{ route('home') }}" class="navbar-brand">AUTOTRADE</a>
    <div class="d-flex gap-2">
      <a href="{{ route('seller.dashboard') }}" class="btn btn-outline-light btn-sm">Seller Dashboard</a>
    </div>
  </div>
</nav>

<main class="container py-4">
  <h1 class="h4 mb-3">Create a Listing</h1>

  <form method="POST" action="{{ route('listings.store') }}" class="card shadow-sm">
    @csrf
    <div class="card-body">
      <h6 class="text-uppercase text-muted">Vehicle</h6>
      <div class="row g-3">
        <div class="col-md-3">
          <label class="form-label">Make</label>
          <select class="form-select" name="make" required>
            <option value="">Choose…</option>
            @foreach($makes as $v)
              <option value="{{ $v }}" @selected(old('make')===$v)>{{ $v }}</option>
            @endforeach
          </select>
          @error('make') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-3">
          <label class="form-label">Model</label>
          <select class="form-select" name="model" required>
            <option value="">Choose…</option>
            @foreach($models as $v)
              <option value="{{ $v }}" @selected(old('model')===$v)>{{ $v }}</option>
            @endforeach
          </select>
          @error('model') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-2">
          <label class="form-label">Trim</label>
          <input type="text" name="trim" class="form-control" value="{{ old('trim') }}">
        </div>

        <div class="col-md-2">
          <label class="form-label">Year</label>
          <select class="form-select" name="year" required>
            <option value="">Choose…</option>
            @foreach($years as $v)
              <option value="{{ $v }}" @selected(old('year')==$v)>{{ $v }}</option>
            @endforeach
          </select>
          @error('year') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-2">
          <label class="form-label">Body Type</label>
          <select class="form-select" name="body_type">
            <option value="">Any</option>
            @foreach($body as $v)
              <option value="{{ $v }}" @selected(old('body_type')===$v)>{{ $v }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-3">
          <label class="form-label">Drivetrain</label>
          <select class="form-select" name="drivetrain">
            <option value="">Any</option>
            @foreach($drive as $v)
              <option value="{{ $v }}" @selected(old('drivetrain')===$v)>{{ $v }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-3">
          <label class="form-label">Fuel</label>
          <select class="form-select" name="fuel_type">
            <option value="">Any</option>
            @foreach($fuel as $v)
              <option value="{{ $v }}" @selected(old('fuel_type')===$v)>{{ $v }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-3">
          <label class="form-label">Transmission</label>
          <select class="form-select" name="transmission">
            <option value="">Any</option>
            @foreach($trans as $v)
              <option value="{{ $v }}" @selected(old('transmission')===$v)>{{ $v }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <hr class="my-4">

      <h6 class="text-uppercase text-muted">Listing</h6>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Title</label>
          <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
          @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6">
          <label class="form-label">Description</label>
          <input type="text" name="description" class="form-control" value="{{ old('description') }}">
        </div>

        <div class="col-md-2">
          <label class="form-label">Exterior Color</label>
          <input type="text" name="color_ext" class="form-control" value="{{ old('color_ext') }}">
        </div>

        <div class="col-md-2">
          <label class="form-label">Interior Color</label>
          <input type="text" name="color_int" class="form-control" value="{{ old('color_int') }}">
        </div>

        <div class="col-md-2">
          <label class="form-label">Mileage</label>
          <input type="number" name="mileage" class="form-control" value="{{ old('mileage') }}" min="0" required>
          @error('mileage') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-2">
          <label class="form-label">Price (USD)</label>
          <input type="number" name="price" class="form-control" value="{{ old('price') }}" min="0" step="0.01" required>
          @error('price') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-2">
          <label class="form-label">City</label>
          <input type="text" name="city" class="form-control" value="{{ old('city') }}">
        </div>

        <div class="col-md-2">
          <label class="form-label">State</label>
          <input type="text" name="state" class="form-control" value="{{ old('state') }}" maxlength="2">
        </div>

        <div class="col-md-2">
          <label class="form-label">Min Condition (1–5)</label>
          <select name="condition_grade" class="form-select">
            <option value="">—</option>
            @for($i=1;$i<=5;$i++)
              <option value="{{ $i }}" @selected(old('condition_grade')==$i)>{{ $i }}</option>
            @endfor
          </select>
        </div>

        <div class="col-md-2">
          <label class="form-label">Active?</label>
          <select name="is_active" class="form-select">
            <option value="1" @selected(old('is_active',1)==1)>Yes</option>
            <option value="0" @selected(old('is_active')==='0')>No</option>
          </select>
        </div>
      </div>

      <div class="mt-4 d-flex gap-2">
        <button class="btn btn-primary" type="submit">Create Listing</button>
        <a href="{{ route('seller.dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
      </div>
    </div>
  </form>
</main>
</body>
</html>
