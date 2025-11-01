<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>AUTOTRADE • Compare</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    th{white-space:nowrap;}
  </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
  <div class="container d-flex justify-content-between">
    <a class="navbar-brand fw-bold" href="/">AUTOTRADE</a>
    <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm">Back to Search</a>
  </div>
</nav>

<main class="container py-4">
  <h1 class="h4 mb-3">Compare Vehicles</h1>

  {{-- Shareable permalink --}}
  <div class="card mb-3">
    <div class="card-body d-flex align-items-center gap-2">
      <input id="shareLink" type="text" class="form-control" readonly value="{{ $shareUrl }}">
      <button id="copyBtn" class="btn btn-outline-secondary btn-sm">Copy</button>
    </div>
  </div>

  @if ($listings->isEmpty())
    <div class="alert alert-secondary">
      No vehicles selected. Go back to the homepage and click <strong>Compare</strong> on up to 4 listings.
    </div>
  @else
    <div class="table-responsive">
      <table class="table table-bordered bg-white">
        <thead class="table-light">
          <tr>
            <th>Attribute</th>
            @foreach ($listings as $l)
              <th class="text-center">
                <div class="fw-semibold">{{ $l->year }} {{ $l->make }} {{ $l->model }}</div>
                <div class="text-muted small">{{ $l->title }}</div>
                <form method="POST" action="{{ route('compare.remove') }}" class="d-inline remove-form">
                  @csrf
                  <input type="hidden" name="id" value="{{ $l->id }}">
                  <button type="submit" class="btn btn-sm btn-outline-danger mt-1">Remove</button>
                </form>
              </th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          @php
            $rows = [
              'Price' => fn($x) => '$'.number_format($x->price, 2),
              'Mileage' => fn($x) => number_format($x->mileage).' mi',
              'Body Type' => fn($x) => $x->body_type,
              'Drivetrain' => fn($x) => $x->drivetrain,
              'Fuel' => fn($x) => $x->fuel_type,
              'Transmission' => fn($x) => $x->transmission,
              'Exterior Color' => fn($x) => $x->color_ext,
              'Interior Color' => fn($x) => $x->color_int,
              'Condition (1–5)' => fn($x) => $x->condition_grade,
              'Location' => fn($x) => trim(($x->city ?? '').', '.($x->state ?? ''), ', '),
            ];
          @endphp

          @foreach ($rows as $label => $getter)
            <tr>
              <th class="bg-light">{{ $label }}</th>
              @foreach ($listings as $l)
                <td>{{ $getter($l) }}</td>
              @endforeach
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <form method="POST" action="{{ route('compare.clear') }}" class="mt-2">
      @csrf
      <button type="submit" class="btn btn-outline-secondary btn-sm">Clear All</button>
    </form>
  @endif

</main>

<script>
document.getElementById('copyBtn')?.addEventListener('click', async () => {
  const input = document.getElementById('shareLink');
  try {
    await navigator.clipboard.writeText(input.value);
    alert('Link copied!');
  } catch {
    input.select(); document.execCommand('copy'); alert('Link copied!');
  }
});

document.addEventListener('submit', async (e) => {
  const form = e.target.closest('.remove-form');
  if (!form) return;
  e.preventDefault();
  const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  const id = form.querySelector('input[name="id"]').value;

  const res = await fetch("{{ route('compare.remove') }}", {
    method: 'POST',
    headers: {'X-CSRF-TOKEN': csrf, 'Content-Type': 'application/json', 'Accept': 'application/json'},
    body: JSON.stringify({ id })
  });

  if (res.ok) {
    location.href = "{{ route('compare') }}"; // refresh without ids param
  } else {
    alert('Could not remove item.');
  }
});
</script>

</body>
</html>
