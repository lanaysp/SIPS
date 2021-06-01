<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Prestasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Ion_auth_model');
		$this->load->model('Model_profile');
        $this->load->model('Model_tahunpelajaran');
        $this->load->model('Model_users');

        $this->load->model('Model_prestasi');
        $this->load->model('Model_kelas');
        $this->load->model('Model_siswa');
		
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
        $this->template->load('walikelas/template','walikelas/prestasi/prestasi',$this->data);
    }

    public function ajax_list()
	{
		//get_datatables terletak di model
		$list = $this->Model_prestasi->get_datatables($this->session->userdata('tahun'),$this->session->userdata('user_id'));
        $siswa = $this->Model_kelas->check_kelas($this->session->userdata('user_id'));
        if ($siswa!=false){
            $idkelas = $siswa->idkelas;
        } else {
            $idkelas = '';
        }
		$data = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_ekstra) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $data_ekstra->k_tingkat.' ('.$data_ekstra->k_keterangan.')';
			$row[] = $data_ekstra->s_nama;
			$row[] = $data_ekstra->p_jenis;
			$row[] = $data_ekstra->p_keterangan;
            $row[] = '<a onclick="return edit('.$data_ekstra->idprestasi.')" class="btn btn-info btn-sm text-light"><i class="fa fa-edit"></i> Edit</a> 
                      <a onclick="return delete_data(\''.$data_ekstra->idprestasi.'\',\''.$data_ekstra->s_nama.'\',\''.$data_ekstra->p_jenis.'\')" class="btn btn-danger btn-sm text-light"><i class="fa fa-window-close"></i> Hapus</a>';

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_prestasi->count_all($this->session->userdata('tahun'),$idkelas),
			"recordsFiltered" => $this->Model_prestasi->count_filtered($this->session->userdata('tahun'),$this->session->userdata('user_id')),
			"data" => $data
		);
		//output to json format
		echo json_encode($output);
    }
    
    public function edit($id)
    {
        $check = $this->Model_prestasi->read_data_by_id($id);
        $data = array();
        if(empty($check)){
            $data['data']['idprestasi'] = "";
            $data['data']['mode'] = "add";
            $data['data']['idsiswa'] = "";
            $data['data']['p_jenis'] = "";
            $data['data']['p_keterangan'] = "";
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
            'p_jenis' => filter($data['p_jenis']),
            'p_keterangan' => filter($data['p_keterangan']),
        ];
        $id = $data['_id'];

        if ($this->Model_prestasi->check_data($insert)){
            return false;
        }

        if ($data['_mode'] == 'add'){
            $this->Model_prestasi->create_data($insert);
            $this->log_activity($this->session->userdata('nama').' menambah data prestasi siswa ');
            $r['status'] = "ok";
        } else if ($data['_mode'] == 'edit'){
            $this->Model_prestasi->update_data($insert,$id);
            $this->log_activity($this->session->userdata('nama').' mengubah data prestasi siswa ');
            $r['status'] = "ok";
        } else {
            $r['status'] = "gagal";
        }
        header('Content-Type: application/json');
        echo json_encode($r);
    }

    public function delete($id,$nama) {
        $this->Model_prestasi->delete_data($id);
        $this->log_activity($this->session->userdata('nama').' menghapus data prestasi siswa '.filter(str_replace('%20',' ',$nama)));
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