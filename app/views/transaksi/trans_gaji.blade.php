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
            <div class="panel-heading">
                <a id="tambah" href="{{ action('TransaksiGajiController@show') }}" class="btn btn-primary"><i class="fa fa-plus-square"></i> Pembayaran Gaji Karyawan</a>
            </div>
            <div class="panel-body">
                <div class="col-sm-12">
                    <table class="table table-bordered table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th class="text-left">No</th>
                                <th class="text-left">Tanggal</th>
                                <th class="text-left">Karyawan</th>
                                <th class="text-left">Total Gaji yang Dibayarkan</th>
                                <th class="text-left">Status <br> Pembayaran</th>
                                <th class="text-left">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="text-left">
                            <?php $no = 1; ?>
                            @foreach($gajis as $gaji)
                            <tr>
                                <td>
                                    <a href="{{ action('TransaksiGajiController@detail', [$gaji->idtg]) }}" class="" data-toggle="tooltip" data-placement="left" title="Detail">{{ $gaji->nortg }}</a>
                                </td>
                                <td>{{ strftime("%d-%b-%Y", strtotime($gaji->tgltg)) }}</td>
                                <td>{{ $gaji->nama }}</td>
                                <td>Rp.{{ number_format($gaji->ttlgj,0, ',','.') }},-</td>
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
                                <td class="text-center" width="15%">
                                    <a href="{{ action('TransaksiGajiController@destroy', [$gaji->idtg]) }}" class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="Hapus Transaksi?"><i class="fa fa-trash"></i></a>
                                        <?php $no++; ?>
                                </td>
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
        $('#datatable').DataTable({
            "paging": true, // next page
            "ordering": true, // order by at header 
            "info": false
        });
    });
</script> 
@stop



