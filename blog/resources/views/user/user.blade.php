@extends('layouts.app')

@section('content')


    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6 well">
          <div class="row">
            <div class="col-md-12">
              <h3>個人設定</h3>
              <p >年齡: {{ $userProfile->age }} 歲</p>
              <p >身高: {{ $userProfile->height }} 公分</p>
              <p >體重: {{ $userProfile->weight }} 公斤</p>
              <p >性別: {{ $userProfile->sexValue }}&nbsp;|&nbsp;活動量: {{ $userProfile->activityAmountValue }}</p>
              <p>建意熱量: {{ $userProfile->RecommendedCalories }} 以內</p>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-5">
              <a class="btn btn-block btn-primary" href="{{ route('userProfile.edit') }}">更新個人設定</a>
            </div>
          </div>
        </div>
        <div class="col-md-6 well">
          <div class="row">
            <div class="col-md-12">
              <h3>帳號設定</h3>
              <p >電子郵件: {{ Auth::user()->email }}</p>
              <p >使用者名字: {{ Auth::user()->username }}</p>
              <p >暱稱: {{ Auth::user()->nickname }}</p>
              <p >群組: {{ Auth::user()->group()->name }}({{ $status[Auth::user()->isApplying] }})</p>
              <p>備注: {{ Auth::user()->remarks }}</p>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-5">
              <a class="btn btn-block btn-primary" href="{{ route('user.edit') }}">更新帳號設定</a>
            </div>
          </div>
        </div>
      </div>
    </div>


@endsection


