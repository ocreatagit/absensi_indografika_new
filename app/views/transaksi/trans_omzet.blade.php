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
    <div class="col-sm-12" style="">
        <div class="panel panel-default">
            <div class="panel-heading">
                <!--<a id="tambah" href="{{ action('TransaksiOmzetController@create') }}" class="btn btn-primary"><i class="fa fa-plus-square"></i> Tambah Omzet</a>-->
            </div>
            <div class="panel-body">
                <h3 class="page-header"><i class="fa fa-info-circle"></i> Input Data Omzet</h3>
            </div>
            @if(Session::has('tz01_success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <i class="fa fa-info-circle"></i> {{ $tz01_success }}
            </div>    
            @endif
            @if(Session::has('tz01_danger'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <i class="fa fa-warning"></i> {{ $tz01_danger }}
            </div>    
            @endif
            <div class="panel-body">
                <div class="col-sm-12">
                    <form class="form-horizontal" action="{{ action("TransaksiOmzetController@store") }}" method="POST">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama Karyawan : </label>
                            <div class="col-sm-2">
                                <select class="form-control siku" name="idkar">
                                    @foreach($karyawanalls as $karyawanall)
                                    <option value="{{ $karyawanall->idkar }}">{{ $karyawanall->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tanggal Transaksi :</label>
                            <div class="col-sm-3">
                                <input type="text" name="tglomz" id="tglomz" value="{{ Input::old("tglomz", date('d-m-Y')) }}" class="form-control siku"/>
                                @if($errors->first('tglomz'))
                                <div class="col-sm-12 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('tglomz') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Jumlah Omzet : </label>
                            <div class="col-sm-4">
                                <input type="text" name="nilomz" value="" class="form-control siku"/>
                                @if($errors->first('nilomz'))
                                <div class="col-sm-12 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('nilomz') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-4">
                                <?php if (count($karyawanalls) > 0) { ?>
                                    <button class="btn btn-success siku"> <i class=" glyphicon glyphicon-floppy-disk"></i> Simpan</button>
                                <?php } else { ?>
                                    <button class="btn btn-danger siku" disabled=""> <i class="glyphicon glyphicon-floppy-disk"></i> Simpan</button>
                                <?php } ?>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <table class="table table-bordered table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th class="text-left">No</th>
                                <th class="text-left">Tanggal Transaksi</th>
                                <th class="text-left">Nama</th>
                                <th class="text-left">Nilai Omzet</th>
                                <th class="text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="text-left">
                            <?php $no = 1; ?>
                            @foreach($omzets as $omzet)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ strftime("%d-%b-%Y", strtotime($omzet->tglomz)) }}</td>
                                <td>{{ $omzet->nama }}</td>
                                <td>Rp.{{ number_format($omzet->nilomz,0,',','.') }},-</td>
                                <td class="text-center">
                                    <a href="{{ action('TransaksiOmzetController@destroy', $omzet->id) }}" class="btn btn-danger siku delete" data-toggle="tooltip" data-placement="left" title="Hapus Data?"><i class="fa fa-trash"></i></a>
                                </td>
                                <?php $no++; ?>
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

        $("#tglomz").datepicker({
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
        alertify.confirm('Hapus Omzet Bulanan Karyawan?', function (e) {
            if (e) {
                window.location.assign(a);
            } else {
                //after clicking Cancel
            }
        });
    });
</script> 
@stop



