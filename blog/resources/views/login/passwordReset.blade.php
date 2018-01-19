@extends('layouts.app')

@section('content')


<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" action="{{ route('password.mail') }}" method="post">
              {{ csrf_field() }}
              <div class="form-group {{ $errors->has('email')?"has-error":"" }}">
              <label for="email" class="col-sm-2 control-label">電子郵件:</label>
              <div class="col-sm-7">
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="請輸入電子郵件" value="{{ old('email') }}">
                <small id="emailHelp" class="form-text text-muted">我們會使用電子郵件來重設您的登入密碼。</small>
              </div>
              @if($errors->has('email'))
              <div class="col-sm-3">
                <span class="help-block">
                <b>{{ $errors->first('email') }}</b>
                </span>
              </div>
              @endif
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-8">
                  <button type="submit" class="btn btn-primary btn-xs-block">傳送電子郵件</button>
                </div>
              </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection