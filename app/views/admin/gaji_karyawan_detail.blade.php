@extends('template.master')

@section('title')
<title>ABSENSI - My Indografika</title>
@stop

@section('header')
<h1 class="page-header">My Indografika
    <small>Laporan Gaji</small>
</h1>
@stop

@section('main')
<div class="well well-sm">
    <a href="{{ url("admin/allgajikaryawan") }}" class="btn btn-primary"><i class="fa fa-backward"></i> Kembali</a>
</div>
<div class="well well-sm">
    <div class="row">
        <div class="col-sm-3" style="">
    <!--        <img src="{{ url("uploads")."/".$karyawan->pic }}" width="200" height="250" class="thumbnail">-->
            <form class="form-horizontal">
                <div class="form-group">
                    <div class="col-sm-offset-2">
                        <a href="{{ url("uploads/".$karyawan->pic) }}" data-lightbox="roadtrip"> {{ $karyawan->pic != "" ? HTML::image('uploads/'.$karyawan->pic, $karyawan->nama, array('class' => 'thumbnail', "width" => 200, "height" => 250)) : HTML::image('uploads/no_image.png', "No Image", array('class' => 'thumbnail', "width" => 180)) }} </a>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 control-label">Nama : </label>
                    <div class="col-sm-7 marginTop25">
                        <label> {{ $karyawan->nama }} </label>
                    </div>
                </div>
                <?php
                $totalgaji = 0;
                ?>
                @foreach($infogajis as $infogaji)
                <?php
                if ($infogaji->jntgh == "Hari" || $infogaji->jntgh == "Jam") {
                    $jam = floor($infogaji->jmtgh / 3600);
                    $menit = $infogaji->jmtgh % 3600;
                    $menit = floor(($menit / 60));
                } else {
                    $jam = $gaji->jmtgh;
                }
                if ($infogaji->jmtgh == null) {
                    $totalTagih = 0;
                } else {
                    $totalTagih = $infogaji->hari * $infogaji->nilgj;
                }
                $totalgaji += $totalTagih;
                ?>
                @endforeach
                <?php
//                            echo $totalgaji; exit;
                $totalgaji += (($karyawan->kmindv * $omzetIndividu) / 100);
                $omtim = (($karyawan->kmtim * $omzetTim) / 100);
                if (count($referrals) > 1) {
                    $bool = FALSE;
                    foreach ($referrals as $key => $val) {
                        if ($val->mk01_id_child == $karyawan->idkar && $val->flglead == "Yes") {
                            $bool = TRUE;
                            break;
                        }
                    }
                    if ($bool == FALSE) {
                        $omtim = 0;
                    }
                } else {
                    $omtim = 0;
                }
                $totalgaji += $omtim;
                ?>
                <div class="form-group blue">
                    <label class="col-sm-5 control-label">Total Gaji : </label>
                    <div class="col-sm-2 marginTop25">
                        <label> Rp.{{ number_format($totalgaji,0,',','.') }},- </label>
                    </div>
                </div>
                <?php
                // Deklarasi variable GajiKotor
                $totalpinjaman = 0;

                // akumulasi nilai totalpinjaman
                if (count($infohutang) != 0) {
                    $totalpinjaman += $infohutang[0]->nilph;
                }
                if (count($infokasbon) != 0) {
                    $totalpinjaman += $infokasbon[0]->nilph;
                }
                if (count($infotabungan) != 0) {
                    $totalpinjaman += $infotabungan[0]->niltb;
                }
                ?>
                <div class="form-group green">
                    <label class="col-sm-5 control-label">Total Gaji Bersih : </label>
                    <div class="col-sm-2 marginTop25">
                        <label> Rp.{{ number_format(($totalgaji + $gaji->ttlbns) - $totalpinjaman,0,',','.') }},- </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 control-label">Komisi Individu : </label>
                    <div class="col-sm-3 marginTop25">
                        <label> {{ $karyawan->kmindv }} % </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 control-label">Komisi Tim : </label>
                    <div class="col-sm-3 marginTop25">
                        <label> {{ $karyawan->kmtim }} % </label>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-9" style="padding-left: 35px;">
            <div class="panel panel-default">
                <div class="panel-heading">Detail Gaji</div>
                <div class="panel-body">
                    <form class="form-horizontal">
                        <div class="col-sm-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Informasi Jam Kerja</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-6 control-label">Kehadiran : </label>
                                        <div class="col-sm-6 marginTop08">
                                            <label>{{ $kehadiran }} Hari</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-6 control-label">Durasi Bekerja : </label>
                                        <div class="col-sm-6 marginTop08">
                                            <?php
                                            $durasiBekerjaJam = floor($durasiBekerja / 3600);
                                            $durasiBekerjaMenit = $durasiBekerja % 3600;
                                            $durasiBekerjaMenit = floor(($durasiBekerjaMenit / 60));
                                            ?>                                    
                                            <label>{{ $durasiBekerjaJam }} Jam {{ $durasiBekerjaMenit }} Menit </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-6 control-label">Durasi Lembur : </label>
                                        <div class="col-sm-6 marginTop08">
                                            <?php
                                            $durasiLemburJam = floor($durasiLembur / 3600);
                                            $durasiLemburMenit = $durasiLemburJam % 3600;
                                            $durasiLemburMenit = floor(($durasiLemburMenit / 60));
                                            ?>                                    
                                            <label>{{ $durasiLemburJam }} Jam {{ $durasiLemburMenit }} Menit </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-6 control-label">Terlambat : </label>
                                        <div class="col-sm-6 marginTop08">           
                                            <label>{{ $durasiLambat == '' ? 0 : $durasiLambat }} Menit </label>
                                        </div>
                                    </div>
                                    <div class="form-group blue">
                                        <label class="col-sm-6 control-label">Omzet Individu : </label>
                                        <div class="col-sm-6 marginTop08">
                                            <label>Rp.{{ number_format($omzetIndividu,0,',','.') }},-</label>
                                        </div>
                                    </div>
                                    <div class="form-group blue">
                                        <label class="col-sm-6 control-label">Omzet Tim : </label>
                                        <div class="col-sm-6 marginTop08">
                                            <?php
                                            if (count($referrals) > 1) {
                                                ?>
                                                <label>Rp.{{ number_format($omzetTim,0,',','.') }},-</label>
                                            <?php } else {
                                                ?>
                                                <label>Rp.{{ number_format(0,0,',','.') }},-</label>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Informasi Gaji <small>(Gaji Kotor)</small></h3>
                                </div>
                                <div class="panel-body">
                                    <?php
                                    // Deklarasi variable GajiKotor
                                    $gajikotor = 0;
                                    ?>
                                    @foreach($infogajis as $infogaji)
                                    <div class="form-group">
                                        <label class="col-sm-6 control-label">{{ $infogaji->jenis }} : </label>
                                        <div class="col-sm-6 marginTop08">
                                            <?php
                                            if ($infogaji->jntgh == "Hari" || $infogaji->jntgh == "Jam") {
                                                $jam = floor($infogaji->jmtgh / 3600);
                                                $menit = $infogaji->jmtgh % 3600;
                                                $menit = floor(($menit / 60));
                                            } else {
                                                $jam = $gaji->jmtgh;
                                            }
                                            if ($infogaji->jmtgh == null) {
                                                $totalTagih = 0;
                                            } else {
                                                $totalTagih = $infogaji->hari * $infogaji->nilgj;
                                            }

                                            // Akumulasi nilai gaji kotor
                                            $gajikotor += $totalTagih;
                                            ?>
                                            <label>Rp.{{ number_format($totalTagih,0,',','.') }},-</label>
                                        </div>
                                    </div>
                                    @endforeach
                                    <div class="form-group blue">
                                        <label class="col-sm-6 control-label">Komisi Individu : </label>
                                        <div class="col-sm-6 marginTop08">           
                                            <label>Rp.{{ number_format((($karyawan->kmindv * $omzetIndividu) / 100),0,',','.') }},-</label>
                                            <?php
                                            $gajikotor += (($karyawan->kmindv * $omzetIndividu) / 100);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group blue">
                                        <label class="col-sm-6 control-label">Komisi Tim : </label>
                                        <div class="col-sm-6 marginTop08">
                                            <?php
                                            if (count($referrals) > 1) {
                                                $bool = FALSE;
                                                foreach ($referrals as $key => $val) {
                                                    if ($val->mk01_id_child == $karyawan->idkar && $val->flglead == "Yes") {
                                                        $bool = TRUE;
                                                        break;
                                                    }
                                                }
                                                if ($bool == FALSE) {
                                                    $omzetTim = 0;
                                                }
                                                ?>
                                                <label>Rp.{{ number_format((($karyawan->kmtim * $omzetTim) / 100),0,',','.') }},-</label>
                                                <?php
                                                $gajikotor += (($karyawan->kmtim * $omzetTim) / 100);
                                            } else {
                                                ?>
                                                <label>Rp.{{ number_format(0,0,',','.') }},-</label>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group blue">
                                        <label class="col-sm-6 control-label">Gaji Kotor : </label>
                                        <div class="col-sm-6 marginTop08">           
                                            <label>Rp.{{ number_format($gajikotor,0,',','.') }},-</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <form class="form-horizontal">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Informasi Pinjaman <small>(Gaji Kotor)</small></h3>
                    </div>
                    <div class="panel-body">                                    
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Hutang : </label>
                            <div class="col-sm-7 marginTop08">
                                <?php
                                $total = count($infohutang) != 0 ? $infohutang[0]->nilph : 0;
                                ?>
                                <label>Rp.{{ number_format($total,0,',','.') }},-</label> <?php if (count($infohutang) != 0) { ?>(Angsuran {{ strftime("%d-%b-%Y", strtotime($infohutang[0]->tglph)) }})<?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Kasbon : </label>
                            <div class="col-sm-7 marginTop08">
                                <label>Rp.{{ number_format(($infokasbon != null ? $infokasbon[0]->nilph : 0),0,',','.') }},-</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Tabungan : </label>
                            <div class="col-sm-7 marginTop08">
                                <label>Rp.{{ number_format(($infotabungan != null ? $infotabungan[0]->niltb : 0),0,',','.') }},-</label>
                            </div>
                        </div>
                        <div class="form-group blue">
                            <label class="col-sm-4 control-label">Total Pinjaman : </label>
                            <div class="col-sm-7 marginTop08">                                            
                                <label>Rp.{{ number_format($totalpinjaman,0,',','.') }},-</label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-9">

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



