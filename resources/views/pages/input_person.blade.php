@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Input person</div>

                <div class="card-body">
                    <form action="/submit-person/submit" method="POST">
                        @csrf
                        <label>Input Name :</label>
                        <input type="text" name="name"> <br />
                        <label>Input User Id :</label>
                        <input type="text" name="user_id"> <br />
                        <label>Input User Id :</label>
                        <input type="date" name="dob"> <br />
                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection