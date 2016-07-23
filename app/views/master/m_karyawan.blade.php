@extends('template.master')

@section('title')
<title>ABSENSI - Master Karyawan</title>
@stop

@section('header')
<h1 class="page-header">Master Data
    <small>KARYAWAN</small>
</h1>
@stop

@section('main')
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">Informasi Karyawan</div>
        <div class="panel-body">
            <form class="form-horizontal" action="{{ $action }}" method="POST" id="form1" enctype="multipart/form-data">
                <div class="col-sm-6">
                    <h2 class="page-header" style="margin-top: 0px;">Informasi Pribadi</h2>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nama</label>
                        <div class="col-sm-6 input-group ">
                            <input type="text" class="form-control" value="{{ Input::old('nama', $karyawan["nama"]) }}" name="nama">
                        </div>
                        @if($errors->first('nama'))
                        <div class="col-sm-6 col-sm-offset-4 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('nama') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Email</label>
                        <div class="col-sm-6 input-group ">
                            <input type="text" class="form-control" value="{{ Input::old('email', $karyawan["email"]) }}" name="email">
                        </div>
                        @if($errors->first('email'))
                        <div class="col-sm-6 col-sm-offset-4 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('email') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">No Reg. Karyawan</label>
                        <div class="col-sm-6 input-group ">
                            <input type="text" class="form-control" id="usernm" value="{{ Input::old('usernm', $karyawan["usernm"]) }}" name="usernm" onkeyup="setPassword(this)" onmouseup="setPassword(this)" onmouseout="setPassword(this)" onmousedown="setPassword(this)">
                        </div>
                        @if($errors->first('usernm'))
                        <div class="col-sm-6 col-sm-offset-4 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('usernm') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Password</label>
                        <div class="col-sm-6 input-group ">
                            <input type="password" class="form-control" id="passwd" value="{{ Input::old('passwd') }}" name="passwd">
                        </div>
                        @if($errors->first('passwd'))
                        <div class="col-sm-6 col-sm-offset-4 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('passwd') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Ulangi Password</label>
                        <div class="col-sm-6 input-group ">
                            <input type="password" class="form-control" id="passwd2" name="passwd2" value="{{ Input::old('passwd2') }}">
                        </div>
                        @if($errors->first('passwd2'))
                        <div class="col-sm-6 col-sm-offset-4 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('passwd2') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Tipe User</label>
                        <div class="col-sm-6 input-group ">
                            <select class="form-control" name="jnsusr">
                                <option value="0" {{ $karyawan["jnsusr"] == 0 ? "selected" : "" }}>Super Admin</option>
                                <option value="1" {{ $karyawan["jnsusr"] == 1 ? "selected" : "" }}>Admin</option>
                                <option value="2" {{ $karyawan["jnsusr"] == 2 ? "selected" : "" }}>Karyawan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Gender</label>
                        <div class="col-sm-6">
                            <div class="col-sm-10 input-group">
                                <label class="radio-inline">
                                    <input type="radio" name="gndr" id="inlineRadio1" value="L" checked=""> Laki-Laki
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gndr" id="inlineRadio2" value="P"> Perempuan
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Tanggal Lahir</label>
                        <div class="col-sm-6 input-group ">
                            <input id="ttl" type="text" class="form-control" value="{{ Input::old('ttl', strftime("%d-%m-%Y", strtotime($karyawan["ttl"] == '' ? date('d-m-1988') : $karyawan["ttl"]))) }}" name="ttl">
                        </div>
                        @if($errors->first('ttl'))
                        <div class="col-sm-6 col-sm-offset-4 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('ttl') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Tanggal Aktif</label>
                        <div class="col-sm-6 input-group ">
                            <input id="tglaktif" type="text" class="form-control" value="{{ Input::old('tglaktif', strftime("%d-%m-%Y", strtotime($karyawan["tglaktif"] == '' ? date('d-m-Y') : $karyawan["tglaktif"]))) }}" name="tglaktif">
                        </div>
                        @if($errors->first('tglaktif'))
                        <div class="col-sm-6 col-sm-offset-4 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('tglaktif') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">No Telepon</label>
                        <div class="col-sm-6 input-group ">
                            <input id="notelp" type="text" class="form-control" value="{{ Input::old('notelp', $karyawan["notelp"]) }}" name="notelp">
                        </div>
                        @if($errors->first('notelp'))
                        <div class="col-sm-6 col-sm-offset-4 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('notelp') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">No Rekening 1 </label>
                        <div class="col-sm-6 input-group ">
                            <input id="ttl" type="text" class="form-control" value="{{ Input::old('norek1', $karyawan["norek1"]) }}" name="norek1">
                        </div>
                        @if($errors->first('norek1'))
                        <div class="col-sm-6 col-sm-offset-4 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('norek1') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">No Rekening 2 </label>
                        <div class="col-sm-6 input-group ">
                            <input id="ttl" type="text" class="form-control" value="{{ Input::old('norek2', $karyawan["norek2"]) }}" name="norek2">
                        </div>
                        @if($errors->first('norek2'))
                        <div class="col-sm-6 col-sm-offset-4 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('norek2') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Alamat</label>
                        <div class="col-sm-6 input-group ">
                            <textarea style="width: 83.333%" name="addr1" class="form-control">{{ Input::old('addr1', $karyawan["addr1"]) }}</textarea>
                        </div>
                        @if($errors->first('addr1'))
                        <div class="col-sm-6 col-sm-offset-4 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('addr1') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Komisi Individu</label>
                        <div class="col-sm-3 input-group">                            
                            <div class="input-group">
                                <input type="number" name="kmindv" class="form-control text-right" value="{{ Input::old('kmindv', $karyawan["kmindv"] == null ? 0 : $karyawan["kmindv"]) }}"/>
                                <div class="input-group-addon">%</div>
                            </div>
                        </div>
                        @if($errors->first('kmindv'))
                        <div class="col-sm-6 col-sm-offset-4 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('kmindv') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Komisi Tim</label>
                        <div class="col-sm-3 input-group">                            
                            <div class="input-group">
                                <input type="number" name="kmtim" class="form-control text-right" value="{{ Input::old('kmtim', $karyawan["kmtim"] == null ? 0 : $karyawan["kmtim"]) }}"/>
                                <div class="input-group-addon">%</div>
                            </div>
                        </div>
                        @if($errors->first('kmtim'))
                        <div class="col-sm-6 col-sm-offset-4 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('kmtim') }}</div>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <h2 class="page-header" style="margin-top: 0px;">Informasi Gaji</h2>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Jabatan</label>
                        <div class="col-sm-6 input-group ">
                            <select class="form-control" name="idjb">
                                @foreach($jabatans as $jabatan)
                                <option value="{{ $jabatan->idjb }}" {{ isset($karyawan) == true ? ($karyawan->idjb == $jabatan->idjb ? "selected" : "") : "" }}>{{ $jabatan->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Jam Masuk - Jam Pulang</label>
                        <div class="col-sm-6 input-group ">
                            <select class="form-control" name="idjk1">
                                @foreach($jamkerjas as $jamkerja)
                                <option value="{{ $jamkerja->idjk }}" {{ isset($karyawan) == true ? ($jamkerja1->idjk == $jamkerja->idjk ? "selected" : "") : "" }}><?php echo strftime("%H:%M", strtotime($jamkerja->jmmsk)) ?> - <?php echo strftime("%H:%M", strtotime($jamkerja->jmklr)) ?></option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Jam Masuk - Jam Pulang <font color="green">(Alternatif 2)</font></label>
                        <div class="col-sm-6 input-group ">
                            <select class="form-control" name="idjk_alt1">
                                @foreach($jamkerjas as $jamkerja)
                                <option value="{{ $jamkerja->idjk }}" {{ isset($karyawan) == true ? ($jamkerja_alt1->idjk == $jamkerja->idjk ? "selected" : "") : "" }}><?php echo strftime("%H:%M", strtotime($jamkerja->jmmsk)) ?> - <?php echo strftime("%H:%M", strtotime($jamkerja->jmklr)) ?></option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Jam Masuk - Jam Pulang <font color="green">(Alternatif 3)</font></label>
                        <div class="col-sm-6 input-group ">
                            <select class="form-control" name="idjk_alt2">
                                @foreach($jamkerjas as $jamkerja)
                                <option value="{{ $jamkerja->idjk }}" {{ isset($karyawan) == true ? ($jamkerja_alt2->idjk == $jamkerja->idjk ? "selected" : "") : "" }}><?php echo strftime("%H:%M", strtotime($jamkerja->jmmsk)) ?> - <?php echo strftime("%H:%M", strtotime($jamkerja->jmklr)) ?></option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Jam Istirahat</label>
                        <div class="col-sm-6 input-group ">
                            <select class="form-control" name="idjk2">
                                @foreach($jamistirahats as $jamistirahat)
                                <option value="{{ $jamistirahat->idjk }}" {{ isset($karyawan) == true ? ($jamkerja2->idjk == $jamistirahat->idjk ? "selected" : "") : "" }}><?php echo strftime("%H:%M", strtotime($jamistirahat->jmmsk)) ?> - <?php echo strftime("%H:%M", strtotime($jamistirahat->jmklr)) ?></option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <h2 class="page-header" style="margin-top: 0px;">Foto Karyawan</h2>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Foto</label>
                        <div class="col-sm-6 input-group ">
                            <input type="file" name="foto" class=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Foto Lama</label>
                        <div class="col-sm-6 input-group ">
                            <?php if (isset($karyawan)) { ?>
                                <a href="{{ url("uploads/".$karyawan->pic) }}" data-lightbox="roadtrip"> {{ HTML::image('uploads/'.$karyawan->pic, $karyawan->nama, array('class' => 'thumbnail', "width" => 350)) }} </a>
                            <?php } else {
                                ?>
                                {{ HTML::image('uploads/no_image.png', "No Image", array('class' => 'thumbnail', "width" => 350)) }}
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12" style="margin-top: 2%; margin-bottom: 1.5%">
                    <!--<a class="btn btn-info btn-block" id="next" onclick="goToDiv('next','infGaji')"><i class="fa fa-arrow-down"></i> Tambah Informasi Gaji <i class="fa fa-arrow-down"></i></a>-->
                    <button class="btn btn-info btn-block" type="submit"><h3 style="margin-top: 0px; margin-bottom: 0px;"> <i class="fa fa-save"></i> {{ !isset($karyawan) ? 'Tambah Gaji' : 'Ubah Data Karyawan' }} </h3> </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php if (isset($karyawan)) { ?>
    <div class="row">
        <div class="panel panel-default" id="infGaji">
            <div class="panel-heading">Informasi Gaji</div>
            <div class="panel-body">
                <form class="form-horizontal" action="{{ action("MasterKaryawanController@saveKaryawanGaji", array($idkaryawan)) }}" method="POST">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Jenis Gaji</label>
                        <div class="col-sm-3 input-group ">
                            <select class="form-control" name="idgj">
                                @foreach($gajis as $gaji)
                                <option value="{{ $gaji->idgj }}">{{ $gaji->jenis }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="idkaryawan" value="{{ $idkaryawan }}"/>
                        </div>
                        @if($errors->first('idgj'))
                        <div class="col-sm-3 col-sm-offset-2 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('nilgj') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nominal Gaji</label>
                        <div class="col-sm-3 input-group ">
                            <input type="text" class="form-control" value="" name="nilgj">                                    
                        </div>
                        @if($errors->first('nilgj'))
                        <div class="col-sm-3 col-sm-offset-2 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('nilgj') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                            <div class="col-sm-8 input-group">
                                <button class="btn btn-success"> <i class=" glyphicon glyphicon-floppy-disk"></i> Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="col-sm-6">
                    <table class="table table-bordered table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th class="text-left">Jenis Gaji</th>
                                <th class="text-left">Nominal Gaji</th>
                                <th class="text-left">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach($karyawan->mg02 as $row)
                            <tr>
                                <td>{{ $row->mg01->jenis }}</td>
                                <td>Rp.{{ number_format($row->nilgj,0, ',','.') }},-</td>
                                <td>
                                    <a href="{{ action('MasterKaryawanController@deleteKaryawanGaji', [$row->id]) }}" class="btn btn-danger delete" data-toggle="tooltip" data-placement="right" title="Hapus Data?"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="panel panel-default" id="infGaji">
            <div class="panel-heading">Informasi Referral</div>
            <div class="panel-body">
                <form class="form-horizontal" action="{{ action("MasterKaryawanController@saveReferral") }}" method="POST">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nama Karyawan</label>
                        <div class="col-sm-3 input-group ">
                            <select class="form-control" name="mk01_id_referral">
                                <?php if (count($karyawanalls) > 0) { ?>
                                    @foreach($karyawanalls as $karyawanall)
                                    <option value="{{ $karyawanall->idkar }}">{{ $karyawanall->nama }}</option>
                                    @endforeach
                                <?php } else { ?>
                                    <option value="">Tidak Terdapat Karyawan</option>
                                    <?php
                                }
                                ?>
                            </select>
                            <input type="hidden" name="idkaryawan" value="{{ $idkaryawan }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Leader</label>
                        <div class="col-sm-3 input-group">
                            <label class="radio-inline">
                                <input type="radio" name="leader" id="inlineRadio1" value="Yes"> Yes
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="leader" id="inlineRadio2" value="No" checked=""> No
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                            <div class="col-sm-8 input-group">
                                <?php if (count($karyawanalls) > 0) { ?>
                                    <button class="btn btn-success"> <i class=" glyphicon glyphicon-floppy-disk"></i> Simpan</button>
                                <?php } else { ?>
                                    <button class="btn btn-danger" disabled=""> <i class="glyphicon glyphicon-floppy-disk"></i> Simpan</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="col-sm-6">
                    <table class="table table-bordered table-hover" id="datatable2">
                        <thead>
                            <tr>
                                <th class="text-left">No</th>
                                <th class="text-left">Nama Referral</th>
                                <th class="text-left">Leader</th>
                                <th class="text-left">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php $no = 1; ?>
                            @foreach($referrals as $referral)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $referral->child_name }}</td>
                                <td>{{ $referral->flglead }}</td>
                                <td>
                                    <a href="{{ action('MasterKaryawanController@deleteReferral', [$referral->id, $referral->mk01_id_parent]) }}" class="btn btn-danger delete" data-toggle="tooltip" data-placement="right" title="Hapus Referral?"><i class="fa fa-trash"></i></a>
                                        <?php $no++; ?>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
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

        $('#datatable2').DataTable();

        $("#tglaktif").datepicker({
            inline: true,
            dateFormat: "dd-mm-yy",
            changeYear: true,
            changeMonth: true
        });

        $("#ttl").datepicker({
            inline: true,
            dateFormat: "dd-mm-yy",
            changeYear: true,
            changeMonth: true
        });
    });

    function goToDiv(button, div) {
        $("#" + button).click(function () {
            $('html,body').animate({
                scrollTop: $("#" + div).offset().top},
            'slow');
        });
    }
    
    function setPassword(noreg) {
        $("#passwd").val(noreg.value);
        $("#passwd2").val(noreg.value);
    }
</script> 
@stop



