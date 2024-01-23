{{-- TEMPLATE --}}
<li class="nav-item{{ $activePage == 'NameOfYourPageHERE' ? ' active' : '' }}">
    <a class="nav-link" href="{{ route('RouteOfYourPageHERE') }}">
        @include('layouts.actions.icon', ['icon' => 'IconForYourPageHERE'])
        <p>{{ __('NameOfYourPageHERE') }}</p>
    </a>
</li>
