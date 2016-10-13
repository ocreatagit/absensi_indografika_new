@extends('template.master')

@section('title')
<title>ABSENSI - My Indografika</title>
@stop

@section('header')
<h1 class="page-header">Laporan Bulanan Karyawan</h1>
@stop

@section('main')
<div class="row">
    <div class="panel panel-default siku">
        <div class="panel-heading">Laporan Bulanan Karyawan</div>
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
                <div class="col-lg-6">
                    <div class="panel panel-info siku">
                        <div class="panel-heading siku">Aktivitas Penggajian Karyawan</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-4 text-left">
                                    <button class="btn btn-warning btn-block siku text-left">Transfer Gaji</button>
                                    <button class="btn btn-warning btn-block siku text-left">Tabungan Karyawan</button>
                                    <button class="btn btn-warning btn-block siku text-left" type="button" data-toggle="modal" data-target=".saldo_tabungan_modal">
                                        Saldo Tabungan
                                    </button>
                                </div>
                                <div class="col-lg-5 text-left">
                                    <button class="btn btn-info btn-block siku text-left">Lap. Pembayaran Gaji</button>
                                    <button class="btn btn-info btn-block siku text-left">Lap. Tabungan</button>
                                    <button class="btn btn-info btn-block siku text-left">Lap. Omzet Karyawan</button>
                                </div>
                                <div class="col-lg-1">
                                    <button class="btn btn-primary siku text-left" type="button" data-toggle="modal" data-target=".absensi_modal">
                                        <i class="fa fa-table"></i>
                                    </button>
                                </div>
                                <div class="col-lg-1">
                                    <button class="btn btn-default siku text-left" type="button" data-toggle="modal" data-target=".persenbonus_modal"><i class="fa fa-gift"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
                <hr>
                <table class="table table-bordered table-hover table-striped" id="">
                    <thead>
                        <tr>
                            <th class="text-center"><a href="{{ action('MasterKaryawanController@create') }}" class="btn btn-primary siku">Tambah Karyawan <i class="fa fa-user-plus"></i></a></th>
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
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr>
                            <td colspan="<?php echo ((in_array(26, $usermatrik)) ? (Session::get("user.tipe") == 0 ? 14 : 10) : 10) ?>" class="cell">&nbsp;</td>
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
                            <td class="text-center" width="10%">
                                <button class="btn btn-info siku" type="button" class="btn btn-primary" data-toggle="modal" data-target=".detail_modal">
                                    <i class="fa fa-info-circle"></i>
                                </button>
                                <a target="_blank" href="{{ action('TransaksiTransferController@printgaji', [$laporan["idtg"]]) }}" class="btn btn-default siku {{ $laporan["idtg"] == -1 ? "disabled" : "" }}" data-toggle="tooltip" data-placement="left" title="Cetak Slip Gaji?"><i class="fa fa-print"></i></a>
                            </td>
                            <?php
                            $totalOmzet += $laporan["omzet"];
                            $totalGajiBersih += $laporan["gajibersih"];
                            $totalGajiKotor += $laporan["gajikotor"];
                            ?>
                        </tr>
                        @endif
                        @endforeach
                        <tr>
                            <td colspan="<?php echo ((in_array(26, $usermatrik)) ? (Session::get("user.tipe") == 0 ? 14 : 10) : 10) ?>" class="cell">&nbsp;</td>
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
                            <td colspan="<?php echo ((in_array(26, $usermatrik)) ? (Session::get("user.tipe") == 0 ? 7 : 9) : 9) ?>" align="right" class="">Total Omzet</td>
                            <td align="right" class="cell">Rp.{{ number_format($totalOmzet, 0, ",", ".") }},-</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade detail_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content siku">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-money"></i> Detail Slip Gaji</h4>
                </div>
                <div class="modal-body">
                    <div class="row">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
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
                                <div class="col-sm-4 input-group">                            
                                    <div class="input-group">
                                        <input type="text" class="form-control siku" value="{{ Input::old('prsbns', $prsbns) }}" name="prsbns">
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                                @if($errors->first('prsbns'))
                                <div class="col-sm-5 col-sm-offset-2 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('prsbns') }}</div>
                                @endif
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
    
    <!-- Saldo Tabungan Karyawan Modal -->
    <div class="modal fade saldo_tabungan_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
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
                                <div class="col-sm-4 input-group">                            
                                    <div class="input-group">
                                        <input type="text" class="form-control siku" value="{{ Input::old('prsbns', $prsbns) }}" name="prsbns">
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                                @if($errors->first('prsbns'))
                                <div class="col-sm-5 col-sm-offset-2 alert alert-danger" style="margin-top: 5px; margin-bottom: 0px;">{{ $errors->first('prsbns') }}</div>
                                @endif
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
    <!-- End Saldo Tabungan Karyawan Modal -->
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
        });


    </script> 
    @stop