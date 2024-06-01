@extends(Template::master())

@section('title')
<h4>{{ __('Report') }} Sparepart</h4>
@endsection

@section('action')
<div class="button">
	<button type="submit" class="btn btn-primary" id="modal-btn-save">{{ __('Generate') }}</button>
</div>
@endsection

@section('container')

{!! Template::form_report() !!}

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
				<div class="form-group {{ $errors->has('start_date') ? 'has-error' : '' }}">
					<label>{{ __('Start Date') }}</label>
					{!! Form::text('start_date', null, ['class' => 'form-control date', 'id' => 'start_date',
					'placeholder'
					=> 'Tanggal Awal']) !!}
					{!! $errors->first('start_date', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('end_date') ? 'has-error' : '' }}">
					<label>{{ __('End Date') }}</label>
					{!! Form::text('end_date', null, ['class' => 'form-control date', 'id' => 'end_date', 'placeholder'
					=> 'Tanggal Akhir']) !!}
					{!! $errors->first('end_date', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div class="col-md-6">

				<div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
					<label>Kategori</label>
					{!! Form::select('category_id', $category, null, ['class' => 'form-control', 'id' =>
					'category_id', 'placeholder' => '- Pilih Status -']) !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
					<label>Teknisi</label>
					{!! Form::select('user_id', $user, null, ['class' => 'form-control', 'id' =>
					'user_id', 'placeholder' => '- Pilih User -']) !!}
				</div>
			</div>

		</div>
	</div>
</div>

{!! Template::form_close() !!}

@endsection

@push('javascript')
@include(Template::components('form'))
@include(Template::components('date'))

@if(Template::greatherAdmin())
<script>
$('body').on('change', '.contract', function() {
	reset();
	contract(this.value);
});

$(document).ready(function() {
	reset();
	var data = $(".contract option:selected").val();
	contract(data);
});

function reset(){
	$(".vendor").hide();
	$(".teknisi").hide();
}

function contract(data) {
	if (typeof data == "undefined") {
		$(".vendor").hide();
		$(".teknisi").hide();
	} else if (data == '1') {
		$(".vendor").show();
		$(".teknisi").hide();
	} else if (data == '0') {
		$(".teknisi").show();
		$(".vendor").hide();
	}
	else{
		reset();
	}
}
</script>
@endif
@endpush
