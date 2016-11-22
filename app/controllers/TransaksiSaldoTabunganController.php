<?php

class TransaksiSaldoTabunganController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $var = User::loginCheck([0, 1], 29);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        $mk01 = new mk01();
        $success = Session::get('mk01_success');
        $data = array(
            "karyawans" => $mk01->getKaryawanAktif(),
            "mk01_success" => $success,
            "usermatrik" => User::getUserMatrix()
        );
        return View::make('master.m_saldo_karyawan', $data);
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
        $var = User::loginCheck([0, 1], 29);
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
                    "tbsld" => "required|numeric"
                        ), $messages
        );

        // 2a. jika semua validasi terpenuhi simpan ke database
        if ($validator->passes()) {
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
            
            Session::flash('mk01_success', 'Data Tabungan Telah Ditambahkan!');
            
            return Redirect::to('inputdata/saldotabungan');
        }
        // 2b. jika tidak, kembali ke halaman form sebelumnya
        else {
            return Redirect::to('inputdata/saldotabungan')
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
        $var = User::loginCheck([0, 1], 29);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        $success = Session::get('mk01_success');
        $data = array(
            "karyawan" => mk01::find($id),
            "mk01_success" => $success,
            "usermatrik" => User::getUserMatrix()
        );
        return View::make('master.m_saldo_karyawan_edit', $data);
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
        $var = User::loginCheck([0, 1], 29);
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
                    "tbsld" => "required|numeric"
                        ), $messages
        );

        // 2a. jika semua validasi terpenuhi simpan ke database
        if ($validator->passes()) {
            $tbsld = Input::get("tbsld");
            
            $mk01 = mk01::find($id);
            $mk01->tbsld = $tbsld;
            $mk01->save();
            
            $ts01 = new ts01();
            $ts01->tgltrans = date("Y-m-d H:i:s");
            $ts01->mk01_id = $id;
            $ts01->tbsld = $tbsld;
            $ts01->save();
            
            Session::flash('mk01_success', 'Data Tabungan Telah Ditambahkan!');
            
            return Redirect::to('inputdata/saldotabungan');
        }
        // 2b. jika tidak, kembali ke halaman form sebelumnya
        else {
            return Redirect::to('inputdata/saldotabungan/'.$id)
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
        //
    }

}
