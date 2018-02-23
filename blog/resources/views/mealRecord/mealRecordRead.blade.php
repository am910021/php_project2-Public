@extends('layouts.app')

@section('title')
今日攝食列表
@endsection

@section('style')
<style>
.li-success{
background-color: #dff0d8;
}
.li-warning{
background-color: #fcf8e3;
}
.li-danger{
background-color: #f2dede;
}


</style>
@endsection


@section('content')

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-3 col-xs-6">
          <a class="btn btn-primary btn-block" href="{{ route('mealRecord.create') }}">新增</a>
          <br class="visible-xs">
        </div>
        <div class="col-md-offset-6 col-md-3 col-xs-6 text-{{ $status[0] }}">
            {{-- <p>攝食：{{ $percent }}%</p> --}}
            {{-- <p>{{ $status[1] }}</p> --}}
            <p>今日建意熱量：{{ Auth::user()->profile()->RecommendedCalories }} 以內</p>
          <br class="visible-xs">
        </div>
      </div>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-md-12">
      @if (isset($mealRecords))
      <ul class="list-group">
        @foreach($mealRecords as $mealRecord)
        <li class="list-group-item list-group-item-default li-{{ $status[0] }}">
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
              糖量比例 {{ $mealRecord->gramByPercent() }}%
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
              <a class="btn btn-warning" href="{{ route('mealRecord.edit', ['id'=>$mealRecord->id]) }}?url={{ 'mealRecord.read' }}">修改</a>
              <br>
            </div>
          </div>
        </li>
        @endforeach
      </ul>
      @endif
    </div>
  </div>
</div>

@endsection