@extends(Template::master())

@section('title')
    <h4>Master Alat</h4>
@endsection

@section('action')
    <div class="button">
        <button type="submit" class="btn btn-primary" id="modal-btn-save">{{ __('Save') }}</button>
        @if ($model->product_id)
            <a class="btn btn-primary"
                href="rawbt:data:image/png;base64,{{ BARCODE2D::getBarcodePNG($model->product_serial_number, 'QRCODE') }}">
                picture </a>
			<a class="btn btn-primary"
                href="rawbt:data:application/pdf;base64,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">
                pdf </a>
			<a href="{{ route('print', ['code' => $model->product_id]) }}" class="print-file btn btn-danger">URL</a>
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

    <div class="inner" id="Intent" style="text-align: center;">
        <h5 style="margin-top:10px;font-size:15px;margin-bottom:-5px;">{{ $model->product_name }}</h5>
        <h5 style="margin: 0px auto;text-align:center">
            <img style="margin-top:10px;height:70px"
                src="data:image/png;base64,{{ BARCODE2D::getBarcodePNG($model->product_serial_number, 'QRCODE') }}"
                alt="barcode" />
        </h5>
        <h5 style="margin-top:3px;font-size:15px;margin-bottom:0px">{{ $model->product_serial_number }}</h5>
        <span style="font-size: 10px;margin-botton:0px;position:absolute;bottom:5px;">.</span>
    </div>

    <div class="inner" id="extend" style="text-align: center;">
        <h5 style="margin-top:10px;font-size:15px;margin-bottom:-5px;">{{ $model->product_name }}</h5>
        <h5 style="margin: 0px auto;text-align:center">
            <img style="margin-top:10px;height:70px"
                src="data:image/png;base64,{{ BARCODE2D::getBarcodePNG($model->product_serial_number, 'QRCODE') }}"
                alt="barcode" />
        </h5>
        <h5 style="margin-top:3px;font-size:15px;margin-bottom:0px">{{ $model->product_serial_number }}</h5>
        <span style="font-size: 10px;margin-botton:0px;position:absolute;bottom:5px;">.</span>
    </div>

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
