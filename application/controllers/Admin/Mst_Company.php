<?php



class Mst_Company extends CI_Controller
{

    public function __construct(Type $var = null)
    {
        parent::__construct();

        date_default_timezone_set('Asia/Jakarta');
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
            'link'       => $this->uri->segment(2),
            'company'    => $this->M_admin->ambilData("admisecsgp_mstcmp")
        ];
        // $this->template->load("template/template", "mst_company", $data);

        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/mst_company", $data);
        $this->load->view("template/footer");
    }
}
