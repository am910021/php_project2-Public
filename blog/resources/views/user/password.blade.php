@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <form class="form-horizontal" action="{{ route('user.password') }}" method="post">
      {{ csrf_field() }}
      <div class="form-group">
        <label for="email" class="col-sm-2 control-label"></label>
        <div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon">電子郵件</span>
				<input type="text" class="form-control" id="email" name="email" readonly aria-describedby="emailHelp" value="{{ Auth::user()->email }}">
			</div>
          <small id="emailHelp" class="form-text text-muted">電子郵件為您登入用的帳號。</small>
        </div>
        <div class="col-sm-3">
          <span class="help-block">
          <b></b>
          </span>
        </div>
      </div>
      <div class="form-group {{ $errors->has('password')?" has-error ":" " }}">
        <label for="password" class="col-sm-2 control-label"></label>
        <div class="col-sm-7">
			<div class="input-group">
				<label class="input-group-addon">&nbsp;&nbsp;新&nbsp;密&nbsp;碼&nbsp;</label>
				<input type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp" placeholder="請輸入新密碼">
			</div>
          <small id="passwordHelp" class="form-text text-muted">此密碼會成為你新的登入用密碼。</small>
        </div>
        @if($errors->has('password'))
        <div class="col-sm-3">
          <span class="help-block">
          <b>{{ $errors->first('password') }}</b>
          </span>
        </div>
        @endif
      </div>
      <div class="form-group {{ $errors->has('password2')?" has-error ":" " }}">
        <label for="password2" class="col-sm-2 control-label"></label>
        <div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon">確認密碼</span>
				<input type="password" class="form-control" id="password2" name="password2" aria-describedby="password2Help" placeholder="請輸入確認密碼">
			</div>
          <small id="password2Help" class="form-text text-muted"></small>
        </div>
        @if($errors->has('password2'))
        <div class="col-sm-3">
          <span class="help-block">
          <b>{{ $errors->first('password2') }}</b>
          </span>
        </div>
        @endif
      </div>
      
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-4">
               <button type="submit" class="btn btn-primary btn-xs-block">修改密碼</button>
                <br>
            </div>
            <div class="col-sm-4">
                <a class="btn btn-primary btn-success btn-xs-block" href="{{ route('user') }}">取消</a>
            </div>
        </div>
    </form>
  </div>
</div>
@endsection