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

			<div class="col-md-4">
				<div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
					<label>Kategori</label>
					{!! Form::select('category_id', $category, null, ['class' => 'form-control', 'id' =>
					'category_id', 'placeholder' => '- Pilih Status -']) !!}
				</div>
			</div>

			<div class="col-md-12">
				<div class="form-group {{ $errors->has('sparepart') ? 'has-error' : '' }}">
					<label>Alat</label>
					{!! Form::select('sparepart[]', $sparepart, null, ['class' => 'form-control', 'id' =>
					'sparepart', 'multiple']) !!}
				</div>
			</div>

			<div class="col-md-12">
				<div class="form-group {{ $errors->has('location') ? 'has-error' : '' }}">
					<label>Ruangan</label>
					{!! Form::select('location[]', $option_location, null, ['class' => 'form-control', 'id' =>
					'location', 'multiple']) !!}
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
