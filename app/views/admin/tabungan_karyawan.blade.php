@extends('template.master')

@section('title')
<title>ABSENSI - My Indografika</title>
@stop

@section('header')
<h1 class="page-header">
    Laporan Tabungan
</h1>
@stop

@section('main')
<div class="row">

    <div class="panel panel-default">
        <div class="panel-heading">Laporan Tabungan</div>
        <div class="panel-body">
            @if(Session::has('filter'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <i class="fa fa-info-circle"></i> {{ $filter }}
            </div>    
            @endif
            <table class="table table-bordered table-hover" id="datatable">
                <thead>
                    <tr>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Tabungan Masuk</th>
                        <th class="text-center">Tabungan Keluar</th>
                        <th class="text-center">Sisa Tabungan</th>
                        <th class="text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php
                    $tabungan = 0;
                    ?>
                    @foreach ($allTabungans as $allTabungan)
                    <tr>
                        <td>{{ $allTabungan->nama }} </td>
                        <td class="text-right">
                            Rp.<?php echo number_format($allTabungan->tbmsk, 0, ',', '.') ?>,-
                        </td>
                        <td class="text-right">
                            Rp.<?php echo number_format($allTabungan->tbklr, 0, ',', '.') ?>,-
                        </td>
                        <td class="text-right">
                            Rp.<?php echo number_format($allTabungan->tbsld, 0, ',', '.') ?>,-
                        </td>
                        <td>
                            <a href="{{ action('LaporanAdminController@show_tabungan', [$allTabungan->idkar]) }}" class="btn btn-info" data-toggle="tooltip" data-placement="right" title="Detail?"><i class="fa fa-info-circle"></i></a> 
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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

        $('#datatable').DataTable();

        $("#tglto").datepicker({
            inline: true,
            dateFormat: "dd-mm-yy",
            changeYear: true,
            changeMonth: true
        });

        $("#tglfrom").datepicker({
            inline: true,
            dateFormat: "dd-mm-yy",
            changeYear: true,
            changeMonth: true
        });
    });
</script> 
@stop



