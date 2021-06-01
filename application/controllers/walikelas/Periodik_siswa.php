<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Periodik_siswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Ion_auth_model');
		$this->load->model('Model_profile');
        $this->load->model('Model_tahunpelajaran');
        $this->load->model('Model_users');

        $this->load->model('Model_siswa_guru');
        $this->load->model('Model_kelas');
        $this->load->model('Model_alamat');
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
        // Untuk menambah data
        $this->data['list_siswa'] = $this->Model_siswa->list_siswa();
		$this->data['list_siswa_attribute'] = [
			'name' => 'list_siswa',
			'id' => 'list_siswa',
			'class' => 'form-control select2bs4',
			'required' => 'required'
        ];
        $this->template->load('walikelas/template','walikelas/periodik_siswa/periodik_siswa',$this->data);
    }

    public function ajax_list()
	{
		//get_datatables terletak di model
        $siswa = $this->Model_kelas->check_kelas($this->session->userdata('user_id'));
        if ($siswa==true){
            $idkelas = $siswa->idkelas;
        } else {
            $idkelas = '';
        }

        $ck_peserta = $this->Model_siswa_guru->check_data_peserta($idkelas,$this->session->userdata('tahun'),$this->session->userdata('user_id'));
        if($ck_peserta!=true){
            $this->Model_siswa_guru->batch_peserta($this->session->userdata('tahun'),$this->session->userdata('user_id'),$idkelas);
        } 
        
        $list = $this->Model_siswa_guru->get_datatables_wali_p($this->session->userdata('user_id'));
        
		$data = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_siswa) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $data_siswa->k_tingkat.' ('.$data_siswa->k_romawi.')';
			$row[] = $data_siswa->s_nama;
			$row[] = $data_siswa->s_tinggi_badan.' cm';
			$row[] = $data_siswa->s_berat_badan.' kg';
			$row[] = $data_siswa->s_jarak_sekolah;
			$row[] = $data_siswa->s_waktu_sekolah;
            $row[] = '<a onclick="return edit('.$data_siswa->idsiswa_guru.')" class="btn btn-info btn-sm text-light"><i class="fa fa-edit"></i> Edit</a>';

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_siswa_guru->count_all_wali_p($idkelas),
			"recordsFiltered" => $this->Model_siswa_guru->count_filtered_wali_p($this->session->userdata('user_id')),
			"data" => $data
		);
		//output to json format
		echo json_encode($output);
    }
    
    public function edit($id)
    {
        $check = $this->Model_siswa_guru->read_data_by_id($id);
        $data = array();
        if(empty($check)){
            $data['data']['idsiswa_guru'] = "";
            $data['data']['mode'] = "add";
            $data['data']['s_nama'] = "";
            $data['data']['s_tinggi_badan'] = "";
            $data['data']['s_berat_badan'] = "";
            $data['data']['s_jarak_sekolah'] = "";
            $data['data']['s_waktu_sekolah'] = "";
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
            's_tinggi_badan' => filter($data['s_tinggi_badan']),
            's_berat_badan' => filter($data['s_berat_badan']),
            's_jarak_sekolah' => filter(strtolower($data['s_jarak_sekolah'])),
            's_waktu_sekolah' => filter(strtolower($data['s_waktu_sekolah']))
        ];
        
        $id = $data['_id'];

        // if ($this->Model_siswa_guru->check_data($insert)){
        //     return false;
        // }

        if ($data['_mode'] == 'add'){
            $this->Model_siswa_guru->create_data($insert);
            $r['status'] = "ok";
        } else if ($data['_mode'] == 'edit'){
            $this->Model_siswa_guru->update_data($insert,$id);
            $this->log_activity($this->session->userdata('nama').' mengubah data periodik siswa '.filter($data['s_nama']));
            $r['status'] = "ok";
        } else {
            $r['status'] = "gagal";
        }
        header('Content-Type: application/json');
        echo json_encode($r);
    }

    public function reset_data() 
    {
        $kelas = $this->Model_kelas->check_kelas($this->session->userdata('user_id'));
        if ($kelas!=false){
            $idkelas = $kelas->idkelas;
        } else {
            $idkelas = '';
        }
        if ($this->Model_siswa_guru->reset_data($idkelas)){
            $r['status'] = "ok"; 
            $this->log_activity($this->session->userdata('nama').' mereset data periodik siswa');
        }  
        header('Content-Type: application/json');
        echo json_encode($r);
    }

    public function add_one_siswa()
    {
        $data = $this->input->post();
        $kelas = $this->Model_kelas->check_kelas($this->session->userdata('user_id'));
        if ($kelas!=false){
            $idkelas = $kelas->idkelas;
        } else {
            $idkelas = '';
        }
        $idsiswa = $data['idsiswa'];

        $check_kelas_siswa = $this->Model_siswa->read_data_by_id($idsiswa);
        $kelas_siswa = $check_kelas_siswa['idkelas'];

        if ($kelas_siswa!=$idkelas){
            $r['status'] = 'kelas';
        } else {
            $check_siswa = [
                'idtahun_pelajaran' => $this->session->userdata('tahun'),
                'idusers' => $this->session->userdata('user_id'),
                'idkelas' => $idkelas,
                'idsiswa' => $idsiswa
            ];
            if ($this->Model_siswa_guru->check_data($check_siswa)){
                $r['status'] = 'ada';
            } else {
                $create = [
                    'idtahun_pelajaran' => $this->session->userdata('tahun'),
                    'idusers' => $this->session->userdata('user_id'),
                    'idkelas' => $idkelas,
                    'idsiswa' => $idsiswa,
                    's_tinggi_badan' => '',
                    's_berat_badan' => '',
                    's_jarak_sekolah' => '',
                    's_waktu_sekolah' => ''
                ];
                $this->Model_siswa_guru->create_data($create);
                $r['status'] = 'ok';
                $this->log_activity($this->session->userdata('nama').' menambah 1 data siswa baru kedalam peserta didik');
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode($r);
    }

    function log_activity($data)
    {
        // ****** LOG ACTIVITY ****** //
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
        // ****** LOG ACTIVITY ****** //
    }
}