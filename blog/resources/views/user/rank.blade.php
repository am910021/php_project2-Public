@extends('layouts.app')
	
@section('title')

排行榜：{{ Auth::user()->group()->name }}
@endsection
	
@section('content')

<div class="container-fluid">
  @if( Auth::user()->isApplying == 1)
  <div class="row">
    <div class="col-xs-12">
    <h3 class="text-center text-warning">你的群組正在申請中，加入後即可觀看。</h3>
    </div>
  </div>
  @else
  <div class="row">
    <div class="col-xs-12">
    <h3 class="text-center text-info">排行時間：{{ $start_date}}~{{ $end_date}}</h3>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <ul class="list-group">
      
      @foreach($rank as $index=>$user)
      @if( $user != null )
        <li class="list-group-item list-group-item-default">
          <div class="container-fluid">
            <div class="col-sm-3 col-xs-6">
              {{ $index+1 }}
            </div>
            <div class="col-sm-3 col-xs-6">
              {{ $user->username }}
            </div>
            <div class="col-sm-3 col-xs-6">
              分數：{{ $user->score }}
            </div>
          </div>
        </li>
        @else
        <li class="list-group-item list-group-item-default">
          <div class="container-fluid">
            <div class="col-sm-3 col-xs-6">
              {{ $index+1 }}
            </div>
            <div class="col-sm-3 col-xs-6">
              無資料
            </div>
          </div>
        </li>
        @endif
        
        
      @endforeach
      
      </ul>
    </div>
  </div>
  <div class="row">
  	<div class="col-xs-12">
  	<h4>你的排行</h4>
  	
      <ul class="list-group">
      
      @if($self!=null)
        <li class="list-group-item list-group-item-default">
          <div class="container-fluid">
            <div class="col-sm-3 col-xs-6">
              {{ $self_rank+1 }}
            </div>
            <div class="col-sm-3 col-xs-6">
              {{ $self->username }}
            </div>
            <div class="col-sm-3 col-xs-6">
              分數：{{ $self->score }}
            </div>
            <div class="col-sm-3 col-xs-6">
              
            </div>
          </div>
        </li>
		@else
        <li class="list-group-item list-group-item-default">
          <div class="container-fluid">
            <div class="col-sm-3 col-xs-6">
              無資料
            </div>
          </div>
        </li>
      </ul>
      @endif
  	</div>
  </div>
  @endif
</div>


@endsection