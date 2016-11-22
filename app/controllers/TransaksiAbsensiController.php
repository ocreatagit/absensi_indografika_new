<?php

class TransaksiAbsensiController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $var = User::loginCheck([0, 1], 24);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        $success = Session::get('ta01_success');
        $danger = Session::get('ta01_danger');
        $ta01 = new ta01();
        $data = array(
            "karyawans" => mk01::where("status", "=", "Y")->where("jnsusr", "=", 2)->get(),
            "ta01_success" => $success,
            "ta01_danger" => $danger,
            "usermatrik" => User::getUserMatrix()
        );
        return View::make('transaksi.trans_absensi', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($id) {
        $var = User::loginCheck([0, 1], 24);
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
                    "tglabs" => "required",
                    "jmmsk" => "required"
                        ), $messages
        );

        if ($validator->passes()) {
            if (Input::get("btn_tambah") != NULL) {
                $tanggal = Input::get('tglabs');
                $abscd = Input::get('abscd');
                $jam = Input::get('jmmsk');
                $ta01_id = Presensi::GetTa01_id($id, $tanggal);
                if ($ta01_id) {
                    if ($ta02_id = Presensi::CheckPresensi($id, $ta01_id, $tanggal, $abscd)) {
                        Presensi::UpdatePresensi($ta02_id, $tanggal, $jam);
                    } else {
                        Presensi::InsertPresensi($id, $ta01_id, $tanggal, $jam, $abscd);
                    }
                } else {
                    try {
                        DB::beginTransaction();
                        date_default_timezone_set('Asia/Jakarta');
                        $date = Date('Y-m-d H:i:s');
                        $MJ03 = DB::table('mj03')
                                ->where('mk01_id', $id)
                                ->first();
                        $TA01 = DB::table('ta01')
                                ->where('tglabs', date("Y-m-d"))
                                ->where('idjk', $MJ03->mj02_id)
                                ->first();
                        if ($TA01 == null) {
                            $MJ02 = DB::table('mj02')
                                    ->where('idjk', $MJ03->mj02_id)
                                    ->first();
                            $sql = "SELECT AUTO_INCREMENT as idabs FROM information_schema.tables WHERE  TABLE_SCHEMA = 'absensi' AND TABLE_NAME = 'ta01'";
                            $TA01 = DB::select(DB::raw($sql));
                            $TA01 = $TA01[0];
                            DB::table('ta01')->insert(
                                    array('tglabs' => date("Y-m-d"),
                                        'tipe' => $MJ02->tipe,
                                        'idjk' => $MJ03->mj02_id,
                                        'created_at' => $date,
                                        'updated_at' => $date)
                            );
                        }
                        $absen = DB::table('ta02')
                                ->where('mk01_id', $id)
                                ->where('abscd', $abscd)
                                ->whereDate('tglmsk', '=', $tanggal)
                                ->first();
                        if (!$absen) {
                            DB::table('ta02')->insert(
                                    array('ta01_id' => $TA01->idabs,
                                        'mk01_id' => $id,
                                        'tglmsk' => date("Y-m-d", strtotime($tanggal)) . " " . $jam,
                                        'abscd' => $abscd,
                                        'created_at' => $date,
                                        'updated_at' => $date)
                            );
                        }
                        DB::commit();
                    } catch (Exception $e) {
                        DB::rollback();
                    }
                }
                return Redirect::to("inputdata/absensi_jam_kerja/" . $id);
            } else if(Input::get("btn_hapus") != NULL) {
                $tanggal = Input::get('tglabs');
                $abscd = Input::get('abscd');
                $jam = Input::get('jmmsk');
                $ta01_id = Presensi::GetTa01_id($id, $tanggal);
                if ($ta01_id) {
                    if ($ta02_id = Presensi::CheckPresensi($id, $ta01_id, $tanggal, $abscd)) {
                        Presensi::DeletePresensi($ta02_id);
                    }
                    return Redirect::to("inputdata/absensi_jam_kerja/" . $id);
                }
            } else if (Input::get("btn_cari") != NULL) {
                $success = Session::get('ta01_success');
                $danger = Session::get('ta01_danger');
                $ta01 = new ta01();
                $data = array(
                    "karyawan" => mk01::find($id),
                    "jamkerjas" => $ta01->getJamKerjaKaryawan($id),
                    "ta01_success" => $success,
                    "ta01_danger" => $danger,
                    "tglabs" => Input::get('tglabs'),
                    "usermatrik" => User::getUserMatrix(),
                    "presensies" => Presensi::getPresensi($id, date("Y-m-d", strtotime(Input::get('tglabs'))), date("Y-m-d", strtotime(Input::get('tglabs'))))
                );
                return View::make('transaksi.trans_absensi_jam_kerja', $data);
            }
        } else {
            return Redirect::to('inputdata/absensi_jam_kerja/' . $id)
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
        $var = User::loginCheck([0, 1], 24);
        if (!$var["bool"]) {
            return Redirect::to($var["url"]);
        }

        $success = Session::get('ta01_success');
        $danger = Session::get('ta01_danger');
        $ta01 = new ta01();
        $data = array(
            "karyawan" => mk01::find($id),
            "jamkerjas" => $ta01->getJamKerjaKaryawan($id),
            "ta01_success" => $success,
            "ta01_danger" => $danger,
            "usermatrik" => User::getUserMatrix(),
            "tglabs" => date("d-m-Y"),
            "presensies" => Presensi::getPresensi($id, date("Y-m-d"), date("Y-m-d"))
        );
        return View::make('transaksi.trans_absensi_jam_kerja', $data);
    }

    public function query() {
        
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
