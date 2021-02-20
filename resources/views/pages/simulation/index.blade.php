@extends('adminlte::page')


@section('js')
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
@stop

@section('content')

<div class="card">
    <div class="card-header font-weight-bold text-center">Simulation Panel</div>

    <div class="card-body">
        <div class="jumbotron jumbotron-fluid" style="background: white;">
            <h1 class="display-4 font-weight-bold">Under Construction</h1>
            <p class="lead">This feature currently required to set a proper working MCU device to connect and is under progress to create a proper simulation to simulate this system.</p>
            <p class="lead">Please contact get a proper simulation so that we could set an MCU for the simulation.</p>
        </div>
        <div class="row">
            <div class="col-sm">
            </div>
            <div class="col-sm">
                <div id="carouselExampleIndicators" class="carousel slide align-center" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="/img/Picture1.jpg" alt="First slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="/img/Picture2.jpg" alt="Second slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="/img/Picture3.jpg" alt="Third slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="/img/Picture4.jpg" alt="Fourth slide">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="col-sm">

            </div>
        </div>
        <br>
    </div>
</div>



@endsection