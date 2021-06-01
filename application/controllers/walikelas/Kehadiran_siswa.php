<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kehadiran_siswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Ion_auth_model');
		$this->load->model('Model_profile');
        $this->load->model('Model_tahunpelajaran');
        $this->load->model('Model_users');

        $this->load->model('Model_kehadiran');
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
        // Untuk menambah data
        $this->data['list_siswa'] = $this->Model_siswa->list_siswa();
		$this->data['list_siswa_attribute'] = [
			'name' => 'list_siswa',
			'id' => 'list_siswa',
			'class' => 'form-control select2bs4',
			'required' => 'required'
        ];
        
        $this->template->load('walikelas/template','walikelas/kehadiran_siswa/kehadiran_siswa',$this->data);
    }

    public function ajax_list()
	{
		//get_datatables terletak di model
		$list = $this->Model_kehadiran->get_datatables($this->session->userdata('tahun'),$this->session->userdata('user_id'));
        $siswa = $this->Model_kelas->check_kelas($this->session->userdata('user_id'));
        if ($siswa==true){
            $idkelas = $siswa->idkelas;
        } else {
            $idkelas = '';
        }
        $ck_kehadiran = $this->Model_kehadiran->check_data_kehadiran($this->session->userdata('tahun'),$this->session->userdata('user_id'));

        if($ck_kehadiran!=true){
            $this->Model_kehadiran->batch_kehadiran($this->session->userdata('tahun'),$this->session->userdata('user_id'),$idkelas);
        } 
        // else {
        //     $this->Model_kehadiran->batch_kehadiran_new($this->session->userdata('tahun'),$this->session->userdata('user_id'),$idkelas);
        // }
        
		$data = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_kehadiran) {
            $duplikat = $this->Model_kehadiran->check_duplikat_siswa($data_kehadiran->idsiswa);
            if ($duplikat){
                $this->Model_kehadiran->delete_old_data($data_kehadiran->idsiswa);
            }

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $data_kehadiran->k_tingkat.' ('.$data_kehadiran->k_keterangan.')';
			$row[] = $data_kehadiran->s_nama;
			$row[] = $data_kehadiran->kh_izin;
			$row[] = $data_kehadiran->kh_sakit;
			$row[] = $data_kehadiran->kh_tanpa_keterangan;
			$row[] = date('d-M-Y / H:i:s',strtotime($data_kehadiran->kh_created));
            $row[] = '<center>
                      <a onclick="return detail('.$data_kehadiran->idkehadiran.')" class="btn btn-info btn-sm text-light"><i class="fa fa-eye"></i> Detail</a>
                      </center>';

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_kehadiran->count_all($this->session->userdata('tahun'),$idkelas),
			"recordsFiltered" => $this->Model_kehadiran->count_filtered($this->session->userdata('tahun'),$this->session->userdata('user_id')),
			"data" => $data
		);
		//output to json format
		echo json_encode($output);
    }
    
    public function edit($id)
    {
        $check = $this->Model_kehadiran->read_data_by_id($id);
        $data = array();
        if(empty($check)){
            $data['data']['idkehadiran'] = "";
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
            'idusers' => $this->session->userdata('user_id'),
            'idtahun_pelajaran' => $this->session->userdata('tahun'),
            'kh_izin' => filter($data['kh_izin']),
            'kh_sakit' => filter($data['kh_sakit']),
            'kh_tanpa_keterangan' => filter($data['kh_tanpa_keterangan']),
        ];

        $edit = [
            'idusers' => $this->session->userdata('user_id'),
            'idtahun_pelajaran' => $this->session->userdata('tahun'),
            'kh_izin' => filter($data['kh_izin']),
            'kh_sakit' => filter($data['kh_sakit']),
            'kh_tanpa_keterangan' => filter($data['kh_tanpa_keterangan']),
            'kh_created' => date('Y-m-d H:i:s')
        ];
        $id = $data['_id'];

        // if ($this->Model_kehadiran->check_data($insert)){
        //     return false;
        // }

        if ($data['_mode'] == 'add'){
            $this->Model_kehadiran->create_data($insert);
            $r['status'] = "ok";
        } else if ($data['_mode'] == 'edit'){
            $this->Model_kehadiran->update_data($edit,$id);
            $this->log_activity($this->session->userdata('nama').' mengubah data kehadiran siswa '.filter($data['s_nama']));
            $r['status'] = "ok";
        } else {
            $r['status'] = "gagal";
        }
        header('Content-Type: application/json');
        echo json_encode($r);
    }

    public function reset_data() 
    {
        if ($this->Model_kehadiran->reset_data()){
            $siswa = $this->Model_kelas->check_kelas($this->session->userdata('user_id'));
            if ($siswa==true){
                $idkelas = $siswa->idkelas;
            } else {
                $idkelas = '';
            }
            $this->Model_kehadiran->batch_kehadiran($this->session->userdata('tahun'),$this->session->userdata('user_id'),$idkelas);
            
            $r['status'] = "ok"; 
            $this->log_activity($this->session->userdata('nama').' mereset data kehadiran siswa');
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
                'idsiswa' => $idsiswa,
            ];
            if ($this->Model_kehadiran->check_data($check_siswa)){
                $r['status'] = 'ada';
            } else {
                $create = [
                    'idtahun_pelajaran' => $this->session->userdata('tahun'),
                    'idusers' => $this->session->userdata('user_id'),
                    'idsiswa' => $idsiswa,
                    'kh_sakit' => 0,
                    'kh_izin' => 0,
                    'kh_tanpa_keterangan' => 0,
                    'kh_created' => date('Y-m-d H:i:s')
                ];
                $this->Model_kehadiran->create_data($create);
                $r['status'] = 'ok';
                $this->log_activity($this->session->userdata('nama').' menambah 1 data siswa baru kedalam kehadiran siswa');
                
            }
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