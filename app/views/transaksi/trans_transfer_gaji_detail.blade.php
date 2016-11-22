@extends('template.master')

@section('title')
<title>ABSENSI - Input Data</title>
@stop

@section('header')
<h1 class="page-header">Input Data
    <small>Pembayaran Gaji</small>
</h1>
@stop

@section('main')
<div class="row">
    <div class="col-sm-12" style="">
        <div class="panel panel-default">
            @if(Session::has('tg01_success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <i class="fa fa-info-circle"></i> {{ $tg01_success }}
            </div>    
            @endif

            @if(Session::has('tg01_danger'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <i class="fa fa-info-circle"></i> {{ $tg01_danger }}
            </div>    
            @endif
            <div class="panel panel-heading">
                <a href="{{ action('TransaksiTransferController@index') }}" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title=""><i class="fa fa-backward"></i> Kembali</a>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-3" id="leftInfo">                       
                        <form class="form-horizontal">
                            <div class="form-group">
                                <div class="col-sm-offset-2">
                                    <a href="{{ url("uploads/".$karyawan->pic) }}" data-lightbox="roadtrip"> {{ $karyawan->pic != "" ? HTML::image('uploads/'.$karyawan->pic, $karyawan->nama, array('class' => 'thumbnail', "width" => 180)) : HTML::image('uploads/no_image.png', "No Image", array('class' => 'thumbnail', "width" => 180)) }} </a>
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
                                $menit = ($infogaji->jmtgh / 60) % 60;
                            } else {
                                $jam = $infogaji->jmtgh;
                            }
                            if ($infogaji->hari == 0) {
                                $jam = ($menit < 30 ? $jam : ($jam + 0.5));
                                $totalTagih = $jam * $infogaji->nilgj;
                            } else {
                                $totalTagih = ($infogaji->hari + ($infogaji->jntgh == "Hari" ? $cuti : 0)) * $infogaji->nilgj;
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
                        </form>
                    </div>
                    <div class="col-sm-8">
                        <form class="form-horizontal" action="{{ action("TransaksiTransferController@savebonus") }}" method="POST">
                            <h3 class="page-header"><i class="fa fa-info-circle"></i> Informasi Slip Gaji</h3>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nomor Pembayaran Gaji</label>
                                <div class="col-sm-3 input-group ">
                                    <input type="text" class="form-control" value="{{ $gaji->nortg }}" name="nortg" id="nortg" disabled=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Tanggal Pembayaran Gaji</label>
                                <div class="col-sm-5 input-group ">
                                    <input type="text" class="form-control" value="{{ strftime("%d-%m-%Y", strtotime($gaji->tgltg)) }}" name="tgltg" id="tgltg" disabled=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Gaji Bonus</label>
                                <div class="col-sm-5 input-group ">
                                    <input type="hidden" name="idtg" value="{{ $gaji->idtg }}"/>
                                    <input type="text" class="form-control" value="{{ Input::old('ttlbns', number_format($gaji->ttlbns, 0, ',', '')) }}" name="ttlbns" {{ $gaji->status == 'Y' ? 'disabled=""' : '' }}/>
                                </div>
                                @if($errors->first('ttlbns'))
                                <div class="col-sm-5 col-sm-offset-4 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('ttlbns') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Keterangan</label>
                                <div class="col-sm-5 input-group ">
                                    <textarea class="form-control siku" name="kettrn">{{ Input::old('kettrn', $gaji->kettrn) }}</textarea>
                                </div>
                                @if($errors->first('ttlbns'))
                                <div class="col-sm-5 col-sm-offset-4 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('ttlbns') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"></label>
                                <div class="col-sm-5 input-group ">
                                    <button type="submit" value="btn_submit" name="btn_submit" class="btn btn-primary" {{ $gaji->status == 'Y' ? 'disabled=""' : '' }}> Simpan Gaji</button>
                                </div>
                            </div>
                        </form> 
                        <hr>
                        <form class="form-horizontal">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Informasi Jam Kerja</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Total Kehadiran : </label>
                                        <div class="col-sm-7 marginTop08">
                                            <label>{{ $kehadiran + $cuti }} Hari</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Total Durasi Bekerja : </label>
                                        <div class="col-sm-7 marginTop08">
                                            <?php
                                            $durasiBekerjaJam = floor($durasiBekerja / 3600);
                                            $durasiBekerjaMenit = $durasiBekerja % 3600;
                                            $durasiBekerjaMenit = floor(($durasiBekerjaMenit / 60));
                                            ?>                                    
                                            <label>{{ $durasiBekerjaJam }} Jam {{ $durasiBekerjaMenit }} Menit </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Total Durasi Lembur : </label>
                                        <div class="col-sm-7 marginTop08">
                                            <?php
                                            $durasiLemburJam = floor($durasiLembur / 3600);
                                            $durasiLemburMenit = $durasiLemburJam % 3600;
                                            $durasiLemburMenit = floor(($durasiLemburMenit / 60));
                                            ?>                                    
                                            <label>{{ $durasiLemburJam }} Jam {{ $durasiLemburMenit }} Menit </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Terlambat : </label>
                                        <div class="col-sm-7 marginTop08">           
                                            <label>{{ $durasiLambat == '' ? 0 : $durasiLambat }} Menit </label>
                                        </div>
                                    </div>
                                    <div class="form-group blue">
                                        <label class="col-sm-4 control-label">Total Omzet Individu : </label>
                                        <div class="col-sm-7 marginTop08">
                                            <label>Rp.{{ number_format($omzetIndividu,0,',','.') }},-</label>
                                        </div>
                                    </div>
                                    <div class="form-group blue">
                                        <label class="col-sm-4 control-label">Total Omzet Tim : </label>
                                        <div class="col-sm-7 marginTop08">
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
                                        <label class="col-sm-4 control-label">{{ $infogaji->jenis }} : </label>
                                        <div class="col-sm-7 marginTop08">
                                            <?php
                                            if ($infogaji->jntgh == "Hari" || $infogaji->jntgh == "Jam") {
                                                $jam = floor($infogaji->jmtgh / 3600);
                                                $menit = ($infogaji->jmtgh / 60) % 60;
                                            } else {
                                                $jam = $infogaji->jmtgh;
                                            }
                                            if ($infogaji->hari == 0) {
                                                $jam = ($menit < 30 ? $jam : ($jam + 0.5));
                                                $totalTagih = $jam * $infogaji->nilgj;
                                            } else {
                                                $totalTagih = ($infogaji->hari + ($infogaji->jntgh == "Hari" ? $cuti : 0)) * $infogaji->nilgj;
                                            }

                                            // Akumulasi nilai gaji kotor
                                            $gajikotor += $totalTagih;
                                            ?>
                                            <label>Rp.{{ number_format($totalTagih,0,',','.') }},-</label>
                                        </div>
                                    </div>
                                    @endforeach
                                    <div class="form-group blue">
                                        <label class="col-sm-4 control-label">Komisi Individu : </label>
                                        <div class="col-sm-7 marginTop08">           
                                            <label>Rp.{{ number_format((($karyawan->kmindv * $omzetIndividu) / 100),0,',','.') }},-</label>
                                            <?php
                                            $gajikotor += (($karyawan->kmindv * $omzetIndividu) / 100);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group blue">
                                        <label class="col-sm-4 control-label">Komisi Tim : </label>
                                        <div class="col-sm-7 marginTop08">
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
                                        <label class="col-sm-4 control-label">Total Gaji Kotor : </label>
                                        <div class="col-sm-7 marginTop08">           
                                            <label>Rp.{{ number_format($gajikotor,0,',','.') }},-</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
        $('#datatable').DataTable({
            "paging": true, // next page
            "ordering": true, // order by at header 
            "info": false
        });
    });
</script> 
@stop



