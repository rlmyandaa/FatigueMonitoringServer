@extends('adminlte::page')

@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header font-weight-bold text-center">Input person</div>

            <div class="card-body">
                <form action="/submit-person/submit" method="POST">
                    @csrf

                    <div class="form-outline mb-4">
                        <input type="text" id="form4Example1" name="name" class="form-control" placeholder="Name" required/>
                        <label class="form-label" for="form4Example1">Name</label>
                    </div>

                    <div class="form-outline mb-4">
                        <input type="text" id="form4Example2" class="form-control" name="user_id" placeholder="User ID" required/>
                        <label class="form-label" for="form4Example2">User ID</label>
                    </div>

                    <div class="form-outline mb-4">
                        <input type="date" id="form4Example4" class="form-control" name="dob" required />
                        <label class="form-label" for="form4Example1">Date of Birth</label>
                    </div>



                    <!-- Checkbox -->

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary btn-block mb-4">Submit</button>


                </form>
            </div>
        </div>
    </div>
    <div class="col-9">
        <div class="card">
            <div class="card-header font-weight-bold text-center">Person List</div>

            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Person Name</th>
                            <th scope="col">User ID</th>
                            <th scope="col">Date of Birth</th>
                            <th scope="col">Operation</th>
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
                            <td>{{$person->full_name}}</td>
                            <td>{{$person->user_id}}</td>
                            <td>{{$person->date_of_birth}}</td>
                            <td><a class="btn btn-primary" href="/submit-person/report/{{ $person->user_id }}">Report</a>
                                <a class="btn btn-danger" href="/submit-person/delete/{{ $person->user_id }}">Delete User</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection