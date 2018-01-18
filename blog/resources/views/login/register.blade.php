@extends('layouts.app')

@section('content')
    @if ($errors->has('fail'))
        <div class="fail">{{ $errors->first('fail') }}</div>
    @endif

	
    <form class="form-horizontal" action="{{ route('register') }}" method="post">
        {{ csrf_field() }}

        <div class="form-group {{ $errors->has('email')?"has-error":"" }}">
            <label for="email" class="col-sm-2 control-label">電子郵件:</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="請輸入電子郵件" value="{{ old('email') }}">
            	<small id="emailHelp" class="form-text text-muted">電子郵件將會成為您登入的帳號。</small>
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
            <div class="col-sm-7">
                <input type="text" class="form-control" id="username" name="username" aria-describedby="usernameHelp" placeholder="請輸入姓名" value="{{ old('username') }}">
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
            <div class="col-sm-7">
                <input type="text" class="form-control" id="nickname" name="nickname" aria-describedby="nicknameHelp" placeholder="請輸入暱稱" value="{{ old('nickname') }}">
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

        <div class="form-group">
            <label for="group" class="col-sm-2 control-label">群組:</label>
            <div class="col-sm-7">
                    <select class="form-control" id="group" name="group" aria-describedby="groupHelp">
                      <option value="1">One</option>
                      <option value="2">Two</option>
                      <option value="3">Three</option>
                      <option value="4">Four</option>
                      <option value="5">Five</option>
                    </select>
            	<small id="groupHelp" class="form-text text-muted">群組預設為無。</small>
            </div>
        </div>

        <div class="form-group">
            <label for="remarks" class="col-sm-2 control-label">備注:</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="remarks" name="remarks" aria-describedby="remarksHelp" value="{{ old('remarks') }}">
            	<small id="remarksHelp" class="form-text text-muted">一般使用者可不用輸入。</small>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-8">
            	<small id="remarksHelp" class="form-text text-muted text-info"><b>* 密碼將在帳號啟用後設定。</b></small>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-8">
                <button type="submit" class="btn btn-primary btn-xs-block">註冊</button>
            </div>
        </div>
    </form>

@endsection