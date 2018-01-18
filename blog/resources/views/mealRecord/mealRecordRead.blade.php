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
    @endif

@endsection