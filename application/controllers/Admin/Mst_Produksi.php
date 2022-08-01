<?php

class Mst_Produksi extends CI_Controller
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
            'link'             => $this->uri->segment(2),
            'produksi'         => $this->M_patrol->ambilData("admisecsgp_mstproduction")
        ];
        // $this->template->load("template/template", "mst_Produksi", $data);
        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/mst_produksi", $data);
        $this->load->view("template/admin/footer");
    }

    public function form_add(Type $var = null)
    {
        $data = [
            'link'          => $this->uri->segment(2),
        ];
        // $this->template->load("template/template", "add_mst_Produksi", $data);
        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/add_mst_produksi", $data);
        $this->load->view("template/admin/footer");
    }


    public function input()
    {
        $status           = $this->input->post("status");
        $nama             = $this->input->post("name");
        $data = [
            'status'           => $status,
            'name'             => strtoupper($nama),
            'created_at'       => date('Y-m-d H:i:s'),
            'created_by'       => $this->session->userdata('id_token'),
        ];

        $cek = $this->db->get_where("admisecsgp_mstproduction", ['name' => $nama])->num_rows();
        if ($cek >= 1) {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> name ' . $nama . ' sudah ada');
            redirect('Admin/Mst_Produksi');
        } else {
            $input = $this->M_patrol->inputData($data, "admisecsgp_mstproduction");
            if ($input) {
                $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil input data');
                redirect('Admin/Mst_Produksi');
            } else {
                $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal input data');
                redirect('Admin/Mst_Produksi');
            }
        }
    }


    public function hapus($id)
    {
        $where = ['id' => $id];
        $del = $this->M_patrol->delete("admisecsgp_mstproduction", $where);
        if ($del) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil hapus data');
            redirect('Admin/Mst_Produksi');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal hapus data');
            redirect('Admin/Mst_Produksi');
        }
    }

    public function edit()
    {
        $id =  $this->input->get('prod_id');
        $data = [
            'link'       => $this->uri->segment(2),
            'data'       => $this->M_patrol->ambilData("admisecsgp_mstproduction", ['id' => $id])->row()
        ];
        // $this->template->load("template/template", "edit_mst_Produksi", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("edit_mst_produksi", $data);
        $this->load->view("template/footer");
    }


    public function update()
    {
        $id                = $this->input->post("id");
        $status            = $this->input->post("status");
        $name             = $this->input->post("name");
        $data = [
            'status'             => $status,
            'name'               => strtoupper($name),
            'updated_at'         => date('Y-m-d H:i:s'),
            'updated_by'         => $this->session->userdata('id_token'),
        ];

        $where = ['id' => $id];
        $update = $this->M_patrol->update("admisecsgp_mstproduction", $data, $where);
        if ($update) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil update data');
            redirect('Admin/Mst_Produksi');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal update data');
            redirect('Admin/Mst_Produksi');
        }
    }
}
