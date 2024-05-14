@extends(Template::master())

@section('title')
<h4>Master Category</h4>
@endsection

@section('action')
<div class="button">
	<button type="submit" class="btn btn-primary" id="modal-btn-save">{{ __('Save') }}</button>
</div>
@endsection

@section('container')

{!! Template::form_open($model) !!}

@if(!request()->ajax())
<div class="page-header">
	<div class="header-container container-fluid d-sm-flex justify-content-between">
		@yield('title')
		@yield('action')
	</div>
</div>
@endif

<div class="card">
	<div class="card-body">

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>Category</label>
					{{ Form::select('model_category_id', $category, null, ['class'=> 'form-control', 'placeholder' => '- Pilih Category -']) }}
				</div>
				<div class="form-group {{ $errors->has('model_group') ? 'has-error' : '' }}">
					<label>{{ __('Name') }}</label>
					{!! Form::text('model_group', null, ['class' => 'form-control', 'id' => 'model_group',
					'placeholder'
					=> 'Please fill this input', 'required']) !!}
					{!! $errors->first('model_group', '<p class="help-block">:message</p>') !!}
				</div>
				<div class="form-group">
					<label>Type</label>
					{{ Form::select('model_type_id', $product_type, null, ['class'=> 'form-control', 'placeholder' => '- Pilih Tipe -']) }}
				</div>
				<div class="form-group">
					<label>Merek</label>
					{{ Form::select('model_brand_id', $brand, null, ['class'=> 'form-control', 'placeholder' => '- Pilih Merek -']) }}
				</div>
				<div class="form-group">
					<label>Unit</label>
					{{ Form::select('model_unit_id', $unit, null, ['class'=> 'form-control', 'placeholder' => '- Pilih Satuan -']) }}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label>{{ __('Description') }}</label>
					{!! Form::textarea('model_description', null, ['class' => 'form-control h-auto', 'id' =>
					'model_description',
					'placeholder' => 'Please fill this input', 'rows' => 5]) !!}
				</div>

				<div class="form-group {{ $errors->has('file_picture') ? 'has-error' : '' }}">

					<label for="">{{ __('Ambil Gambar') }}</label>
					<input id="cameraFileInput" name="file_picture" type="file" accept="image/*"
						class="btn btn-default btn-block" capture="environment" />

					<input type="hidden" name="file_old" value="{{ $model->field_image ?? null }}">
					<img class="img-fluid" style="margin-top: 10px"
						src="{{ $model && $model->field_image ? asset('files/model/'.$model->field_image) : asset('images/picture.png') }}"
						id="pictureFromCamera" />
				</div>
			</div>

		</div>

	</div>
</div>

{!! Template::form_close() !!}

@endsection

@push('javascript')
@include(Template::components('form'))
@endpush