@extends('myindografika.master')

@section('title')
<title>ABSENSI - My Indografika</title>
@stop

@section('header')
<h1 class="page-header">My Indografika
    <small>Laporan Tabungan</small>
</h1>
@stop

@section('main')
<div class="panel panel-default">
    <div class="panel-heading">Laporan Tabungan</div>
    <div class="panel-body">
        <div class="well well-sm">
            <h3 class="" style="margin-top: 0px; margin-bottom: 0px">Total Tabungan : <b>Rp.<?php echo number_format($karyawan->tbsld, 0, ',', '.') ?>,-</b></h3>
        </div>
        @if(Session::has('filter'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-info-circle"></i> {{ $filter }}
        </div>    
        @endif
        <form class="form-horizontal" action="{{ action("FiturController@histori_tabungan_query") }}" method="POST">
            <div class="form-group">
                <label class="col-sm-2 control-label">Periode</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control siku" value="{{ date('d-m-Y') }}" name="tglfrom" id="tglfrom">
                </div>
                <label class="col-sm-1 control-label">s/d</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control siku" value="{{ date('d-m-Y') }}" name="tglto" id="tglto">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-4">                                        
                    <button type="submit" class="btn btn-success siku" name="btn_filter" value="btn_filter"><i class="fa fa-search"></i> Filter</button>
                </div>
            </div>                               
        </form>
        <hr>
        <table class="table table-bordered table-hover" id="datatable">
            <thead>
                <tr>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Tabungan Masuk</th>
                    <th class="text-center">Tabungan Keluar</th>
                    <th class="text-center">Jumlah Tabungan</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php
                $tabungan = 0;
                ?>
                @foreach ($allTabungans as $allTabungan)
                <?php
                $tabungan += $allTabungan->niltb;
                ?>
                <tr>
                    <td>{{ date("d-m-Y", strtotime($allTabungan->tgltb)) }}</td>
                    <td>
                        <?php if ($allTabungan->niltb > 0) { ?>
                            Rp.<?php echo number_format($allTabungan->niltb, 0, ',', '.') ?>,-
                        <?php } else {
                            ?>
                            Rp.<?php echo number_format(0, 0, ',', '.') ?>,-
                        <?php }
                        ?>
                    </td>
                    <td>
                        <?php if ($allTabungan->niltb < 0) { ?>
                            Rp.<?php echo number_format(abs($allTabungan->niltb), 0, ',', '.') ?>,-
                        <?php } else {
                            ?>
                            Rp.<?php echo number_format(0, 0, ',', '.') ?>,-
                        <?php }
                        ?>
                    </td>
                    <td>Rp.<?php echo number_format($tabungan, 0, ',', '.') ?>,-</td>
                </tr>
                @endforeach
            </tbody>
        </table>
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



