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
            <div class="panel-heading">
                <a href="{{ action('TransaksiGajiController@index') }}" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title=""><i class="fa fa-backward"></i> Kembali</a>
            </div>
            <div class="panel-body">
                <div class="col-sm-12">
                    <table class="table table-bordered table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th class="text-left">No</th>
                                <th class="text-left">Foto</th>
                                <th class="text-left">Nama</th>
                                <th class="text-left">Username</th>                                
                                <th class="text-left">Omzet</th>
                                <th class="text-left">Tgl Pembayaran <br> Gaji Terakhir </th>
                                <th class="text-left">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="text-left">
                            <?php $no = 1; ?>
                            @foreach($karyawans as $karyawan)
                            <tr>
                                <td>{{ $no }}</td>
                                <td><a href="{{ url("uploads/".$karyawan->pic) }}" data-lightbox="roadtrip"> {{ $karyawan->pic != "" ? HTML::image('uploads/'.$karyawan->pic, $karyawan->nama, array('class' => 'thumbnail', "width" => 100)) : HTML::image('uploads/no_image.png', "No Image", array('class' => 'thumbnail', "width" => 100)) }} </a> </td>
                                <td>{{ $karyawan->nama }}</td>
                                <td>{{ $karyawan->usernm }}</td>
                                <td width="">
                                </td>
                                <td>{{ strftime("%d-%b-%Y", strtotime($karyawan->tglgj)) }}</td>
                                <td class="text-center" width="15%">
                                    <a href="{{ action('TransaksiGajiController@create', $karyawan->idkar) }}" class="btn btn-info" data-toggle="tooltip" data-placement="left" title="Edit Data?">Bayar Gaji</a>
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
    
</script> 
@stop



