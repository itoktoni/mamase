@if(request()->ajax())
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#modal-btn-save').click(function (event) {
    event.preventDefault();

    var form = $('#modal-body form'),
        url = form.attr('action');

    form.find('.help-block').remove();
    form.find('.form-group').removeClass('has-error');

    $.ajax({
        url : url,
        method: 'POST',
        dataType  : 'json',
        data : form.serialize(),
        success: function (response) {
            if(response.status){
                form.trigger('reset');
                $('#modal').modal('hide');
                toastr.success('Data has been Saved !');
                window.location.reload();
            }
            if(response.data){
                swal({
                    icon : 'error',
                    title : 'Error!',
                    text : response.data,
                });
            }
            else{
                swal({
                    icon : 'error',
                    title : 'Error!',
                    text : response,
                });
            }

        },
        error: function(xhr, status, error) {
            var res = xhr.responseJSON;
            if ($.isEmptyObject(res) == false) {
                $.each(res.errors, function (key, value) {
                    $('#' + key)
                        .closest('.form-group')
                        .addClass('has-error')
                        .append('<span class="help-block">*' + value + '</span>');
                });
            }
        }
    })
});
</script>
@endif