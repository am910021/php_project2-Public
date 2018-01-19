<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>減糖新運動</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('css/_all-skins.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
    <!-- Daterange picker -->
    <!-- <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css"> -->
    <!-- bootstrap wysihtml5 - text editor -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @yield('style')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="{{ route('index') }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>減糖</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>減糖新運動</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    @if(!Auth::check())
                        <li class="dropdown user user-menu">
                            <a href="{{ route('register') }}">
                                <i class="fa fa-user-plus"></i><span>註冊</span>
                            </a>
                        </li>
                        <li class="dropdown user user-menu">
                            <a href="{{ route('login') }}">
                                <i class="fa fa-sign-in"></i><span>登入</span>
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('user') }}">
                                <i class=""></i><span>{{ Auth::user()->username }}({{ Auth::user()->nickname}})</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}">
                                <i class="fa fa-sign-out"></i><span>登出</span>
                            </a>
                        </li>
                    {{--<li class="dropdown user user-menu">--}}
                    {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
                    {{--<img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">--}}
                    {{--<span class="hidden-xs">Alexander Pierce</span>--}}
                    {{--</a>--}}
                    {{--<ul class="dropdown-menu">--}}
                    {{--<!-- User image -->--}}
                    {{--<li class="user-header">--}}
                    {{--<img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">--}}

                    {{--<p>--}}
                    {{--Alexander Pierce - Web Developer--}}
                    {{--<small>Member since Nov. 2012</small>--}}
                    {{--</p>--}}
                    {{--</li>--}}
                    {{--<!-- Menu Body -->--}}
                    {{--<li class="user-body">--}}
                    {{--<div class="row">--}}
                    {{--<div class="col-xs-4 text-center">--}}
                    {{--<a href="#">Followers</a>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-4 text-center">--}}
                    {{--<a href="#">Sales</a>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-4 text-center">--}}
                    {{--<a href="#">Friends</a>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<!-- /.row -->--}}
                    {{--</li>--}}
                    {{--<!-- Menu Footer-->--}}
                    {{--<li class="user-footer">--}}
                    {{--<div class="pull-left">--}}
                    {{--<a href="#" class="btn btn-default btn-flat">Profile</a>--}}
                    {{--</div>--}}
                    {{--<div class="pull-right">--}}
                    {{--<a href="#" class="btn btn-default btn-flat">Sign out</a>--}}
                    {{--</div>--}}
                    {{--</li>--}}
                    {{--</ul>--}}
                    {{--</li>--}}
                @endif

                <!-- Control Sidebar Toggle Button -->
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <!-- <li class="header">MAIN NAVIGATION</li> -->
                {{--class="active"--}}
                @if(!Auth::check())
                    <li>
                        <a href="{{ route('register') }}">
                            <i class="fa fa-user-plus"></i><span>註冊</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('login') }}">
                            <i class="fa fa-sign-in"></i><span>登入</span>
                        </a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('logout') }}">
                            <i class="fa fa-sign-out"></i><span>登出</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('sevenMealRecord.readChart') }}"">
                            <i class="fa fa-calendar"></i><span>七日統計圖表</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('sevenMealRecord.readList') }}">
                            <i class="fa fa-list-ol"></i><span>七日飲食列表</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('mealRecord.read') }}">
                            <i class="fa fa-cutlery"></i><span>輸入當日的飲食</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('mealRecord.createDate') }}">
                            <i class="fa fa-cutlery"></i><span>輸入非當日的飲食</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dateMealRecord.readChart') }}">
                            <i class="fa fa-line-chart"></i><span>歷史統計圖表</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dateMealRecord.readList') }}">
                            <i class="fa fa-list-alt"></i><span>歷史列表</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user') }}">
                            <i class="fa fa-book"></i><span>帳號資料</span>
                        </a>
                    </li>
                    @if( Auth::user()->type <3 )
                    <li>
                    	<a >
                    		<i class="fa fa-server"></i><span>管理</span>
                    	</a>
                    </li>
                    @endif
            @endif

            <!-- <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
            <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
          </ul>
        </li> -->

            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="main-contant">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            @if(session()->has('message'))
                <div class="alert alert-success fade in">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>{{ session()->get('message') }}</strong>
                </div>
            @endif
            @if(session()->has('message-fail'))
                <div class="alert alert-danger fade in">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>{{ session()->get('message-fail') }}</strong>
                </div>
            @endif
            {{--<h1>--}}
            {{--Dashboard--}}
            {{--<!-- <small>Control panel</small> -->--}}
            {{--</h1>--}}

            <h2>
                @yield('title')
            </h2>

            @yield('content')
        </section>

        <!-- Main content -->
        <section class="content" style="min-height: 0px;padding:0px">
            <!-- Main row -->
            <div class="row">


            </div>
            <!-- /.row (main row) -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">

        </div>

    </footer>


</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<!-- custom -->
<script src="{{ asset('js/chart.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<!-- daterangepicker -->
<!-- <script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script> -->
<!-- datepicker -->
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<!-- <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script> -->
<!-- Slimscroll -->
<!-- <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script> -->
<!-- FastClick -->
<!-- <script src="bower_components/fastclick/lib/fastclick.js"></script> -->
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="dist/js/pages/dashboard.js"></script> -->
<!-- AdminLTE for demo purposes -->
<!-- <script src="js/demo.js"></script> -->
@yield('javascript')

</body>
</html>
