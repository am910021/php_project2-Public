@extends('layouts.app')

@section('title')
    攝食日期列表
@endsection
@section('style')
    <style>
        #dateDiv{
            margin-bottom: 25px;
            border: 1px solid black;
        }
    </style>
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
         @if (isset($dateAvg))
         <div class="panel panel-{{ Helper::getBSColor($dateAvg->dpercent) }}" id="dateDiv" >
         
            <div class="panel-heading" role="tab">
              <h4 class="panel-title">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-sm-3 col-xs-6">
                      <b>日期平均</b> 
                    </div>
                    <div class="col-sm-3 col-xs-6">
                      游離糖 {{ $dateAvg->dsugar }} 公克
                    </div>
                    <div class="col-sm-3 col-xs-6">
                      糖的熱量 {{ $dateAvg->dtcal }} 大卡
                    </div>
                    <div class="col-sm-3 col-xs-6">
                      游離糖量比例 {{ $dateAvg->dpercent }}
                    </div>
                  </div>
                </div>
        	 </div>
              </h4>
            </div>
          
  @endif
        <br>
       

                @if (isset($mealRecordDays))
                    @foreach($mealRecordDays as $index=>$mealRecordDay)
                        <div class="panel panel-{{ Helper::getBSColor($mealRecordDay->percent) }}">
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
                                                        游離糖 {{ $mealRecordDay->weight }} 公克
                                                    </div>
                                                    <div class="col-sm-3 col-xs-6">
                                                        糖的熱量 {{ $mealRecordDay->calories }} 大卡
                                                    </div>
                                                     <div class="col-sm-3 col-xs-6">
                                                        游離糖量比例 {{ $mealRecordDay->percent }}
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
                                                     <div class="col-sm-2 col-xs-4">
                                                        游離糖 {{ $mealRecord->weight }} 公克
                                                    </div>
                                                    <div class="col-sm-2 col-xs-4">
                                                        糖的熱量 {{ $mealRecord->calories }} 大卡
                                                    </div>
                                                    <div class="col-sm-2 col-xs-4">
                                                        游離糖量比例 {{ $mealRecord->percent }}
                                                    </div>
                                                    <div class="col-md-2 col-sm-4 col-xs-6">
                                                        {{ $mealRecord->name }}
                                                        <br class="visible-xs">
                                                    </div>
                                                    <div class="col-md-2 col-sm-4 col-xs-6">
                                                        <a class="btn btn-warning"
                                                           href="{{ route('mealRecord.edit', ['id'=>$mealRecord->id]) }}?url={{ 'dateMealRecord.readList' }}">修改</a>
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