@extends('adminlte::page')

@section('content')

<div class="card">
    <div class="card-header text-center">{{ __('Report Detail') }}</div>

    <div class="card-body">
        <div class="card">
            <div class="card-header text-center">{{ __('Report Summary') }}</div>
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 h-100 d-inline-block">
                            <div class="card">
                                <div class="card-header text-center">{{ __('Shift Summary') }}</div>
                                <div class="card-body">
                                    <table class="table">
                                        <thead></thead>

                                        <tbody>

                                            <tr>
                                                <td style="width: 25%">Nama</td>
                                                <td> {{ $data->name }}</td>
                                            </tr>

                                            <tr>
                                                <td style="width: 25%">Attend Time</td>
                                                <td> {{ $shift->attend_date}}</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 25%">Shift Finish</td>
                                                <td> {{ $shift->finish_time}}</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 25%">Shift Duration</td>
                                                <td> {{ $data->shiftDuration}}</td>
                                            </tr>



                                        </tbody>


                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 h-100 d-inline-block">
                            <div class="card">
                                <div class="card-header text-center">{{ __('Fatigue Summary') }}</div>
                                <div class="card-body">
                                    <div class="h-100">
                                        <canvas class="col" id="canvas"></canvas>
                                        <div class="card text-center">
                                        
                                        <div class="class-header font-weight-bold">Summary</div>
                                        <div class="card-body">
                                        {{ $data->statusReportSummary ?? ''}}                                        
                                        </div>
                                    </div>                               
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header text-center">{{ __('Report Chart') }}</div>
            <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 h-100 d-inline-block">
                            <canvas id="heartChart"></canvas>
                        </div>
                        <div class="col-md-4 h-100 d-inline-block">
                            <canvas id="spo2Chart"></canvas>
                        </div>
                        <div class="col-md-4 h-100 d-inline-block">
                            <canvas id="tempChart"></canvas>
                        </div>
                    </div>
        
            </div>
        </div>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="https://www.chartjs.org/samples/latest/utils.js"></script>
<script>
    var report = {!!json_encode($data) !!};
    var label = [];
    for (x in report.timeState) {
        var d = new Date(report.timeState[x]);
        label.push(d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds());
    }
    console.log(label);
    console.log(report);
    var heartRateData = {
        type: 'line',
        data: {
            labels: label,
            datasets: [{
                label: "Heart Rate(BPM)",
                backgroundColor: window.chartColors.red,
                borderColor: window.chartColors.red,
                data: report.hr,

                pointRadius: 0,
                fill: false,
                lineTension: 0,
                borderWidth: 1
            }]
        },
        options: {

            legend: false,
            responsive: true,
            title: {
                display: true,
                text: 'Heart Rate Chart'
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Time'
                    },
                    ticks: {
                        major: {
                            enabled: true,
                            fontStyle: 'bold'
                        },
                        source: 'data',
                        autoSkip: true,
                        autoSkipPadding: 50,
                        sampleSize: 50
                    },
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Value'
                    }
                }]
            }
        }
    };
    var spo2Data = {
        type: 'line',
        data: {
            labels: label,
            datasets: [{
                label: "SPO2",
                backgroundColor: window.chartColors.blue,
                borderColor: window.chartColors.blue,
                data: report.spo2,
                fill: false,

                pointRadius: 0,
                fill: false,
                lineTension: 0,
                borderWidth: 1
            }]
        },
        options: {

            legend: false,
            responsive: true,
            title: {
                display: true,
                text: 'SPO2 Chart'
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Time'
                    },
                    ticks: {
                        major: {
                            enabled: true,
                            fontStyle: 'bold'
                        },
                        source: 'data',
                        autoSkip: true,
                        autoSkipPadding: 50,
                        sampleSize: 50
                    },
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Value'
                    }
                }]
            }
        }
    };
    var tempData = {
        type: 'line',
        data: {
            labels: label,
            datasets: [{
                label: "Temperature",
                backgroundColor: window.chartColors.purple,
                borderColor: window.chartColors.purple,
                data: report.temperature,
                fill: false,

                pointRadius: 0,
                fill: false,
                lineTension: 0,
                borderWidth: 2
            }]
        },
        options: {

            legend: false,
            responsive: true,
            title: {
                display: true,
                text: 'Temperature Chart'
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Time'
                    },
                    ticks: {
                        major: {
                            enabled: true,
                            fontStyle: 'bold'
                        },
                        source: 'data',
                        autoSkip: true,
                        autoSkipPadding: 50,
                        sampleSize: 50
                    },
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Value'
                    }
                }]
            }
        }
    };

    var rSum = [];

    function parseResultSummary() {
        rSum[0] = (report.resultSummary.Max);
        rSum[1] = (report.resultSummary.Hard);
        rSum[2] = (report.resultSummary.Moderate);
        rSum[3] = (report.resultSummary.Light);
        rSum[4] = (report.resultSummary.Relax);
    }
    parseResultSummary();
    console.log(rSum);
    var horizontalBarChartData = {
        labels: ['Maximum', 'Hard', 'Moderate', 'Light', 'Relax'],
        datasets: [{
            label: 'Dataset 1',
            backgroundColor: window.chartColors.red,
            borderColor: window.chartColors.red,
            borderWidth: 1,
            data: rSum
        }]

    };
    window.onload = function() {
        var hr = document.getElementById('heartChart').getContext('2d');
        window.myLine = new Chart(hr, heartRateData);
        var spo2 = document.getElementById('spo2Chart').getContext('2d');
        window.myLine = new Chart(spo2, spo2Data);
        var temp = document.getElementById('tempChart').getContext('2d');
        window.myLine = new Chart(temp, tempData);

        var ctx = document.getElementById('canvas').getContext('2d');
        window.myHorizontalBar = new Chart(ctx, {
            type: 'horizontalBar',
            data: horizontalBarChartData,
            options: {
                // Elements options apply to all of the options unless overridden in a dataset
                // In this case, we are setting the border of each horizontal bar to be 2px wide
                elements: {
                    rectangle: {
                        borderWidth: 2,
                    }
                },
                responsive: true,
                legend: false,
                title: {
                    display: true,
                    text: 'BPM Level'
                }
            }
        });
    };
</script>
@endsection