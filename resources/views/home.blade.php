@extends('layouts.app')

@push('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
@endpush

@section('content')

<div class="page-header">
	<div class="container-fluid d-sm-flex justify-content-between">
		<h4>Dashboard</h4>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="#">Dashboard</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Welcome {{ auth()->user()->name ?? '' }}</li>
			</ol>
		</nav>
	</div>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">

			<div class="row">
				<div class="col-md-3">
					<div class="card card-body">
						<h3 class="mb-3">
							{{ Query::getTotalTicket() }}
							<small>Total Tickets</small>
						</h3>
						<div class="progress mb-2" style="height: 5px">
							<div class="progress-bar bg-primary" role="progressbar" style="width: 100%;"
								aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="card card-body">
						<h3 class="mb-3">
							{{ Query::getTotalOpenTicket() }}
							<small>New Tickets</small>
						</h3>
						<div class="progress mb-2" style="height: 5px">
							<div class="progress-bar bg-primary" role="progressbar"
								style="width: {{ Query::getTotalOpenTicket(true) }}%;" aria-valuenow="50"
								aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="card card-body">
						<h4 class="mb-3">
							{{ Query::getTotalProcessTicket() }}
							<small>Process Tickets</small>
						</h4>
						<div class="progress mb-2" style="height: 5px">
							<div class="progress-bar bg-info" role="progressbar"
								style="width: {{ Query::getTotalProcessTicket(true) }}%;"
								aria-valuenow="{{ Query::getTotalProcessTicket(true) }}" aria-valuemin="0"
								aria-valuemax="100"></div>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="card card-body">
						<h3 class="mb-3">
							{{ Query::getTotalCloseTicket() }}
							<small>Closed Tickets</small>
						</h3>
						<div class="progress mb-2" style="height: 5px">
							<div class="progress-bar bg-success" role="progressbar"
								style="width: {{ Query::getTotalCloseTicket(true) }}%;"
								aria-valuenow="{{ Query::getTotalCloseTicket(true) }}" aria-valuemin="0"
								aria-valuemax="100"></div>
						</div>
					</div>
				</div>

			</div>

			<div class="row">
				<div class="col-lg-12 col-md-12">
					<div class="card">
						<div class="card-body">
							<div class="d-flex justify-content-between">
								<h6 class="card-title">Ticket Status</h6>
							</div>

							<di class="row">
								{!! $chart->container() !!}
								{!! $chart->script() !!}
							</di>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>


@endsection