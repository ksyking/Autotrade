<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ $l->year }} {{ $l->make }} {{ $l->model }} • AUTOTRADE</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand fw-bold" href="{{ route('home') }}">AUTOTRADE</a>
    <a class="btn btn-outline-light btn-sm" href="{{ route('compare') }}">Compare</a>
  </div>
</nav>

<main class="container py-4">
  <a href="{{ url()->previous() }}" class="btn btn-link p-0 mb-3">&larr; Back</a>

  <div class="card shadow-sm">
    <div class="card-body">
      <h1 class="h4 mb-1">{{ $l->year }} {{ $l->make }} {{ $l->model }}</h1>
      <div class="text-muted">{{ $l->title }}</div>

      <div class="row g-3 mt-3">
        <div class="col-md-6">
          <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between">
              <span>Price</span><strong>${{ number_format($l->price,2) }}</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span>Mileage</span><strong>{{ number_format($l->mileage) }} mi</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span>Body</span><strong>{{ $l->body_type }}</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span>Drivetrain</span><strong>{{ $l->drivetrain }}</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span>Fuel</span><strong>{{ $l->fuel_type }}</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span>Transmission</span><strong>{{ $l->transmission }}</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span>Location</span><strong>{{ $l->city }}, {{ $l->state }}</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span>Condition</span><strong>{{ $l->condition_grade }}/5</strong>
            </li>
          </ul>
        </div>
        <div class="col-md-6">
          <p class="mb-2"><strong>Description</strong></p>
          <p class="text-muted">{{ $l->description ?? '—' }}</p>

          <form class="mt-3">
            <button type="button"
              class="btn btn-outline-primary"
              id="compareBtn"
              data-id="{{ $l->id }}">
              Add to Compare
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const btn = document.getElementById('compareBtn');
  const id = parseInt(btn.dataset.id, 10);

  btn.addEventListener('click', async () => {
    const res = await fetch("{{ route('compare.add') }}", {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({ id })
    });
    if (res.ok) {
      btn.classList.replace('btn-outline-primary','btn-success');
      btn.textContent = 'Added';
    } else {
      alert('Could not add to compare (limit 4).');
    }
  });
});
</script>
</body>
</html>
