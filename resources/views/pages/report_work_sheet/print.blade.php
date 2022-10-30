@extends('layouts.print')

@section('header')
<h4>{{ __('Report') }} Worksheet</h4>
<div class="header-action">
    <nav>
        <a onclick="window.print()" href="{{ route(SharedData::get('route').'.getPrint') }}">Print PDF</a>
        <a href="{{ route(SharedData::get('route').'.getExcel') }}">Excel</a>
        <a href="{{ route(SharedData::get('route').'.getCsv') }}">Csv</a>
    </nav>
</div>
@endsection

@section('content')
@includeIf(Template::form(SharedData::get('template'),'data'))
@endsection