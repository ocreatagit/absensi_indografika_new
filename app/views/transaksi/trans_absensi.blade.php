@extends('template.master')

@section('title')
<title>ABSENSI - Input Data</title>
@stop

@section('header')
<h1 class="page-header">Input Data
    <small>Absensi</small>
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
                <div>
                    <h3 class="page-header"><i class="fa fa-info-circle"></i> Absensi Karyawan </h3>
                    <table class="table table-bordered table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php $no = 1; ?>
                            @foreach($karyawans as $kar)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $kar->nama }}</td>
                                <td>
                                    <a href="{{ action('TransaksiAbsensiController@show', $kar->idkar) }}" class="btn btn-info" data-toggle="tooltip" data-placement="right" title="Edit Data?"><i class="fa fa-edit"></i></a>
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



