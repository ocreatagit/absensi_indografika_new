<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */

Route::get('/', function() {
    return Redirect::to('login');
});

//login
Route::get('login', 'loginController@index');
Route::get('error_404', 'loginController@error_404');
Route::post('login', 'loginController@login');
Route::get('logout', 'loginController@logout');

// Master Jam Kerja
Route::get('master/jamkerja', 'MasterJamKerjaController@index');
Route::post('master/jamkerja/create', 'MasterJamKerjaController@create');
Route::get('master/jamkerja/edit/{id}', 'MasterJamKerjaController@edit');
Route::post('master/jamkerja/update/{id}', 'MasterJamKerjaController@update');
Route::get('master/jamkerja/delete/{id}', 'MasterJamKerjaController@destroy');
Route::get('master/jamkerja/active/{id}', 'MasterJamKerjaController@active');

// Master Jabatan
Route::get('master/jabatan', 'MasterJabatanController@index');
Route::post('master/jabatan/create', 'MasterJabatanController@create');
Route::get('master/jabatan/edit/{id}', 'MasterJabatanController@edit');
Route::post('master/jabatan/update/{id}', 'MasterJabatanController@update');
Route::get('master/jabatan/delete/{id}', 'MasterJabatanController@destroy');

// Master Gaji
Route::get('master/jenisgaji', 'MasterGajiController@index');
Route::post('master/jenisgaji/create', 'MasterGajiController@create');
Route::get('master/jenisgaji/edit/{id}', 'MasterGajiController@edit');
Route::post('master/jenisgaji/update/{id}', 'MasterGajiController@update');
Route::get('master/jenisgaji/delete/{id}', 'MasterGajiController@destroy');

// Master Karyawan
Route::get('master/karyawan', 'MasterKaryawanController@index');
Route::get('master/karyawan/create', 'MasterKaryawanController@create');
Route::post('master/karyawan/store', 'MasterKaryawanController@store');
Route::get('master/karyawan/edit/{id}', 'MasterKaryawanController@edit');
Route::post('master/karyawan/update/{id}', 'MasterKaryawanController@update');
Route::get('master/karyawan/delete/{id}', 'MasterKaryawanController@destroy');
Route::get('master/karyawan/change_status/{id}', 'MasterKaryawanController@changeStatus');
Route::get('master/karyawan/add_gaji/{id}', 'MasterKaryawanController@addGaji');
Route::post('master/karyawan/insert_item_gaji/{id}', 'MasterKaryawanController@saveItemGaji');
Route::get('master/karyawan/delete_item_gaji/{rowid}/{id}', 'MasterKaryawanController@deleteItemGaji');
Route::get('master/karyawan/save_gaji/{id}', 'MasterKaryawanController@saveGaji');
Route::post('master/karyawan/save_karyawan_gaji', 'MasterKaryawanController@saveKaryawanGaji');
Route::get('master/karyawan/delete_karyawan_gaji/{id}', 'MasterKaryawanController@deleteKaryawanGaji');

Route::get('master/karyawan/add_jam_kerja/{id}', 'MasterKaryawanController@addJamKerja');
Route::post('master/karyawan/save_item_jam_kerja_karyawan/{id}', 'MasterKaryawanController@saveItemJamKerja');
Route::get('master/karyawan/delete_item_jam_kerja_karyawan/{rowid}/{id}', 'MasterKaryawanController@deleteItemJamKerja');

Route::post('master/karyawan/save_jam_kerja_karyawan/{id}', 'MasterKaryawanController@saveJamKerja');
Route::get('master/karyawan/delete_jam_kerja_karyawan/{rowid}/{id}', 'MasterKaryawanController@deleteJamKerja');

Route::get('master/karyawan/get_karyawan/{id}', 'MasterKaryawanController@getKaryawan');
Route::get('master/karyawan/get_jenis_jam_kerja/{id}', 'MasterKaryawanController@getJenisJamKerja');
Route::get('master/karyawan/get_hari_jam_kerja/{id}', 'MasterKaryawanController@getHariJamKerja');
Route::post('master/karyawan/save_referral_karyawan', 'MasterKaryawanController@saveReferral');
Route::get('master/karyawan/delete_referral_karyawan/{id}/{idkar}', 'MasterKaryawanController@deleteReferral');
Route::get('master/karyawan/set_jam_kerja/{id}', 'MasterKaryawanController@setJamKerja');

//Fitur
Route::get('myindografika', "FiturController@myindografika");

Route::get('myindografika/gajikaryawan', "FiturController@histori_pembayaran_gaji");
Route::post('myindografika/gajikaryawan', "FiturController@histori_pembayaran_gaji_query");
Route::get('myindografika/detail_gaji_karyawan/{id}', "FiturController@show_gaji");

Route::get('myindografika/tabungankaryawan', "FiturController@histori_tabungan");
Route::post('myindografika/tabungankaryawan', "FiturController@histori_tabungan_query");

Route::get('myindografika/pinjamankaryawan', "FiturController@histori_hutang");
Route::post('myindografika/pinjamankaryawan', "FiturController@histori_hutang_query");
Route::get('myindografika/detail_pinjaman_karyawan/{id}', "FiturController@show_pinjaman");

Route::get('myindografika/omzetkaryawan', "FiturController@histori_omzet");
Route::post('myindografika/omzetkaryawan', "FiturController@histori_omzet_query");

Route::get('myindografika/presensikaryawan', "FiturController@presensi_karyawan");
Route::post('myindografika/presensikaryawan', "FiturController@presensi_karyawan_query");

// end fitur

// Admin

Route::get('admin/allgajikaryawan', "LaporanAdminController@histori_pembayaran_gaji");
Route::post('admin/allgajikaryawan', "LaporanAdminController@histori_pembayaran_gaji_query");
Route::get('admin/detail_gaji_karyawan/{id}', "LaporanAdminController@show_gaji");

Route::get('admin/alltabungankaryawan', "LaporanAdminController@histori_tabungan");
Route::post('admin/detail_tabungan_karyawan', "LaporanAdminController@histori_tabungan_query");
Route::get('admin/detail_tabungan_karyawan/{id}', "LaporanAdminController@show_tabungan");

Route::get('admin/allpinjamankaryawan', "LaporanAdminController@histori_hutang");
Route::post('admin/allpinjamankaryawan', "LaporanAdminController@histori_hutang_query");
Route::get('admin/detail_pinjaman_karyawan/{id}', "LaporanAdminController@show_pinjaman");

Route::get('admin/allomzetkaryawan', "LaporanAdminController@histori_omzet");
Route::post('admin/allomzetkaryawan', "LaporanAdminController@histori_omzet_query");

Route::get('admin/allpresensikaryawan', "LaporanAdminController@presensi_karyawan");
Route::post('admin/allpresensikaryawan', "LaporanAdminController@presensi_karyawan_query");

Route::get('admin/allpresensikaryawan', "LaporanAdminController@presensi_karyawan");
Route::post('admin/allpresensikaryawan', "LaporanAdminController@presensi_karyawan_query");

Route::get('admin/adminlaporankaryawan', "LaporanAdminController@laporan_karyawan");
Route::post('admin/adminlaporankaryawan', "LaporanAdminController@laporan_karyawan_query");
Route::post('admin/exportadminlaporankaryawan', "LaporanAdminController@laporan_karyawan_export");

Route::get('admin/persenbonus', "LaporanAdminController@persen_bonus_karyawan");
Route::post('admin/persenbonus', "LaporanAdminController@persen_bonus_karyawan_save");
Route::post('admin/persenbonus_admin', "LaporanAdminController@persen_bonus_karyawan_admin_save");

// end Admin

// Input data
// Transaksi Hutang
Route::get('inputdata/hutang', "TransaksiHutangController@index");
Route::post('inputdata/hutang/store', "TransaksiHutangController@store");
Route::get('inputdata/hutang/delete/{id}', "TransaksiHutangController@destroy");
Route::get('inputdata/hutang/edit/{id}', "TransaksiHutangController@edit");
Route::post('inputdata/hutang/update/{id}', "TransaksiHutangController@update");

// Transaksi Tabungan
Route::get('inputdata/tabungan', "TransaksiTabunganController@index");
Route::post('inputdata/tabungan/store', "TransaksiTabunganController@store");
Route::get('inputdata/tabungan/delete/{id}', "TransaksiTabunganController@destroy");
Route::get('inputdata/tabungan/edit/{id}', "TransaksiTabunganController@edit");
Route::post('inputdata/tabungan/update/{id}', "TransaksiTabunganController@update");

// Transaksi Gaji
Route::get('inputdata/gaji', "TransaksiGajiController@index");
Route::get('inputdata/show_gaji_karyawan', "TransaksiGajiController@show");
Route::get('inputdata/trans_gaji_karyawan/{id}', "TransaksiGajiController@create");
Route::get('inputdata/gaji_karyawan_detail/{id}', "TransaksiGajiController@detail");
Route::post('inputdata/save_trans_gaji_karyawan', "TransaksiGajiController@store");
Route::get('inputdata/delete_trans_gaji_karyawan/{id}', "TransaksiGajiController@destroy");
Route::post('inputdata/save_all_trans_gaji', "TransaksiGajiController@saveall");

// Transaksi Transfer Gaji
Route::get('inputdata/transfer', "TransaksiTransferController@index");
Route::get('inputdata/detail/{id}', "TransaksiTransferController@show");
Route::post('inputdata/simpan_gaji_bonus', "TransaksiTransferController@savebonus");
Route::get('inputdata/bayar_gaji/{id}', "TransaksiTransferController@payment");
Route::get('inputdata/print_gaji/{id}', "TransaksiTransferController@printgaji");
Route::post('inputdata/saveall', "TransaksiTransferController@saveall");

// Transaksi Omzet
Route::get('inputdata/omzet', "TransaksiOmzetController@index");
Route::get('inputdata/omzet_karyawan', "TransaksiOmzetController@create");
Route::post('inputdata/save_omzet_karyawan', "TransaksiOmzetController@store");
Route::get('inputdata/delete/{id}', "TransaksiOmzetController@destroy");

// Transaksi Tarik Tabungan
Route::get('inputdata/tarik_tabungan', "TransaksiTarikTabunganController@index");
Route::post('inputdata/update_saldo_tabungan', "TransaksiTarikTabunganController@update_saldo_tabungan");
Route::get('inputdata/batal_saldo/{id}', "TransaksiTarikTabunganController@delete");

// Transaksi Input Absensi
Route::get('inputdata/absensi', "TransaksiAbsensiController@index");
Route::get('inputdata/absensi_jam_kerja/{id}', "TransaksiAbsensiController@show");
Route::post('inputdata/absensi_store/{id}', "TransaksiAbsensiController@store");

// Transaksi Input Absensi (Cuti dan Alpha)
Route::get('inputdata/alpha', "TransaksiAlphaController@index");
Route::post('inputdata/save_alpha', "TransaksiAlphaController@store");
Route::get('inputdata/delete_alpha/{id}', "TransaksiAlphaController@destroy");

// Transaksi Input Saldo Tabungan
Route::get('inputdata/saldotabungan', "TransaksiSaldoTabunganController@index");
Route::get('inputdata/saldotabungan/{id}', "TransaksiSaldoTabunganController@show");
Route::post('inputdata/save_saldotabungan', "TransaksiSaldoTabunganController@store");
Route::post('inputdata/save_saldotabungan/{id}', "TransaksiSaldoTabunganController@update");
// End Input data

Route::get('daftarmasuk', function() {
    date_default_timezone_set('Asia/Jakarta');
    $data = array(
        "usermatrik" => User::getUserMatrix()
    );
    return View::make('daftar.masuk', $data);
});
Route::get('getTimeServer', 'DaftarController@getTimeServer');
Route::get('getDateServer', 'DaftarController@getDateServer');
Route::get('getDaftarMasuk', 'DaftarController@getDaftarMasuk');

Route::get('daftarpulang', function() {
    date_default_timezone_set('Asia/Jakarta');
    $data = array(
        "usermatrik" => User::getUserMatrix()
    );
    return View::make('daftar.pulang', $data);
});
Route::get('getDaftarPulang', 'DaftarController@getDaftarPulang');

Route::get('daftarlembur', function() {
    date_default_timezone_set('Asia/Jakarta');
    $data = array(
        "usermatrik" => User::getUserMatrix()
    );
    return View::make('daftar.lembur', $data);
});

Route::get('absen', function() {
    return View::make('absen1');
});

Route::get('getAbsen', 'HomeController@getAbsen');
Route::get('myaccount', 'MasterKaryawanController@myaccount');
Route::post('changepassword', 'MasterKaryawanController@changepassword');
Route::get('usermatrix/{id}', 'MasterKaryawanController@usermatrix');
Route::post('usermatrix/{id}', 'MasterKaryawanController@usermatrixsave');