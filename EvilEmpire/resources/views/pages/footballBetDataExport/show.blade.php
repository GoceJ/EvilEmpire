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

            <input type="button" id="close" onclick="window.close()" value="asdasdsa"/>

            <pre>
            {{ print_r($data) }}
              @foreach ($data as $value)
              <pre>
                
              @endforeach
            </pre>
            
            
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
    
  </div>
</div>
@endsection