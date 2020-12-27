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
                        <div class="col">
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
                        <div class="col">
                            <div class="card">
                                <div class="card-header text-center">{{ __('Fatigue Summary') }}</div>
                                <div class="card-body">
                                <canvas class="col" id="canvas" width="400" height="400"></canvas>
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
                <div class="container">
                    <div class="row">
                        <canvas class="col" id="heartChart" width="400" height="400"></canvas>
                        <canvas class="col" id="spo2Chart" width="400" height="400"></canvas>
                        <canvas class="col" id="tempChart" width="400" height="400"></canvas>

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
                fill: false,
            }]
        },
        options: {
            legend: false,
            responsive: false,
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
                    }
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
                label: "Heart Rate(BPM)",
                backgroundColor: window.chartColors.blue,
                borderColor: window.chartColors.blue,
                data: report.spo2,
                fill: false,
            }]
        },
        options: {
            legend: false,
            responsive: false,
            title: {
                display: true,
                text: 'SpO2 Chart'
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
                    }
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
                label: "Heart Rate(BPM)",
                backgroundColor: window.chartColors.purple,
                borderColor: window.chartColors.purple,
                data: report.temperature,
                fill: false,
            }]
        },
        options: {
            legend: false,
            responsive: false,
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
                    }
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

    rSum = [];
    function parseResultSummary(){
        rSum[0]=(report.resultSummary.Max);
        rSum[1]=(report.resultSummary.Hard);
        rSum[2]=(report.resultSummary.Moderate);
        rSum[3]=(report.resultSummary.Light);
        rSum[4]=(report.resultSummary.Relax);
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
					responsive: false,
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