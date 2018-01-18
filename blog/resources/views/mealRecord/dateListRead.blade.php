@extends('layouts.app')

@section('title')
    攝食日期列表
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">

            <form method="{{ route('dateMealRecord.readList') }}">
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
            <div class="col-sm-12 {{ $errors->has('endDate')?"has-error":"" }}">
                @if($errors->has('endDate'))
                    <div class="">
                    <span class="help-block">
                        <b>{{ $errors->first('endDate') }}</b>
                    </span>
                    </div>
                @endif
            </div>

        </div>
        <br>
        <div class="row">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                @if (isset($mealRecordDays))
                    @foreach($mealRecordDays as $index=>$mealRecordDay)
                        <div class="panel panel-{{ $mealRecordDay->BSColorTag }}">
                            <div class="panel-heading" role="tab" id="heading-{{ $index }}">
                                <h4 class="panel-title">
                                    @if ($mealRecordDay->calories!=0)
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                           data-parent="#accordion"
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
                                                    <div class="col-sm-3 col-xs-6">
                                                        {{ $mealRecord->datetimeByTime }}
                                                    </div>
                                                    <div class="col-sm-3 col-xs-6">
                                                        熱量 {{ $mealRecord->calories }} 大卡
                                                    </div>
                                                    <div class="col-sm-3 col-xs-6">
                                                        糖量比例 {{ $mealRecord->gramByPercent() }}
                                                    </div>
                                                    <div class="col-sm-3 col-xs-6">
                                                        糖 {{ $mealRecord->weight }} 公克
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
        });
    </script>

@endsection