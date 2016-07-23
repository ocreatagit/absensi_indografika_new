@extends('template.master')

@section('title')
<title>ABSENSI - My Indografika</title>
@stop

@section('header')
<h1 class="page-header">Ubah Persen Bonus Karyawan
</h1>
@stop

@section('main')
<div class="row">    
        <div class="panel panel-default">
            <div class="panel-heading">Ubah Persen Bonus Karyawan </div>
            <div class="panel-body">
                @if(Session::has('filter'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <i class="fa fa-info-circle"></i> {{ $filter }}
                </div>    
                @endif
                <form class="form-horizontal" action="{{ action("LaporanAdminController@persen_bonus_karyawan_save") }}" method="POST">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Persen Bonus</label>
                        <div class="col-sm-1 input-group">                            
                            <div class="input-group">
                                <input type="text" class="form-control siku" value="{{ Input::old('prsbns', $prsbns) }}" name="prsbns">
                                <div class="input-group-addon">%</div>
                            </div>
                        </div>
                        @if($errors->first('prsbns'))
                        <div class="col-sm-3 col-sm-offset-2 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('prsbns') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-3 input-group">                                        
                            <button class="btn btn-primary siku"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </form>
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



