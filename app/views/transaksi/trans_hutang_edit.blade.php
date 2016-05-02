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
            <div class="panel-heading">
                <a href="{{ action('TransaksiHutangController@index') }}" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title=""><i class="fa fa-backward"></i> Kembali</a>
            </div>
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
                    <form class="form-horizontal" action="{{ action("TransaksiHutangController@update", [$hutang[0]->idhut]) }}" method="POST">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nama Karyawan</label>
                                <div class="col-sm-6">
                                    <input type="text" disabled="" value="{{ $hutang[0]->nama }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Jenis Pinjaman</label>
                                <div class="col-sm-3">
                                    <input type="text" disabled="" value="{{ $hutang[0]->jenhut }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Angsuran</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="jmlang" value="{{ Input::old('jmlang', $hutang[0]->jmlang) }}" {{ $hutang[0]->jenhut == 'Kas Bon' ? 'disabled' : '' }}/>
                                    @if($errors->first('jmlang'))
                                    <div class="col-sm-12 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('jmlang') }}</div>
                                    @endif
                                </div>                                

                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Jumlah Pinjaman</label>
                                <div class="col-sm-6">                                        
                                    <input type="text" class="form-control" name="nilhut" value="{{ Input::old('nilhut', $hutang[0]->nilhut) }}"/>
                                    @if($errors->first('nilhut'))
                                    <div class="col-sm-12 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('nilhut') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"></label>
                                <div class="col-sm-6">                                        
                                    <button class="btn btn-info"><i class="fa fa-save"></i> Ubah Data</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <img src="<?php echo url("/uploads")."/".$hutang[0]->pic ?>" width="120" height="150">
                        </div>
                    </form>
                </div>
                <div>
                    <h3 class="page-header"><i class="fa fa-info-circle"></i> Status Pinjaman Karyawan</h3>
                    <table class="table table-bordered table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th class="text-center">Jumlah Angsuran</th>
                                <th class="text-center">Tanggal Angsur</th>
                                <th class="text-center">Nilai Angsuran</th>
                                <th class="text-center">Status Bayar</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php $no = 1; ?>
                            @foreach($hutangs as $hutang)
                            <tr>
                                <td> {{ $no }} </td>
                                <td> {{ strftime("%d-%b-%Y", strtotime($hutang->tglph)) }}</td>
                                <td>Rp.<?php echo number_format($hutang->nilph, 0, ',', '.') ?>,-</td>
                                <td>{{ $hutang->status }}</td>
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



