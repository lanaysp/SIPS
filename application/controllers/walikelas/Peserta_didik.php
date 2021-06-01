<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Peserta_didik extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Ion_auth_model');
		$this->load->model('Model_profile');
        $this->load->model('Model_tahunpelajaran');
        $this->load->model('Model_users');

        $this->load->model('Model_siswa');
        $this->load->model('Model_siswa_guru');
        $this->load->model('Model_kelas');
        $this->load->model('Model_alamat');
		
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
        // untuk edit data 
        $this->data['edit_provinsi'] = $this->Model_alamat->read_provinsi();
		$this->data['edit_provinsi_attribute'] = [
			'name' => 's_tl_idprovinsi',
			'id' => 's_tl_idprovinsi',
			'class' => 'form-control'
		];
		$this->data['edit_kota'] = ' - Pilih Kota -';   
		$this->data['edit_kota_attribute'] = [
			'name' => 's_tl_idkota',
			'id' => 's_tl_idkota',
			'class' => 'form-control'
		];
		$this->data['current_kota'] = array(
			'name'			=>'current_kota',
			'id'			=>'current_kota',
			'class'			=>'form-control',
			'required'		=>'required',
			'type'			=>'hidden',
		);
        $this->data['edit_jenis_kelamin'] = [
			'' => '- Jenis Kelamin -',
			'P' => 'Perempuan',
			'L' => 'Laki - laki'
		];
		$this->data['edit_jenis_kelamin_attr'] = [
			'name' => 's_jenis_kelamin',
			'id' => 's_jenis_kelamin',
			'class' => 'form-control',
			'required' => 'required'
        ];	
        $this->data['edit_kelas'] = $this->Model_kelas->list_kelas();
		$this->data['edit_kelas_attr'] = [
			'name' => 's_kelas',
			'id' => 's_kelas',
			'class' => 'form-control',
			'required' => 'required'
        ];
        
        // Untuk menambah data
        $this->data['list_siswa'] = $this->Model_siswa->list_siswa();
		$this->data['list_siswa_attribute'] = [
			'name' => 'list_siswa',
			'id' => 'list_siswa',
			'class' => 'form-control select2bs4',
			'required' => 'required'
        ];
        $this->template->load('walikelas/template','walikelas/peserta_didik/peserta_didik',$this->data);
    }

    public function ajax_list()
	{
		//get_datatables terletak di model
        $kelas = $this->Model_kelas->check_kelas($this->session->userdata('user_id'));
        if ($kelas!=false){
            $idkelas = $kelas->idkelas;
        } else {
            $idkelas = '';
        }

        $ck_peserta = $this->Model_siswa_guru->check_data_peserta($idkelas,$this->session->userdata('tahun'),$this->session->userdata('user_id'));
        if($ck_peserta!=true){
            $this->Model_siswa_guru->batch_peserta($this->session->userdata('tahun'),$this->session->userdata('user_id'),$idkelas);
        } 
        // else {
        //     $this->Model_siswa_guru->batch_peserta_new($this->session->userdata('tahun'),$this->session->userdata('user_id'),$idkelas);
        // }
        
		$list = $this->Model_siswa_guru->get_datatables($this->session->userdata('user_id'));

		$data = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_siswa) {
            $duplikat = $this->Model_siswa_guru->check_duplikat_siswa($data_siswa->idsiswa,$idkelas);
            if ($duplikat){
                $this->Model_siswa_guru->delete_old_data($data_siswa->idsiswa,$idkelas);
            }

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $data_siswa->k_tingkat.' ('.$data_siswa->k_romawi.')';
			$row[] = $data_siswa->s_nisn;
			$row[] = $data_siswa->s_nama;
			$row[] = $data_siswa->s_nik;
			$row[] = $data_siswa->s_jenis_kelamin;
			$row[] = $data_siswa->city_name;
			$row[] = date('d-M-Y',strtotime($data_siswa->s_tanggal_lahir));
			$row[] = $data_siswa->s_wali;
			$row[] = $data_siswa->s_dusun;
			$row[] = $data_siswa->s_desa;
			$row[] = $data_siswa->s_kecamatan;
			$row[] = $data_siswa->s_domisili;
			$row[] = $data_siswa->s_abk;
			$row[] = $data_siswa->s_bsm_pip;
			$row[] = $data_siswa->s_keluarga_miskin;
            $row[] = '<a onclick="return edit('.$data_siswa->idsiswa.')" class="btn btn-info btn-sm text-light"><i class="fa fa-edit"></i> Edit</a>';

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_siswa_guru->count_all($idkelas),
			"recordsFiltered" => $this->Model_siswa_guru->count_filtered($this->session->userdata('user_id')),
			"data" => $data
		);
		//output to json format
		echo json_encode($output);
    }
    
    public function read_kota()
	{
		$this->data['edit_kota'] = $this->Model_alamat->read_kota($this->uri->segment(4));
		$this->data['edit_kota_attribut'] = array(
			'id'			=>'s_tl_idkota',
			'name'			=>'s_tl_idkota',
			'class'			=>'form-control',
			'required'		=>'required',
			'style'			=>'width:100%;'
		);
		$this->load->view('walikelas/peserta_didik/_kota',$this->data);
    }
    
    public function reload_kota()
    {
        $siswa = $this->Model_siswa->read_data_by_id($this->uri->segment(4));
        $this->data['edit_kota'] = $this->Model_alamat->read_kota($siswa['s_tl_idprovinsi']);
		$this->data['edit_kota_attribut'] = array(
			'id'			=>'s_tl_idkota',
			'name'			=>'s_tl_idkota',
			'class'			=>'form-control',
			'required'		=>'required',
			'style'			=>'width:100%;'
		);
		$this->load->view('walikelas/peserta_didik/_kota',$this->data);
    }
    
    public function edit($id)
    {
        $check = $this->Model_siswa->read_data_by_id($id);
        $data = array();
        if(empty($check)){
            $data['data']['idsiswa'] = "";
            $data['data']['mode'] = "add";
            $data['data']['s_nisn'] = "";
            $data['data']['s_nama'] = "";
            $data['data']['s_nik'] = "";
            $data['data']['s_jenis_kelamin'] = "";
            $data['data']['s_tl_idprovinsi'] = "";
            $data['data']['s_tl_idkota'] = "";
            $data['data']['s_tanggal_lahir'] = "";
            $data['data']['s_wali'] = "";
            $data['data']['s_dusun'] = "";
            $data['data']['s_desa'] = "";
            $data['data']['s_kecamatan'] = "";
            $data['data']['s_domisili'] = "";
            $data['data']['s_abk'] = "";
            $data['data']['s_bsm_pip'] = "";
            $data['data']['s_keluarga_miskin'] = "";
        } else {
            $data['data'] = $check;
        }
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function save() {
        $data = $this->input->post();

        $r['status'] = "";

        $kota = $data['s_tl_idkota'];
		if ($kota==0){
			$kota = $data['current_kota'];
		} else {
			$kota = $kota;
		}

        $insert = [
            's_nisn' => filter($data['s_nisn']),
            's_nama' => filter($data['s_nama']),
            's_nik' => filter($data['s_nik']),
            's_jenis_kelamin' => filter($data['s_jenis_kelamin']),
            's_tl_idprovinsi' => filter($data['s_tl_idprovinsi']),
            's_tl_idkota' => filter($kota),
            's_tanggal_lahir' => filter($data['s_tanggal_lahir']),
            's_wali' => filter($data['s_wali']),
            's_dusun' => filter(strtoupper($data['s_dusun'])),
            's_desa' => filter(strtoupper($data['s_desa'])),
            's_kecamatan' => filter(strtoupper($data['s_kecamatan'])),
            's_domisili' => filter($data['s_domisili']),
            's_abk' => filter($data['s_abk']),
            's_bsm_pip' => filter($data['s_bsm_pip']),
            's_keluarga_miskin' => filter($data['s_keluarga_miskin'])
        ];
        $id = $data['_id'];

        if ($this->Model_siswa->check_data($insert)){
            return false;
        }

        if ($data['_mode'] == 'add'){
            $this->Model_siswa->create_data($insert);
            $r['status'] = "ok";
            $this->log_activity($this->session->userdata('nama').' menambah data peserta didik '.filter($data['s_nama']));
        } else if ($data['_mode'] == 'edit'){
            $this->Model_siswa->update_data($insert,$id);
            $this->log_activity($this->session->userdata('nama').' mengubah data peserta didik '.filter($data['s_nama']));
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