@extends('template.master')

@section('title')
<title>ABSENSI - Input Omzet Karyawan</title>
@stop

@section('header')
<h1 class="page-header">Input Data
    <small>Omzet Karyawan</small>
</h1>
@stop

@section('main')
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <a id="" href="{{ action('TransaksiOmzetController@index') }}" class="btn btn-primary"><i class="fa fa-backward"></i> Kembali </a>
        </div>
        @if(Session::has('tz01_success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-info-circle"></i> {{ $tz01_success }}
        </div>    
        @endif        
        <div class="panel-body">
            <div class="col-sm-12">
                <form class="form-horizontal" action="{{ action("TransaksiOmzetController@store") }}" method="POST">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nama Karyawan : </label>
                        <div class="col-sm-2 input-group ">
                            <select class="form-control" name="idkar">
                                @foreach($karyawanalls as $karyawanall)
                                <option value="{{ $karyawanall->idkar }}">{{ $karyawanall->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tanggal Transaksi :</label>
                        <div class="col-sm-3 input-group ">
                            <input type="text" name="tglomz" id="jmlomz" value="{{ Input::old("tglomz", date('d-m-Y')) }}" class="form-control"/>
                            @if($errors->first('tglomz'))
                            <div class="col-sm-12 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('tglomz') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Jumlah Omzet : </label>
                        <div class="col-sm-4 input-group ">
                            <input type="text" name="nilomz" value="" class="form-control"/>
                            @if($errors->first('nilomz'))
                            <div class="col-sm-12 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('nilomz') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                            <div class="col-sm-8 input-group">
                                <?php if (count($karyawanalls) > 0) { ?>
                                    <button class="btn btn-success"> <i class=" glyphicon glyphicon-floppy-disk"></i> Simpan</button>
                                <?php } else { ?>
                                    <button class="btn btn-danger" disabled=""> <i class="glyphicon glyphicon-floppy-disk"></i> Simpan</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </form>
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

        $("#jmlomz").datepicker({
            inline: true,
            dateFormat: "dd-mm-yy",
            changeYear: true,
            changeMonth: true
        });
    });

    alertify.defaults = {
        // dialogs defaults
        modal: true,
        basic: false,
        frameless: false,
        movable: true,
        resizable: true,
        closable: true,
        closableByDimmer: true,
        maximizable: true,
        startMaximized: false,
        pinnable: true,
        pinned: true,
        padding: true,
        overflow: true,
        maintainFocus: true,
        transition: 'pulse',
        autoReset: true,
        // notifier defaults
        notifier: {
            // auto-dismiss wait time (in seconds)  
            delay: 5,
            // default position
            position: 'bottom-right'
        },
        // language resources 
        glossary: {
            // dialogs default title
            title: 'Konfirmasi',
            // ok button text
            ok: 'OK',
            // cancel button text
            cancel: 'Batal'
        },
        // theme settings
        theme: {
            // class name attached to prompt dialog input textbox.
            input: 'ajs-input',
            // class name attached to ok button
            ok: 'ajs-ok',
            // class name attached to cancel button 
            cancel: 'ajs-cancel'
        }
    };

    $(".delete").click(function (e) {
        e.preventDefault();
        var a = this.href;
        alertify.confirm('Hapus Master Karyawan?', function (e) {
            if (e) {
                window.location.assign(a);
            } else {
                //after clicking Cancel
            }
        });
    });
</script> 
@stop



