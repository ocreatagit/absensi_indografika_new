<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>ABSENSI</title>

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/1-col-portfolio.css" rel="stylesheet">
        <link href="css/standalone.css" rel="stylesheet">
        <link href="css/clockpicker.css" rel="stylesheet">

        <link rel="stylesheet" href="css/jquery.dataTables.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>

        <!-- Navigation -->
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
                    <a class="navbar-brand" href="#">ABSENSI</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="#">MENU 1</a>
                        </li>
                        <li>
                            <a href="#">MENU 2</a>
                        </li>
                        <li>
                            <a href="#">MENU 3</a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>

        <!-- Page Content -->
        <div class="container">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Master Data
                        <small>JABATAN</small>
                    </h1>
                </div>
            </div>
            <!-- /.row -->

            <!-- Project One -->
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">Informasi Pribadi</div>
                    <div class="panel-body">
                        <form class="form-horizontal" action="#">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Username</label>
                                <div class="col-sm-3 input-group ">
                                    <input type="text" class="form-control" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Password</label>
                                <div class="col-sm-3 input-group ">
                                    <input type="text" class="form-control" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Ulangi Password</label>
                                <div class="col-sm-3 input-group ">
                                    <input type="text" class="form-control" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nama</label>
                                <div class="col-sm-3 input-group ">
                                    <input type="text" class="form-control" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Tempat Lahir</label>
                                <div class="col-sm-3 input-group ">
                                    <input type="text" class="form-control" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Tanggal Lahir</label>
                                <div class="col-sm-3 input-group ">
                                    <input type="text" class="form-control" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Alamat</label>
                                <div class="col-sm-4 input-group ">
                                    <textarea style="width: 83.333%"></textarea>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">Informasi Karyawan</div>
                    <div class="panel-body">
                        <form class="form-horizontal" action="#">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Jabatan</label>
                                <div class="col-sm-3 input-group ">
                                    <select class="form-control">
                                        <option>Helper</option>
                                        <option>Operator</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Komisi Omset</label>
                                <div class="col-sm-3 input-group ">
                                    <input type="text" class="form-control" value="">
                                    <span class="input-group-addon">
                                        <span>%</span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Jam Masuk</label>
                                <div class="col-sm-3 input-group ">
                                    <select class="form-control">
                                        <option>08.00</option>
                                        <option>09.00</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Jam Istirahat</label>
                                <div class="col-sm-3 input-group ">
                                    <input type="text" readonly class="form-control" value="13.00">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Jam Pulang</label>
                                <div class="col-sm-3 input-group ">
                                    <select class="form-control">
                                        <option>17.00</option>
                                        <option>18.00</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">Informasi Gaji</div>
                    <div class="panel-body">
                        <form class="form-horizontal" action="#">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Jenis Gaji</label>
                                <div class="col-sm-3 input-group ">
                                    <select class="form-control">
                                        <option>Gaji Pokok</option>
                                        <option>Gaji Harian</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nominal Gaji</label>
                                <div class="col-sm-3 input-group ">
                                    <input type="text" class="form-control" value="">                                    
                                </div>
                            </div>
                        </form>
                        <hr>
                        <div class="col-sm-6">
                            <table class="table" id="datatable">
                                <thead>
                                    <tr>
                                        <th class="text-left">Jenis Gaji</th>
                                        <th class="text-left">Nominal Gaji</th>
                                    </tr>
                                </thead>
                                <tbody class="text-left">
                                    <tr>
                                        <td>Gaji Pokok</td>
                                        <td>Rp. <?php echo number_format(800000, 0, ',', '.') ?>,-</td>
                                    </tr>
                                    <tr>
                                        <td>Gaji Harian</td>
                                        <td>Rp. <?php echo number_format(75000, 0, ',', '.') ?>,-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <!-- Pagination
            <div class="row text-center">
                <div class="col-lg-12">
                    <ul class="pagination">
                        <li>
                            <a href="#">&laquo;</a>
                        </li>
                        <li class="active">
                            <a href="#">1</a>
                        </li>
                        <li>
                            <a href="#">2</a>
                        </li>
                        <li>
                            <a href="#">3</a>
                        </li>
                        <li>
                            <a href="#">4</a>
                        </li>
                        <li>
                            <a href="#">5</a>
                        </li>
                        <li>
                            <a href="#">&raquo;</a>
                        </li>
                    </ul>
                </div>
            </div>
             /.row -->

            <hr>

            <!-- Footer -->
            <footer>
                <div class="row">
                    <div class="col-lg-12">
                        <p>Copyright &copy; Indografika</p>
                    </div>
                </div>
                <!-- /.row -->
            </footer>

        </div>
        <!-- /.container -->

        <!-- jQuery -->
        <script src="js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>
        <script src="js/clockpicker.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.clockpicker').clockpicker({
                    placement: 'bottom',
                    align: 'left',
                    donetext: 'Done'
                });
                $('#datatable').DataTable();
            });
        </script> 
    </body>

</html>
