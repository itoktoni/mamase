<div class="card form-product">
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">

				<div class="form-group {{ $errors->has('product_name') ? 'has-error' : '' }}">
					<label>{{ __('Name') }}</label>
					{!! Form::text('product_name', null, ['class' => 'form-control', 'id' => 'product_name',
					'placeholder'
					=> '* wajib diisi', 'required']) !!}
					{!! $errors->first('product_name', '<p class="help-block">:message</p>') !!}
				</div>

				<div class="form-group {{ $errors->has('product_serial_number') ? 'has-error' : '' }}">
					<label>Serial Number</label>
					{!! Form::text('product_serial_number', null, ['class' => 'form-control', 'id' =>
					'product_serial_number', 'required']) !!}
					{!! $errors->first('product_serial_number', '<p class="help-block">:message</p>') !!}
				</div>

				<div class="form-group {{ $errors->has('product_internal_number') ? 'has-error' : '' }}">
					<label>Kode Internal</label>
					{!! Form::text('product_internal_number', null, ['class' => 'form-control', 'id' =>
					'product_internal_number', 'required']) !!}
					{!! $errors->first('product_internal_number', '<p class="help-block">:message</p>') !!}
				</div>

			</div>

			<div class="col-md-6">

				<div class="form-group">
					<label>Type</label>
					{!! Form::select('product_type_id', $product_type, null, ['class' => 'form-control', 'id' =>
					'product_type_id', 'placeholder' => '- Select Unit -', 'required']) !!}
				</div>

				<div class="form-group">
					<label>Merk</label>
					{!! Form::select('product_brand_id', $brand, null, ['class' => 'form-control', 'id' =>
					'product_name', 'placeholder' => '- Select brand -', 'required']) !!}
				</div>

				<div class="form-group">
					<label>Ruangan</label>
					{!! Form::select('product_location_id', $location, null, ['class' => 'form-control', 'id' =>
					'product_name', 'placeholder' => '- Select Ruangan -', 'required']) !!}
				</div>

			</div>
		</div>

		<div class="row">
			<div class="col-md-2">
				<div class="form-group">
					<label>{{ __('Contact') }}</label>
					{!! Form::select('product_contract', $kontrak, null, ['class' => 'form-control
					contract']) !!}
				</div>
			</div>

			<div class="col-md-10">
				<div class="form-group teknisi">
					<label>{{ __('Teknisi') }}</label>
					{!! Form::select('teknisi[]', $teknisi, $model ?
					json_decode($model->field_teknisi_data) :
					null, ['class' => 'form-control',
					'multiple', 'data-placeholder' => 'Pilih Pelaksana']) !!}
				</div>

				<div class="form-group vendor">
					<label>{{ __('Vendor') }}</label>
					{!! Form::select('product_vendor_id', $supplier, null,
					['class' => 'form-control',
					'placeholder' => '- Pilih Vendor -']) !!}
				</div>
			</div>

		</div>
	</div>
</div>

<div class="card form-product">
	<div class="card-body">

		<div class="row">

			<div class="col-md-6">

				<div class="row">
					<div class="col-md-6">
						<div class="form-group {{ $errors->has('product_price') ? 'has-error' : '' }}">
							<label>Harga Alat</label>
							{!! Form::text('product_price', null, ['class' => 'form-control', 'id' =>
							'product_prod_year']) !!}
							{!! $errors->first('product_price', '<p class="help-block">:message</p>') !!}
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Status</label>
							{!! Form::select('product_status', $status, null, ['class' => 'form-control', 'id' =>
							'product_name', 'placeholder' => '- Select Status -', 'required']) !!}
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Jenis Teknologi</label>
							{!! Form::select('product_tech_id', $product_tech, null, ['class' => 'form-control', 'id' =>
							'product_tech_id', 'placeholder' => '- Select Unit -', 'required']) !!}
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Unit</label>
							{!! Form::select('product_unit_code', $unit, null, ['class' => 'form-control', 'id' =>
							'product_name', 'placeholder' => '- Select Unit -', 'required']) !!}
						</div>
					</div>
				</div>

				<div class="form-group">
					<label>{{ __('Description') }}</label>
					{!! Form::textarea('product_description', null, ['class' => 'form-control h-auto', 'id' =>
					'product_description',
					'placeholder' => 'Please fill this input', 'rows' => 8]) !!}
				</div>
			</div>

			<div class="col-md-6">

				<div class="row">
					<div class="col-md-4">
						<div class="form-group {{ $errors->has('product_buy_date') ? 'has-error' : '' }}">
							<label>Tanggal Pembelian</label>
							{!! Form::text('product_buy_date', null, ['class' => 'form-control date', 'id' =>
							'product_buy_date', 'placeholder'
							=> 'Tanggal', 'required']) !!}
							{!! $errors->first('product_buy_date', '<p class="help-block">:message</p>') !!}
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group {{ $errors->has('product_prod_year') ? 'has-error' : '' }}">
							<label>Tahun Produksi</label>
							{!! Form::text('product_prod_year', null, ['class' => 'form-control', 'id' =>
							'product_prod_year',
							'placeholder' => 'Tahun']) !!}
							{!! $errors->first('product_prod_year', '<p class="help-block">:message</p>') !!}
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group {{ $errors->has('product_acqu_year') ? 'has-error' : '' }}">
							<label>Pengakuan Asset</label>
							{!! Form::text('product_acqu_year', null, ['class' => 'form-control', 'id' =>
							'product_prod_year',
							'placeholder' => 'Tahun', 'required']) !!}
							{!! $errors->first('product_acqu_year', '<p class="help-block">:message</p>') !!}
						</div>
					</div>
				</div>

				<div class="form-group">
					<label>Category</label>
					{!! Form::select('product_category_id', $category, null, ['class' => 'form-control', 'id' =>
					'product_name', 'placeholder' => '- Select Category -', 'required']) !!}
				</div>

				<div class="form-group">
					<label>Pembelian Supplier</label>
					{!! Form::select('product_supplier_id', $supplier, null, ['class' => 'form-control', 'id' =>
					'product_name', 'placeholder' => '- Select Supplier -', 'required']) !!}
				</div>

				<div class="form-group {{ $errors->has('file_logo') ? 'has-error' : '' }}">
					<img class="img-fluid img-thumbnail mb-2"
						src="{{ !empty($model) && $model->field_image ? $model->field_image_url : Views::noImage() }}"
						alt="">
					<input type="file" class="file btn btn-default btn-block" name="file_picture" />
				</div>

			</div>

		</div>

	</div>

</div>


@push('javascript')
<script>
$('body').on('change', '.contract', function() {
	contract(this.value);
});

$(document).ready(function() {
	var data = $(".contract option:selected").val();
	contract(data);
});

function contract(data) {
	if (typeof data == "undefined") {
		$(".vendor").show();
		$(".teknisi").hide();
	} else if (data == '1') {
		$(".vendor").show();
		$(".teknisi").hide();
	} else {
		$(".teknisi").show();
		$(".vendor").hide();
	}
}
</script>
@endpush