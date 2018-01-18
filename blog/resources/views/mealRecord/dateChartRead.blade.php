@extends('layouts.app')

@section('title')
    攝食日期圖表
@endsection

@section('style')
    <style>

        @media (max-width: 768px) {
            .chartDiv {
                width: 150%
            }

            .overFlowDiv {
                overflow: scroll
            }

        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <form method="{{ route('dateMealRecord.readChart') }}">
                <div class="col-lg-6 col-sm-8">
                    <div class="input-group">
                        <input type="text" class="input-small form-control datepicker" name="startDate"
                               value="{{ old('startDate', $startDate) }}">
                        <span class="input-group-addon"><strong>~</strong></span>
                        <input type="text" class="input-small form-control datepicker" name="endDate"
                               value="{{ old('endDate', $endDate) }}">
                    </div>
                </div>
                <div class="visible-xs">
                    <br>
                </div>
                <div class="col-lg-6 col-sm-2">
                    <input class="btn btn-primary btn-xs-block" type="submit" value="查詢">
                </div>
            </form>
        </div>
        <div class="row">
            <div class="overFlowDiv">
                <div class="chartDiv">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function () {

            $('.datepicker').datepicker({
                'autoclose': true,
                'endDate': new Date(),
                'format': 'yyyy-mm-dd',
                language: 'zh-hant'
            })

            var labelLists = [
                @forEach($mealRecordDays as $mealRecordDay)
                    "{{ $mealRecordDay->date }}",
                @endforeach
            ];

            var data = [
                @forEach($mealRecordDays as $mealRecordDay)
                {{ $mealRecordDay->gramByPercent() }},
                @endforeach
            ];

            var ctx = document.getElementById("myChart").getContext('2d');


            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labelLists,
                    datasets: [
                        {
                            'label': '糖量比例',
                            'backgroundColor': 'black',
                            'borderColor': 'black',
                            'data': data,
                            'fill': 'false'
                        }
                    ],
                    yHighlightRange: [
                        {
                            begin: 0,
                            end: 5,
                            color: 'rgb(223,240,216)'
                        }, {
                            begin: 5,
                            end: 10,
                            color: 'rgb(252,248,227)'
                        }, {
                            begin: 10,
                            end: 30,
                            color: 'rgb(242,200,200)'
                        }
                    ]
                },
                options: {
                    responsive: true,

                    title: {
                        display: true,
                        text: '圖表'
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
                                labelString: '日期'
                            }
                        }],
                        yAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: '含糖量'
                            }

                        }]
                    }

                }
            });

        });

    </script>

@endsection