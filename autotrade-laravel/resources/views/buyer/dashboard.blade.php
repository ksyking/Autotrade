@extends('layouts.app')

@section('content')
<div class="container py-4">
  <h1 class="h4 mb-3">Buyer Dashboard</h1>

  <div class="row g-3">
    <div class="col-12 col-md-4">
      <div class="list-group">
        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
          Watchlist/Saved
          <span class="badge bg-secondary">{{ $stats['watchlistCount'] }}</span>
        </a>
        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
          Purchases
          <span class="badge bg-secondary">{{ $stats['purchases'] }}</span>
        </a>
        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
          Bids & Offers
          <span class="badge bg-secondary">{{ $stats['offers'] }}</span>
        </a>
        <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action">
          Profile & security
        </a>
      </div>
    </div>

    <div class="col-12 col-md-8">
      <div class="card">
        <div class="card-body">
          <p class="mb-0">Welcome, {{ $user->display_name ?? $user->name }}!</p>
          <small class="text-muted">This is your buyer dashboard placeholder.</small>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
