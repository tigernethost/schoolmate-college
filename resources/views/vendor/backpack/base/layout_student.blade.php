@php
    $photo = auth()->user()->student->photo;
    $avatar = \Storage::disk('public')->exists($photo) ? 'storage/' . $photo : 'images/headshot-default.png'; 
    auth()->user()->student->photo = $avatar;
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Encrypted CSRF token for Laravel, in order for Ajax requests to work --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>
      {{ isset($title) ? $title.' :: '.config('backpack.base.project_name').' Student Portal' : config('backpack.base.project_name').' Student Portal' }}
    </title>

    @yield('before_styles')
    @stack('before_styles')

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    {{-- <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/dist/css/skins/_all-skins.min.css"> --}}

    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/pace/pace.min.css">
    <link rel="stylesheet" href="{{ asset('vendor/backpack/pnotify/pnotify.custom.min.css') }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!-- BackPack Base CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/backpack/base/backpack.base.css') }}?v=2">
    <link rel="stylesheet" href="{{ asset('vendor/backpack/overlays/backpack.bold.css') }}">
    <link rel="stylesheet" href="{{ asset('css/svg-icons.css') }}">

    <!-- FONT AWESOME KIT -->
    <script src="{{ asset('js/fontawesome-kit.js') }}" crossorigin="anonymous"></script>

    <!-- Sweet Alert2 -->
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    @yield('after_styles')

    <!-- JQUERY CONFIRM CSS -->
    <link rel="stylesheet" href="{{ asset('css/jquery-confirm-3.3.2.min.css') }}">
    <!-- SCHOOLMATE CUSTOM CSS -->
    <link rel="stylesheet" href="{{ asset('css') }}/schoolmate/schoolmate.css">

    @stack('after_styles')
    
    <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900);
        body {
            font-size: 12px;
            font-family: 'Roboto', sans-serif;
            font-weight: 400;
            height: 100%;
            line-height: 1.7;
            vertical-align: baseline;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
            color: #646464;
            background-color: #f0f1f3;  
        }  
        
        .student-box {
        background:#367FA9; 
        border-radius:10px; 
        display:block; 
        width:200px; 
        height:40px; 
        margin-bottom:10px; 
        margin-left:8px; 
      }

        /*.sidebar-menu  .fa { color: #3c8dbc !important; }*/
        /*.sidebar-menu span {
            font-size: 12px;
            color: #888;
        }*/
    </style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition {{ config('backpack.base.skin') }} sidebar-mini">
	<script type="text/javascript">
		/* Recover sidebar state */
		(function () {
			if (Boolean(sessionStorage.getItem('sidebar-toggle-collapsed'))) {
				var body = document.getElementsByTagName('body')[0];
				body.className = body.className + ' sidebar-collapse';
			}
		})();
	</script>
    {{-- Print Section --}}
    <div class="print_section"></div>
    <!-- Site wrapper -->
    <div class="wrapper" id="main-body">

      <header class="main-header">
        <!-- Logo -->
        <a href="{{ url('') }}" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">{!! config('backpack.base.logo_mini') !!}</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">{!! config('backpack.base.logo_lg') !!}</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">{{ trans('backpack::base.toggle_navigation') }}</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>

          @include('backpack::inc.menu_student')
        </nav>
      </header>

      <!-- =============================================== -->

      @include('backpack::inc.sidebar_student')

      

      <!-- =============================================== -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
         @yield('header')

        <!-- Main content -->
        <section id="app" class="content">

          @yield('content')

        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <footer class="main-footer">
        @if (config('backpack.base.show_powered_by'))
            <div class="pull-right hidden-xs">
              {{ trans('backpack::base.powered_by') }} <a target="_blank" href="http://backpackforlaravel.com?ref=panel_footer_link">Backpack for Laravel</a>
            </div>
        @endif
        {{ trans('backpack::base.handcrafted_by') }} <a target="_blank" href="{{ config('backpack.base.developer_link') }}">{{ config('backpack.base.developer_name') }}</a>.
      </footer>
    </div>
    <!-- ./wrapper -->

    <!-- Vue JS Notification Mix -->
    <script src="{{ mix('js/notification.js') }}"></script>


    @yield('before_scripts')
    @stack('before_scripts')

    <!-- jQuery 2.2.3 -->
    <script src="{{ asset('vendor/adminlte') }}/bower_components/jquery/dist/jquery.min.js"></script>
    {{-- <script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
    <script>window.jQuery || document.write('<script src="{{ asset('vendor/adminlte') }}/plugins/jQuery/jQuery-2.2.3.min.js"><\/script>')</script> --}}
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('vendor/adminlte') }}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('vendor/adminlte') }}/plugins/pace/pace.min.js"></script>
    <script src="{{ asset('vendor/adminlte') }}/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    {{-- <script src="{{ asset('vendor/adminlte') }}/bower_components/fastclick/lib/fastclick.js"></script> --}}
    <script src="{{ asset('vendor/adminlte') }}/dist/js/adminlte.min.js"></script>

    <!-- page script -->
    <script type="text/javascript">
        /* Store sidebar state */
        $('.sidebar-toggle').click(function(event) {
          event.preventDefault();
          if (Boolean(sessionStorage.getItem('sidebar-toggle-collapsed'))) {
            sessionStorage.setItem('sidebar-toggle-collapsed', '');
          } else {
            sessionStorage.setItem('sidebar-toggle-collapsed', '1');
          }
        });
        // To make Pace works on Ajax calls
        $(document).ajaxStart(function() { Pace.restart(); });

        // Ajax calls should always have the CSRF token attached to them, otherwise they won't work
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        // Set active state on menu element
        var current_url = "{{ Request::fullUrl() }}";
        var full_url = current_url+location.search;
        var $navLinks = $("ul.sidebar-menu li a");
        // First look for an exact match including the search string
        var $curentPageLink = $navLinks.filter(
            function() { return $(this).attr('href') === full_url; }
        );
        // If not found, look for the link that starts with the url
        if(!$curentPageLink.length > 0){
            $curentPageLink = $navLinks.filter(
                function() { return $(this).attr('href').startsWith(current_url) || current_url.startsWith($(this).attr('href')); }
            );
        }

        $curentPageLink.parents('li').addClass('active');
        {{-- Enable deep link to tab --}}
        var activeTab = $('[href="' + location.hash.replace("#", "#tab_") + '"]');
        location.hash && activeTab && activeTab.tab('show');
        $('.nav-tabs a').on('shown.bs.tab', function (e) {
            location.hash = e.target.hash.replace("#tab_", "#");
        });

        // ADDITIONAL SCRIPTS
        // $("#nextTab").click(function() {
        //     console.log("Next Tab");
        //     var selected = $("li").attr('role').tabs("option", "selected");
        //     $("li").attr('role').tabs("option", "selected", selected + 1);
        // });

        $('#nextTab').click(function(){
            if ($('ul.nav-tabs .active').next('ul.nav-tabs li').length) {
                $('ul.nav-tabs .active').removeClass('active')
                            .next('ul.nav-tabs li')
                            .addClass('active');
                $getTabContentId = $('ul.nav-tabs .active').find('a').attr('href');

                $('.tab-content div.active').removeClass('active').next('.tab-content div').addClass('active');

            }
        });

        $('#prevTab').click(function(){
            if ($('ul.nav-tabs .active').prev('ul.nav-tabs li').length) {
                $('ul.nav-tabs .active').removeClass('active')
                            .prev('ul.nav-tabs li')
                            .addClass('active');
                $getTabContentId = $('ul.nav-tabs .active').find('a').attr('href');

                $('.tab-content div.active').removeClass('active').prev('.tab-content div').addClass('active');

            }
        });
    </script>



    @include('backpack::inc.alerts')

    <script src="{{ asset('js/intlTelInput.js') }}"></script>
    {{-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script> --}}
    <!-- JQUERY CONFIRM JS -->
    <script src="{{ asset('js/jquery-confirm-3.3.2.min.js') }}"></script>

    <!-- JavaScripts -->
    {{-- <script src="{{ mix('js/app.js') }}"></script> --}}
    
    @yield('after_scripts')
    @stack('after_scripts')

</body>
</html>
