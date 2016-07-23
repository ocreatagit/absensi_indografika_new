@extends('template.master')

@section('title')
<title>ABSENSI - Input Data</title>
@stop

@section('header')
<h1 class="page-header">Input Data
    <small>Hutang</small>
</h1>
@stop

@section('main')
<div class="row">
    <div class="col-sm-12" style="">
        <div class="panel panel-default">
            <div class="panel-heading"></div>
            @if(Session::has('th01_success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <i class="fa fa-info-circle"></i> {{ $th01_success }}
            </div>    
            @endif
            @if(Session::has('th01_danger'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <i class="fa fa-warning"></i> {{ $th01_danger }}
            </div>    
            @endif
            <div class="panel-body">
                <div class="row">
                    <form class="form-horizontal" action="{{ action("TransaksiHutangController@store") }}" method="POST">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nama Karyawan</label>
                                <div class="col-sm-6 input-group">
                                    <select id="idkar" class="form-control" name="idkar" onchange="changeKaryawan('idkar')">
                                        <?php
                                        if(count($karyawans) > 0){
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
                                <div class="col-sm-6 input-group">                                        
                                    <input type="text" class="form-control" id="abscd" name="abscd" value="<?php echo $usernm ?>" disabled=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Jenis Pinjaman</label>
                                <div class="col-sm-6 input-group">
                                    <select class="form-control" name="idhut">
                                        <option value="Hutang">Hutang</option>
                                        <option value="Kas Bon">Kas Bon</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Angsuran</label>
                                <div class="col-sm-2 input-group">                                                               
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="jmlang" value="1"/>
                                        <div class="input-group-addon"><i class="fa fa-times"></i></div>
                                    </div>                                    
                                </div>                                
                                @if($errors->first('jmlang'))
                                <div class="col-sm-12 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('jmlang') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Jumlah Pinjaman</label>
                                <div class="col-sm-6 input-group">                                        
                                    <input type="text" class="form-control" name="nilhut" value=""/>
                                    @if($errors->first('nilhut'))
                                    <div class="col-sm-12 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('nilhut') }}</div>
                                    @endif
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
                            <img src="<?php echo url("/uploads")."/".$img ?>" id="img" width="120" height="150">
                        </div>
                    </form>
                </div>
                <div>
                    <h3 class="page-header"><i class="fa fa-info-circle"></i> Status Pinjaman Karyawan</h3>
                    <table class="table table-bordered table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Nomor Transaksi Hutang</th>
                                <th class="text-center">Nama Karyawan</th>
                                <th class="text-center">Total Pinjaman</th>
                                <th class="text-center">Jenis Pinjaman</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach($hutangs as $hutang)
                            <tr>
                                <td> {{ strftime("%d-%b-%Y", strtotime($hutang->tglhut)) }}</td>
                                <td> {{ $hutang->norhut }} </td>
                                <td>{{ $hutang->nama }}</td>
                                <td>Rp.<?php echo number_format($hutang->nilhut, 0, ',', '.') ?>,-</td>
                                <td>{{ $hutang->jenhut }}</td>
                                <td>{{ $hutang->flglns == "Y" ? "Lunas" : "Belum Lunas" }}</td>
                                <td>
                                    <a href="{{ action('TransaksiHutangController@edit', [$hutang->idhut]) }}" class="btn btn-info" data-toggle="tooltip" data-placement="right" title="Edit Data?"><i class="fa fa-edit"></i></a>
                                    <a href="{{ action('TransaksiHutangController@destroy', [$hutang->idhut]) }}" class="btn btn-danger delete" data-toggle="tooltip" data-placement="right" title="Hapus Data?"><i class="fa fa-trash"></i></a>
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
            alertify.confirm('Hapus Hutang Karyawan?', function (e) {
                if (e) {
                    window.location.assign(a);
                } else {
                    //after clicking Cancel
                }
            });
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