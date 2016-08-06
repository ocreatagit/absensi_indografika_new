<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        @yield('title')

        {{ HTML::style('assets/css/bootstrap.css') }}
        {{ HTML::style('assets/css/font-awesome.css') }}
        {{ HTML::style('assets/css/custom.css') }}
        {{ HTML::style('assets/js/dataTables/dataTables.bootstrap.css') }}
        {{ HTML::style('css/clockpicker.css') }}
        {{ HTML::style('jquery-ui/jquery-ui.min.css') }}
        {{-- HTML::style('http://fonts.googleapis.com/css?family=Open+Sans') --}}
        
        <style>
            #pageHeader {
                margin-top: 0px;
                padding-top: 0px;
            }
            
            .ui-datepicker-year, .ui-datepicker-month{
                color: black;
            }
            
            .marginTop08 {
                margin-top: 0.8%;
            }

            .marginTop25{
                margin-top: 2.5%;
            }
            
            .siku {
                border-radius: 0px;
            }
        </style>
    </head>
    <body>
        <div id="wrapper">
            <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ url("/") }}">My Indografika</a> 
                </div>
                <div style="color: white;
                     padding: 15px 50px 5px 50px;
                     float: right;
                     font-size: 16px;"> 
                     <?php
                     $userloginid = Session::get("user");
                     ?>
                    <span style="">Welcome, <?php echo $userloginid["nama"]; ?></span> &nbsp;&nbsp;
                    <a href="{{ url('logout') }}" class="btn btn-danger square-btn-adjust">Logout</a>
                </div>
            </nav>   
            <!-- /. NAV TOP  -->
            <nav class="navbar-default navbar-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="main-menu">
                        <li class="text-center">
                            <a href="{{ url("uploads/".$karyawan->pic) }}" data-lightbox="roadtrip"> 
                                {{ $karyawan->pic != "" ? HTML::image('uploads/'.$karyawan->pic, $karyawan->nama, array('class' => 'user-image img-responsive thumbnail')) : HTML::image('uploads/no_image.png', "No Image", array('class' => 'thumbnail', "width" => 180)) }}
                            </a>
                            <!--<img src="assets/img/find_user.png" class="user-image img-responsive"/>-->
                        </li>
                        
                        <li class="active-menu">
                            <a class="active-menu"  href=""><i class="fa fa-user "></i> Nama : {{ $karyawan->nama }}</a>
                        </li>
                        <li>
                            <a class=""  href="{{ url('myaccount') }}"><i class="fa fa-cogs "></i> My Account</a>
                        </li>
                        <?php if (count(array_intersect([14, 15, 16, 17, 18], $usermatrik)) > 0) { ?>
                        <?php if (in_array(14, $usermatrik)) { ?>
                        <li>
                            <a href="{{ url('myindografika/gajikaryawan') }}"><i class="fa fa-book "></i> Gaji</a>
                        </li>
                        <?php } ?>
                        <?php if (in_array(15, $usermatrik)) { ?>
                        <li>
                            <a href="{{ url('myindografika/tabungankaryawan') }}"><i class="fa fa-money "></i> Tabungan </a>
                        </li>
                        <?php } ?>
                        <?php if (in_array(16, $usermatrik)) { ?>
                        <li>
                            <a href="{{ url('myindografika/pinjamankaryawan') }}"><i class="fa fa-minus-circle "></i> Hutang </a>
                        </li>
                        <?php } ?>
                        <?php if (in_array(17, $usermatrik)) { ?>
                        <li>
                            <a href="{{ url('myindografika/omzetkaryawan') }}"><i class="fa fa-dollar "></i> Omzet </a>
                        </li>
                        <?php } ?>
                        <?php if (in_array(18, $usermatrik)) { ?>
                        <li>
                            <a href="{{ url('myindografika/presensikaryawan') }}"><i class="fa fa-check-circle "></i> Presensi </a>
                        </li>
                        <?php }} ?>
                        <!--                        <li>
                                                    <a href=""><i class="fa fa-sign-out "></i> Logout </a>
                                                </li>-->
                    </ul>

                </div>

            </nav>  
            <!-- /. NAV SIDE  -->
            <div id="page-wrapper" >
                <div id="page-inner">
<!--                    <div class="row">
                        <div class="col-lg-12" id="pageHeader">
                            @yield('header')
                        </div>
                    </div>-->
                    <div class="row">
                        <div class="col-md-12">
                            @yield('main')
                        </div>
                    </div>
                </div>
                <!-- /. PAGE INNER  -->
            </div>
            <!-- /. PAGE WRAPPER  -->
        </div>

        <!-- /. WRAPPER  -->
        {{ HTML::script('assets/js/jquery-1.10.2.js') }}
        {{ HTML::script('assets/js/bootstrap.min.js') }}
        {{ HTML::script('assets/js/jquery.metisMenu.js') }}
        {{ HTML::script('assets/js/dataTables/jquery.dataTables.js') }}
        {{ HTML::script('assets/js/dataTables/dataTables.bootstrap.js') }}
        {{ HTML::script('assets/js/custom.js') }}

        {{ HTML::script('jquery-ui/jquery-ui.min.js') }}
        {{ HTML::script('js/clockpicker.js') }}
        {{ HTML::script('alertifyjs/alertify.min.js') }}
        {{ HTML::script('lightbox/js/lightbox.js') }}

        <script>
            alertify.defaults.transition = "slide";
            alertify.defaults.theme.ok = "btn btn-primary";
            alertify.defaults.theme.cancel = "btn btn-danger";
            alertify.defaults.theme.input = "form-control";

            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });
        </script>

        @yield('script')
    </body>
</html>
