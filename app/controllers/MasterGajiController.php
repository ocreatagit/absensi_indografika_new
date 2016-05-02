<?php

class MasterGajiController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $var = User::loginCheck([0, 1], 3);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        
        $mg01 = new mg01();
        $gaji = mg01::all();
        $success = Session::get('mg01_success');
        $data = array(
            "gaji" => $mg01->find(0),
            "gajis" => $gaji,
            "action" => action("MasterGajiController@create"),
            "mg01_success" => $success,
            "usermatrik" => User::getUserMatrix()
        );        
        return View::make('master.m_jenis_gaji', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $var = User::loginCheck([0, 1], 3);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        // 1. setting validasi
        $messages = array(
            'required' => 'Inputan <b>Tidak Boleh Kosong</b>!'
        );

        $validator = Validator::make(
                        Input::all(), array(
                    "jenis" => "required"), $messages
        );

        // 2a. jika semua validasi terpenuhi simpan ke database
        if ($validator->passes()) {
            $gaji = new mg01();
            $gaji->jenis = Input::get('jenis');
            $gaji->status = Input::get('status') == "Y" ? "Y" : "N";
            $gaji->jntgh = Input::get("jntgh");
            $gaji->jmltgh = Input::get("jntgh") == "Bulan" ? 30 : 1;
            $gaji->save();
            Session::flash('mg01_success', 'Data Telah Ditambahkan!');
            return Redirect::to('master/jenisgaji');
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('master/jenisgaji')
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
        $var = User::loginCheck([0, 1], 3);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        
        $mg01 = new mg01();
        $gaji = mg01::all();
        $data = array(
            "gaji" => $mg01->find($id),
            "gajis" => $gaji,
            "action" => action("MasterGajiController@update", $id),
            "usermatrik" => User::getUserMatrix()
        );
        return View::make('master.m_jenis_gaji', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $var = User::loginCheck([0, 1], 3);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        // 1. setting validasi
        $messages = array(
            'required' => 'Inputan <b>Tidak Boleh Kosong</b>!'
        );

        $validator = Validator::make(
                        Input::all(), array(
                    "jenis" => "required"), $messages
        );

        // 2a. jika semua validasi terpenuhi simpan ke database
        if ($validator->passes()) {
            $mg01 = new mg01();
            $gaji = $mg01::find($id);
            $gaji->jenis = Input::get('jenis');
            $gaji->status = Input::get('status') == "Y" ? "Y" : "N";
            $gaji->jntgh = Input::get("jntgh");
            $gaji->jmltgh = Input::get("jntgh") == "Bulan" ? 30 : 1;
            $gaji->save();
            Session::flash('mg01_success', 'Data Telah Ditambahkan!');
            return Redirect::to('master/jenisgaji');
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('master/jenisgaji')
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
        $var = User::loginCheck([0, 1], 3);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        $mg01 = mg01::find($id);
        $mg01->delete();
        Session::flash('mg01_success', 'Data Telah Di-hapus!');
        return Redirect::to('master/jenisgaji');
    }

}
