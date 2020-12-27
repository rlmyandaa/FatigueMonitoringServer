@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('You are logged in!') }}
                    <br />
                    <a class="btn btn-primary" href="/submit-person">Input Person</a> <br />
                    <a class="btn btn-primary" href="/rpc/on">Turn On</a> <br />
                    <a class="btn btn-primary" href="/rpc/off">Turn Off</a> <br />
                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection