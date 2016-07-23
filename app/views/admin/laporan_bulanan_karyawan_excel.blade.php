<html>
    {{ HTML::style('css/tableCSS.css') }}
    <table class="table table-bordered table-hover" id="" border="1">
        <thead>
            <tr>
                <th class="text-center cell"></th>
                <th class="text-center cell">Gaji Bersih</th>
                <th class="text-center cell">Gaji Kotor</th>
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
                <td colspan="10" class="cell">&nbsp;</td>
            </tr>
            <?php $totalOmzet = 0; ?>
            @foreach($laporans as $laporan)
            <tr>
                <td class="cell">{{ $laporan["nama"] }}</td>
                <td class="cell">{{ $laporan["gajibersih"] }}</td>
                <td class="cell">{{ $laporan["gajikotor"] }}</td>
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
                ?>
            </tr>
            @endforeach
            <tr>
                <td colspan="10" class="cell">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="8" align="right" class="">Total Omzet</td>
                <td align="right" class="cell">{{ $totalOmzet }}</td>
                <td class="cell"></td>
            </tr>
        </tbody>
    </table>
</html>