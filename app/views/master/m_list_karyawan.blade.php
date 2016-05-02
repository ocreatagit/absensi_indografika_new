@extends('template.master')

@section('title')
<title>ABSENSI - Master Karyawan</title>
@stop

@section('header')
<h1 class="page-header">Master Data
    <small>DAFTAR KARYAWAN</small>
</h1>
@stop

@section('main')
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <a id="tambah" href="{{ action('MasterKaryawanController@create') }}" class="btn btn-primary"><i class="fa fa-plus-square"></i> Tambah Karyawan</a>
        </div>
        @if(Session::has('mk01_success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-info-circle"></i> {{ $mk01_success }}
        </div>    
        @endif
        <div class="panel-body">
            <div class="col-sm-12">
                <table class="table table-bordered table-hover" id="datatable">
                    <thead>
                        <tr>
                            <th class="text-left">No</th>
                            <th class="text-left">Foto</th>
                            <th class="text-left">Nama</th>
                            <th class="text-left">Username</th>
                            <th class="text-left">Jabatan</th>
                            <th class="text-left">Tanggal Lahir</th>
                            <th class="text-left">Saldo</th>                            
                            <th class="text-left">Status</th>                            
                            <th class="text-left">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="text-left">
                        <?php $no = 1; ?>
                        @foreach($karyawans as $karyawan)
                        <tr>
                            <td>{{ $no }}</td>
                            <td><a href="{{ url("uploads/".$karyawan->pic) }}" data-lightbox="roadtrip"> {{ $karyawan->pic != "" ? HTML::image('uploads/'.$karyawan->pic, $karyawan->nama, array('class' => 'thumbnail', "width" => 180)) : HTML::image('uploads/no_image.png', "No Image", array('class' => 'thumbnail', "width" => 180)) }} </a> </td>
                            <td>{{ $karyawan->nama }}</td>
                            <td>{{ $karyawan->usernm }}</td>
                            <td>{{ $karyawan->mj01->nama }}</td>
                            <td>{{ strftime("%d-%b-%Y", strtotime($karyawan->ttl)) }}</td>
                            <td width="35%">
                                <div class="row">
                                    <div class="col-lg-6 text-right">Tabungan : </div>
                                    <div class="col-lg-6 text-right">Rp.{{ number_format($karyawan->tbsld, 0, ",", ".") }},-</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 text-right">Hutang : </div>
                                    <div class="col-lg-6 text-right">Rp.{{ number_format($karyawan->htsld, 0, ",", ".") }},-</div>
                                </div>
                            </td>
                            <td class="text-center" width="15%">
                                {{ $karyawan->status == 'N' ? '<font color="red">Tidak Aktif</font>' : '<font color="green">Aktif</font>'; $no++; }} <a href="{{ action('MasterKaryawanController@changeStatus', $karyawan->idkar) }}" data-toggle="tooltip" data-placement="left" title="Change Status?">{{ $karyawan->status == 'N' ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>' }}</a>
                                <!--<br>-->
                                <!--<a href="{{ action('MasterKaryawanController@changeStatus', $karyawan->idkar) }}" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Change Status?">{{ $karyawan->status == 'N' ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>' }}</a>-->
                            </td>
                            <td class="text-center" width="5%">
                                <a href="{{ action('MasterKaryawanController@edit', $karyawan->idkar) }}" class="btn btn-info" data-toggle="tooltip" data-placement="left" title="Edit Data?"><i class="fa fa-edit"></i></a> <br><br>
                                <a href="{{ action('MasterKaryawanController@usermatrix', $karyawan->idkar) }}" class="btn btn-info" data-toggle="tooltip" data-placement="center" title="User Matrix?"><i class="fa fa-user"></i></a> <br><br>
                                <a href="{{ action('MasterKaryawanController@destroy', $karyawan->idkar) }}" class="btn btn-danger delete" data-toggle="tooltip" data-placement="right" title="Hapus Data?"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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

        $("#ttl").datepicker({
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



