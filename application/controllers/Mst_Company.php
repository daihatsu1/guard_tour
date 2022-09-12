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
        if ($role != "SUPERADMIN") {
            redirect('Login');
        }
    }

    public function index()
    {
        $data = [
            'link'       => $this->uri->segment(1),
            'company'    => $this->M_patrol->ambilData("admisecsgp_mstcmp")
        ];
        // $this->template->load("template/template", "mst_company", $data);

        $this->load->view("template/sidebar", $data);
        $this->load->view("mst_company", $data);
        $this->load->view("template/footer");
    }


    public function form_add()
    {
        $data = [
            'link'       => $this->uri->segment(1),
        ];
        // $this->template->load("template/template", "add_mst_company", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("add_mst_company", $data);
        $this->load->view("template/footer");
    }


    public function input()
    {
        $comp_name      = $this->input->post("comp_name");
        $comp_phone     = $this->input->post("comp_phone");
        $address        = $this->input->post("address1");
        $status         = $this->input->post("status");

        $data = [
            'company_id'      => 'ADMCMP' . substr(uniqid(rand(), true), 4, 4),
            'comp_name'       => $comp_name,
            'comp_phone'      => $comp_phone,
            'address1'        => $address,
            'created_at'      => date('Y-m-d H:i:s'),
            'created_by'      => $this->session->userdata('id_token'),
            'status'          => $status
        ];
        $save = $this->M_patrol->inputData($data, "admisecsgp_mstcmp");
        if ($save) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil input data');
            redirect('Mst_Company');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal input data');
            redirect('Mst_Company');
        }
    }

    public function edit()
    {
        $id =  $this->input->get('comp_id');
        $data = [
            'link'       => $this->uri->segment(1),
            'data'       => $this->M_patrol->ambilData("admisecsgp_mstcmp", ['company_id' => $id])->row()
        ];
        // $this->template->load("template/template", "edit_mst_company", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("edit_mst_company", $data);
        $this->load->view("template/footer");
    }

    public function hapus($id)
    {
        $where = ['company_id' => $id];
        $del = $this->M_patrol->delete("admisecsgp_mstcmp", $where);
        if ($del) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil hapus data');
            redirect('Mst_Company');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal hapus data');
            redirect('Mst_Company');
        }
    }


    public function update()
    {
        $id             = $this->input->post("id");
        $comp_name      = $this->input->post("comp_name");
        $comp_phone     = $this->input->post("comp_phone");
        $address        = $this->input->post("address1");
        $status         = $this->input->post("status");
        $data = [
            'comp_name'       => $comp_name,
            'comp_phone'      => $comp_phone,
            'address1'        => $address,
            'updated_at'      => date('Y-m-d H:i:s'),
            'updated_by'      => $this->session->userdata('id_token'),
            'status'          => $status
        ];

        $where = ['company_id' => $id];
        $update = $this->M_patrol->update("admisecsgp_mstcmp", $data, $where);
        if ($update) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil update data');
            redirect('Mst_Company');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal update data');
            redirect('Mst_Company');
        }
    }
}
