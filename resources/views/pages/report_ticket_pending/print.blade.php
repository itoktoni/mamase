@extends('layouts.print')

@section('header')

@component('components.action_print')
@endcomponent

@endsection

@section('content')
@includeIf(Template::form(SharedData::get('template'),'data'))
@endsection