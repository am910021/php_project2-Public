@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="{{ asset('static/bootstrap-dialog/css/bootstrap-dialog.css') }}">
@endsection

@section('javascript')
<script src="{{ asset('static/bootstrap-dialog/js/bootstrap-dialog.js') }}"></script>
<script type="text/javascript">
var $in_manager = $("#group_manager");
var $in_managerName = $("#group_text");

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
		$table.find('thead tr').addClass("info");
    	$table.find('tbody tr:even').addClass("warning");
    	$table.find('tbody tr:odd').addClass("success");
};

function selectGroup() {
	  BootstrapDialog.show({
	    message: '{!! $table !!}',
	    onshow: function(dialogRef) {
	      var $table = dialogRef.getModalBody().find('#table');
	      var $search_username = dialogRef.getModalBody().find('#search_username');
	      var $search_id = dialogRef.getModalBody().find('#search_id');
	      dialogRef.getModalBody().find("[name='optradio'][value='"+$in_manager.val()+"']").prop('checked', true);;

	      $search_username.change(function() {
	    	  $search_id.val("");
	        searchText(this, $table);
	        updateRow($table);
	      });
	      $search_id.change(function() {
	    	  $search_username.val("");
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
	        $in_manager.val(fruit.val());
	        $in_managerName.val(fruit.parent().next().next().html());
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
  <div class="row">
    <div class="col-md-12">
      <h3 class="text-center text-info" >正在新建群組 </h3>
      <br>
    </div>
  </div>
    <div class="col-md-12">
      <form class="form-horizontal" action="{{ route('admin.groupUpdate') }}" method="post">
      	{{ csrf_field() }}
        <div class="form-group {{ $errors->has('group_manager')?"has-error":"" }}">
          <div class="col-md-offset-2 col-md-5 col-sm-7">
            <input type="hidden" class="form-control" id="group_manager" name="group_manager" @if(old('group_manager')!=NULL) value="{{old('group_manager')}}" @else value="1" @endif>
            <div class="input-group">
              <span class="input-group-addon">&nbsp;&nbsp;管&nbsp;理&nbsp;員&nbsp;</span>
              <input type="text" class="form-control" id="group_text" name="group_text" aria-describedby="managerHelp" @if(old('group_text')!=NULL) value="{{old('group_text')}}" @else value="root" @endif readonly onclick="selectGroup()" >
            </div>
            <small id="managerHelp" class="form-text text-muted">管理員名稱只有教師以上的成員會顯示，一般成員會顯示暱稱。</small>
          </div>
          <div class="col-md-2 col-sm-3">
            <button type="button" onclick="selectGroup()" class="btn btn-info btn-block">選擇管理者</button>
          </div>
          @if($errors->has('group_manager'))
          <div class="col-md-3 col-sm-2">
            <span class="help-block">
            	<b>{{ $errors->first('group_manager') }}</b>
            </span>
          </div>
          @endif
        </div>
        
        <div class="form-group {{ $errors->has('group_name')?"has-error":"" }}">
          <div class="col-md-offset-2 col-md-5 col-sm-7">
            <div class="input-group">
              <span class="input-group-addon">群組名稱</span>
              <input type="text" class="form-control" id="group_name" name="group_name" aria-describedby="nameHelp" placeholder="請輸入群組名稱" value="{{ old('group_name') }}">
            </div>
            <small id="nameHelp" class="form-text text-muted">群組名稱為顯示給所有人看。</small>
          </div>
          @if($errors->has('group_name'))
          <div class="col-md-5 col-sm-5">
            <span class="help-block">
            	<b>{{ $errors->first('group_name') }}</b>
            </span>
          </div>
          @endif
        </div>
        
        <div class="form-group {{ $errors->has('group_remarks')?"has-error":"" }}">
          <div class="col-md-offset-2 col-md-5 col-sm-7">
            <div class="input-group">
              <span class="input-group-addon">&nbsp;&nbsp;&nbsp;備&nbsp;&nbsp;&nbsp;&nbsp;注&nbsp;&nbsp;&nbsp;</span>
              <input type="text" class="form-control" id="group_remarks" name="group_remarks" aria-describedby="remarksHelp" placeholder="請輸備注" value="{{ old('group_remarks') }}">
            </div>
            <small id="remarksHelp" class="form-text text-muted">備注會顯示給所有人，非必要選項。</small>
          </div>
          @if($errors->has('group_remarks'))
          <div class="col-md-5 col-sm-5">
            <span class="help-block">
            	<b>{{ $errors->first('group_remarks') }}</b>
            </span>
          </div>
          @endif
        </div>

        <div class="form-group ">
          <div class="col-md-offset-2 col-md-5 col-sm-7">
            <div class="input-group">
              <span class="input-group-addon">&nbsp;&nbsp;&nbsp;停&nbsp;&nbsp;&nbsp;&nbsp;用&nbsp;&nbsp;&nbsp;</span>
              <span class="input-group-addon">
              	<input type="checkbox" id="group_apply" name="group_apply" value="1">
              </span>
              <input type="text" class="form-control invisible" >
            </div>
            <small id="nicknameHelp" class="form-text text-muted">此功能會停止新會員的申請。</small>
          </div>
          <div class="col-md-5 col-sm-5">
            <span class="help-block">
            <b></b>
            </span>
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-2">
            <button type="submit" class="btn btn-danger btn-xs-block">儲存</button>
          </div>
          <div class="col-sm-2">
            <a href="{{ route('admin.showGroup') }}" class="btn btn-primary btn-xs-block">取消</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection