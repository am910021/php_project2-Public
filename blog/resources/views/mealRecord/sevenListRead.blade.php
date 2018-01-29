	@extends('layouts.app')

@section('title')
    七日攝食列表
@endsection

@section('style')
    <style>
        #weeklyDiv{
            margin-bottom: 25px;
            border: 1px solid black;
        }
    </style>
@endsection

@section('content')

    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

        @if (isset($weeklyAvg))
            <div class="panel panel-{{ $weeklyAvg->BSColorTag }}" id="weeklyDiv">
                <div class="panel-heading" role="tab">
                    <h4 class="panel-title">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-3 col-xs-6">
                                    <b>{{ $weeklyAvg->date }}</b>
                                </div>
                                <div class="col-sm-3 col-xs-6">
                                    熱量 {{ $weeklyAvg->calories }} 大卡
                                </div>
                                <div class="col-sm-3 col-xs-6">
                                    糖量比例 {{ $weeklyAvg->gramByPercent() }}
                                </div>
                                <div class="col-sm-3 col-xs-6">
                                    糖 {{ $weeklyAvg->weight }} 公克
                                </div>
                            </div>
                        </div>

                    </h4>
                </div>
            </div>
        @endif
        @if (isset($mealRecordDays))
            @foreach($mealRecordDays as $index=>$mealRecordDay)
                <div class="panel panel-{{ $mealRecordDay->BSColorTag }}">
                    <div class="panel-heading" role="tab" id="heading-{{ $index }}">
                        <h4 class="panel-title">
                            @if ($mealRecordDay->calories!=0)
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                   href="#collapse-{{ $index }}" aria-expanded="false"
                                   aria-controls="collapse-{{ $index }}">
                                    @endif
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-sm-3 col-xs-6">
                                                {{ $mealRecordDay->date }}
                                            </div>
                                            <div class="col-sm-3 col-xs-6">
                                                熱量 {{ $mealRecordDay->calories }} 大卡
                                            </div>
                                            <div class="col-sm-3 col-xs-6">
                                                糖量比例 {{ $mealRecordDay->gramByPercent() }}
                                            </div>
                                            <div class="col-sm-3 col-xs-6">
                                                糖 {{ $mealRecordDay->weight }} 公克
                                            </div>
                                        </div>
                                    </div>
                                    @if ($mealRecordDay->calories!=0)
                                </a>
                            @endif
                        </h4>
                    </div>

                    <div id="collapse-{{ $index }}" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="heading-{{ $index }}">
                        <div class="panel-body">
                            {{--{{ $mealRecordDay->mealRecords()->count() }}--}}
                            <ul class="list-group">
                                @foreach($mealRecordDay->mealRecords() as $mealRecord)

                                    <li class="list-group-item list-group-item-default">
                                      <div class="container-fluid">
                                        <div class="col-md-2 col-sm-4 col-xs-6">
                                          {{ $mealRecord->datetimeByTime }}
                                          <br class="visible-xs">
                                        </div>
                                        <div class="col-md-2 col-sm-4 col-xs-6">
                                          熱量 {{ $mealRecord->calories }} 大卡
                                          <br class="visible-xs">
                                        </div>
                                        <div class="col-md-2 col-sm-4 col-xs-6">
                                          糖量比例 {{ $mealRecord->gramByPercent() }}
                                          <br class="visible-xs">
                                        </div>
                                        <div class="col-md-2 col-sm-4 col-xs-6">
                                          糖量 {{ $mealRecord->weight }}
                                          <br class="visible-xs">
                                        </div>
                                        <div class="col-md-2 col-sm-4 col-xs-6">
                                          {{ $mealRecord->name }}
                                          <br class="visible-xs">
                                        </div>
                                        <div class="col-md-2 col-sm-4 col-xs-6">
                                          <a class="btn btn-warning" href="{{ route('mealRecord.edit', ['id'=>$mealRecord->id]) }}?url={{ 'sevenMealRecord.readList' }}">修改</a>
                                          <br>
                                        </div>
                                      </div>
                                    </li>

                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            @endforeach
        @endif


    </div>
@endsection

