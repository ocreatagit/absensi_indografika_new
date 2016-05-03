@extends('template.master')

@section('title')
<title>ABSENSI - Daftar Masuk</title>
@stop

@section('header')
<h1 class="page-header">
    Daftar Masuk Kerja Karyawan
    <span id="timeServer" class="pull-right">{{ date('d-M-Y H:i:s') }}</span>
</h1>
@stop

@section('main')
<div class="row">    
    <table id="datatable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <td>No Absen</td>
                <td>Nama Karyawan</td>
                <td>Jam Masuk</td>
                <td>Jam Istirahat</td>
                <td>Jam Kembali</td>
                <td>Jam Pulang</td>
            </tr>
        </thead>
        <tbody id="tblMasuk">
        </tbody>
    </table>
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
               $.each(data, function (key, val) {
                   str += "<tr>";
                   str += "<td>" + val[0] + "</td>";
                   str += "<td>" + val[1] + "</td>";
                   str += "<td>" + val[2] + "</td>";
                   str += "<td>" + val[3] + "</td>";
                   str += "<td>" + val[4] + "</td>";
                   str += "<td>" + val[5] + "</td>";
                   str += "</tr>";
               });
           } else {
               str += "<tr>";
               str += "<td class='text-center' colspan='6'>No Data available in table </td>";
               str += "</tr>";
           }
           $("#tblMasuk").html(str);
        });
    }, 10);
</script>
@stop



