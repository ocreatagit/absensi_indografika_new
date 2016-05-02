@extends('template.master')

@section('title')
<title>ABSENSI - Daftar Pulang</title>
@stop

@section('header')
<h1 class="page-header">
    Daftar Pulang Kerja Karyawan
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
                <td>Jadwal jam pulang</td>
                <td>Login jam pulang</td>
            </tr>
        </thead>
        <tbody id="tblpulang">
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

        $.getJSON('<?php echo action('DaftarController@getDaftarPulang') ?>', function (data) {
            var str = "";
            if (data.length > 0) {
                $.each(data, function (key, val) {
                    str += "<tr>";
                    str += "<td>" + val.idkar + "</td>";
                    str += "<td>" + val.nama + "</td>";
                    str += "<td>" + val.jmmsk + "</td>";
                    str += "<td>" + val.tglmsk + "</td>";
                    str += "</tr>";
                });
            } else {
                str += "<tr>";
                str += "<td class='text-center' colspan='5'>No Data available in table </td>";
                str += "</tr>";
            }
            $("#tblpulang").html(str);
        });
    }, 1000);
</script> 
@stop



