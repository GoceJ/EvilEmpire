@extends('layouts.app', ['activePage' => 'ajaxError', 'titlePage' => __('Ajax Error')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="container">
              @foreach($data as $key => $value)
                  {{$key}}
                  {{$value}}
              @endforeach
            </div>
        </div>
    </div>
  </div>
</div>
@endsection