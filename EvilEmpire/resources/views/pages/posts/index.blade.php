@extends('layouts.app', ['activePage' => 'posts', 'titlePage' => __('Posts')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        {{-- Card --}}
        <div class="card">
          {{-- Card Header --}}
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Posts</h4>
            <p class="card-category">Posts information table</p>
          </div>

          {{-- Card Body --}}
          <div class="card-body">
            <div class="table-responsive text-center" style="overflow-x: hidden;">
              
              @if (session('status'))
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <i class="material-icons">close</i>
                        </button>
                        <span>{{ session('status') }}</span>
                      </div>
                    </div>
                  </div>
              @endif

              <livewire:post-table/>

            </div>
          </div>
          {{-- Card Body End--}}

        </div>
        {{-- Card end--}}

      </div>
    </div>
  </div>
</div>

{{-- Include this script if there is delete button for sweet alert --}}
@include('layouts.actions.deleteJS')
@endsection