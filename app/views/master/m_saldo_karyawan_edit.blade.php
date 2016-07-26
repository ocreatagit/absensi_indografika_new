@extends('template.master')

@section('title')
<title>ABSENSI - Input Data</title>
@stop

@section('header')
<h1 class="page-header">Input Data
    <small>Saldo Tabungan</small>
</h1>
@stop

@section('main')
<div class="row">
    <form class="form-horizontal" action="{{ action("TransaksiSaldoTabunganController@update", ["id" => $karyawan->idkar]) }}" method="POST">
        @if(Session::has('mk01_success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-info-circle"></i> {{ $mk01_success }}
        </div>    
        @endif
        <div class="col-sm-7">
            <div class="form-group">
                <label class="col-sm-4 control-label">Nama Karyawan</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control siku" name="" disabled="" value="{{ $karyawan->nama }}"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Saldo Tabungan</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control siku text-right" name="tbsld" value="{{ Input::old("tbsld", $karyawan->tbsld) }}"/>
                    @if($errors->first('tbsld'))
                    <div class="col-sm-12 alert alert-danger siku" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('tbsld') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label"></label>
                <div class="col-sm-5">
                    <div class="col-sm-12 input-group">
                        <a href="{{ action('TransaksiSaldoTabunganController@index') }}" class="btn btn-primary siku"><i class="fa fa-backward"></i> Kembali</a> &nbsp;
                        <button class="btn btn-success siku"> <i class=" glyphicon glyphicon-floppy-disk"></i> Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
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
        alertify.confirm('Hapus Master Gaji?', function (e) {
            if (e) {
                window.location.assign(a);
            } else {
                //after clicking Cancel
            }
        });
    });

    function changeKaryawan(idkar) {
        var id = document.getElementById(idkar).value;
        var url = "<?php echo url("/master/karyawan/get_karyawan") ?>" + "/" + id;

        $.get(url, function (data) {
            var mk01 = JSON.parse(data);
            console.log(mk01);
            $("#abscd").val(mk01.usernm);
            var img = "<?php echo url("/uploads") ?>" + "/" + mk01.pic;
            $("#img").attr("src", img);
        });
    }
</script> 
@stop



