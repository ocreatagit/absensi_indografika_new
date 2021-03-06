<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        @yield('title')

        {{ HTML::style('css/bootstrap.min.css') }}
        {{ HTML::style('css/1-col-portfolio.css') }}
        {{ HTML::style('css/standalone.css') }}
        {{ HTML::style('css/clockpicker.css') }}
        {{ HTML::style('css/jquery.dataTables.min.css') }}
        {{ HTML::style('font-awesome/css/font-awesome.min.css') }}
        {{ HTML::style('alertifyjs/css/alertify.min.css') }}
        {{ HTML::style('jquery-ui/jquery-ui.min.css') }}
        {{ HTML::style('lightbox/css/lightbox.css') }}

        <link media="all" type="text/css" rel="stylesheet" href="{{ URL::asset('css/fixedHeader.min.css') }}">


        <style type="text/css">
            .ui-datepicker-year, .ui-datepicker-month{
                color: black;
            }
            #tambah:hover {
                background-color: none;
                color: white;
            }

            .red {
                color: red;
            }

            .green {
                color: green;
            }

            .blue {
                color: blue;
            }

            .marginTop08 {
                margin-top: 0.8%;
            }

            .marginTop22 {
                margin-top: 2.2%;
            }

            .marginTop25{
                margin-top: 2.5%;
            }

            #leftInfo img {
                text-align: center;
            }

            .siku {
                border-radius: 0px;
            }

            .padleft6percent {
                padding-left: 6%;
            }

            .ui-datepicker {
                z-index: 1600 !important; /* has to be larger than 1050 */
            }

            #ui-datetimepicker-div {
                z-index: 100000;
            }

            /*            #datatable_input_saldo_tabungan tbody tr td:nth-child(3), #datatable_input_saldo_tabungan tbody tr td:nth-child(1){
                            text-align : right;
                        }*/

            #datatable_input_tabungan tbody tr td:nth-child(5) {
                text-align : center;
            }

            #datatable_input_transfer_gaji tbody tr td:nth-child(6) {
                text-align : center;
            }
        </style>
    </head>

    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    {{ HTML::link('/', 'ABSENSI', array('class' => 'navbar-brand'))}}
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <?php if (count(array_intersect([1, 2, 3, 4], $usermatrik)) > 0) { ?>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Master Data <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <?php if (in_array(1, $usermatrik)) { ?>
                                        <li>
                                            {{ HTML::link('master/jamkerja', 'Master Jam Kerja')}}
                                        </li>
                                    <?php } ?>
                                    <?php if (in_array(2, $usermatrik)) { ?>
                                        <li>
                                            {{ HTML::link('master/jabatan', 'Master Jabatan')}}
                                        </li>
                                    <?php } ?>
                                    <?php if (in_array(3, $usermatrik)) { ?>
                                        <li>
                                            {{ HTML::link('master/jenisgaji', 'Master Jenis Gaji')}}
                                        </li>
                                    <?php } ?>
                                    <?php if (in_array(4, $usermatrik)) { ?>
                                        <li>
                                            {{ HTML::link('master/karyawan', 'Master Karyawan')}}
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        </li>
                        <li>
                            <?php if (count(array_intersect([5, 6, 7, 8, 9, 24, 25, 29], $usermatrik)) > 0) { ?>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Input Data <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <?php if (in_array(5, $usermatrik)) { ?>
                                        <li>{{ HTML::link('inputdata/hutang', 'Hutang')}}</li>
                                    <?php } ?>
                                    <?php if (in_array(6, $usermatrik)) { ?>
                                        <li>{{ HTML::link('inputdata/tabungan', 'Tabungan')}}</li>
                                    <?php } ?>
                                    <?php if (in_array(7, $usermatrik)) { ?>
                                        <li>{{ HTML::link('inputdata/gaji', 'Slip Gaji')}}</li>
                                    <?php } ?>
                                    <?php if (in_array(8, $usermatrik)) { ?>
                                        <li>{{ HTML::link('inputdata/transfer', 'Transfer Gaji')}}</li>
                                    <?php } ?>
                                    <?php if (in_array(9, $usermatrik)) { ?>
                                        <li>{{ HTML::link('inputdata/omzet', 'Omzet Karyawan')}}</li>
                                    <?php } ?>
                                    <?php if (in_array(24, $usermatrik)) { ?>
                                        <li>{{ HTML::link('inputdata/absensi', 'Absensi Karyawan')}}</li>
                                    <?php } ?>
                                    <?php if (in_array(25, $usermatrik)) { ?>
                                        <li>{{ HTML::link('inputdata/alpha', 'Alpha / Cuti Karyawan')}}</li>
                                    <?php } ?>
                                    <?php if (in_array(29, $usermatrik)) { ?>
                                        <li>{{ HTML::link('inputdata/saldotabungan', 'Saldo Tabungan')}}</li>
                                    <?php } ?>
                                    <?php if (in_array(30, $usermatrik)) { ?>
                                        <li>{{ HTML::link('inputdata/tarik_tabungan', 'Tarik Tabungan')}}</li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        </li>
                        <li class="dropdown">
                            <?php if (count(array_intersect([10, 11, 12], $usermatrik)) > 0) { ?>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Daftar Jam <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <?php if (in_array(10, $usermatrik)) { ?>
                                        <li>
                                            {{ HTML::link('daftarmasuk', 'Daftar Masuk Karyawan')}}
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        </li>
                        <?php if (in_array(13, $usermatrik)) { ?>
                            <li>
                                {{-- HTML::link('myindografika', 'My Indografika') --}}
                            </li>
                        <?php } ?>
                        <li>
                            <?php if (count(array_intersect([14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 26, 27], $usermatrik)) > 0) { ?>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Fitur <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <?php if (in_array(14, $usermatrik)) { ?>
                                        <li>{{ HTML::link('myindografika/gajikaryawan', 'Pembayaran Gaji')}}</li>
                                    <?php } ?>
                                    <?php if (in_array(15, $usermatrik)) { ?>
                                        <li>{{ HTML::link('myindografika/tabungankaryawan', 'Tabungan Karyawan')}}</li>
                                    <?php } ?>
                                    <?php if (in_array(16, $usermatrik)) { ?>
                                        <li>{{ HTML::link('myindografika/pinjamankaryawan', 'Pinjaman Karyawan')}}</li>
                                    <?php } ?>
                                    <?php if (in_array(17, $usermatrik)) { ?>
                                        <li>{{ HTML::link('myindografika/omzetkaryawan', 'Omzet Karyawan')}}</li>
                                    <?php } ?>
                                    <?php if (in_array(18, $usermatrik)) { ?>
                                        <li>{{ HTML::link('myindografika/presensikaryawan', 'Presensi Karyawan')}}</li>
                                    <?php } ?>

                                    <?php if (in_array(19, $usermatrik)) { ?>
                                        <li>{{ HTML::link('admin/allgajikaryawan', 'Laporan Pembayaran Gaji Karyawan')}}</li>
                                    <?php } ?>
                                    <?php if (in_array(20, $usermatrik)) { ?>
                                        <li>{{ HTML::link('admin/alltabungankaryawan', 'Laporan Tabungan Karyawan')}}</li>
                                    <?php } ?>
                                    <?php if (in_array(21, $usermatrik)) { ?>
                                        <li>{{ HTML::link('admin/allpinjamankaryawan', 'Laporan Pinjaman Karyawan')}}</li>
                                    <?php } ?>
                                    <?php if (in_array(22, $usermatrik)) { ?>
                                        <li>{{ HTML::link('admin/allomzetkaryawan', 'Laporan Omzet Karyawan')}}</li>
                                    <?php } ?>
                                    <?php if (in_array(23, $usermatrik)) { ?>
                                        <li>{{ HTML::link('admin/allpresensikaryawan', 'Laporan Presensi Karyawan')}}</li>
                                    <?php } ?>                                    
                                    <?php if (in_array(26, $usermatrik)) { ?>
                                        <li>{{ HTML::link('admin/adminlaporankaryawan', 'Admin Laporan Karyawan')}}</li>
                                    <?php } ?>
                                    <?php if (in_array(27, $usermatrik)) { ?>
                                        <li>{{ HTML::link('admin/persenbonus', 'Ubah Persen Bonus')}}</li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <?php
                            $userloginid = Session::get("user");
                            ?>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Welcome, <?php echo $userloginid["nama"] ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">                                
                                <li>
                                    {{ HTML::link('myaccount', 'My Account')}}
                                </li>
                                <li>
                                    {{ HTML::link('logout', 'Logout')}}
                                </li>
                            </ul>
                        </li>
                        <li>

                        </li>                        
                    </ul>
                </div><!-- /.navbar-collapse -->
                <!-- -->
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @yield('header')
            </div>
        </div>
        @yield('main')
        <hr>

        <footer>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p>Copyright &copy; Indografika</p>
                </div>
            </div>
        </footer>

    </div>

    {{-- HTML::script('js/jquery.js') --}}
    {{ HTML::script('js/jquery-1.12.3.js') }}
    {{ HTML::script('js/bootstrap.min.js') }}
    {{ HTML::script('js/clockpicker.js') }}
    {{ HTML::script('js/jquery.dataTables.min.js') }}
    {{ HTML::script('alertifyjs/alertify.min.js') }}
    {{ HTML::script('jquery-ui/jquery-ui.min.js') }}
    {{ HTML::script('lightbox/js/lightbox.js') }}
    {{ HTML::script('js/fixedHeader.min.js') }}

    <script>
//        alertify.defaults.transition = "slide";
//        alertify.defaults.theme.ok = "btn btn-primary";
//        alertify.defaults.theme.cancel = "btn btn-danger";
//        alertify.defaults.theme.input = "form-control";

        alertify.defaults = {
            // dialogs defaults
            autoReset: true,
            basic: false,
            closable: true,
            closableByDimmer: true,
            frameless: false,
            maintainFocus: true, // <== global default not per instance, applies to all dialogs
            maximizable: true,
            modal: true,
            movable: true,
            moveBounded: false,
            overflow: true,
            padding: true,
            pinnable: true,
            pinned: true,
            preventBodyShift: false, // <== global default not per instance, applies to all dialogs
            resizable: true,
            startMaximized: false,
            transition: 'pulse',
            // notifier defaults
            notifier: {
                // auto-dismiss wait time (in seconds)  
                delay: 5,
                // default position
                position: 'bottom-right'
            },
            // language resources 
            glossary: {
                // dialogs default title
                title: 'Message',
                // ok button text
                ok: 'OK',
                // cancel button text
                cancel: 'Cancel'
            },
            // theme settings
            theme: {
                // class name attached to prompt dialog input textbox.
                input: 'ajs-input',
                // class name attached to ok button
                ok: 'ajs-ok',
                // class name attached to cancel button 
                cancel: 'ajs-cancel'
            }
        };

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>

    @yield('script')
</body>

</html>
