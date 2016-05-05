@extends('myindografika.master')

@section('title')
<title>ABSENSI - My Indografika</title>
@stop

@section('header')
<h1 class="page-header">My Account
</h1>
@stop

@section('main')
<div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-cogs"></i> My Account</div>
    @if(Session::has('mk01_success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="fa fa-info-circle"></i> {{ $mk01_success }}
    </div>    
    @endif
    <div class="panel-body">
        <form class="form-horizontal" action="{{ action("MasterKaryawanController@changepassword") }}" method="POST">
            <div class="form-group">
                <label class="col-sm-4 control-label">Nama</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control siku" value="{{ Input::old('nama', $karyawan["nama"]) }}" name="nama" disabled="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Email</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control siku" value="{{ Input::old('email', $karyawan["email"]) }}" name="email" disabled="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">No Reg. Karyawan</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control siku" value="{{ Input::old('usernm', $karyawan["usernm"]) }}" name="usernm" disabled="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Password</label>
                <div class="col-sm-4">
                    <input id="passwd" type="password" class="form-control siku" value="{{ Input::old('passwd', $karyawan->passwd) }}" name="passwd">
                </div>
                <div class="col-sm-2">
                    <button id="show_password" type="button" class="btn btn-primary siku">Show Password</button>
                </div>
                @if($errors->first('passwd'))
                <div class="col-sm-4 col-sm-offset-4 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('passwd') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Ulangi Password</label>
                <div class="col-sm-4">
                    <input id="passwd2" type="password" class="form-control siku" name="passwd2" value="{{ Input::old('passwd2', $karyawan->passwd) }}">
                </div>
                @if($errors->first('passwd2'))
                <div class="col-sm-4 col-sm-offset-4 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('passwd2') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Gender</label>
                <div class="col-sm-6">
                    <div class="col-sm-10 input-group">
                        <label class="radio-inline">
                            <input type="radio" name="gndr" id="inlineRadio1" value="L" <?php echo $karyawan->gndr == "L" ? 'checked' : '' ?>> Laki-Laki
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="gndr" id="inlineRadio2" value="P" <?php echo $karyawan->gndr == "Y" ? 'checked' : ''; ?>> Perempuan
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Tanggal Lahir</label>
                <div class="col-sm-6">
                    <input id="ttl" type="text" class="form-control siku" value="{{ Input::old('ttl', strftime("%d-%m-%Y", strtotime($karyawan["ttl"] == '' ? date('d-m-1988') : $karyawan["ttl"]))) }}" name="ttl" disabled="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">No Telepon</label>
                <div class="col-sm-6">
                    <input id="notelp" type="text" class="form-control siku" value="{{ Input::old('notelp', $karyawan["notelp"]) }}" name="notelp" disabled="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">No Rekening 1 </label>
                <div class="col-sm-6">
                    <input id="ttl" type="text" class="form-control siku" value="{{ Input::old('norek1', $karyawan["norek1"]) }}" name="norek1" disabled="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">No Rekening 2 </label>
                <div class="col-sm-6">
                    <input id="ttl" type="text" class="form-control siku" value="{{ Input::old('norek2', $karyawan["norek2"]) }}" name="norek2" disabled="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Alamat</label>
                <div class="col-sm-6">
                    <textarea style="width: 83.333%" name="addr1" class="form-control siku" disabled="">{{ Input::old('addr1', $karyawan["addr1"]) }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label"></label>
                <div class="col-sm-6">
                    <button type="submit" class="btn btn-primary siku" value="submit" name="btn_submit"><i class="fa fa-save"></i> Save Change</button>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $("#show_password").click(function () {
            var type = $("#passwd").attr("type");
            var type2 = $("#passwd2").attr("type");
            if (type == "password") {
                $("#passwd").attr("type", "text");
            } else {
                $("#passwd").attr("type", "password");
            }
            if (type2 == "password") {
                $("#passwd2").attr("type", "text");
            } else {
                $("#passwd2").attr("type", "password");
            }
        });
    });
</script> 
@stop



