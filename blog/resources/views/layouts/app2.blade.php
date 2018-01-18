<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
</head>
<body>

@if(!Auth::check())
    <a href="{{ route('register') }}">註冊</a>
    <a href="{{ route('login') }}">登入</a>
@else
    {{ Auth::user()->username}} 已登入，
    <a href="{{ route('logout') }}">登出</a>
    <a href="">七日統計圖表</a>
    <a href="{{ route('sevenList.read') }}">七日飲食列表</a>
    <a href="{{ route('mealRecord.read') }}">輸入當日的飲食</a>
    <a href="">輸入非當日的飲食</a>
    <a href="">時間統計圖表</a>
    <a href="">時間列表</a>
    <a href="{{ route('userProfile.read') }}">個人資料</a>
@endif

@if(session()->has('message'))
    {!! session()->get('message') !!}
@endif

<div id="content">
    @yield('content')
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
@yield('javascript')
</body>
</html>