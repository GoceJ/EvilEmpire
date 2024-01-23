<form action="{{ $route }}" method="post" style="display: inline;">
    @csrf
    @method('DELETE')
    <input type="submit" class="form-delete" id="{{ $route }}" value="" hidden>
    <label rel="tooltip" class="btn btn-danger btn-link" for="{{ $route }}">
        <i class="material-icons">delete</i>
        <div class="ripple-container"></div>
    </label>
</form>

