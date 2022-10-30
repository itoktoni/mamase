<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function showModal(url, size) {
    size = (typeof size == 'undefined' || size == '') ? 'modal-lg' : size;
    $.ajax({
        url: url,
        success: function(response) {

            $('#modal-body').html(response);
            $('#modal').modal({
                backdrop: 'static',
                keyboard: false
            });
            $('.modal-dialog').addClass(size);
        },
        complete: function() {
            // $('#loader').hide();
        },
        error: function(jqXHR, testStatus, error) {
            console.log(error);
            alert("Page " + href + " cannot open. Error:" + error);
            $('#loader').hide();
        },
        timeout: 8000
    });
}

$('body').on('click', '.button-update', function(event) {
    event.preventDefault();
    showModal($(this).attr('href'), $(this).attr('size'));
});

$('body').on('click', '.button-create', function(event) {
    event.preventDefault();
    showModal($(this).attr('href'), $(this).attr('size'));
});

$('body').on('click', '.button-delete', function(event) {
    event.preventDefault();

    var me = $(this),
        url = me.attr('href'),
        id = me.attr('data'),
        csrf_token = $('meta[name="csrf-token"]').attr('content');

    swal({
        title: '{{ __("Are you sure want to delete this data ?") }}',
        text: '{{ __("You not be able to revert this!") }}',
        icon: "warning",
        buttons: true,
    }).then((result) => {
        if (result) {
            $.ajax({
                url: url,
                type: "POST",
                dataType: 'json',
                data: {
                    'id': id
                },
                success: function(response) {
                    if (response.status) {
                        swal({
                            icon: 'success',
                            title: '{{ __("Success!") }}',
                            text: '{{ __("Data has been deleted!") }}',
                            timer: 3000
                        }).then(function() {
                            window.location.reload();
                        });

                    } else if (response.status == false) {
                        swal({
                            icon: 'error',
                            title: '{{ __("Error!") }}',
                            text: response.data
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: '{{ __("Error!") }}',
                            text: '{{ __("Data failed to deleted!") }}'
                        });
                    }
                },
                error: function(xhr, status, error) {

                    if (xhr.status == 422) {

                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: '{{ __("Validation Error !") }}'
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: '{{ __("Something went wrong!") }}'
                        });
                    }
                }
            });
        } else {

        }
    });
});

$('body').on('click', '.button-sort', function(event) {
    event.preventDefault();

    var me = $(this),
        url = me.attr('href'),
        csrf_token = $('meta[name="csrf-token"]').attr('content');

        var data = [];
        $('.sort').each(function() {
            data.push({'key' : $(this).attr('key'), 'value' : $(this).val()});
        });

    swal({
        title: 'Are you sure want sort Data ?',
        text: 'You won\'t be able to revert this!',
        icon: "info",
        buttons: true,
    }).then((result) => {
        if (result) {
            $.ajax({
                url: url,
                type: "POST",
                dataType: 'json',
                data: {
                    'sort': data
                },
                success: function(response) {
                    if (response.status) {
                        swal({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Data has been sorted!',
                            timer: 3000
                        }).then(function() {
                            window.location.reload();
                        });

                    } else if (response.status == false) {
                        swal({
                            icon: 'error',
                            title: 'Error!',
                            text: response.data
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Data failed to deleted!'
                        });
                    }
                },
                error: function(xhr, status, error) {

                    if (xhr.status == 422) {

                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Validation Error !'
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!'
                        });
                    }
                }
            });
        } else {

        }
    });
});

$('body').on('click', '.button-delete-all', function(event) {
    event.preventDefault();

    var me = $(this),
        url = me.attr('href'),
        id = me.attr('data'),
        csrf_token = $('meta[name="csrf-token"]').attr('content');

    var data = [];
    $('.checkbox').each(function() {
        if ($(this).is(":checked")) {
            data.push($(this).val());
        }
    });

    if(data.length == 0){
        swal({
            icon: 'error',
            title: 'Oops...',
            text: 'Select Data terlebih dahulu !'
        });

        return;
    }

    swal({
        title: 'Are you sure want to delete this data ?',
        text: 'You won\'t be able to revert this!',
        icon: "warning",
        buttons: true,
    }).then((result) => {
        if (result) {
            $.ajax({
                url: url,
                type: "POST",
                dataType: 'json',
                data: {
                    'code': data
                },
                success: function(response) {
                    if (response.status) {
                        swal({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Data has been deleted!',
                            timer: 3000
                        }).then(function() {
                            window.location.reload();
                        });

                    } else if (response.status == false) {
                        swal({
                            icon: 'error',
                            title: 'Error!',
                            text: response.data
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Data failed to deleted!'
                        });
                    }
                },
                error: function(xhr, status, error) {

                    if (xhr.status == 422) {

                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Validation Error !'
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!'
                        });
                    }
                }
            });
        } else {

        }
    });
});
</script>