<?php

class Login extends CI_Controller
{

    public function __construct(Type $var = null)
    {
        parent::__construct();
        $id = $this->session->userdata('id_token');
        if ($id != null || $id != "") {
            $role = $this->session->userdata('role');
            if ($role == "SUPERADMIN") {
                redirect('Dashboard');
            } else {
                redirect('Admin/Dashboard');
            }
        }
    }

    public function index(Type $var = null)
    {
        $this->load->view("login");
    }


    public function cekLogin()
    {
        $name = $this->input->post("username");
        $password = md5($this->input->post("password"));

        // $cekUser = $this->db->get_where("admisecsgp_mstusr", ['name' =>  $name, 'password' => $password]);

        $cekUser = $this->db->query("SELECT   usr.npk , usr.name , ru.level  , usr.admisecsgp_mstsite_site_id , usr.admisecsgp_mstplant_plant_id 
        FROM admisecsgp_mstusr usr  , admisecsgp_mstroleusr  ru
        WHERE ru.role_id = usr.admisecsgp_mstroleusr_role_id and usr.password = '" . $password . "' and usr.name = '" . $name . "' ");
        // var_dump($cekUser->row());

        if ($cekUser->num_rows() > 0) {
            $data = $cekUser->row();
            // $this->session->set_userdata("name", $data->user_name);
            switch ($data->level) {
                case 'SUPERADMIN':
                    $this->session->set_userdata("id_token", $data->npk);
                    $this->session->set_userdata("npk", $data->npk);
                    $this->session->set_userdata("name", $data->name);
                    $this->session->set_userdata("role", $data->level);
                    $this->session->set_userdata("site_id", $data->admisecsgp_mstsite_site_id);
                    $this->session->set_userdata("plant_id", $data->admisecsgp_mstplant_plant_id);
                    redirect('Dashboard');
                    // echo $this->session->userdata('role');
                    break;
                case 'ADMIN':
                    $this->session->set_userdata("id_token", $data->npk);
                    $this->session->set_userdata("npk", $data->npk);
                    $this->session->set_userdata("name", $data->name);
                    $this->session->set_userdata("role", $data->level);
                    $this->session->set_userdata("site_id", $data->admisecsgp_mstsite_site_id);
                    $this->session->set_userdata("plant_id", $data->admisecsgp_mstplant_plant_id);
                    redirect('Admin/Dashboard');
                    break;
                case 'SECURITY':
                    $this->session->set_flashdata("info_login", "tidak ada akses untuk role security");
                    redirect('Login');
                default:
                    'USER TIDAK ADA';
                    break;
            }
        } else {
            $this->session->set_flashdata('info_login', "akun tidak ditemukan");
            redirect('Login');
        }
    }
}
