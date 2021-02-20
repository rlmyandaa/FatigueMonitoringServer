@extends('adminlte::page')

@section('content')
<div class="card">

    <div class="card-body">
        <div class="jumbotron jumbotron-fluid" style="background: white;">
            <div class="container text-center">
                <h1 class="display-9">Welcome to Fatigue Monitoring System Console</h1>
                <p class="lead">Here you can see the insight.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-left-primary py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col mr-2">
                                <div class="text-uppercase text-primary font-weight-bold text-xs mb-1"><span>System Status</span></div>
                                <div class="text-dark font-weight-bold h5 mb-0" ><span style="color: green;">Running</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-left-success py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col mr-2">
                                <div class="text-uppercase text-success font-weight-bold text-xs mb-1"><span>Active Device</span></div>
                                <div class="text-dark font-weight-bold h5 mb-0"><span>0</span></div>
                            </div>
                            <div class="col-auto"><i class="fas fa-microchip fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-left-info py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col mr-2">
                                <div class="text-uppercase text-info font-weight-bold text-xs mb-1"><span>Today's Report</span></div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="text-dark font-weight-bold h5 mb-0 mr-3"><span>0</span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto"><i class="fas fa-poll fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-left-warning py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col mr-2">
                                <div class="text-uppercase text-warning font-weight-bold text-xs mb-1"><span>Active Warning</span></div>
                                <div class="text-dark font-weight-bold h5 mb-0"><span>0</span></div>
                            </div>
                            <div class="col-auto"><i class="fas fa-bell fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection