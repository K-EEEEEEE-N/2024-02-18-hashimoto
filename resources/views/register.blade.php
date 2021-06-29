@extends('layouts.app')

@section('main')
@if (session('result'))
<div class="flash_message">
  {{ session('result') }}
</div>
@endif
<h2 class="main-ttl">会員登録</h2>
<form action="/register" method="post">
  @csrf
  <div class="input-container">
    <input type="text" placeholder="名前" name="name" value="{{ old('name') }}">
    @error('name')
    <p>{{ $message }}</p>
    @enderror
  </div>
  <div class="input-container">
    <input type="email" placeholder="メールアドレス" name="email" value="{{ old('email') }}">
    @error('email')
    <p>{{ $message }}</p>
    @enderror
  </div>
  <div class="input-container">
    <input type="password" placeholder="パスワード" name="password">
    @error('password')
    <p>{{ $message }}</p>
    @enderror
  </div>
  <div class="input-container">
    <input type="password" placeholder="確認用パスワード" name="password_confirmation">
    @error('password_confirmation')
    <p>{{ $message }}</p>
    @enderror
  </div>
  <div class="btn-container">
    <input type="submit" value="会員登録">
  </div>
</form>
<p class="transition-txt">アカウントをお持ちの方はこちらから</p>
<a class="transition-link" href="/login">ログイン</a>
@endsection