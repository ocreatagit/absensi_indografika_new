@extends('template.master')

@section('title')
<title>ABSENSI - Master Gaji</title>
@stop

@section('header')
<h1 class="page-header">Master Data
    <small>JENIS GAJI</small>
</h1>
@stop

@section('main')
<div class="row">
    <form class="form-horizontal" action="{{ $action }}" method="POST">
        @if(Session::has('mg01_success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-info-circle"></i> {{ $mg01_success }}
        </div>    
        @endif
        <div class="form-group">
            <label class="col-sm-2 control-label">Jenis Gaji</label>
            <div class="col-sm-4">
                <div class="col-sm-10 input-group ">
                    <input type="text" class="form-control"  value="{{ Input::old('jenis', $gaji["jenis"]) }}" name="jenis">
                </div>
                @if($errors->first('jenis'))
                <div class="col-sm-12 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('jenis') }}</div>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Status Aktif</label>
            <div class="col-sm-4">
                <div class="col-sm-10 input-group">
                    <span class="input-group-addon">
                        <?php $flag = Input::old('status', $gaji['status']); ?>
                        <input type="checkbox" name="status" value="Y" {{ (isset($flag)) ? (($flag == 'Y') ? "checked" : "") : "checked" }}>
                    </span>
                    <input readonly type="text" class="form-control" value="Aktif">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Jenis Tagih</label>
            <div class="col-sm-2">
                <div class="col-sm-10 input-group">
                    <select name="jntgh" class="form-control">
                        <option value="Hari" <?php echo $gaji["jntgh"] == "Hari" ? "selected" : ''; ?>>Hari</option>
                        <option value="Bulan" <?php echo $gaji["jntgh"] == "Bulan" ? "selected" : ''; ?>>Bulan</option>
                        <option value="Jam" <?php echo $gaji["jntgh"] == "Jam" ? "selected" : ''; ?>>Jam</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-4">
                <div class="col-sm-8 input-group">
                    <button class="btn btn-success"> <i class=" glyphicon glyphicon-floppy-disk"></i> Simpan</button>
                    <a href="{{ action('MasterGajiController@index') }}" class="btn btn-default"><i class="fa fa-repeat"></i> Reset</a>
                </div>
            </div>
        </div>
    </form>
    <hr>
    <div class="col-sm-8 col-sm-offset-2">
        <table class="table table-bordered table-hover" id="datatable">
            <thead>
                <tr>
                    <th class="text-left">No</th>
                    <th class="text-left">Jenis</th>
                    <th class="text-left">Jenis Tagih</th>
                    <th class="text-left">Status</th>
                    <th class="text-left">Opsi</th>
                </tr>
            </thead>
            <tbody class="text-left">
                <?php $no = 1; ?>
                @foreach($gajis as $gaji)                
                <tr>
                    <td>{{ $no }}</td>
                    <td>{{ $gaji->jenis }}</td>
                    <td>{{ $gaji->jntgh }}</td>
                    <td>{{ $gaji->status == 'N' ? 'Tidak Aktif' : 'Aktif'; $no++; }}</td>
                    <td class="text-center">
                        <a href="{{ action('MasterGajiController@edit', $gaji->idgj) }}" class="btn btn-info" data-toggle="tooltip" data-placement="left" title="Edit Data?"><i class="fa fa-edit"></i></a>
                        <a href="{{ action('MasterGajiController@destroy', $gaji->idgj) }}" class="btn btn-danger delete" data-toggle="tooltip" data-placement="right" title="Hapus Data?"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
<!--                <tr>
                    <td>Gaji Harian</td>
                    <td>Tidak ada status</td>
                </tr>-->
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
</script> 
@stop



