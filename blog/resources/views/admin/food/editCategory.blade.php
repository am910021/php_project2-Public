@extends('layouts.app')

@section('title')
正在類別：{{ $category->name }}
@endsection('content')

@section('content')
<br>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
            <form class="form-horizontal" action="{{ route('admin.updateCatrgory', ['id'=>$category->id]) }}" method="post">
                {{ csrf_field() }}
        
              <div class="form-group {{ $errors->has('username')?"has-error":"" }}">
              <label for="username" class="col-sm-1 control-label"></label>
              <div class="col-sm-6">
                  <div class="input-group">
                    <span class="input-group-addon">類別名稱</span>
                    <input type="text" class="form-control" id="categoryName" name="categoryName" aria-describedby="categoryNameHelp" placeholder="請輸入類別名稱" value="{{ $category->name }}">
                  </div>
                  <small id="categoryNameHelp" class="form-text text-muted"></small>
              </div>
              @if($errors->has('categoryName'))
              <div class="col-sm-3">
                <span class="help-block">
                <b>{{ $errors->first('categoryName') }}</b>
                </span>
              </div>
              @endif
              </div>
                
                <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-2">
                        <button type="submit" class="btn btn-danger btn-xs-block">儲存</button>
                    </div>
                    <div class="col-sm-2">
                        <a href="{{ route('admin.showCategory') }}" class="btn btn-primary btn-xs-block">取消</a>
                    </div>
                </div>
            </form>
		</div>
	</div>
</div>
@endsection