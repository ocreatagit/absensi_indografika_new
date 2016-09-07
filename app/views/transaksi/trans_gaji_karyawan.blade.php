@extends('template.master')

@section('title')
<title>ABSENSI - Input Data</title>
@stop

@section('header')
<h1 class="page-header">Input Data
    <small>Gaji</small>
</h1>
@stop

@section('main')
<div class="row">
    <div class="panel panel-default" id="infGaji">        
        <div class="panel-heading">
            <a href="{{ action('TransaksiGajiController@show') }}" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title=""><i class="fa fa-backward"></i> Kembali</a>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" action="{{ action("TransaksiGajiController@store") }}" method="POST">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Nama Karyawan</label>
                    <div class="col-sm-2 input-group ">
                        <input type="text" class="form-control disabled" value="{{ $karyawan->nama }}" disabled=""/>
                        <input type="hidden" name="idkar" value="{{ $karyawan->idkar }}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Tanggal Pembayaran Gaji</label>
                    <div class="col-sm-3 input-group ">
                        <input type="text" class="form-control" value="{{ date('d-m-Y', strtotime("+1 months", strtotime($karyawan->tglgj))) }}" name="tgltg" id="tgltg"/>
                    </div>
                </div>
                @foreach($gajis as $gaji)
                <div class="form-group">
                    <label class="col-sm-3 control-label">{{ $gaji->jenis }}</label>
                    <div class="col-sm-2 input-group pull-left">
                        <input type="hidden" name="idgj[]" value="{{ $gaji->idgj }}" class="form-control"/>
                        <?php
//                        echo $gaji->jmtgh."<br>";
                        if ($gaji->jntgh == "Hari" || $gaji->jntgh == "Jam") {
                            $jam = floor($gaji->jmtgh / 3600);
                            $menit = ($gaji->jmtgh / 60) % 60;
                        } else {
                            $jam = $gaji->jmtgh;
                        }
                        ?>
                        <input type="text" name="nominalgaji[]" value="{{ $gaji->hari == 0 ? ($menit < 30 ? $jam : ($jam + 0.5)) : $gaji->hari }}" class="form-control" readonly=""/>
                        <div class="input-group-addon">{{ $gaji->jntgh }}</div>
                    </div>
                    <label class="col-sm-3" style="margin-top: 0.5%">
                        <?php
                        if ($gaji->jntgh == "Hari" || $gaji->jntgh == "Jam") {
                            echo "Total Jam Kerja : ".$jam . " Jam " . $menit . " Menit";
                        }
                        ?>
                    </label>
                </div>
                @endforeach
                <div class="form-group">
                    <label class="col-sm-3 control-label"></label>
                    <div class="col-sm-3">
                        <button type="submit" name="btn_submit" value="submit" class="btn btn-primary">Buat Gaji Karyawan</button>
                    </div>
                </div>
            </form>            
        </div>
    </div>
</div>
@stop

@section('script')
<script type="text/javascript">
    $("#tgltg").datepicker({
        inline: true,
        dateFormat: "dd-mm-yy",
        changeYear: true,
        changeMonth: true,
        minDate: new Date("<?php echo date('Y', strtotime("+1 months", strtotime($karyawan->tglgj))).'/'.date('m', strtotime("+1 months", strtotime($karyawan->tglgj))).'/01'?>"),
        maxDate: new Date("<?php echo date('Y', strtotime("+1 months", strtotime($karyawan->tglgj))).'/'.date('m', strtotime("+1 months", strtotime($karyawan->tglgj))).'/'.date('t', strtotime("+1 months", strtotime($karyawan->tglgj)))?>")
    });
</script> 
@stop



