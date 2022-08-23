<?php



class M_admin extends CI_Model
{
    //ambil data
    public function ambilData($table, $where = NULL)
    {
        if ($where == null || $where == "") {
            $query = $this->db->get($table);
        } else {
            $query = $this->db->get_where($table, $where);
        }
        return $query;
    }

    //input data
    public function inputData($data, $table)
    {
        $this->db->insert($table, $data);
        return $this->db->affected_rows();
    }

    //hapus data
    public function delete($where, $table)
    {
        $this->db->delete($where, $table);
        return $this->db->affected_rows();
    }

    public function update($table, $data, $where)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }


    //tampilkan wilayah()
    public function showWilayah($id)
    {
        $query =  $this->db->query("SELECT c.id , c.comp_name  , w.others ,  w.site_name , w.id  , w.status 
        FROM admisecsgp_mstcmp c , admisecsgp_mstsite w 
        WHERE c.id = w.admisecsgp_mstcmp_id and w.id = '" . $id . "'  ");
        return $query;
    }

    public function detailWilayah($id)
    {
        $query =  $this->db->query("SELECT c.id , c.comp_name , w.others, w.site_name , w.id  , w.status  , w.admisecsgp_mstcmp_id
        FROM admisecsgp_mstcmp c , admisecsgp_mstsite w  
        WHERE c.id = w.admisecsgp_mstcmp_id  and w.id = " . $id . " ");
        return $query;
    }


    //tampilkan plant
    public function showPlant($id)
    {
        $query =  $this->db->query("SELECT c.comp_name , p.id ,  p.plant_name ,  w.site_name , p.admisecsgp_mstsite_id , p.status  , p.others , p.kode_plant
        FROM admisecsgp_mstplant p , admisecsgp_mstsite w  , admisecsgp_mstcmp c
        WHERE p.admisecsgp_mstsite_id = w.id and w.admisecsgp_mstcmp_id = c.id and w.id = '" . $id . "'  ");
        return $query;
    }

    public function detailPlant($id)
    {
        $query =  $this->db->query("SELECT c.comp_name , c.id , w.site_name , p.id , p.plant_name , p.status , p.others , p.admisecsgp_mstsite_id  , w.admisecsgp_mstcmp_id , p.kode_plant 
        FROM admisecsgp_mstplant p , admisecsgp_mstsite w  , admisecsgp_mstcmp c 
        WHERE w.admisecsgp_mstcmp_id = c.id and p.admisecsgp_mstsite_id = w.id and w.admisecsgp_mstcmp_id = c.id 
         and p.id = " . $id . "   ");
        return $query;
    }
    //


    //tampilkan data zona
    public function showZona($id)
    {
        $query =  $this->db->query("SELECT z.id , z.zone_name,  z.others , z.status , z.status,  p.plant_name , w.site_name , z.kode_zona  FROM admisecsgp_mstplant p, admisecsgp_mstzone z   ,  admisecsgp_mstsite w
         WHERE z.admisecsgp_mstplant_id = p.id and w.id = p.admisecsgp_mstsite_id and w.id = '" . $id . "' ");
        return $query;
    }

    public function detailZona($id)
    {
        $query =  $this->db->query("SELECT z.zone_name , z.id , z.kode_zona , w.site_name ,p.plant_name , z.status , z.others , z.admisecsgp_mstplant_id , p.plant_name , p.admisecsgp_mstsite_id
         FROM admisecsgp_mstplant p , admisecsgp_mstsite w  , admisecsgp_mstzone z
         WHERE   z.admisecsgp_mstplant_id = p.id and w.id = p.admisecsgp_mstsite_id  and p.id = z.admisecsgp_mstplant_id  and z.id = " . $id . "    ");
        return $query;
    }


    //tampilkan checkPoint()
    public function showCheckpoint($id)
    {
        $query =  $this->db->query("SELECT c.id ,  c.check_name ,  c.others  , c.status , c.durasi, z.zone_name,  p.plant_name  , c.check_no, z.admisecsgp_mstplant_id  as plant_id , c.admisecsgp_mstzone_id as zona_id
        FROM admisecsgp_mstplant p, admisecsgp_mstzone z  , admisecsgp_mstckp c , admisecsgp_mstsite w
        WHERE z.admisecsgp_mstplant_id = p.id AND z.id = c.admisecsgp_mstzone_id  AND w.id = '" . $id . "' AND p.admisecsgp_mstsite_id = w.id order by c.id DESC ");
        return $query;
    }


    public function detailCheckpoint($id)
    {
        $query =  $this->db->query("SELECT z.zone_name , c.id  , w.site_name ,p.plant_name , z.status , z.others , z.admisecsgp_mstplant_id , p.plant_name , c.durasi , 
        c.check_name , c.check_no , c.admisecsgp_mstzone_id , c.status
        FROM admisecsgp_mstplant p , admisecsgp_mstsite w  , admisecsgp_mstzone z , admisecsgp_mstckp c
        WHERE   z.admisecsgp_mstplant_id = p.id and c.admisecsgp_mstzone_id = z.id and c.id = " . $id . "  ");
        return $query;
    }

    //upload data checkpoint
    public function uploadCheckpoint($filename)
    {
        $this->load->library('upload');
        $config['upload_path']        = './assets/path_upload/';
        $config['allowed_types']      = 'xlsx';
        $config['max_size']           = '15048';
        $config['overwrite']          = true;
        $config['file_name']          = $filename;

        $this->upload->initialize($config);
        if ($this->upload->do_upload('file')) {
            //jik berhasil
            $return = array('result' => 'success', 'file'    => $this->upload->data(), 'error' => '');
            return $return;
        } else {
            $return = array('result' => 'gagal', 'file' => '', 'error' => $this->upload->display_errors());
            return $return;
        }
    }


    //multiple upload
    public function mulitple_upload($table, $var)
    {
        return $this->db->insert_batch($table, $var);
    }

    //multiple delete 
    public function multiple_delete($table, $data)
    {
        $total = count($data);
        for ($i = 0; $i < $total; $i++) {
            $this->db->where('id', $data[$i]);
            $this->db->delete($table);
        }
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    //tampilkan kategori objek
    public function kategoriObjek($id)
    {
        $query =  $this->db->query("SELECT ko.id , ko.kategori_name , ko.status, ko.others, ko.admisecsgp_mstzone_id as zona_id , zn.zone_name , pl.plant_name , zn.admisecsgp_mstplant_id as plant_id from admisecsgp_mstkobj ko , admisecsgp_mstzone zn , admisecsgp_mstplant pl WHERE ko.admisecsgp_mstzone_id = zn.id AND zn.admisecsgp_mstplant_id = pl.id and pl.admisecsgp_mstsite_id = '" . $id . "'  order by ko.id desc ");
        return $query;
    }

    //tampilkan kategori objek
    public function detailkategoriObjek($id)
    {
        $query =  $this->db->query("SELECT ko.id , ko.kategori_name , ko.status, ko.others, ko.admisecsgp_mstzone_id as zona_id , zn.zone_name , pl.plant_name  , zn.admisecsgp_mstplant_id as plant_id from admisecsgp_mstkobj ko , admisecsgp_mstzone zn , admisecsgp_mstplant pl WHERE ko.admisecsgp_mstzone_id = zn.id AND zn.admisecsgp_mstplant_id = pl.id AND ko.id='" . $id . "' ");
        return $query;
    }

    // tampilkan event 
    public function showEvent($id)
    {
        $query = $this->db->query("SELECT ed.id , e.event_name , c.check_name , o.nama_objek, zn.zone_name , pl.plant_name , zn.admisecsgp_mstplant_id as plant_id , c.admisecsgp_mstzone_id as zona_id  , o.admisecsgp_mstckp_id as check_id , ed.admisecsgp_mstobj_id as objek_id , ed.status from admisecsgp_msteventdtls ed , admisecsgp_mstevent e , admisecsgp_mstplant pl  , admisecsgp_mstzone zn , admisecsgp_mstckp c , admisecsgp_mstobj o  WHERE ed.admisecsgp_mstevent_id = e.id and ed.admisecsgp_mstobj_id = o.id and zn.admisecsgp_mstplant_id = pl.id and c.admisecsgp_mstzone_id = zn.id and o.admisecsgp_mstckp_id = c.id and pl.admisecsgp_mstsite_id = '" . $id . "' order by ed.id desc  ");
        return $query;
    }


    //detail event 
    public function detailEvent($id)
    {
        $query = $this->db->query("SELECT ed.id , e.event_name , c.check_name , o.nama_objek, zn.zone_name , pl.plant_name , zn.admisecsgp_mstplant_id as plant_id , c.admisecsgp_mstzone_id as zona_id  , o.admisecsgp_mstckp_id as check_id , ed.admisecsgp_mstobj_id as objek_id , ed.admisecsgp_mstevent_id as event_id , ed.status from admisecsgp_msteventdtls ed , admisecsgp_mstevent e , admisecsgp_mstplant pl  , admisecsgp_mstzone zn , admisecsgp_mstckp c , admisecsgp_mstobj o  WHERE ed.admisecsgp_mstevent_id = e.id and ed.admisecsgp_mstobj_id = o.id and zn.admisecsgp_mstplant_id = pl.id and c.admisecsgp_mstzone_id = zn.id and o.admisecsgp_mstckp_id = c.id   and e.id = '" . $id . "' ");
        return $query;
    }

    //tampilkan object
    public function showObject($id)
    {
        $query =  $this->db->query("SELECT o.id , o.nama_objek  , z.zone_name , k.kategori_name ,  c.check_name  , o.status , o.others  , p.plant_name , z.admisecsgp_mstplant_id as plant_id ,o.admisecsgp_mstckp_id as id_check , c.admisecsgp_mstzone_id as zona_id 
        FROM  admisecsgp_mstobj o , admisecsgp_mstzone z , admisecsgp_mstkobj k  , admisecsgp_mstckp c , admisecsgp_mstplant p 
        WHERE  o.admisecsgp_mstckp_id = c.id and k.id = o.admisecsgp_mstkobj_id and  
        z.id = c.admisecsgp_mstzone_id  and p.id = z.admisecsgp_mstplant_id and p.admisecsgp_mstsite_id = '" . $id . "' order by o.id desc ");
        return $query;
    }

    //detail objek
    public function detailObjek($id)
    {
        $query =  $this->db->query("SELECT o.id , o.nama_objek  , z.zone_name, z.id as zona_id  ,  k.kategori_name  , o.admisecsgp_mstkobj_id as kategori_id,  c.check_name , c.id as check_id  , o.status , o.others  , p.plant_name , z.admisecsgp_mstplant_id as plant_id , o.admisecsgp_mstckp_id , o.admisecsgp_mstkobj_id , c.admisecsgp_mstzone_id 
        FROM  admisecsgp_mstobj o , admisecsgp_mstzone z , admisecsgp_mstkobj k , admisecsgp_mstckp c  , admisecsgp_mstplant p 
        WHERE  o.admisecsgp_mstckp_id = c.id   and k.id = o.admisecsgp_mstkobj_id  and z.id = c.admisecsgp_mstzone_id  and p.id = z.admisecsgp_mstplant_id and k.admisecsgp_mstzone_id = z.id and o.id = " . $id . "  ");
        return $query;
    }

    //upload data objek
    public function uploadObjek($filename)
    {
        $this->load->library('upload');
        $config['upload_path']        = './assets/path_upload/';
        $config['allowed_types']      = 'xlsx';
        $config['max_size']           = '15048';
        $config['overwrite']          = true;
        $config['file_name']          = $filename;

        $this->upload->initialize($config);
        if ($this->upload->do_upload('file')) {
            //jik berhasil
            $return = array('result' => 'success', 'file'    => $this->upload->data(), 'error' => '');
            return $return;
        } else {
            $return = array('result' => 'gagal', 'file' => '', 'error' => $this->upload->display_errors());
            return $return;
        }
    }


    // tampilkan zona dan plant
    public function zonePlant($idSite)
    {
        $query = $this->db->query("select zn.id ,  zn.zone_name , plt.plant_name    from admisecsgp_mstplant plt , admisecsgp_mstzone zn 
        where zn.admisecsgp_mstplant_id = plt.id and zn.status = 1 and plt.admisecsgp_mstsite_id = '" . $idSite . "'  ");
        return $query;
    }


    //tampilkan user
    public function showUser($idSite)
    {
        $query =  $this->db->query("SELECT u.id , u.name , u.npk , u.admisecsgp_mstroleusr_id , r.level , c.comp_name , s.site_name , p.plant_name  , u.status 
        FROM admisecsgp_mstusr u , admisecsgp_mstroleusr r , admisecsgp_mstcmp c , admisecsgp_mstsite s , admisecsgp_mstplant p
        WHERE u.admisecsgp_mstroleusr_id = r.id and c.id = s.admisecsgp_mstcmp_id and u.admisecsgp_mstsite_id = s.id and p.id = u.admisecsgp_mstplant_id  and u.admisecsgp_mstsite_id = '" . $idSite . "' and r.level='SECURITY'  ");
        return $query;
    }

    public function detailUser($id)
    {
        $query =  $this->db->query("SELECT u.id , u.name , u.npk , u.admisecsgp_mstroleusr_id , r.level , c.comp_name , s.site_name , p.plant_name  , u.status , u.admisecsgp_mstplant_id , u.admisecsgp_mstsite_id 
        FROM admisecsgp_mstusr u , admisecsgp_mstroleusr r , admisecsgp_mstcmp c , admisecsgp_mstsite s
        , admisecsgp_mstplant p
        WHERE u.admisecsgp_mstroleusr_id = r.id and c.id = s.admisecsgp_mstcmp_id and u.admisecsgp_mstsite_id = s.id and p.id = u.admisecsgp_mstplant_id and u.id = '" . $id . "' ");
        return $query;
    }


    //jadwal patroli  dan produksi
    public function uploadJadwal($filename)
    {
        $this->load->library('upload');
        $config['upload_path']        = './assets/path_upload/';
        $config['allowed_types']      = 'xlsx';
        $config['max_size']           = '15048';
        $config['overwrite']          = true;
        $config['file_name']          = $filename;

        $this->upload->initialize($config);
        if ($this->upload->do_upload('file')) {
            //jik berhasil
            $return = array('result' => 'success', 'file'    => $this->upload->data(), 'error' => '');
            return $return;
        } else {
            $return = array('result' => 'gagal', 'file' => '', 'error' => $this->upload->display_errors());
            return $return;
        }
    }

    //show jadwal patroli 
    public function showJadwal($tahun, $bulan, $plant)
    {
        $query = $this->db->query("SELECT pl.plant_name , usr.name , usr.npk , jdl.tanggal_1 , jdl.tanggal_2 , jdl.tanggal_3  , jdl.tanggal_4 , jdl.tanggal_5 , jdl.tanggal_6  , jdl.tanggal_7 , jdl.tanggal_8 , jdl.tanggal_9  , jdl.tanggal_10 , jdl.tanggal_11 , jdl.tanggal_12, jdl.tanggal_13 , jdl.tanggal_14 , jdl.tanggal_15  , jdl.tanggal_16 , jdl.tanggal_17 , jdl.tanggal_18  , jdl.tanggal_19 , jdl.tanggal_20 , jdl.tanggal_21  , jdl.tanggal_22 , jdl.tanggal_23 , jdl.tanggal_24 , jdl.tanggal_25 , jdl.tanggal_26 , jdl.tanggal_27  , jdl.tanggal_28 , jdl.tanggal_29 , jdl.tanggal_30, jdl.tanggal_31 from admisecsgp_mstjadwalpatroli jdl , admisecsgp_mstusr usr , admisecsgp_mstplant pl  
        where  jdl.admisecsgp_mstplant_id = pl.id and jdl.admisecsgp_mstusr_id = usr.id and jdl.bulan = '" . $bulan . "' and tahun = '" . $tahun . "' 
        and pl.kode_plant = '" . $plant . "' and jdl.status = 1 
        ");
        return $query;
    }


    //tampil petugas patroli per tanggal
    public function petugasPerTanggal($col_tanggal, $bulan, $tahun, $plant_id)
    {
        $query = $this->db->query("SELECT ptr.id ,   $col_tanggal , u.name ,u.npk  , p.plant_name ,p.id as id_plant , u.id as id_user from admisecsgp_mstjadwalpatroli ptr  , admisecsgp_mstusr u , admisecsgp_mstplant p   where ptr.admisecsgp_mstusr_id = u.id  and p.id = ptr.admisecsgp_mstplant_id and ptr.admisecsgp_mstplant_id = $plant_id and ptr.bulan ='" . $bulan . "' and ptr.tahun ='" . $tahun . "'  ");
        return $query;
    }


    //show jadwal produksi 
    public function showProduksi($tahun, $bulan, $plant)
    {
        $query = $this->db->query("SELECT
        prd.tahun ,prd.bulan ,
        plt.plant_name ,
        zn.zone_name , 
        sh.nama_shift,
        IF(ss_1 = 1 , 'ON','OFF') AS TGL_1 ,IF(ss_2 = 1 , 'ON','OFF') AS TGL_2 ,IF(ss_3 = 1 , 'ON','OFF') AS TGL_3,
        IF(ss_4 = 1 , 'ON','OFF') AS TGL_4 ,IF(ss_5 = 1 , 'ON','OFF') AS TGL_5 ,IF(ss_6 = 1 , 'ON','OFF') AS TGL_6 ,
        IF(ss_7 = 1 , 'ON','OFF') AS TGL_7 ,IF(ss_8 = 1 , 'ON','OFF') AS TGL_8 ,IF(ss_9 = 1 , 'ON','OFF') AS TGL_9 ,
        IF(ss_10 = 1 ,'ON','OFF') AS TGL_10 ,IF(ss_11 = 1 ,'ON','OFF') AS TGL_11 ,IF(ss_12 = 1 ,'ON','OFF') AS TGL_12 ,
        IF(ss_13 = 1 , 'ON','OFF') AS TGL_13 ,IF(ss_14 = 1 , 'ON','OFF') AS TGL_14 ,IF(ss_15 = 1 , 'ON','OFF') AS TGL_15,IF(ss_16 = 1 , 'ON','OFF') AS TGL_16 ,
        IF(ss_17 = 1 , 'ON','OFF') AS TGL_17 ,IF(ss_18 = 1 , 'ON','OFF') AS TGL_18 ,IF(ss_19 = 1 , 'ON','OFF') AS TGL_19 ,
        IF(ss_20 = 1 , 'ON','OFF') AS TGL_20 ,IF(ss_21 = 1 , 'ON','OFF') AS TGL_21 ,IF(ss_22 = 1 , 'ON','OFF') AS TGL_22 ,
        IF(ss_23 = 1 ,'ON','OFF') AS TGL_23 ,IF(ss_24 = 1 ,'ON','OFF') AS TGL_24 ,IF(ss_25 = 1 ,'ON','OFF') AS TGL_25 ,
        IF(ss_26 = 1 , 'ON','OFF') AS TGL_26 ,IF(ss_27 = 1 , 'ON','OFF') AS TGL_27 ,IF(ss_28 = 1 , 'ON','OFF') AS TGL_28 ,
        IF(ss_29 = 1 ,'ON','OFF') AS TGL_29 ,IF(ss_30 = 1 ,'ON','OFF') AS TGL_30 ,IF(ss_31 = 1 ,'ON','OFF') AS TGL_31 
        FROM `admisecsgp_mstproductiondtls` prd , `admisecsgp_mstplant` plt , `admisecsgp_mstzone` zn ,`admisecsgp_mstshift` sh 
        WHERE prd.admisecsgp_mstplant_id = plt.id 
        AND prd.admisecsgp_mstzone_id = zn.id 
        AND prd.admisecsgp_mstshift_id = sh.id 
        and prd.status = 1
        AND prd.admisecsgp_mstplant_id =  '" . $plant . "'
        AND tahun = '" . $tahun . "' AND bulan = '" . $bulan . "' ");
        return $query;
    }

    //tampilkan jadwal produksi per tanggal
    public function produksiPerTanggal($colom_stat_zona, $tahun, $bulan,  $col_tanggal, $plant_id, $colom_select_tgl)
    {
        $query = $this->db->query("SELECT prd.id , bulan , tahun , plt.plant_name , zn.zone_name , sh.nama_shift , $colom_stat_zona , $colom_select_tgl , plt.id as id_plant , zn.id as id_zona , mstprd.id as id_produksi , sh.id as id_shift ,
        IF($colom_stat_zona = 1 , 'ACTIVE','INACTIVE') AS status_zona , mstprd.name AS status_produksi 
        FROM `admisecsgp_mstproductiondtls` prd , `admisecsgp_mstplant` plt , `admisecsgp_mstzone` zn ,`admisecsgp_mstshift` sh ,
        `admisecsgp_mstproduction` mstprd 
        WHERE prd.admisecsgp_mstplant_id = plt.id 
        AND prd.admisecsgp_mstplant_id = $plant_id
        AND prd.admisecsgp_mstzone_id = zn.id 
        AND prd.admisecsgp_mstshift_id = sh.id
        AND $col_tanggal = mstprd.id 
        and prd.status = 1
        AND tahun = '" . $tahun . "' AND bulan = '" . $bulan . "' ORDER BY sh.nama_shift ASC ");
        return $query;
    }

    // daftar security per plant
    public function daftarSecurity($id_plant)
    {
        $query = $this->db->query("SELECT usr.id , usr.name , usr.npk , rl.level from admisecsgp_mstusr usr , admisecsgp_mstroleusr rl WHERE usr.admisecsgp_mstplant_id = '" . $id_plant . "'  and rl.level = 'SECURITY' and usr.admisecsgp_mstroleusr_id = rl.id ");
        return $query;
    }
}
