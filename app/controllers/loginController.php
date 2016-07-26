<?php

class loginController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $data["login_failed"] = Session::get('login_failed');
        return View::make('login', $data);
    }

    public function login() {
        $data = Input::all();
        $rules = array(
            'usernm' => 'required',
            'password' => 'required',
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return Redirect::to('login')->withInput(Input::except('password'))->withErrors($validator);
        } else {
            $usernm = Input::get('usernm');
            $passwd = Input::get('password');

            $sql = "SELECT * FROM mk01 WHERE usernm = '" . $usernm."'";
            $kar = DB::select(DB::raw($sql));
            if (!empty($kar)) {
                if ($kar[0]->passwd == $passwd) {
                    Session::put('user.idkar', $kar[0]->idkar);
                    Session::put('user.nama', $kar[0]->nama);
                    Session::put('user.tipe', $kar[0]->jnsusr);

                    if ($kar[0]->jnsusr == 2) {
                        return Redirect::to('myindografika/presensikaryawan');
                    } else if ($kar[0]->jnsusr == 2) {
                        return Redirect::to('myindografika/gajikaryawan');
                    } else {
                        return Redirect::to('master/jamkerja');
                    }
                } else {
                    Session::flash('login_failed', 'Password yang diinputkan Salah!');
                }
            } else {
                Session::flash('login_failed', 'Username Tidak Terdaftar!');
            }
            return Redirect::to('login');
        }
    }

    public function logout() {
        Session::forget('user');
        return Redirect::to('/');
    }

    public function error_404() {
        return View::make('template.error');
    }

}
