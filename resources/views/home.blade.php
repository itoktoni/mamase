@extends('layouts.app')

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
							<div class="progress-bar bg-primary" role="progressbar" style="width: {{ Query::getTotalOpenTicket(true) }}%;"
								aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
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
								aria-valuenow="{{ Query::getTotalProcessTicket(true) }}"
								aria-valuemin="0" aria-valuemax="100"></div>
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
								aria-valuenow="{{ Query::getTotalCloseTicket(true) }}"
								aria-valuemin="0" aria-valuemax="100"></div>
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
								<div class="dropdown">
									<a class="btn btn-outline-light btn-sm dropdown-toggle" href="#"
										data-toggle="dropdown">2019</a>
									<div class="dropdown-menu dropdown-menu-right">
										<a href="#" class="dropdown-item">2018</a>
										<a href="#" class="dropdown-item">2017</a>
									</div>
								</div>
							</div>
							<div class="text-center mb-3">
								<ul class="list-inline">
									<li class="list-inline-item text-uppercase font-size-11">
										<i class="fa fa-circle text-primary mr-1"></i> New Tickets
									</li>
									<li class="list-inline-item text-uppercase font-size-11">
										<i class="fa fa-circle text-success mr-1"></i> Solved Tickets
									</li>
									<li class="list-inline-item text-uppercase font-size-11">
										<i class="fa fa-circle text-info mr-1"></i> Process Tickets
									</li>
								</ul>
							</div>
							<canvas id="chart-ticket-status"></canvas>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

@endsection