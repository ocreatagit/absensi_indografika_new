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
        return View::make('master.my_gaji_detail', $data);
    }

    public function histori_pembayaran_gaji_query() {

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

            $userloginid = Session::get("user");
            $tg01 = new tg01();
            $data = array();
            $data["karyawan"] = mk01::find($userloginid["idkar"]);
            $data["gajis"] = $tg01->getGajiStatusN(date("Y-m-d", strtotime($tglfrom)), date("Y-m-d", strtotime($tglto)), $userloginid["idkar"], $status);
            Session::flash('filter', 'Pencarian Gaji dengan status <b>' . ($status == "Y" ? "Terbayar" : "Belum Terbayar") . '</b> Pada Tanggal <b>' . $tglfrom . ' s/d ' . $tglto . '</b>');

            $data['filter'] = Session::get('filter');
            $data['usermatrik'] = User::getUserMatrix();
            return View::make('master.my_gaji', $data);
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('myindografika/gajikaryawan')
                            ->withErrors($validator)
                            ->withInput();
        }
    }
    
    // ------------------- END Gaji ------------------- //
    
    // ------------------- Tabungan ------------------- //
    
    // ------------------- END Tabungan ------------------- //
    
    // ------------------- Hutang ------------------- //
    
    // ------------------- END Hutang ------------------- //
    
    // ------------------- Omzet ------------------- //
    
    // ------------------- END Omzet ------------------- //
    
    // ------------------- Presensi ------------------- //
    
    public function presensi_karyawan() {
        $userloginid = Session::get("user");
        $tglfrom = "";
        $tglto = "";
        $mk01 = new mk01();
        $data = array(
            "karyawans" => $mk01->getKaryawanAktif(),
            "usermatrik" => User::getUserMatrix(),
            "presensies" => Presensi::getPresensi()
        );
        return View::make('admin.presensi_karyawan', $data);
    }
    
    public function presensi_karyawan_query() {
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

            $userloginid = Session::get("user");
            $mk01 = new mk01();
            $data = array(
                "karyawans" => $mk01->getKaryawanAktif(),
                "usermatrik" => User::getUserMatrix(),
                "presensies" => Presensi::getPresensi($idkar,$tglfrom, $tglto)
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

}
