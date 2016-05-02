@extends('template.master')

@section('title')
<title>ABSENSI - Daftar Lembur</title>
@stop

@section('header')
<h1 class="page-header">
    Daftar Lembur Kerja Karyawan
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
                <td>Jam Pulang</td>
                <td>Total Jam</td>
            </tr>
        </thead>
        <tbody id="tbllembur">
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
    }, 900);
</script> 
@stop



