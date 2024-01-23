@extends('layouts.app', ['activePage' => 'images', 'titlePage' => __('Images')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">View Image</h4>
            <p class="card-category">Information for image</p>
          </div>
          <div class="card-body">
            <div class="table-responsive" style="overflow-x: hidden">

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

              {{-- Title --}}
              <div class="row mx-0 my-2">
                <p class="col-md-2 col-form-label">{{ __('Title:') }}</p>
                <div class="col-md-10 border-left">
                    <p class="col-form-label">Image title 1</p>
                </div>
              </div>

              {{-- include this tag after every new input --}}
              <hr>

              {{-- Title --}}
              <div class="row mx-0 my-2">
                <p class="col-md-2 col-form-label">{{ __('Description:') }}</p>
                <div class="col-md-10 border-left">
                    <p class="col-form-label">Some description ...</p>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="img-galery">
      @foreach ($images as $img)
        <div class="img-galery-children">
          <div class="card card-chart">
            <div class="card-header card-header-warning">
              <img style="width: 100%" src="{{ asset($img->img) }}" alt="">
            </div>
            <div class="card-body text-center">
              <form action="{{ route('image.destroy', ['image' => $img->id]) }}" method="post" style="display: inline;">
                  @csrf
                  @method('DELETE')
                  <input type="submit" class="form-delete" id="{{ $img->id }}" value="" hidden>
                  <label rel="tooltip"  class="btn btn-primary btn-link m-1 p-1" for="{{ $img->id }}">
                      <i style="font-size: 1.5rem !important;" class="material-icons">delete_outline</i>
                      <div class="ripple-container"></div>
                  </label>
              </form>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    
  </div>
</div>
@endsection