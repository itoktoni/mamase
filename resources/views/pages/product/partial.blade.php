<div class="card form-product">
	<div class="card-body">

		<div class="row">

			<div class="col-md-6">

				<div class="form-group {{ $errors->has('product_name') ? 'has-error' : '' }}">
					<label>{{ __('Name') }}</label>
					{!! Form::text('product_name', null, ['class' => 'form-control', 'id' => 'product_name',
					'placeholder'
					=> 'Please fill this input', 'required']) !!}
					{!! $errors->first('product_name', '<p class="help-block">:message</p>') !!}
				</div>

				<div class="form-group {{ $errors->has('product_internal_number') ? 'has-error' : '' }}">
					<label>Internal Number</label>
					{!! Form::text('product_internal_number', null, ['class' => 'form-control', 'id' =>
					'product_internal_number', 'placeholder'
					=> 'Please fill this input', 'required']) !!}
					{!! $errors->first('product_internal_number', '<p class="help-block">:message</p>') !!}
				</div>

				<div class="form-group {{ $errors->has('product_auto_number') ? 'has-error' : '' }}">
					<label>Auto Number</label>
					{!! Form::text('product_auto_number', null, ['class' => 'form-control', 'id' =>
					'product_auto_number', 'placeholder'
					=> 'Please fill this input', 'required']) !!}
					{!! $errors->first('product_auto_number', '<p class="help-block">:message</p>') !!}
				</div>

				<div class="row">
					<div class="col-md-4">
						<div class="form-group {{ $errors->has('product_buy_date') ? 'has-error' : '' }}">
							<label>Buy Date</label>
							{!! Form::text('product_buy_date', null, ['class' => 'form-control date', 'id' =>
							'product_buy_date', 'placeholder'
							=> 'Please fill this input', 'required']) !!}
							{!! $errors->first('product_buy_date', '<p class="help-block">:message</p>') !!}
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group {{ $errors->has('product_prod_year') ? 'has-error' : '' }}">
							<label>Production Year</label>
							{!! Form::text('product_prod_year', null, ['class' => 'form-control', 'id' =>
							'product_prod_year',
							'placeholder'
							=> 'Please fill this input', 'required']) !!}
							{!! $errors->first('product_prod_year', '<p class="help-block">:message</p>') !!}
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group {{ $errors->has('product_acqu_year') ? 'has-error' : '' }}">
							<label>Acquisition Year</label>
							{!! Form::text('product_acqu_year', null, ['class' => 'form-control', 'id' =>
							'product_prod_year',
							'placeholder' => 'Year', 'required']) !!}
							{!! $errors->first('product_acqu_year', '<p class="help-block">:message</p>') !!}
						</div>
					</div>
				</div>

				<div class="form-group {{ $errors->has('product_serial_number') ? 'has-error' : '' }}">
					<label>Serial Number</label>
					{!! Form::text('product_serial_number', null, ['class' => 'form-control', 'id' =>
					'product_serial_number', 'placeholder'
					=> 'Please fill this input', 'required']) !!}
					{!! $errors->first('product_serial_number', '<p class="help-block">:message</p>') !!}
				</div>

				<div class="form-group {{ $errors->has('product_price') ? 'has-error' : '' }}">
					<label>Product Price</label>
					{!! Form::text('product_price', null, ['class' => 'form-control', 'id' => 'product_prod_year',
					'placeholder'
					=> 'Please fill this input', 'required']) !!}
					{!! $errors->first('product_price', '<p class="help-block">:message</p>') !!}
				</div>

				<div class="form-group">
					<label>Status</label>
					{!! Form::select('product_status', $status, null, ['class' => 'form-control', 'id' =>
					'product_name', 'placeholder' => '- Select Status -', 'required']) !!}
				</div>

				<div class="form-group">
					<label>{{ __('Description') }}</label>
					{!! Form::textarea('product_description', null, ['class' => 'form-control h-auto', 'id' =>
					'product_description',
					'placeholder' => 'Please fill this input', 'rows' => 8]) !!}
				</div>
			</div>

			<div class="col-md-6">

				<div class="form-group">
					<label>Category</label>
					{!! Form::select('product_category_id', $category, null, ['class' => 'form-control', 'id' =>
					'product_name', 'placeholder' => '- Select Category -', 'required']) !!}
				</div>

				<div class="form-group">
					<label>Type</label>
					{!! Form::select('product_type_id', $product_type, null, ['class' => 'form-control', 'id' =>
					'product_type_id', 'placeholder' => '- Select Unit -', 'required']) !!}
				</div>

				<div class="form-group">
					<label>Jenis Teknologi</label>
					{!! Form::select('product_tech_id', $product_tech, null, ['class' => 'form-control', 'id' =>
					'product_tech_id', 'placeholder' => '- Select Unit -', 'required']) !!}
				</div>

				<div class="form-group">
					<label>Brand</label>
					{!! Form::select('product_brand_id', $brand, null, ['class' => 'form-control', 'id' =>
					'product_name', 'placeholder' => '- Select brand -', 'required']) !!}
				</div>

				<div class="form-group">
					<label>Unit</label>
					{!! Form::select('product_unit_code', $unit, null, ['class' => 'form-control', 'id' =>
					'product_name', 'placeholder' => '- Select Unit -', 'required']) !!}
				</div>

				<div class="form-group">
					<label>Supplier</label>
					{!! Form::select('product_supplier_id', $supplier, null, ['class' => 'form-control', 'id' =>
					'product_name', 'placeholder' => '- Select Supplier -', 'required']) !!}
				</div>

				<div class="form-group">
					<label>Location</label>
					{!! Form::select('product_location_id', $location, null, ['class' => 'form-control', 'id' =>
					'product_name', 'placeholder' => '- Select Location -', 'required']) !!}
				</div>

				<div class="form-group {{ $errors->has('file_logo') ? 'has-error' : '' }}">
					<img class="img-fluid img-thumbnail mb-2" src="{{ $model->field_image ? $model->field_image_url : Views::noImage() }}"
						alt="">
					<input type="file" class="file btn btn-default btn-block" name="file_picture" />
				</div>

			</div>

		</div>

	</div>

</div>