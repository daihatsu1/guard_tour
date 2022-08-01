<?php

class Mst_Periode extends CI_Controller
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
        if ($role != "SUPERADMIN") {
            redirect('Login');
        }
    }

    public function index()
    {
        $data = [
            'link'          => $this->uri->segment(1),
            'event'         => $this->M_patrol->showPeriode()
        ];
        // $this->template->load("template/template", "mst_periode", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("mst_periode", $data);
        $this->load->view("template/footer");
    }

    public function form_add(Type $var = null)
    {
        $data = [
            'link'          => $this->uri->segment(1),
            'shift'         => $this->M_patrol->ambilData("admisecsgp_mstshift")
        ];
        // $this->template->load("template/template", "add_mst_periode", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("add_mst_periode", $data);
        $this->load->view("template/footer");
    }


    public function input()
    {
        $status            = $this->input->post("status");
        $id_shift          = $this->input->post("shift");
        $total             = $this->input->post("total");


        $data = [
            'status'                    => $status,
            'admisecsgp_mstshift_id'    => $id_shift,
            'total'                     => $total,
            'created_at'                => date('Y-m-d H:i:s'),
            'created_by'                => $this->session->userdata('id_token'),
        ];

        $cek = $this->db->get_where("admisecsgp_mstprd", ['admisecsgp_mstshift_id' => $id_shift]);
        if ($cek->num_rows() >= 1) {
            $vi =  $this->db->get_where("admisecsgp_mstshift", ['id' => $id_shift])->row();
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> shift ' . $vi->nama_shift . ' sudah terdaftar');
            redirect('Mst_Periode');
        } else {
            $input = $this->M_patrol->inputData($data, "admisecsgp_mstprd");
            if ($input) {
                $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil input data');
                redirect('Mst_Periode');
            } else {
                $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal input data');
                redirect('Mst_Periode');
            }
        }
    }


    public function hapus($id)
    {
        $where = ['id' => $id];
        $del = $this->M_patrol->delete("admisecsgp_mstprd", $where);
        if ($del) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil hapus data');
            redirect('Mst_Periode');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal hapus data');
            redirect('Mst_Periode');
        }
    }

    public function edit()
    {
        $id =  $this->input->get('periode_id');
        $data = [
            'link'       => $this->uri->segment(1),
            'shift'      => $this->M_patrol->ambilData("admisecsgp_mstshift"),
            'data'       => $this->M_patrol->detailPeriode($id)->row()
        ];
        // $this->template->load("template/template", "edit_mst_periode", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("edit_mst_periode", $data);
        $this->load->view("template/footer");
    }


    public function update()
    {
        $id                 = $this->input->post("id");
        $status            = $this->input->post("status");
        $id_shift          = $this->input->post("shift");
        $total             = $this->input->post("total");


        $data = [
            'status'                    => $status,
            'admisecsgp_mstshift_id'    => $id_shift,
            'total'                     => $total,
            'updated_at'                => date('Y-m-d H:i:s'),
            'updated_by'                => $this->session->userdata('id_token'),
        ];

        $where = ['id' => $id];
        $update = $this->M_patrol->update("admisecsgp_mstprd", $data, $where);
        if ($update) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil update data');
            redirect('Mst_Periode');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal update data');
            redirect('Mst_Periode');
        }
    }
}
