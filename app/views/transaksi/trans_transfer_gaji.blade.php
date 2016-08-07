@extends('template.master')

@section('title')
<title>ABSENSI - Input Data</title>
@stop

@section('header')
<h1 class="page-header">Input Data
    <small>Pembayaran Gaji</small>
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
            <form action="{{ action("TransaksiTransferController@saveall") }}" method="POST">
                <div class="panel panel-heading">
                    <button class="btn btn-success siku pull-right" type="submit" value="bayar" name="btn_submit" data-toggle="tooltip" data-placement="left" title="Buat Transaksi yang Dipilih?"><i class="fa fa-check-circle"></i> Transfer Slip Gaji</button>
                    <br><br>
                </div>
                <div class="panel-body">
                    <div id="lbl_selected" class="alert alert-info">
                        <b><span id="text_selected"></span> </b>
                    </div>

                    <div class="col-sm-12">
                        <div style="">
                            <table class="table table-bordered table-hover" id="datatable">
                                <thead>
                                    <tr>
                                        <th class="text-left">No</th>
                                        <th class="text-left">Tanggal</th>
                                        <th class="text-left">Karyawan</th>
                                        <th class="text-left">Total Gaji yang Dibayarkan</th>
                                        <th class="text-left">Status <br> Pembayaran</th>
                                        <th class="text-left">Opsi</th>
                                        <th class="text-center">Pilih <input type="checkbox" name="chk" id="chk"/> </th>
                                    </tr>
                                </thead>
                                <tbody class="text-left">
                                    <?php $no = 1; ?>
                                    @foreach($gajis as $gaji)
                                    <tr>
                                        <td>
                                            {{ $gaji->nortg }}
                                        </td>
                                        <td>{{ strftime("%d-%b-%Y", strtotime($gaji->tgltg)) }}</td>
                                        <td>{{ $gaji->nama }}</td>
                                        <td>Rp.{{ number_format($gaji->ttlgj,0, ',','.') }} + <span class="blue">Rp.{{ number_format($gaji->ttlbns,0, ',','.') }} (Bonus)</span></td>
                                        <?php
                                        if ($gaji->status == "N") {
                                            ?>
                                            <td class="red"><i class='fa fa-exclamation-circle'></i> Belum Terbayar</td>
                                            <?php
                                        } else {
                                            ?>
                                            <td class="green"><i class='fa fa-check-circle green'></i> Gaji Telah Dibayarkan</td>
                                            <?php
                                        }
                                        ?>
                                        <td class="text-center" width="15%">
                                            <a href="{{ action('TransaksiTransferController@show', [$gaji->idtg]) }}" class="btn btn-info" data-toggle="tooltip" data-placement="left" title="Detail?"><i class="fa fa-info-circle"></i></a>                                    
                                            <a href="{{ action('TransaksiTransferController@payment', [$gaji->idtg]) }}" class="btn btn-success {{ $gaji->status == "N" ? "" : "disabled" }}" data-toggle="tooltip" data-placement="left" title="Bayar Gaji?">{{ $gaji->status == "N" ? '<i class="fa fa-money"></i>' : '<i class="fa fa-check"></i>' }}</a>                                    
                                            <a target="_blank" href="{{ action('TransaksiTransferController@printgaji', [$gaji->idtg]) }}" class="btn btn-default {{ $gaji->status == "Y" ? "" : "disabled" }}" data-toggle="tooltip" data-placement="left" title="Cetak Slip Gaji?"><i class="fa fa-print"></i></a>
                                            <?php $no++; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($gaji->status == "Y") {
                                                ?>
                                                <input type="checkbox" name="" class="siku" disabled=""/>
                                                <?php
                                            } else {
                                                ?>
                                                <input type="checkbox" onchange="getSelectedItem()" name="chkitem[]" class="chkitem siku" value="{{ $gaji->idtg }}"/>
                                            <?php }
                                            ?>
                                        </td>
                                    </tr>
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
    $(document).ready(function () {
        $('.clockpicker').clockpicker({
            placement: 'bottom',
            align: 'left',
            donetext: 'Done'
        });
        $('#datatable').DataTable({
            "paging": false, // next page
            "ordering": true, // order by at header 
            "info": false,
            "order": [[1, 'desc']],
            fixedHeader: {
                headerOffset: $('.navbar').outerHeight()
            },
        });

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
    });

    function getSelectedItem() {
        if ($(".chkitem:checked").length == 0) {
            $("#lbl_selected").hide();
        } else {
            $("#lbl_selected").show();
            $("#text_selected").html($(".chkitem:checked").length + " Item Selected");
        }
    }
</script> 
@stop



