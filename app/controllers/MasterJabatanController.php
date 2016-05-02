<?php

class MasterJabatanController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $var = User::loginCheck([0, 1], 2);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        
        $mj01 = new mj01();
        $jabatan = mj01::all();
        $success = Session::get('mj01_success');
        $data = array(
            "jabatan" => $mj01->find(0),
            "jabatans" => $jabatan,
            "action" => action("MasterJabatanController@create"),
            "mj01_success" => $success,
            "usermatrik" => User::getUserMatrix()
        );
        return View::make('master.m_jabatan', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $var = User::loginCheck([0, 1], 2);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        // 1. setting validasi
        $messages = array(
            'required' => 'Inputan <b>Tidak Boleh Kosong</b>!'
        );

        $validator = Validator::make(
                        Input::all(), array(
                    "nama" => "required"), $messages
        );

        // 2a. jika semua validasi terpenuhi simpan ke database
        if ($validator->passes()) {
            $jabatan = new mj01();
            $jabatan->flgomzt = Input::get('flgomzt') == "Y" ? "Y" : "N";
            $jabatan->nama = Input::get('nama');
            $jabatan->status = Input::get('status') == "Y" ? "Y" : "N";
            $jabatan->save();
            Session::flash('mj01_success', 'Data Telah Ditambahkan!');
            return Redirect::to('master/jabatan');
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('master/jabatan')
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
        $var = User::loginCheck([0, 1], 2);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        
        $jabatan = new mj01();
        $jabatan = $jabatan->find($id);
        $data = array(
            "jabatan" => $jabatan,
            "action" => action("MasterJabatanController@update", $id),
            "jabatans" => mj01::all(),
            "usermatrik" => User::getUserMatrix()
        );
        return View::make('master.m_jabatan', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $var = User::loginCheck([0, 1], 2);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        // 1. setup validation
        $messages = array(
            'required' => 'Inputan <b>Tidak Boleh Kosong</b>!'
        );

        $validator = Validator::make(
                        Input::all(), array(
                    "nama" => "required"), $messages
        );
        
        // 2a. jika semua validasi terpenuhi simpan ke database
        if ($validator->passes()) {
            $jabatan = new mj01();
            $jabatan = $jabatan->find($id);
            $jabatan->flgomzt = Input::get('flgomzt') == "Y" ? "Y" : "N";
            $jabatan->nama = Input::get('nama');
            $jabatan->status = Input::get('status') == "Y" ? "Y" : "N";
            $jabatan->save();
            Session::flash('mj01_success', 'Data Telah Ditambahkan!');
            return Redirect::to('master/jabatan');
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('master/jabatan')
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
        $var = User::loginCheck([0, 1], 2);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        $jabatan = mj01::find($id);
        $jabatan->delete();
        Session::flash('mj01_success', 'Data Telah Di-hapus!');
        return Redirect::to('master/jabatan');
    }

}
