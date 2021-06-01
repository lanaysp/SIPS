<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ekstra_hasil extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Ion_auth_model');
		$this->load->model('Model_profile');
        $this->load->model('Model_tahunpelajaran');
        $this->load->model('Model_users');

        $this->load->model('Model_kelas');
        $this->load->model('Model_ekstra_siswa');
		
        $this->load->library('Template');
        $this->load->library('Ion_auth');
		
        if (!$this->ion_auth->is_admin()){redirect('Auth/login');}
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
    }

    public function index()
    {
        // list kelas
        $this->data['list_kelas'] = $this->Model_kelas->list_kelas();
		$this->data['list_kelas_attribute'] = [
			'name' => 'opsi_kelas',
			'id' => 'opsi_kelas',
			'class' => 'form-control col-lg-10',
			'required' => 'required'
        ];
        $this->template->load('administrator/template','administrator/ekstra/ekstra_hasil',$this->data);
    }

    public function ajax_list()
	{
        //get_datatables terletak di model
        $idkelas = $this->uri->segment(4);
        $kelas = $this->Model_users->read_users_by_kelas($idkelas);
        if ($kelas!=false){
            $idusers = $kelas->idusers;
        } else {
            $idusers = 0;
        }

		//get_datatables terletak di model
		$list = $this->Model_ekstra_siswa->get_datatables_admin($this->session->userdata('tahun'),$idusers);
		$data = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_ekstra_siswa) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $data_ekstra_siswa->k_tingkat.' ('.$data_ekstra_siswa->k_keterangan.')';
			$row[] = $data_ekstra_siswa->s_nama;
			$row[] = $data_ekstra_siswa->e_nama;
			$row[] = $data_ekstra_siswa->es_nilai;
			$row[] = $data_ekstra_siswa->es_deskripsi;
			$row[] = $data_ekstra_siswa->first_name.' '.$data_ekstra_siswa->last_name;

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_ekstra_siswa->count_all_admin($this->session->userdata('tahun'),$idusers),
			"recordsFiltered" => $this->Model_ekstra_siswa->count_filtered_admin($this->session->userdata('tahun'),$idusers),
			"data" => $data
		);
		//output to json format
		echo json_encode($output);
    }
    
    public function edit($id)
    {
        $check = $this->Model_ekstra_siswa->read_data_by_id($id);
        $data = array();
        if(empty($check)){
            $data['data']['idekstra_siswa'] = "";
            $data['data']['mode'] = "add";
            $data['data']['s_nama'] = "";
            $data['data']['kh_izin'] = "";
            $data['data']['kh_sakit'] = "";
            $data['data']['kh_tanpa_keterangan'] = "";
        } else {
            $data['data'] = $check;
        }
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function save() {
        $data = $this->input->post();

        $r['status'] = "";

        $insert = [
            'kh_izin' => filter($data['kh_izin']),
            'kh_sakit' => filter($data['kh_sakit']),
            'kh_tanpa_keterangan' => filter($data['kh_tanpa_keterangan']),
        ];

        $edit = [
            'kh_izin' => filter($data['kh_izin']),
            'kh_sakit' => filter($data['kh_sakit']),
            'kh_tanpa_keterangan' => filter($data['kh_tanpa_keterangan']),
            'kh_created' => date('Y-m-d H:i:s')
        ];
        $id = $data['_id'];

        if ($this->Model_ekstra_siswa->check_data($insert)){
            return false;
        }

        if ($data['_mode'] == 'add'){
            $this->Model_ekstra_siswa->create_data($insert);
            $r['status'] = "ok";
        } else if ($data['_mode'] == 'edit'){
            $this->Model_ekstra_siswa->update_data($edit,$id);
            $this->log_activity('menginput/mengubah data kehadiran siswa '.filter($data['s_nama']));
            $r['status'] = "ok";
        } else {
            $r['status'] = "gagal";
        }
        header('Content-Type: application/json');
        echo json_encode($r);
    }

    public function delete($id,$nama) 
    {
        $this->Model_ekstra_siswa->delete_data($id);
        $this->log_activity('menghapus data kehadiran siswa '.filter(str_replace('%20',' ',$nama)));
        $r['status'] = "ok";
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