<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>ABSENSI</title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/1-col-portfolio.css" rel="stylesheet">

    </head>
    <body>
        <div class="container">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="col-sm-8">Absensi Indografika</h3>
                    <h3><span id="dateServer">{{ date('d F Y') }}</span> | <span id="timeServer">{{ date('H:i:s') }}</span></h3>
                </div>
                <div class="panel-body">
                    <div class="col-sm-8"> 
                        <div class="col-sm-4" style="margin-right: 20px">
                            <img id="image" width="200" src="http://dummyimage.com/200x200">
                        </div>
                        <div class="col-sm-7">
                            <table>
                                <tbody>
                                    <tr style="font-size: 40px">
                                        <td class="text-right">No Absen :</td>
                                        <td>&nbsp; <span id="noAbsen">-</span></td>
                                    </tr>
                                    <tr style="font-size: 40px">
                                        <td class="text-right">Nama :</td>
                                        <td>&nbsp; <span id="nama">-</span></td>
                                    </tr>
                                </tbody>
                                <tbody id="jam">
                                    <tr style='font-size: 30px'>
                                        <td class='text-right'>Telat (menit) :</td>
                                        <td>&nbsp; </td>
                                    </tr>
                                    <tr style='font-size: 30px'>
                                        <td class='text-right'>Jam Masuk :</td>
                                        <td>&nbsp; </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row text-center" style="margin-top: 210px;">
                            <h1 id="status"></h1>
                            <h1 id="jenis"></h1>
                        </div>
                    </div>
                    <div class="col-sm-4"> 
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h4> Note : Sebelum meletekkan jari anda pada alat fingerprint, tekan dahulu angka pada alat fingerprint.</h4>
                                <table>
                                    <tr>
                                        <td class="text-center"><i class="glyphicon glyphicon-record"></i> / <i class="glyphicon glyphicon-triangle-left"></i></td>
                                        <td style="padding: 0px 5px;"> : </td>
                                        <td>untuk jam masuk</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><i class="glyphicon glyphicon-triangle-right"></i></td>
                                        <td style="padding: 0px 5px;"> : </td>
                                        <td>untuk jam pulang</td>
                                    </tr><tr>
                                        <td class="text-center">ESC</td>
                                        <td style="padding: 0px 5px;"> : </td>
                                        <td>untuk jam istirahat</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><i class="glyphicon glyphicon-triangle-top"></td>
                                        <td style="padding: 0px 5px;"> : </td>
                                        <td>untuk jam masuk istirahat</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">M / OK </td>
                                        <td style="padding: 0px 5px;"> : </td>
                                        <td>untuk jam masuk lembur</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><i class="glyphicon glyphicon-triangle-bottom"></i></td>
                                        <td style="padding: 0px 5px;"> : </td>
                                        <td>untuk jam pulang lembur</td>
                                    </tr>
                                    
                                </table>                                                             
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                Jika karyawan ingin melihat absensi secara keseluruhan dapat dilihat di<br>
                                <a href="">www.something.com</a><br>
                                Login sesuai username dan password yang diberikan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <p>Copyright &copy; Indografika 2016</p>
                    </div>
                </div>
            </footer>
        </div>
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script>
$(document).ready(function () {
    $('#noAbsen').html("-");
    $('#nama').html("-");
    $('#jam').html("<tr style='font-size: 30px'>" +
            "<td class='text-right'>Jam Masuk :</td>" +
            "<td>&nbsp; -</td>" +
            "</tr>");
    $('#status').html('');
    console.log("ready!");
    setInterval(function () {
        $.get('<?php echo action('DaftarController@getTimeServer') ?>', function (data) {
            $('#timeServer').html(data);
        });
        $.get('<?php echo action('DaftarController@getDateServer') ?>', function (data) {
            $('#dateServer').html(data);
        });
        $.getJSON("<?php echo action('HomeController@getAbsen') ?>", function (data) {
            if (data.length > 0) {
                $('#noAbsen').html(data[0].idkar);
                $('#nama').html(data[0].nama);
                $("#image").attr('src', "<?php echo url('uploads//'); ?>/"+data[0].pic);
                if (data[0].abscd == 0) {
                    $('#jam').html("<tr style='font-size: 30px'>" +
                            "<td class='text-right'>Telat (menit) :</td>" +
                            "<td>&nbsp; " + data[0].lbt + "</td>" +
                            "</tr><tr style='font-size: 30px'>" +
                            "<td class='text-right'>Jam Masuk :</td>" +
                            "<td>&nbsp; " + data[0].jammsk + "</td>" +
                            "</tr>");
                } else {
                    $('#jam').html("<tr style='font-size: 30px'>" +
                            "<td class='text-right'>Jam :</td>" +
                            "<td>&nbsp; " + data[0].jammsk + "</td>" +
                            "</tr>");
                }
                switch (data[0].abscd) {
                    case 0:
                    case 3:
                    case 4:
                        $('#status').html('Selamat Berkerja');
                        break;
                    case 1:
                    case 2:
                    case 5:
                        $('#status').html('Terima Kasih');
                        break;
                }
                switch (data[0].abscd) {
                    case 0:
                        $('#jenis').html('Tombol absensi : Masuk Kerja');
                        break;
                    case 1:
                        $('#jenis').html('Tombol absensi : Pulang Kerja');
                        break;
                    case 2:
                        $('#jenis').html('Tombol absensi : Jam Istirahat');
                        break;
                    case 3:
                        $('#jenis').html('Tombol absensi : Selesai Istirahat');
                        break;
                    case 4:
                        $('#jenis').html('Tombol absensi : Masuk Lembur');
                        break;
                    case 5:
                        $('#jenis').html('Tombol absensi : Pulang Lembur');
                        break;
                }
            } else {
                $('#noAbsen').html("-");
                $('#nama').html("-");
                $('#status').html('');
                $('#jenis').html('');
                $('#jam').html("<tr style='font-size: 30px'>" +
                        "<td class='text-right'>Jam Masuk :</td>" +
                        "<td>&nbsp; -</td>" +
                        "</tr>");
                $("#image").attr('src', "http://dummyimage.com/200x200");

            }
        })
                .done(function () {

                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    //                console.log('getJSON request failed! ' + JSON.stringify(jqXHR));
                    //                console.log('getJSON request failed! ' + JSON.stringify(textStatus));
                    //                console.log('getJSON request failed! ' + JSON.stringify(errorThrown));
                    //                console.log('============================');
                })
                .always(function () {

                });
    }, 1000);
});
        </script>
    </body>
</html>


