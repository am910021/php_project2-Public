@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="{{ asset('static/bootstrap-dialog/css/bootstrap-dialog.css') }}">
<link rel="stylesheet" href="{{ asset('static/bootstrap-table/bootstrap-table.css') }}">
@endsection

@section('javascript')
<script src="{{ asset('static/bootstrap-dialog/js/bootstrap-dialog.js') }}"></script>
<script src="{{ asset('static/bootstrap-table/bootstrap-table.js') }}"></script>
<script src="{{ asset('static/bootstrap-table/extensions/cookie/bootstrap-table-cookie.js') }}"></script>
<script src="{{ asset('static/bootstrap-table/extensions/filter-control/bootstrap-table-filter-control.js') }}"></script>
<script src="{{ asset('static/bootstrap-table/locale/bootstrap-table-zh-TW.js') }}"></script>
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
	    message: '{!! $html !!}',
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
            <form id="modify_form" class="form-horizontal" action="{{ route('user.update') }}" method="post">
              {{ csrf_field() }}
              <div class="form-group {{ $errors->has('email')?"has-error":"" }}">
              <label for="email" class="col-sm-1 control-label"></label>
              <div class="col-sm-6">
                  <div class="input-group">
                    <span class="input-group-addon">電子郵件</span>
					<input type="text" class="form-control" id="email" name="email" readonly value="{{ Auth::user()->email }}">
                  </div>
              </div>
              @if($errors->has('email'))
              <div class="col-sm-3">
                <span class="help-block">
                <b>{{ $errors->first('email') }}</b>
                </span>
              </div>
              @endif
              </div>
              <div class="form-group {{ $errors->has('username')?"has-error":"" }}">
              <label for="username" class="col-sm-1 control-label"></label>
              <div class="col-sm-6">
                  <div class="input-group">
                    <span class="input-group-addon">&nbsp;&nbsp;使&nbsp;用&nbsp;者&nbsp;</span>
                    <input type="text" class="form-control" id="username" name="username" aria-describedby="usernameHelp" placeholder="請輸入姓名" value="{{ Auth::user()->username }}">
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
                    <input type="text" class="form-control" id="nickname" name="nickname" aria-describedby="nicknameHelp" placeholder="請輸入暱稱" value="{{ Auth::user()->nickname }}">
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
                    <input type="text" class="form-control" id="group_text" aria-describedby="groupHelp" value="{{ Auth::user()->group()->name }}" readonly onclick="selectGroup()" >
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
                    <input type="text" class="form-control" id="remarks" name="remarks" aria-describedby="remarksHelp" value="{{ Auth::user()->remarks }}">
                  </div>
                  <small id="remarksHelp" class="form-text text-muted">一般使用者可不用輸入。</small>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-1 col-sm-4">
                  <button type="submit" class="btn btn-primary btn-xs-block">儲存</button>
                  <br>
                </div>
                <div class="col-sm-4">
                  <a href="{{ route('user.password') }}" class="btn btn-warning btn-xs-block">修改密碼</a>
                </div>
              </div>
            </form>
		</div>
	</div>
</div>
@endsection
