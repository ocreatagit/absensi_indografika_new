@extends('template.master')

@section('title')
<title>ABSENSI - My Indografika</title>
@stop

@section('header')
<h1 class="page-header">Laporan Bulanan Karyawan</h1>
@stop

@section('main')
<div class="row">
    <div class="col-sm-12" style="">
        <div class="panel panel-default siku">
            <div class="panel-heading">Laporan Bulanan Karyawan</div>
            <div class="panel-body">
                <h3 class="page-header"><i class="fa fa-info-circle"></i> Laporan Bulanan Karyawan</h3>
            </div>
            <div class="panel-body">
                @if(Session::has('filter'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <i class="fa fa-info-circle"></i> {{ $filter }}
                </div>    
                @endif
                <div class="row">
                    <div class="col-lg-6">
                        <div class="panel panel-primary siku">
                            <div class="panel-heading siku">Filter Laporan</div>
                            <div class="panel-body">
                                <form class="form-horizontal" action="{{ action("LaporanAdminController@laporan_karyawan_query") }}" method="POST">
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label">Bulan</label>
                                        <div class="col-sm-3">
                                            <select name="bln_start" class="form-control siku" style="width: 110%">
                                                <option value="01" <?php if (date("m") == "01") echo "selected" ?>>January</option>
                                                <option value="02" <?php if (date("m") == "02") echo "selected" ?>>February</option>
                                                <option value="03" <?php if (date("m") == "03") echo "selected" ?>>March</option>
                                                <option value="04" <?php if (date("m") == "04") echo "selected" ?>>April</option>
                                                <option value="05" <?php if (date("m") == "05") echo "selected" ?>>May</option>
                                                <option value="06" <?php if (date("m") == "06") echo "selected" ?>>June</option>
                                                <option value="07" <?php if (date("m") == "07") echo "selected" ?>>July</option>
                                                <option value="08" <?php if (date("m") == "08") echo "selected" ?>>August</option>
                                                <option value="09" <?php if (date("m") == "09") echo "selected" ?>>September</option>
                                                <option value="10" <?php if (date("m") == "10") echo "selected" ?>>October</option>
                                                <option value="11" <?php if (date("m") == "11") echo "selected" ?>>November</option>
                                                <option value="12" <?php if (date("m") == "12") echo "selected" ?>>December</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-2" style="margin-left: -20px;">
                                            <input class="form-control siku" name="thn_start" value="{{ date("Y") }}" required=""/>
                                        </div>
                                        <label class="col-sm-1 control-label">Sampai</label>
                                        <div class="col-sm-3" style="margin-left: 10px;">
                                            <select name="bln_end" class="form-control siku" style="width: 110%">
                                                <option value="01" <?php if (date("m") == "01") echo "selected" ?>>January</option>
                                                <option value="02" <?php if (date("m") == "02") echo "selected" ?>>February</option>
                                                <option value="03" <?php if (date("m") == "03") echo "selected" ?>>March</option>
                                                <option value="04" <?php if (date("m") == "04") echo "selected" ?>>April</option>
                                                <option value="05" <?php if (date("m") == "05") echo "selected" ?>>May</option>
                                                <option value="06" <?php if (date("m") == "06") echo "selected" ?>>June</option>
                                                <option value="07" <?php if (date("m") == "07") echo "selected" ?>>July</option>
                                                <option value="08" <?php if (date("m") == "08") echo "selected" ?>>August</option>
                                                <option value="09" <?php if (date("m") == "09") echo "selected" ?>>September</option>
                                                <option value="10" <?php if (date("m") == "10") echo "selected" ?>>October</option>
                                                <option value="11" <?php if (date("m") == "11") echo "selected" ?>>November</option>
                                                <option value="12" <?php if (date("m") == "12") echo "selected" ?>>December</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-2" style="margin-left: -20px;">
                                            <input class="form-control siku" name="thn_end" value="{{ date("Y") }}" required=""/>
                                        </div>
                                    </div>                            
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label"></label>
                                        <div class="col-sm-2">                                        
                                            <button type="submit" class="btn btn-primary siku" name="btn_filter" value="btn_filter"><i class="fa fa-search"></i> Filter</button>
                                        </div>
                                        <div class="col-sm-4">                                        
                                            <button type="submit" class="btn btn-success siku" name="btn_export" value="btn_export"><i class="fa fa-book"></i> Export to Excel</button>
                                        </div>
                                    </div>                               
                                </form>
                            </div>
                        </div>
                    </div> 
                    <hr>
                    <table class="table table-bordered table-hover table-striped" id="">
                        <thead>
                            <tr>
                                <th class="text-center"></th>
                                <th class="text-right">Pembayaran</th>
                                <?php
                                if (in_array(26, $usermatrik)) {
                                    if (Session::get("user.tipe") == 0) {
                                        ?>
                                        <th class="text-right">No Rekening 1</th>
                                        <th class="text-right">Gaji Kotor</th>
                                        <th class="text-right">Gaji Bersih</th>
                                        <?php
                                    }
                                }
                                ?>
                                <th class="text-right">Msk</th>
                                <th class="text-right">Lbr</th>
                                <th class="text-right">Aph</th>
                                <th class="text-right">Cuti</th>
                                <th class="text-right">Telat/Menit</th>
                                <th class="text-right">Kasbon</th>
                                <th class="text-right">Hutang</th>
                                <th class="text-right">Omzet</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <tr>
                                <td colspan="10" class="cell">&nbsp;</td>
                            </tr>
                            <?php
                            $totalOmzet = 0;
                            $totalGajiBersih = 0;
                            $totalGajiKotor = 0;
                            ?>
                            @foreach($laporans as $laporan)
                            @if($laporan['jnsusr'] != 0)
                            <tr>
                                <td align="left">{{ $laporan["nama"] }}</td> 
                                <td align="left">{{ $laporan["bln_pembayaran"] }}</td>
                                <?php
                                if (in_array(26, $usermatrik)) {
                                    if (Session::get("user.tipe") == 0) {
                                        ?>
                                        <td align="right">{{ $laporan["norek1"] }}</td>
                                        <td align="right">Rp.{{ number_format($laporan["gajibersih"], 0, ",", ".") }},-</td>
                                        <td align="right">Rp.{{ number_format($laporan["gajikotor"], 0, ",", ".") }},-</td>
                                        <?php
                                    }
                                }
                                ?>
                                <td align="right">{{ $laporan["msk"] }}</td>
                                <td align="right">
                                    <?php
                                    echo floor(($laporan["lbr"] / 3600));
                                    ?>
                                </td>
                                <td align="right">{{ $laporan["aph"] }}</td>
                                <td align="right">{{ $laporan["cuti"] }}</td>
                                <td align="right">{{ $laporan["telat"] }}</td>
                                <td align="right">Rp.{{ number_format($laporan["kasbon"], 0, ",", ".") }},-</td>
                                <td align="right">Rp.{{ number_format($laporan["hutang"], 0, ",", ".") }},-</td>
                                <td align="right">Rp.{{ number_format($laporan["omzet"], 0, ",", ".") }},-</td>
                                <?php
                                $totalOmzet += $laporan["omzet"];
                                $totalGajiBersih += $laporan["gajibersih"];
                                $totalGajiKotor += $laporan["gajikotor"];
                                ?>
                            </tr>
                            @endif
                            @endforeach
                            <tr>
                                <td colspan="10" class="cell">&nbsp;</td>
                            </tr>
                            <tr>
                                <?php
                                if (in_array(26, $usermatrik)) {
                                    if (Session::get("user.tipe") == 0) {
                                        ?>
                                        <td align="right" colspan="3">Total Keseluruhan</td>
                                        <td align="right">Rp.{{ number_format($totalGajiBersih, 0, ",", ".") }},-</td>
                                        <td align="right">Rp.{{ number_format($totalGajiKotor, 0, ",", ".") }},-</td>
                                        <?php
                                    }
                                }
                                ?>
                                <td colspan="8" align="right" class="">Total Omzet</td>
                                <td align="right" class="cell">Rp.{{ number_format($totalOmzet, 0, ",", ".") }},-</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade detail_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content siku">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Detail Slip Gaji</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-2">
                            {{ HTML::image('uploads/no_image.png', "No Image", array('class' => 'thumbnail', "width" => 120)) }}
                        </div>
                        <div class="col-lg-10">
                            <form class="form-horizontal" action="{{ action("TransaksiTransferController@savebonus") }}" method="POST">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Nama Karyawan</label>
                                    <div class="col-sm-3 input-group ">
                                        <input type="text" class="form-control" value="" name="nortg" id="nortg" disabled=""/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Nomor Pembayaran Gaji</label>
                                    <div class="col-sm-3 input-group ">
                                        <input type="text" class="form-control" value="" name="nortg" id="nortg" disabled=""/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Tanggal Pembayaran Gaji</label>
                                    <div class="col-sm-3 input-group ">
                                        <input type="text" class="form-control" value="" name="tgltg" id="tgltg" disabled=""/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Gaji Kotor</label>
                                    <div class="col-sm-3 input-group ">
                                        <input type="text" class="form-control" value="" name="tgltg" id="tgltg" disabled=""/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Gaji Bersih</label>
                                    <div class="col-sm-3 input-group ">
                                        <input type="text" class="form-control" value="" name="tgltg" id="tgltg" disabled=""/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Gaji Bonus</label>
                                    <div class="col-sm-5 input-group ">
                                        <input type="text" class="form-control" value="" name="ttlbns"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Keterangan</label>
                                    <div class="col-sm-5 input-group ">
                                        <textarea class="form-control siku" name="kettrn"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"></label>
                                    <div class="col-sm-5 input-group ">
                                        <button type="button" value="btn_submit" name="btn_submit" class="btn btn-primary siku"> Simpan Gaji</button>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="panel panel-primary siku">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Informasi Jam Kerja</h3>
                                        </div>
                                        <div class="panel-body">
                                            <form class="form-horizontal">
                                                <div class="form-group">
                                                    <label class="col-lg-5 control-label">Total&nbsp;&nbsp; Kehadiran : </label>
                                                    <div class="col-sm-7 marginTop08">
                                                        <label>21 Hari</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-5 control-label">Total Durasi Bekerja : </label>
                                                    <div class="col-sm-7 marginTop08">
                                                        <label>197 Jam 42 Menit</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-5 control-label">Total Durasi Lembur : </label>
                                                    <div class="col-sm-7 marginTop08">
                                                        <label>0 Jam 0 Menit</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-5 control-label">Terlambat : </label>
                                                    <div class="col-sm-7 marginTop08">
                                                        <label>47 Menit</label>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="panel panel-primary siku">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Informasi Jam Kerja</h3>
                                        </div>
                                        <div class="panel-body">
                                            <form class="form-horizontal">
                                                <div class="form-group">
                                                    <label class="col-lg-5 control-label">Total&nbsp;&nbsp; Kehadiran : </label>
                                                    <div class="col-sm-7 marginTop08">
                                                        <label>21 Hari</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-5 control-label">Total Durasi Bekerja : </label>
                                                    <div class="col-sm-7 marginTop08">
                                                        <label>197 Jam 42 Menit</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-5 control-label">Total Durasi Lembur : </label>
                                                    <div class="col-sm-7 marginTop08">
                                                        <label>0 Jam 0 Menit</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-5 control-label">Terlambat : </label>
                                                    <div class="col-sm-7 marginTop08">
                                                        <label>47 Menit</label>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-primary siku">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Informasi Jam Kerja</h3>
                                </div>
                                <div class="panel-body">
                                    <form class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Total Kehadiran : </label>
                                            <div class="col-sm-7 marginTop08">
                                                <label>21 Hari</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Total Durasi Bekerja : </label>
                                            <div class="col-sm-7 marginTop08">
                                                <label>197 Jam 42 Menit</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Total Durasi Lembur : </label>
                                            <div class="col-sm-7 marginTop08">
                                                <label>0 Jam 0 Menit</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Terlambat : </label>
                                            <div class="col-sm-7 marginTop08">
                                                <label>47 Menit</label>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-10">
                            <div class="panel panel-danger siku">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Informasi Jam Kerja</h3>
                                </div>
                                <div class="panel-body">
                                    <form class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-lg-5 control-label">Total Kehadiran : </label>
                                            <div class="col-sm-7 marginTop08">
                                                <label>21 Hari</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-5 control-label">Total Durasi Bekerja : </label>
                                            <div class="col-sm-7 marginTop08">
                                                <label>197 Jam 42 Menit</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-5 control-label">Total Durasi Lembur : </label>
                                            <div class="col-sm-7 marginTop08">
                                                <label>0 Jam 0 Menit</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-5 control-label">Terlambat : </label>
                                            <div class="col-sm-7 marginTop08">
                                                <label>47 Menit</label>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="panel panel-danger siku">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Informasi Jam Kerja</h3>
                                </div>
                                <div class="panel-body">
                                    <form class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-lg-5 control-label">Total Kehadiran : </label>
                                            <div class="col-sm-7 marginTop08">
                                                <label>21 Hari</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-5 control-label">Total Durasi Bekerja : </label>
                                            <div class="col-sm-7 marginTop08">
                                                <label>197 Jam 42 Menit</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-5 control-label">Total Durasi Lembur : </label>
                                            <div class="col-sm-7 marginTop08">
                                                <label>0 Jam 0 Menit</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-5 control-label">Terlambat : </label>
                                            <div class="col-sm-7 marginTop08">
                                                <label>47 Menit</label>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="panel panel-danger siku">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Informasi Jam Kerja</h3>
                                </div>
                                <div class="panel-body">
                                    <form class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-lg-5 control-label">Total Kehadiran : </label>
                                            <div class="col-sm-7 marginTop08">
                                                <label>21 Hari</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-5 control-label">Total Durasi Bekerja : </label>
                                            <div class="col-sm-7 marginTop08">
                                                <label>197 Jam 42 Menit</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-5 control-label">Total Durasi Lembur : </label>
                                            <div class="col-sm-7 marginTop08">
                                                <label>0 Jam 0 Menit</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-5 control-label">Terlambat : </label>
                                            <div class="col-sm-7 marginTop08">
                                                <label>47 Menit</label>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="panel panel-default siku">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Informasi Jam Kerja</h3>
                                </div>
                                <div class="panel-body">
                                    <form class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-lg-5 control-label">Total Kehadiran : </label>
                                            <div class="col-sm-7 marginTop08">
                                                <label>21 Hari</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-5 control-label">Total Durasi Bekerja : </label>
                                            <div class="col-sm-7 marginTop08">
                                                <label>197 Jam 42 Menit</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-5 control-label">Total Durasi Lembur : </label>
                                            <div class="col-sm-7 marginTop08">
                                                <label>0 Jam 0 Menit</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-5 control-label">Terlambat : </label>
                                            <div class="col-sm-7 marginTop08">
                                                <label>47 Menit</label>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="panel panel-default siku">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Informasi Jam Kerja</h3>
                                </div>
                                <div class="panel-body">
                                    <form class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-lg-5 control-label">Total Kehadiran : </label>
                                            <div class="col-sm-7 marginTop08">
                                                <label>21 Hari</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-5 control-label">Total Durasi Bekerja : </label>
                                            <div class="col-sm-7 marginTop08">
                                                <label>197 Jam 42 Menit</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-5 control-label">Total Durasi Lembur : </label>
                                            <div class="col-sm-7 marginTop08">
                                                <label>0 Jam 0 Menit</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-5 control-label">Terlambat : </label>
                                            <div class="col-sm-7 marginTop08">
                                                <label>47 Menit</label>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="panel panel-default siku">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Informasi Jam Kerja</h3>
                                </div>
                                <div class="panel-body">
                                    <form class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-lg-5 control-label">Total Kehadiran : </label>
                                            <div class="col-sm-7 marginTop08">
                                                <label>21 Hari</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-5 control-label">Total Durasi Bekerja : </label>
                                            <div class="col-sm-7 marginTop08">
                                                <label>197 Jam 42 Menit</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-5 control-label">Total Durasi Lembur : </label>
                                            <div class="col-sm-7 marginTop08">
                                                <label>0 Jam 0 Menit</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-5 control-label">Terlambat : </label>
                                            <div class="col-sm-7 marginTop08">
                                                <label>47 Menit</label>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger siku" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Masuk Karyawan Modal -->
    <div class="modal fade absensi_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content siku">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-table"></i> Daftar Masuk Karyawan
                        <span id="timeServer" class="pull-right">{{ date('H:i:s') }}</span>
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="padding: 20px;">
                        <table id="datatable_absensi" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <td>No Absen</td>
                                    <td>Nama Karyawan</td>
                                    <td>Jam Masuk</td>
                                    <td>Jam Istirahat</td>
                                    <td>Jam Kembali</td>
                                    <td>Jam Pulang</td>
                                    <td>Jam Lembur Masuk</td>
                                    <td>Jam Lembur Pulang</td>
                                    <td>Keterlambatan</td>
                                </tr>
                            </thead>
                            <tbody id="tblMasuk">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger siku" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        setInterval(function () {
            $.get('<?php echo action('DaftarController@getTimeServer') ?>', function (data) {
                $('#timeServer').html("Jam : " + data);
            });
            //ambil data dari json
            $.getJSON('<?php echo action('DaftarController@getDaftarMasuk') ?>', function (data) {
                var str = "";
                if (data.length > 0) {
                    $.each(data, function (key, val) {
                        str += "<tr>";
                        str += "<td>" + val.idkar + "</td>";
                        str += "<td>" + val.nama + "</td>";
                        str += "<td>" + val.jammasuk + "</td>";
                        str += "<td>" + val.jamkeluar + "</td>";
                        str += "<td>" + val.jamkembali + "</td>";
                        str += "<td>" + val.jampulang + "</td>";
                        str += "<td>" + val.jamlemburmasuk + "</td>";
                        str += "<td>" + val.jamlemburpulang + "</td>";
                        str += "<td>" + val.lbt + "</td>";
                        str += "</tr>";
                    });
                } else {
                    str += "<tr>";
                    str += "<td class='text-center' colspan='9'>No Data available in table </td>";
                    str += "</tr>";
                }
                $("#tblMasuk").html(str);
            });
        }, 1000);
    </script>
    <!-- End Daftar Masuk Karyawan Modal -->

    <!-- Persen Bonus Karyawan Modal -->
    <div class="modal fade persenbonus_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content siku">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-percent"></i> Ubah Persen Bonus Karyawan
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="padding: 20px;">
                        <form class="form-horizontal" action="{{ action("LaporanAdminController@persen_bonus_karyawan_admin_save") }}" method="POST" id="persen_bonus_form">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Persen Bonus</label>
                                <div class="col-sm-2 input-group">                            
                                    <div class="input-group">
                                        <input type="text" class="form-control siku" value="{{ Input::old('prsbns', $prsbns) }}" name="prsbns">
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Maksimal Telat (Menit) </label>
                                <div class="col-sm-3 input-group">                            
                                    <div class="input-group">
                                        <input type="text" class="form-control siku" value="{{ Input::old('maxtelat', $maxtelat) }}" name="maxtelat">
                                        <div class="input-group-addon">Menit</div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"></label>
                                <div class="col-sm-3 input-group">                                        
                                    <button class="btn btn-primary siku" type="button" id="btn_persen"><i class="fa fa-save"></i> Simpan</button> &nbsp;
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger siku" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Persen Bonus Karyawan Modal -->

    <!-- Laporan Penggajian Karyawan Modal -->
    <div class="modal fade laporan_pembayaran_gaji_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content siku">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"> Laporan Pembayaran Gaji
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="padding: 20px;">
                        <form class="form-horizontal" action="{{ action("LaporanAdminController@histori_pembayaran_gaji_query") }}" method="POST">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Periode</label>
                                <div class="col-sm-3">
                                    <select class="form-control siku" name="bulan" id="bulan_gaji">
                                        <?php for ($i = 1; $i < 13; $i++) { ?>
                                            <option value="<?php echo (strlen($i) == 1 ? "0" . $i : $i) ?>" {{ date("m") == $i ? "selected" : "" }}>
                                            <?php
                                            setlocale(LC_ALL, 'IND');
                                            echo strftime('%B', strtotime("2016-" . (strlen($i) == 1 ? "0" . $i : $i) . "-01"));
                                            ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select class="form-control siku" name="bulan2" id="bulan2_gaji">
                                    <?php for ($i = 1; $i < 13; $i++) { ?>
                                        <option value="<?php echo (strlen($i) == 1 ? "0" . $i : $i) ?>" {{ date("m") == $i ? "selected" : "" }}>
                                        <?php
                                        setlocale(LC_ALL, 'IND');
                                        echo strftime('%B', strtotime("2016-" . (strlen($i) == 1 ? "0" . $i : $i) . "-01"));
                                        ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>                    
                        <div class="col-sm-2">
                            <input type="text" class="form-control siku" value="{{ date('Y') }}" name="tahun" id="tahun_gaji">
                        </div>
                        @if($errors->first('tahun'))
                        <div class="col-sm-3 col-sm-offset-2 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('tahun') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Karyawan</label>
                        <div class="col-sm-4">
                            <select class="form-control siku" name="idkar_gaji" id="idkar_gaji">
                                <option value="0" selected="">Semua</option>
                                @foreach($karyawans as $karyawan)
                                <option value="{{ $karyawan->idkar }}">{{ $karyawan->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-4">                                        
                            <select class="form-control siku" name="status_gaji" id="status_gaji">
                                <option value="A">-- Semua Status --</option>
                                <option value="Y">Terbayar</option>
                                <option value="N">Belum Terbayar</option>
                            </select>
                        </div>
                    </div>                               
                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">                                        
                            <button id="btn_laporan_gaji" type="button" class="btn btn-success siku" name="btn_filter" value="btn_filter"><i class="fa fa-search"></i> Filter</button>
                        </div>
                    </div>                               
                </form>
                <hr>
                <table class="table table-bordered table-hover" id="datatable_laporan_pembayaran_gaji">
                    <thead>
                        <tr>
                            <th class="text-left">No Gaji</th>
                            <th class="text-left">Tanggal</th>
                            <th class="text-left">Nama</th>
                            <th class="text-left">Total Gaji</th>
                            <th class="text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-left" id="tblbody_laporan_gaji">
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger siku" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
        </div>
    </div>
</div>
</div>
<!-- END Laporan Penggajian Karyawan Modal -->

<!-- Laporan Tabungan Karyawan Modal -->
<div class="modal fade laporan_tabungan_karyawan_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content siku">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"> Laporan Saldo Tabungan
                </h4>
            </div>
            <div class="modal-body">
                <div class="row" style="padding: 20px;">
                    <table class="table table-bordered table-hover" id="datatable_laporan_tabungan">
                        <thead>
                            <tr>
                                <th class="text-left">Nama</th>
                                <th class="text-left">Tabungan Masuk</th>
                                <th class="text-left">Tabungan Keluar</th>
                                <th class="text-left">Sisa Tabungan</th>
                                <th class="text-left">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="text-left" id="tblbody_saldo_tabungan">
                            <?php
                            $tabungan = 0;
                            ?>
                            @foreach ($allTabungans as $allTabungan)
                            <tr>
                                <td>{{ $allTabungan->nama }} </td>
                                <td class="text-left">
                                    Rp.<?php echo number_format($allTabungan->tbmsk, 0, ',', '.') ?>,-
                                </td>
                                <td class="text-left">
                                    Rp.<?php echo number_format($allTabungan->tbklr, 0, ',', '.') ?>,-
                                </td>
                                <td class="text-left">
                                    Rp.<?php echo number_format($allTabungan->tbsld, 0, ',', '.') ?>,-
                                </td>
                                <td class="text-center">
                                    <a target="_blank" href="{{ action('LaporanAdminController@show_tabungan', [$allTabungan->idkar]) }}" class="btn btn-info siku" data-toggle="tooltip" data-placement="right" title="Detail?"><i class="fa fa-info-circle"></i></a> 
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger siku" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- End Tabungan Karyawan Modal -->

<!-- Laporan Omzet Karyawan Modal -->
<div class="modal fade laporan_omzet_karyawan_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content siku">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"> Laporan Omzet Karyawan
                </h4>
            </div>
            <div class="modal-body">
                <div class="row" style="padding: 20px;">
                    <form class="form-horizontal" action="{{ action("LaporanAdminController@histori_omzet_query") }}" method="POST">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Periode</label>
                            <div class="col-sm-6 input-group ">
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" value="<?php echo date("d-m-Y") ?>" name="tglfrom_laporan_omzet" id="tglfrom_laporan_omzet">
                                </div>
                                <label class="col-sm-2 control-label">s/d</label>
                                <div class="col-sm-4 input-group ">
                                    <input type="text" class="form-control" value="<?php echo date("d-m-Y") ?>" name="tglto_laporan_omzet" id="tglto_laporan_omzet">  
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama Karyawan</label>
                            <div class="col-sm-3">
                                <select class="form-control siku" name="idkar_laporan_omzet" id="idkar_laporan_omzet">
                                    <option value="0">Semua</option>
                                    @foreach($karyawans as $karyawan)
                                    <option value="{{ $karyawan->idkar }}">{{ $karyawan->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-3">                                        
                                <button class="btn btn-success siku" type="button" id="btn_laporan_omzet"><i class="fa fa-search"></i> Filter</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <table class="table table-bordered table-hover" id="datatable_laporan_omzet_karyawan">
                        <thead>
                            <tr>
                                <th class="text-left">Tanggal</th>
                                <th class="text-left">Nama</th>
                                <th class="text-left">Total Omzet</th>
                            </tr>
                        </thead>
                        <tbody class="text-center" id="tblbody_laporan_omzet">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger siku" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- END Laporan Omzet Karyawan Modal -->

<!-- Input Saldo Tabungan Karyawan Modal -->
<div class="modal fade input_saldo_tabungan_karyawan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content siku">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"> Input Saldo Tabungan Karyawan </h4>
            </div>
            <div class="modal-body">
                <div class="row" style="padding: 20px;">
                    <form id="form_saldo_tabungan_karyawan" class="form-horizontal" action="{{ action("LaporanAdminController@add_saldo_tabungan_karyawan") }}" method="POST">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama Karyawan</label>
                            <div class="col-sm-3">
                                <select class="form-control siku" name="idkar" id="idkar_input_saldo_tabungan">
                                    @foreach($karyawans as $karyawan)
                                    <option value="{{ $karyawan->idkar }}">{{ $karyawan->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Saldo Tabungan</label>
                            <div class="col-sm-4">
                                <input type="number" name="tbsld" id="tbsld_input_saldo_tabungan" class="form-control siku" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-3">                                        
                                <button class="btn btn-primary siku" type="button" id="btn_input_saldo_tabungan"><i class="fa fa-save"></i> Simpan </button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <table class="table table-bordered table-hover" id="datatable_input_saldo_tabungan">
                        <thead>
                            <tr>
                                <th class="text-left">No</th>
                                <th class="text-left">Nama</th>
                                <th class="text-left">Tabungan</th>
                            </tr>
                        </thead>
                        <tbody class="" id="tblbody_input_saldo_tabungan">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger siku" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- END Input Saldo Tabungan Karyawan Modal -->

<!-- Input Tabungan Karyawan Modal -->
<div class="modal fade input_tabungan_karyawan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content siku">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"> Input Tabungan Karyawan </h4>
            </div>
            <div class="modal-body">
                <div class="row" style="padding: 20px;">
                    <div class="col-sm-8">
                        <form id="form_tabungan_karyawan" class="form-horizontal" action="{{ action("LaporanAdminController@add_tabungan_karyawan") }}" method="POST">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nama Karyawan</label>
                                <div class="col-sm-6">
                                    <select class="form-control siku" name="idkar" id="idkar_input_tabungan" onchange="changeKaryawan('idkar_input_tabungan')">
                                        <?php
                                        $kodeabsen = "000000";
                                        $pic = "";
                                        if (count($karyawans) > 0) {
                                            $kodeabsen = $karyawans[0]->usernm;
                                            $pic = $karyawans[0]->pic;
                                        }
                                        ?>
                                        @foreach($karyawans as $karyawan)
                                        <option value="{{ $karyawan->idkar }}">{{ $karyawan->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Kode Absen</label>
                                <div class="col-sm-6">
                                    <input type="number" id="abscd" class="form-control siku" readonly="" value="{{ $kodeabsen }}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Jumlah Tabungan</label>
                                <div class="col-sm-6">
                                    <input type="number" name="niltb" id="niltb_input_tabungan" class="form-control siku" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"></label>
                                <div class="col-sm-6">                                        
                                    <button class="btn btn-primary siku" type="button" id="btn_input_tabungan"><i class="fa fa-save"></i> Simpan </button>
                                </div>
                            </div>
                        </form>                        
                    </div>
                    <div class="col-sm-4">
                        <img id="img" class="thumbnail" src="{{ url("/uploads")."/".$pic }}" width="120" height="150">
                    </div>
                </div>
                <hr>
                <h4 class="page-header">Status Tabungan Karyawan</h4>
                <table class="table table-bordered table-hover" id="datatable_input_tabungan">
                    <thead>
                        <tr>
                            <th class="text-left">Tanggal</th>
                            <th class="text-left">Nomor Transaksi Tabungan</th>
                            <th class="text-left">Karyawan</th>
                            <th class="text-left">Tabungan</th>
                            <th class="text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="" id="tblbody_input_tabungan">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger siku" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- END Input Tabungan Karyawan Modal -->

<!-- Transfer Gaji Karyawan Modal -->
<div class="modal fade input_transfer_gaji_karyawan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content siku">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"> Transfer Gaji Karyawan </h4>
            </div>
            <div class="modal-body">
                <div class="row" style="padding: 20px; padding-top: 0px;">
                    <form id="form_gaji_karyawan" class="form-horizontal" action="{{ action("LaporanAdminController@transfer_all_gaji") }}" method="POST">
                        <div class="pull-right" style="margin-top: 0px;">
                            <button class="btn btn-success siku" id="btn_transfer_gaji" type="button"><i class="fa fa-check-circle"></i> Transfer Slip Gaji</button>
                        </div>
                        <br><br><br>
                        <div id="lbl_selected" class="alert alert-info">
                            <b><span id="text_selected"></span> </b>
                        </div>
                        <table class="table table-bordered table-hover" id="datatable_input_transfer_gaji">
                            <thead>
                                <tr>
                                    <th class="text-left">No</th>
                                    <th class="text-left">Tanggal</th>
                                    <th class="text-left">Karyawan</th>
                                    <th class="text-left">Total Gaji yang Dibayarkan</th>
                                    <th class="text-left">Status Pembayaran</th>
                                    <th class="text-left">Pilih <input type="checkbox" name="chk" id="chk"/> </th>
                                </tr>
                            </thead>
                            <tbody class="" id="tblbody_input_transfer_gaji">
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger siku" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- END Transfer Gaji Karyawan Modal -->

@stop

@section('script')
<script type="text/javascript">
    var table;
    $(document).on("click", ".modal-body", function () {
        $("#tglto_laporan_omzet").datepicker({
            inline: true,
            dateFormat: "dd-mm-yy",
            changeYear: true,
            changeMonth: true
        });
    });

    $(document).ready(function () {
        // <editor-fold defaultstate="collapsed" desc="user-description">
        $('.clockpicker').clockpicker({
            placement: 'bottom',
            align: 'left',
            donetext: 'Done'
        });
        $('#datatable').DataTable();

        $('#datatable_absensi').DataTable({
            "bInfo": false
        });

        $("#tglto").datepicker({
            inline: true,
            dateFormat: "dd-mm-yy",
            changeYear: true,
            changeMonth: true
        });

        $("#tglfrom").datepicker({
            inline: true,
            dateFormat: "dd-mm-yy",
            changeYear: true,
            changeMonth: true
        });

        $("#tglto_laporan_omzet").datepicker({
            inline: true,
            dateFormat: "dd-mm-yy",
            changeYear: true,
            changeMonth: true
        });

        $("#tglfrom_laporan_omzet").datepicker({
            inline: true,
            dateFormat: "dd-mm-yy",
            changeYear: true,
            changeMonth: true
        });

        //  Laporan Penggajian Karyawan
        $.ajax({
            type: "POST",
            url: '{{ action("LaporanAdminController@get_laporan_gaji") }}',
            data: {
                bulan_gaji: $("#bulan_gaji").val(),
                bulan2_gaji: $("#bulan2_gaji").val(),
                tahun_gaji: $("#tahun_gaji").val(),
                idkar_gaji: $("#idkar_gaji").val(),
                status_gaji: $("#status_gaji").val()
            },
            success: function (result) {

                var data = JSON.parse(result);
                $.each(data, function (index, data) {
                    //!!!--Here is the main catch------>fnAddData
                    $('#datatable_laporan_pembayaran_gaji').dataTable().fnAddData([
                        data.no_gaji,
                        data.tanggal,
                        data.nama,
                        data.total_gaji,
                        data.status]
                            );
                });
            }
        });
        $("#btn_laporan_gaji").click(function () {
            var bulan_gaji = $("#bulan_gaji").val();
            var bulan2_gaji = $("#bulan2_gaji").val();
            if (parseInt(bulan_gaji) > parseInt(bulan2_gaji)) {
                alertify.alert("Filter Bulan Tidak Valid!");
            } else {
                $("#tblbody_laporan_gaji").html('');

                $.ajax({
                    type: "POST",
                    url: '{{ action("LaporanAdminController@get_laporan_gaji") }}',
                    data: {
                        bulan_gaji: $("#bulan_gaji").val(),
                        bulan2_gaji: $("#bulan2_gaji").val(),
                        tahun_gaji: $("#tahun_gaji").val(),
                        idkar_gaji: $("#idkar_gaji").val(),
                        status_gaji: $("#status_gaji").val()
                    },
                    success: function (result) {
                        $("#datatable_laporan_pembayaran_gaji").DataTable().clear();

                        var data = JSON.parse(result);
                        $.each(data, function (index, data) {
                            //!!!--Here is the main catch------>fnAddData
                            $('#datatable_laporan_pembayaran_gaji').dataTable().fnAddData([
                                data.no_gaji,
                                data.tanggal,
                                data.nama,
                                data.total_gaji,
                                data.status]
                                    );
                        });
                    }
                });
            }
        });
        $('#datatable_laporan_pembayaran_gaji').DataTable({
            "pageLength": 5,
            "processing": true,
            "order": []
        });
        // END Laporan Penggajian Karyawan

        // Laporan Tabungan Karyawan
        $('#datatable_laporan_tabungan').DataTable({
            "pageLength": 5,
            "processing": true,
            "order": []
        });
        // End Laporan Tabungan Karyawan

        // Laporan Omzet Karyawan
        $.ajax({
            type: "POST",
            url: '{{ action("LaporanAdminController@get_laporan_omzet") }}',
            data: {
                tanggal_start_omzet: $("#tglfrom_laporan_omzet").val(),
                tanggal_end_omzet: $("#tglto_laporan_omzet").val(),
                idkar_omzet: $("#idkar_laporan_omzet").val()
            },
            success: function (result) {
                $("#datatable_laporan_omzet_karyawan").DataTable().clear();

                var data = JSON.parse(result);
                $.each(data, function (index, data) {
                    //!!!--Here is the main catch------>fnAddData
                    $('#datatable_laporan_omzet_karyawan').dataTable().fnAddData([
                        data.tglomz,
                        data.nama,
                        data.nilomz
                    ]);
                });
            }
        });
        $("#btn_laporan_omzet").click(function () {
            var tglfrom_omzet = $("#tglfrom_laporan_omzet").val() + "";
            var tglto_omzet = $("#tglto_laporan_omzet").val() + "";
            var tglfrom_num = tglfrom_omzet.substr(6, 4) + tglfrom_omzet.substr(3, 2) + tglfrom_omzet.substr(0, 2);
            var tglto_num = tglto_omzet.substr(6, 4) + tglto_omzet.substr(3, 2) + tglto_omzet.substr(0, 2);
            if (parseInt(tglfrom_num) > parseInt(tglto_num)) {
                alertify.alert("Filter Tanggal Tidak Valid!");
            } else {
                $("#tblbody_laporan_omzet").html('');

                $.ajax({
                    type: "POST",
                    url: '{{ action("LaporanAdminController@get_laporan_omzet") }}',
                    data: {
                        tanggal_start_omzet: $("#tglfrom_laporan_omzet").val(),
                        tanggal_end_omzet: $("#tglto_laporan_omzet").val(),
                        idkar_omzet: $("#idkar_laporan_omzet").val()
                    },
                    success: function (result) {
                        $("#datatable_laporan_omzet_karyawan").DataTable().clear();

                        var data = JSON.parse(result);
                        if (data == '') {
                            $("#datatable_laporan_omzet_karyawan").DataTable().destroy();
                            $('#datatable_laporan_omzet_karyawan tbody').empty();
                            $("#datatable_laporan_omzet_karyawan").DataTable().fnDraw();
                        }
                        $.each(data, function (index, data) {
                            //!!!--Here is the main catch------>fnAddData
                            $('#datatable_laporan_omzet_karyawan').dataTable().fnAddData([
                                data.tglomz,
                                data.nama,
                                data.nilomz
                            ]);
                        });
                    }
                });


            }
        });
        $('#datatable_laporan_omzet_karyawan').DataTable({
            "pageLength": 5,
            "processing": true,
            "order": []
        });
        // End Laporan Tabungan Karyawan

        // Ubah Persen Bonus
        $("#btn_persen").click(function (e) {
            $.ajax({
                type: "POST",
                url: $("#persen_bonus_form").attr("action"),
                data: $("#persen_bonus_form").serialize(), // serializes the form's elements.
                success: function (data) {
                    alertify.alert("Data Persen Bonus Karyawan Telah Diubah!", function () {
                        // Do Something Here
                    });
                }
            });
            $(".persenbonus_modal").modal('hide');
        });
        // END Ubah Persen Bonus

        // Input Saldo Tabungan
        get_saldo_tabungan();
        $("#btn_input_saldo_tabungan").click(function () {
            var saldo_tabungan = $("#tbsld_input_saldo_tabungan").val() + "";
            if (saldo_tabungan == "") {
                alertify.alert("Nominal Saldo Tabungan Harus Diisi!");
            } else {
                $.ajax({
                    type: "POST",
                    url: $("#form_saldo_tabungan_karyawan").attr("action"),
                    data: $("#form_saldo_tabungan_karyawan").serialize(), // serializes the form's elements.
                    success: function (data) {
                        alertify.alert("Data Tabungan Telah Ditambahkan!", function () {
                            $("#tblbody_laporan_gaji").html('');
                            get_saldo_tabungan();
                            $("#tbsld_input_saldo_tabungan").val("");
                        });
                    }
                });
            }
        });
        $("#datatable_input_saldo_tabungan").DataTable({
            "pageLength": 5,
            "processing": true,
            "order": [],
            "aoColumnDefs": {
                "aTargets": [2],
                "sClass": "right"
            }
        });
        // END Input Saldo Tabungan

        // Input Tabungan Karyawan

        get_tabungan_karyawan();

        $("#btn_input_tabungan").click(function () {
            var nil_tabungan = $("#niltb_input_tabungan").val() + "";
            if (nil_tabungan == "") {
                alertify.alert("Nominal Saldo Tabungan Harus Diisi!");
            } else {
                $.ajax({
                    type: "POST",
                    url: $("#form_tabungan_karyawan").attr("action"),
                    data: $("#form_tabungan_karyawan").serialize(), // serializes the form's elements.
                    success: function (data) {
                        var message = "";
                        if (data == "true") {
                            message = "Data Tabungan Telah Ditambahkan";
                        } else {
                            message = data;
                        }

                        alertify.alert(message, function () {
                            $("#tblbody_input_tabungan").html('');
                            get_tabungan_karyawan();
                            $("#niltb_input_tabungan").val("");
                        });

                    }
                });
            }
        });

        $("#datatable_input_tabungan").DataTable({
            "pageLength": 5,
            "processing": true,
            "order": [],
            "aoColumnDefs": {
                "aTargets": [2],
                "sClass": "right"
            }
        });
        // END Input Tabungan Karyawan

        // Input Transfer Gaji Karyawan

        get_gaji_karyawan();
        $("#lbl_selected").hide();

        $("#chk").change(function () {
            if (this.checked) {
                $(".chkitem").prop('checked', true);
                $("#lbl_selected").show();
                $("#text_selected").html($(".chkitem:checked").length + " Item Selected");
            } else {
                $(".chkitem").prop('checked', false);
                $("#lbl_selected").hide();
            }
        });

        $("#btn_transfer_gaji").click(function () {
            var selectedItem = $(".chkitem:checked").length;
            if (selectedItem == 0) {
                alertify.alert("Tidak Terdapat Slip Gaji yang dipilih!");
            } else {
                $.ajax({
                    type: "POST",
                    url: $("#form_gaji_karyawan").attr("action"),
                    data: $("#form_gaji_karyawan").serialize(), // serializes the form's elements.
                    success: function (data) {
                        alertify.alert(data, function () {
                            $("#tblbody_input_transfer_gaji").html('');
                            get_gaji_karyawan();
                            $("#lbl_selected").hide();
                        });

                    }
                });
            }
        });

        $("#datatable_input_transfer_gaji").DataTable({
            "paging": false, // next page
            "ordering": true, // order by at header 
            "info": false,
            "order": [],
            fixedHeader: {
                headerOffset: $('#form_gaji_karyawan').outerHeight()
            }
        });
        // END Input Transfer Gaji Karyawan

        // Detail Gaji
        $.ajax({
            type: "POST",
            url: '{{ action("LaporanAdminController@get_detail_gaji") }}',
            success: function (result) {
                var data = JSON.parse(result);
                var gajis = data.gajis;
                $.each(gajis, function (index, gaji) {
                });
//                console.log("Durasi Bekerja : " + data.durasiBekerja);
//                $.each(data, function (index, data) {
//                   console.log(data); 
//                   console.log('------------'); 
//                });
            }
        });
        // END Detail Gaji
    });

    function get_saldo_tabungan() {
        $.ajax({
            type: "POST",
            url: '{{ action("LaporanAdminController@get_saldo_tabungan_karyawan") }}',
            success: function (result) {
                $("#datatable_input_saldo_tabungan").DataTable().clear();

                var data = JSON.parse(result);
                $.each(data, function (index, data) {
                    //!!!--Here is the main catch------>fnAddData
                    $('#datatable_input_saldo_tabungan').dataTable().fnAddData([
                        data.no,
                        data.nama,
                        data.tbsld
                    ]);
                });
            }
        });
    }

    function get_tabungan_karyawan() {
        $.ajax({
            type: "POST",
            url: '{{ action("LaporanAdminController@get_tabungan_karyawan") }}',
            success: function (result) {
                $("#datatable_input_tabungan").DataTable().clear();
                var data = JSON.parse(result);
                $.each(data, function (index, data) {
                    //!!!--Here is the main catch------>fnAddData
                    var action = "<button class='btn btn-danger' onclick='delete_tabungan(" + data.idtb + ")'><i class='fa fa-times'></i></button>";
                    $('#datatable_input_tabungan').dataTable().fnAddData([
                        data.tgltb,
                        data.nortb,
                        data.nama,
                        data.niltb,
                        action
                    ]);
                });
            }
        });
    }

    function changeKaryawan(idkar) {
        var id = document.getElementById(idkar).value;
        var url = "<?php echo url("/master/karyawan/get_karyawan") ?>" + "/" + id;

        $.get(url, function (data) {
            var mk01 = JSON.parse(data);
            $("#abscd").val(mk01.usernm);
            var img = "<?php echo url("/uploads") ?>" + "/" + mk01.pic;
            $("#img").attr("src", img);
        });
    }

    function delete_tabungan(id) {
        if (id != null) {
            alertify.confirm('Hapus Tabungan Karyawan?', function (e) {
                if (e) {
                    $.ajax({
                        type: "POST",
                        url: '{{ action("LaporanAdminController@delete_tabungan_karyawan") }}',
                        data: {
                            idtb: id
                        },
                        success: function (result) {
                            alertify.alert(result, function () {
                                get_tabungan_karyawan();
                            });
                        }
                    });
                } else {
                    //after clicking Cancel
                }
            });
        }
    }

    function get_gaji_karyawan() {
        $.ajax({
            type: "POST",
            url: '{{ action("LaporanAdminController@get_gaji_karyawan") }}',
            success: function (result) {
                $("#datatable_input_transfer_gaji").DataTable().clear();
                var data = JSON.parse(result);
                $.each(data, function (index, data) {
                    //!!!--Here is the main catch------>fnAddData
                    var status = "";
                    var check = "";
                    if (data.status == "N") {
                        status = "<font color='red'> <i class='fa fa-exclamation-circle'></i> Belum Terbayar </font>";
                        check = '<input type="checkbox" onchange="getSelectedItem()" name="chkitem[]" class="chkitem siku" value="' + data.idtg + '"/>'
                    } else {
                        status = "<font color='green'> <i class='fa fa-check-circle green'></i> Gaji Telah Dibayarkan </font>";
                        check = '<input type="checkbox" name="" class="siku" disabled=""/>';
                    }

                    $('#datatable_input_transfer_gaji').dataTable().fnAddData([
                        data.nortg,
                        data.tgltg,
                        data.nama,
                        data.ttlgj,
                        status,
                        check
                    ]);
                });
            }
        });
    }

    function getSelectedItem() {
        if ($(".chkitem:checked").length == 0) {
            $("#lbl_selected").hide();
        } else {
            $("#lbl_selected").show();
            $("#text_selected").html($(".chkitem:checked").length + " Item Selected");
        }
    }

    function get_detail_slip_gaji(id) {
//        alert(id);
    }
</script> 
@stop