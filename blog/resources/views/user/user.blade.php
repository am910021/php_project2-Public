@extends('layouts.app')

@section('content')


    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6 well">
          <div class="row">
            <div class="col-md-12">
              <h3>個人設定</h3>
              <p >年齡: {{ $userProfile->age }}</p>
              <p >身高: {{ $userProfile->height }}</p>
              <p >體重: {{ $userProfile->weight }}</p>
              <p >性別: {{ $userProfile->sexValue }}</p>
              <p>活動量: {{ $userProfile->activityAmountValue }}</p>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <a class="btn btn-info btn-block" href="{{ route('userProfile.edit') }}">修改個人設定</a>
            </div>
            <div class="col-md-9"></div>
          </div>
        </div>
        <div class="col-md-6 well">
          <div class="row">
            <div class="col-md-12">
              <h3>帳號設定</h3>
              <p >電子郵件: {{ Auth::user()->email }}</p>
              <p >使用者名字: {{ Auth::user()->username }}</p>
              <p >暱稱: {{ Auth::user()->nickname }}</p>
              <p >群組: {{ Auth::user()->group }}</p>
              <p>備注: {{ Auth::user()->remarks }}</p>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <a class="btn btn-info btn-block" href="{{ route('user.edit') }}">修改帳號設定</a>
            </div>
            <div class="col-md-9"></div>
          </div>
        </div>
      </div>
    </div>


@endsection


