@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="{{ asset('static/bootstrap-dialog/css/bootstrap-dialog.css') }}">
@endsection

@section('javascript')
<script src="{{ asset('static/bootstrap-dialog/js/bootstrap-dialog.js') }}"></script>
<script type="text/javascript">
var _group = {'1':'test','2':'test2','3':'test3','4':'test4',}
var _list = "";

for(var index in _group) {
	_list += '<label><input type="radio" id="regular" name="optradio" value="'+index+'">'+_group[index]+'</label><br>';
	}

var $in_group = $("#group");
var $in_group_text = $("#group_text");

console.log( _list );
function selectGroup(){
	BootstrapDialog.show({
	    message: _list,
	    buttons: [{
	        label: '確定',
	        cssClass: 'btn-success',
	        action: function(dialogRef) {
	        	var fruit = dialogRef.getModalBody().find('input:checked');
	        	$in_group.val(fruit.val());
	        	$in_group_text.val(fruit.parent().text());
	            dialogRef.close();
	        }
	    },{
	        label: '取消',
	        cssClass: 'btn-warning',
	        action: function(dialogRef) {
	        	var fruit = dialogRef.getModalBody().find('input:checked').val();
	        	console.log(fruit);
	            dialogRef.close();
	        }
	    }]
	});
}
</script>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<h3 class="text-center text-info" >正在編輯會員：{{ $user->email }}</h3>
			<br>
		</div>
	
	</div>

	<div class="row">
		<div class="col-md-12">
            <form class="form-horizontal" action="{{ route('admin.userUpdate', ['id'=>$user->id]) }}" method="post">
                {{ csrf_field() }}
        
                <div class="form-group {{ $errors->has('username')?"has-error":"" }}">
                    <label for="username" class="col-sm-2 control-label">使用者名字:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="username" name="username" aria-describedby="usernameHelp" placeholder="請輸入姓名" value="{{ $user->username }}">
                    	<small id="usernameHelp" class="form-text text-muted">使用者名字只會顯示給自己和管理者。</small>
                    </div>
                    @if($errors->has('username'))
                        <div class="col-sm-3">
                            <span class="help-block">
                                <b>{{ $errors->first('username') }}</b>
                            </span>
                        </div>
                    @endif
                </div>
        
                <div class="form-group {{ $errors->has('nickname')?"has-error":"" }}">
                    <label for="nickname" class="col-sm-2 control-label">暱稱:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="nickname" name="nickname" aria-describedby="nicknameHelp" placeholder="請輸入暱稱" value="{{ $user->nickname }}">
                    	<small id="nicknameHelp" class="form-text text-muted">暱稱會顯示給所有人。</small>
                    </div>
                    @if($errors->has('nickname'))
                        <div class="col-sm-3">
                            <span class="help-block">
                                <b>{{ $errors->first('nickname') }}</b>
                            </span>
                        </div>
                    @endif
                </div>
        
                <div class="form-group {{ $errors->has('group')?"has-error":"" }}">
                    <label for="group" class="col-sm-2 control-label">群組:</label>
                    <div class="col-sm-4">
						<input type="hidden" class="form-control" id="group" name="group" value="{{ $user->group }}" >
                    	<input type="text" class="form-control" id="group_text" aria-describedby="groupHelp" value="test" readonly onclick="selectGroup()" >
                    	<small id="groupHelp" class="form-text text-muted">群組預設為無。</small>
                    </div>
                    <div class="col-sm-2">
						<button type="button" onclick="selectGroup()" class="btn btn-info btn-xs-block">選擇群組</button>
                    </div>
                    @if($errors->has('group'))
					<div class="col-sm-2">
                            <span class="help-block">
                            	<b>{{ $errors->first('group') }}</b>
                            </span>
                    </div>
                    @endif
                </div>
        
                <div class="form-group">
                    <label for="remarks" class="col-sm-2 control-label">備注:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="remarks" name="remarks" aria-describedby="remarksHelp" value="{{ $user->remarks }}">
                    	<small id="remarksHelp" class="form-text text-muted">一般使用者可不用輸入。</small>
                    </div>
                </div>
        
                <div class="form-group">
                    <label for="type" class="col-sm-2 control-label">權限:</label>
                    <div class="col-sm-4">
                      <select class="form-control" id="type" name="type">
                        <option value="0" @if($user->type ==0)selected @endif>超級管理員</option>
                        <option value="1" @if($user->type ==1)selected @endif>群組管理員</option>
                        <option value="2" @if($user->type ==2)selected @endif>教師人員</option>
                        <option value="3" @if($user->type ==3)selected @endif>一般會員</option>
                      </select>
                    </div>
                </div>
                
                <div class="form-group has-error">
                    <label for="isActive" class="col-sm-2 control-label">停用:</label>
                    <div class="col-sm-4">
                        <input type="checkbox" id="isActive" name="isActive" value="1" {{ $status[$user->isActive]}}>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-2">
                        <button type="submit" class="btn btn-danger btn-xs-block">儲存</button>
                    </div>
                    <div class="col-sm-2">
                        <a href="{{ route('admin.showUser') }}" class="btn btn-primary btn-xs-block">取消</a>
                    </div>
                </div>
            </form>
		</div>
	</div>
</div>
@endsection