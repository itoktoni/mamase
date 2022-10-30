@extends(Template::master())

@section('title')
<h4>Master Gedung</h4>
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
				<div class="form-group {{ $errors->has('building_name') ? 'has-error' : '' }}">
					<label>{{ __('Name') }}</label>
					{{ Template::text('building_name') }}
					{!! $errors->first('building_name', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label>{{ __('Description') }}</label>
					{!! Form::textarea('building_description', null, ['class' => 'form-control', 'id' =>
					'building_description',
					'placeholder' => 'Please fill this input', 'rows' => 5]) !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label>Contact Person</label>
					{!! Form::text('building_contact_person', null, ['class' => 'form-control', 'id' =>
					'building_contact_person', 'placeholder' => 'Please fill this input']) !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label>Contact Phone</label>
					{!! Form::text('building_contact_phone', null, ['class' => 'form-control', 'id' =>
					'building_contact_phone',
					'placeholder' => 'Please fill this input']) !!}
				</div>
			</div>

			<div class="col-md-12">
				<div class="form-group">
					<label>Building Address</label>
					{!! Form::textarea('building_address', null, ['class' => 'form-control', 'id' => 'building_address',
					'placeholder' => 'Please fill this input']) !!}
				</div>
			</div>
		</div>

		<hr>

		<div class="row">

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('building_jumlah_lantai') ? 'has-error' : '' }}">
					<label>{{ __('Jumlah Lantai') }}</label>
					{{ Template::text('building_jumlah_lantai') }}
					{!! $errors->first('building_jumlah_lantai', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('building_luas_bangunan') ? 'has-error' : '' }}">
					<label>{{ __('Luas Bangunan') }}</label>
					{{ Template::text('building_luas_bangunan') }}
					{!! $errors->first('building_luas_bangunan', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('building_nomer_imb') ? 'has-error' : '' }}">
					<label>{{ __('Nomer IMB') }}</label>
					{{ Template::text('building_nomer_imb') }}
					{!! $errors->first('building_nomer_imb', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('building_nomer_ipb') ? 'has-error' : '' }}">
					<label>{{ __('Nomer IPB/SLF') }}</label>
					{{ Template::text('building_nomer_ipb') }}
					{!! $errors->first('building_nomer_ipb', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label>Tahun Pendirian</label>
					{!! Form::text('building_tahun_pendirian', null, ['class' => 'form-control', 'id' =>
					'building_tahun_pendirian', 'placeholder' => 'Please fill this input']) !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label>Tahun Renovasi</label>
					{!! Form::text('building_tahun_renovasi', null, ['class' => 'form-control', 'id' =>
					'building_tahun_renovasi',
					'placeholder' => 'Please fill this input']) !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label>Sumber Anggaran</label>
					{!! Form::text('building_sumber_anggaran', null, ['class' => 'form-control', 'id' =>
					'building_sumber_anggaran',
					'placeholder' => 'Please fill this input']) !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label>Nilai Anggaran</label>
					{!! Form::text('building_nilai_anggaran', null, ['class' => 'form-control', 'id' =>
					'building_nilai_anggaran',
					'placeholder' => 'Please fill this input']) !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label>Gedung punya basement</label>
					{!! Form::select('building_basement', ['1' => 'Punya', '0' => 'Tidak Punya'], null, ['class' => 'form-control', 'id' =>
					'department_name', 'placeholder' => '- Select Basement -', 'required']) !!}
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