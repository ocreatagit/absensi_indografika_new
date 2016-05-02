<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <!--<meta http-equiv="X-UA-Compatible" content="IE=edge">-->
        <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
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
                        <small>JAM KERJA</small>
                    </h1>
                </div>
            </div>
            <!-- /.row -->

            <!-- Project One -->
            <div class="row">
                <div class="col-sm-2" style="margin-right: 20px;">
                    <img src="http://placehold.it/200x250">
                </div>
                <div class="col-sm-7">
                    <div class="panel panel-default">
                        <div class="panel-heading">William</div>
                        <div class="panel-body">
                            <table class="col-sm-6">
                                <tr>
                                    <td class="col-sm-6" >Kode Absensi</td>
                                    <td style="text-align: left">0004</td>
                                </tr>
                            </table>
                            <br>
                            <br>
                            <form class="form-horizontal" action="#">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Periode</label>
                                    <div class="col-sm-3 input-group ">
                                        <input type="text" class="form-control" value="">  
                                    </div>
                                </div>                               
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-3 input-group ">                                        
                                        <button class="btn btn-success">Pilih</button>
                                    </div>
                                </div>                               
                            </form>    
                            <hr>
                            <h2>Absensi Bulan Ini</h2>
                            <table class="table" id="datatable">
                                <thead>
                                    <tr>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Jam Masuk</th>
                                        <th class="text-center">Jam Istirahat</th>
                                        <th class="text-center">Jam Pulang</th>
                                        <th class="text-center">Telat/menit</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr>
                                        <td>01-01-2016</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>02-01-2016</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>03-01-2016</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>04-01-2016</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>05-01-2016</td>
                                        <td>08.00</td>
                                        <td>13.00</td>
                                        <td>17.00</td>
                                        <td><?php echo number_format(10, 0, ',', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <td>06-01-2016</td>
                                        <td>08.05</td>
                                        <td>13.50</td>
                                        <td>17.08</td>
                                        <td><?php echo number_format(7, 0, ',', '.') ?></td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">William</div>
                        <div class="panel-body">
                            <p>Alpha : 1 hari</p>
                            <p>Cuti : 3 hari</p>
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
