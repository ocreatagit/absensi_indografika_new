<?php

class TransaksiTabunganController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $var = User::loginCheck([0, 1], 6);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        
        $success = Session::get('tt01_success');
        $danger = Session::get('tt01_danger');
        $tt01 = new tt01();
        $data = array(
            "karyawans" => mk01::where("status", "=", "Y")->get(),
            "tabungans" => $tt01->getTabungan(),
            "tt01_success" => $success,
            "tt01_danger" => $danger,
            "usermatrik" => User::getUserMatrix()
        );
        return View::make('transaksi.trans_tabungan', $data);
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
        $var = User::loginCheck([0, 1], 6);
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
                    "niltb" => "required|numeric"
                        ), $messages
        );

        // 2a. jika semua validasi terpenuhi simpan ke database
        if ($validator->passes()) {
            // validasi input tabungan tidak boleh double pada bulan yang sama
            $flginsert = TRUE;

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
                Session::flash('tt01_success', 'Data Telah Ditambahkan!');
            } else {
                Session::flash('tt01_danger', 'Tabungan Bulan ini telah Di-inputkan !');
            }
            
            return Redirect::to('inputdata/tabungan');
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('inputdata/tabungan')
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
        $var = User::loginCheck([0, 1], 6);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        
        $success = Session::get('tt01_success');
        $tt01 = new tt01();
        $data = array(
            "tabungan" => $tt01->getKarTabungan($id),
            "tt01_success" => $success,
            "usermatrik" => User::getUserMatrix()
        );
        return View::make('transaksi.trans_tabungan_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $var = User::loginCheck([0, 1], 6);
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
                    "niltb" => "required|numeric"
                        ), $messages
        );

        // 2a. jika semua validasi terpenuhi simpan ke database
        if ($validator->passes()) {
            // validasi input tabungan tidak boleh double pada bulan yang sama

            $idkar = Input::get("idkar");
            $tt01 = tt01::find($id);

            if ($tt01->idtg == 0) {
                $tt01->niltb = Input::get("niltb");
                $tt01->save();
                Session::flash('tt01_success', 'Data Telah Diubah !');
            } else {
                Session::flash('tt01_danger', 'Tabungan Telah Dibayarkan !');
            }
            return Redirect::to('inputdata/tabungan');
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('inputdata/tabungan')
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
        $var = User::loginCheck([0, 1], 6);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        
        $tt01 = tt01::find($id);
        $idkar = $tt01->idkar;
        $niltb = $tt01->niltb;

        $tt01->delete();

        $mk01 = mk01::find($idkar);
        $mk01->tbsld = $mk01->tbsld - $niltb;
        $mk01->save();

        Session::flash('tt01_success', 'Data Telah DiHapus!');
        return Redirect::to('inputdata/tabungan');
    }

}
