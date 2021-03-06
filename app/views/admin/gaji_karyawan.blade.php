@extends('template.master')

@section('title')
<title>ABSENSI - My Indografika</title>
@stop

@section('header')
<h1 class="page-header">Laporan Pembayaran Gaji</h1>
@stop

@section('main')
<div class="row">
    <div class="col-sm-12" style="">
        <div class="panel panel-default">
            <div class="panel-heading"></div>
            <div class="panel-body">
                <h3 class="page-header"><i class="fa fa-info-circle"></i> Laporan Gaji</h3>
            </div>
            <div class="panel-body">
                @if(Session::has('filter'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <i class="fa fa-info-circle"></i> {{ $filter }}
                </div>    
                @endif
                @if(Session::has('filter2'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <i class="fa fa-info-circle"></i> {{ $filter2 }}
                </div>    
                @endif
                <form class="form-horizontal" action="{{ action("LaporanAdminController@histori_pembayaran_gaji_query") }}" method="POST">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Periode</label>
                        <div class="col-sm-2">
                            <select class="form-control siku" name="bulan">
                                <?php for ($i = 1; $i < 13; $i++) { ?>
                                    <option value="<?php echo (strlen($i) == 1 ? "0" . $i : $i) ?>">
                                        <?php
                                        setlocale(LC_ALL, 'IND');
                                        echo strftime('%B', strtotime("2016-" . (strlen($i) == 1 ? "0" . $i : $i) . "-01"));
                                        ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control siku" value="{{ date('Y') }}" name="tahun_awal">
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control siku" name="bulan2">
                                <?php for ($i = 1; $i < 13; $i++) { ?>
                                    <option value="<?php echo (strlen($i) == 1 ? "0" . $i : $i) ?>">
                                        <?php
                                        setlocale(LC_ALL, 'IND');
                                        echo strftime('%B', strtotime("2016-" . (strlen($i) == 1 ? "0" . $i : $i) . "-01"));
                                        ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>                    
                        <div class="col-sm-1">
                            <input type="text" class="form-control siku" value="{{ date('Y') }}" name="tahun_akhir">
                        </div>
                        @if($errors->first('tahun'))
                        <div class="col-sm-3 col-sm-offset-2 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('tahun') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Karyawan</label>
                        <div class="col-sm-3">
                            <select class="form-control siku" name="idkar">
                                <option value="0" selected="">Semua</option>
                                @foreach($karyawans as $karyawan)
                                <option value="{{ $karyawan->idkar }}">{{ $karyawan->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-2">                                        
                            <select class="form-control siku" name="status">
                                <option value="A">-- Semua Status --</option>
                                <option value="Y">Terbayar</option>
                                <option value="N">Belum Terbayar</option>
                            </select>
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
                            <th class="text-center">No Gaji</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Total Gaji</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach($gajis as $gaji)
                        <tr>
                            <td> {{ $gaji->nortg }} </td>
                            <td>{{ strftime("%d-%b-%Y", strtotime($gaji->tgltg)) }}</td>
                            <td>{{ $gaji->nama }}</td>
                            <td>Rp.{{ number_format($gaji->ttlgj,0, ',','.') }} + <span class="blue">Rp.{{ number_format($gaji->ttlbns,0, ',','.') }} (Bonus)</span></td>
                            <?php
                            if ($gaji->status == "N") {
                                ?>
                                <td class="red"><i class='fa fa-exclamation-circle'></i> Belum Terbayar</td>
                                <?php
                            } else {
                                ?>
                                <td class="green"><i class='fa fa-check-circle green'></i> Gaji Telah Dibayarkan</td>
                                <?php
                            }
                            ?>
                            <td> 
                                <a href="{{ action('LaporanAdminController@show_gaji', [$gaji->idtg]) }}" class="btn btn-info siku" data-toggle="tooltip" data-placement="left" title="Detail?"><i class="fa fa-info-circle"></i></a> 
                                <a target="_blank" href="{{ action('TransaksiTransferController@printgaji', [$gaji->idtg]) }}" class="btn btn-default siku {{ $gaji->status == "Y" ? "" : "disabled" }}" data-toggle="tooltip" data-placement="left" title="Cetak Slip Gaji?"><i class="fa fa-print"></i></a>
                            </td>
                        </tr>
                        @endforeach
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



