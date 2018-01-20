@extends('layouts.app')

@section('content')


    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6 well">
          <div class="row">
            <div class="col-md-12">
              <h3>會員統計</h3>
              <p>超級管理員： {{ $root }} </p>
              <p>群組管理員： {{ $group }} </p>
              <p>教師人員： {{ $teacher }}</p>
              <p>一般會員： {{ $normal }}</p>
              <p></p>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <a class="btn btn-info btn-block" href="{{ route('admin.showUser') }}">會員管理</a>
            </div>
            <div class="col-md-9"></div>
          </div>
        </div>
        <div class="col-md-6 well">
          <div class="row">
            <div class="col-md-12">
              <h3>群組統計</h3>
              <p></p>
              <p></p>
              <p></p>
              <p></p>
              <p></p>
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