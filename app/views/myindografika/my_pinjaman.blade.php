@extends('myindografika.master')

@section('title')
<title>ABSENSI - My Indografika</title>
@stop

@section('header')
<h1 class="page-header">My Indografika
    <small>Laporan Pinjaman</small>
</h1>
@stop

@section('main')
<div class="panel panel-default">
    <div class="panel-heading">Laporan Pinjaman</div>
    <div class="panel-body">
        @if(Session::has('filter'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-info-circle"></i> {{ $filter }}
        </div>    
        @endif
        <form class="form-horizontal" action="{{ action("FiturController@histori_hutang_query") }}" method="POST">
            <div class="form-group">
                <label class="col-sm-2 control-label"> Jenis Pinjaman</label>
                <div class="col-sm-3">                                        
                    <select class="form-control siku" name="jenis">
                        <option value="Hutang">Hutang</option>
                        <option value="Kas Bon">Kas Bon</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Periode</label>
                <div class="col-sm-6 input-group ">
                    <div class="col-sm-5">
                        <input type="text" class="form-control" value="<?php echo date("d-m-Y") ?>" name="tglfrom" id="tglfrom">
                    </div>
                    <label class="col-sm-2 control-label">s/d</label>
                    <div class="col-sm-4 input-group ">
                        <input type="text" class="form-control" value="<?php echo date("d-m-Y") ?>" name="tglto" id="tglto">  
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"> Status </label>
                <div class="col-sm-3">                                        
                    <select class="form-control siku" name="status">
                        <option value="Y">Lunas</option>
                        <option value="N">Belum Lunas</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-3">                                        
                    <button class="btn btn-success siku"><i class="fa fa-search"></i> Filter</button>
                </div>
            </div>
        </form>    
        <hr>
        <table class="table table-bordered table-hover" id="datatable">
            <thead>
                <tr>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Total Pinjaman</th>
                    <th class="text-center">Jenis Pinjaman</th>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center">Opsi</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach($allHutangs as $allHutang)
                <tr>
                    <td>{{ date("d-m-Y", strtotime($allHutang->tglhut)) }}</td>
                    <td>Rp.<?php echo number_format($allHutang->nilhut, 0, ',', '.') ?>,-</td>
                    <td>{{  $allHutang->jenhut }}</td>
                    <td>{{ $allHutang->flglns == "Y" ? "Lunas" : "Belum Lunas" }}</td>
                    <td>
                        <?php if ($allHutang->jenhut == "Hutang") {
                            ?>
                            <a href="{{ action('FiturController@show_pinjaman', [$allHutang->idhut]) }}" class="btn btn-info" data-toggle="tooltip" data-placement="left" title="Detail?"><i class="fa fa-info-circle"></i></a> 
                            <?php
                        } else {
                            ?>
                            <a href="" class="btn btn-default disabled"><i class="fa fa-minus"></i></a>
                                <?php
                            }
                            ?>
                    </td>
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



