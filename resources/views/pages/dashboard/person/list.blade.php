@extends('layouts.app')

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
                                <th scope="col">Person Name</th>
                                <th scope="col">Device Used</th>
                                <th scope="col">Monitor</th>
                            </tr>
                        </thead>
                        @php
                            $num = 1;
                        @endphp
                        <tbody>
                            @foreach($data as $person)
                            <tr>
                                <td>
                                    @php
                                        echo $num;
                                        $num++;
                                    @endphp
                                </td>
                                <td>{{$person->person_name}}</td>
                                <td>{{$person->device_name}}</td>
                                <td><a href="{{$person->dashUrl}}" target="_blank">Open Dashboard</a></td>
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