<?php

class TransaksiOmzetController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $var = User::loginCheck([0, 1], 9);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        
        $success = Session::get('tz01_success');
        $danger = Session::get('tz01_danger');
        $tz01 = new tz01();
        $data = array(
            "karyawanalls" => mk01::all(),
            "omzets" => $tz01->getOmzet(),
            "tz01_success" => $success,
            "tz01_danger" => $danger,
            "usermatrik" => User::getUserMatrix()
        );
        return View::make('transaksi.trans_omzet', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $var = User::loginCheck([0, 1], 9);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        
        $success = Session::get('tz01_success');
        $data = array(
            "karyawanalls" => mk01::all(),
            "tz01_success" => $success,
            "usermatrik" => User::getUserMatrix()
        );
        return View::make('transaksi.trans_omzet_karyawan', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $var = User::loginCheck([0, 1], 9);
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
                    "nilomz" => "required|numeric",
                    "tglomz" => "required"
                        ), $messages
        );

        // 2a. jika semua validasi terpenuhi simpan ke database
        if ($validator->passes()) {
            $cek = new tz01();
            $cek = $cek->getLatestOmzet(Input::get("idkar"), date("Y-m-d"));
            if (count($cek) == 0) {
                $tz01 = new tz01();
                $tz01->tglomz = strftime("%Y-%m-%d", strtotime(Input::get("tglomz")));
                $tz01->nilomz = Input::get("nilomz");
                $tz01->idkar = Input::get("idkar");
                $tz01->save();

                Session::flash('tz01_success', 'Data Telah DiTambahkan!');
            } else {
                Session::flash('tz01_danger', 'Omzet Telah Di Setorkan!');
            }
            return Redirect::to('inputdata/omzet');
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('inputdata/omzet_karyawan')
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
        $var = User::loginCheck([0, 1], 9);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        
        $tz01 = tz01::find($id);
        $tz01->delete();

        Session::flash('tz01_success', 'Data Telah DiHapus!');
        return Redirect::to('inputdata/omzet');
    }

}
