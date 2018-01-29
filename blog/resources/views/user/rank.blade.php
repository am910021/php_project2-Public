@extends('layouts.app')
	
@section('title')

排行榜：{{ Auth::user()->group()->name }}
@endsection
	
@section('content')

<div class="container-fluid">
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
</div>


@endsection