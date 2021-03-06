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
            <div class="row">
                <div class="col-lg-6 text-center" style="padding-top: 25px;">
                    <h1 style="font-size: 50px">Absensi Online</h1>
                    <div class="col-lg-12" style="border: 1px black solid;">
                        <span style="font-size: 25px" id="timeServer">{{-- date('j F Y, H:i:s') --}}</span>
                    </div>
                    <p style="font-size: smaller">Designed and Developed By Ocreata Programmer</p>
                </div>
                <div class="col-lg-6" >
                    <img class="col-lg-12" src="<?php echo url('assets/logo.jpg'); ?>">
                    Jl. Ngagel Madya V No.52, Baratajaya, Gubeng, No Telp. (031) 5041592
                </div>                
            </div>
            <hr style="border: 1px red solid;">
            <div class="row">
                <div class="col-lg-3">
                    <img id="image" width="150" height="200" src="http://dummyimage.com/200x200" style="margin-left: 65px;">
                </div>
                <div class="col-lg-9">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="font-size: large">
                            Informasi Absensi
                        </div>
                        <div class="panel-body">
                            <table>
                                <tbody>
                                    <tr style="font-size: large">
                                        <td class="text-left">No Absen</td>
                                        <td>:</td>
                                        <td>&nbsp; <span id="noAbsen">-</span></td>
                                    </tr>
                                    <tr style="font-size: large">
                                        <td class="text-left">Nama</td>
                                        <td>:</td>
                                        <td>&nbsp; <span id="nama">-</span></td>
                                    </tr>
                                    <tr style="font-size: large">
                                        <td class="text-left">Status Absen</td>
                                        <td>:</td>
                                        <td>&nbsp; <span id="jenis" style="">-</span></td>
                                    </tr>
                                </tbody>
                                <tbody id="jam">
                                    <tr style='font-size: large'>
                                        <td class='text-left'>Telat (menit)</td>
                                        <td>:</td>
                                        <td>&nbsp; </td>
                                    </tr>
                                    <tr style='font-size: large'>
                                        <td class='text-left'>Waktu Absen</td>
                                        <td>:</td>
                                        <td>&nbsp; </td>
                                    </tr>
                                </tbody>
                                <tbody>
                                    <tr style="font-size: large">
                                        <td class="text-left">Pesan</td>
                                        <td>:</td>
                                        <td>&nbsp; <span id="status">-</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-info">
                        <div class="panel-heading" style="font-size: large">
                            Catatan dan Pemberitahuan
                        </div>
                        <div class="panel-body">
                            <table>
                                <tr style="color: red;">
                                    <td class="text-center"><i class="glyphicon glyphicon-record"></i> / <i class="glyphicon glyphicon-triangle-left"></i></td>
                                    <td style="padding: 0px 5px;"> : </td>
                                    <td>untuk jam masuk</td>
                                </tr>
                                <tr style="color: orange">
                                    <td class="text-center"><i class="glyphicon glyphicon-triangle-right"></i></td>
                                    <td style="padding: 0px 5px;"> : </td>
                                    <td>untuk jam pulang</td>
                                </tr><tr style="color: chocolate">
                                    <td class="text-center">ESC</td>
                                    <td style="padding: 0px 5px;"> : </td>
                                    <td>untuk jam istirahat</td>
                                </tr>
                                <tr style="color: green">
                                    <td class="text-center"><i class="glyphicon glyphicon-triangle-top"></td>
                                    <td style="padding: 0px 5px;"> : </td>
                                    <td>untuk jam masuk istirahat</td>
                                </tr>
                                <tr style="color: blue">
                                    <td class="text-center">M / OK </td>
                                    <td style="padding: 0px 5px;"> : </td>
                                    <td>untuk jam masuk lembur</td>
                                </tr>
                                <tr style="color: purple">
                                    <td class="text-center"><i class="glyphicon glyphicon-triangle-bottom"></i></td>
                                    <td style="padding: 0px 5px;"> : </td>
                                    <td>untuk jam pulang lembur</td>
                                </tr>

                            </table>  
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="panel panel-info">
                        <div class="panel-heading" style="font-size: large">
                            Developer Note
                        </div>
                        <div class="panel-body">
                            <ul class="">
                                <li>Fingerprint Jangan Lupa <font color="red"> Dimatikan </font> bagi yang terakhir pulang!</li>
                                <li>Fingerprint Jangan Lupa <font color="green"> Dinyalakan </font> bagi yang pertama kali datang!</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
$(document).ready(function () {
    var currentdate = new Date();
    var options = {
        year: 'numeric', month: 'long', day: 'numeric',
        hour: 'numeric', minute: 'numeric', second: 'numeric',
        hour12: false
    };
    var formatter = new Intl.DateTimeFormat("en-GB", options),
            date = formatter.format(currentdate).toLocaleString('en-US', options);

    $('#timeServer').html(date);

    $('#noAbsen').html("-");
    $('#nama').html("-");
    $('#jam').html("<tr style='font-size: large'>" +
            "<td class='text-left'>Waktu Absen</td><td>:</td>" +
            "<td>&nbsp; -</td>" +
            "</tr>");
    $('#status').html('');
    console.log("ready!");
    setInterval(function () {
        var currentdate = new Date();
        var options = {
            year: 'numeric', month: 'long', day: 'numeric',
            hour: 'numeric', minute: 'numeric', second: 'numeric',
            hour12: false
        };
        var formatter = new Intl.DateTimeFormat("en-GB", options),
                date = formatter.format(currentdate).toLocaleString('en-US', options);

        $('#timeServer').html(date);

        $.getJSON("<?php echo action('HomeController@getAbsen') ?>", function (data) {
            console.log(data);
            if (data.length > 0) {
                $('#noAbsen').html(data[0].idkar);
                $('#nama').html(data[0].nama);
                $("#image").attr('src', "<?php echo url('uploads//'); ?>/" + data[0].pic);
                if (data[0].abscd == 0) {
                    $('#jam').html("<td class='text-left'>Waktu Absen</td><td>:</td>" +
                            "<td>&nbsp; " + data[0].jammsk + "</td>" +
                            "</tr>");
                } else {
                    $('#jam').html("<tr style='font-size: large'>" +
                            "<td class='text-left'>Waktu Absen</td><td>:</td>" +
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
                        $('#jenis').html('Masuk Kerja');
                        $('#jenis').css("color", "red");
                        break;
                    case 1:
                        $('#jenis').html('Pulang Kerja');
                        $('#jenis').css("color", "orange");
                        break;
                    case 2:
                        $('#jenis').html('Jam Istirahat');
                        $('#jenis').css("color", "chocolate");
                        break;
                    case 3:
                        $('#jenis').html('Selesai Istirahat');
                        $('#jenis').css("color", "green");
                        break;
                    case 4:
                        $('#jenis').html('Masuk Lembur');
                        $('#jenis').css("color", "blue");
                        break;
                    case 5:
                        $('#jenis').html('Pulang Lembur');
                        $('#jenis').css("color", "purple");
                        break;
                }
            } else {
                $('#noAbsen').html("-");
                $('#nama').html("-");
                $('#status').html('-');
                $('#jenis').html('-');
                $('#jenis').css('color','black');
                $('#jam').html("<tr style='font-size: large'>" +
                        "<td class='text-left'>Waktu Absen</td><td>:</td>" +
                        "<td>&nbsp; -</td>" +
                        "</tr>");
                $("#image").attr('src', "http://dummyimage.com/200x200");

            }
        }).done(function () {

        }).fail(function (jqXHR, textStatus, errorThrown) {
            //                console.log('getJSON request failed! ' + JSON.stringify(jqXHR));
            //                console.log('getJSON request failed! ' + JSON.stringify(textStatus));
            //                console.log('getJSON request failed! ' + JSON.stringify(errorThrown));
            //                console.log('============================');
        }).always(function () {

        });
    }, 1000);

    setInterval(function () {
        console.log("Refresh!!!");
       location.reload();
    }, 5000);


});
</script>
</body>
</html>


