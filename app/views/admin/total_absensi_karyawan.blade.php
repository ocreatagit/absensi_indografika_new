@extends('template.master')

@section('title')
<title>ABSENSI - My Indografika</title>
@stop

@section('header')
<h1 class="page-header">My Indografika
    <small>Laporan Absensi</small>
</h1>
@stop

@section('main')
<div class="row">    
        <div class="panel panel-default">
            <div class="panel-heading">Laporan Presensi </div>
            <div class="panel-body">
                @if(Session::has('filter'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <i class="fa fa-info-circle"></i> {{ $filter }}
                </div>    
                @endif
                <form class="form-horizontal" action="{{ action("LaporanAdminController@presensi_karyawan_query") }}" method="POST">
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
                        <label class="col-sm-2 control-label">Karyawan</label>
                        <div class="col-sm-3">
                            <select class="form-control siku" name="idkar">
                                <option value="0">Semua</option>
                                @foreach($karyawans as $karyawan)
                                <option value="{{ $karyawan->idkar }}">{{ $karyawan->nama }}</option>
                                @endforeach
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
                            <th class="text-center">Nama</th>
                            <th class="text-center" width="15%">Tanggal</th>
                            <th class="text-center">Jam Masuk</th>
                            <th class="text-center">Jam Istirahat Keluar </th>
                            <th class="text-center">Jam Istirahat Kembali </th>
                            <th class="text-center">Jam Pulang </th>
                            <th class="text-center">Jam Lembur Masuk </th>
                            <th class="text-center">Jam Lembur Pulang </th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php foreach ($presensies as $pres) { ?>
                            <tr>
                                <td><?= $pres[1] ?></td>
                                <td><?= date("d-m-Y", strtotime( $pres[2])) ?></td>
                                <td><?= $pres[3] ?></td>
                                <td><?= $pres[5] ?></td>
                                <td><?= $pres[6] ?></td>
                                <td><?= $pres[4] ?></td>
                                <td><?= $pres[7] ?></td>
                                <td><?= $pres[8] ?></td>
                            </tr>
                        <?php } ?>
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



