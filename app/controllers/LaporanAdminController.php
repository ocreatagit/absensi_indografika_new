<?php

class LaporanAdminController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

    // ------------------- Gaji ------------------- //

    public function histori_pembayaran_gaji() {
        $var = User::loginCheck([0, 1], 19);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        $mk01 = new mk01();
        $tg01 = new tg01();
        $data = array();
        $data['karyawans'] = $mk01->getKaryawanAktif();
        $data["gajis"] = $tg01->getGajiStatusN('', '', 0);
        $data['filter'] = Session::get('filter');
        $data['usermatrik'] = User::getUserMatrix();
        return View::make('admin.gaji_karyawan', $data);
    }

    public function show_gaji($id) {
        $var = User::loginCheck([0, 1], 19);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        $tg01 = tg01::find($id);
        $tg02 = new tg02();
        $th01 = new th01();
        $tt01 = new tt01();
        $tz01 = new tz01();
        $mk01 = new mk01();

        $karyawan = mk01::find($tg01->idkar);
        $data = array(
            "karyawan" => $karyawan,
            "kehadiran" => $tg01->getKehadiranGaji($tg01->tglgjsblm, $tg01->idkar),
            "durasiBekerja" => $tg01->getDurasiBekerjaGaji($tg01->tglgjsblm, $tg01->idkar),
            "durasiLembur" => $tg01->getDurasiLemburGaji($tg01->tglgjsblm, $tg01->idkar),
            "durasiLambat" => $tg01->getKeterlambatan($tg01->tglgjsblm, $tg01->idkar),
            "gaji" => $tg01,
            "gajis" => $tg02->getDetailGajiKaryawan($id),
            "infogajis" => $tg01->getJamKerjaInSec($tg01->idkar, $tg01->tglgjsblm),
            "infohutang" => $th01->getHutangBulan($tg01->idkar, $tg01->tgltg),
            "infokasbon" => $th01->getKasBonBulan($tg01->idkar, $tg01->tgltg),
            "infotabungan" => $tt01->getTabunganGaji($tg01->idkar, $tg01->tgltg),
            "omzetIndividu" => $tz01->getOmzetIndividu($tg01->idkar, $tg01->tgltg),
            "omzetTim" => $tz01->getOmzetTim($tg01->idkar, $tg01->tgltg),
            "referrals" => $mk01->getReferralKar($tg01->idkar),
            "usermatrik" => User::getUserMatrix()
        );
        return View::make('admin.gaji_karyawan_detail', $data);
    }

    public function histori_pembayaran_gaji_query() {
        $var = User::loginCheck([0, 1], 19);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        // 1. setting validasi
        $messages = array(
            'required' => 'Inputan <b>Tidak Boleh Kosong</b>!',
            'numeric' => 'Inputan <b>Harus Angka</b>!',
            'same' => 'Password <b>Tidak Sama</b>!'
        );

        $validator = Validator::make(
                        Input::all(), array(
                    "tahun_awal" => "required|numeric",
                    "tahun_akhir" => "required|numeric"
                        ), $messages
        );

        // 2a. jika semua validasi terpenuhi simpan ke database
        if ($validator->passes()) {
            $month = Input::get("bulan");
            $month2 = Input::get("bulan2");
            $year_awal = Input::get("tahun_awal");
            $year_akhir = Input::get("tahun_akhir");
            $status = Input::get("status");
            $idkar = Input::get("idkar");

            $tg01 = new tg01();
            $mk01 = new mk01();
            $karyawan = mk01::find($idkar);
            if ($idkar == 0) {
                $nama = "Semua Karyawan";
            } else {
                $nama = $karyawan->nama;
            }

            $data["karyawans"] = $mk01->getKaryawanAktif();
            $status = ($status == "A" ? '%' : $status);

            $data["gajis"] = $tg01->getGajiStatusNMonthYear($month, $month2, $year_awal, $year_akhir, $idkar, $status);

            setlocale(LC_ALL, 'IND');
            $monthname = strftime('%B', strtotime("2016-" . $month . "-01"));
            $monthname2 = strftime('%B', strtotime("2016-" . $month2 . "-01"));

            $flash = 'Pencarian Gaji <b>' . $nama . '</b> dengan status <b>' .
                    ($status == "Y" ? "Terbayar" : "Belum Terbayar") . '</b> Pada Bulan <b>'
                    . $monthname . ' ' . $year_awal . ' - ' . $monthname2 . ' ' . $year_akhir . '</b>';

            if (intval($year_awal) > intVal($year_akhir)) {
                $flash = "Filter Pencarian Tidak Valid!";
            } else if(intval($year_awal) == intVal($year_akhir)) {
                if ($month > $month2) {
                    $flash = "Filter Pencarian Tidak Valid!";
                    Session::flash('filter2', $flash);
                } else {
                    Session::flash('filter', $flash);
                }
            } else {
                Session::flash('filter', $flash);
            }

            $data['filter'] = Session::get('filter');
            $data['filter2'] = Session::get('filter2');
            $data['usermatrik'] = User::getUserMatrix();
            return View::make('admin.gaji_karyawan', $data);
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('admin/allgajikaryawan')
                            ->withErrors($validator)
                            ->withInput();
        }
    }

    // ------------------- END Gaji ------------------- //
    // ------------------- Tabungan ------------------- //
    public function histori_tabungan() {
        $var = User::loginCheck([0, 1], 20);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        $tt01 = new tt01();
        $mk01 = new mk01();
        $data = array(
            "karyawans" => $mk01->getKaryawanAktif(),
            "allTabungans" => $tt01->getAllTabunganKaryawan(),
            "usermatrik" => User::getUserMatrix()
        );
        return View::make('admin.tabungan_karyawan', $data);
    }

    public function show_tabungan($idkar) {
        $var = User::loginCheck([0, 1], 20);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        $tt01 = new tt01();
        $tglfrom = "";
        $tglto = "";
        $data = array(
            "karyawan" => mk01::find($idkar),
            "allTabungans" => $tt01->getAllTabungan($tglfrom, $tglto, $idkar),
            "usermatrik" => User::getUserMatrix()
        );
        return View::make('admin.tabungan_karyawan_detail', $data);
    }

    public function histori_tabungan_query() {
        $var = User::loginCheck([0, 1], 20);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        // 1. setting validasi
        $messages = array(
            'required' => 'Inputan <b>Tidak Boleh Kosong</b>!',
            'numeric' => 'Inputan <b>Harus Angka</b>!',
            'same' => 'Password <b>Tidak Sama</b>!'
        );

        $validator = Validator::make(
                        Input::all(), array(
                    "tglfrom" => "required",
                    "tglto" => "required"
                        ), $messages
        );

        // 2a. jika semua validasi terpenuhi simpan ke database
        if ($validator->passes()) {
            $tglfrom = Input::get("tglfrom");
            $tglto = Input::get("tglto");
            $idkar = Input::get("idkar");

            $userloginid = Session::get("user");
            $tt01 = new tt01();
            $data = array();
            $data["karyawan"] = mk01::find($idkar);
            $data["allTabungans"] = $tt01->getAllTabungan(date("Y-m-d", strtotime($tglfrom)), date("Y-m-d", strtotime($tglto)), $idkar);
            Session::flash('filter', 'Pencarian Tabungan Pada Tanggal <b>' . $tglfrom . ' s/d ' . $tglto . '</b>');

            $data['filter'] = Session::get('filter');
            $data['usermatrik'] = User::getUserMatrix();
            return View::make('admin.tabungan_karyawan_detail', $data);
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('myindografika/tabungankaryawan')
                            ->withErrors($validator)
                            ->withInput();
        }
    }

    // ------------------- END Tabungan ------------------- //
    // ------------------- Hutang ------------------- //

    public function histori_hutang() {
        $var = User::loginCheck([0, 1], 21);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        $userloginid = Session::get("user");
        $th01 = new th01();
        $tglfrom = "";
        $tglto = "";
        $jenis = "Hutang";
        $status = "N";
        $mk01 = new mk01();
        $data = array(
            "karyawans" => $mk01->getKaryawanAktif(),
            "allHutangs" => $th01->getAllHutang($tglfrom, $tglto, 0, $jenis, $status),
            "usermatrik" => User::getUserMatrix()
        );
        return View::make('admin.pinjaman_karyawan', $data);
    }

    public function histori_hutang_query() {
        $var = User::loginCheck([0, 1], 21);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        // 1. setting validasi
        $messages = array(
            'required' => 'Inputan <b>Tidak Boleh Kosong</b>!',
            'numeric' => 'Inputan <b>Harus Angka</b>!',
            'same' => 'Password <b>Tidak Sama</b>!'
        );

        $validator = Validator::make(
                        Input::all(), array(
                    "tglfrom" => "required",
                    "tglto" => "required"
                        ), $messages
        );

        // 2a. jika semua validasi terpenuhi simpan ke database
        if ($validator->passes()) {
            $tglfrom = Input::get("tglfrom");
            $tglto = Input::get("tglto");
            $status = Input::get("status");
            $jenis = Input::get("jenis");
            $idkar = Input::get("idkar");

            $th01 = new th01();
            $data = array();
            $mk01 = new mk01();
            $karyawan = mk01::find($idkar);
            if ($idkar == 0) {
                $nama = "Semua Karyawan";
            } else {
                $nama = $karyawan->nama;
            }
            $data["karyawans"] = $mk01->getKaryawanAktif();
            $data["allHutangs"] = $th01->getAllHutang(date("Y-m-d", strtotime($tglfrom)), date("Y-m-d", strtotime($tglto)), $idkar, $jenis, $status);
            Session::flash('filter', 'Pencarian Pinjaman <b> (' . $jenis . ') ' . $nama . ' ' . '</b> dengan status <b>' . ($status == "Y" ? "Lunas" : "Belum Lunas") . '</b> Pada Tanggal <b>' . $tglfrom . ' s/d ' . $tglto . '</b>');

            $data['filter'] = Session::get('filter');
            $data['usermatrik'] = User::getUserMatrix();
            return View::make('admin.pinjaman_karyawan', $data);
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('admin/allpinjamankaryawan')
                            ->withErrors($validator)
                            ->withInput();
        }
    }

    public function show_pinjaman($idhut) {
        $var = User::loginCheck([0, 1], 21);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        $userloginid = Session::get("user");
        $th01 = new th01();
        $hutang = th01::find($idhut);
        $data = array(
            "karyawan" => mk01::find($hutang->idkar),
            "hutang" => $hutang,
            "detail_hutangs" => $th01->getDetailHutang($idhut),
            "usermatrik" => User::getUserMatrix()
        );
        return View::make('admin.pinjaman_karyawan_detail', $data);
    }

    // ------------------- END Hutang ------------------- //
    // ------------------- Omzet ------------------- //
    public function histori_omzet() {
        $var = User::loginCheck([0, 1], 22);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        $userloginid = Session::get("user");
        $tz01 = new tz01();
        $tglfrom = "";
        $tglto = "";
        $mk01 = new mk01();
        $data = array(
            "karyawans" => $mk01->getKaryawanAktif(),
            "allOmzets" => $tz01->getAllOmzet($tglfrom, $tglto, 0),
            "usermatrik" => User::getUserMatrix()
        );
        return View::make('admin.omzet_karyawan', $data);
    }

    public function histori_omzet_query() {
        $var = User::loginCheck([0, 1], 22);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        // 1. setting validasi
        $messages = array(
            'required' => 'Inputan <b>Tidak Boleh Kosong</b>!',
            'numeric' => 'Inputan <b>Harus Angka</b>!',
            'same' => 'Password <b>Tidak Sama</b>!'
        );

        $validator = Validator::make(
                        Input::all(), array(
                    "tglfrom" => "required",
                    "tglto" => "required"
                        ), $messages
        );

        // 2a. jika semua validasi terpenuhi simpan ke database
        if ($validator->passes()) {
            $tglfrom = Input::get("tglfrom");
            $tglto = Input::get("tglto");
            $idkar = Input::get("idkar");

            $tz01 = new tz01();
            $mk01 = new mk01();
            $karyawan = mk01::find($idkar);

            if ($idkar == 0) {
                $nama = "Semua Karyawan";
            } else {
                $nama = $karyawan->nama;
            }

            $data["karyawans"] = $mk01->getKaryawanAktif();
            $data["allOmzets"] = $tz01->getAllOmzet(date("Y-m-d", strtotime($tglfrom)), date("Y-m-d", strtotime($tglto)), $idkar);
            Session::flash('filter', 'Pencarian Omzet <b>' . $nama . '</b> Pada Tanggal <b>' . $tglfrom . ' s/d ' . $tglto . '</b>');

            $data['filter'] = Session::get('filter');
            $data['usermatrik'] = User::getUserMatrix();
            return View::make('admin.omzet_karyawan', $data);
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('admin/allomzetkaryawan')
                            ->withErrors($validator)
                            ->withInput();
        }
    }

    // ------------------- END Omzet ------------------- //
    // ------------------- Presensi ------------------- //

    public function presensi_karyawan() {
        $var = User::loginCheck([0, 1], 23);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        $userloginid = Session::get("user");
        $tglfrom = "";
        $tglto = "";
        $mk01 = new mk01();
        $data = array(
            "karyawans" => $mk01->getKaryawanAktif(),
            "usermatrik" => User::getUserMatrix(),
            "presensies" => Presensi::getPresensi(),
            "filter" => Session::get('filter')
        );
        return View::make('admin.presensi_karyawan', $data);
    }

    public function presensi_karyawan_query() {
        $var = User::loginCheck([0, 1], 23);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        $messages = array(
            'required' => 'Inputan <b>Tidak Boleh Kosong</b>!',
            'numeric' => 'Inputan <b>Harus Angka</b>!',
            'same' => 'Password <b>Tidak Sama</b>!'
        );

        $validator = Validator::make(
                        Input::all(), array(
                    "tglfrom" => "required",
                    "tglto" => "required"
                        ), $messages
        );

        if ($validator->passes()) {
            $tglfrom = Input::get("tglfrom");
            $tglto = Input::get("tglto");
            $idkar = Input::get("idkar");

            $karyawan = mk01::find($idkar);
            if ($idkar == 0) {
                $nama = "Semua Karyawan";
            } else {
                $nama = $karyawan->nama;
            }

            $userloginid = Session::get("user");
            $mk01 = new mk01();
            Session::flash('filter', 'Pencarian Presensi Karyawan <b>' . $nama . '</b> Pada Tanggal <b>' . $tglfrom . ' s/d ' . $tglto . '</b>');
            $data = array(
                "karyawans" => $mk01->getKaryawanAktif(),
                "usermatrik" => User::getUserMatrix(),
                "presensies" => Presensi::getPresensi($idkar, $tglfrom, $tglto),
                "filter" => Session::get('filter')
            );
            return View::make('admin.presensi_karyawan', $data);
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('admin/allpresensikaryawan')
                            ->withErrors($validator)
                            ->withInput();
        }
    }

    // ------------------- END Presensi ------------------- //
    // ------------------- Total Absensi ------------------- //
    public function total_absensi_karyawan() {
        $userloginid = Session::get("user");
        $tglfrom = "";
        $tglto = "";
        $mk01 = new mk01();
        $data = array(
            "karyawans" => $mk01->getKaryawanAktif(),
            "usermatrik" => User::getUserMatrix(),
            "presensies" => Presensi::getPresensi(),
            "filter" => Session::get('filter')
        );
        //total_absensi_karyawan
        return View::make('admin.presensi_karyawan', $data);
    }

    // ------------------- END Total Absensi ------------------- //
    // ------------------- Laporan Presensi + Hutang + Tabungan ------------------- //

    public function laporan_karyawan() {
        $var = User::loginCheck([0, 1], 26);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        $mk01 = new mk01();
        $mk03 = new mk03();
        $ta03 = new ta03();
        $tg01 = new tg01();
        $th01 = new th01();
        $tt01 = new tt01();
        $tz01 = new tz01();

        $data = array();
        $data['karyawans'] = $mk01->getKaryawanAktif();
        $data["allTabungans"] = $tt01->getAllTabunganKaryawan();
        $data["allOmzets"] = $tz01->getAllOmzet('', '', 0);
        $data["gajis"] = $tg01->getGajiStatusN('', '', 0);
        $data['filter'] = Session::get('filter');
        $data['usermatrik'] = User::getUserMatrix();
        $data['prsbns'] = $mk03->getNilKeterangan("prsbns");
        $data['maxtelat'] = $mk03->getNilKeterangan("maxtelat");

        $date = date("Y-m-d");

        $arrLaporan = array();
        foreach ($data['karyawans'] as $karyawan) {
            // ID Karyawan
            $temp["idkar"] = $karyawan->idkar;
            // Bulan Pembayaran
            $temp["bln_pembayaran"] = strftime("%B %Y", strtotime($date));
            // Nama Karyawan
            $temp["nama"] = $karyawan->nama;
            // No Rek 1
            $temp["norek1"] = $karyawan->norek1;
            // No Rek 2
            $temp["norek2"] = $karyawan->norek2;
            // Gaji Bersih
            $temp["gajibersih"] = $tg01->getGajiKaryawanBersih($date, $karyawan->idkar);
            // Gaji Kotor
            $temp["gajikotor"] = $tg01->getGajiKaryawanKotor($date, $karyawan->idkar);
            // Jam Masuk (Kehadiran) Karyawan
            $temp["msk"] = $tg01->getKehadiranGaji($date, $karyawan->idkar) + $ta03->getTotalAlpha($karyawan->idkar, $date, "Cuti");
            // Jam Lembur Karyawan (in second)
            $temp["lbr"] = $tg01->getDurasiLemburGaji($date, $karyawan->idkar);
            // Total Alpha
            $temp["aph"] = $ta03->getTotalAlpha($karyawan->idkar, $date, "Alpha");
            // Total Cuti
            $temp["cuti"] = $ta03->getTotalAlpha($karyawan->idkar, $date, "Cuti");
            // Telat
            $temp["telat"] = $tg01->getKeterlambatan($date, $karyawan->idkar);
            // Kasbon
            $temp["kasbon"] = $th01->getTotalHutangBulan($karyawan->idkar, $date);
            // Hutang
            $temp["hutang"] = $th01->getTotalKasBonBulan($karyawan->idkar, $date);
            // Omzet Karyawan
            $omzetIndividu = $tz01->getOmzetIndividu($karyawan->idkar, $date);
            $omzetTim = $tz01->getOmzetTim($karyawan->idkar, $date);
            $referrals = $mk01->getReferralKar($karyawan->idkar);
            $temp["omzet"] = $omzetIndividu;
            // Jenis User
            $temp["jnsusr"] = $karyawan->jnsusr;

            $temp["idtg"] = $tg01->getSlipGaji($date, $karyawan->idkar);
            $temp["status"] = $tg01->getStatusSlipGaji($date, $karyawan->idkar);

            array_push($arrLaporan, $temp);
        }

        $data['laporans'] = $arrLaporan;
        if (Session::get("user.tipe") == 0) {
            return View::make('admin.laporan_bulanan_karyawan', $data);
        } else {
            return View::make('admin.laporan_bulanan_karyawan_admin', $data);
        }
    }

    public function laporan_karyawan_query() {
        $var = User::loginCheck([0, 1], 26);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        $mk01 = new mk01();
        $mk03 = new mk03();
        $ta03 = new ta03();
        $tg01 = new tg01();
        $th01 = new th01();
        $tt01 = new tt01();
        $tz01 = new tz01();

        $bulan_start = Input::get("bln_start");
        $tahun_start = Input::get("thn_start");
        $bulan_end = Input::get("bln_end");
        $tahun_end = Input::get("thn_end");

        $date_start = $tahun_start . "-" . $bulan_start . "-01";
        $date_end = $tahun_end . "-" . $bulan_end . "-01";

        $d1 = new DateTime($date_start);
        $d2 = new DateTime($date_end);

        $month_diff = ($d1->diff($d2)->m);
//        dd($d1->diff($d2)->m + ($d1->diff($d2)->y * 12)); // int(8)
        $count = 1;
        if ($month_diff != 0) {
            $count = $month_diff + 1;
        }

        Session::put('lapbulan.bulanfrom', $bulan_start);
        Session::put('lapbulan.tahunfrom', $tahun_start);
        Session::put('lapbulan.bulanto', $bulan_end);
        Session::put('lapbulan.tahunto', $tahun_end);

        $data = array();
        $data['karyawans'] = $mk01->getKaryawanAktif();
        $data["allTabungans"] = $tt01->getAllTabunganKaryawan();
        $data["allOmzets"] = $tz01->getAllOmzet('', '', 0);
        $data["gajis"] = $tg01->getGajiStatusN('', '', 0);
        $data['usermatrik'] = User::getUserMatrix();
        $data['prsbns'] = $mk03->getNilKeterangan("prsbns");
        $data['maxtelat'] = $mk03->getNilKeterangan("maxtelat");

        $arrLaporan = array();
        for ($i = 0; $i < $count; $i++) {
            if ($i == 0) {
                $date = $date_start;
            } else {
                $date = date('Y-m-d', strtotime("+1 months", strtotime($date)));
            }
            foreach ($data['karyawans'] as $karyawan) {
                // ID Karyawan
                $temp["idkar"] = $karyawan->idkar;
                // Bulan Pembayaran
                $temp["bln_pembayaran"] = strftime("%B %Y", strtotime($date));
                // Nama Karyawan
                $temp["nama"] = $karyawan->nama;
                // No Rek 1
                $temp["norek1"] = $karyawan->norek1;
                // No Rek 2
                $temp["norek2"] = $karyawan->norek2;
                // Gaji Bersih
                $temp["gajibersih"] = $tg01->getGajiKaryawanBersih($date, $karyawan->idkar);
                // Gaji Kotor
                $temp["gajikotor"] = $tg01->getGajiKaryawanKotor($date, $karyawan->idkar);
                // Jam Masuk (Kehadiran) Karyawan
                $temp["msk"] = $tg01->getKehadiranGaji($date, $karyawan->idkar) + $ta03->getTotalAlpha($karyawan->idkar, $date, "Cuti");
                // Jam Lembur Karyawan (in second)
                $temp["lbr"] = $tg01->getDurasiLemburGaji($date, $karyawan->idkar);
                // Total Alpha
                $temp["aph"] = $ta03->getTotalAlpha($karyawan->idkar, $date, "Alpha");
                // Total Cuti
                $temp["cuti"] = $ta03->getTotalAlpha($karyawan->idkar, $date, "Cuti");
                // Telat
                $temp["telat"] = $tg01->getKeterlambatan($date, $karyawan->idkar);
                // Kasbon
                $temp["kasbon"] = $th01->getTotalHutangBulan($karyawan->idkar, $date);
                // Hutang
                $temp["hutang"] = $th01->getTotalKasBonBulan($karyawan->idkar, $date);
                // Omzet Karyawan
                $omzetIndividu = $tz01->getOmzetIndividu($karyawan->idkar, $date);
                $omzetTim = $tz01->getOmzetTim($karyawan->idkar, $date);
                $referrals = $mk01->getReferralKar($karyawan->idkar);

                $temp["omzet"] = $omzetIndividu;

                $temp["jnsusr"] = $karyawan->jnsusr;

                $temp["idtg"] = $tg01->getSlipGaji($date, $karyawan->idkar);
                $temp["status"] = $tg01->getStatusSlipGaji($date, $karyawan->idkar);

                array_push($arrLaporan, $temp);
            }
        }

        $data['laporans'] = $arrLaporan;

        if (Input::get("btn_filter")) {
            Session::flash('filter', "Pencarian Laporan Karyawan pada Bulan " . strftime("%B", strtotime($date_start)) . " " . $tahun_start . " s/d " . strftime("%B", strtotime($date_end)) . " " . $tahun_end);
            $data['filter'] = Session::get('filter');

            if (Session::get("user.tipe") == 0) {
                return View::make('admin.laporan_bulanan_karyawan', $data);
            } else {
                return View::make('admin.laporan_bulanan_karyawan_admin', $data);
            }
        } else if (Input::get("btn_export")) {
            $filename = 'Absensi ' . strftime("%B %Y", strtotime($date_start));
            Excel::create($filename, function($excel) {
                $bulan_start = Input::get("bln_start");
                $tahun_start = Input::get("thn_start");
                $bulan_end = Input::get("bln_end");
                $tahun_end = Input::get("thn_end");

                $date_start = $tahun_start . "-" . $bulan_start . "-01";

                $sheetname = strftime("%B-%Y", strtotime($date_start));

                $excel->sheet($sheetname, function($sheet) {

                    $mk01 = new mk01();
                    $tg01 = new tg01();
                    $ta03 = new ta03();
                    $tz01 = new tz01();
                    $th01 = new th01();

                    $bulan_start = Input::get("bln_start");
                    $tahun_start = Input::get("thn_start");
                    $bulan_end = Input::get("bln_end");
                    $tahun_end = Input::get("thn_end");

                    $date_start = $tahun_start . "-" . $bulan_start . "-01";
                    $date_end = $tahun_end . "-" . $bulan_end . "-01";

                    $d1 = new DateTime($date_start);
                    $d2 = new DateTime($date_end);

                    $month_diff = ($d1->diff($d2)->m);
                    $count = 1;
                    if ($month_diff != 0) {
                        $count = $month_diff + 1;
                    }

                    $data = array();
                    $data['karyawans'] = $mk01->getKaryawanAktif();
                    $data["gajis"] = $tg01->getGajiStatusN('', '', 0);
                    $data['filter'] = Session::get('filter');
                    $data['usermatrik'] = User::getUserMatrix();

                    $arrLaporan = array();
                    for ($i = 0; $i < $count; $i++) {
                        if ($i == 0) {
                            $date = $date_start;
                        } else {
                            $date = date('Y-m-d', strtotime("+1 months", strtotime($date)));
                        }
                        foreach ($data['karyawans'] as $karyawan) {
                            // ID Karyawan
                            $temp["idkar"] = $karyawan->idkar;
                            // Bulan Pembayaran
                            $temp["bln_pembayaran"] = strftime("%B %Y", strtotime($date));
                            // Nama Karyawan
                            $temp["nama"] = $karyawan->nama;
                            // No Rek 1
                            $temp["norek1"] = $karyawan->norek1;
                            // No Rek 2
                            $temp["norek2"] = $karyawan->norek2;
                            // Gaji Bersih
                            $temp["gajibersih"] = $tg01->getGajiKaryawanBersih($date, $karyawan->idkar);
                            // Gaji Kotor
                            $temp["gajikotor"] = $tg01->getGajiKaryawanKotor($date, $karyawan->idkar);
                            // Jam Masuk (Kehadiran) Karyawan
                            $temp["msk"] = $tg01->getKehadiranGaji($date, $karyawan->idkar);
                            // Jam Lembur Karyawan (in second)
                            $temp["lbr"] = $tg01->getDurasiLemburGaji($date, $karyawan->idkar);
                            // Total Alpha
                            $temp["aph"] = $ta03->getTotalAlpha($karyawan->idkar, $date, "Alpha");
                            // Total Cuti
                            $temp["cuti"] = $ta03->getTotalAlpha($karyawan->idkar, $date, "Cuti");
                            // Telat
                            $temp["telat"] = $tg01->getKeterlambatan($date, $karyawan->idkar);
                            // Kasbon
                            $temp["kasbon"] = $th01->getTotalHutangBulan($karyawan->idkar, $date);
                            // Hutang
                            $temp["hutang"] = $th01->getTotalKasBonBulan($karyawan->idkar, $date);
                            // Omzet Karyawan
                            $omzetIndividu = $tz01->getOmzetIndividu($karyawan->idkar, $date);
                            $omzetTim = $tz01->getOmzetTim($karyawan->idkar, $date);
                            $referrals = $mk01->getReferralKar($karyawan->idkar);

                            $temp["omzet"] = $omzetIndividu;

                            $temp["jnsusr"] = $karyawan->jnsusr;

                            $temp["idtg"] = $tg01->getSlipGaji($date, $karyawan->idkar);
                            $temp["status"] = $tg01->getStatusSlipGaji($date, $karyawan->idkar);

                            array_push($arrLaporan, $temp);
                        }
                    }

                    $sheet->loadView('admin.laporan_bulanan_karyawan_excel', array('laporans' => $arrLaporan, 'usermatrik' => $data['usermatrik']));
                });
            })->export('xlsx');
        }
    }

    function get_laporan_gaji() {
        $tg01 = new tg01();
        $data = array();
        $startdate = Input::get("tahun_awal_gaji") . "-" . Input::get("bulan_gaji") . "-01";
        $enddate = Input::get("tahun_akhir_gaji") . "-" . Input::get("bulan2_gaji") . "-01";
        $idkar = Input::get("idkar_gaji");
        $status_gaji = Input::get("status_gaji");

        if ($status_gaji == "A") {
            $status_gaji = "%";
        }

        $laporan_gaji = $tg01->getGajiStatusN($startdate, $enddate, $idkar, $status_gaji);
        $no = 1;
        foreach ($laporan_gaji as $gaji) {
            $row = array();
            $row["nama"] = $gaji->nama;
            $row["no_gaji"] = $gaji->nortg;
            $row["tanggal"] = strftime("%d-%b-%Y", strtotime($gaji->tgltg));
            $row["total_gaji"] = "Rp. " . number_format($gaji->ttlgj, 0, ',', '.') . ' + <font color="blue">Rp.' . number_format($gaji->ttlbns, 0, ',', '.') . " (Bonus)</font>";
            $row["status"] = $gaji->status == "N" ? "<font color='red'>Belum Terbayar</color>" : "<font color='green'>Gaji Telah Dibayarkan</color>";

            $data[] = $row;
            $no++;
        }

        //output to json format
        echo json_encode($data);
    }

    function get_laporan_omzet() {

        $tz01 = new tz01();
        $data = array();
        $startdate = date("Y-m-d", strtotime(Input::get("tanggal_start_omzet")));
        $enddate = date("Y-m-d", strtotime(Input::get("tanggal_end_omzet")));
        $idkar = Input::get("idkar_omzet");

        $laporan_omzet = $tz01->getAllOmzet($startdate, $enddate, $idkar);
        $no = 1;
        foreach ($laporan_omzet as $omzet) {
            $row = array();
            $row["tglomz"] = date("d-m-Y", strtotime($omzet->tglomz));
            $row["nama"] = $omzet->nama;
            $row["nilomz"] = number_format($omzet->nilomz, 0, ',', '.');

            $data[] = $row;
            $no++;
        }

        //output to json format
        echo json_encode($data);
    }

    function get_saldo_tabungan_karyawan() {
        $mk01 = new mk01();
        $karyawans = $mk01->getKaryawanAktif();
        $no = 1;
        $data = array();
        foreach ($karyawans as $karyawan) {
            $row = array();
            $row["no"] = $no++;
            $row["nama"] = $karyawan->nama;
            $row["tbsld"] = "Rp." . number_format($karyawan->tbsld, 0, ',', '.') . ",-";
            $data[] = $row;
        }
        echo json_encode($data);
    }

    function add_saldo_tabungan_karyawan() {
        $tbsld = Input::get("tbsld");
        $idkar = Input::get("idkar");

        $mk01 = mk01::find($idkar);
        $mk01->tbsld = $tbsld;
        $mk01->save();

        setlocale(LC_ALL, 'IND');
        $ts01 = new ts01();
        $ts01->tgltrans = date("Y-m-d H:i:s");
        $ts01->mk01_id = $idkar;
        $ts01->tbsld = $tbsld;
        $ts01->save();

        echo "true";
    }

    function get_tabungan_karyawan() {
        $tt01 = new tt01();
        $tabungans = $tt01->getTabungan();
        $data = array();
        foreach ($tabungans as $tabungan) {
            $row = array();
            $row["idtb"] = $tabungan->idtb;
            $row["tgltb"] = date("d-m-Y", strtotime($tabungan->tgltb));
            $row["nortb"] = $tabungan->nortb;
            $row["nama"] = $tabungan->nama;
            $row["niltb"] = "Rp." . number_format($tabungan->niltb, 0, ',', '.') . ",-";
            $data[] = $row;
        }
        echo json_encode($data);
    }

    function add_tabungan_karyawan() {
        $niltb = Input::get("niltb");
        $idkar = Input::get("idkar");
        $tt01 = new tt01();
        $idtb = $tt01->getAutoIncrement();
        $lasttb = $tt01->getLatestTabungan($idkar, date("Y-m-d"));
        if (count($lasttb) == 0) {
            $tt01->nortb = "TB" . $idtb . date("m") . date("y");
            $tt01->tgltb = date("Y-m-d");
            $tt01->niltb = $niltb;
            $tt01->idkar = $idkar;
            $tt01->save();

            $mk01 = mk01::find($idkar);
            $mk01->tbsld = $mk01->tbsld + $niltb;
            $mk01->save();
            echo "true";
        } else {
            echo 'Tabungan Bulan ini telah Di-inputkan !';
        }
    }

    function delete_tabungan_karyawan() {
        $idtb = Input::get("idtb");

        $tt01 = tt01::find($idtb);
        $idkar = $tt01->idkar;
        $niltb = $tt01->niltb;
        $tt01->delete();

        $mk01 = mk01::find($idkar);
        $mk01->tbsld = $mk01->tbsld - $niltb;
        $mk01->save();

        echo "Data Tabungan Telah DiHapus!";
    }

    function get_gaji_karyawan() {
        $tg01 = new tg01();
        $gajis = $tg01->getGajiStatusN('', '', 0, 'N');
        $data = array();
        foreach ($gajis as $gaji) {
            $row = array();
            $row["idtg"] = $gaji->idtg;
            $row["nortg"] = $gaji->nortg;
            $row["tgltg"] = date("d-m-Y", strtotime($gaji->tgltg));
            $row["nama"] = $gaji->nama;
            $row["ttlgj"] = 'Rp.' . number_format($gaji->ttlgj, 0, ",", ".") . ' + <span class="blue">Rp.' . number_format($gaji->ttlbns, 0, ',', '.') . ' (Bonus)';
            $row["status"] = $gaji->status;
            $data[] = $row;
        }
        echo json_encode($data);
    }

    function transfer_all_gaji() {
        $chkitem = Input::get("chkitem");
        if (count($chkitem) > 0) {
            DB::transaction(function() {
                $chkitem = Input::get("chkitem");

                foreach ($chkitem as $idtg) {
                    $tg01 = tg01::find($idtg);
                    $check = new tg01();

                    // update hutang
                    $idph = $check->checkExistHutangKaryawan($tg01->tgltg, $tg01->idkar);
                    if ($idph != -1) {
                        $th02 = th02::find($idph);
                        $th02->idtg = $idtg;
                        $th02->status = 'Y';
                        $th02->save();

                        $mk01 = mk01::find($tg01->idkar);
                        $mk01->htsld = $mk01->htsld + $th02->nilhut;
                        $mk01->save();
                    }

                    // update tabungan
                    $idtb = $check->checkExistTabunganKaryawan($tg01->tgltg, $tg01->idkar);
                    if ($idtb != -1) {
                        $tt01 = tt01::find($idtb);
                        $tt01->idtg = $idtg;
                        $tt01->save();

                        $mk01 = mk01::find($tt01->idkar);
                        $mk01->tbsld = $mk01->tbsld + $tt01->niltb;
                        $mk01->save();
                    }

                    // Update hutang, kasbon dan tabungan sesuai pembayaran gaji
                    $check->updateHutangTabunganLunas($idph, $idtb);

                    // update status gaji
                    $check->updateStatusGaji($idtg, "Y");
                }
                echo "Data Slip Gaji Telah ditransfer!";
            });
        }
    }

    function get_detail_gaji() {
        $id = Input::get("idtg");
        $tg01 = tg01::find($id);
        $tg02 = new tg02();
        $ta03 = new ta03();
        $th01 = new th01();
        $tt01 = new tt01();
        $tz01 = new tz01();
        $mk01 = new mk01();
        $karyawan = mk01::find($tg01->idkar);

        $data = array();
        $data["karyawan"] = $karyawan;
        $data["kehadiran"] = $tg01->getKehadiranGaji($tg01->tglgjsblm, $tg01->idkar);
        $data["durasiBekerja"] = $tg01->getDurasiBekerjaGaji($tg01->tglgjsblm, $tg01->idkar);
        $data["durasiLembur"] = $tg01->getDurasiLemburGaji($tg01->tglgjsblm, $tg01->idkar);
        $data["durasiLambat"] = $tg01->getKeterlambatan($tg01->tglgjsblm, $tg01->idkar);
        $data["gaji"] = $tg01;
        $data["gajis"] = $tg02->getDetailGajiKaryawan($id);
        $data["infogajis"] = $tg01->getJamKerjaInSec($tg01->idkar, $tg01->tglgjsblm);
        $data["infohutang"] = $th01->getHutangBulan($tg01->idkar, $tg01->tglgjsblm);
        $data["infokasbon"] = $th01->getKasBonBulan($tg01->idkar, $tg01->tglgjsblm);
        $data["infotabungan"] = $tt01->getTabunganGaji($tg01->idkar, $tg01->tglgjsblm);
        $data["omzetIndividu"] = $tz01->getOmzetIndividu($tg01->idkar, $tg01->tglgjsblm);
        $data["omzetTim"] = $tz01->getOmzetTim($tg01->idkar, $tg01->tglgjsblm);
        $data["cuti"] = $ta03->getTotalAlpha($tg01->idkar, $tg01->tglgjsblm, "Cuti");
        $data["referrals"] = $mk01->getReferralKar($tg01->idkar);
        echo json_encode($data);
    }

    function save_bonus() {
        $idtg = Input::get("idtg");
        $ttlbns = Input::get("ttlbns");
        $kettrn = Input::get("kettrn");

        $tg01 = tg01::find($idtg);
        $tg01->ttlbns = $ttlbns;
        $tg01->kettrn = $kettrn;
        $tg01->save();

        echo "true";
    }

    // ------------------- END Laporan Presensi + Hutang + Tabungan ------------------- //
    // ------------------- Ubah Persen Bonus ------------------- //

    public function persen_bonus_karyawan() {
        $mk03 = new mk03();

        $data = array();
        $data['usermatrik'] = User::getUserMatrix();
        $data['filter'] = Session::get('filter');
        $data['prsbns'] = $mk03->getNilKeterangan("prsbns");
        $data['maxtelat'] = $mk03->getNilKeterangan("maxtelat");

        return View::make('admin.persen_bonus_karyawan', $data);
    }

    public function persen_bonus_karyawan_save() {
        // 1. setting validasi
        $messages = array(
            'required' => 'Inputan <b>Tidak Boleh Kosong</b>!',
            'numeric' => 'Inputan <b>Harus Angka</b>!',
            'same' => 'Password <b>Tidak Sama</b>!'
        );

        $validator = Validator::make(
                        Input::all(), array(
                    "prsbns" => "required|numeric",
                    "maxtelat" => "required|numeric"
                        ), $messages
        );

        // 2a. jika semua validasi terpenuhi simpan ke database
        if ($validator->passes()) {
            $prsbns = Input::get("prsbns");
            $maxtelat = Input::get("maxtelat");

            $temp_mk03 = new mk03();
            $idket = $temp_mk03->getIDKeterangan("prsbns");
            $mk03 = mk03::find($idket);
            $mk03->nilket = $prsbns;
            $mk03->save();

            $idket = $temp_mk03->getIDKeterangan("maxtelat");
            $mk03 = mk03::find($idket);
            $mk03->nilket = $maxtelat;
            $mk03->save();

            $data = array();
            Session::flash('filter', 'Persen Bonus Karyawan Telah Disimpan!');

            $data['filter'] = Session::get('filter');
            $data['usermatrik'] = User::getUserMatrix();
            $data['prsbns'] = $mk03->getNilKeterangan("prsbns");
            $data['maxtelat'] = $mk03->getNilKeterangan("maxtelat");
            return View::make('admin.persen_bonus_karyawan', $data);
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('admin/persenbonus')
                            ->withErrors($validator)
                            ->withInput();
        }
    }

    function persen_bonus_karyawan_admin_save() {
        $prsbns = Input::get("prsbns");
        $maxtelat = Input::get("maxtelat");

        $temp_mk03 = new mk03();
        $idket = $temp_mk03->getIDKeterangan("prsbns");
        $mk03 = mk03::find($idket);
        $mk03->nilket = $prsbns;
        $mk03->save();

        $idket = $temp_mk03->getIDKeterangan("maxtelat");
        $mk03 = mk03::find($idket);
        $mk03->nilket = $maxtelat;
        $mk03->save();

        echo "true";
    }

    // ------------------- END Ubah Persen Bonus ------------------- //

    function testpdf() {
        $data["test"] = "Test";
        $pdf = PDF::loadView('pdf.laporan_pembayaran_gaji', $data);
        return $pdf->stream();
    }

}
