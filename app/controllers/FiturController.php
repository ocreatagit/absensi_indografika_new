<?php

class FiturController extends \BaseController {

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

    public function myindografika() {
        $data['usermatrik'] = User::getUserMatrix();
        return View::make('master.my_indografika', $data);
    }

    public function histori_pembayaran_gaji() {
        $userloginid = Session::get("user");
        $tg01 = new tg01();
        $data = array();
        $data["karyawan"] = mk01::find($userloginid["idkar"]);
        $data["gajis"] = $tg01->getGajiStatusN('', '', $userloginid["idkar"]);
        $data['filter'] = Session::get('filter');
        $data['usermatrik'] = User::getUserMatrix();
        return View::make('master.my_gaji', $data);
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

    public function histori_tabungan() {
        $userloginid = Session::get("user");
        $tt01 = new tt01();
        $tglfrom = "";
        $tglto = "";
        $data = array(
            "karyawan" => mk01::find($userloginid["idkar"]),
            "allTabungans" => $tt01->getAllTabungan($tglfrom, $tglto, $userloginid["idkar"]),
            "usermatrik" => User::getUserMatrix()
        );
        return View::make('master.my_tabungan', $data);
    }

    public function histori_tabungan_query() {
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

            $userloginid = Session::get("user");
            $tt01 = new tt01();
            $data = array();
            $data["karyawan"] = mk01::find($userloginid["idkar"]);
            $data["allTabungans"] = $tt01->getAllTabungan(date("Y-m-d", strtotime($tglfrom)), date("Y-m-d", strtotime($tglto)), $userloginid["idkar"]);
            Session::flash('filter', 'Pencarian Tabungan Pada Tanggal <b>' . $tglfrom . ' s/d ' . $tglto . '</b>');

            $data['filter'] = Session::get('filter');
            $data['usermatrik'] = User::getUserMatrix();
            return View::make('master.my_tabungan', $data);
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('myindografika/tabungankaryawan')
                            ->withErrors($validator)
                            ->withInput();
        }
    }

    public function histori_hutang() {
        $userloginid = Session::get("user");
        $th01 = new th01();
        $tglfrom = "";
        $tglto = "";
        $jenis = "Hutang";
        $status = "N";
        $data = array(
            "karyawan" => mk01::find($userloginid["idkar"]),
            "allHutangs" => $th01->getAllHutang($tglfrom, $tglto, $userloginid["idkar"], $jenis, $status),
            "usermatrik" => User::getUserMatrix()
        );
        return View::make('master.my_pinjaman', $data);
    }

    public function histori_hutang_query() {
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

            $userloginid = Session::get("user");
            $th01 = new th01();
            $data = array();
            $data["karyawan"] = mk01::find($userloginid["idkar"]);
            $data["allHutangs"] = $th01->getAllHutang(date("Y-m-d", strtotime($tglfrom)), date("Y-m-d", strtotime($tglto)), $userloginid["idkar"], $jenis, $status);
            Session::flash('filter', 'Pencarian Pinjaman <b>' . $jenis . '</b> dengan status <b>' . ($status == "Y" ? "Lunas" : "Belum Lunas") . '</b> Pada Tanggal <b>' . $tglfrom . ' s/d ' . $tglto . '</b>');

            $data['filter'] = Session::get('filter');
            $data['usermatrik'] = User::getUserMatrix();
            return View::make('master.my_pinjaman', $data);
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('myindografika/pinjamankaryawan')
                            ->withErrors($validator)
                            ->withInput();
        }
    }

    public function show_pinjaman($idhut) {
        $userloginid = Session::get("user");
        $th01 = new th01();
        $data = array(
            "karyawan" => mk01::find($userloginid["idkar"]),
            "hutang" => th01::find($idhut),
            "detail_hutangs" => $th01->getDetailHutang($idhut),
            "usermatrik" => User::getUserMatrix()
        );
        return View::make('master.my_pinjaman_detail', $data);
    }

    public function histori_omzet() {
        $userloginid = Session::get("user");
        $tz01 = new tz01();
        $tglfrom = "";
        $tglto = "";
        $data = array(
            "karyawan" => mk01::find($userloginid["idkar"]),
            "allOmzets" => $tz01->getAllOmzet($tglfrom, $tglto, $userloginid["idkar"]),
            "usermatrik" => User::getUserMatrix()
        );
        return View::make('master.my_omzet', $data);
    }

    public function histori_omzet_query() {
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

            $userloginid = Session::get("user");
            $tz01 = new tz01();
            $data = array();
            $data["karyawan"] = mk01::find($userloginid["idkar"]);
            $data["allOmzets"] = $tz01->getAllOmzet(date("Y-m-d", strtotime($tglfrom)), date("Y-m-d", strtotime($tglto)), $userloginid["idkar"]);
            Session::flash('filter', 'Pencarian Omzet Pada Tanggal <b>' . $tglfrom . ' s/d ' . $tglto . '</b>');

            $data['filter'] = Session::get('filter');
            $data['usermatrik'] = User::getUserMatrix();
            return View::make('master.my_omzet', $data);
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('myindografika/omzetkaryawan')
                            ->withErrors($validator)
                            ->withInput();
        }
    }

    public function presensi_karyawan() {
        $userloginid = Session::get("user");

        $data = array(
            "karyawan" => mk01::find($userloginid["idkar"]),
            "usermatrik" => User::getUserMatrix(),
            "presensi" => Presensi::getPresensi($userloginid["idkar"])
        );

        return View::make('master.my_presensi', $data);
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

            $userloginid = Session::get("user");

            $data = array(
            "karyawan" => mk01::find($userloginid["idkar"]),
            "usermatrik" => User::getUserMatrix(),
            "presensi" => Presensi::getPresensi($userloginid["idkar"], $tglfrom, $tglto)
            );

            return View::make('master.my_presensi', $data);
        }
        else{
            return Redirect::to('myindografika/presensikaryawan')
                            ->withErrors($validator)
                            ->withInput();
        }
    }
}
