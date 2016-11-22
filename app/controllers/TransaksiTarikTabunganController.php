<?php

class TransaksiTarikTabunganController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $var = User::loginCheck([0, 1], 30);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        
        $success = Session::get('tt02_success');
        $danger = Session::get('tt02_danger');
        $tt02 = new tt02();
        $mk01 = new mk01();
        $data = array(
            "karyawanalls" => $mk01->getKaryawanAktif(),
            "tariks" => $tt02->getAllTarik(),
            "tt02_success" => $success,
            "tt02_danger" => $danger,
            "usermatrik" => User::getUserMatrix()
        );
        return View::make("transaksi.trans_tarik_tabungan", $data);
    }

    public function update_saldo_tabungan() {
        $var = User::loginCheck([0, 1], 30);
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
                    "niltt" => "required|numeric",
                    "tgltt" => "required"
                        ), $messages
        );

        // 2a. jika semua validasi terpenuhi simpan ke database
        if ($validator->passes()) {
            $niltt = Input::get("niltt");
            $idkar = Input::get("idkar");
            $tgltt = Input::get("tgltt");
            $tt02 = new tt02();
            $idtt = $tt02->getAutoIncrement();

            $mk01 = mk01::find($idkar);
            if ($mk01->tbsld < $niltt) {
                Session::flash('tt02_danger', 'Tabungan Tidak Mencukupi!');
            } else {
                $tt02->nortt = "TT" . $idtt . date("m", strtotime($tgltt)) . date("y", strtotime($tgltt));
                $tt02->tgltt = date("Y-m-d", strtotime($tgltt));
                $tt02->niltt = $niltt;
                $tt02->idkar = $idkar;
                $tt02->save();

                $mk01 = mk01::find($idkar);
                $mk01->tbsld = $mk01->tbsld - $niltt;
                $mk01->save();
                Session::flash('tt02_success', 'Data Telah Ditambahkan!');
            }
            return Redirect::to('inputdata/tarik_tabungan');
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('inputdata/tarik_tabungan')
                            ->withErrors($validator)
                            ->withInput();
        }
    }

    public function delete($id) {
        
        $var = User::loginCheck([0, 1], 30);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        
        $tt02 = tt02::find($id);
        $idkar = $tt02->idkar;
        $niltt = $tt02->niltt;

        $tt02->delete();

        $mk01 = mk01::find($idkar);
        $mk01->tbsld = $mk01->tbsld + $niltt;
        $mk01->save();

        Session::flash('tt02_success', 'Penarikan Tabungan Telah Dibatalkan!');
        return Redirect::to('inputdata/tarik_tabungan');
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

}
