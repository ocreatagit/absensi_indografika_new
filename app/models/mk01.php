<?php

class mk01 extends Eloquent {

    protected $table = 'mk01';
    protected $primaryKey = 'idkar';

    // START Eloquent Relationship
    function mj01() {
        return $this->belongsTo('mj01', 'idjb');
    }

    function mj03() {
        return $this->hasMany("mj03");
    }

    function mg02() {
        return $this->hasMany("mg02");
    }

    function th01() {
        return $this->hasMany("th01");
    }

    function tt01() {
        return $this->hasMany("tt01");
    }

    function tg01() {
        return $this->hasMany("tg01");
    }

    // END Eloquent Relationship

    function getJamKerja($idkar) {
        return DB::table('mk01')
                        ->select("mj02.idjk", "mj02.tipe", "mj02.jmmsk", "mj02.jmklr", "mj02.status")
                        ->join("mj03", "mj03.mk01_id", "=", "mk01.idkar")
                        ->join("mj02", "mj02.idjk", "=", "mj03.mj02_id")
                        ->where("tipe", 1)
                        ->where("alt", 1)
                        ->where("selected", "Y")
                        ->where("idkar", $idkar)->first();
    }

    function getJamKerja_Alt1($idkar) {
        return DB::table('mk01')
                        ->select("mj02.idjk", "mj02.tipe", "mj02.jmmsk", "mj02.jmklr", "mj02.status")
                        ->join("mj03", "mj03.mk01_id", "=", "mk01.idkar")
                        ->join("mj02", "mj02.idjk", "=", "mj03.mj02_id")
                        ->where("tipe", 1)
                        ->where("alt", 2)
                        ->where("idkar", $idkar)->first();
    }

    function getJamKerja_Alt2($idkar) {
        return DB::table('mk01')
                        ->select("mj02.idjk", "mj02.tipe", "mj02.jmmsk", "mj02.jmklr", "mj02.status")
                        ->join("mj03", "mj03.mk01_id", "=", "mk01.idkar")
                        ->join("mj02", "mj02.idjk", "=", "mj03.mj02_id")
                        ->where("tipe", 1)
                        ->where("alt", 3)
                        ->where("idkar", $idkar)->first();
    }

    function getJamIstirahat($idkar) {
        return DB::table('mk01')
                        ->select("mj02.idjk", "mj02.tipe", "mj02.jmmsk", "mj02.jmklr", "mj02.status")
                        ->join("mj03", "mj03.mk01_id", "=", "mk01.idkar")
                        ->join("mj02", "mj02.idjk", "=", "mj03.mj02_id")
                        ->where("tipe", 2)
                        ->where("selected", "Y")
                        ->where("idkar", $idkar)->first();
    }

    function getAdminKaryawanAktif() {
        return $this->where('status', '=', 'Y')->orderBy('idkar', 'ASC')->get();
    }
    
    function getKaryawanAktif() {
        return $this->where('status', '=', 'Y')->where('jnsusr', '=', '2')->orderBy('idkar', 'ASC')->get();
    }

    function getAutoIncrement() {
        $sql = "SELECT AUTO_INCREMENT as idkar FROM information_schema.tables WHERE  TABLE_SCHEMA = 'absensi' AND TABLE_NAME = 'mk01'";
        $mk01 = DB::select(DB::raw($sql));
        $mk01 = $mk01[0];
        return $mk01->idkar;
    }

    function getReferral($idkar) {
        // Ambil Referral yang belum ada sesuai ID yang dipassing
        $sql = "SELECT * FROM mk01 WHERE mk01.idkar NOT IN (SELECT mk01_id_child FROM mk02 WHERE mk01_id_parent = $idkar);";
        $mk01 = DB::select(DB::raw($sql));
        return $mk01;
    }

    function getReferralKar($idkar) {
        // Ambil Referral yang sudah ditambahkan
        $sql = "SELECT mk02.id, mk02.mk01_id_parent, parent.nama as parent_name, mk02.mk01_id_child, child.nama as child_name, mk02.flglead FROM mk02 INNER JOIN mk01 parent ON parent.idkar = mk02.mk01_id_parent INNER JOIN mk01 child ON child.idkar = mk02.mk01_id_child WHERE mk02.mk01_id_parent = $idkar;";
//        echo $sql; exit;
        $mk01 = DB::select(DB::raw($sql));
        return $mk01;
    }

    function saveSuperAdminUserMatrix($idkaryawan) {
        $sql = "INSERT INTO mm02(mk01_id, mm01_id, created_at, updated_at)
                SELECT $idkaryawan, mm01.idmnu, '" . date('Y-m-d H:i:s') . "' , '" . date("Y-m-d H:i:s") . "'
                FROM mm01
                WHERE url NOT LIKE 'myindografika/%' OR url NOT LIKE 'myindografika%';";
        DB::select(DB::raw($sql));
        return TRUE;
    }

    function saveAdminUserMatrix($idkaryawan) {
        $sql = "INSERT INTO mm02(mk01_id, mm01_id, created_at, updated_at)
                SELECT $idkaryawan, mm01.idmnu,'" . date('Y-m-d H:i:s') . "', '" . date("Y-m-d H:i:s") . "'
                FROM mm01
                WHERE url NOT LIKE 'admin/%';";
        DB::select(DB::raw($sql));
        return TRUE;
    }

    function saveKaryawanUserMatrix($idkaryawan) {
        $sql = "INSERT INTO mm02(mk01_id, mm01_id, created_at, updated_at)
                SELECT $idkaryawan, mm01.idmnu, '" . date('Y-m-d H:i:s') . "', '" . date("Y-m-d H:i:s") . "'
                FROM mm01
                WHERE url LIKE 'myindografika/%' OR url like 'myindografika%';";
        DB::select(DB::raw($sql));
        return TRUE;
    }

    function get_all_jam_kerja($arrKar) {
        $counter = 0;
        $data = array();
        foreach ($arrKar as $karyawan) {
            $sql = "SELECT mj03.id, mj02.idjk, mj02.tipe, mj02.jmmsk, mj02.jmklr, mj03.mk01_id, mj03.alt, mj03.selected
                    FROM mj02
                    INNER JOIN mj03 ON mj03.mj02_id = mj02.idjk
                    WHERE mk01_id = " . $karyawan->idkar . " AND tipe = 1;";
            $jamkerja = DB::select(DB::raw($sql));

            $data[$karyawan->idkar] = $jamkerja;
            $counter++;
        }
        return $data;
    }

    function get_jam_kerja_karyawan($idkar) {
        $sql = "SELECT mj03.id, mj02.idjk, mj02.tipe, mj02.jmmsk, mj02.jmklr, mj03.mk01_id, mj03.alt, mj03.selected
                    FROM mj02
                    INNER JOIN mj03 ON mj03.mj02_id = mj02.idjk
                    WHERE mk01_id = " . $idkar . " AND tipe = 1;";
        $jamkerja = DB::select(DB::raw($sql));
        return $jamkerja;
    }

    function update_jam_kerja($mj02_id, $mk01_id, $alt) {
        $jamkerja = DB::table('mj03')
                        ->select("mj03.id")
                        ->where("mj02_id", $mj02_id)
                        ->where("mk01_id", $mk01_id)
                        ->where("alt", $alt)->first();

        $mj03 = mj03::find($jamkerja->id);
        $mj03->mj02 = $mj02_id;
        $mj03->save();
    }

}
