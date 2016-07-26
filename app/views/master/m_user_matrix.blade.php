@extends('template.master')

@section('title')
<title>ABSENSI - User Matrix</title>
@stop

@section('header')
<h1 class="page-header">USER MATRIX
    <small>DAFTAR KARYAWAN</small>
</h1>
@stop

@section('main')
<div class="row">
    <div class="panel panel-default">
        <div class="panel-body">
            <form action="<?php echo action("MasterKaryawanController@usermatrixsave", [$id]) ?>" method="POST" class="form-horizontal">
                <div class="form-group">        
                    @foreach ($usermatrixs as $usermatrix)
                    <div class="checkbox col-md-4">
                        <label><input type="checkbox" name="matrix{{ $usermatrix->idmnu }}" value="{{ $usermatrix->idmnu }}" <?php
                            if ($maks > 0 && $usermatrix->idmnu == $matrixs[$counter]->mm01_id) {
                                echo "checked";
                                if ($counter < $maks - 1) {
                                    $counter++;
                                }
                            }
                            ?> >{{ $usermatrix->nama }}</label>
                    </div>
                    @endforeach
                </div>
                <div class="form-group">
                    &nbsp;&nbsp;&nbsp;{{ Form::submit('Simpan', array('class'=>'btn btn-primary btn-large center siku')) }}
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('script')
<script type="text/javascript">

</script> 
@stop



