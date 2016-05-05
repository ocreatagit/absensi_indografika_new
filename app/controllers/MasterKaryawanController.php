<?php

class MasterKaryawanController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $var = User::loginCheck([0, 1], 4);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        $success = Session::get('mk01_success');
        $data = array(
            "karyawans" => mk01::all(),
            "mk01_success" => $success,
            "usermatrik" => User::getUserMatrix()
        );
        return View::make('master.m_list_karyawan', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $var = User::loginCheck([0, 1], 4);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        $success = Session::get('mk01_success');
        $mk01 = new mk01();
        $mj01 = new mj01();
        $mj02 = new mj02();
        $mg01 = new mg01();
        $idkaryawan = $mk01->getAutoIncrement();
        $data = array(
            "karyawan" => $mk01::find(0),
            "idkaryawan" => $idkaryawan,
            "karyawans" => mk01::all(),
            "action" => action("MasterKaryawanController@store"),
            "jabatans" => $mj01->getJabatanAktif(),
            "jamkerjas" => $mj02->getJamKerjaAktif(),
            "jamistirahats" => $mj02->getJamIstirahatAktif(),
            "gajis" => $mg01->getJenisGajiAktif(),
            "mk01_status" => $success,
            "cart" => Cart::content(),
            "usermatrik" => User::getUserMatrix()
        );
        return View::make('master.m_karyawan', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $var = User::loginCheck([0, 1], 4);
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
                    "nama" => "required",
                    "usernm" => "required",
                    "passwd" => "required",
                    "passwd2" => "same:passwd",
                    "norek1" => "required|numeric",
                    "norek2" => "required|numeric",
                    "ttl" => "required",
                    "tglaktif" => "required",
                    "addr1" => "required",
                    "notelp" => "required|numeric",
                    "kmindv" => "required|numeric",
                    "kmtim" => "required|numeric"
                        ), $messages
        );

        // 2a. jika semua validasi terpenuhi simpan ke database
        if ($validator->passes()) {
            if (Input::hasFile('foto')) {
                if (Input::File('foto')->isValid()) {
                    $img = Input::File('foto');
                    $destinationPath = 'uploads';
                    $filename = rand(10000, 99999) . "_" . $img->getClientOriginalName();
//                $fullname = rand(10000, 99999) . '_' . $filename . '.' . $img->getClientOriginalExtension();
                    $img->move($destinationPath, $filename);
                } else {
                    Session::flash('mk01_failed', 'Foto tidak valid!');
                    return Redirect::to('master/karyawan/create');
                }
            } else {
                $filename = "";
            }

            $karyawan = new mk01();
            $idkaryawan = $karyawan->getAutoIncrement();

            $karyawan->nama = Input::get('nama');
            $karyawan->usernm = Input::get('usernm');
            $karyawan->email = Input::get('email');
            $karyawan->passwd = Input::get('passwd');
            $karyawan->gndr = Input::get('gndr');
            $karyawan->norek1 = Input::get('norek1');
            $karyawan->norek2 = Input::get('norek2');
            $karyawan->tglaktif = strftime("%Y-%m-%d", strtotime(Input::get('tglaktif')));
            $karyawan->ttl = strftime("%Y-%m-%d", strtotime(Input::get('ttl')));
            $karyawan->addr1 = Input::get('addr1');
            $karyawan->notelp = Input::get('notelp');
            $karyawan->status = "Y";
            $karyawan->pic = $filename;
            $karyawan->tbsld = 0;
            $karyawan->htsld = 0;
            $karyawan->tglgj = date("Y-m-d");
            $karyawan->idjb = Input::get('idjb');
            $karyawan->kmindv = Input::get('kmindv');
            $karyawan->kmtim = Input::get('kmtim');
            $karyawan->save();

            // Jam Kerja
            $jam_kerja = new mj03();
            $jam_kerja->mj02_id = Input::get('idjk1');
            $jam_kerja->mk01_id = $idkaryawan;
            $jam_kerja->save();

            // Jam Istirahat
            $jam_kerja = new mj03();
            $jam_kerja->mj02_id = Input::get('idjk2');
            $jam_kerja->mk01_id = $idkaryawan;
            $jam_kerja->save();

            $mk02 = new mk02();
            $mk02->mk01_id_parent = $idkaryawan;
            $mk02->mk01_id_child = $idkaryawan;
            $mk02->flglead = "No";
            $mk02->save();

            Session::flash('mk01_success', 'Data Telah Ditambahkan!');
            return Redirect::to('master/karyawan/add_gaji/' . $karyawan->idkar);
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('master/karyawan/create')
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
        $var = User::loginCheck([0, 1], 4);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        $success = Session::get('mk01_success');
        $mk01 = new mk01();
        $mj01 = new mj01();
        $mj02 = new mj02();
        $mg01 = new mg01();
        $karyawan = $mk01::find($id);

//         PENTING !~!~        
//        $data = $karyawan->mj03->first()->mj02->first();
//         DUMP QUERY

        /*
          DB::listen(function($sql) {
          var_dump($sql);
          });
         * 
         */
        try {
            $data = array(
                "karyawan" => $mk01::find($id),
                "karyawanalls" => $mk01->getReferral($id),
                "idkaryawan" => $karyawan->idkar,
                "action" => action("MasterKaryawanController@update", $id),
                "jabatans" => $mj01->getJabatanAktif(),
                "jamkerjas" => $mj02->getJamKerjaAktif(),
                "jamistirahats" => $mj02->getJamIstirahatAktif(),
                "gajis" => $mg01->getOtherGaji($karyawan->idkar),
                "mk01_status" => $success,
                "jamkerja1" => $mk01->getJamKerja($id),
                "jamkerja2" => $mk01->getJamIstirahat($id),
                "referrals" => $mk01->getReferralKar($id),
                "usermatrik" => User::getUserMatrix()
            );
//            print_r($data); exit;
        } catch (Exception $ex) {
            DB::listen(function($sql) {
//                if (isset($sql)) {
                dd($sql);
//                }
            });
            dd($ex->getMessage());
        }

//        print_r($mk01->getJamKerja($id)); exit;


        return View::make('master.m_karyawan', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $var = User::loginCheck([0, 1], 4);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }
        //         1. setting validasi
        $messages = array(
            'required' => 'Inputan <b>Tidak Boleh Kosong</b>!',
            'numeric' => 'Inputan <b>Harus Angka</b>!',
            'same' => 'Password <b>Tidak Sama</b>!'
        );

        $validator = Validator::make(
                        Input::all(), array(
                    "nama" => "required",
                    "passwd2" => "same:passwd",
                    "usernm" => "required",
                    "norek1" => "required|numeric",
                    "norek2" => "required|numeric",
                    "ttl" => "required",
                    "tglaktif" => "required",
                    "addr1" => "required",
                    "notelp" => "required|numeric",
                    "kmindv" => "required|numeric",
                    "kmtim" => "required|numeric"
                        ), $messages
        );

        // 2a. jika semua validasi terpenuhi simpan ke database
        if ($validator->passes()) {
            $karyawan = mk01::find($id);

            if (Input::hasFile('foto')) {
                if (Input::File('foto')->isValid()) {
                    $img = Input::File('foto');
                    $destinationPath = 'uploads';
                    $filename = rand(10000, 99999) . "_" . $img->getClientOriginalName();
//                $fullname = rand(10000, 99999) . '_' . $filename . '.' . $img->getClientOriginalExtension();
                    $img->move($destinationPath, $filename);
                } else {
                    Session::flash('mk01_failed', 'Foto tidak valid!');
                    return Redirect::to('master/karyawan/create');
                }
            } else {
                $filename = $karyawan->pic;
            }

            $karyawan->nama = Input::get('nama');
            if (Input::get('passwd')) {
                $karyawan->passwd = Input::get('passwd');
            }
            $karyawan->usernm = Input::get('usernm');
            $karyawan->email = Input::get('email');
            $karyawan->gndr = Input::get('gndr');
            $karyawan->norek1 = Input::get('norek1');
            $karyawan->norek2 = Input::get('norek2');
            $karyawan->tglaktif = strftime("%Y-%m-%d", strtotime(Input::get('tglaktif')));
            $karyawan->ttl = strftime("%Y-%m-%d", strtotime(Input::get('ttl')));
            $karyawan->addr1 = Input::get('addr1');
            $karyawan->notelp = Input::get('notelp');
            $karyawan->status = "Y";
            $karyawan->pic = $filename;
            $karyawan->tbsld = 0;
            $karyawan->htsld = 0;
            $karyawan->idjb = Input::get('idjb');
            $karyawan->kmindv = Input::get('kmindv');
            $karyawan->kmtim = Input::get('kmtim');
            $karyawan->save();

            $datas = $karyawan->mj03;
            $datas[0]->mj02_id = Input::get('idjk1');
            $datas[0]->save();

            $datas[1]->mj02_id = Input::get('idjk2');
            $datas[1]->save();

            Session::flash('mk01_success', 'Data Telah Diubah!');
            return Redirect::to('master/karyawan');
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('master/karyawan/edit/' . $id)
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
        $var = User::loginCheck([0, 1], 4);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        $mg02 = new mg02();
        $temp_mg02 = $mg02->getGajiKaryawan($id);
        foreach ($temp_mg02 as $temp) {
            $relasi = mg02::find($temp->id);
            $relasi->delete();
        }

        $mj03 = new mj03();
        $temp_mj03 = $mj03->getJamKerjaKaryawan($id);
        foreach ($temp_mj03 as $temp) {
            $relasi = mj03::find($temp->id);
            $relasi->delete();
        }

        $mk01 = new mk01();
        $karyawan = $mk01::find($id);
        $karyawan->delete();

        Session::flash('mk01_success', 'Data Telah Dihapus!');

        return Redirect::to('master/karyawan');
//        $content = Cart::content();
//        foreach ($content as $row) {
//            $rowId = $row->rowid;
//
//            Cart::remove($rowId);
//        }
    }

    public function addGaji($id) {
        $var = User::loginCheck([0, 1], 4);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        $success = Session::get('mk01_success');
        $mk01 = new mk01();
        $mg01 = new mg01();
        $karyawan = $mk01::find($id);
        try {
            $data = array(
                "karyawan" => $mk01::find($id),
                "idkaryawan" => $karyawan->idkar,
                "action" => action("MasterKaryawanController@update", $id),
                "gajis" => $mg01->getJenisGajiAktif(),
                "mk01_status" => $success,
                "cart" => Cart::content(),
                "usermatrik" => User::getUserMatrix()
            );
        } catch (Exception $ex) {
            DB::listen(function($sql) {
                dd($sql);
            });
        }
        return View::make('master.m_karyawan_gaji', $data);
    }

    public function saveItemGaji($id) {
        $var = User::loginCheck([0, 1], 4);
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
                    "nilgj" => "required|numeric"
                        ), $messages
        );

        // 2a. jika semua validasi terpenuhi simpan ke database
        if ($validator->passes()) {
//            Cart::add(1, 5, 5, 5);
            $content = Cart::content();
            $idcart = 1;
            $rowId = '';
            foreach ($content as $row) {
                if ($row->name == Input::get("idgj")) {
                    $idcart = $row->id;
                    $rowId = $row->rowid;
                    break;
                } else {
                    $idcart = $row->id;
                    $idcart += 1;
                }
            }

            if ($rowId != '') {
                Cart::update($rowId, array('price' => Input::get("nilgj")));
            } else {
                if (Input::get("idgj")) {
                    $idgj = Input::get("idgj");
                    $gaji = mg01::find($idgj);
                    $jenis = $gaji['jenis'];
                    Cart::add($idcart, Input::get("idgj"), 1, Input::get("nilgj"), array('jenis_gaji' => $jenis, "idkaryawan" => Input::get("idkaryawan"), "iduser" => 0));
                }
            }
            // Redirect ke url + menuju div tertentu
            $url = URL::action("MasterKaryawanController@addGaji", ['id' => $id]) . "#datatable";
            return Redirect::to($url);
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('master/karyawan/add_gaji/' . $id)
                            ->withErrors($validator)
                            ->withInput();
        }
    }

    public function deleteItemGaji($rowId, $id) {
        $var = User::loginCheck([0, 1], 4);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        Cart::remove($rowId);
        $url = URL::action("MasterKaryawanController@addGaji", ['id' => $id]) . "#datatable";
        return Redirect::to($url);
    }

    public function saveGaji() {
        $var = User::loginCheck([0, 1], 4);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        $cart = Cart::content();
        foreach ($cart as $row) {
            $mg02 = new mg02();
            $mg02->mk01_id = $row->options['idkaryawan'];
            $mg02->mg01_id = $row->name;
            $mg02->nilgj = $row->price;
            $mg02->save();
        }

        Cart::destroy();

        return Redirect::to("master/karyawan");
    }

    public function saveKaryawanGaji() {
        $var = User::loginCheck([0, 1], 4);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        $id = Input::get("idkaryawan");
        $idgj = Input::get("idgj");
        $nilgj = Input::get("nilgj");

        // 1. setting validasi
        $messages = array(
            'required' => 'Inputan <b>Tidak Boleh Kosong</b>!',
            'numeric' => 'Inputan <b>Harus Angka</b>!',
            'same' => 'Password <b>Tidak Sama</b>!'
        );

        $validator = Validator::make(
                        Input::all(), array(
                    "idgj" => "required",
                    "nilgj" => "required|numeric"
                        ), $messages
        );

        // 2a. jika semua validasi terpenuhi simpan ke database
        if ($validator->passes()) {
            $mg02 = new mg02();
            $mg02->mk01_id = $id;
            $mg02->mg01_id = $idgj;
            $mg02->nilgj = $nilgj;
            $mg02->save();

            // Redirect ke url + menuju div tertentu
            $url = URL::action("MasterKaryawanController@edit", ['id' => $id]) . "#datatable";
            return Redirect::to($url);
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('master/karyawan/edit/' . $id . "#datatable")
                            ->withErrors($validator)
                            ->withInput();
        }
    }

    public function deleteKaryawanGaji($id) {
        $var = User::loginCheck([0, 1], 4);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        $mg02 = mg02::find($id);
        $idkar = $mg02->mk01_id;
        $mg02->delete();
        $url = URL::action("MasterKaryawanController@edit", ['id' => $idkar]) . "#datatable";
        return Redirect::to($url);
    }

    public function changeStatus($idkar) {
        $var = User::loginCheck([0, 1], 4);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        $mk01 = new mk01();
        $karyawan = $mk01::find($idkar);
        if ($karyawan->status == "Y") {
            $karyawan->status = "N";
        } else {
            $karyawan->status = "Y";
        }
        $karyawan->save();
        Session::flash('mk01_success', 'Data Telah Diubah!');
        return Redirect::to('master/karyawan');
    }

    public function getKaryawan($idkar) {
        $mk01 = mk01::find($idkar);
        echo json_encode($mk01);
    }

    public function saveReferral() {
        $var = User::loginCheck([0, 1], 4);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        $idreferral = Input::get("mk01_id_referral");
        $idkar = Input::get("idkaryawan");
        $mk02 = new mk02();
        $mk02->mk01_id_parent = $idkar;
        $mk02->mk01_id_child = $idreferral;
        $mk02->flglead = Input::get("leader");
        $mk02->save();
        Session::flash('mk01_success', 'Referral Telah Ditambahkan!');
        $url = URL::action("MasterKaryawanController@edit", ['id' => $idkar]) . "#datatable2";
        return Redirect::to($url);
    }

    public function deleteReferral($id, $idkar) {
        $var = User::loginCheck([0, 1], 4);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        $mk02 = mk02::find($id);
        $mk02->delete();
        Session::flash('mk01_success', 'Referral Telah Ditambahkan!');
        $url = URL::action("MasterKaryawanController@edit", ['id' => $idkar]) . "#datatable2";
        return Redirect::to($url);
    }

    public function usermatrix($id) {
//        $var = User::loginCheck([0, 1], 4);
//        if (!$var["bool"]) {
//            return Redirect::to($var["url"]);
//        }

        $sql = "select * from mm01";
        $data['usermatrixs'] = DB::select(DB::raw($sql));
        $sql = "SELECT * FROM `mm02` WHERE `mk01_id` = " . $id . " ORDER BY mm01_id ASC";
        $data['matrixs'] = DB::select(DB::raw($sql));
        $data['counter'] = 0;
        $data['maks'] = count($data['matrixs']);
        $data['id'] = $id;
        $data["usermatrik"] = User::getUserMatrix();
//        print_r($data['matrixs'][$data['counter']]->mm01_id);exit;
        return View::make('master.m_user_matrix', $data);
    }

    public function usermatrixsave($id) {

        $datas = Input::all();
        DB::table('mm02')->where('mk01_id', '=', $id)->delete();

        $insert = array();
        foreach ($datas as $data) {
            array_push($insert, array('mk01_id' => $id, 'mm01_id' => $data));
        }
        DB::table('mm02')->insert($insert);

        return Redirect::to('master/karyawan');
    }

    public function myaccount() {
        $success = Session::get('mk01_success');
        $userloginid = Session::get("user");
        $data = array(
            "karyawan" => mk01::find($userloginid["idkar"]),
            "mk01_success" => $success,
            "usermatrik" => User::getUserMatrix()
        );
        if ($userloginid["tipe"] == 1) {
            return View::make('myindografika.my_account', $data);
        } else {
            return View::make('master.my_account', $data);
        }
    }

    public function changepassword() {
        // 1. setting validasi
        $messages = array(
            'required' => 'Inputan <b>Tidak Boleh Kosong</b>!',
            'numeric' => 'Inputan <b>Harus Angka</b>!',
            'same' => 'Password <b>Tidak Sama</b>!'
        );

        $validator = Validator::make(
                        Input::all(), array(
                    "passwd" => "required",
                    "passwd2" => "required|same:passwd"
                        ), $messages
        );

        // 2a. jika semua validasi terpenuhi simpan ke database
        if ($validator->passes()) {
            $userloginid = Session::get("user");
            $passwd = Input::get("passwd");
            $mk01 = mk01::find($userloginid["idkar"]);
            $mk01->passwd = $passwd;
            $mk01->save();

            Session::flash('mk01_success', 'Data Telah Diubah!');
            return Redirect::to('myaccount');
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('myaccount')
                            ->withErrors($validator)
                            ->withInput();
        }
    }

}
