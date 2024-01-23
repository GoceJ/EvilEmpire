@if (isset($e))
    <a rel="tooltip" class="btn btn-success btn-link p-1 m-1" href="{{ $e }}">
        <i class="material-icons">edit</i>
        <div class="ripple-container"></div>
    </a>
@endif

@if (isset($v))
    <a rel="tooltip" class="btn btn-primary btn-link p-1 m-1" href="{{ $v }}">
        <i class="material-icons">visibility</i>
        <div class="ripple-container"></div>
    </a>
@endif

@if (isset($d))
    <form action="{{ $d }}" method="post" style="display: inline;">
        @csrf
        @method('DELETE')
        <input type="submit" class="form-delete" id="{{ $d }}" value="" hidden>
        <label rel="tooltip" class="btn btn-danger btn-link m-1 p-1" for="{{ $d }}">
            <i class="material-icons">delete</i>
            <div class="ripple-container"></div>
        </label>
    </form>
@endif


