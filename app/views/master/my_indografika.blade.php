@extends('template.master')

@section('title')
<title>ABSENSI - Jabatan</title>
@stop

@section('header')
<h1 class="page-header">My Indografika
</h1>
@stop

@section('main')
<div class="row">
    <div class="col-sm-2" style="margin-right: 20px;">
        <img src="http://placehold.it/200x250">
    </div>
    <div class="col-sm-7">
        <div class="panel panel-default">
            <div class="panel-heading">William</div>
            <div class="panel-body">
                <table class="col-sm-6">
                    <tr>
                        <td class="col-sm-6" >Kode Absensi</td>
                        <td style="text-align: left">{{ $idkar }}</td>
                    </tr>
                </table>
                <br>
                <br>
                <form class="form-horizontal" action="#">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Periode</label>
                        <div class="col-sm-3 input-group ">
                            <input type="text" class="form-control" value="">  
                        </div>
                    </div>                               
                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-3 input-group ">                                        
                            <button class="btn btn-success">Pilih</button>
                        </div>
                    </div>                               
                </form>    
                <hr>
                <h2>Absensi Bulan Ini</h2>
                <table class="table" id="datatable">
                    <thead>
                        <tr>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Jam Masuk</th>
                            <th class="text-center">Jam Istirahat</th>
                            <th class="text-center">Jam Pulang</th>
                            <th class="text-center">Telat/menit</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr>
                            <td>01-01-2016</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>02-01-2016</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>03-01-2016</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>04-01-2016</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>05-01-2016</td>
                            <td>08.00</td>
                            <td>13.00</td>
                            <td>17.00</td>
                            <td><?php echo number_format(10, 0, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <td>06-01-2016</td>
                            <td>08.05</td>
                            <td>13.50</td>
                            <td>17.08</td>
                            <td><?php echo number_format(7, 0, ',', '.') ?></td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-sm-2">
        <div class="panel panel-default">
            <div class="panel-heading">William</div>
            <div class="panel-body">
                <p>Alpha : 1 hari</p>
                <p>Cuti : 3 hari</p>
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
    });
</script> 
@stop



