@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Warning List') }}</div>

                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Person Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Result</th>
                                <th scope="col">Option</th>
                            </tr>
                        </thead>
                        @php
                            $num = 1;
                        @endphp
                        <tbody>
                            @foreach($data as $data)
                            <tr>
                                <td>
                                    @php
                                        echo $num;
                                        $num++;
                                    @endphp
                                </td>
                                <td>{{$data->name}}</td>
                                <td>
                                    @php
                                        if ($data->reviewed == false){
                                            echo "Need Review";
                                        }
                                        else {
                                            echo "Reviewed";
                                        }
                                    @endphp
                                </td>
                                <td><a class="btn btn-warning" href="/dashboard/report/{{ $data->attendance_id }}">Report Link</a></td>
                                <td>
                                <a class='btn btn-danger' href='/dashboard/warning/reviewed/{{$data->attendance_id}}'>Mark Reviewed</a>
                                </td>
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