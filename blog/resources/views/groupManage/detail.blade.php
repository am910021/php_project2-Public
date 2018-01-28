@extends('layouts.app')

@section('title')
群組詳細資料：{{ $group->name }}
@endsection

@section('style')
    <style>
        .panel-body .row{
        margin-bottom: 10px;
        }
    </style>
@endsection

@section('javascript')
<script type="text/javascript">
function form_sumbit(type){
	$("#apply_reject").val(type);
	$("#apply_reject_form").submit();
}
</script>
@endsection


@section('content')





<br>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="heading-0">
            <h4 class="panel-title">
              <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-0" aria-expanded="false" aria-controls="collapse-0">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-sm-12">
                      編輯群組
                    </div>
                  </div>
                </div>
              </a>
            </h4>
          </div>
          <div id="collapse-0" class="panel-collapse collapse {{ $errors->has('group_name')?"in":"" }}" role="tabpanel" aria-labelledby="heading-0">
            <div class="panel-body">
              <div class="row">
                <div class="col-md-12">
                  <form class="form-horizontal" action="{{ route('group.update', ['id'=>$group->id]) }}" method="post">
                  	{{ csrf_field() }}
                    <div class="form-group {{ $errors->has('group_name')?"has-error":"" }}">
                      <div class="col-sm-9">
                        <div class="input-group">
                          <span class="input-group-addon">群組名稱</span>
                          <input type="text" class="form-control" id="group_name" name="group_name" aria-describedby="nameHelp" placeholder="請輸入群組名稱" value="{{ $group->name }}">
                        </div>
                        <small id="nameHelp" class="form-text text-muted">群組名稱為顯示給所有人看。</small>
                      </div>
                      @if($errors->has('group_name'))
                      <div class="col-sm-3">
                        <span class="help-block">
                        	<b>{{ $errors->first('group_name') }}</b>
                        </span>
                      </div>
                      @endif
                    </div>
                    
                    <div class="form-group {{ $errors->has('group_remarks')?"has-error":"" }}">
                      <div class="col-sm-9">
                        <div class="input-group">
                          <span class="input-group-addon">&nbsp;&nbsp;&nbsp;備&nbsp;&nbsp;&nbsp;&nbsp;注&nbsp;&nbsp;&nbsp;</span>
                          <input type="text" class="form-control" id="group_remarks" name="group_remarks" aria-describedby="remarksHelp" placeholder="請輸備注" value="{{ $group->remarks }}">
                        </div>
                        <small id="remarksHelp" class="form-text text-muted">備注會顯示給所有人，非必要選項。</small>
                      </div>
                      @if($errors->has('group_remarks'))
                      <div class="col-sm-3">
                        <span class="help-block">
                        	<b>{{ $errors->first('group_remarks') }}</b>
                        </span>
                      </div>
                      @endif
                    </div>
            
                    <div class="form-group ">
                      <div class="col-sm-9">
                        <div class="input-group">
                          <span class="input-group-addon">&nbsp;&nbsp;&nbsp;停&nbsp;&nbsp;&nbsp;&nbsp;用&nbsp;&nbsp;&nbsp;</span>
                          <span class="input-group-addon">
                          	<input type="checkbox" id="group_apply" name="group_apply" value="1" {{ $status[$group->canApply]}}>
                          </span>
                          <input type="text" class="form-control invisible" >
                        </div>
                        <small id="nicknameHelp" class="form-text text-muted">此功能會停止新會員的申請。</small>
                      </div>
                      <div class="col-sm-3">
                        <span class="help-block">
                        <b></b>
                        </span>
                      </div>
                    </div>
            
                    <div class="form-group">
                      <div class="col-sm-2">
                        <button type="submit" class="btn btn-danger btn-xs-block">儲存</button>
                        <br class="visible-xs">
                      </div>
                      <div class="col-sm-2">
                        <a href="{{ route('admin.showGroup') }}" class="btn btn-primary btn-xs-block">取消</a>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="heading-1">
            <h4 class="panel-title">
              <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-1" aria-expanded="false" aria-controls="collapse-1">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-sm-12">
                      申請中
                    </div>
                  </div>
                </div>
              </a>
            </h4>
          </div>
          <div id="collapse-1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-1">
            <div class="panel-body">
            @if( count($apply) > 0 )
            <form id="apply_reject_form" action="{{ route('group.apply',['id'=>$group->id]) }}" method="post" >
            {{ csrf_field() }}
            <input type="hidden" id="apply_reject" name="apply_reject" >
              <ul class="list-group">
              	@foreach($apply as $user)
                    <li class="list-group-item list-group-item-default">
                      <div class="container-fluid">
                        <div class="col-sm-3 col-xs-6">
                          <input type="checkbox" name="user_apple[]" value="{{ $user->id }}"><span style="padding-bottom: 20px;"> # {{ $user->id }}</span>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                          使用者：{{ $user->username }}
                        </div>
                        <div class="col-sm-3 col-xs-6">
                          暱稱：{{ $user->nickname }}
                        </div>
                        <div class="col-sm-3 col-xs-6">
                          狀態：<span class="text-danger">申請中</span>
                        </div>
                      </div>
                    </li>
                @endforeach
              </ul>
              <div class="row">
              	<div class="col-sm-2">
              		<button type="button" onclick="form_sumbit(0)" class="btn btn-success btn-xs-block">同意申請</button>
              		<br class="visible-xs">
              	</div>
              	<div class="col-sm-2">
              		<button type="button" onclick="form_sumbit(2)" class="btn btn-danger btn-xs-block">拒絕申請</button>
              	</div>
              </div>
              
              </form>
            @else
                  <ul class="list-group">
                        <li class="list-group-item list-group-item-default">
                          <div class="container-fluid">
                            <div class="col-sm-3 col-xs-6">
                            目前沒有申請者
                            </div>
                          </div>
                        </li>
                  </ul>
            @endif
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="heading-2">
            <h4 class="panel-title">
              <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-2" aria-expanded="false" aria-controls="collapse-2">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-sm-12">
                      目前成員
                    </div>
                  </div>
                </div>
              </a>
            </h4>
          </div>
          <div id="collapse-2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-2">
            <div class="panel-body">
              <ul class="list-group">
              @foreach($member as $user)
                <li class="list-group-item list-group-item-default">
                  <div class="container-fluid">
                    <div class="col-sm-3 col-xs-6">
                      編號：{{ $user->id }}
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
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-offset-10 col-md-2 text-right">
	  <br>
		<a class="btn btn-info btn-default btn-block" href="{{ route('group.manage') }}">回上一頁</a>
      <br>
    </div>
  </div>
</div>


@endsection