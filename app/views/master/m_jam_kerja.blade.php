@extends('template.master')

@section('title')
<title>ABSENSI - Master Jam Kerja</title>
@stop

@section('header')
<h1 class="page-header">Master Data
    <small>JAM KERJA</small>
</h1>
@stop

@section('main')
<div class="row">
    <form class="form-horizontal" action="{{ $action }}" method="POST">
        {{-- Form::open(array('action' => 'MasterJamKerjaController@create', 'class' => 'form-horizontal')) --}}
        @if(Session::has('mj02_success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-info-circle"></i> {{ $mj02_success }}
        </div>    
        @endif

        @if(Session::has('mj02_danger'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-warning"></i> {{ $mj02_danger }}
        </div>    
        @endif

        <div class="form-group">
            <label class="col-sm-2 control-label">Jenis : </label>
            <div class="col-sm-4">
                <label class="radio-inline">
                    <input type="radio" name="tipe" id="inlineRadio1" value="1" <?php if ($jam_kerja['tipe'] == 1 || is_null($jam_kerja)) echo "checked"; ?>> Jam Kerja
                </label>
                <label class="radio-inline">
                    <input type="radio" name="tipe" id="inlineRadio2" value="2" <?php if ($jam_kerja['tipe'] == 2) echo "checked"; ?>> Istirahat
                </label>
                <label class="radio-inline">
                    <input type="radio" name="tipe" id="inlineRadio3" value="3" <?php if ($jam_kerja['tipe'] == 3) echo "checked"; ?>> Lembur
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Jam Masuk</label>
            <div class="col-sm-4">
                <div class="col-sm-6 input-group clockpicker">
                    <input type="text" class="form-control" value="{{ Input::old('jmmsk', $jam_kerja["jmmsk"]) }}" name="jmmsk">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                    </span>
                </div>
                @if($errors->first('jmmsk'))
                <div class="col-sm-12 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('jmmsk') }}</div>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Jam Keluar</label>
            <div class="col-sm-4">
                <div class="col-sm-6 input-group clockpicker">
                    <input type="text" class="form-control" value="{{ Input::old('jmklr', $jam_kerja["jmklr"]) }}" name="jmklr">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                    </span>
                </div>
                @if($errors->first('jmklr'))
                <div class="col-sm-12 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('jmklr') }}</div>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Status Aktif</label>
            <div class="col-sm-4">
                <div class="col-sm-10 input-group">
                    <span class="input-group-addon">
                        <?php $flag = Input::old('status', $jam_kerja['status']); ?>
                        <input type="checkbox" name="status" value="Y" {{ (isset($flag)) ? (($flag == 'Y') ? "checked" : "") : "checked" }}>
                    </span>
                    <input readonly type="text" class="form-control" value="Aktif">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-4">
                <div class="col-sm-8 input-group">
                    <button class="btn btn-success" type="submit" value="btn_submit"> <i class=" glyphicon glyphicon-floppy-disk"></i> Simpan</button>
                    <a href="{{ action('MasterJamKerjaController@index') }}" class="btn btn-default"><i class="fa fa-repeat"></i> Reset</a>
                </div>
            </div>
        </div>
        <hr>
        <div class="form-group">
            <div class="col-sm-12 control-label">
                <table class="table table-bordered" id="datatable">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Tipe</th>
                            <th class="text-center">Jam Masuk</th>
                            <th class="text-center">Jam Keluar</th>
                            <th class="text-center">Status Aktif</th>
                            <th class="text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="text-left">
                        <?php $no = 1; ?>
                        @foreach($jam_kerjas as $jam_kerja)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $jam_kerja->tipe == 1 ? "Jam Kerja" : ($jam_kerja->tipe == 2 ? "Istirahat" : "Lembur") }}</td>
                            <td>{{ $jam_kerja->jmmsk }}</td>
                            <td>{{ $jam_kerja->jmklr; }}</td>
                            <td>{{ $jam_kerja->status == 'N' ? 'Tidak Aktif' : 'Aktif'; $no++; }}</td>
                            <td class="text-center">
                                <a href="{{ action('MasterJamKerjaController@edit', $jam_kerja->idjk) }}" class="btn btn-info" data-toggle="tooltip" data-placement="left" title="Edit Data?"><i class="fa fa-edit"></i></a>
                                <a href="{{ action('MasterJamKerjaController@destroy', $jam_kerja->idjk) }}" class="btn btn-danger delete" data-toggle="tooltip" data-placement="right" title="Hapus Data?"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Form::close() --}}
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
        alertify.confirm('Hapus Master Jam Kerja?', function (e) {
            if (e) {
                window.location.assign(a);
            } else {
                //after clicking Cancel
            }
        });
    });
</script> 
@stop

