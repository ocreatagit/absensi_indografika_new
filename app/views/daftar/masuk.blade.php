@extends('template.master')

@section('title')
<title>ABSENSI - Daftar Masuk</title>
@stop

@section('header')
<h1 class="page-header">
    Daftar Masuk Kerja Karyawan
</h1>
@stop

@section('main')
<div class="row">   
    <div class="col-sm-12" style="">
        <div class="panel panel-default">
            <div class="panel-heading"></div>
            <div class="panel-body">
                <h3 class="page-header"><i class="fa fa-info-circle"></i> Daftar Masuk Kerja Karyawan <span id="timeServer" class="pull-right">{{ date('H:i:s') }}</span></h3>
            </div>
            <div class="panel-body">
                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>No Absen</td>
                            <td>Nama Karyawan</td>
                            <td>Jam Masuk</td>
                            <td>Jam Istirahat</td>
                            <td>Jam Kembali</td>
                            <td>Jam Pulang</td>
                            <td>Jam Lembur Masuk</td>
                            <td>Jam Lembur Pulang</td>
                            <td>Keterlambatan</td>
                        </tr>
                    </thead>
                    <tbody id="tblMasuk">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $('.clockpicker').clockpicker({
            placement: 'bottom',
            align: 'left',
            donetext: 'Done'
        });
        $('#datatable').DataTable({
            "bInfo": false
        });

    });
    setInterval(function () {
        $.get('<?php echo action('DaftarController@getTimeServer') ?>', function (data) {
            $('#timeServer').html(data);
        });
        //ambil data dari json
        $.getJSON('<?php echo action('DaftarController@getDaftarMasuk') ?>', function (data) {
            var str = "";
            if (data.length > 0) {
                var nourut = 1;
                $.each(data, function (key, val) {
                    str += "<tr>";
                    str += "<td>" + nourut++ + "</td>";
                    str += "<td>" + val.idkar + "</td>";
                    str += "<td>" + val.nama + "</td>";
                    str += "<td>" + val.jammasuk + "</td>";
                    str += "<td>" + val.jamkeluar + "</td>";
                    str += "<td>" + val.jamkembali + "</td>";
                    str += "<td>" + val.jampulang + "</td>";
                    str += "<td>" + val.jamlemburmasuk + "</td>";
                    str += "<td>" + val.jamlemburpulang + "</td>";
                    str += "<td>" + val.lbt + "</td>";
                    str += "</tr>";
                });
            } else {
                str += "<tr>";
                str += "<td class='text-center' colspan='9'>No Data available in table </td>";
                str += "</tr>";
            }
            $("#tblMasuk").html(str);
        });
    }, 1000);
</script>
@stop



