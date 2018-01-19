@extends('layouts.app')

@section('content')
<style>
<!--
img {
    display: block;
    margin-left: auto;
    margin-right: auto;
   width:auto%;
   height:auto;

}
-->
</style>
<img id="poster" align="middle" src="{{ asset('img/background.png') }}">

@endsection

@section('javascript')
 <script type="text/javascript">
$_main = $("#main-contant");
$_poster = $("#poster").css("height",$(window).height()-120);

$( window ).resize(function() {
	$_poster = $("#poster").css("height",$(window).height()-120);
	});

console.log($_main.outerHeight());
console.log($(window).height()-166);
</script>
@endsection