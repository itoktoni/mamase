@extends(Template::ajax())

@section('title') Setting System @endsection

@section('form')

@if(isset($model))
{!! Form::model($model, ['route'=>[SharedData::get('route').'.postUpdate', 'code' =>
$model->{$model->getKeyName()}],'class'=>'form-horizontal needs-validation' , 'files'=>true]) !!}
@else
{!! Form::open(['url' => route(SharedData::get('route').'.postCreate'), 'class' => 'form-horizontal needs-validation',
'files' => true]) !!}
@endif

@endsection

@section('container')

<div class="row">

	<div class="col-md-6">

		<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
			<label>{{ __('Name') }}</label>
			{!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder'
			=> 'Please fill this input', 'required']) !!}
			{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
		</div>

		<div class="form-group">
			<label>{{ __('Description') }}</label>
			{!! Form::textarea('description', null, ['class' => 'form-control h-auto', 'id' =>
			'description',
			'placeholder' => 'Please fill this input', 'rows' => 5]) !!}
		</div>
	</div>

	<div class="col-md-6">

		<div class="form-group {{ $errors->has('upload_logo') ? 'has-error' : '' }}">
			<img class="img-fluid img-thumbnail mb-2" src="{{ url('storage/'.env('APP_LOGO')) }}" alt="">
			<label>Logo</label>
			<input type="file" class="file" data="APP_LOGO" name="file" />
			<input class="logo" type="hidden" value="{{ env('APP_LOGO') }}" name="logo">
		</div>

		<div class="form-group {{ $errors->has('upload_logo') ? 'has-error' : '' }}">
			<label>Header Print</label>
			<input type="file" class="file" data="APP_HEADER" name="file" />
			<input class="header" type="hidden" value="{{ env('APP_HEADER') }}" name="header">
		</div>

	</div>

</div>



@endsection

@section('action')
<div class="button">
	<button type="submit" class="btn btn-primary" id="modal-btn-save">{{ __('Save') }}</button>
</div>
@endsection

@section('javascript')
@include(Template::components('form'))
@endsection

@component(Template::components('date'))
@endcomponent

@push('footer')

<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />

<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>

<script>
$(function() {

	$.fn.filepond.registerPlugin(FilePondPluginImagePreview);
	$('.file').filepond({
		server: {
			url: '{{ route("upload") }}',
			process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {

				const formData = new FormData();
				formData.append(fieldName, file, file.name);
				console.log(file.data);

				const request = new XMLHttpRequest();
				request.open('POST', '{{ route("upload", ["_token" => csrf_token()]) }}');

				request.upload.onprogress = (e) => {
					progress(e.lengthComputable, e.loaded, e.total);
				};

				request.onload = function() {
					if (request.status >= 200 && request.status < 300) {

						// if(fieldName == 'file_logo'){
						// 	$('.logo').val(request.responseText);
						// }
						// if(fieldName == 'file_header'){
						// 	$('.header').val(request.responseText);
						// }

						window.location.reload();

						load(load);

					} else {
						alert('Error Upload !');
					}
				};

				request.send(formData);

			},
			revert: null,
			restore: null,
			load: null,
			fetch: null,
		},
	});

});
</script>

@endpush