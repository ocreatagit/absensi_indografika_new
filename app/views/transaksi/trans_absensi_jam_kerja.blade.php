@extends('template.master')

@section('title')
<title>ABSENSI - Input Data</title>
@stop

@section('header')
<h1 class="page-header">Input Data
    <small>Absensi - jam kerja</small>
</h1>
@stop

@section('main')
<div class="row">
    <div class="col-sm-12" style="">
        <div class="panel panel-default">
            <div class="panel-heading"></div>
            @if(Session::has('ta01_success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <i class="fa fa-info-circle"></i> {{ $ta01_success }}
            </div>    
            @endif
            @if(Session::has('ta01_danger'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <i class="fa fa-warning"></i> {{ $ta01_danger }}
            </div>    
            @endif
            <div class="panel-body">
                <h3 class="page-header"><i class="fa fa-info-circle"></i> Input Data Absensi - Detail </h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <form class="form-horizontal" action="{{ action("TransaksiAbsensiController@store", [$karyawan->idkar]) }}" method="POST">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nama Karyawan</label>
                                <div class="col-sm-4 input-group">
                                    <select readonly id="idkar" class="form-control siku" name="idkar" onchange="changeKaryawan('idkar')">
                                        <?php
                                        $usernm = $karyawan->usernm;
                                        $img = $karyawan->pic;
                                        ?>
                                        <option value="{{ $karyawan->idkar }}">{{ $karyawan->nama }}</option>
                                    </select>
                                    <input type="hidden" name="getKaryawanUrl" id="getKaryawanUrl" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Tanggal Absensi</label>
                                <div class="col-sm-4 input-group">
                                    <input id="tglabs" type="text" class="form-control siku" value="{{ Input::old('tglabs', $tglabs) }}" name="tglabs">
<!--                                    <select id="idkar" class="form-control" name="idjk" onchange="">
                                        @foreach($jamkerjas as $jamkerja)
                                        <option value="{{ $jamkerja->ta01_id }}">{{ date('d-m-Y', strtotime($jamkerja->tgl)) }}</option>
                                        @endforeach
                                    </select>-->
                                    @if($errors->first('tglabs'))
                                    <div class="col-sm-12 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('tglabs') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Jenis Jam Kerja</label>
                                <div class="col-sm-3 input-group">                                        
                                    <select id="idkar" class="form-control siku" name="abscd" onchange="">
                                        <option value="0">Jam Masuk</option>
                                        <option value="2">Jam Istirahat Keluar</option>
                                        <option value="3">Jam Istirahat Kembali</option>
                                        <option value="1">Jam Pulang</option>
                                        <option value="4">Jam Lembur Masuk</option>
                                        <option value="5">Jam Lembur Pulang</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Jam Masuk</label>
                                <div class="col-sm-2 input-group clockpicker">
                                    <input type="text" class="form-control siku" value="{{ Input::old('jmmsk', '08:00') }}" name="jmmsk">
                                    <span class="input-group-addon siku">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                                @if($errors->first('jmmsk'))
                                <div class="col-sm-4 col-sm-offset-4 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('jmmsk') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4 text-right">
                                    <a href="{{ action("TransaksiAbsensiController@index") }}" class="btn btn-primary siku"><i class="fa fa-backward"></i> Kembali</a> 
                                </div>
                                <div class="col-sm-8 input-group">
                                    <button class="btn btn-primary siku" name="btn_tambah" value="tambah"><i class="fa fa-plus-square"></i> Tambah / Edit Jam Kerja</button> &nbsp;
                                    <button class="btn btn-danger siku" name="btn_hapus" value="hapus"><i class="fa fa-times"></i> Hapus </button> &nbsp;
                                    <button class="btn btn-success siku" name="btn_cari" value="cari"><i class="fa fa-search"></i> Cari </button> &nbsp;
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <img id="img" src="<?php echo url("/uploads") . "/" . $img ?>" width="120" height="150" class="thumbnail">
                        </div>
                    </form>
                </div>
                <div>
                    <h3 class="page-header"><i class="fa fa-info-circle"></i> Absensi </h3>
                    <table class="table table-bordered table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Jam Masuk</th>
                                <th class="text-center">Jam Istirahat Keluar</th>
                                <th class="text-center">Jam Istirahat Masuk</th>
                                <th class="text-center">Jam Pulang</th>
                                <th class="text-center">Jam Lembur Masuk</th>
                                <th class="text-center">Jam Lembur Pulang</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php foreach ($presensies as $pres) { ?>
                                <tr>
                                    <td><?= date("d-m-Y", strtotime($pres->tglabs)) ?></td>
                                    <td><?= $pres->jammasuk ?></td>
                                    <td><?= $pres->jamkeluar ?></td>
                                    <td><?= $pres->jamkembali ?></td>
                                    <td><?= $pres->jampulang ?></td>
                                    <td><?= $pres->jamlemburmasuk ?></td>
                                    <td><?= $pres->jamlemburpulang ?></td>
                                </tr>
                            <?php } ?>
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
            alertify.confirm('Hapus Tabungan Karyawan?', function (e) {
                if (e) {
                    window.location.assign(a);
                } else {
                    //after clicking Cancel
                }
            });
        });

        $('#datatable').DataTable();

        $("#tglabs").datepicker({
            inline: true,
            dateFormat: "dd-mm-yy",
            changeYear: true,
            changeMonth: true
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

//        $.ajax({
//            url: url,
//            type: 'POST',
//            success: function (data, textStatus, jqXHR) {
//                var lokasi = JSON.parse(data);
//            }, error: function (jqXHR, textStatus, errorThrown) {
//                alert(JSON.stringify(jqXHR));
//            }
//        });
    }
</script> 
@stop



