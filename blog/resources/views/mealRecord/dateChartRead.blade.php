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

            var labelList = [
                @forEach($mealRecordDays as $mealRecordDay)
                    "{{ $mealRecordDay->date }}",
                @endforeach
            ];
            var percentList = [
                @forEach($mealRecordDays as $mealRecordDay)
                    {{ $mealRecordDay->percent }},
                @endforeach
            ];

            var caloriesList = [ // 熱量
                @forEach($mealRecordDays as $mealRecordDay)
                    {{ $mealRecordDay->calories }},
                @endforeach
            ];

            var weightList = [ // 糖量
                @forEach($mealRecordDays as $mealRecordDay)
                    {{ $mealRecordDay->weight }},
                @endforeach
            ];
            var heightList = [
                @forEach($mealRecordDays as $mealRecordDay)
                    {{ $mealRecordDay->height }},
                @endforeach
            ];
            var p_weightList = [  // 體重
                @forEach($mealRecordDays as $mealRecordDay)
                    {{ $mealRecordDay->p_weight }},
                @endforeach
            ];
            var rcList = [
                @forEach($mealRecordDays as $mealRecordDay)
                    {{ $mealRecordDay->rc }},
                @endforeach
            ];

            var ctx = document.getElementById("myChart").getContext('2d');

            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labelList,
                    datasets: [
                        {
                            label: '糖量比例',
                            backgroundColor: 'black',
                            borderColor: 'black',
                            data: percentList,
                            fill: 'false',
                            yAxisID: 'percent'
                        },
                        {
                            label: '熱量',
                            backgroundColor: 'orange',
                            borderColor: 'orange',
                            data: caloriesList,
                            fill: 'false',
                            yAxisID: 'calories'
                        },
                        {
                            label: '糖量',
                            backgroundColor: 'blue',
                            borderColor: 'blue',
                            data: weightList,
                            fill: 'false',
                            yAxisID: 'weight',
                            hidden: true
                        },
                        {
                            label: '身高',
                            backgroundColor: 'green',
                            borderColor: 'green',
                            data: heightList,
                            fill: 'false',
                            yAxisID: 'height',
                            hidden: true
                        },
                        {
                            label: '體重',
                            backgroundColor: 'gray',
                            borderColor: 'gray',
                            data: p_weightList,
                            fill: 'false',
                            yAxisID: 'p_weight',
                            hidden: true
                        },
                        {
                            label: '建議熱量',
                            backgroundColor: 'red',
                            borderColor: 'red',
                            data: rcList,
                            fill: 'false',
                            yAxisID: 'calories'
                        }
                    ],
                    yHighlightRange: [
                        {
//                            begin: 0,
//                            end: 5,
                            color: 'rgb(223,240,216)'
                        }, {
//                            begin: 5,
//                            end: 10,
                            color: 'rgb(252,248,227)'
                        }, {
//                            begin: 10,
//                            end: 30,
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
                        intersect: false
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
                        yAxes: [
                            {
                                id: 'percent',
                                scaleLabel: {
                                    display: true,
                                    labelString: '糖量比例(%)'
                                },
                                position: 'left',
                                ticks: {
                                    beginAtZero: true
                                }

                            },
                            {
                                id: 'calories',
                                scaleLabel: {
                                    display: true,
                                    labelString: '熱量(克)'
                                },
                                position: 'left',
                                ticks: {
                                    beginAtZero: true
                                }
                            },
                            {
                                id: 'weight',
                                display: false,
                                scaleLabel: {
                                    display: true,
                                    labelString: '糖量(克)'
                                },
                                position: 'left',
                                ticks: {
                                    beginAtZero: true
                                }
                            },
                            {
                                id: 'height',
                                display: false,
                                scaleLabel: {
                                    display: true,
                                    labelString: '身高(公分)'
                                },
                                position: 'left',
                                ticks: {
                                    beginAtZero: true
                                }
                            },
                            {
                                id: 'p_weight',
                                display: false,
                                scaleLabel: {
                                    display: true,
                                    labelString: '體重(公斤)'
                                },
                                position: 'left',
                                ticks: {
                                    beginAtZero: true
                                }
                            }
//                            ,{
//                                id: 'rc',
//                                display: true,
//                                scaleLabel: {
//                                    display: true,
//                                    labelString: '建議熱量(克)'
//                                },
//                                position: 'left',
//                                ticks: {
//                                    beginAtZero: true
//                                }
//                            }


                        ]
                    },
                    legend: {
                        onClick: function(event, legendItem) {
                            //get the index of the clicked legend
                            var index = legendItem.datasetIndex;
                            //toggle chosen dataset's visibility
                            myChart.data.datasets[index].hidden =
                                !myChart.data.datasets[index].hidden;
                            //toggle the related labels' visibility
                            myChart.options.scales.yAxes[index].display =
                                !myChart.options.scales.yAxes[index].display;
                            myChart.update();
                        }
                    }

                }
            });

        });

    </script>

@endsection