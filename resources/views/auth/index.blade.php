@extends('layouts.base')

@section('content')
<style>
  :root{--at-bg:#f5f6f8;--at-card:#fff;--at-border:#e5e7eb;--at-text:#111827;--at-muted:#6b7280;--at-blue:#0d6efd;--at-blue-600:#0b5ed7;--at-radius:12px;}
  body{background:var(--at-bg);}
  .at-container{max-width:460px;margin:48px auto 64px;padding:0 16px;}
  .at-card{background:var(--at-card);border:1px solid var(--at-border);border-radius:var(--at-radius);box-shadow:0 1px 2px rgba(0,0,0,.03),0 8px 24px rgba(0,0,0,.06);padding:28px;}
  .at-title{font-size:28px;font-weight:600;margin:4px 0 20px;text-align:center;}
  .at-tabs{display:flex;gap:12px;justify-content:center;margin-bottom:16px;}
  .at-tab{padding:8px 12px;border:1px solid var(--at-border);border-radius:8px;cursor:pointer;text-decoration:none;color:var(--at-text);}
  .at-tab.active{border-color:var(--at-blue);box-shadow:0 0 0 3px rgba(13,110,253,.15);}
  .at-field{display:block;width:100%;margin:10px 0 14px;padding:12px 14px;border:1px solid var(--at-border);border-radius:10px;background:#fff;font-size:16px;outline:none;}
  .at-field:focus{border-color:var(--at-blue);box-shadow:0 0 0 3px rgba(13,110,253,.15);}
  .at-btn{display:inline-block;width:100%;padding:12px 16px;border:0;border-radius:10px;background:var(--at-blue);color:#fff;font-weight:600;font-size:16px;cursor:pointer;}
  .at-btn:hover{background:var(--at-blue-600);}
  .at-muted{color:var(--at-muted);font-size:14px;text-align:center;margin-top:14px;}
  .at-alert{border:1px solid #fecaca;background:#fef2f2;color:#991b1b;padding:10px 12px;border-radius:10px;font-size:14px;margin-bottom:14px;}
  .at-success{border:1px solid #bbf7d0;background:#ecfdf5;color:#065f46;padding:10px 12px;border-radius:10px;font-size:14px;margin-bottom:14px;}
  .at-radio{display:flex;gap:12px;margin:6px 0 12px;}
  .at-radio label{font-size:14px;color:var(--at-text);}
</style>

<div class="at-container">
  <div class="at-card">
    <div class="at-title">Account</div>

    {{-- Tabs --}}
    @php($active = $tab ?? 'login')
    <div class="at-tabs">
      <a class="at-tab {{ $active==='login' ? 'active' : '' }}" href="{{ route('auth.page', ['tab'=>'login']) }}">Log in</a>
      <a class="at-tab {{ $active==='register' ? 'active' : '' }}" href="{{ route('auth.page', ['tab'=>'register']) }}">Sign up</a>
    </div>

    {{-- Success after registration --}}
    @if (session('created') && $active==='login')
      <div class="at-success">Account created — please log in.</div>
    @endif

    {{-- Errors --}}
    @if ($errors->any())
      <div class="at-alert">{{ $errors->first() }}</div>
    @endif

    {{-- LOGIN FORM --}}
    @if ($active==='login')
      <form method="post" action="{{ route('login.post') }}" autocomplete="on" novalidate>
        @csrf
        <input class="at-field" name="email" type="email" placeholder="Email" required value="{{ old('email') }}">
        <input class="at-field" name="password" type="password" placeholder="Password" required>
        <button class="at-btn" type="submit">Log in</button>
      </form>

      <div class="at-muted" style="margin-top:10px;">
        New here? <a href="{{ route('auth.page', ['tab'=>'register']) }}" style="color:var(--at-blue);text-decoration:none;">Create an account</a>
      </div>
    @endif

    {{-- REGISTER FORM --}}
    @if ($active==='register')
      <form method="post" action="{{ route('register.post') }}" novalidate>
        @csrf
        <div class="at-radio">
          <label><input type="radio" name="role" value="buyer" {{ old('role','buyer')==='buyer' ? 'checked' : '' }}> Buyer</label>
          <label><input type="radio" name="role" value="seller" {{ old('role')==='seller' ? 'checked' : '' }}> Seller</label>
        </div>
        <input class="at-field" name="name" placeholder="Name" value="{{ old('name') }}" required>
        <input class="at-field" name="email" type="email" placeholder="Email" value="{{ old('email') }}" required>
        <input class="at-field" name="password" type="password" placeholder="Password (min 6)" required>
        <button class="at-btn" type="submit">Create account</button>
      </form>

      <div class="at-muted" style="margin-top:10px;">
        Have an account? <a href="{{ route('auth.page', ['tab'=>'login']) }}" style="color:var(--at-blue);text-decoration:none;">Log in</a>
      </div>
    @endif
  </div>
</div>
@endsection
