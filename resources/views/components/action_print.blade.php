@if(request()->get('action') == 'excel')
@php
header('Content-Type: application/force-download');
header('Content-disposition: attachment; filename=excel.xls');
// Fix for crappy IE bug in download.
header("Pragma: ");
header("Cache-Control: ");
@endphp
@else
<div class="header-action">
    <nav>
        <a onclick="window.print()" href="{{ route(SharedData::get('route').'.getPrint') }}">Print PDF</a>
        <a href="{{ url()->full().'&action=excel' }}">Excel</a>
        <a href="{{ route(SharedData::get('route').'.getCreate') }}">Back</a>
    </nav>
</div>
@endif

<style>

	h3{
		text-align: center;
		font-size: 18px;
		margin-bottom: 0px;
	}
	h5{
		text-align: center;
		margin: 0px;
		font-size: 20px;
	}
</style>