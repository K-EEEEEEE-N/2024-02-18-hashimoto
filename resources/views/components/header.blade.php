<header class="header">
  <h1 class="header-ttl">Atte</h1>
  @if( Auth::check() )
  <nav class="header-nav">
    <ul class="header-nav-list">
      <li class="header-nav-item"><a href="/">ホーム</a></li>
      <li class="header-nav-item"><a href="/attendance/0">日付一覧</a></li>
      <li class="header-nav-item"><a href="/logout">ログアウト</a></li>
    </ul>
  </nav>
  @endif
</header>