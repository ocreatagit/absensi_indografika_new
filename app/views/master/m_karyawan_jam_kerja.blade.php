@extends('template.master')

@section('title')
<title>ABSENSI - Master Karyawan</title>
@stop

@section('header')
<h1 class="page-header">Master Data
    <small>KARYAWAN</small>
</h1>
@stop

@section('main')
<div class="row">
    <div class="col-sm-12">
        @if(Session::has('mk01_failed'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-info-circle"></i> {{ $mk01_failed }}
        </div>    
        @endif
    </div>
    <div class="col-sm-6">
        <div class="panel panel-default" id="infGaji">
            <div class="panel-heading"><big> <i class="fa fa-clock-o"></i> Informasi Jam Kerja </big> </div>
            <div class="panel-body">
                <form class="form-horizontal" action="{{ action("MasterKaryawanController@saveItemJamKerja", array($idkaryawan)) }}" method="POST">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Jam Kerja</label>
                        <div class="col-sm-5">
                            <select class="form-control siku" name="jmkrj" id="jmkrj" onchange="getJenJmKrj(this)">
                                <?php
                                $jenjmkrj = "";
                                if (count($jam_kerjas) > 0) {
                                    $jenjmkrj = $jam_kerjas[0]->tipe == 1 ? "Jam Kerja" : "Jam Istirahat";
                                }
                                ?>

                                @foreach($jam_kerjas as $jam_kerja)
                                <option value="{{ $jam_kerja->idjk }}">{{ $jam_kerja->jmmsk." - ".$jam_kerja->jmklr }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="idkar" value="{{ $idkaryawan }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Jenis Jam Kerja</label>
                        <div class="col-sm-5">
                            <input type="text" id="jenjmkrj" class="form-control siku" value="{{ $jenjmkrj }}" name="" disabled="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-5">
                            <button class="btn btn-success siku"> <i class=" glyphicon glyphicon-floppy-disk"></i> Tambah</button>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="col-sm-12">
                    <table class="table table-bordered table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th class="text-left">Jam Kerja</th>
                                <th class="text-left">Jenis</th>
                                <th class="text-left">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach($jam_kerja_karyawans as $jam_kerja_karyawan)
                            <tr>
                                <td>{{ $jam_kerja_karyawan->jmmsk." - ".$jam_kerja_karyawan->jmklr }}</td>
                                <td>{{ $jam_kerja_karyawan->tipe == 1 ? "Jam Kerja" : "Jam Istirahat" }}</td>
                                <td>
                                    <a href="{{ action('MasterKaryawanController@deleteItemJamKerja', [$jam_kerja_karyawan->id, $jam_kerja_karyawan->mk01_id]) }}" class="btn btn-danger delete siku" data-toggle="tooltip" data-placement="right" title="Hapus Data?"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-default" id="infGaji">
            <div class="panel-heading"><big> <i class="fa fa-money"></i> Informasi Gaji </big> </div>
            <div class="panel-body">
                <form class="form-horizontal" action="{{ action("MasterKaryawanController@saveItemGaji", array($idkaryawan)) }}" method="POST">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Jenis Gaji</label>
                        <div class="col-sm-5">
                            <select class="form-control siku" name="idgj">
                                @foreach($gajis as $gaji)
                                <option value="{{ $gaji->idgj }}">{{ $gaji->jenis }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="idkaryawan" value="{{ $idkaryawan }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nominal Gaji</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control siku" value="" name="nilgj">                                    
                        </div>
                        @if($errors->first('nilgj'))
                        <div class="col-sm-5 col-sm-offset-3 alert alert-danger siku" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('nilgj') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-5">
                            <div class="col-sm-8">
                                <button class="btn btn-success siku"> <i class=" glyphicon glyphicon-floppy-disk"></i> Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="col-sm-12">
                    <table class="table table-bordered table-hover" id="datatable2">
                        <thead>
                            <tr>
                                <th class="text-left">Jenis Gaji</th>
                                <th class="text-left">Nominal Gaji</th>
                                <th class="text-left">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach($cart as $row)
                            <tr>
                                <td>{{ $row->options['jenis_gaji'] }}</td>
                                <td>Rp.{{ number_format($row->price,0, ',','.') }},-</td>
                                <td>
                                    <a href="{{ action('MasterKaryawanController@deleteItemGaji', [$row->rowid, $idkaryawan]) }}" class="btn btn-danger delete siku" data-toggle="tooltip" data-placement="right" title="Hapus Data?"><i class="fa fa-trash"></i></a>
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
<div class="row" style="margin-top: 0px; padding-top: 0px;">
    <div class="col-sm-12" style="margin-top: 2%; margin-bottom: 1.5%">
        <a class="btn btn-info btn-block siku" href="{{ action('MasterKaryawanController@saveGaji', [$idkaryawan]) }}"><h3 style="margin-top: 0px; margin-bottom: 0px;"> <i class="fa fa-save"></i> Simpan Gaji Karyawan </h3> </a>
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
        $('#datatable2').DataTable();

        $("#tglaktif").datepicker({
            inline: true,
            dateFormat: "dd-mm-yy", changeYear: true,
            changeMonth: true
        });

        $("#ttl").datepicker({
            inline: true,
            dateFormat: "dd-mm-yy", changeYear: true,
            changeMonth: true
        });
    });
    function goToDiv(button, div) {
        $("#" + button).click(function () {
            $('html,body').animate({
                scrollTop: $("#" + div).offset().top},
            'slow');
        });
    }

    function getJenJmKrj(jmkrj) {
        var id = jmkrj.value;
        var url = "<?php echo url("/master/karyawan/get_jenis_jam_kerja") ?>" + "/" + id;

        $.get(url, function (data) {
            $("#jenjmkrj").val(data);
        });
    }
</script> 
@stop



