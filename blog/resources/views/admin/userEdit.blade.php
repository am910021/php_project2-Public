@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="{{ asset('static/bootstrap-dialog/css/bootstrap-dialog.css') }}">
@endsection

@section('javascript')
<script src="{{ asset('static/bootstrap-dialog/js/bootstrap-dialog.js') }}"></script>
<script type="text/javascript">
var $in_group = $("#group");
var $in_group_text = $("#group_text");
function searchText(input, table) {
	  var filter, rows, row, td, i;
	  filter = input.value.toUpperCase();
	  rows = table.find("tr");
	  rows.each(function(index) {
	    td = $(this).find("td"); //判斷是否為空行
	    if (td.length > 0) {
	      	if (td[2].innerHTML.toUpperCase().indexOf(filter) > -1 ||
	      			td[3].innerHTML.toUpperCase().indexOf(filter) > -1) {
	      		this.style.display = "";
	        } else {
	        	this.style.display = "none";
	        }
	    }
	  });
	};

	function searchId(input, table) {
		  var filter, rows, row, td, i;
		  filter = input.value.toUpperCase();
		  rows = table.find("tr");
		  rows.each(function(index) {
		    td = $(this).find("td"); //判斷是否為空行
		    if (td.length > 0) {
		      	if (td[1].innerHTML.toUpperCase().indexOf(filter) > -1) {
		      		this.style.display = "";
		        } else {
		        	this.style.display = "none";
		        }
		    }
		  });
		};

function updateRow($table){
    	$table.find('tbody tr:even').addClass("warning");
    	$table.find('tbody tr:odd').addClass("success");
};

function selectGroup() {
	  BootstrapDialog.show({
	    message: '{!! $table !!}',
	    onshow: function(dialogRef) {
	      var $table = dialogRef.getModalBody().find('#table');
	      var $group_manager = dialogRef.getModalBody().find('#group_manager');
	      var $group_id = dialogRef.getModalBody().find('#group_id');
	      dialogRef.getModalBody().find("[name='optradio'][value='"+$in_group.val()+"']").prop('checked', true);;

	      $group_manager.change(function() {
	    	  $group_id.val("");
	        searchText(this, $table);
	        updateRow($table);
	      });
	      $group_id.change(function() {
	    	  $group_manager.val("");
	        searchId(this, $table);
	        updateRow($table);
	      });

	      updateRow($table);
	    },
	    buttons: [{
	      label: '確定',
	      cssClass: 'btn-success',
	      action: function(dialogRef) {
	        var fruit = dialogRef.getModalBody().find("[name='optradio']:checked");
	        $in_group.val(fruit.val());
	        $in_group_text.val(fruit.parent().next().next().html());
	        dialogRef.close();
	      }
	    }, {
	      label: '取消',
	      cssClass: 'btn-warning',
	      action: function(dialogRef) {
	        dialogRef.close();
	      }
	    }]
	  });
	};
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
              <label for="username" class="col-sm-1 control-label"></label>
              <div class="col-sm-6">
                  <div class="input-group">
                    <span class="input-group-addon">&nbsp;&nbsp;使&nbsp;用&nbsp;者&nbsp;</span>
                    <input type="text" class="form-control" id="username" name="username" aria-describedby="usernameHelp" placeholder="請輸入姓名" value="{{ $user->username }}">
                  </div>
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
              <label for="nickname" class="col-sm-1 control-label"></label>
              <div class="col-sm-6">
                  <div class="input-group">
                    <span class="input-group-addon">&nbsp;&nbsp;&nbsp;暱&nbsp;&nbsp;&nbsp;&nbsp;稱&nbsp;&nbsp;&nbsp;</span>
                    <input type="text" class="form-control" id="nickname" name="nickname" aria-describedby="nicknameHelp" placeholder="請輸入暱稱" value="{{ $user->nickname }}">
                  </div>
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
                <label for="group" class="col-sm-1 control-label"></label>
                <div class="col-sm-6">
                  <input type="hidden" class="form-control" id="group" name="group" value="{{ Auth::user()->group()->id }}" >
                  <div class="input-group">
                    <span class="input-group-addon">&nbsp;&nbsp;&nbsp;群&nbsp;&nbsp;&nbsp;&nbsp;組&nbsp;&nbsp;&nbsp;</span>
                    <input type="text" class="form-control" id="group_text" aria-describedby="groupHelp" value="{{ $user->group()->name }}" readonly onclick="selectGroup()" >
                  </div>
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
                <label for="remarks" class="col-sm-1 control-label"></label>
                <div class="col-sm-6">
                  <div class="input-group">
                    <span class="input-group-addon">&nbsp;&nbsp;&nbsp;備&nbsp;&nbsp;&nbsp;&nbsp;注&nbsp;&nbsp;&nbsp;</span>
                    <input type="text" class="form-control" id="remarks" name="remarks" aria-describedby="remarksHelp" value="{{ $user->remarks }}">
                  </div>
                  <small id="remarksHelp" class="form-text text-muted">一般使用者可不用輸入。</small>
                </div>
              </div>
        
                <div class="form-group {{ $errors->has('type')?"has-error":"" }}">
                    <label for="type" class="col-sm-1 control-label"></label>
                    <div class="col-sm-6">
                      <div class="input-group">
                        <span class="input-group-addon">&nbsp;&nbsp;&nbsp;權&nbsp;&nbsp;&nbsp;&nbsp;限&nbsp;&nbsp;&nbsp;</span>
                          <select class="form-control" id="type" name="type" aria-describedby="typeHelp">
                            @if(Auth::user()->type <=0)<option value="0" @if($user->type ==0)selected @endif>超級管理員</option>@endif
                            @if(Auth::user()->type <=1)<option value="1" @if($user->type ==1)selected @endif>群組管理員</option>@endif
                            <option value="2" @if($user->type ==2)selected @endif>教師人員</option>
                            <option value="3" @if($user->type ==3)selected @endif>一般會員</option>
                          </select>
                      </div>
                      <small id="typeHelp" class="form-text text-muted">選擇權限之前請先確認。</small>
                    </div>
                    @if($errors->has('type'))
					<div class="col-sm-2">
                            <span class="help-block">
                            	<b>{{ $errors->first('type') }}</b>
                            </span>
                    </div>
                    @endif
                </div>
                
                <div class="form-group has-error">
                  <label for="isActive" class="col-sm-1 control-label"></label>
                  <div class="col-sm-6">
                    <div class="input-group">
                      <span class="input-group-addon">&nbsp;&nbsp;&nbsp;停&nbsp;&nbsp;&nbsp;&nbsp;用&nbsp;&nbsp;&nbsp;</span>
                      <span class="input-group-addon">
                      	<input type="checkbox" id="isActive" name="isActive" aria-describedby="isActiveHelp" value="1" {{ $status[$user->isActive]}}>
                      </span>
                      <input type="text" class="form-control invisible" >
                    </div>
                    <small id="isActiveHelp" class="form-text text-muted">此功能會停止會員登入許可，請確認後在近行。</small>
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