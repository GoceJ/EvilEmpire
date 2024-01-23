<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script>
    $(function() {
        document.querySelectorAll('.form-delete').forEach(formElement => {
            $(formElement).on('click', function (e) {
                e.preventDefault();
                // let url = $(this).parent().attr('action')
                // let del = false;
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "error",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then(result => {
                    if (result.value) {
                        $(this).parent().submit()
                    }
                });
            })
        })
    })
</script>