@extends('layouts.app')

@section('content')

    @if ($errors->has('fail'))
	<div class="alert alert-danger fade in">
			<a href="#" class="close" data-dismiss="alert">×</a>
		<strong>{{ $errors->first('fail') }}</strong>
	</div>
    @endif

    <form class="form-horizontal" action="{{ route('login') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group {{ $errors->has('email')?"has-error":"" }}">
            <label for="email" class="col-sm-2 control-label">帳號:</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}">
            </div>
            @if($errors->has('email'))
                <div class="col-sm-3">
                    <span class="help-block">
                        <b>{{ $errors->first('email') }}</b>
                    </span>
                </div>
            @endif
        </div>

        <div class="form-group {{ $errors->has('password')?"has-error":"" }}">
            <label for="password" class="col-sm-2 control-label">密碼:</label>
            <div class="col-sm-7">
                <input type="password" class="form-control" id="password" name="password">
            </div>
            @if($errors->has('password'))
                <div class="col-sm-3">
                    <span class="help-block">
                        <b>{{ $errors->first('password') }}</b>
                    </span>
                </div>
            @endif
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-3">
                <button type="submit" class="btn btn-primary btn-xs-block">登入</button>
            </div>
            <div class="col-sm-3">
                <a href="{{ route('password.reset') }}" class="btn btn-success btn-xs-block">忘記密碼</a>
            </div>
        </div>
    </form>

@endsection