@extends('layouts.app', ['activePage' => 'NameOfYourPageHere', 'titlePage' => __('NameOfYourPageHere')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">

          {{-- Card Header --}}
          <div class="card-header card-header-primary">
            <h4 class="card-title ">TitleForYourPageHere</h4>
            <p class="card-category">DescriptionForYourPageHere</p>
          </div>

          {{-- Card Body --}}
          <div class="card-body">
            <div class="table-responsive">

              {{-- Title --}}
              <div class="row mx-0 my-2">
                <p class="col-md-2 col-form-label">{{ __('Title:') }}</p>
                <div class="col-md-10 border-left">
                    <p class="col-form-label">TitleFromYourPost</p>
                </div>
              </div>

              {{-- Include this tag after every new display --}}
              <hr>

              {{-- Description --}}
              <div class="row mx-0 my-2">
                <p class="col-md-2 col-form-label ">{{ __('Description:') }}</p>
                <div class="col-md-10 border-left">
                    <p class="col-form-label">DescriptionFromYourPost</p>
                </div>
              </div>

            </div>
          </div>

          <div class="card-footer ml-auto mr-auto">
            <a href="{{ route('YourPageNormalRoute') }}" class="btn btn-warning m-2">{{ __('Back') }}</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection