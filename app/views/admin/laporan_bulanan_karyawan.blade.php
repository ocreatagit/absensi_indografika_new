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
                    <?php $totalOmzet = 0; ?>
                    @foreach($laporans as $laporan)
                    <tr>
                        <td>{{ $laporan["nama"] }}</td>
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
                        ?>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="9">&nbsp;</td>
                    </tr>
                    <tr style="background-color: lightblue; color: black">
                        <td colspan="8" align="right">Total Omzet</td>
                        <td>Rp.{{ number_format($totalOmzet, 0, ",", ".") }},-</td>
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



