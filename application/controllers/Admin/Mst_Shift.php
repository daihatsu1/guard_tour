<?php

class Mst_Shift extends CI_Controller
{

    public function __construct(Type $var = null)
    {
        parent::__construct();
        $id = $this->session->userdata('id_token');
        date_default_timezone_set('Asia/Jakarta');
        if ($id == null || $id == "") {
            $this->session->set_flashdata('info_login', 'anda harus login dulu');
            redirect('Login');
        }

        $role = $this->session->userdata('role');
        if ($role != "ADMIN") {
            redirect('Login');
        }
    }

    public function index()
    {
        $data = [
            'link'          => $this->uri->segment(2),
            'shift'         => $this->M_admin->showShift()
            // 'shift'         => $this->M_patrol->ambilData("admisecsgp_mstshift")
        ];
        // $this->template->load("template/template", "mst_shift", $data);
        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/mst_shift", $data);
        $this->load->view("template/admin/footer");
    }
}
