@extends('layouts.app', ['activePage' => 'NameOfYourPageHere', 'titlePage' => __('NameOfYourPageHere')])


@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      {{-- Form 1 --}}
      <div class="col-md-12">
        <form method="post" action="{{ route('post.update', ['post' => $post->id]) }}" autocomplete="off" class="form-horizontal">
          @csrf
          @method('put')

          {{-- Post Edit --}}
          <div class="card ">
            <div class="card-header card-header-primary">
              <h4 class="card-title">{{ __('EditPost') }}</h4>
              <p class="card-category">{{ __('PostInformation') }}</p>
            </div>
            <div class="card-body ">

              {{-- Season Message --}}
              {{--  called from controller >>> return back()->withStatus(__('Profile successfully updated.')); --}}
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

              {{-- Title edit --}}
              <div class="row">
                <label class="col-sm-2 col-form-label">{{ __('Title') }}</label>
                <div class="col-sm-10">
                  <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                    <input  class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" 
                            name="title" 
                            id="input-title" 
                            type="text" 
                            placeholder="{{ __('Title') }}" 
                            value="{{ $post->title }}" 
                            required="true" 
                            aria-required="true"/>

                    @if ($errors->has('title'))
                      <span class="error text-danger" 
                            id="title-error" 
                            for="input-title">{{ $errors->first('title') }}</span>

                    @endif
                  </div>
                </div>
              </div>

              {{-- Description edit --}}
              <div class="row">
                <label class="col-sm-2 col-form-label">{{ __('Description') }}</label>
                <div class="col-sm-10">
                  <div class="form-group{{ $errors->has('desc') ? ' has-danger' : '' }}">
                    <input  class="form-control{{ $errors->has('desc') ? ' is-invalid' : '' }}" 
                            name="desc" 
                            id="input-desc" 
                            type="text" 
                            placeholder="{{ __('Description') }}" 
                            value="{{ $post->desc }}" required />

                    @if ($errors->has('desc'))
                      <span id="desc-error" 
                            class="error text-danger" 
                            for="input-desc">{{ $errors->first('desc') }}</span>

                    @endif
                  </div>
                </div>
              </div>
              
            </div>

            {{-- Footer Submit Save Button --}}
            <div class="card-footer ml-auto mr-auto">
              <button type="submit" class="btn btn-primary m-2">{{ __('Save') }}</button>
              <a href="{{ route('post.index') }}" class="btn btn-warning m-2">{{ __('Back') }}</a>
            </div>

          </div>
        </form>
      </div>
      {{-- Form 1 End --}}

    </div>
  </div>
</div>
@endsection