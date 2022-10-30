@extends(Template::master())

@section('title')
<h4>Master Menu</h4>
@endsection

@section('action')
@can(Views::permision('getUpdate'))
<div class="button">
	<button type="submit" class="btn btn-primary" id="modal-btn-save">{{ __('Save') }}</button>
</div>
@endcan
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
				<div class="form-group {{ $errors->has('system_menu_type') ? 'has-error' : '' }}">
					<label>Type</label>
					{!! Form::select('system_menu_type', $type, null, ['class' => 'form-control', 'id' =>
					'product_name', 'placeholder' => '- Select Group -', 'required']) !!}
					{!! $errors->first('system_menu_type', '<p class="help-block">:message</p>') !!}
				</div>

				<div class="form-group {{ $errors->has('system_menu_code') ? 'has-error' : '' }}">
					<label>Code</label>
					{!! Form::text('system_menu_code', null, ['class' => 'form-control', 'id' => 'system_menu_code',
					'placeholder'
					=> 'Please fill this input', 'required']) !!}
					{!! $errors->first('system_menu_code', '<p class="help-block">:message</p>') !!}
				</div>

				<div class="form-group {{ $errors->has('system_menu_name') ? 'has-error' : '' }}">
					<label>{{ __('Name') }}</label>
					{!! Form::text('system_menu_name', null, ['class' => 'form-control', 'id' => 'system_menu_name',
					'placeholder'
					=> 'Please fill this input', 'required']) !!}
					{!! $errors->first('system_menu_name', '<p class="help-block">:message</p>') !!}
				</div>

				<div class="form-group">
					<label>Sort</label>
					{!! Form::text('system_menu_sort', null, ['class' => 'form-control', 'id' =>
					'system_menu_sort',
					'placeholder'
					=> 'Please fill this input', 'required']) !!}
				</div>

			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label>Controller</label>
					{!! Form::text('system_menu_controller', null, ['class' => 'form-control', 'id' =>
					'system_menu_controller',
					'placeholder'
					=> 'Please fill this input', 'required']) !!}
				</div>

				<div class="form-group">
					<label>Action</label>
					{!! Form::text('system_menu_action', null, ['class' => 'form-control', 'id' =>
					'system_menu_action',
					'placeholder'
					=> 'Please fill this input', 'required']) !!}
				</div>

				<div class="form-group">
					<label>{{ __('Description') }}</label>
					{!! Form::textarea('system_menu_description', null, ['class' => 'form-control h-auto', 'id' =>
					'email',
					'placeholder' => 'Please fill this input', 'rows' => 5]) !!}
				</div>
			</div>
		</div>

		@if($model)

		<hr>

		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive" id="table_data">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Code</th>
								<th>Function Name</th>
								<th class="column-action">Reset Name</th>
								<th class="column-action">Show</th>
								<th class="column-action">Active</th>
							</tr>
						</thead>
						<tbody>
							@forelse(old('detail') ?? $method as $table)
							@php
							$temp_data = "detail[$loop->index]";
							$temp_id = $temp_data.'[temp_id]';
							$temp_module = $temp_data.'[temp_module]';
							$temp_name = $temp_data.'[temp_name]';
							$temp_show = $temp_data.'[temp_show]';
							$temp_reset = $temp_data.'[temp_reset]';
							$temp_active = $temp_data.'[temp_active]';
							@endphp
							<tr>
								<td class="text-center">
									<input type="text" name="{{ $temp_id }}" class="form-control form-control-sm"
										readonly value="{{ old('temp_id') ?? $table[$menu->field_primary()] }}">
								</td>
								<td class="text-center">
									<input type="hidden" value="{{ old('temp_module') ?? $model->field_primary }}"
										name="{{ $temp_module }}">
									<input type="text" name="{{ $temp_name }}" class="form-control form-control-sm"
										value="{{ old('temp_name') ?? $table[$menu->field_name()] }}">
								</td>
								<td>
									{{ Form::select($temp_reset, ['1' => 'Yes', '0' => 'No'], null, ['class'=> 'form-control', 'id' => 'system_menu_active']) }}
								</td>
								<td>
									{{ Form::select($temp_show, ['0' => 'No', '1' => 'Yes'], null, ['class'=> 'form-control', 'id' => 'system_menu_active']) }}
								</td>
								<td>
									{{ Form::select($temp_active, ['1' => 'Yes', '0' => 'No'], null, ['class'=> 'form-control', 'id' => 'system_menu_active']) }}
								</td>
							</tr>
							@empty
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>

		@endif

	</div>
</div>

{!! Template::form_close() !!}

@endsection

@push('javascript')
@include(Template::components('form'))
@endpush