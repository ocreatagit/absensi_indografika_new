@extends('template.master')

@section('title')
<title>ABSENSI - My Indografika</title>
@stop

@section('header')
<h1 class="page-header">Laporan Bulanan Karyawan</h1>
@stop

@section('main')
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">Laporan Bulanan Karyawan</div>
        <div class="panel-body">
            @if(Session::has('filter'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <i class="fa fa-info-circle"></i> {{ $filter }}
            </div>    
            @endif
            <form class="form-horizontal" action="{{ action("LaporanAdminController@laporan_karyawan_query") }}" method="POST">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Bulan</label>
                    <div class="col-sm-2">
                        <select name="bln" class="form-control siku">
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
                    <div class="col-sm-1">
                        <input class="form-control siku" name="thn" value="{{ date("Y") }}" required=""/>
                    </div>
                </div>                            
                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-1">                                        
                        <button type="submit" class="btn btn-primary siku" name="btn_filter" value="btn_filter"><i class="fa fa-search"></i> Filter</button>
                    </div>
                    <div class="col-sm-2">                                        
                        <button type="submit" class="btn btn-success siku" name="btn_export" value="btn_export"><i class="fa fa-book"></i> Export to Excel</button>
                    </div>
                </div>                               
            </form>    
            <hr>
            <table class="table table-bordered table-hover" id="">
                <thead>
                    <tr>
                        <th class="text-center"></th>
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
                        <td colspan="<?php echo ((in_array(26, $usermatrik)) ? (Session::get("user.tipe") == 0 ? 13 : 9) : 9) ?>" class="cell">&nbsp;</td>
                    </tr>
                    <?php
                    $totalOmzet = 0;
                    $totalGajiBersih = 0;
                    $totalGajiKotor = 0;
                    ?>
                    @foreach($laporans as $laporan)
                    <tr>
                        <td>{{ $laporan["nama"] }}</td>
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
                    @endforeach
                    <tr>
                        <td colspan="<?php echo ((in_array(26, $usermatrik)) ? (Session::get("user.tipe") == 0 ? 13 : 9) : 9) ?>" class="cell">&nbsp;</td>
                    </tr>
                    <tr>
                        <?php
                        if (in_array(26, $usermatrik)) {
                            if (Session::get("user.tipe") == 0) {
                                ?>
                                <td align="right" colspan="2">Total Keseluruhan</td>
                                <td align="right">Rp.{{ number_format($totalGajiBersih, 0, ",", ".") }},-</td>
                                <td align="right">Rp.{{ number_format($totalGajiKotor, 0, ",", ".") }},-</td>
                                <?php
                            }
                        }
                        ?>
                        <td colspan="<?php echo ((in_array(26, $usermatrik)) ? (Session::get("user.tipe") == 0 ? 7 : 8) : 8) ?>" align="right" class="">Total Omzet</td>
                        <td align="right" class="cell">Rp.{{ number_format($totalOmzet, 0, ",", ".") }},-</td>
                    </tr>
                </tbody>
            </table>
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
    });
</script> 
@stop



