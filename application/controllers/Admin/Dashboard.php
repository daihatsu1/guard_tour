<?php


class Dashboard extends CI_Controller
{

    public function __construct(Type $var = null)
    {
        parent::__construct();
        $id = $this->session->userdata('id_token');
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
            'link'  => $this->uri->segment(2)
        ];
        // $this->template->load("template/template", "dashboard", $data);

        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/dashboard", $data);
        $this->load->view("template/admin/footer");
    }
}
