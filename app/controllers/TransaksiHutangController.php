<?php

class TransaksiHutangController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $var = User::loginCheck([0, 1], 5);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        
        $success = Session::get('th01_success');
        $danger = Session::get('th01_danger');
        $th01 = new th01();
        $data = array(
            "karyawans" => mk01::where("status", "=", "Y")->where("jnsusr", "=", 2)->get(),
            "hutangs" => $th01->getHutangBlmLunas(),
//            "hutangs" => $th01::all(),
            "th01_success" => $success,
            "th01_danger" => $danger,
            "usermatrik" => User::getUserMatrix()
        );
        return View::make('transaksi.trans_hutang', $data);
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
        $var = User::loginCheck([0, 1], 5);
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
                    "jmlang" => "required|numeric",
                    "nilhut" => "required|numeric"
                        ), $messages
        );

        // 2a. jika semua validasi terpenuhi simpan ke database
        if ($validator->passes()) {
            $th01 = new th01();
            $idhut = $th01->getAutoIncrement();
            $nilhut = Input::get("nilhut");
            $jmlang = Input::get("jmlang");
            $idkar = Input::get("idkar");
            $sumhut = 0;
            $flaginsert = true;

            if ($th01->checkAktifHutang($idkar) > 0) {
                Session::flash('th01_danger', 'Transaksi Gagal! Hutang / Kasbon Karyawan Belum Lunas!');
            } else {

                if (Input::get("idhut") == "Kas Bon") {
                    if (Input::get("jmlang") != 1) {
                        Session::flash('th01_danger', 'Transaksi Gagal! <b> Angsuran</b> Kasbon Harus Bernilai 1 !');
                        $flaginsert = FALSE;
                    }
                }

                $cek = new th01();
                $latestHutang = $cek->getLatestHutang($idkar);
                if (count($latestHutang) > 0) {
                    if (date("m", strtotime($latestHutang[0]->tglhut)) == date("m")) {
                        Session::flash('th01_danger', 'Transaksi Gagal! Hutang / Kasbon Karyawan Pada Bulan Ini Telah Dibuat !');
                        $flaginsert = FALSE;
                    }
                }

                if ($flaginsert) {
                    $th01->norhut = Input::get("idhut") == "Hutang" ? "HT" . $idhut . date("m") . date("y") : "KB" . $idhut . date("m") . date("y");
                    $th01->tglhut = date("Y-m-d");
                    $th01->jenhut = Input::get("idhut");
                    $th01->jmlang = Input::get("jmlang");
                    $th01->nilhut = Input::get("nilhut");
                    $th01->flglns = "N";
                    $th01->idkar = Input::get("idkar");
                    $th01->save();

                    for ($i = 1; $i <= $jmlang; $i++) {
                        $th02 = new th02();
                        if ((int) date("d") <= 10) {
                            $strhut = "+" . ($i - 1) . " month";
                        } else {
                            $strhut = "+" . ($i) . " month";
                        }
                        $th02->tglph = date('Y-m-d', strtotime($strhut, strtotime(date("Y-m-d"))));

                        if ($i == $jmlang) {
                            $th02->nilph = $nilhut - $sumhut;
                        } else {
                            $tamp = ($nilhut / 1000) / $jmlang;
                            $tamp = floor($tamp) * 1000;
                            $th02->nilph = $tamp;
                            $sumhut += $tamp;
                        }
                        $th02->status = "N";
                        $th02->idhut = $idhut;
                        $th02->save();
                    }
                    Session::flash('th01_success', 'Data Telah Ditambahkan!');
                }
            }
            return Redirect::to('inputdata/hutang');
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('inputdata/hutang')
                            ->withErrors($validator)
                            ->withInput();
        }
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
        $var = User::loginCheck([0, 1], 5);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        
        $success = Session::get('th01_success');
        $danger = Session::get('th01_danger');
        $th01 = new th01();
        $dethuts = $th01->getDetailHutang($id);
        $hutang = $th01->getHutang($id);
//        $flgbyr = FALSE;
//
//        foreach ($dethuts as $dethut) {
//            if ($dethut->idtg != 0) {
//                $flgbyr = TRUE;
//            }
//        }
//
//        if ($flgbyr) {
//            Session::flash('th01_danger', 'Gagal Edit ! Hutang Telah Diangsur!');
//            return Redirect::to('inputdata/hutang');
//        } else {

            $data = array(
                "hutang" => $hutang,
                "hutangs" => $dethuts,
                "th01_success" => $success,
                "th01_danger" => $danger,
                "usermatrik" => User::getUserMatrix()
            );
            return View::make('transaksi.trans_hutang_edit', $data);
//        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $var = User::loginCheck([0, 1], 5);
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
                    "jmlang" => "required|numeric",
                    "nilhut" => "required|numeric"
                        ), $messages
        );

        // 2a. jika semua validasi terpenuhi simpan ke database
        if ($validator->passes()) {
            $th01 = th01::find($id);
            $nilhut = Input::get("nilhut");
            $jmlang = Input::get("jmlang");
            $idkar = Input::get("idkar");
            $sumhut = 0;

            $cek = new th01();
            $dethuts = $cek->getDetailHutang($id);
            $flgbyr = FALSE;

            foreach ($dethuts as $dethut) {
                if ($dethut->idtg != 0) {
                    $flgbyr = TRUE;
                }
            }

            if ($flgbyr) {
                Session::flash('th01_danger', 'Gagal Edit ! Hutang Telah Diangsur!');
                return Redirect::to('inputdata/hutang/edit/'.$id);
            } else {
                $th01->jmlang = Input::get("jmlang");
                $th01->nilhut = Input::get("nilhut");
                $th01->flglns = "N";
                $th01->save();

                // Delete Hutang Lama
                $dethuts = $th01->getDetailHutang($id);
                foreach ($dethuts as $dethut) {
                    $th02 = th02::find($dethut->idph);
                    $th02->delete();
                }

                // Save Hutang baru
                for ($i = 1; $i <= $jmlang; $i++) {
                    $th02 = new th02();
                    if ((int) date("d") <= 10) {
                        $strhut = "+" . ($i - 1) . " month";
                    } else {
                        $strhut = "+" . ($i) . " month";
                    }
                    $th02->tglph = date('Y-m-d', strtotime($strhut, strtotime($th01->tglhut)));

                    if ($i == $jmlang) {
                        $th02->nilph = $nilhut - $sumhut;
                    } else {
                        $tamp = ($nilhut / 1000) / $jmlang;
                        $tamp = floor($tamp) * 1000;
                        $th02->nilph = $tamp;
                        $sumhut += $tamp;
                    }
                    $th02->status = "N";
                    $th02->idhut = $id;
                    $th02->save();
                }
                Session::flash('th01_success', 'Data Telah Diubah!');
            }
            
            return Redirect::to('inputdata/hutang');
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('inputdata/hutang')
                            ->withErrors($validator)
                            ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $var = User::loginCheck([0, 1], 5);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        
        $th01 = new th01();
        $dethuts = $th01->getDetailHutang($id);
        foreach ($dethuts as $dethut) {
            $th02 = th02::find($dethut->idph);
            $th02->delete();
        }

        $th01 = th01::find($id);
        $th01->delete();

        Session::flash('th01_success', 'Data Telah DiHapus!');
        return Redirect::to('inputdata/hutang');
    }

}
