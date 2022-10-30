@if ($errors->any())
<script type="text/javascript">
$(function() {
    toastr.options = {
        timeOut: 5000,
        progressBar: true,
        showMethod: "slideDown",
        hideMethod: "slideUp",
        closeButton: true,
        showDuration: 200,
        hideDuration: 200
    };

    @foreach($errors->all() as $error)
    toastr.error('{{ $error }}');
    @endforeach
});
</script>
@endif

@if(session()->has('success') && !request()->ajax())
<script type="text/javascript">
$(function() {
    toastr.success("{{ session()->get('success') }}");
});
</script>
@php
session()->forget('success');
@endphp
@endif

@if(session()->has('Error') && !request()->ajax())
<script type="text/javascript">
$(function() {
    toastr.error("{{ session()->get('Error') }}");
});
</script>
@php
session()->forget('Error');
@endphp
@endif