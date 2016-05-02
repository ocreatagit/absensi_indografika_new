<?php

class MasterJamKerjaController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $var = User::loginCheck([0, 1], 1);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        $mj02 = new mj02();
        $jam_kerja = mj02::all();
        $success = Session::get('mj02_success');
        $danger = Session::get('mj02_danger');
        $data = array(
            "jam_kerja" => $mj02->find(0),
            "jam_kerjas" => $jam_kerja,
            "action" => action("MasterJamKerjaController@create"),
            "mj02_success" => $success,
            "mj02_danger" => $danger,
            "usermatrik" => User::getUserMatrix()
        );
        return View::make('master.m_jam_kerja', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        // 1. setting validasi
        $var = User::loginCheck([0, 1], 1);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        $messages = array(
            'required' => 'Inputan <b>Tidak Boleh Kosong</b>!'
        );

        $validator = Validator::make(
                        Input::all(), array(
                    "jmmsk" => "required",
                    "jmklr" => "required"), $messages
        );

        // 2a. jika semua validasi terpenuhi simpan ke database
        if ($validator->passes()) {
            if (Input::get('jmmsk') != Input::get('jmklr')) {
                $jam_kerja = new mj02();
                if ($jam_kerja->checkJamKerja(Input::get('tipe'), Input::get('jmmsk'), Input::get('jmklr'))) {
                    Session::flash('mj02_danger', 'Jam Kerja Sudah Pernah Ditambahkan!');
                } else {
                    $jam_kerja->tipe = Input::get('tipe');
                    $jam_kerja->jmmsk = Input::get('jmmsk');
                    $jam_kerja->jmklr = Input::get('jmklr');
                    $jam_kerja->status = Input::get('status') == "Y" ? "Y" : "N";
                    $jam_kerja->save();
                    Session::flash('mj02_success', 'Data Telah Ditambahkan!');
                }
            } else {
                Session::flash('mj02_danger', 'Jam Masuk Tidak Boleh Sama Dengan Jam Keluar!');
            }
            return Redirect::to('master/jamkerja');
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('master/jamkerja')
                            ->withErrors($validator)
                            ->withInput();
        }
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
        $var = User::loginCheck([0, 1], 1);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        $mj02 = new mj02();
        $jam_kerja = $mj02->find($id);
        $data = array(
            "jam_kerja" => $jam_kerja,
            "action" => action("MasterJamKerjaController@update", $id),
            "jam_kerjas" => mj02::all(),
            "usermatrik" => User::getUserMatrix()
        );
        return View::make('master.m_jam_kerja', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id = FALSE) {
        if ($id == FALSE) {
            return Redirect::to("login");
        }
        $var = User::loginCheck([0, 1], 1);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        // 1. setup validation
        $messages = array(
            'required' => 'Inputan <b>Tidak Boleh Kosong</b>!'
        );

        $validator = Validator::make(
                        Input::all(), array(
                    "jmmsk" => "required",
                    "jmklr" => "required"), $messages
        );

        // 2a. no error validaion
        if ($validator->passes()) {
            $mj02 = new mj02();
            $jam_kerja = $mj02->find($id);
            $jam_kerja->tipe = Input::get('tipe');
            $jam_kerja->jmmsk = Input::get('jmmsk');
            $jam_kerja->jmklr = Input::get('jmklr');
            $jam_kerja->status = Input::get('status') == "Y" ? "Y" : "N";
            $jam_kerja->save();
            Session::flash('mj02_success', 'Data Telah Di-ubah!');
            return Redirect::to('master/jamkerja');
        }
        // 2b. error validation
        else {
            return Redirect::to('master/jamkerja/edit/' . $id)
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
        $var = User::loginCheck([0, 1], 1);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        $jam_kerja = mj02::find($id);
        $jam_kerja->delete();
        Session::flash('mj02_success', 'Data Telah Di-hapus!');
        return Redirect::to('master/jamkerja');
    }

}
