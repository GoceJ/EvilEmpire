<div class="wrapper ebackground" >
  @include('layouts.navbars.sidebar')
  <div class="main-panel ebackground">
    @include('layouts.navbars.navs.auth')
    @yield('content')
  </div>
</div>