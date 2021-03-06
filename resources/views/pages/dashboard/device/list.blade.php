@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Device List') }}</div>

                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Device Name</th>
                                <th scope="col">Active</th>
                                <th scope="col">User</th>
                                <th scope="col">Device ID</th>
                                
                            </tr>
                        </thead>
                        @php
                            $num = 1;
                        @endphp
                        <tbody>
                            @foreach($data as $device)
                            <tr>
                                <td>
                                    @php
                                        echo $num;
                                        $num++;
                                    @endphp
                                </td>
                                <td>{{$device->name}}</td>
                                <td>{{$device->state}}</td>
                                <td>{{$device->user}}</td>
                                <td>{{$device->device_id}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection