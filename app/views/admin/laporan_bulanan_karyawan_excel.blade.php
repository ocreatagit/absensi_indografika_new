<html>
    {{ HTML::style('css/tableCSS.css') }}
    <table class="table table-bordered table-hover" id="" border="1">
        <thead>
            <tr>
                <th class="text-center cell"></th>
                <th class="text-right">Pembayaran</th>
                <?php
                if (in_array(26, $usermatrik)) {
                    if (Session::get("user.tipe") == 0) {
                        ?>
                        <th class="text-right">No Rekening 1</th>
                        <th class="text-center cell">Gaji Bersih</th>
                        <th class="text-center cell">Gaji Kotor</th>
                        <?php
                    }
                }
                ?>
                <th class="text-center cell">Msk</th>
                <th class="text-center cell">Lbr</th>
                <th class="text-center cell">Aph</th>
                <th class="text-center cell">Cuti</th>
                <th class="text-center cell">Telat/Menit</th>
                <th class="text-center cell">Kasbon</th>
                <th class="text-center cell">Hutang</th>
                <th class="text-center cell">Omzet</th>
                <th class="text-center cell">Keterangan</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <tr>
                <td colspan="<?php echo ((in_array(26, $usermatrik)) ? (Session::get("user.tipe") == 0 ? 14 : 9) : 9) ?>" class="cell">&nbsp;</td>
            </tr>
            <?php
            $totalOmzet = 0;
            $totalGajiBersih = 0;
            $totalGajiKotor = 0;
            ?>
            @foreach($laporans as $laporan)
            <tr>
                <td class="cell">{{ $laporan["nama"] }}</td>
                <td align="cell">{{ $laporan["bln_pembayaran"] }}</td>
                <?php
                if (in_array(26, $usermatrik)) {
                    if (Session::get("user.tipe") == 0) {
                        ?>
                        <td align="right">{{ $laporan["norek1"] }}</td>
                        <td class="cell">{{ $laporan["gajibersih"] }}</td>
                        <td class="cell">{{ $laporan["gajikotor"] }}</td>
                        <?php
                    }
                }
                ?>
                <td class="cell">{{ $laporan["msk"] }}</td>
                <td class="cell">
                    <?php
                    $jam = round(($laporan["lbr"] / 3600) * 2) / 2;
                    echo ($jam);
                    ?>
                </td>
                <td class="cell">{{ $laporan["aph"] }}</td>
                <td class="cell">{{ $laporan["cuti"] }}</td>
                <td class="cell">{{ $laporan["telat"] }}</td>
                <td align="right" class="cell">{{ $laporan["kasbon"] }}</td>
                <td align="right" class="cell">{{ $laporan["hutang"] }}</td>
                <td align="right" class="cell">{{ $laporan["omzet"] }}</td>
                <td class="cell"></td>
                <?php
                $totalOmzet += $laporan["omzet"];
                $totalGajiBersih += $laporan["gajibersih"];
                $totalGajiKotor += $laporan["gajikotor"];
                ?>
            </tr>
            @endforeach
            <tr>
                <td colspan="<?php echo ((in_array(26, $usermatrik)) ? (Session::get("user.tipe") == 0 ? 14 : 9) : 9) ?>" class="cell">&nbsp;</td>
            </tr>
            <tr>
                <?php
                if (in_array(26, $usermatrik)) {
                    if (Session::get("user.tipe") == 0) {
                        ?>
                        <td colspan="3">Total Keseluruhan</td>
                        <td>{{ $totalGajiBersih }}</td>
                        <td>{{ $totalGajiKotor }}</td>
                        <?php
                    }
                }
                ?>
                <td colspan="<?php echo ((in_array(26, $usermatrik)) ? (Session::get("user.tipe") == 0 ? 7 : 8) : 8) ?>" align="right" class="">Total Omzet</td>
                <td align="right" class="cell">Rp.{{ number_format($totalOmzet, 0, ",", ".") }},-</td>
                <td class="cell"></td>
            </tr>
        </tbody>
    </table>
</html>