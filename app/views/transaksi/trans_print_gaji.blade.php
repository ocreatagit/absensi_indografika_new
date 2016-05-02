<html>
    <head>
        <title>Print Slip Gaji - {{ $karyawan->nama }}</title>
        <style>
            .tablePrint {
                border-collapse: collapse;
                width: 100%;
            }

            .tablePrint th {
                height: 30px;
            } 

            .tablePrint, .tablePrint th, .tablePrint td {
                border: 1px solid black;
            }

            .notable {
                border-collapse: collapse;
            }

            .width100{
                width: 100%;
            }

            .notable, .notable th, .notable td {
                border: none;
            }
        </style>
    </head>
    <body>
        <table class="tablePrint">
            <tr>
                <td rowspan="6" width='10%' class="" style="padding-left: 7px; padding-right: 5px;">
                    <img src="{{ asset('uploads/'.$karyawan->pic); }}" class="" width="120" height="">
                </td>
                <td width='45%' style="padding-left: 10px;">Nama : {{ $karyawan->nama }}</td>
                <td width='45%'>
                    <table class="notable width100">
                        <tr>
                            <td align='right' style="border-bottom: #000 solid 1px; padding-right: 10px;">Tanggal : </td>
                            <td style="border-bottom: #000 solid 1px;">{{ strftime('%d-%b-%Y', strtotime($gaji->tgltg)) }}</td>
                        </tr>
                        <tr>
                            <td align='right' style="padding-right: 10px;">No Slip Gaji : </td>
                            <td style="">{{ $gaji->nortg }} </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding-left: 10px;">
                    <big><b>Informasi Jam Kerja</b></big>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding-left: 10px;">
                    <table class="notable">
                        <tr>
                            <td colspan="2" style="height: 10px;"></td>
                        </tr>
                        <tr>
                            <td align='right'>Total Kehadiran : </td>
                            <td>{{ $kehadiran }} Hari </td>
                        </tr>                        
                        <tr>
                            <td align='right'>Total Durasi Bekerja : </td>
                            <td>
                                <?php
                                $durasiBekerjaJam = floor($durasiBekerja / 3600);
                                $durasiBekerjaMenit = $durasiBekerjaJam % 3600;
                                $durasiBekerjaMenit = floor(($durasiBekerjaMenit / 60));
                                ?>
                                {{ $durasiBekerjaJam }} Jam {{ $durasiBekerjaMenit }} Menit 
                            </td>
                        </tr>
                        <tr>
                            <td align='right'>Terlambat : </td>
                            <td>{{ $durasiLambat }} Menit </td>
                        </tr>
                        <tr>
                            <td align='right'>Total Omzet Individu : </td>
                            <td>Rp.{{ number_format($omzetIndividu,0,',','.') }},- </td>
                        </tr>
                        <tr>
                            <td align='right'>Total Omzet Tim : </td>
                            <td>
                                <?php
                                if (count($referrals) > 1) {
                                    ?>
                                    Rp.{{ number_format($omzetTim,0,',','.') }},-
                                <?php } else {
                                    ?>
                                    Rp.{{ number_format(0,0,',','.') }},-
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>                        
                        <tr>
                            <td colspan="2" style="height: 10px;"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr></tr>
            <tr></tr>
            <tr></tr>
            <tr></tr>
            <tr>
                <td colspan="2">
                    <table class="notable" style="width: 100%;">
                        <tr style="">
                            <td style="padding-left: 10px;" colspan="2"><big><b>Informasi Gaji</b></big></td>
                        </tr>
                        <?php
                        // Deklarasi variable GajiKotor
                        $gajikotor = 0;
                        ?>
                        @foreach($infogajis as $infogaji)
                        <tr style="">
                            <td style="text-align: right; padding-left: 10px; width: 40%;">{{ $infogaji->jenis }} : </td>
                            <td style="width: 60%; padding-left: 10px;">
                                <?php
                                if ($infogaji->jntgh == "Hari" || $infogaji->jntgh == "Jam") {
                                    $jam = floor($infogaji->jmtgh / 3600);
                                    $menit = $jam % 3600;
                                    $menit = floor(($menit / 60));
                                } else {
                                    $jam = $gaji->jmtgh;
                                }
                                if ($infogaji->jmtgh == null) {
                                    $totalTagih = 0;
                                } else {
                                    $totalTagih = $infogaji->hari * $infogaji->nilgj;
                                }

                                // Akumulasi nilai gaji kotor
                                $gajikotor += $totalTagih;
                                ?>
                                Rp.{{ number_format($totalTagih,0,',','.') }},-
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td style="text-align: right; padding-left: 10px; width: 40%;">Komisi Individu : </td>
                            <td style="width: 60%; padding-left: 10px;">
                                Rp.{{ number_format((($karyawan->kmindv * $omzetIndividu) / 100),0,',','.') }},-
                                <?php
                                $gajikotor += (($karyawan->kmindv * $omzetIndividu) / 100);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right; padding-left: 10px; width: 40%;">Komisi Tim : </td>
                            <td style="width: 60%; padding-left: 10px;">
                                <?php
                                if (count($referrals) > 1) {
                                    $bool = FALSE;
                                    foreach ($referrals as $key => $val) {
                                        if ($val->mk01_id_child == $karyawan->idkar && $val->flglead == "Yes") {
                                            $bool = TRUE;
                                            break;
                                        }
                                    }
                                    if ($bool == FALSE) {
                                        $omzetTim = 0;
                                    }
                                    ?>
                                    Rp.{{ number_format((($karyawan->kmtim * $omzetTim) / 100),0,',','.') }},-
                                    <?php
                                    $gajikotor += (($karyawan->kmtim * $omzetTim) / 100);
                                } else {
                                    ?>
                                    Rp.{{ number_format(0,0,',','.') }},-
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right; padding-left: 10px; width: 40%;">Total Bonus : </td>
                            <td style="width: 60%; padding-left: 10px;">
                                Rp.{{ number_format($gaji->ttlbns ,0,',','.') }},-
                            </td>
                        </tr>
                </table>
            </td>
            <td>
                <table class="notable" style="width: 100%;">
                    <?php
                            // Deklarasi variable GajiKotor
                            $totalpinjaman = 0;

                            // akumulasi nilai totalpinjaman
                            if (count($infohutang) != 0) {
                                $totalpinjaman += $infohutang[0]->nilph;
                            }
                            if (count($infokasbon) != 0) {
                                $totalpinjaman += $infokasbon[0]->nilph;
                            }
                            if (count($infotabungan) != 0) {
                                $totalpinjaman += $infotabungan[0]->niltb;
                            }
                            ?>
                    <tr style="">
                        <td style="text-align: left; padding-left: 10px;" colspan="2"><span style="position: absolute; top: 203px;"><big><b>Total Pinjaman</b></big></span></td>
                    </tr>
                    <tr>
                        <td style="text-align: right; padding-left: 10px; width: 40%;">Hutang : </td>
                        <td style="width: 60%; padding-left: 10px;">
                            <?php
                            $total = count($infohutang) != 0 ? $infohutang[0]->nilph : 0;
                            ?>
                            Rp.{{ number_format($total,0,',','.') }},-<?php if (count($infohutang) != 0) { ?>(Angsuran {{ strftime("%d-%b-%Y", strtotime($infohutang[0]->tglph)) }})<?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right; padding-left: 10px; width: 40%;">Kasbon : </td>
                        <td style="width: 60%; padding-left: 10px;">
                            Rp.{{ number_format(($infokasbon != null ? $infokasbon[0]->nilph : 0),0,',','.') }},-
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right; padding-left: 10px; width: 40%;">Tabungan : </td>
                        <td style="width: 60%; padding-left: 10px;">
                            Rp.{{ number_format(($infotabungan != null ? $infotabungan[0]->niltb : 0),0,',','.') }},-
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <?php
        // Deklarasi variable GajiKotor
        $totalpinjaman = 0;

        // akumulasi nilai totalpinjaman
        if (count($infohutang) != 0) {
            $totalpinjaman += $infohutang[0]->nilph;
        }
        if (count($infokasbon) != 0) {
            $totalpinjaman += $infokasbon[0]->nilph;
        }
        if (count($infotabungan) != 0) {
            $totalpinjaman += $infotabungan[0]->niltb;
        }
        ?>
        
        <?php
        $totalgaji = 0;
        ?>
        @foreach($infogajis as $infogaji)
        <?php
        if ($infogaji->jntgh == "Hari" || $infogaji->jntgh == "Jam") {
            $jam = floor($infogaji->jmtgh / 3600);
            $menit = $jam % 3600;
            $menit = floor(($menit / 60));
        } else {
            $jam = $gaji->jmtgh;
        }
        if ($infogaji->jmtgh == null) {
            $totalTagih = 0;
        } else {
            $totalTagih = $infogaji->hari * $infogaji->nilgj;
        }
        $totalgaji += $totalTagih;

        $omtim = (($karyawan->kmtim * $omzetTim) / 100);
        if (count($referrals) < 1) {
            $omtim = 0;
        }
        ?>
        @endforeach
        <tr>
            <td colspan="2" align='right' style="padding-right: 10px">
                Total Gaji Kotor :
            </td>
            <td style="padding-left: 10px;">
                Rp.{{ number_format($gajikotor,0,',','.') }},-
            </td>
        </tr>
        <tr>
            <td colspan="2" align='right' style="padding-right: 10px">
                Total Pinjaman :
            </td>
            <td style="padding-left: 10px;">
                Rp.{{ number_format($totalpinjaman,0,',','.') }},-
            </td>
        </tr>
        <tr>
            <td colspan="2" align='right' style="padding-right: 10px">
                Total Gaji :
            </td>
            <td style="padding-left: 10px;">
                Rp.{{ number_format(($totalgaji + $gaji->ttlbns + (($karyawan->kmindv * $omzetIndividu) / 100) + $omtim) - $totalpinjaman,0,',','.') }},-
            </td>
        </tr>
</table>
</body>
</html>
