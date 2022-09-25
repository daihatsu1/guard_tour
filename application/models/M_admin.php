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
    // ambil data master_shift
    public function showShift()
    {
        $query = $this->db->query("SELECT shift_id ,nama_shift , convert(varchar,jam_masuk,120) as jam_masuk ,convert(varchar,jam_pulang,120) as jam_pulang , status from admisecsgp_mstshift   ");
        return $query;
    }

    // detail master shift
    public function showShiftDetail($id)
    {
        $query = $this->db->query("SELECT shift_id ,nama_shift , convert(varchar,jam_masuk,120) as jam_masuk ,convert(varchar,jam_pulang,120) as jam_pulang , status from admisecsgp_mstshift where shift_id = '" . $id . "'   ");
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
        $query =  $this->db->query("SELECT c.company_id as id , c.comp_name  , w.others ,  w.site_name , w.site_id  , w.status 
        FROM admisecsgp_mstcmp c , admisecsgp_mstsite w 
        WHERE c.company_id = w.admisecsgp_mstcmp_company_id  and w.site_id = '" . $id . "'  ");
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
        $query =  $this->db->query("SELECT c.comp_name , p.plant_id  as id ,  p.plant_name ,  w.site_name , p.admisecsgp_mstsite_site_id as admisecsgp_mstsite_id  , p.status  , p.others , p.kode_plant
        FROM admisecsgp_mstplant p , admisecsgp_mstsite w  , admisecsgp_mstcmp c
        WHERE p.admisecsgp_mstsite_site_id = w.site_id and w.admisecsgp_mstcmp_company_id = c.company_id and w.site_id = '" . $id . "'  ");
        return $query;
    }

    public function detailPlant($id)
    {
        $query =  $this->db->query("SELECT c.comp_name , c.company_id as id , w.site_name , p.plant_id , p.plant_name , p.status , p.others , p.admisecsgp_mstsite_id  , w.admisecsgp_mstcmp_id , p.kode_plant 
        FROM admisecsgp_mstplant p , admisecsgp_mstsite w  , admisecsgp_mstcmp c 
        WHERE w.admisecsgp_mstcmp_id = c.id and p.admisecsgp_mstsite_id = w.id and w.admisecsgp_mstcmp_id = c.id 
         and p.id = " . $id . "   ");
        return $query;
    }
    //


    //tampilkan data zona
    public function showZona($id)
    {
        $query =  $this->db->query("SELECT z.zone_id as id , z.zone_name,  z.others , z.status , z.status,  p.plant_name , w.site_name , z.kode_zona FROM admisecsgp_mstplant p, admisecsgp_mstzone z   ,  admisecsgp_mstsite w
        WHERE z.admisecsgp_mstplant_plant_id = p.plant_id and w.site_id = p.admisecsgp_mstsite_site_id  and w.site_id = '" . $id . "' order by z.created_at desc ");
        return $query;
    }

    public function detailZona($id)
    {
        $query =  $this->db->query("SELECT z.zone_name , z.zone_id as id , z.kode_zona , w.site_name ,p.plant_name , z.status , z.others , z.admisecsgp_mstplant_plant_id ,z.durasi_batas_atas , z.durasi_batas_bawah , p.plant_name , p.admisecsgp_mstsite_site_id
        FROM admisecsgp_mstplant p , admisecsgp_mstsite w  , admisecsgp_mstzone z
        WHERE   z.admisecsgp_mstplant_plant_id = p.plant_id and w.site_id = p.admisecsgp_mstsite_site_id and z.zone_id = '" . $id . "'     ");
        return $query;
    }


    //tampilkan checkPoint()
    public function showCheckpoint($id)
    {
        $query =  $this->db->query("SELECT c.checkpoint_id as id ,  c.check_name ,  c.others  , c.status , z.zone_name,  p.plant_name  , c.check_no , z.admisecsgp_mstplant_plant_id  as plant_id , c.admisecsgp_mstzone_zone_id as zona_id , c.durasi_batas_atas , c.durasi_batas_bawah 
        FROM admisecsgp_mstplant p, admisecsgp_mstzone z  , admisecsgp_mstckp c  , admisecsgp_mstsite w
        WHERE z.admisecsgp_mstplant_plant_id = p.plant_id AND z.zone_id = c.admisecsgp_mstzone_zone_id AND w.site_id = '" . $id . "' AND p.admisecsgp_mstsite_site_id = w.site_id order by c.created_at DESC  ");
        return $query;
    }


    public function detailCheckpoint($id)
    {
        $query =  $this->db->query("SELECT z.zone_name , c.checkpoint_id as id , w.site_name ,p.plant_name , z.status , z.others , z.admisecsgp_mstplant_plant_id , p.plant_name , 
        c.check_name , c.check_no , c.admisecsgp_mstzone_zone_id , c.status ,  c.durasi_batas_atas , c.durasi_batas_bawah
        FROM admisecsgp_mstplant p , admisecsgp_mstsite w  , admisecsgp_mstzone z , admisecsgp_mstckp c
        WHERE   z.admisecsgp_mstplant_plant_id = p.plant_id and c.admisecsgp_mstzone_zone_id = z.zone_id and c.checkpoint_id = '" . $id . "' ");
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
    public function multiple_delete($table, $data, $col)
    {
        $total = count($data);
        for ($i = 0; $i < $total; $i++) {
            $this->db->where($col, $data[$i]);
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
        $query =  $this->db->query("SELECT ko.kategori_id , ko.kategori_name , ko.status, ko.others from admisecsgp_mstkobj ko  WHERE ko.kategori_id='" . $id . "' ");
        return $query;
    }

    // tampilkan event 
    public function showEvent()
    {
        $query = $this->db->query("SELECT ev.event_id , ko.kategori_name , ev.status ,ev.event_name  from admisecsgp_mstevent ev , admisecsgp_mstkobj ko
        where ev.admisecsgp_mstkobj_kategori_id = ko.kategori_id  
         order by ko.kategori_name  ");
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
        $query =  $this->db->query("SELECT o.objek_id as id , o.nama_objek  , z.zone_name , k.kategori_name ,  c.check_name  , o.status , o.others  , p.plant_name , z.admisecsgp_mstplant_plant_id as plant_id ,o.admisecsgp_mstckp_checkpoint_id as id_check , c.admisecsgp_mstzone_zone_id as zona_id 
        FROM  admisecsgp_mstobj o , admisecsgp_mstzone z , admisecsgp_mstkobj k  , admisecsgp_mstckp c , admisecsgp_mstplant p 
        WHERE  o.admisecsgp_mstckp_checkpoint_id = c.checkpoint_id and k.kategori_id = o.admisecsgp_mstkobj_kategori_id and  
        z.zone_id = c.admisecsgp_mstzone_zone_id  and p.plant_id = z.admisecsgp_mstplant_plant_id  and p.admisecsgp_mstsite_site_id = '" . $id . "' order by o.created_at desc ");
        return $query;
    }

    //detail objek
    public function detailObjek($id)
    {
        $query =  $this->db->query("SELECT o.objek_id , o.nama_objek  , z.zone_name, z.zone_id as zona_id  ,  k.kategori_name  , o.admisecsgp_mstkobj_kategori_id as kategori_id,  c.check_name , c.checkpoint_id as check_id  , o.status , o.others  , p.plant_name , z.admisecsgp_mstplant_plant_id as plant_id , o.admisecsgp_mstckp_checkpoint_id , o.admisecsgp_mstkobj_kategori_id , c.admisecsgp_mstzone_zone_id 
        FROM  admisecsgp_mstobj o , admisecsgp_mstzone z , admisecsgp_mstkobj k , admisecsgp_mstckp c  , admisecsgp_mstplant p 
        WHERE  o.admisecsgp_mstckp_checkpoint_id = c.checkpoint_id   and k.kategori_id = o.admisecsgp_mstkobj_kategori_id  and z.zone_id = c.admisecsgp_mstzone_zone_id  and p.plant_id = z.admisecsgp_mstplant_plant_id and o.objek_id = '" . $id . "'   ");
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
        $query = $this->db->query("select zn.zone_id as id ,  zn.zone_name , plt.plant_name    from admisecsgp_mstplant plt , admisecsgp_mstzone zn 
        where zn.admisecsgp_mstplant_plant_id = plt.plant_id and zn.status = 1 and plt.admisecsgp_mstsite_site_id = '" . $idSite . "'  ");
        return $query;
    }


    //tampilkan user
    public function showUser($idSite)
    {
        $query =  $this->db->query("SELECT  u.name , u.npk , u.admisecsgp_mstroleusr_role_id , r.level , c.comp_name , s.site_name , p.plant_name  , u.status , u.admisecsgp_mstsite_site_id as site_id
        FROM admisecsgp_mstusr u , admisecsgp_mstroleusr r , admisecsgp_mstcmp c , admisecsgp_mstsite s
        , admisecsgp_mstplant p
        WHERE u.admisecsgp_mstroleusr_role_id = r.role_id and c.company_id = s.admisecsgp_mstcmp_company_id and u.admisecsgp_mstsite_site_id = s.site_id and p.plant_id = u.admisecsgp_mstplant_plant_id  and u.admisecsgp_mstsite_site_id = '" . $idSite . "' and r.level='SECURITY'  ");
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

    public function headerjadwalPatroli($plant_id, $date)
    {
        $query = $this->db->query("SELECT pl.plant_name AS plant , jp.admisecsgp_mstplant_plant_id as id_plant , usr.name AS nama , usr.npk  , 
        jp.admisecsgp_mstusr_npk as user_id  
        FROM admisecsgp_trans_jadwal_patroli jp , admisecsgp_mstusr usr, admisecsgp_mstplant pl 
                WHERE 
                jp.admisecsgp_mstplant_plant_id = pl.plant_id AND 
                usr.npk = jp.admisecsgp_mstusr_npk AND 
                format(jp.date_patroli,'yyyy-MM') = '" . $date . "' AND 
                jp.admisecsgp_mstplant_plant_id = '" . $plant_id . "'
          GROUP BY  pl.plant_name  , jp.admisecsgp_mstplant_plant_id , usr.name  , usr.npk  , 
        jp.admisecsgp_mstusr_npk  ");
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
        $query = $this->db->query("SELECT 
        am.zone_name AS zona  ,  pl.plant_name AS plant , sh.shift_id AS shift_id ,  sh.nama_shift AS shift ,
        zp.admisecsgp_mstzone_zone_id  AS zona_id  
            from admisecsgp_trans_zona_patroli zp
            inner join admisecsgp_mstzone am on am.zone_id  = zp.admisecsgp_mstzone_zone_id 
            inner join admisecsgp_mstplant pl on pl.plant_id  = am.admisecsgp_mstplant_plant_id 
            inner join admisecsgp_mstshift sh on sh.shift_id  = zp.admisecsgp_mstshift_shift_id 
            where
                format(zp.date_patroli,'yyyy-MM','en-US') = '" . $date . "'
                and pl.plant_id  = '" . $plant_id . "'
                and zp.status  = 1 
                group by  am.zone_name ,  pl.plant_name, sh.shift_id,  sh.nama_shift ,zp.admisecsgp_mstzone_zone_id 
        ");
        return $query;
    }

    public function detailJadwalProduksi($plant_id, $shift_id, $date, $zona_id)
    {
        $query = $this->db->query("SELECT jp.id_zona_patroli, jp.date_patroli AS tanggal , zn.zone_name  ,  sh.nama_shift ,
        CAST(
            CASE 
                WHEN jp.status_zona = 0
                    THEN 'OFF'
                ELSE 'ON'
            END
            as varchar
        )as  zona_status
          FROM admisecsgp_trans_zona_patroli jp , admisecsgp_mstshift sh  , 
        admisecsgp_mstzone zn 
        WHERE  jp.admisecsgp_mstshift_shift_id = sh.shift_id AND zn.zone_id = admisecsgp_mstzone_zone_id AND jp.admisecsgp_mstplant_plant_id = '" . $plant_id . "' AND admisecsgp_mstzone_zone_id = '" . $zona_id . "' AND jp.admisecsgp_mstshift_shift_id = '" . $shift_id . "'
        AND jp.admisecsgp_mstshift_shift_id = sh.shift_id AND  
        jp.date_patroli = '" . $date . "' and jp.status = 1 ");
        return $query;
    }

    public function petugasPerTanggal($date, $plant_id)
    {
        $query = $this->db->query("SELECT jp.id_jadwal_patroli, jp.date_patroli AS tanggal , sh.nama_shift as shift , pl.plant_name AS plant , 
        usr.name as nama , usr.npk , jp.admisecsgp_mstplant_plant_id as plant_id ,
                jp.admisecsgp_mstshift_shift_id as shift_id , jp.admisecsgp_mstusr_npk as user_id 
                FROM admisecsgp_trans_jadwal_patroli jp , admisecsgp_mstplant pl , admisecsgp_mstusr usr , admisecsgp_mstshift sh
                WHERE 
                jp.date_patroli = '" . $date . "' AND 
                jp.admisecsgp_mstplant_plant_id= pl.plant_id AND 
                jp.admisecsgp_mstshift_shift_id = sh.shift_id AND
                jp.admisecsgp_mstusr_npk =  usr.npk and jp.status = 1  AND 
                jp.admisecsgp_mstplant_plant_id = '" . $plant_id . "'
                GROUP BY  jp.id_jadwal_patroli, jp.date_patroli  , sh.nama_shift  , pl.plant_name , 
        usr.name , usr.npk , jp.admisecsgp_mstplant_plant_id ,
                jp.admisecsgp_mstshift_shift_id  , jp.admisecsgp_mstusr_npk ");
        return $query;
    }


    public function produksiPerTanggal($date, $plant_id)
    {
        $query = $this->db->query("   SELECT spt.id_zona_patroli as id , pl.plant_name as plant, spt.date_patroli as tanggal , zn.zone_name as zona  , 
		sh.nama_shift  AS shift , CAST(
		CASE 
			WHEN spt.status_zona = '0' 
				THEN 'INACTIVE' 
			ELSE 'ACTIVE' 	
		END
		AS varchar
		) AS zona_status , 
		spt.status_zona , prd.name  AS stat_produksi  , spt.admisecsgp_mstproduction_produksi_id as id_produksi
        from admisecsgp_trans_zona_patroli spt 
        inner join  admisecsgp_mstzone zn on spt.admisecsgp_mstzone_zone_id  = zn.zone_id 
        inner join  admisecsgp_mstshift sh on sh.shift_id  = spt.admisecsgp_mstshift_shift_id 
        inner join  admisecsgp_mstproduction prd on prd.produksi_id  = admisecsgp_mstproduction_produksi_id  
        inner join  admisecsgp_mstplant pl on pl.plant_id  = spt.admisecsgp_mstplant_plant_id 
        where 
          format(spt.date_patroli,'yyyy-MM-dd','en-US') = '" . $date . "'  AND
          spt.admisecsgp_mstplant_plant_id  = '" . $plant_id . "' AND
          spt.status = 1
        order by sh.nama_shift  ASC");
        return $query;
    }

    // daftar security per plant
    public function daftarSecurity($id_plant)
    {
        $query = $this->db->query("SELECT  usr.name , usr.npk , rl.level from admisecsgp_mstusr usr , admisecsgp_mstroleusr rl WHERE usr.admisecsgp_mstplant_plant_id = '" . $id_plant . "'  and rl.level = 'SECURITY' and usr.admisecsgp_mstroleusr_role_id = rl.role_id ");
        return $query;
    }
}
