@extends('template.master')

@section('title')
<title>ABSENSI - Master Jabatan</title>
@stop

@section('header')
<h1 class="page-header">Master Data
    <small>JABATAN</small>
</h1>
@stop

@section('main')
<div class="row">
    <div class="col-sm-12" style="">
        <div class="panel panel-default">
            <div class="panel-heading"></div>
            <div class="panel-body">
                <h3 class="page-header"><i class="fa fa-info-circle"></i> Master Jabatan</h3>
            </div>
            <form class="form-horizontal" action="{{ $action }}" method="POST">
                @if(Session::has('mj01_success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <i class="fa fa-info-circle"></i> {{ $mj01_success }}
                </div>    
                @endif
                <div class="form-group">
                    <label class="col-sm-2 control-label">Nama Jabatan</label>
                    <div class="col-sm-4 input-group">
                        <input type="text" class="form-control siku" value="{{ Input::old('nama', $jabatan['nama']) }}" name="nama">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-4 input-group">
                        <span class="input-group-addon siku">
                            <?php $flag = Input::old('flgomzt', $jabatan['flgomzt']);
                            ?>
                            <input type="checkbox" name="flgomzt" value="Y" {{ (isset($flag)) ? (($flag == 'Y') ? "checked" : "") : "" }}>
                        </span>
                        <input readonly type="text" class="form-control siku" value="Memiliki omset">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Status Aktif</label>
                    <div class="col-sm-4 input-group">
                        <span class="input-group-addon siku">
                            <?php $flagAktif = Input::old('status', $jabatan['status']); ?>
                            <input type="checkbox" name="status" value="Y" {{ (isset($flagAktif)) ? (($flagAktif == 'Y') ? "checked" : "") : "checked" }}>
                        </span>
                        <input readonly type="text" class="form-control siku" value="Aktif">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-4">
                        <div class="col-sm-8 input-group">
                            <button class="btn btn-success siku" type="submit" value="btn_submit"> <i class=" glyphicon glyphicon-floppy-disk"></i> Simpan</button>
                            &nbsp; <a href="{{ action('MasterJabatanController@index') }}" class="btn btn-default siku"><i class="fa fa-repeat"></i> Reset</a>
                        </div>
                    </div>
                </div>
            </form>
            <div class="panel-body">
                <div class="col-sm-12">
                    <table class="table table-bordered table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th class="text-left">No</th>
                                <th class="text-left">Nama Jabatan</th>
                                <th class="text-left">Omzet</th>
                                <th class="text-left">Status Aktif</th>
                                <th class="text-left">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="text-left">
                            <?php $no = 1; ?>
                            @foreach($jabatans as $jabatan)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $jabatan->nama }}</td>
                                <td>{{ $jabatan->flgomzt == 'N' ? 'Tidak memiliki omset' : 'Memiliki omset'; }}</td>
                                <td>{{ $jabatan->status == 'N' ? 'Tidak Aktif' : 'Aktif'; $no++; }}</td>
                                <td class="text-center">
                                    <a href="{{ action('MasterJabatanController@edit', $jabatan->idjb) }}" class="btn btn-info siku" data-toggle="tooltip" data-placement="left" title="Edit Data?"><i class="fa fa-edit"></i></a>
                                    <a href="{{ action('MasterJabatanController@destroy', $jabatan->idjb) }}" class="btn btn-danger siku delete" data-toggle="tooltip" data-placement="right" title="Hapus Data?"><i class="fa fa-trash"></i></a>
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
        pinnable: true, pinned: true,
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
        alertify.confirm('Hapus Master Jabatan?', function (e) {
            if (e) {
                window.location.assign(a);
            } else {
                //after clicking Cancel
            }
        });
    });
</script> 
@stop



