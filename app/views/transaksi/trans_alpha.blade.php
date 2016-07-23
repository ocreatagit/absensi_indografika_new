@extends('template.master')

@section('title')
<title>ABSENSI - Input Data</title>
@stop

@section('header')
<h1 class="page-header">Input Data
    <small>Cuti / Alpha</small>
</h1>
@stop

@section('main')
<div class="row">
    <div class="col-sm-12" style="">
        <div class="panel panel-default">
            @if(Session::has('ta03_success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <i class="fa fa-info-circle"></i> {{ $ta03_success }}
            </div>    
            @endif

            @if(Session::has('ta03_danger'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <i class="fa fa-info-circle"></i> {{ $ta03_danger }}
            </div>    
            @endif
            <div class="panel-heading">
            </div>
            <div class="panel-body">
                <div class="col-sm-12">
                    <div>
                        <form class="form-horizontal" action="{{ action("TransaksiAlphaController@store") }}" method="POST">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Nama Karyawan</label>
                                    <div class="col-sm-4 input-group">
                                        <select id="idkar" class="form-control siku" name="idkar" onchange="changeKaryawan('idkar')">
                                            <?php
                                            if (count($karyawans) > 0) {
                                                $usernm = $karyawans[0]->usernm;
                                                $img = $karyawans[0]->pic;
                                            }
                                            ?>
                                            @foreach($karyawans as $karyawan)
                                            <option value="{{ $karyawan->idkar }}">{{ $karyawan->nama }}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="getKaryawanUrl" id="getKaryawanUrl" value=""/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Kode Absensi</label>
                                    <div class="col-sm-2 input-group">                                        
                                        <input type="text" class="form-control" id="abscd" name="abscd" value="<?php echo $usernm ?>" disabled=""/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Tanggal Alpha / Cuti</label>
                                    <div class="col-sm-2 input-group">
                                        <input id="tglabs" type="text" class="form-control" value="{{ Input::old('tglabs', $tglabs) }}" name="tglabs">
                                        @if($errors->first('tglabs'))
                                        <div class="col-sm-12 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('tglabs') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Jenis</label>
                                    <div class="col-sm-2 input-group">
                                        <select class="form-control" name="jenis">
                                            <option value="Cuti">Cuti</option>
                                            <option value="Alpha">Alpha</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"></label>
                                    <div class="col-sm-6 input-group">                                        
                                        <button class="btn btn-primary"><i class="fa fa-plus-square"></i> Tambah Data</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <img src="<?php echo url("/uploads") . "/" . $img ?>" id="img" width="150" height="180" class="thumbnail">
                            </div>
                        </form>
                    </div>
                </div>
                <h3 class="page-header"><i class="fa fa-info-circle"></i> Alpha / Cuti Karyawan</h3>
                <div>
                    <table class="table table-bordered table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th class="text-left">No</th>
                                <th class="text-left">Tanggal</th>
                                <th class="text-left">Karyawan</th>
                                <th class="text-left">Jenis</th>
                                <th class="text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="text-left">
                            <?php $no = 1; ?> 
                            @foreach($alphas as $alpha)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ strftime("%d-%b-%Y", strtotime($alpha->tglabs)) }}</td>
                                <td>{{ $alpha->nama }}</td>
                                <td>{{ $alpha->jenis }}</td>                                
                                <td class="text-center">
                                    <a href="{{ action('TransaksiAlphaController@destroy', [$alpha->id]) }}" class="btn btn-danger delete" data-toggle="tooltip" data-placement="right" title="Hapus Data?"><i class="fa fa-trash"></i></a>
                                </td>                                
                            </tr>
                            <?php $no++; ?>
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
        $('#datatable').DataTable({
            "paging": true, // next page
            "ordering": true, // order by at header 
            "info": false
        });
    });

    $("#tglabs").datepicker({
        inline: true,
        dateFormat: "dd-mm-yy",
        changeYear: true,
        changeMonth: true
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
        alertify.confirm('Hapus Data Cuti / Alpha Karyawan?', function (e) {
            if (e) {
                window.location.assign(a);
            } else {
                //after clicking Cancel
            }
        });
    });
</script> 
@stop



