@extends('layouts.app', ['activePage' => 'user-managment', 'titlePage' => __('User Menagment')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Users</h4>
                            <p class="card-category"> Here you can manage users</p>
                        </div>
                        <div class="card-body">
                            {{-- Add User --}}
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a href="#" class="btn btn-sm btn-primary"><i class="material-icons">person_add</i></a>
                                </div>
                            </div>

                            {{-- User Table --}}
                            <div class="table-responsive" style="overflow-x: hidden;">
                                <livewire:users-table/>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
