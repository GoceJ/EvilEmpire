@extends('layouts.app', ['activePage' => 'posts', 'titlePage' => __('Posts')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">

          {{-- Card Header --}}
          <div class="card-header card-header-primary">
            <h4 class="card-title ">View Post {{ $post->title }}</h4>
            <p class="card-category">Information for post number {{ $post->id }}</p>
          </div>

          {{-- Card Body --}}
          <div class="card-body">
            <div class="table-responsive">

              {{-- Title --}}
              <div class="row mx-0 my-2">
                <p class="col-md-2 col-form-label">{{ __('Title:') }}</p>
                <div class="col-md-10 border-left">
                    <p class="col-form-label">{{ $post->title }}</p>
                </div>
              </div>

              <hr>

              {{-- Description --}}
              <div class="row mx-0 my-2">
                <p class="col-md-2 col-form-label ">{{ __('Description:') }}</p>
                <div class="col-md-10 border-left">
                    <p class="col-form-label">{{ $post->desc }}</p>
                </div>
              </div>

            </div>
          </div>

          <div class="card-footer ml-auto mr-auto">
            <a href="{{ route('post.index') }}" class="btn btn-warning m-2">{{ __('Back') }}</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection