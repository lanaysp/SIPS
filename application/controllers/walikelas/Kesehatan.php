<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kesehatan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Ion_auth_model');
		$this->load->model('Model_profile');
        $this->load->model('Model_tahunpelajaran');
        $this->load->model('Model_users');

        $this->load->model('Model_kesehatan_siswa');
        $this->load->model('Model_kelas');
        $this->load->model('Model_siswa');
        $this->load->model('Model_kesehatan');
		
        $this->load->library('Template');
        $this->load->library('Ion_auth');
		
        if (!$this->ion_auth->is_walikelas()){redirect('Auth/login');}
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
        $ck = $this->Model_kelas->check_kelas($this->session->userdata('user_id'));
        if ($ck!=false){
            $idkelas = $ck->idkelas;
        } else {
            $idkelas = '';
        }
        $this->data['list_siswa'] = $this->Model_siswa->list_siswa_by_wali($idkelas);
		$this->data['list_siswa_attribute'] = [
			'name' => 'idsiswa',
			'id' => 'idsiswa',
			'class' => 'form-control',
			'required' => 'required'
        ];
        $this->data['list_kesehatan'] = $this->Model_kesehatan->list_kesehatan();
		$this->data['list_kesehatan_attribute'] = [
			'name' => 'idkesehatan',
			'id' => 'idkesehatan',
			'class' => 'form-control',
			'required' => 'required'
        ];
        $this->template->load('walikelas/template','walikelas/kesehatan/kesehatan',$this->data);
    }

    public function ajax_list()
	{
		//get_datatables terletak di model
		$list = $this->Model_kesehatan_siswa->get_datatables($this->session->userdata('tahun'),$this->session->userdata('user_id'));
        $siswa = $this->Model_kelas->check_kelas($this->session->userdata('user_id'));
        if ($siswa!=false){
            $idkelas = $siswa->idkelas;
        } else {
            $idkelas = '';
        }
		$data = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_kesehatan) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $data_kesehatan->k_tingkat.' ('.$data_kesehatan->k_keterangan.')';
			$row[] = $data_kesehatan->s_nama;
			$row[] = $data_kesehatan->ks_aspek;
			$row[] = $data_kesehatan->ks_deskripsi;
            $row[] = '<a onclick="return edit('.$data_kesehatan->idkesehatan_siswa.')" class="btn btn-info btn-sm text-light"><i class="fa fa-edit"></i> Edit</a> 
                      <a onclick="return delete_data(\''.$data_kesehatan->idkesehatan_siswa.'\',\''.$data_kesehatan->s_nama.'\',\''.$data_kesehatan->ks_aspek.'\')" class="btn btn-danger btn-sm text-light"><i class="fa fa-window-close"></i> Hapus</a>';

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_kesehatan_siswa->count_all($this->session->userdata('tahun'),$idkelas),
			"recordsFiltered" => $this->Model_kesehatan_siswa->count_filtered($this->session->userdata('tahun'),$this->session->userdata('user_id')),
			"data" => $data
		);
		//output to json format
		echo json_encode($output);
    }
    
    public function edit($id)
    {
        $check = $this->Model_kesehatan_siswa->read_data_by_id($id);
        $data = array();
        if(empty($check)){
            $data['data']['idkesehatan_siswa'] = "";
            $data['data']['mode'] = "add";
            $data['data']['idsiswa'] = "";
            $data['data']['idkesehatan'] = "";
            $data['data']['ks_deskripsi'] = "";
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
            'idusers' => $this->session->userdata('user_id'),
            'idtahun_pelajaran' => $this->session->userdata('tahun'),
            'idsiswa' => filter($data['idsiswa']),
            'idkesehatan' => filter($data['idkesehatan']),
            'ks_deskripsi' => filter($data['ks_deskripsi']),
        ];
        $id = $data['_id'];

        if ($this->Model_kesehatan_siswa->check_data($insert)){
            return false;
        }

        if ($data['_mode'] == 'add'){
            $this->Model_kesehatan_siswa->create_data($insert);
            $this->log_activity($this->session->userdata('nama').' menambah data kesehatan siswa ');
            $r['status'] = "ok";
        } else if ($data['_mode'] == 'edit'){
            $this->Model_kesehatan_siswa->update_data($insert,$id);
            $this->log_activity($this->session->userdata('nama').' mengubah data kesehatan siswa ');
            $r['status'] = "ok";
        } else {
            $r['status'] = "gagal";
        }
        header('Content-Type: application/json');
        echo json_encode($r);
    }

    public function delete($id,$nama) {
        $this->Model_kesehatan_siswa->delete_data($id);
        $this->log_activity($this->session->userdata('nama').' menghapus data kesehatan siswa '.filter(str_replace('%20',' ',$nama)));
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