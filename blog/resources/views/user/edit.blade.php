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
function myFunction(input, table) {
	  var filter, tr, td, i;
	  filter = input.value.toUpperCase();
	  tr = table.find("tr");
	  tr.each(function( index ) {
		    td = $(this).find("td")[1];
		    if (td) {
		      if ($(this).html().toUpperCase().indexOf(filter) > -1) {
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
  	      dialogRef.getModalBody().find('#group_manager').change(function() {
  	        myFunction(this, $table);
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
  	        $in_group_text.val(fruit.parent().next().html());
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
              <label for="email" class="col-sm-2 control-label">電子郵件:</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="email" name="email" readonly value="{{ Auth::user()->email }}">
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
              <label for="username" class="col-sm-2 control-label">使用者名字:</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="username" name="username" aria-describedby="usernameHelp" placeholder="請輸入姓名" value="{{ Auth::user()->username }}">
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
              <div class="col-sm-5">
                <input type="text" class="form-control" id="nickname" name="nickname" aria-describedby="nicknameHelp" placeholder="請輸入暱稱" value="{{ Auth::user()->nickname }}">
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
                <div class="col-sm-5">
                  <input type="hidden" class="form-control" id="group" name="group" value="{{ Auth::user()->group()->id }}" >
                  <input type="text" class="form-control" id="group_text" aria-describedby="groupHelp" value="{{ Auth::user()->group()->name }}" readonly onclick="selectGroup()" >
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
                <div class="col-sm-5">
                  <input type="text" class="form-control" id="remarks" name="remarks" aria-describedby="remarksHelp" value="{{ Auth::user()->remarks }}">
                  <small id="remarksHelp" class="form-text text-muted">一般使用者可不用輸入。</small>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-4">
                  <button type="submit" class="btn btn-primary btn-xs-block">儲存</button>
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
