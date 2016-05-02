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
    <div class="row">
        <div class="col-sm-3 padleft6percent" style="text-align: center;">
            <!--<img src="{{ url("uploads")."/".$karyawan->pic }}" width="200" height="250" class="thumbnail">-->
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
        <div class="col-sm-9" style="">
            <div class="panel panel-default">
                <div class="panel-heading">Laporan Gaji</div>
                <div class="panel-body">
                    @if(Session::has('filter'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <i class="fa fa-info-circle"></i> {{ $filter }}
                    </div>    
                    @endif
                    <form class="form-horizontal" action="{{ action("FiturController@histori_pembayaran_gaji_query") }}" method="POST">
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
                            <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-3">                                        
                                <select class="form-control siku" name="status">
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
                                    <a href="{{ action('FiturController@show_gaji', [$gaji->idtg]) }}" class="btn btn-info" data-toggle="tooltip" data-placement="left" title="Detail?"><i class="fa fa-info-circle"></i></a> 
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



