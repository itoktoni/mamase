@extends(Template::master())

@section('title')
    <h4>Master Alat</h4>
@endsection

@section('action')
    <div class="button">
        <button type="submit" class="btn btn-primary" id="modal-btn-save">{{ __('Save') }}</button>
        @if ($model->product_id)
		<a href="{{ route('product.getPrint', ['code' => $model->product_id]) }}" class="print-file btn btn-danger">Print</a>
        @endif
    </div>
@endsection

@section('container')
    {!! Template::form_open($model) !!}

    @if (!request()->ajax())
        <div class="page-header">
            <div class="header-container container-fluid d-sm-flex justify-content-between">
                @yield('title')
                @yield('action')
            </div>
        </div>
    @endif

    @include('pages.product.partial')

    {!! Template::form_close() !!}
@endsection

@push('javascript')
    @include(Template::components('form'))
    @include(Template::components('date'))

    <script>
        function sendUrlToPrint(url) {
            var beforeUrl = 'intent:';
            var afterUrl = '#Intent;';
            // Intent call with component
            afterUrl += 'component=ru.a402d.rawbtprinter.activity.PrintDownloadActivity;'
            afterUrl += 'package=ru.a402d.rawbtprinter;end;';
            document.location = beforeUrl + encodeURI(url) + afterUrl;
            return false;
        }
        // jQuery: set onclick hook for css class print-file
        $(document).ready(function() {
            $('.print-file').click(function() {
                return sendUrlToPrint($(this).attr('href'));
            });
        });

        function BtPrint(prn) {
            alert('juga');
            var S = "#Intent;scheme=rawbt;";
            var P = "package=ru.a402d.rawbtprinter;end;";
            var textEncoded = encodeURI(prn);
            window.location.href = "intent:" + textEncoded + S + P;
        }
    </script>
@endpush
