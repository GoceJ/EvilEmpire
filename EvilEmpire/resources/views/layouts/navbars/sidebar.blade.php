<div class="sidebar esidebar">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo esidebar p-0" style="cursor: default;">
    <!-- <span class="simple-text logo-normal">
      {{ __('Administrator') }}
    </span> -->
    <img class="w-100" src="{{ asset('images/evilempirelogoLogo2.png') }}" alt="">
  </div>

  {{-- Menu --}}
  <div class="sidebar-wrapper esidebar">
    <ul class="nav">

      {{-- Dashboard --}}
      <li class="nav-item {{ $activePage == 'dashboard' ? 'active' : '' }}">
        <a class="nav-link egraytext" href="{{ route('home') }}">
          <i class="material-icons egraytext">dashboard</i>
            <p class="">{{ __('Dashboard') }}</p>
        </a>
      </li>

      {{-- Match Export Controller --}}
      <li class="nav-item{{ $activePage == 'matchExport' ? ' active' : '' }}">
        <a class="nav-link egraytext" href="{{ route('matchExportController.index') }}">
          @include('layouts.actions.icon', ['icon' => 'collections'])
            <p>{{ __('Match Export') }}</p>
        </a>
      </li>

      {{-- Bet Data Export Controller --}}
      <li class="nav-item{{ $activePage == 'footballBetDataExport' ? ' active' : '' }}">
        <a class="nav-link egraytext" href="{{ route('footballBetDataExport.index') }}">
          @include('layouts.actions.icon', ['icon' => 'sports_soccer'])
           <!-- <img src="{{ asset('/images/icons/footballBet.png') }}" style=" width: 30px; margin-right: 15px; " alt=""> -->
            <p>{{ __('Football Bet Data') }}</p>
        </a>
      </li>

      {{-- Ajax Error Controller --}}
      <li class="nav-item{{ $activePage == 'ajaxError' ? ' active' : '' }}">
        <a class="nav-link egraytext" href="{{ route('ajaxerror.index') }}">
          @include('layouts.actions.icon', ['icon' => 'collections'])
            <p>{{ __('Ajax Error') }}</p>
        </a>
      </li>

      {{-- Calendar --}}
      <li class="nav-item{{ $activePage == 'calendar' ? ' active' : '' }}">
        <a class="nav-link egraytext" href="{{ route('events.index') }}">
          @include('layouts.actions.icon', ['icon' => 'event'])
            <p>{{ __('Calendar') }}</p>
        </a>
      </li>

      {{-- Profile Manager --}}
      <li class="nav-item egraytext {{ ($activePage == 'profile' || $activePage == 'user-managment') ? ' active' : '' }}">
        <a class="nav-link egraytext {{ ($activePage == 'profile' || $activePage == 'user-managment') ? '' : 'collapsed' }} " data-toggle="collapse" href="#laravelExample" aria-expanded="{{ ($activePage == 'profile' || $activePage == 'user-managment') ? 'true' : 'false' }}">
          <i style="width:25px" class="egraytext">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
          </i>
          <p>{{ __('Profile Manager') }}
            <b class="caret"></b>
          </p>
        </a>
        
        <div class="collapse {{ ($activePage == 'profile' || $activePage == 'user-managment') ? 'show' : '' }}" id="laravelExample">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
              <a class="nav-link egraytext" href="{{ route('profile.edit') }}">
                <span class="sidebar-mini"><i class="material-icons">perm_contact_calendar</i></span>
                <span class="sidebar-normal">{{ __('User profile') }} </span>
              </a>
            </li>
            <li class="nav-item egraytext {{ $activePage == 'user-managment' ? ' active' : '' }}">
              <a class="nav-link egraytext" href="{{ route('user.index') }}">
                <span class="sidebar-mini"><i class="material-icons">manage_accounts</i></span>
                <span class="sidebar-normal"> {{ __('User Management') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>

    </ul>
  </div>
</div>
