<?php

class TransaksiAlphaController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $var = User::loginCheck([0, 1], 25);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        
        $success = Session::get('ta03_success');
        $danger = Session::get('ta03_danger');
        $ta03 = new ta03();
        $mk01 = new mk01();

        $data = array(
            "alphas" => $ta03->getAllAlpha(),
            "tglabs" => date("d-m-Y"),
            "karyawans" => $mk01->getKaryawanAktif(),
            "ta03_success" => $success,
            "ta03_danger" => $danger,
            "usermatrik" => User::getUserMatrix()
        );
        return View::make('transaksi.trans_alpha', $data);
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
        $var = User::loginCheck([0, 1], 25);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        
        // 1. setting validasi
        $messages = array(
            'required' => 'Inputan <b>Tidak Boleh Kosong</b>!',
            'numeric' => 'Inputan <b>Harus Angka</b>!',
            'same' => 'Password <b>Tidak Sama</b>!',
            'date' => 'Inputan Tanggal Salah!'
        );

        $validator = Validator::make(
                        Input::all(), array(
                    "tglabs" => "required|date"
                        ), $messages
        );

        // 2a. jika semua validasi terpenuhi simpan ke database
        if ($validator->passes()) {
            $cek = new ta03();
            $cek = $cek->getAlpha(Input::get("idkar"), Input::get("tglabs"), Input::get("jenis"));
            if (count($cek) == 0) {
                $ta03 = new ta03();
                
                $ta03->tglabs = date("Y-m-d", strtotime(Input::get("tglabs")));
                $ta03->durasi = 24;
                $ta03->jenis = Input::get("jenis");
                $ta03->idkar = Input::get("idkar");
                $ta03->save();
                
                Session::flash('ta03_success', 'Data Telah DiTambahkan!');
            } else {
                Session::flash('ta03_danger', 'Data Cuti / Alpha Sudah Pernah Diinputkan!');
            }
            return Redirect::to('inputdata/alpha');
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('inputdata/alpha')
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
        $var = User::loginCheck([0, 1], 25);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        
        $ta03 = ta03::find($id);
        $ta03->delete();

        Session::flash('ta03_success', 'Data Telah DiHapus!');
        return Redirect::to('inputdata/alpha');
    }

}
