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
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <a class="btn btn-info btn-block" href="{{ route('admin.showUser') }}">會員管理</a>
            </div>
            <div class="col-md-9"></div>
          </div>
        </div>
        <div class="col-md-6 well">
          <div class="row">
            <div class="col-md-12">
              <h3>群組統計</h3>
              <p>群組數量：{{ $groups }}</p>
              <p>已加入群組會員數：{{ $inGroupMember }}</p>
              <p>未加入群組會員數：{{ $noGroupMember }}</p>
              <p>&nbsp;</p>

              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <a class="btn btn-info btn-block" href="{{ route('admin.showGroup') }}">群組管理</a>
            </div>
            <div class="col-md-9"></div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 well">
          <div class="row">
            <div class="col-md-12">
              <h3>食品種類統計</h3>
              <p>類別數量： {{ $category }} </p>
              <p>自訂義數量： {{ $customFood }} </p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <a class="btn btn-info btn-block" href="{{ route('admin.showCategory') }}">食品種類管理</a>
            </div>
            <div class="col-md-9"></div>
          </div>
        </div>
      </div>
    </div>

@endsection