@extends('layouts.app')

@section('title')
    群組成員管理
@endsection

@section('style')
    <style>
        #weeklyDiv{
            margin-bottom: 25px;
            border: 1px solid black;
        }
        .panel-body .row{
        margin-bottom: 10px;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
      @if( count($groups)>0 )
      
      @foreach($groups as $index=>$group)
        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="heading-{{ $index }}">
            <h4 class="panel-title">
              <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{ $index }}" aria-expanded="false" aria-controls="collapse-{{ $index }}">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-sm-3 col-xs-6">
                      編號：{{ $group->id }}
                    </div>
                    <div class="col-sm-3 col-xs-6">
                      名稱：{{ $group->name }}
                    </div>
                    <div class="col-sm-3 col-xs-6">
                      成員數量：{{ $group->amount }}
                    </div>
                    <div class="col-sm-3 col-xs-6">
                      目前申請數： {{ $group->applying }}
                    </div>
                  </div>
                </div>
              </a>
            </h4>
          </div>
          <div id="collapse-{{ $index }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-{{ $index }}">
            <div class="panel-body">
            		<div class="row">
              		<div class="col-md-offset-8 col-md-2 col-sm-offset-6 col-sm-3">
              			
              		</div>
              		<div class="col-md-2 col-sm-3">
              			<a class="btn btn-info btn-block" href="{{ route('group.detail',['id'=>$group->id]) }}">詳細資料</a>
              		</div>
            		</div>
              <ul class="list-group">
				@foreach($group->member() as $user)
                <li class="list-group-item list-group-item-default">
                  <div class="container-fluid">
                    <div class="col-sm-3 col-xs-6">
                      成員編號：{{ $user->id }}
                    </div>
                    <div class="col-sm-3 col-xs-6">
                      使用者：{{ $user->username }}
                    </div>
                    <div class="col-sm-3 col-xs-6">
                      暱稱：{{ $user->nickname }}
                    </div>
                    <div class="col-sm-3 col-xs-6">
                      已輸入：{{ $user->getSevenMealRecordAmount() }} / 7天
                    </div>
                  </div>
                </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      @endforeach
      @else


    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="heading-0">
        <h4 class="panel-title">
          <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-0" aria-expanded="false" aria-controls="collapse-0">
            <div class="container-fluid">
              <div class="row">
                <div class="col-sm-3 col-xs-6">
                  目前沒有管理群組
                </div>
              </div>
            </div>
          </a>
        </h4>
      </div>
    </div>


      @endif
      </div>
    </div>
  </div>
</div>




@endsection