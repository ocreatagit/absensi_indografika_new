@extends('template.master')

@section('title')
<title>ABSENSI - My Indografika</title>
@stop

@section('header')
<h1 class="page-header">My Indografika
    <small>Laporan Pinjaman</small>
</h1>
@stop

@section('main')
<div class="well well-sm">
    <a href="{{ url('myindografika/pinjamankaryawan') }}" class="btn btn-primary"><i class="fa fa-backward"></i> Kembali</a>
</div>
<div class="well well-sm">
    <div class="row">
        <div class="col-sm-3 padleft6percent" style="">
            <a href="{{ url("uploads/".$karyawan->pic) }}" data-lightbox="roadtrip"> {{ $karyawan->pic != "" ? HTML::image('uploads/'.$karyawan->pic, $karyawan->nama, array('class' => 'thumbnail', "width" => 200, "height" => 250)) : HTML::image('uploads/no_image.png', "No Image", array('class' => 'thumbnail', "width" => 180)) }} </a>
            <form class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Nama : </label>
                    <div class="col-sm-8">
                        <label class="" style="margin-top: 8px;">{{ $karyawan->nama }}</label>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-9" style="padding-left: 35px;">
            <div class="panel panel-default">
                <div class="panel-heading">Laporan Pinjaman</div>
                <div class="panel-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">No Hutang</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control siku" value="{{ $hutang->norhut }}" disabled="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nilai Hutang</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control siku" value="{{ number_format($hutang->nilhut, 0, ',', '.') }}" disabled="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Status Hutang</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control siku" value="{{ $hutang->flglns == "Y" ? "Lunas" : "Belum Lunas" }}" disabled="">
                            </div>
                        </div>
                    </form>  
                    <hr>
                    <table class="table table-bordered table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th class="text-center">Angsuran</th>
                                <th class="text-center">Tanggal Angsuran</th>
                                <th class="text-center">Nilai Angsuran</th>
                                <th class="text-center">Status Bayar</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach($detail_hutangs as $detail_hutang)
                            <?php $no = 1; ?>
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ date("d-m-Y", strtotime($detail_hutang->tglph)) }}</td>
                                <td>Rp.<?php echo number_format($detail_hutang->nilph, 0, ',', '.') ?>,-</td>
                                <td>{{  $detail_hutang->status }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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



