<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Ion_auth_model');
		$this->load->model('Model_profile');
		$this->load->model('Model_users');
		$this->load->model('Model_alamat');
		$this->load->model('Model_tahunpelajaran');
		$this->load->model('Model_mapel');
		$this->load->model('Model_kelas');
		
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
    }

    public function index()
    {
        $users = $this->Model_users->read_data_by_id($this->session->userdata('user_id'));
        $groups = $this->Model_users->read_users_groups_by_id($this->session->userdata('user_id'));
        $diklat = $this->Model_users->read_diklat_by_id($this->session->userdata('user_id'));
        $mapel = $this->Model_users->read_mapel_by_id($this->session->userdata('user_id'));
        $kelas = $this->Model_users->read_kelas_by_id($this->session->userdata('user_id'));

        // id untuk edit
        $this->data['idusers'] = $users->idusers;
        $this->data['users_status'] = $groups->description;

        $this->data['u_nama_awal'] = $users->first_name;
        $this->data['u_nama_akhir'] = $users->last_name;
        $this->data['u_nbm_nip'] = $users->u_nbm_nip;
        $this->data['u_nuptk_nuks'] = $users->u_nuptk_nuks;
        $this->data['u_provinsi_lahir'] = $users->province;
        $this->data['u_kota_lahir'] = $users->city_name;
        $this->data['u_tanggal_lahir'] = $users->u_tanggal_lahir;
        if ($users->u_jenis_kelamin=='P'){
            $this->data['u_jk'] = 'Perempuan';
        } else {
            $this->data['u_jk'] = 'Laki - laki';
        }
        $this->data['u_status_pegawai'] = $users->u_status_pegawai;
        $this->data['u_tunjangan_apbd'] = $users->u_tunjangan_apbd;
        $this->data['u_tugas_tambahan'] = $users->u_tugas_tambahan;
        $this->data['u_telepon'] = $users->phone;
        $this->data['u_email'] = $users->email;
        if ($users->u_tunjangan_apbd==null){
            $this->data['u_apbd'] = '-';
        } else {
            $this->data['u_apbd'] = $users->u_tunjangan_apbd;
		}
		$this->data['u_tunjangan'] = $users->u_tunjangan_apbd;
        $this->data['u_jenjang'] = $users->u_jenjang;
        $this->data['u_perguruan_tinggi'] = $users->u_perguruan_tinggi;
        $this->data['u_jurusan'] = $users->u_jurusan;
        $this->data['u_tahun_lulus'] = $users->u_tahun_lulus;
        $this->data['u_npwp'] = $users->u_npwp;
        if ($users->u_sertifikasi=='Sudah'){
            $this->data['u_sertifikasi_status'] = 'Sudah';
            $this->data['u_sertifikasi_tahun'] = $users->u_sertifikasi_tahun;
        } else {
            $this->data['u_sertifikasi_status'] = 'Belum';
            $this->data['u_sertifikasi_tahun'] = '-';
        }
        $this->data['u_prestasi'] = $users->u_prestasi;
        $this->data['u_nominal_honor'] = $users->u_honor;
        $this->data['u_kerja_pasangan'] = $users->u_kerja_pasangan;
        $this->data['u_alamat_tinggal'] = $users->u_alamat_tinggal;
        $this->data['u_photo'] = $users->u_photo;

		// normalisasi tabel
        $this->data['diklat'] = $diklat;
        $this->data['mapel'] = $mapel;
        $this->data['kelas'] = $kelas;

        // untuk edit data 
        $this->data['edit_provinsi'] = $this->Model_alamat->read_provinsi();
		$this->data['edit_provinsi_select'] = $users->u_tl_idprovinsi;
		$this->data['edit_provinsi_attribute'] = [
			'name' => 'u_tl_idprovinsi',
			'id' => 'u_tl_idprovinsi',
			'class' => 'form-control',
			'required' => 'required',
			'value' => $users->u_tl_idprovinsi
		];
		$this->data['edit_kota'] = $this->Model_alamat->read_kota($users->u_tl_idprovinsi);
		$this->data['edit_kota_select'] = $users->u_tl_idkota;
		$this->data['edit_kota_attribute'] = [
			'name' => 'u_tl_idkota',
			'id' => 'u_tl_idkota',
			'class' => 'form-control',
			'required' => 'required',
			'value' => $users->u_tl_idkota
		];
        $this->data['current_kota'] = array(
			'name'			=>'current_kota',
			'id'			=>'current_kota',
			'class'			=>'form-control',
			'required'		=>'required',
			'type'			=>'hidden',
			'value'			=>$users->u_tl_idkota
		);
		$this->data['edit_jenis_kelamin'] = [
			'' => '- Jenis Kelamin -',
			'P' => 'Perempuan',
			'L' => 'Laki - laki'
		];
		$this->data['edit_jenis_kelamin_select'] = $users->u_jenis_kelamin;
		$this->data['edit_jenis_kelamin_attr'] = [
			'name' => 'u_jenis_kelamin',
			'id' => 'u_jenis_kelamin',
			'class' => 'form-control',
			'required' => 'required'
		];
		$this->data['edit_groups'] = [
			'' => '- Pilih Status -',
			'1' => 'Administrator'
		];
		$this->data['edit_groups_select'] = $groups->group_id;
		$this->data['edit_groups_attr'] = [
			'name' => 'users_groups',
			'id' => 'users_groups',
			'class' => 'form-control',
			'required' => 'required'
		];
		$this->data['edit_mapel'] = $this->Model_mapel->list_mapel();
		$this->data['edit_mapel_attr'] = [
			'name' => 'mata_pelajaran',
			'id' => 'mata_pelajaran',
			'class' => 'form-control',
			'required' => 'required'
		];

		$this->data['edit_kelas'] = $this->Model_kelas->list_kelas();
		$this->data['edit_kelas_attr'] = [
			'name' => 'kelas',
			'id' => 'kelas',
			'class' => 'form-control',
			'required' => 'required'
		];
        
        $this->template->load('administrator/template','administrator/data/data',$this->data);
    }

    public function read_kota()
	{
		$this->data['edit_kota'] = $this->Model_alamat->read_kota($this->uri->segment(4));
		$this->data['edit_kota_attribut'] = array(
			'id'			=>'u_tl_idkota',
			'name'			=>'u_tl_idkota',
			'class'			=>'form-control',
			'required'		=>'required',
			'style'			=>'width:100%;'
		);
		$this->load->view('administrator/users/_kota',$this->data);
	}

	public function edit_diklat($id)
    {
        $check = $this->Model_users->read_row_diklat_by_id($id);
        $data = array();
        if(empty($check)){
            $data['data']['iddiklat'] = "";
            $data['data']['mode'] = "add";
            $data['data']['d_nama'] = "";
            $data['data']['d_penyelenggara'] = "";
            $data['data']['d_tahun'] = "";
        } else {
            $data['data'] = $check;
        }
        header('Content-Type: application/json');
        echo json_encode($data);
	}
	
	public function edit_mapel($id)
    {
        $check = $this->Model_users->read_row_mapel_by_id($id);
        $data = array();
        if(empty($check)){
            $data['data']['idmata_pelajaran_guru'] = "";
            $data['data']['mode'] = "add";
            $data['data']['idmata_pelajaran'] = "";
        } else {
            $data['data'] = $check;
        }
        header('Content-Type: application/json');
        echo json_encode($data);
	}
	
	public function edit_kelas($id)
    {
        $check = $this->Model_users->read_row_kelas_by_id($id);
        $data = array();
        if(empty($check)){
            $data['data']['idkelas_guru'] = "";
            $data['data']['mode'] = "add";
            $data['data']['idkelas'] = "";
        } else {
            $data['data'] = $check;
        }
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function save_diklat() {
        $data = $this->input->post();

        $r['status'] = "";

        $insert = [
            'idusers' => $this->session->userdata('user_id'),
            'd_nama' => filter(ucwords($data['d_nama'])),
            'd_penyelenggara' => filter(strtoupper($data['d_penyelenggara'])),
            'd_tahun' => filter(ucwords($data['d_tahun']))
        ];
        $id = $data['_id_diklat'];

        if ($this->Model_users->check_data($insert,'diklat')){
            return false;
        }

        if ($data['_mode_diklat'] == 'add'){
            $this->Model_users->create_data($insert,'diklat');
            $r['status'] = "ok";
        } else if ($data['_mode_diklat'] == 'edit'){
            $this->Model_users->update_data($insert,$id,'diklat');
            $r['status'] = "ok";
        } else {
            $r['status'] = "gagal";
        }
        header('Content-Type: application/json');
        echo json_encode($r);
	}

	public function save_mapel() {
        $data = $this->input->post();

        $r['status'] = "";

        $insert = [
            'idusers' => $this->session->userdata('user_id'),
            'idmata_pelajaran' => filter($data['mata_pelajaran'])
        ];
        $id = $data['_id_mapel'];

        if ($this->Model_users->check_data($insert,'mapel')){
            return false;
        }

        if ($data['_mode_mapel'] == 'add'){
            $this->Model_users->create_data($insert,'mapel');
            $r['status'] = "ok";
        } else if ($data['_mode_mapel'] == 'edit'){
            $this->Model_users->update_data($insert,$id,'mapel');
            $r['status'] = "ok";
        } else {
            $r['status'] = "gagal";
        }
        header('Content-Type: application/json');
        echo json_encode($r);
	}

	public function save_kelas() {
        $data = $this->input->post();

        $r['status'] = "";

        $insert = [
            'idusers' => $this->session->userdata('user_id'),
            'idkelas' => filter($data['kelas'])
        ];
        $id = $data['_id_kelas'];

        if ($this->Model_users->check_data($insert,'kelas')){
            return false;
        }

        if ($data['_mode_kelas'] == 'add'){
            $this->Model_users->create_data($insert,'kelas');
            $r['status'] = "ok";
        } else if ($data['_mode_kelas'] == 'edit'){
            $this->Model_users->update_data($insert,$id,'kelas');
            $r['status'] = "ok";
        } else {
            $r['status'] = "gagal";
        }
        header('Content-Type: application/json');
        echo json_encode($r);
	}

	public function update_data()
	{
		$this->load->library('upload');
		$data = $this->input->post();

		$r['status'] = "";

		$id = $data['idusers'];

		$kota = $data['u_tl_idkota'];
		if ($kota==0){
			$kota = $data['current_kota'];
		} else {
			$kota = $kota;
		}
		
		$attach = $data['attach'];
		if($attach=='Y'){
			$countfiles = count((array)$_FILES['files']['name']);
		} else {
			$countfiles = 0;
		}
		
		if($countfiles!=0){
			// Define new $_FILES array - $_FILES['file']
			$_FILES['file']['name'] = $_FILES['files']['name'];
			$_FILES['file']['type'] = $_FILES['files']['type'];
			$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'];
			$_FILES['file']['error'] = $_FILES['files']['error'];
			$_FILES['file']['size'] = $_FILES['files']['size'];

			// Set preference
			$config['upload_path'] = './assets/upload/administrator/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['max_size'] = '5000'; // max_size in kb
			$config['file_name'] = $_FILES['files']['name'];
			$config['encrypt_name'] = true;

			//Load upload library
			$this->upload->initialize($config);
			// File upload
			if($this->upload->do_upload('file')){
				$data_upload = $this->upload->data();
				// Create Thumbnails
				$this->_create_thumbnails($data_upload['file_name']);
				$new_photo = $data_upload['file_name'];
			}
			$foto = $this->Model_users->read_data_by_id($id)->u_photo;
			$dir = "assets/upload/administrator/".$foto;
			$dir_thumbnails = "assets/upload/administrator/thumbnails/".$foto;
			unlink($dir);
			unlink($dir_thumbnails);
			
			$insert_main = [
				'first_name' => filter($data['u_nama_awal']),
				'last_name' => filter($data['u_nama_akhir']),
				'email' => filter($data['u_email']),
				'phone' => filter($data['u_telepon'])
			];
			$insert_sub = [
				'u_nbm_nip' => filter($data['u_nbm_nip']),
				'u_nuptk_nuks' => filter($data['u_nuptk_nuks']),
				'u_tl_idprovinsi' => filter($data['u_tl_idprovinsi']),
				'u_tl_idkota' => filter($kota),
				'u_tanggal_lahir' => $data['u_tanggal_lahir'],
				'u_jenis_kelamin' => filter($data['u_jenis_kelamin']),
				'u_status_pegawai' => filter($data['u_status_pegawai']),
				'u_tunjangan_apbd' => filter($data['u_tunjangan']),
				'u_tugas_tambahan' => filter($data['u_tugas_tambahan']),
				'u_jenjang' => filter($data['u_jenjang']),
				'u_perguruan_tinggi' => filter($data['u_perguruan_tinggi']),
				'u_jurusan' => filter($data['u_jurusan']),
				'u_tahun_lulus' => filter($data['u_tahun_lulus']),
				'u_npwp' => filter($data['u_npwp']),
				'u_sertifikasi' => filter($data['u_sertifikasi']),
				'u_sertifikasi_tahun' => filter($data['u_sertifikasi_tahun']),
				'u_prestasi' => filter($data['u_prestasi']),
				'u_honor' => filter($data['u_nominal_honor']),
				'u_kerja_pasangan' => filter($data['u_kerja_pasangan']),
				'u_alamat_tinggal' => filter($data['u_alamat_tinggal']),
				'u_photo' => $new_photo
			];
			$insert_groups = [
				'group_id' => filter($data['users_groups'])
			];

			$this->Model_users->update_data($insert_main,$id,'users');
			$this->Model_users->update_data($insert_sub,$id,'users_sub');
			$this->Model_users->update_data($insert_groups,$id,'users_groups');
            $r['status'] = "ok";

		} else {
			$insert_main = [
				'first_name' => filter($data['u_nama_awal']),
				'last_name' => filter($data['u_nama_akhir']),
				'email' => filter($data['u_email']),
				'phone' => filter($data['u_telepon'])
			];
			$insert_sub = [
				'u_nbm_nip' => filter($data['u_nbm_nip']),
				'u_nuptk_nuks' => filter($data['u_nuptk_nuks']),
				'u_tl_idprovinsi' => filter($data['u_tl_idprovinsi']),
				'u_tl_idkota' => filter($kota),
				'u_tanggal_lahir' => $data['u_tanggal_lahir'],
				'u_jenis_kelamin' => filter($data['u_jenis_kelamin']),
				'u_status_pegawai' => filter($data['u_status_pegawai']),
				'u_tunjangan_apbd' => filter($data['u_tunjangan']),
				'u_tugas_tambahan' => filter($data['u_tugas_tambahan']),
				'u_jenjang' => filter($data['u_jenjang']),
				'u_perguruan_tinggi' => filter($data['u_perguruan_tinggi']),
				'u_jurusan' => filter($data['u_jurusan']),
				'u_tahun_lulus' => filter($data['u_tahun_lulus']),
				'u_npwp' => filter($data['u_npwp']),
				'u_sertifikasi' => filter($data['u_sertifikasi']),
				'u_sertifikasi_tahun' => filter($data['u_sertifikasi_tahun']),
				'u_prestasi' => filter($data['u_prestasi']),
				'u_honor' => filter($data['u_nominal_honor']),
				'u_kerja_pasangan' => filter($data['u_kerja_pasangan']),
				'u_alamat_tinggal' => filter($data['u_alamat_tinggal'])
			];
			$insert_groups = [
				'group_id' => filter($data['users_groups'])
			];

			$this->Model_users->update_data($insert_main,$id,'users');
			$this->Model_users->update_data($insert_sub,$id,'users_sub');
			$this->Model_users->update_data($insert_groups,$id,'users_groups');
            $r['status'] = "ok";
		}

        header('Content-Type: application/json');
        echo json_encode($r);
	}

	function _create_thumbnails($file_name)
	{
        // Image resizing config
        $config = array(
            // Thumbnails Image
            array(
                'image_library' => 'GD2',
                'source_image'  => './assets/upload/administrator/'.$file_name,
                'maintain_ratio'=> FALSE,
                'width'         => 200,
                'height'        => 200,
                'new_image'     => './assets/upload/administrator/thumbnails/'.$file_name
                )
		);

        $this->load->library('image_lib', $config[0]);
        foreach ($config as $item){
            $this->image_lib->initialize($item);
            if(!$this->image_lib->resize()){
                return false;
            }
            $this->image_lib->clear();
        }
    }
	
	public function delete($id) {
        $this->Model_users->delete_data($id);
        $r['status'] = "ok";
        header('Content-Type: application/json');
        echo json_encode($r);
    }

    public function delete_diklat($id) {
        $this->Model_users->delete_diklat($id);
        $r['status'] = "ok";
        header('Content-Type: application/json');
        echo json_encode($r);
	}
	
	public function delete_mapel($id) {
        $this->Model_users->delete_mapel($id);
        $r['status'] = "ok";
        header('Content-Type: application/json');
        echo json_encode($r);
	}
	
	public function delete_kelas($id) {
        $this->Model_users->delete_kelas($id);
        $r['status'] = "ok";
        header('Content-Type: application/json');
        echo json_encode($r);
	}
	
}