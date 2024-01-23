<div class="sidebar" data-color="rose" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo" style="cursor: default;">
    <span class="simple-text logo-normal">
      {{ __('Administrator') }}
    </span>
  </div>

  {{-- Menu --}}
  <div class="sidebar-wrapper">
    <ul class="nav">

      {{-- Dashboard --}}
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>

      {{-- Profile Manager --}}
      <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-managment') ? ' active' : '' }}">
        <a class="nav-link {{ ($activePage == 'profile' || $activePage == 'user-managment') ? '' : 'collapsed' }} " data-toggle="collapse" href="#laravelExample" aria-expanded="{{ ($activePage == 'profile' || $activePage == 'user-managment') ? 'true' : 'false' }}">
          <i style="width:25px">
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
              <a class="nav-link" href="{{ route('profile.edit') }}">
                <span class="sidebar-mini"><i class="material-icons">perm_contact_calendar</i></span>
                <span class="sidebar-normal">{{ __('User profile') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'user-managment' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('user.index') }}">
                <span class="sidebar-mini"><i class="material-icons">manage_accounts</i></span>
                <span class="sidebar-normal"> {{ __('User Management') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>

      {{-- Posts --}}
      <li class="nav-item{{ $activePage == 'posts' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('post.index') }}">
          @include('layouts.actions.icon', ['icon' => 'content_paste'])
            <p>{{ __('Posts') }}</p>
        </a>
      </li>

      {{-- Match Export Controller --}}
      <li class="nav-item{{ $activePage == 'matchExport' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('matchExportController.index') }}">
          @include('layouts.actions.icon', ['icon' => 'collections'])
            <p>{{ __('Match Export') }}</p>
        </a>
      </li>

      {{-- Calendar --}}
      <li class="nav-item{{ $activePage == 'calendar' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('events.index') }}">
          @include('layouts.actions.icon', ['icon' => 'event'])
            <p>{{ __('Calendar') }}</p>
        </a>
      </li>

    </ul>
  </div>
</div>
