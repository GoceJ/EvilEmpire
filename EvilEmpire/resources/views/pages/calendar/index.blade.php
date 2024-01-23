{{-- BODY TEMPLATE --}}
@extends('layouts.app', ['activePage' => 'calendar', 'titlePage' => __('Calendar')])

@section('content')
<link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.css" />
<link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.css" />
<link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.css" />

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    {{-- Card --}}
                    <div class="card">
                        {{-- Header --}}
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Calendar</h4>
                            <p class="card-category">Create events</p>
                        </div>
                        
                        {{-- Notification when created or edited or deleted --}}
                        <div id="notification"></div>
                        
                        {{-- All things from calendar rendering --}}
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="container grid px-6 mx-auto">
                                    {{-- Calendar render --}}
                                    @include('pages.calendar.calendar')

                                    {{-- Create modal --}}
                                    @include('pages.calendar.create')

                                    {{-- Edit modal --}}
                                    @include('pages.calendar.edit')
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    {{-- Card --}}
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://uicdn.toast.com/tui.code-snippet/v1.5.2/tui-code-snippet.min.js"></script>
    <script src="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.min.js"></script>
    <script src="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.min.js"></script>
    <script src="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.js"></script>
    <script src="{{ asset('js/events/labels.js') }}"></script>
    <script src="{{ asset('js/events/events.js') }}"></script>
    <script src="{{ asset('js/events/actions.js') }}"></script>

@endsection
