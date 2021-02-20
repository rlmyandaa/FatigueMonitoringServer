@extends('adminlte::page')

@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header font-weight-bold text-center">{{ "Report List" }}</div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Person Name</th>
                            <th scope="col">Attend Time</th>
                            <th scope="col">Finish Time</th>
                            <th scope="col">Monitor</th>
                        </tr>
                    </thead>
                    @php
                    $num = 1;
                    @endphp
                    <tbody>
                        @foreach($data as $d)
                        <tr>
                            <td>
                            {{$d->num}}
                            </td>
                            <td>{{$d->name}}</td>
                            <td>{{$d->attend_time}}</td>
                            <td>{{$d->finish_time}}</td>
                            <td><a href="{{$d->report_url}}" target="_blank">Open Dashboard</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $data->links() !!}

            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header font-weight-bold text-center">{{ __('Warning List') }}</div>

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
                        @foreach($warning as $data)
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




@endsection