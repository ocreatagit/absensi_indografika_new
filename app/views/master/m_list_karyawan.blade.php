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
    <div class="col-sm-12" style="">
        <div class="panel panel-default siku">
            <div class="panel-heading"></div>
            @if(Session::has('mk01_success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <i class="fa fa-info-circle"></i> {{ $mk01_success }}
            </div>    
            @endif
            <div class="panel-body">
                <h3 class="page-header"><i class="fa fa-info-circle"></i> Master Karyawan</h3>
                <?php if (Session::get("user.tipe") == 0) { ?>
                    <a id="tambah" href="{{ action('MasterKaryawanController@create') }}" class="btn btn-primary siku"><i class="fa fa-plus-square"></i> Tambah Karyawan</a>
                <?php } ?>
            </div>
            <div class="panel-body">
                <div class="row"> 
                    <?php foreach ($karyawans as $karyawan) { ?>
                        <div class="col-sm-3">
                            <div class="panel panel-default siku">
                                <div class="panel-heading">
                                    {{ $karyawan->nama }}
                                </div>
                                <div class="panel-body">
                                    <div class="text-center" style="text-align: center">
                                        <a href="{{ url("uploads/".$karyawan->pic) }}" data-lightbox="roadtrip"> {{ $karyawan->pic != "" ? HTML::image('uploads/'.$karyawan->pic, $karyawan->nama, array('class' => 'thumbnail siku text-center', "width" => 200, "height" => 200)) : HTML::image('uploads/no_image.png', "No Image", array('class' => 'thumbnail siku text-center', "width" => 180)) }} </a> 
                                    </div>
                                    <div class="text-left">
                                        <p><strong>No. Absen : </strong>{{ $karyawan->idkar }}</p>
                                        <p><strong>Status : </strong>{{ $karyawan->status == 'N' ? '<font color="red">Tidak Aktif</font>' : '<font color="green">Aktif</font>'; }}</p>
                                        <p><strong>No. Karyawan : </strong>{{ $karyawan->usernm }}</p>
                                        <p><strong>Jabatan : </strong>{{ $karyawan->mj01->nama }}</p>    
                                    </div>
                                    <div class="text-center">
                                        <?php if ($karyawan->jnsusr == 0) {
                                            ?>
                                            <a href="{{ action('MasterKaryawanController@edit', $karyawan->idkar) }}" class="btn btn-info disabled siku" data-toggle="tooltip" data-placement="left" title="Edit Data?"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?php
                                        } else {
                                            ?>
                                            <a href="{{ action('MasterKaryawanController@edit', $karyawan->idkar) }}" class="btn btn-info siku" data-toggle="tooltip" data-placement="left" title="Edit Data?"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?php }
                                        ?>
                                        <a href="#" class="btn btn-info siku <?php echo (Session::get("user.tipe") == 0) ? "" : "disabled"; ?>" data-toggle="modal" data-placement="center" title="User Matrix?" data-target="#myModal" onclick="UserMatrixModal(<?php echo $karyawan->idkar ?>,'{{ $karyawan->nama }}')"><i class="fa fa-user"></i></a>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="{{ action('MasterKaryawanController@changeStatus', $karyawan->idkar) }}" class="btn btn-default siku" data-toggle="tooltip" data-placement="left" title="Change Status?">{{ $karyawan->status == 'N' ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>' }}</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">USER MATRIX - <span id="nama_kar"></span></h4>
                </div>
                <div class="modal-body">

                    <form id="formUM" action="<?php echo action("MasterKaryawanController@usermatrixsave") ?>" method="POST" class="form-horizontal">
                        <div class="form-group">        
                            @foreach ($usermatrixs as $um)
                            <div class="checkbox col-md-4">
                                <label><input type="checkbox" class="jsUM" id="matrix{{ $um->idmnu }}" name="matrix{{ $um->idmnu }}" value="{{ $um->idmnu }}" > <small><font color="blue">({{ $um->klpk_menu }})</font></small><br> {{ $um->nama }}</label>
                            </div>
                            @endforeach
                        </div>
                        <div class="form-group">
                            &nbsp;&nbsp;&nbsp;{{ Form::submit('Simpan', array('class'=>'btn btn-primary btn-large center siku')) }}
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <!-- END MODAL -->


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
            function UserMatrixModal(id, nama){
            $('.jsUM').prop('checked', false);
                    $('#nama_kar').html(nama);
                    $.post("<?php echo action("MasterKaryawanController@getUserMatrixKar") ?>",
                    { idkar: id },
                            function (data, status) {
                            for (var i = 0; i < data.length; i++){
                            $('#matrix' + data[i].mm01_id).prop('checked', true);
                            }
                            }, "json");
                    $('#formUM').attr('action', "http://localhost/absensi_indografika/usermatrix/" + id);
            }
</script> 
@stop



