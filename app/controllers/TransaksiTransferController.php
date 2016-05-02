<?php

class TransaksiTransferController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $var = User::loginCheck([0, 1], 8);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        
        $success = Session::get('tg01_success');
        $danger = Session::get('tg01_danger');
        $tg01 = new tg01();
        $data = array(
            "gajis" => $tg01->getGajiStatusN(),
            "tg01_success" => $success,
            "tg01_danger" => $danger,
            "usermatrik" => User::getUserMatrix()
        );
        return View::make('transaksi.trans_transfer_gaji', $data);
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
        $var = User::loginCheck([0, 1], 8);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        
        $success = Session::get('tg01_success');
        $danger = Session::get('tg01_danger');
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
            "tg01_success" => $success,
            "tg01_danger" => $danger,
            "usermatrik" => User::getUserMatrix()
        );
        return View::make('transaksi.trans_transfer_gaji_detail', $data);
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
        
    }

    public function payment($id) {
        $var = User::loginCheck([0, 1], 8);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        
        $tg01 = tg01::find($id);
        $check = new tg01();

        // update hutang
        $idph = $check->checkExistHutangKaryawan($tg01->tgltg, $tg01->idkar);
        if ($idph != -1) {
            $th02 = th02::find($idph);
            $th02->idtg = $id;
            $th02->status = 'Y';
            $th02->save();
            
            $mk01 = mk01::find($tg01->idkar);
            $mk01->htsld = $mk01->htsld + $th02->nilhut;
            $mk01->save();
//            echo "- ada hutang <br>";
        }
        
        // update tabungan
        $idtb = $check->checkExistTabunganKaryawan($tg01->tgltg, $tg01->idkar);
        if ($idtb != -1) {
            $tt01 = tt01::find($idtb);
            $tt01->idtg = $id;
            $tt01->save();
            
            $mk01 = mk01::find($tt01->idkar);
            $mk01->tbsld = $mk01->tbsld + $tt01->niltb;
            $mk01->save();
//            echo "- ada tabungan <br>";
        }

        // Update hutang, kasbon dan tabungan sesuai pembayaran gaji
        $check->updateHutangTabunganLunas($idph, $idtb);

        // update status gaji
        $check->updateStatusGaji($id, "Y");

        Session::flash('tg01_success', 'Gaji Telah Di Transfer!');
        // Redirect ke url + menuju div tertentu
        $url = URL::action("TransaksiTransferController@index");
        return Redirect::to($url);
    }

    public function printgaji($id) {
        $var = User::loginCheck([0, 1], 8);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        
        $success = Session::get('tg01_success');
        $danger = Session::get('tg01_danger');
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
            "tg01_success" => $success,
            "tg01_danger" => $danger,
            "usermatrik" => User::getUserMatrix()
        );
        return View::make('transaksi.trans_print_gaji', $data);
    }

    public function savebonus() {
        $var = User::loginCheck([0, 1], 8);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        
        //Input POST
        $idtg = Input::get("idtg");
        $ttlbns = Input::get("ttlbns");

        // 1. setting validasi
        $messages = array(
            'required' => 'Inputan <b>Tidak Boleh Kosong</b>!',
            'numeric' => 'Inputan <b>Harus Angka</b>!',
            'same' => 'Password <b>Tidak Sama</b>!'
        );

        $validator = Validator::make(
                        Input::all(), array(
                    "ttlbns" => "required"
                        ), $messages
        );

        // 2a. jika semua validasi terpenuhi simpan ke database
        if ($validator->passes()) {
            $tg01 = tg01::find($idtg);
            $tg01->ttlbns = $ttlbns;
            $tg01->save();

            Session::flash('tg01_success', 'Gaji Bonus Telah Ditambahkan!');
            // Redirect ke url + menuju div tertentu
            $url = URL::action("TransaksiTransferController@show", ['id' => $idtg]);
            return Redirect::to($url);
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('inputdata/detail/' . $idtg)
                            ->withErrors($validator)
                            ->withInput();
        }
    }

}
