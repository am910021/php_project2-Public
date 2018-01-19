@extends('layouts.app')

@section('content')
@if ($error)
<div class="container-fluid">
  <div class="row">
    <div class="col-md-2">
    </div>
    <div class="col-md-8">
      <h3 class="text-danger">
        糟糕! 這個鏈結已經過期了～
      </h3>
      <p>
        因為您超過24小時未使用此鏈結，請重發送重置帳號以取得新的啟動鏈結。
      </p>
    </div>
    <div class="col-md-2">
    </div>
  </div>
</div>
@else
<div class="container-fluid">
  <div class="row">
    <form class="form-horizontal" action="{{ route('login.pwdUpdateByURL',['key'=>$enable_key]) }}" method="post">
      {{ csrf_field() }}
      <div class="form-group">
        <label for="email" class="col-sm-2 control-label">電子郵件:</label>
        <div class="col-sm-7">
          <input type="text" class="form-control" id="email" name="email" readonly aria-describedby="emailHelp" value="{{ $email }}">
          <small id="emailHelp" class="form-text text-muted">電子郵件為您登入用的帳號。</small>
        </div>
        <div class="col-sm-3">
          <span class="help-block">
          <b></b>
          </span>
        </div>
      </div>
      <div class="form-group {{ $errors->has('password')?" has-error ":" " }}">
        <label for="password" class="col-sm-2 control-label">新密碼:</label>
        <div class="col-sm-7">
          <input type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp" placeholder="請輸入新密碼">
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
        <label for="password2" class="col-sm-2 control-label">確認密碼:</label>
        <div class="col-sm-7">
          <input type="password" class="form-control" id="password2" name="password2" aria-describedby="password2Help" placeholder="請輸入確認密碼">
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
        <div class="col-sm-offset-2 col-sm-8">
          <button type="submit" class="btn btn-primary btn-xs-block">修改密碼</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endif
@endsection