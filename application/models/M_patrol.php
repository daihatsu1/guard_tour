<?php

class M_patrol extends CI_Model
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
    public function showWilayah()
    {
        $query =  $this->db->query("SELECT c.company_id  , c.comp_name  , w.others ,  w.site_name , w.site_id  , w.status 
        FROM admisecsgp_mstcmp c , admisecsgp_mstsite w 
        WHERE c.company_id = w.admisecsgp_mstcmp_company_id  ");
        return $query;
    }

    public function detailWilayah($id)
    {
        $query =  $this->db->query("SELECT c.company_id , c.comp_name , w.others, w.site_name , w.site_id  , w.status  , w.admisecsgp_mstcmp_company_id
        FROM admisecsgp_mstcmp c , admisecsgp_mstsite w  
        WHERE c.company_id = w.admisecsgp_mstcmp_company_id  and w.site_id = '" . $id . "' ");
        return $query;
    }


    //tampilkan plant
    public function showPlant()
    {
        $query =  $this->db->query("SELECT c.comp_name , p.plant_id ,  p.plant_name ,  w.site_name , p.admisecsgp_mstsite_site_id , p.status  , p.others , p.kode_plant
        FROM admisecsgp_mstplant p , admisecsgp_mstsite w  , admisecsgp_mstcmp c
        WHERE p.admisecsgp_mstsite_site_id = w.site_id and w.admisecsgp_mstcmp_company_id = c.company_id ");
        return $query;
    }

    public function detailPlant($id)
    {
        $query =  $this->db->query("SELECT c.comp_name , c.company_id , w.site_name , p.plant_id , p.plant_name , p.status , p.others , p.admisecsgp_mstsite_site_id  , w.admisecsgp_mstcmp_company_id , p.kode_plant 
        FROM admisecsgp_mstplant p , admisecsgp_mstsite w  , admisecsgp_mstcmp c 
        WHERE w.admisecsgp_mstcmp_company_id = c.company_id and p.admisecsgp_mstsite_site_id = w.site_id
         and p.plant_id = '" . $id . "'   ");
        return $query;
    }
    //



    //tampilkan data zona
    public function showZona()
    {
        $query =  $this->db->query("SELECT z.zone_id , z.zone_name,  z.others , z.status , z.status,  p.plant_name , w.site_name , z.kode_zona FROM admisecsgp_mstplant p, admisecsgp_mstzone z   ,  admisecsgp_mstsite w
        WHERE z.admisecsgp_mstplant_plant_id = p.plant_id and w.site_id = p.admisecsgp_mstsite_site_id order by z.created_at desc");
        return $query;
    }

    public function detailZona($id)
    {
        $query =  $this->db->query("SELECT z.zone_name , z.zone_id , z.kode_zona , w.site_name ,p.plant_name , z.status , z.others , z.admisecsgp_mstplant_plant_id ,z.durasi_batas_atas , z.durasi_batas_bawah , p.plant_name , p.admisecsgp_mstsite_site_id
        FROM admisecsgp_mstplant p , admisecsgp_mstsite w  , admisecsgp_mstzone z
        WHERE   z.admisecsgp_mstplant_plant_id = p.plant_id and w.site_id = p.admisecsgp_mstsite_site_id and z.zone_id = '" . $id . "'    ");
        return $query;
    }

    //tampilkan checkPoint()
    public function showCheckpoint()
    {
        $query =  $this->db->query("SELECT c.checkpoint_id ,  c.check_name ,  c.others  , c.status , z.zone_name,  p.plant_name  , c.check_no , z.admisecsgp_mstplant_plant_id  as plant_id , c.admisecsgp_mstzone_zone_id as zona_id , c.durasi_batas_atas , c.durasi_batas_bawah 
        FROM admisecsgp_mstplant p, admisecsgp_mstzone z  , admisecsgp_mstckp c 
        WHERE z.admisecsgp_mstplant_plant_id = p.plant_id AND z.zone_id = c.admisecsgp_mstzone_zone_id order by c.created_at DESC ");
        return $query;
    }

    public function detailCheckpoint($id)
    {
        $query =  $this->db->query("SELECT z.zone_name , c.checkpoint_id  , w.site_name ,p.plant_name , z.status , z.others , z.admisecsgp_mstplant_plant_id , p.plant_name , 
        c.check_name , c.check_no , c.admisecsgp_mstzone_zone_id , c.status ,  c.durasi_batas_atas , c.durasi_batas_bawah
        FROM admisecsgp_mstplant p , admisecsgp_mstsite w  , admisecsgp_mstzone z , admisecsgp_mstckp c
        WHERE   z.admisecsgp_mstplant_plant_id = p.plant_id and c.admisecsgp_mstzone_zone_id = z.zone_id and c.checkpoint_id = '" . $id . "'  ");
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


    //multiple upload
    public function mulitple_upload($table, $var)
    {
        return $this->db->insert_batch($table, $var);
    }

    //multiple delete 
    public function multiple_delete($table, $data, $kolom)
    {
        $total = count($data);
        for ($i = 0; $i < $total; $i++) {
            $this->db->where($kolom, $data[$i]);
            $this->db->delete($table);
        }

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    //tampilkan kategori objek
    public function kategoriObjek()
    {
        $query =  $this->db->query("SELECT ko.kategori_id , ko.kategori_name , ko.status, ko.others  from admisecsgp_mstkobj ko");
        return $query;
    }

    //tampilkan kategori objek
    public function detailkategoriObjek($id)
    {
        $query =  $this->db->query("SELECT ko.kategori_id , ko.kategori_name , ko.status, ko.others from admisecsgp_mstkobj ko  WHERE ko.kategori_id='" . $id . "' ");
        return $query;
    }

    // tampilkan event 
    public function showEvent()
    {
        $query = $this->db->query("SELECT ev.event_id , ko.kategori_name , ev.status ,ev.event_name  from admisecsgp_mstevent ev , admisecsgp_mstkobj ko
        where ev.admisecsgp_mstkobj_kategori_id = ko.kategori_id 
         order by ko.kategori_name ");
        return $query;
    }


    //detail event 
    public function detailEvent($id)
    {
        $query = $this->db->query("SELECT ev.event_id , ko.kategori_name , ev.status ,ev.event_name , ko.kategori_id    from admisecsgp_mstevent ev , admisecsgp_mstkobj ko
        where ev.admisecsgp_mstkobj_kategori_id = ko.kategori_id  and ev.event_id = '" . $id . "' ");
        return $query;
    }

    //tampilkan object
    public function showObject()
    {
        $query =  $this->db->query("SELECT o.objek_id , o.nama_objek  , z.zone_name , k.kategori_name ,  c.check_name  , o.status , o.others  , p.plant_name , z.admisecsgp_mstplant_plant_id as plant_id ,o.admisecsgp_mstckp_checkpoint_id as id_check , c.admisecsgp_mstzone_zone_id as zona_id 
        FROM  admisecsgp_mstobj o , admisecsgp_mstzone z , admisecsgp_mstkobj k  , admisecsgp_mstckp c , admisecsgp_mstplant p 
        WHERE  o.admisecsgp_mstckp_checkpoint_id = c.checkpoint_id and k.kategori_id = o.admisecsgp_mstkobj_kategori_id and  
        z.zone_id = c.admisecsgp_mstzone_zone_id  and p.plant_id = z.admisecsgp_mstplant_plant_id  order by o.created_at desc ");
        return $query;
    }

    public function detailObjek($id)
    {
        $query =  $this->db->query("SELECT o.objek_id , o.nama_objek  , z.zone_name, z.zone_id as zona_id  ,  k.kategori_name  , o.admisecsgp_mstkobj_kategori_id as kategori_id,  c.check_name , c.checkpoint_id as check_id  , o.status , o.others  , p.plant_name , z.admisecsgp_mstplant_plant_id as plant_id , o.admisecsgp_mstckp_checkpoint_id , o.admisecsgp_mstkobj_kategori_id , c.admisecsgp_mstzone_zone_id 
        FROM  admisecsgp_mstobj o , admisecsgp_mstzone z , admisecsgp_mstkobj k , admisecsgp_mstckp c  , admisecsgp_mstplant p 
        WHERE  o.admisecsgp_mstckp_checkpoint_id = c.checkpoint_id   and k.kategori_id = o.admisecsgp_mstkobj_kategori_id  and z.zone_id = c.admisecsgp_mstzone_zone_id  and p.plant_id = z.admisecsgp_mstplant_plant_id and o.objek_id = '" . $id . "'  ");
        return $query;
    }


    public function zonePlant()
    {
        $query = $this->db->query("select zn.id ,  zn.zone_name , plt.plant_name    from admisecsgp_mstplant plt , admisecsgp_mstzone zn 
        where zn.admisecsgp_mstplant_id = plt.id and zn.status = 1  ");
        return $query;
    }


    //show event

    //tampilkan user
    public function showUser()
    {
        $query =  $this->db->query("SELECT  u.name , u.npk , u.admisecsgp_mstroleusr_role_id , r.level , c.comp_name , s.site_name , p.plant_name  , u.status , u.admisecsgp_mstsite_site_id as site_id
        FROM admisecsgp_mstusr u , admisecsgp_mstroleusr r , admisecsgp_mstcmp c , admisecsgp_mstsite s
        , admisecsgp_mstplant p
        WHERE u.admisecsgp_mstroleusr_role_id = r.role_id and c.company_id = s.admisecsgp_mstcmp_company_id and u.admisecsgp_mstsite_site_id = s.site_id and p.plant_id = u.admisecsgp_mstplant_plant_id ");
        return $query;
    }

    public function detailUser($id)
    {
        $query =  $this->db->query("SELECT  u.name , u.npk , u.admisecsgp_mstroleusr_role_id , r.level , c.comp_name , s.site_name , p.plant_name  , u.status , u.admisecsgp_mstplant_plant_id , u.admisecsgp_mstsite_site_id 
        FROM admisecsgp_mstusr u , admisecsgp_mstroleusr r , admisecsgp_mstcmp c , admisecsgp_mstsite s
        , admisecsgp_mstplant p
        WHERE u.admisecsgp_mstroleusr_role_id = r.role_id and c.company_id = s.admisecsgp_mstcmp_company_id and u.admisecsgp_mstsite_site_id = s.site_id and p.plant_id = u.admisecsgp_mstplant_plant_id and u.npk = '" . $id . "' ");
        return $query;
    }

    //tampilkan user dan company
    public function showUserCompany()
    {
        $query =  $this->db->query("SELECT u.user_id , u.user_name , u.user_npk , u.id_role , r.level , c.comp_no , c.comp_name  
        FROM admisecsgp_mstusr u , admisecsgp_mstroleusr r , admisecsgp_mstcmp c 
        WHERE u.id_role = r.id_role and u.comp_no = c.comp_no  ");
        return $query;
    }

    //tampilkan data form role menu  / hak akses menu per user
    public function showMenuUser()
    {
        $query = $this->db->query("SELECT fm.id , c.comp_name ,  u.user_name , fm.npk , fm.create , fm.update , fm.delete , fm.view , m.nama_menu  , r.level
        FROM admisecsgp_formmenu fm , admisecsgp_mstmenu m   , admisecsgp_mstusr u , admisecsgp_mstcmp c , admisecsgp_mstroleusr r 
        WHERE fm.id_menu = m.id_menu and u.user_npk = fm.npk and u.comp_no = c.comp_no and u.id_role = r.id_role ");
        return $query;
    }

    //periode patroli
    public function showPeriode(Type $var = null)
    {
        $query = $this->db->query("SELECT pr.total , pr.id , pr.status , sh.nama_shift from admisecsgp_mstprd pr , admisecsgp_mstshift sh where
        pr.admisecsgp_mstshift_id = sh.id ");
        return $query;
    }

    //detail patroli
    public function detailPeriode($id)
    {
        $query = $this->db->query("SELECT pr.total , pr.id , pr.status , sh.nama_shift , pr.admisecsgp_mstshift_id from admisecsgp_mstprd pr , admisecsgp_mstshift sh where
        pr.admisecsgp_mstshift_id = sh.id and pr.id ='" . $id . "' ");
        return $query;
    }


    //jadwal patroli 
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

    public function headerjadwalPatroli($plant_id, $date)
    {
        $query = $this->db->query("SELECT pl.plant_name AS plant , jp.admisecsgp_mstplant_plant_id as id_plant , usr.name AS nama , usr.npk  , jp.admisecsgp_mstusr_npk as user_id  FROM admisecsgp_trans_jadwal_patroli jp , admisecsgp_mstusr usr, admisecsgp_mstplant pl 
        WHERE jp.admisecsgp_mstplant_plant_id = pl.plant_id AND usr.npk = jp.admisecsgp_mstusr_npk AND date_format(jp.date_patroli,'%Y-%m') = '" . $date . "' AND jp.admisecsgp_mstplant_plant_id = '" . $plant_id . "' GROUP BY jp.admisecsgp_mstusr_npk  ");
        return $query;
    }

    public function detailJadwalPatroli($plant_id, $user_id, $date)
    {
        $query = $this->db->query("SELECT  sh.nama_shift as shift FROM admisecsgp_trans_jadwal_patroli jp , admisecsgp_mstshift sh  , admisecsgp_mstusr usr
        WHERE jp.admisecsgp_mstshift_shift_id = sh.shift_id AND usr.npk = jp.admisecsgp_mstusr_npk AND jp.admisecsgp_mstplant_plant_id = '" . $plant_id . "' AND admisecsgp_mstusr_npk = '" . $user_id . "' AND
        jp.date_patroli = '" . $date . "' ");
        return $query;
    }


    public function headerjadwalProduksi($plant_id, $date)
    {
        $query = $this->db->query("SELECT jp.id_zona_patroli, pl.plant_name AS plant , zn.zone_name AS zona  , sh.nama_shift AS shift  , sh.shift_id AS shift_id ,
        jp.admisecsgp_mstzone_zone_id  AS zona_id 
        FROM admisecsgp_trans_zona_patroli jp , admisecsgp_mstzone zn, admisecsgp_mstplant pl , admisecsgp_mstshift sh
        WHERE jp.admisecsgp_mstplant_plant_id = pl.plant_id AND zn.zone_id = jp.admisecsgp_mstzone_zone_id AND sh.shift_id = jp.admisecsgp_mstshift_shift_id AND date_format(jp.date_patroli,'%Y-%m') = '" . $date . "' AND jp.status = 1 
        AND jp.admisecsgp_mstplant_plant_id = '" . $plant_id . "' AND zn.admisecsgp_mstplant_plant_id = pl.plant_id
        GROUP BY jp.admisecsgp_mstzone_zone_id  , admisecsgp_mstshift_shift_id
        ORDER BY sh.nama_shift  ASC ");
        return $query;
    }

    public function detailJadwalProduksi($plant_id, $shift_id, $date, $zona_id)
    {
        $query = $this->db->query("SELECT jp.id_zona_patroli, jp.date_patroli AS tanggal , zn.zone_name  ,  sh.nama_shift , IF(jp.status_zona=0, 'OFF' , 'ON') AS zona_status ,
        jp.status_zona
          FROM admisecsgp_trans_zona_patroli jp , admisecsgp_mstshift sh  , 
        admisecsgp_mstzone zn 
        WHERE  jp.admisecsgp_mstshift_shift_id = sh.shift_id AND zn.zone_id = admisecsgp_mstzone_zone_id AND jp.admisecsgp_mstplant_plant_id = '" . $plant_id . "' AND admisecsgp_mstzone_zone_id = '" . $zona_id . "' AND jp.admisecsgp_mstshift_shift_id = '" . $shift_id . "'
        AND jp.admisecsgp_mstshift_shift_id = sh.shift_id AND  
        jp.date_patroli = '" . $date . "' and jp.status = 1 ");
        return $query;
    }

    public function petugasPerTanggal($date, $plant_id)
    {
        $query = $this->db->query("SELECT jp.id_jadwal_patroli, jp.date_patroli AS tanggal , sh.nama_shift as shift , pl.plant_name AS plant , usr.name as nama , usr.npk , jp.admisecsgp_mstplant_plant_id as plant_id ,
        jp.admisecsgp_mstshift_shift_id as shift_id , jp.admisecsgp_mstusr_npk as user_id 
        FROM admisecsgp_trans_jadwal_patroli jp , admisecsgp_mstplant pl , admisecsgp_mstusr usr , admisecsgp_mstshift sh
        WHERE jp.date_patroli = '" . $date . "' AND jp.admisecsgp_mstplant_plant_id= pl.plant_id AND jp.admisecsgp_mstshift_shift_id = sh.shift_id AND
        jp.admisecsgp_mstusr_npk =  usr.npk and jp.status = 1 
        and jp.admisecsgp_mstplant_plant_id = '" . $plant_id . "'
        GROUP BY jp.admisecsgp_mstshift_shift_id , jp.admisecsgp_mstusr_npk ");
        return $query;
    }


    public function produksiPerTanggal($date, $plant_id)
    {
        $query = $this->db->query("SELECT spt.id_zona_patroli , pl.plant_name as plant , spt.date_patroli as tanggal , zn.zone_name as zona  , sh.nama_shift  AS shift , IF(spt.status_zona = 0 , 'INACTIVE' ,'ACTIVE') AS zona_status , spt.status_zona , prd.name  AS stat_produksi  , spt.admisecsgp_mstproduction_produksi_id as id_produksi
        FROM admisecsgp_trans_zona_patroli spt , admisecsgp_mstzone zn , admisecsgp_mstshift sh , admisecsgp_mstproduction prd , admisecsgp_mstplant pl
        WHERE spt.admisecsgp_mstzone_zone_id = zn.zone_id  AND sh.shift_id = spt.admisecsgp_mstshift_shift_id AND spt.date_patroli = '" . $date . "' AND spt.admisecsgp_mstplant_plant_id = '" . $plant_id . "' and spt.admisecsgp_mstplant_plant_id = pl.plant_id 
        AND prd.produksi_id = spt.admisecsgp_mstproduction_produksi_id  and spt.status = 1  ORDER BY spt.admisecsgp_mstshift_shift_id");
        return $query;
    }

    // daftar security per plant
    public function daftarSecurity($id_plant)
    {
        $query = $this->db->query("SELECT  usr.name , usr.npk , rl.level from admisecsgp_mstusr usr , admisecsgp_mstroleusr rl WHERE usr.admisecsgp_mstplant_plant_id = '" . $id_plant . "'  and rl.level = 'SECURITY' and usr.admisecsgp_mstroleusr_role_id = rl.role_id ");
        return $query;
    }
}
