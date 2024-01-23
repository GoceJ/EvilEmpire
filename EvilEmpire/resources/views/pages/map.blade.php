@extends('layouts.app', ['activePage' => 'map', 'titlePage' => __('Map')])

@section('content')
<div id="map"></div>
@endsection

@push('js')
<script src="https://maps.googleapis.com/maps/api/js?sensor=false&callback=myMap"></script>
<script>
  $(document).ready(function() {
    // Javascript method's body can be found in assets/js/demos.js
    demo.initGoogleMaps();
  });
</script>
@endpush