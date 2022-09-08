<?php


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require FCPATH . 'vendor/autoload.php';

class Mst_Jadwal_Patroli extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $id = $this->session->userdata('id_token');
        date_default_timezone_set('Asia/Jakarta');
        $this->load->helper('ConvertBulan');
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
        $data['bulan'] = "";
        $data['tahun'] = "";
        $data['plant_id'] = "";
        $data['daftar_bulan'] = [
            'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'
        ];

        if (isset($_POST['lihat'])) {
            $plant_id             = $this->input->post("plant");
            $tahun                = $this->input->post("tahun");
            $bulan                = $this->input->post("bulan");
            $data['bulan']        = $bulan;
            $data['month']        = convert_bulan($bulan);
            $data['tahun']        = $tahun;
            $data['plant_id']     = $plant_id;
            $data['user']         = $this->M_patrol->headerjadwalPatroli($plant_id, $tahun . '-' . convert_bulan($bulan));
        }
        $data['link']          = $this->uri->segment(1);
        $data['plant']         = $this->M_patrol->ambilData("admisecsgp_mstplant");
        // $this->template->load("template/template", "mst_jadwal", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("mst_jadwal_patroli", $data);
        $this->load->view("template/footer");
    }


    public function download_jadwal()
    {
        $tahun = $this->input->get("tahun");
        $bulan = strtolower($this->input->get("bulan"));
        $plant_id = $this->input->get("plant_id");
        $dataPlant = $this->db->get_where('admisecsgp_mstplant', ['kode_plant' => $plant_id])->row();
        $filename = "Jadwal Patroli " . ucwords(strtolower($dataPlant->plant_name)) . ' ' . ucwords($bulan) . ' ' . $tahun;
        $jadwal = $this->M_patrol->showJadwal($tahun, $bulan, $plant_id);

        header('Content-Type:application/vnd-ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->mergeCells('A1:AG2')->setCellValue('A1', 'JADWAL PATROLI ' . $dataPlant->plant_name);
        $sheet->mergeCells('C3:AG4')->setCellValue('C3', '');
        $sheet->setCellValue('A3', 'Tahun');
        $sheet->setCellValue('A4', 'Bulan');
        $sheet->setCellValue('B3', $tahun);
        $sheet->setCellValue('B4', ucwords($bulan));


        $sheet->mergeCells('A5:A6')->setCellValue('A5', 'NPK');
        $sheet->mergeCells('B5:B6')->setCellValue('B5', 'NAMA');
        $sheet->mergeCells('C5:AG5')->setCellValue('C5', 'TANGGAL');
        $sheet->setCellValue('C6', '1');
        $sheet->setCellValue('D6', '2');
        $sheet->setCellValue('E6', '3');
        $sheet->setCellValue('F6', '4');
        $sheet->setCellValue('G6', '5');
        $sheet->setCellValue('H6', '6');
        $sheet->setCellValue('I6', '7');
        $sheet->setCellValue('J6', '8');
        $sheet->setCellValue('K6', '9');
        $sheet->setCellValue('L6', '10');
        $sheet->setCellValue('M6', '11');
        $sheet->setCellValue('N6', '12');
        $sheet->setCellValue('O6', '13');
        $sheet->setCellValue('P6', '14');
        $sheet->setCellValue('Q6', '15');
        $sheet->setCellValue('R6', '16');
        $sheet->setCellValue('S6', '17');
        $sheet->setCellValue('T6', '18');
        $sheet->setCellValue('U6', '19');
        $sheet->setCellValue('V6', '20');
        $sheet->setCellValue('W6', '21');
        $sheet->setCellValue('X6', '22');
        $sheet->setCellValue('Y6', '23');
        $sheet->setCellValue('Z6', '24');
        $sheet->setCellValue('AA6', '25');
        $sheet->setCellValue('AB6', '26');
        $sheet->setCellValue('AC6', '27');
        $sheet->setCellValue('AD6', '28');
        $sheet->setCellValue('AE6', '29');
        $sheet->setCellValue('AF6', '30');
        $sheet->setCellValue('AG6', '31');
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $sn = 7;
        foreach ($jadwal->result() as $jdl) {
            $sheet->setCellValue('A' . $sn, $jdl->npk);
            $sheet->setCellValue('B' . $sn, $jdl->name);
            $sheet->setCellValue('C' . $sn, $jdl->tanggal_1);
            $sheet->setCellValue('D' . $sn, $jdl->tanggal_2);
            $sheet->setCellValue('E' . $sn, $jdl->tanggal_3);
            $sheet->setCellValue('F' . $sn, $jdl->tanggal_4);
            $sheet->setCellValue('G' . $sn, $jdl->tanggal_5);
            $sheet->setCellValue('H' . $sn, $jdl->tanggal_6);
            $sheet->setCellValue('I' . $sn, $jdl->tanggal_7);
            $sheet->setCellValue('J' . $sn, $jdl->tanggal_8);
            $sheet->setCellValue('K' . $sn, $jdl->tanggal_9);
            $sheet->setCellValue('L' . $sn, $jdl->tanggal_10);
            $sheet->setCellValue('M' . $sn, $jdl->tanggal_11);
            $sheet->setCellValue('N' . $sn, $jdl->tanggal_12);
            $sheet->setCellValue('O' . $sn, $jdl->tanggal_13);
            $sheet->setCellValue('P' . $sn, $jdl->tanggal_14);
            $sheet->setCellValue('Q' . $sn, $jdl->tanggal_15);
            $sheet->setCellValue('R' . $sn, $jdl->tanggal_16);
            $sheet->setCellValue('S' . $sn, $jdl->tanggal_17);
            $sheet->setCellValue('T' . $sn, $jdl->tanggal_18);
            $sheet->setCellValue('U' . $sn, $jdl->tanggal_19);
            $sheet->setCellValue('V' . $sn, $jdl->tanggal_20);
            $sheet->setCellValue('W' . $sn, $jdl->tanggal_21);
            $sheet->setCellValue('X' . $sn, $jdl->tanggal_22);
            $sheet->setCellValue('Y' . $sn, $jdl->tanggal_23);
            $sheet->setCellValue('Z' . $sn, $jdl->tanggal_24);
            $sheet->setCellValue('AA' . $sn, $jdl->tanggal_25);
            $sheet->setCellValue('AB' . $sn, $jdl->tanggal_26);
            $sheet->setCellValue('AC' . $sn, $jdl->tanggal_27);
            $sheet->setCellValue('AD' . $sn, $jdl->tanggal_28);
            $sheet->setCellValue('AE' . $sn, $jdl->tanggal_29);
            $sheet->setCellValue('AF' . $sn, $jdl->tanggal_30);
            $sheet->setCellValue('AG' . $sn, $jdl->tanggal_31);
            $sn++;
        }

        $sheet->getStyle('A1:AG' . $sn - 1)->applyFromArray($styleArray);
        //judul jadwal patroli
        $sheet->getStyle('A1:AG2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('00FF7F');
        $sheet->getStyle('A1:AG2')
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER_CONTINUOUS);
        $sheet->getStyle('A1:AG2')
            ->getFont()
            ->setSize(20)
            ->setBold(true);
        //bulan & tahun 
        $sheet->getStyle('B3:B4')
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $writer = new Xlsx($spreadsheet);

        //npk & nama 
        $sheet->getStyle('A5:B6')
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $writer = new Xlsx($spreadsheet);
        $sheet->getStyle('A5:AG6')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('00FF7F');
        $sheet->getStyle('A5:AG6')
            ->getFont()
            ->setBold(true);
        //title tanggal
        $sheet->getStyle('C5:AG5')
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $writer = new Xlsx($spreadsheet);

        //tanggal 
        $sheet->getStyle('C6:AG' . $sn)
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $writer = new Xlsx($spreadsheet);
        $writer->save("php://output");
    }

    //form koreksi jadwal petugas patroli
    public function form_rubah_jadwal_petugas(Type $var = null)
    {

        $data['session_plant']  = "";
        $data['tahun_pilih']    = "";
        $data['bulan_pilih']    = "";
        $data['tanggal_pilih']  = "";
        $data['session_date'] = "";
        $date = "";
        if (isset($_POST['lihat'])) {
            $date       = $this->input->post("date");
            $plant_id   = $this->input->post("plant_id");
            $data['petugas'] = $this->M_patrol->petugasPerTanggal($date, $plant_id);
            //data pencarian
            $data['session_plant'] = $plant_id;
            $data['session_date'] = $date;
        }
        $data['link']                = $this->uri->segment(1);
        $data['plant']               = $this->M_patrol->ambilData("admisecsgp_mstplant");
        $data['daftar_bulan'] = [
            'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'
        ];

        $data['produksi']   =
            $this->load->view("template/sidebar", $data);
        $this->load->view("form_edit_jadwal_petugas", $data);
        $this->load->view("template/footer");
    }

    public function load_data_petugas()
    {
        $plant_id     = $this->input->post("plant_id");
        $shift        = $this->input->post("shift");
        $nama         = $this->input->post("nama");
        $npk          = $this->input->post("npk");
        $shift_id     = $this->input->post("shift_id");
        $user_id      = $this->input->post("user_id");
        $id_update    = $this->input->post("id_update");
        $tgl_patroli  = $this->input->post("tanggal_patroli");
        $data =  [
            'id'                 => $id_update,
            'nama'               => $nama,
            'npk'                => $npk,
            'plant_id'           => $plant_id,
            'id_user'            => $user_id,
            'shift'              => $shift,
            'shift_id'           => $shift_id,
            'data_petugas'       => $this->M_patrol->daftarSecurity($plant_id),
            'data_shift'         => $this->db->query("select * from admisecsgp_mstshift where status = 1  "),
            'tanggal_patroli'    => $tgl_patroli
        ];
        $this->load->view("ajax/list_user", $data);
    }

    //update petugas patroli 
    public function update_petugas_patroli()
    {
        $shift      = $this->input->post("shift_id");

        $where = [
            'date_patroli'                      => $this->input->post("tanggal_patroli"),
            'admisecsgp_mstplant_plant_id'      => $this->input->post("plant_id"),
            'admisecsgp_mstusr_npk'             => $this->input->post("user_npk"),
        ];

        $data = [
            'admisecsgp_mstshift_shift_id'   => $shift,
            'updated_by'                     => $this->session->userdata('id_token'),
            'updated_at'                     => date('Y-m-d H:i:s')
        ];

        $update = $this->M_patrol->update("admisecsgp_trans_jadwal_patroli", $data, $where);
        if ($update) {
            echo "1";
        } else {
            echo "0";
        }
    }
}
