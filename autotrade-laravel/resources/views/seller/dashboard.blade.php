<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Seller Dashboard • AUTOTRADE</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark">
  <div class="container d-flex justify-content-between">
    <a href="{{ route('home') }}" class="navbar-brand">AUTOTRADE</a>
    <div class="d-flex gap-2">
      <a href="{{ route('listings.create') }}" class="btn btn-outline-light btn-sm">List a Vehicle</a>
      <a href="{{ route('buyer.dashboard') }}" class="btn btn-outline-light btn-sm">Buyer Dashboard</a>
    </div>
  </div>
</nav>

<main class="container py-4">
  @if(session('ok'))
    <div class="alert alert-success">{{ session('ok') }}</div>
  @endif

  <div class="d-flex justify-content-between align-items-center">
    <h1 class="h4 mb-3">My Listings</h1>
    <a href="{{ route('listings.create') }}" class="btn btn-primary btn-sm">+ New Listing</a>
  </div>

  <div class="vstack gap-3">
    @forelse($myListings as $l)
      <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <div class="fw-semibold">{{ $l->year }} {{ $l->make }} {{ $l->model }}</div>
            <div class="text-muted small">{{ $l->title }}</div>
            <div class="mt-1 d-flex gap-2 flex-wrap">
              <span class="badge bg-light text-dark">Price: ${{ number_format($l->price, 2) }}</span>
              <span class="badge bg-light text-dark">Mileage: {{ number_format($l->mileage) }} mi</span>
              <span class="badge bg-secondary">{{ $l->body_type }}</span>
              <span class="badge bg-secondary">{{ $l->is_active ? 'Active' : 'Inactive' }}</span>
            </div>
          </div>
          <span class="text-muted small">{{ $l->city }}, {{ $l->state }}</span>
        </div>
      </div>
    @empty
      <div class="alert alert-secondary">You don’t have any listings yet.</div>
    @endforelse
  </div>
</main>
</body>
</html>
