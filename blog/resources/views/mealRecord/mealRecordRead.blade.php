@extends('layouts.app')

@section('title')
今日攝食列表
@endsection

@section('content')

    <a class="btn btn-primary" href="{{ route('mealRecord.create') }}">新增</a>
    <br><br>
    @if (isset($mealRecords))
        <ul class="list-group">
            @foreach($mealRecords as $mealRecord)
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
                      <a class="btn btn-warning" href="{{ route('mealRecord.edit', ['id'=>$mealRecord->id]) }}">修改</a>
                      <br>
                    </div>
                  </div>
                </li>
            @endforeach
        </ul>
    @endif

@endsection