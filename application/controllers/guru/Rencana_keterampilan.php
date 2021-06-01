<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Rencana_keterampilan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Ion_auth_model');
		$this->load->model('Model_profile');
		$this->load->model('Model_tahunpelajaran');
        $this->load->model('Model_users');
        
        $this->load->model('Model_mapel');
        $this->load->model('Model_kelas');
        $this->load->model('Model_kompetensi');
		
        $this->load->library('Template');
        $this->load->library('Ion_auth');
		
		if (!$this->ion_auth->is_guru()){redirect('Auth/login');}
		// Data Aplikasi
		$this->data['logo_aplikasi']= $this->Model_profile->read_data()->pr_logo;
		$this->data['nama_aplikasi']= $this->Model_profile->read_data()->pr_nama_aplikasi;
		$this->data['ket_aplikasi']= $this->Model_profile->read_data()->pr_ket_aplikasi;
        $this->data['nama']= $this->Model_profile->read_data()->pr_nama;
		// Tahun pelajaran
		$tahun_explode = explode('-',$this->Model_profile->read_data()->tp_tahun);
		$p_tahun = $tahun_explode[0];
		$p_semester = $tahun_explode[1];
		$this->data['p_tahun_pelajaran']= $p_tahun.' (Semester '.$p_semester.')';
		$this->data['tahunpelajaran_dipilih']= $this->Model_tahunpelajaran->read_data_by_id($this->session->userdata('tahun'));
        $this->data['u_photo'] = $this->Model_users->read_data_by_id($this->session->userdata('user_id'))->u_photo;
		// Data Email User
		$users = $this->Model_users->read_data_by_id($this->session->userdata('user_id'));
        $this->data['u_email'] = $users->email;
    }

    public function index()
    {
        $this->data['list_kelas'] = $this->Model_kelas->list_kelas_by_id($this->session->userdata('user_id'));
		$this->data['list_kelas_attribute'] = [
			'name' => 'idkelas',
			'id' => 'idkelas',
			'class' => 'form-control col-lg-10',
			'required' => 'required'
        ];
        $this->data['list_mapel'] = $this->Model_mapel->list_mapel_by_id($this->session->userdata('user_id'));
		$this->data['list_mapel_attribute'] = [
			'name' => 'idmata_pelajaran',
			'id' => 'idmata_pelajaran',
			'class' => 'form-control col-lg-10',
			'required' => 'required'
        ];
        $this->data['list_ph'] = [
            '' => '- Pilih Jumlah PH -',
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',
            '8' => '8',
            '9' => '9',
            '10' => '10',
        ];
		$this->data['list_ph_attribute'] = [
			'name' => 'jumlah_ph',
			'id' => 'jumlah_ph',
			'class' => 'form-control col-lg-10',
			'required' => 'required'
        ];
        $this->template->load('guru/template','guru/rencana_keterampilan/rencana_keterampilan',$this->data);
    }

    public function ajax_list()
	{
		//get_datatables terletak di model
		$idmapel = $this->uri->segment(4);
		$idkelas = $this->uri->segment(5);
        $list = $this->Model_kompetensi->get_datatables_keterampilan($idmapel,$this->session->userdata('tahun'),$this->session->userdata('user_id'),$idkelas);
        
		$data = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_kompetensi) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $data_kompetensi->kd_kategori;
			$row[] = $data_kompetensi->kd_kode;
            $row[] = $data_kompetensi->kd_nama;
            if ($data_kompetensi->kd_status=='Y'){
                $row[] = '<center><input type="checkbox" name="kd_status" id="kd_status" data-id="'.$data_kompetensi->idkompetensi_dasar.'" value="'.$data_kompetensi->kd_status.'" checked></center>';
            } else {
                $row[] = '<center><input type="checkbox" name="kd_status" id="kd_status" data-id="'.$data_kompetensi->idkompetensi_dasar.'" value="'.$data_kompetensi->kd_status.'"></center>';
            }

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_kompetensi->count_all_keterampilan($idmapel,$this->session->userdata('tahun'),$this->session->userdata('user_id')),
			"recordsFiltered" => $this->Model_kompetensi->count_filtered_keterampilan($idmapel,$this->session->userdata('tahun'),$this->session->userdata('user_id')),
			"data" => $data
		);
		//output to json format
		echo json_encode($output);
    }

    public function update_status() {
        $data = $this->input->post();
        $r['status'] = "";
        $new_status = "";

        $status = $data['kd_status'];
        if ($status=='N'){
            $new_status = 'Y';
        } else {
            $new_status = 'N';
        }

        $insert = [
            'kd_status' => $new_status
        ];
        $id = $data['idkompetensi'];

        $this->Model_kompetensi->update_data($insert,$id);
        $this->log_activity($this->session->userdata('nama').' mengubah status kompetensi dasar yang dipilih ');
        $r['status'] = "ok";

        
        header('Content-Type: application/json');
        echo json_encode($r);
    }

    public function save() {
        $data = $this->input->post();

        $r['status'] = "";

        $check = [
            'idtahun_pelajaran' => filter($this->session->userdata('tahun')),
            'idusers' => filter($this->session->userdata('user_id')),
            'idkelas' => filter($data['idkelas']),
            'idmata_pelajaran' => filter($data['idmata_pelajaran'])
        ];

        $insert = [
            'idtahun_pelajaran' => filter($this->session->userdata('tahun')),
            'idusers' => filter($this->session->userdata('user_id')),
            'idkelas' => filter($data['idkelas']),
            'idmata_pelajaran' => filter($data['idmata_pelajaran']),
            'rkdk_penilaian_harian' => filter($data['jumlah_ph'])
        ];
        $id = $this->Model_kompetensi->check_rencana_keterampilan($check);

        if ($id != ''){
            $this->Model_kompetensi->update_rencana_keterampilan($insert,$id['idrencana_kd_keterampilan']);
            $this->log_activity($this->session->userdata('nama').' mengubah data rencana keterampilan');
            $r['status'] = "update";
        } else {
            $this->Model_kompetensi->create_rencana_keterampilan($insert);
            $this->log_activity($this->session->userdata('nama').' menambah data rencana keterampilan');
            $r['status'] = "insert";
        }
        
        header('Content-Type: application/json');
        echo json_encode($r);
    }

    public function check_ph() {
        $data = $this->input->post();

        $r['status'] = "";

        $check = [
            'idtahun_pelajaran' => filter($this->session->userdata('tahun')),
            'idusers' => filter($this->session->userdata('user_id')),
            'idkelas' => filter($data['idkelas']),
            'idmata_pelajaran' => filter($data['idmata_pelajaran'])
        ];
        
        $id = $this->Model_kompetensi->check_rencana_keterampilan($check);

        if ($id != ''){
            $r['status'] = "y";
            $r['data'] = $id;
        } else {
            $r['status'] = "n";
            $r['data']['rkdk_penilaian_harian'] = "";
        }
        
        header('Content-Type: application/json');
        echo json_encode($r);
    }

    // ****** LOG ACTIVITY ****** //
    function log_activity($data)
    {
        $idusers_log = $this->session->userdata('user_id');
        if($idusers_log!=''){
            $log_activity = [
                'idtahun_pelajaran' => $this->session->userdata('tahun'),
                'idusers' => $idusers_log,
                'activity' => $data,
                'log_date' => date('Y-m-d H:i:s')
            ];
            $this->Model_activity->create_data($log_activity);
        } 
    }
    // ****** LOG ACTIVITY ****** //
}