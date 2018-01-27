@extends('layouts.app')
	
@section('title')

排行榜：{{ Auth::user()->group()->name }}
@endsection
	
@section('content')

{{ count($user) }}

<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12">
      <ul class="list-group">
      
        <li class="list-group-item list-group-item-default">
          <div class="container-fluid">
            <div class="col-sm-3 col-xs-6">
              01:00:38
            </div>
            <div class="col-sm-3 col-xs-6">
              熱量 136 大卡
            </div>
            <div class="col-sm-3 col-xs-6">
              糖量比例 23.96
            </div>
            <div class="col-sm-3 col-xs-6">
              糖 34 公克
            </div>
          </div>
        </li>
        
      </ul>
    </div>
  </div>
</div>


@endsection