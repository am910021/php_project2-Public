@extends('layouts.app')

@section('style')
    <style id="styles">

        #sunChart {
            padding: 0;
        }

        .line {
            width: 100%;
            /*border: 1px solid #bababa;*/
            padding: 12%;
            position: absolute;
            border: 2px solid #aaaaaa;
            border-radius: 10px;
            box-shadow: 5px 5px 5px #888888;
        }

           
        .sun-1 {
            position: absolute;
            width: 15%;
            top: 6.5%;
            left: 40%;           
            
        }
                
        .sun-2 {
            position: absolute;
            width: 19%;
            top: 10%;
            left: 5%;
        }

        .sun-3 {
            position: absolute;
            width: 22%;
            top: 24%;
            left: 73%;
        }

        .sun-4 {
            position: absolute;
            width: 25%;
            top: 43%;
            left: 2%;
        }

        .sun-5 {
            position: absolute;
            width: 28%;
            top: 54%;
            left: 40%;
        }

        .sun-6 {
            position: absolute;
            width: 31%;
            top: 60%;
            left: 70%;
        }

        .sun-7 {
            position: absolute;
            width: 34%;
            top: 73%;
            left: 2%;
        }
          .word1 {
            font-size:100%;
            position: absolute;
            width: 34%;
            top:70%;
            left: 15%;         
            
        }
          .word2 {
            position: absolute;
            width: 31%;
            top: 57%;
            left: 81%;         
            
        }
          .word3 {
            position: absolute;
            width: 28%;
            top: 50.5%;
            left:50%;         
            
        }
          .word4 {
            position: absolute;
            width: 25%;
            top: 39.5%;
            left: 10%;         
            
        }
          .word5 {
            position: absolute;
            width: 22%;
            top: 20.5%;
            left: 80%;         
            
        }
          .word6 {
            position: absolute;
            width: 19%;
            top: 6.5%;
            left: 10%;         
            
        }
          .word7 {
            position: absolute;
            width: 15%;
            top: 2.5%;
            left: 43.5%;         
            
        }

        /* progress bar */
        #barChart {
            padding: 0;
        }
        .bar {
            width: 100%;
            position: absolute;
        }

        .number {
            position: absolute;
            width: 9%;
        }

        .number5 {
            top: 15%;
            left: 30%;
        }

        .number10 {
            top: 15%;
            left: 60%;
        }

        .arrows {
            position: absolute;
            width: 5%;
        }

    </style>
@endsection

@section('title')
    七日攝食圖示
@endsection

@section('content')

    <div class="container-fluid">
        @if (isset($mealRecordDays))
            <div class="row">
                <div id="sunChart" class="col-sm-6 col-xs-12">
                    <img class="line" src="{{ asset('img/line.png') }}">
                     

                    @foreach($mealRecordDays as $index => $mealRecordDay)
                        <img class="sun-{{ $index+1 }}"
                             src="{{ asset('img/sun-'.$mealRecordDay->calcColor.'.png') }}">
                             <div class="word1">今日</div>
                             <div class="word2">前1日</div>
                             <div class="word3">前2日</div>
                             <div class="word4">前3日</div>
                             <div class="word5">前4日</div>
                             <div class="word6">前5日</div>
                             <div class="word7">前6日</div>
                    @endforeach
                </div>
            </div>
        @endif

        <br><br>

        <div class="row">
            <div id="barChart" class="col-sm-6 col-xs-12">
                <div class="progressBar">
                    <img class="bar" src="{{ asset('img/bars.png') }}">
                    <img class="number number5" src="{{ asset('img/p5.png') }}">
                    <img class="number number10" src="{{ asset('img/p10.png') }}">
                    <img class="arrows" src="{{ asset('img/arrows.png') }}"
                         style="left: {{ $weeklyAvg->percent * 6.6 > 95 ? 95 : $weeklyAvg->percent * 6.6 }}%;">
                </div>
            </div>
        </div>

    </div>
@endsection

@section('javascript')
    <script>
        function setLineImgHeight() {
            const lineHeight = $('.line').css('height');
            $('#sunChart').css({'height': lineHeight});

            const barHeight = $('.bar').css('height');
            $('#barChart').css({'height': barHeight});
        }

        $(document).ready(function () {

            $(window).resize(function () {
                setLineImgHeight();
            });

        });

        $('.line').on('load', function () {
            setLineImgHeight();
        });
        setTimeout(function () {
            setLineImgHeight();
        }, 1000);
    </script>
@endsection