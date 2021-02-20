@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $name."'s Report"}}</div>

                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Attend Date</th>
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
                                    @php
                                        echo $num;
                                        $num++;
                                    @endphp
                                </td>
                                <td>{{$d->attend_date}}</td>
                                <td>{{$d->finish_time}}</td>
                                <td><a href="{{ route('report.detail', ['uid' => $d->attendance_id]) }}" target="_blank">Open Dashboard</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $data->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>


@endsection