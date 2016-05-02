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
    <div class="panel panel-default" id="infGaji">
        <div class="panel-heading">Informasi Gaji</div>
        <div class="panel-body">
            <form class="form-horizontal" action="{{ action("MasterKaryawanController@saveItemGaji", array($idkaryawan)) }}" method="POST">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Jenis Gaji</label>
                    <div class="col-sm-3 input-group ">
                        <select class="form-control" name="idgj">
                            @foreach($gajis as $gaji)
                            <option value="{{ $gaji->idgj }}">{{ $gaji->jenis }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="idkaryawan" value="{{ $idkaryawan }}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Nominal Gaji</label>
                    <div class="col-sm-3 input-group ">
                        <input type="text" class="form-control" value="" name="nilgj">                                    
                    </div>
                    @if($errors->first('nilgj'))
                    <div class="col-sm-3 col-sm-offset-2 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('nilgj') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-4">
                        <div class="col-sm-8 input-group">
                            <button class="btn btn-success"> <i class=" glyphicon glyphicon-floppy-disk"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
            <hr>
            <div class="col-sm-6">
                <table class="table table-bordered table-hover" id="datatable">
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
                                <a href="{{ action('MasterKaryawanController@deleteItemGaji', [$row->rowid, $idkaryawan]) }}" class="btn btn-danger delete" data-toggle="tooltip" data-placement="right" title="Hapus Data?"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-sm-12" style="margin-top: 2%; margin-bottom: 1.5%">
                    <!--<a class="btn btn-info btn-block" id="next" onclick="goToDiv('next','infGaji')"><i class="fa fa-arrow-down"></i> Tambah Informasi Gaji <i class="fa fa-arrow-down"></i></a>-->
            <a class="btn btn-info btn-block" href="{{ action('MasterKaryawanController@saveGaji') }}"><h3 style="margin-top: 0px; margin-bottom: 0px;"> <i class="fa fa-save"></i> Simpan Gaji Karyawan </h3> </a>
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

        $("#tglaktif").datepicker({
            inline: true,
            dateFormat: "dd-mm-yy",
            changeYear: true,
            changeMonth: true
        });

        $("#ttl").datepicker({
            inline: true,
            dateFormat: "dd-mm-yy",
            changeYear: true,
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
</script> 
@stop



