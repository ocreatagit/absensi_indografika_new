@extends('template.master')

@section('title')
<title>ABSENSI - Input Data</title>
@stop

@section('header')
<h1 class="page-header">Input Data
    <small>Gaji</small>
</h1>
@stop

@section('main')
<div class="row">
    <div class="col-sm-12" style="">
        <div class="panel panel-default">
            @if(Session::has('tg01_success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <i class="fa fa-info-circle"></i> {{ $tg01_success }}
            </div>    
            @endif

            @if(Session::has('tg01_danger'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <i class="fa fa-info-circle"></i> {{ $tg01_danger }}
            </div>    
            @endif
            <form action="{{ action("TransaksiGajiController@saveall") }}" method="POST">
                <div class="panel-heading">
                    <a href="{{ action('TransaksiGajiController@index') }}" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title=""><i class="fa fa-backward"></i> Kembali</a>
                    <div class="pull-right">
                        <button class="btn btn-success siku" type="submit" value="bayar" name="btn_submit" data-toggle="tooltip" data-placement="left" title="Buat Transaksi yang Dipilih?"><i class="fa fa-check-circle"></i></button>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="lbl_selected" class="alert alert-info">
                        <b><span id="text_selected"></span> </b>
                    </div>

                    <div class="col-sm-12">
                        <div style="height: 400px; overflow-y: scroll;">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr style="">
                                        <th class="text-left">No</th>
                                        <th class="text-left">Foto</th>
                                        <th class="text-left">Nama</th>
                                        <th class="text-left">Username</th>
                                        <th class="text-left">Tgl Pembayaran <br> Gaji Terakhir </th>
                                        <th class="text-center">Opsi</th>
                                        <th class="text-center">Pilih <input type="checkbox" name="chk" id="chk"/> </th>
                                    </tr>  
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    @foreach($karyawans as $karyawan)
                                    <?php if ($karyawan->jnsusr != 0) { ?>
                                        <tr>
                                            <td style="width: 5%;">{{ $no }}</td>
                                            <td style="width: 10%;">
                                                <a href="{{ url("uploads/".$karyawan->pic) }}" data-lightbox="roadtrip"> {{ $karyawan->pic != "" ? HTML::image('uploads/'.$karyawan->pic, $karyawan->nama, array('class' => 'thumbnail', "width" => 100)) : HTML::image('uploads/no_image.png', "No Image", array('class' => 'thumbnail', "width" => 100)) }} 
                                                </a> </td>
                                            <td>{{ $karyawan->nama }}</td>
                                            <td>{{ $karyawan->usernm }}</td>
                                            <td>{{ strftime("%d-%b-%Y", strtotime($karyawan->tglgj)) }}</td>
                                            <td class="text-center">
                                                <a href="{{ action('TransaksiGajiController@create', $karyawan->idkar) }}" class="btn btn-info" data-toggle="tooltip" data-placement="left" title="Edit Data?">Bayar Gaji</a>
                                            </td>
                                            <td class="text-center">
                                                <?php if ((int) date("m") == (int) strftime("%m", strtotime($karyawan->tglgj))) {
                                                    ?>
                                                    <input type="checkbox" name="" class="siku" disabled=""/>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <input type="checkbox" onchange="getSelectedItem()" name="chkitem[]" class="chkitem siku" value="{{ $karyawan->idkar }}"/>
                                                <?php }
                                                ?>
                                            </td>
                                            <?php $no++; ?>
                                        </tr>
                                    <?php } ?>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('script')
<script type="text/javascript">
    $('#datatable').DataTable({
        "paging": true, // next page
        "ordering": true, // order by at header 
        "info": false
    });
    
    $("#lbl_selected").hide();

    $("#chk").change(function () {
        if (this.checked) {
//            $('input:checkbox[class=chkitem]:checked').each(function () {
//                console.log("1");
//            });
            $(".chkitem").prop('checked', true);
            $("#lbl_selected").show();
            $("#text_selected").html($(".chkitem:checked").length + " Item Selected");
        } else {
            $(".chkitem").prop('checked', false);
            $("#lbl_selected").hide();
        }
    });

    function getSelectedItem() {
        $("#lbl_selected").show();
        $("#text_selected").html($(".chkitem:checked").length + " Item Selected");
    }
</script>
@stop



