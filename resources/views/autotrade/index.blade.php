@extends('layouts.base')

@section('content')
<div style="max-width:960px;margin:40px auto;padding:0 16px;">
  <h1>Welcome, {{ auth()->user()->name }}</h1>
  <form method="post" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Log out</button>
  </form>
</div>
@endsection
