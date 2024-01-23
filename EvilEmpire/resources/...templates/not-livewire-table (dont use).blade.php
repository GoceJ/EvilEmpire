@extends('layouts.app', ['activePage' => 'posts', 'titlePage' => __('Posts')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Posts</h4>
            <p class="card-category">Posts information table</p>
          </div>
          <div class="card-body">
            <div class="table-responsive">

              {{-- Code in controller for this alert --}}
              {{-- ->withStatus(__('Profile successfully updated.')) --}}
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

              {{-- Table --}}
              <table class="table text-center">
                {{-- Table Head --}}
                <thead class=" text-primary">
                  <th>ID</th>
                  <th>Title</th>
                  <th>Action</th>
                </thead>

                {{-- Table Body --}}
                <tbody>
                  @foreach ($posts as $post)
                    <tr>
                      {{-- content here --}}

                      <td class="td-actions">
                        {{-- action edit --}}
                        @include('layouts.actions.action', ['icon' => 'edit', 'color' => 'success', 'route' => route('post.edit', ['post' => $post->id])])

                        {{-- action delete --}}
                        @include('layouts.actions.delete', ['route' => route('post.destroy', ['post' => $post->id])] )

                        {{-- action view --}}
                        @include('layouts.actions.action', ['icon' => 'visibility', 'color' => 'danger', 'route' => route('post.show', ['post' => $post->id])])
                      </td>

                    </tr>
                  @endforeach
                </tbody>
              </table>

              {{-- pagination --}}
              <nav aria-label="Page navigation example">
                <ul class="pagination">
                    {{ $posts->links() }}
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection