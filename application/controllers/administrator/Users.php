<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Ion_auth_model');
		$this->load->model('Model_profile');
		$this->load->model('Model_users');
		$this->load->model('Model_tahunpelajaran');
		$this->load->model('Model_alamat');
		$this->load->model('Model_mapel');
		$this->load->model('Model_kelas');
        $this->load->model('Model_web_config');
		
        $this->load->library('Template');
        $this->load->library('Ion_auth');
        $this->load->library('Form_validation');
		
		if (!$this->ion_auth->is_admin()){redirect('Auth/login');}
		// Data utama aplikasi tiap menu selain dashboard
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
		$this->data['edit_groups'] = [
			'' => '- Pilih Status -',
			'2' => 'Guru',
			'3' => 'Guru Kelas'
		];
		$this->data['edit_groups_attr'] = [
			'name' => 'users_groups',
			'id' => 'users_groups',
			'class' => 'form-control',
			'required' => 'required'
		];
		// untuk edit data 
        $this->data['edit_provinsi'] = $this->Model_alamat->read_provinsi();
		$this->data['edit_provinsi_attribute'] = [
			'name' => 'u_tl_idprovinsi',
			'id' => 'u_tl_idprovinsi',
			'class' => 'form-control',
			'required' => 'required'
		];
		$this->data['edit_kota'] = ' - Pilih Kota -';
		$this->data['edit_kota_attribute'] = [
			'name' => 'u_tl_idkota',
			'id' => 'u_tl_idkota',
			'class' => 'form-control',
			'required' => 'required'
		];
		$this->data['edit_jenis_kelamin'] = [
			'' => '- Jenis Kelamin -',
			'P' => 'Perempuan',
			'L' => 'Laki - laki'
		];
		$this->data['edit_jenis_kelamin_attr'] = [
			'name' => 'u_jenis_kelamin',
			'id' => 'u_jenis_kelamin',
			'class' => 'form-control',
			'required' => 'required'
		];
		$this->template->load('administrator/template','administrator/users/users',$this->data);
	}

	public function ajax_list_guru()
	{
		//get_datatables terletak di model
		$reset_password = $this->Model_web_config->read_data_reset_password()->config_value;
		$list = $this->Model_users->get_datatables(2);
		$data = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_users) {

			$mapel = $this->Model_users->read_mapel_by_id($data_users->idusers);
			$kelas = $this->Model_users->read_kelas_by_id($data_users->idusers);
			$mapel_data = array();
			$kelas_data = array();
			
			if ($mapel!=''){
				foreach ($mapel as $row){
					$mapel_data[] = ' ('.$row->mp_kode.')'.$row->mp_nama;
				}
			}
			
			if ($kelas!=''){
				foreach ($kelas as $row){
					$kelas_data[] = ' ('.$row->k_romawi.') '.$row->k_keterangan;
				}
			}

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $data_users->first_name.' '.$data_users->last_name;
			$row[] = $data_users->u_nbm_nip;
			$row[] = $data_users->u_status_pegawai;
			$row[] = $data_users->u_tugas_tambahan;
			if ($mapel==''){
				$row[] = '<center>-</center>';
			} else {
				$row[] = $mapel_data;
			}
			if ($kelas==''){
				$row[] = '<center>-</center>';
			} else {
				$row[] = $kelas_data;
			}
			if ($reset_password=='1'){
				$row[] = $data_users->email.'<br/> <a onclick="return reset_password(\''.$data_users->email.'\')" class="btn-sm btn-primary text-light">Reset Password <i class="fas fa-redo-alt"></i></a>';
			} else {
				$row[] = $data_users->email;
			}
			$row[] = $data_users->phone;
			$row[] = '<center><a onclick="return detail(\''.encrypt_sr($data_users->idusers).'\')" class="btn btn-info btn-sm text-light"><i class="fa fa-eye"></i> Detail</a> 
                      <a onclick="return delete_data(\''.$data_users->idusers.'\',\''.$data_users->first_name.' '.$data_users->last_name.'\')" class="btn btn-danger btn-sm text-light"><i class="fa fa-window-close"></i> Hapus</a></center>';

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_users->count_all(2),
			"recordsFiltered" => $this->Model_users->count_filtered(2),
			"data" => $data
		);
		//output to json format
		echo json_encode($output);
	}
	
	public function ajax_list_guru_kelas()
	{
		//get_datatables terletak di model
		$reset_password = $this->Model_web_config->read_data_reset_password()->config_value;
		$list = $this->Model_users->get_datatables(3);
		$data = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_users) {

			$mapel = $this->Model_users->read_mapel_by_id($data_users->idusers);
			$kelas = $this->Model_users->read_kelas_by_id($data_users->idusers);
			$mapel_data = array();
			$kelas_data = array();

			if ($mapel!=''){
				foreach ($mapel as $row){
					$mapel_data[] = ' ('.$row->mp_kode.')'.$row->mp_nama;
				}
			}
			
			if ($kelas!=''){
				foreach ($kelas as $row){
					$kelas_data[] = ' ('.$row->k_romawi.') '.$row->k_keterangan;
				}
			}

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $data_users->first_name.' '.$data_users->last_name;
			$row[] = $data_users->u_nbm_nip;
			$row[] = $data_users->u_status_pegawai;
			$row[] = $data_users->u_tugas_tambahan;
			if ($mapel==''){
				$row[] = '<center>-</center>';
			} else {
				$row[] = $mapel_data;
			}
			if ($kelas==''){
				$row[] = '<center>-</center>';
			} else {
				$row[] = $kelas_data;
			}
			if ($reset_password=='1'){
				$row[] = $data_users->email.'<br/> <a onclick="return reset_password(\''.$data_users->email.'\')" class="btn-sm btn-primary text-light">Reset Password <i class="fas fa-redo-alt"></i></a>';
			} else {
				$row[] = $data_users->email;
			}
			$row[] = $data_users->phone;
			$row[] = '<center><a onclick="return detail(\''.encrypt_sr($data_users->idusers).'\')" class="btn btn-info btn-sm text-light"><i class="fa fa-eye"></i> Detail</a> 
                      <a onclick="return delete_data(\''.$data_users->idusers.'\',\''.$data_users->first_name.' '.$data_users->last_name.'\')" class="btn btn-danger btn-sm text-light"><i class="fa fa-window-close"></i> Hapus</a></center>';

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_users->count_all(3),
			"recordsFiltered" => $this->Model_users->count_filtered(3),
			"data" => $data
		);
		//output to json format
		echo json_encode($output);
	}
	
	public function detail()
	{
		$id_decrypt = base64_decode($this->uri->segment(4));
		$id = decrypt_sr($id_decrypt);
		$check = [
			'id' => $id
		];
		if (!$this->Model_users->check_data($check,'users')){
			echo "<center><h1 style='background:#2D5E89; color:white; font-family:arial;'>USER TIDAK DITEMUKAN .. ! <small><br/><a style='color:white; text-decoration:none;' href='".base_url('administrator/users/')."'>> silahkan kembali <</a></small></h1></center>";
			return false;
		}

		$users = $this->Model_users->read_data_by_id($id);
        $groups = $this->Model_users->read_users_groups_by_id($id);
        $diklat = $this->Model_users->read_diklat_by_id($id);
        $mapel = $this->Model_users->read_mapel_by_id($id);
        $kelas = $this->Model_users->read_kelas_by_id($id);

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
        $this->data['u_photo_users'] = $users->u_photo;

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
			'2' => 'Guru',
			'3' => 'Guru Kelas'
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
		$this->template->load('administrator/template','administrator/users/detail',$this->data);
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

	public function cetak_users()
	{
		// Tahun pelajaran
		$tahun_explode = explode('-',$this->Model_profile->read_data()->tp_tahun);
		$p_tahun = $tahun_explode[0];

		$this->data['cetak_users'] = '';

		$this->data['cetak_users'] = '<p align="center"><b>DATA PENDIDIK DAN TENAGA KEPENDIDIKAN
		<br/>'.strtoupper($this->data['nama']).'
		<br/>TAHUN PELAJARAN '.$p_tahun.'</b></p>';

		$this->data['cetak_users'] .= '<table class="table"><tr><td rowspan="2">No</td>';
		$this->data['cetak_users'] .= '<td rowspan="2"><center>NAMA LENGKAP DAN GELAR</center></td>';
		$this->data['cetak_users'] .= '<td rowspan="2"><center>NBM/NIP</center></td>';
		$this->data['cetak_users'] .= '<td rowspan="2"><center>NUPTK/NUKS</center></td>';
		$this->data['cetak_users'] .= '<td rowspan="2"><center>TEMPAT LAHIR</center></td>';
		$this->data['cetak_users'] .= '<td rowspan="2"><center>TANGGAL LAHIR</center></td>';
		$this->data['cetak_users'] .= '<td rowspan="2"><center>JENIS KELAMIN</center></td>';
		$this->data['cetak_users'] .= '<td rowspan="2"><center>STATUS KEPEGAWAIAN</center></td>';
		$this->data['cetak_users'] .= '<td rowspan="2"><center>TUNJANGAN APBD</center></td>';
		$this->data['cetak_users'] .= '<td rowspan="2"><center>TUGAS TAMBAHAN</center></td>';
		$this->data['cetak_users'] .= '<td rowspan="2"><center>MATA PELAJARAN DIAMPU</center></td>';
		$this->data['cetak_users'] .= '<td colspan="4"><center>IJAZAH TERAKHIR</center></td>';
		$this->data['cetak_users'] .= '<td rowspan="2"><center>NPWP</center></td>';
		$this->data['cetak_users'] .= '<td colspan="2"><center>SERTIFIKASI</center></td>';
		$this->data['cetak_users'] .= '<td colspan="3"><center>DIKLAT YANG DIIKUTI</center></td>';
		$this->data['cetak_users'] .= '<td rowspan="2"><center>PRESTASI KERJA</center></td>';
		$this->data['cetak_users'] .= '<td rowspan="2"><center>NOMINAL HONOR</center></td>';
		$this->data['cetak_users'] .= '<td rowspan="2"><center>PEKERJAAN SUAMI/ISTRI</center></td>';
		$this->data['cetak_users'] .= '<td rowspan="2"><center>ALAMAT</center></td>';
		$this->data['cetak_users'] .= '<td rowspan="2"><center>EMAIL</center></td>';
		$this->data['cetak_users'] .= '<td rowspan="2"><center>NO TELEPON</center></td></tr>';

		$this->data['cetak_users'] .= '<td><center>JENJANG</center></td> <td><center>NAMA PERGURUAN TINGGI</center></td> <td><center>JURUSAN</center></td> <td><center>TAHUN LULUS</center></td>';
		$this->data['cetak_users'] .= '<td><center>STATUS</center></td> <td><center>TAHUN LULUS</center></td>';
		$this->data['cetak_users'] .= '<td><center>NAMA DIKLAT</center></td> <td><center>PENYELENGGARA</center></td> <td><center>TAHUN</center></td>';

		$users = $this->Model_users->read_data();
		if ($users!=false){
			$nomor = 1;
			$mapel_diampu = '';
			$diklat_nama = '';
			$diklat_penyelenggara = '';
			$diklat_tahun = '';
			foreach ($users as $row){
				$diklat = $this->Model_users->read_diklat_by_id($row->idusers);
				$mapel = $this->Model_users->read_mapel_by_id($row->idusers);

				if ($diklat!=false){
					foreach ($diklat as $d_row){
						$diklat_nama .= $d_row->d_nama.'<br/>';
						$diklat_penyelenggara .= $d_row->d_penyelenggara.'<br/>';
						$diklat_tahun .= $d_row->d_tahun.'<br/>';
					}
				}

				if ($mapel!=false){
					foreach ($mapel as $m_row){
						$mapel_diampu .= '('.$m_row->mp_kode.') '.$m_row->mp_nama.'<br/>';
					}
				}

				$this->data['cetak_users'] .= '<tr><td><center>'.$nomor.'</center></td><td>'.$row->first_name.' '.$row->last_name.'</td>';
				$this->data['cetak_users'] .= '<td><center>'.$row->u_nbm_nip.'</center></td>';
				$this->data['cetak_users'] .= '<td><center>'.$row->u_nuptk_nuks.'</center></td>';
				$this->data['cetak_users'] .= '<td><center>'.$row->city_name.'</center></td>';
				$this->data['cetak_users'] .= '<td><center>'.tanggal($row->u_tanggal_lahir,'s').'</center></td>';
				$this->data['cetak_users'] .= '<td><center>'.$row->u_jenis_kelamin.'</center></td>';
				$this->data['cetak_users'] .= '<td><center>'.$row->u_status_pegawai.'</center></td>';
				$this->data['cetak_users'] .= '<td><center>'.$row->u_tunjangan_apbd.'</center></td>';
				$this->data['cetak_users'] .= '<td><center>'.$row->u_tugas_tambahan.'</center></td>';
				$this->data['cetak_users'] .= '<td>'.$mapel_diampu.'</td>';
				$this->data['cetak_users'] .= '<td><center>'.$row->u_jenjang.'</center></td>';
				$this->data['cetak_users'] .= '<td><center>'.$row->u_perguruan_tinggi.'</center></td>';
				$this->data['cetak_users'] .= '<td><center>'.$row->u_jurusan.'</center></td>';
				$this->data['cetak_users'] .= '<td><center>'.$row->u_tahun_lulus.'</center></td>';
				$this->data['cetak_users'] .= '<td><center>'.$row->u_npwp.'</center></td>';
				$this->data['cetak_users'] .= '<td><center>'.$row->u_sertifikasi.'</center></td>';
				$this->data['cetak_users'] .= '<td><center>'.$row->u_sertifikasi_tahun.'</center></td>';
				$this->data['cetak_users'] .= '<td>'.$diklat_nama.'</td>';
				$this->data['cetak_users'] .= '<td>'.$diklat_penyelenggara.'</td>';
				$this->data['cetak_users'] .= '<td>'.$diklat_tahun.'</td>';
				$this->data['cetak_users'] .= '<td><center>'.$row->u_prestasi.'</center></td>';
				$this->data['cetak_users'] .= '<td><center>'.number_format($row->u_honor).'</center></td>';
				$this->data['cetak_users'] .= '<td><center>'.$row->u_kerja_pasangan.'</center></td>';
				$this->data['cetak_users'] .= '<td><center>'.$row->u_alamat_tinggal.'</center></td>';
				$this->data['cetak_users'] .= '<td><center>'.$row->email.'</center></td>';
				$this->data['cetak_users'] .= '<td><center>'.$row->phone.'</center></td></tr>';
				$nomor ++;
				$mapel_diampu = '';
				$diklat_nama = '';
				$diklat_penyelenggara = '';
				$diklat_tahun = '';
			}
		}
		$this->load->view('administrator/users/cetak_users',$this->data);
	}

	public function create_users()
	{
		$this->load->library('upload');
		$data = $this->input->post();

		$r['status'] = "";

		$kota = $data['u_tl_idkota'];
		if ($kota==0){
			return false;
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
			$config['upload_path'] = './assets/upload/guru/';
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
			
			$email = filter($data['u_email']);
			$password = $this->randomPassword();
			$group = filter($data['users_groups']);

			$additional_data = [
				'first_name' => filter($data['u_nama_awal']),
				'last_name' => filter($data['u_nama_akhir']),
				'phone' => filter($data['u_telepon'])
			];
			
			if($this->ion_auth->register($email, $password, $email, $additional_data, $group)){
				$insert = [
					'idusers' => $this->session->userdata('insert_user_id'),
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
	
				$this->Model_users->create_data($insert,'sr_users');
				$this->send_notifikasi_password($email,$password,$group);
				$r['status'] = "ok";
				$this->log_activity($this->session->userdata('nama').' menambah data user baru');
			} else {
				$r['status'] = "gagal";
				$this->log_activity($this->session->userdata('nama').' gagal menambah data user baru');
				return false;
			}

		} else {
			$r['status'] = "gagal";
			$this->log_activity($this->session->userdata('nama').' gagal menambah data user baru');
			return false;
		}

        header('Content-Type: application/json');
        echo json_encode($r);
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
		
		$idusers = $data['idusers'];

        $insert = [
            'idusers' => $idusers,
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
			$this->log_activity($this->session->userdata('nama').' menambah data diklat user');
        } else if ($data['_mode_diklat'] == 'edit'){
            $this->Model_users->update_data($insert,$id,'diklat');
			$r['status'] = "ok";
			$this->log_activity($this->session->userdata('nama').' mengubah data diklat user');
        } else {
			$r['status'] = "gagal";
			$this->log_activity($this->session->userdata('nama').' gagal mengelola data diklat user');
        }
        header('Content-Type: application/json');
        echo json_encode($r);
	}

	public function save_mapel() {
        $data = $this->input->post();

		$r['status'] = "";
		
		$idusers = $data['idusers'];

        $insert = [
            'idusers' => $idusers,
            'idmata_pelajaran' => filter($data['mata_pelajaran'])
        ];
        $id = $data['_id_mapel'];

        if ($this->Model_users->check_data($insert,'mapel')){
            return false;
        }

        if ($data['_mode_mapel'] == 'add'){
            $this->Model_users->create_data($insert,'mapel');
			$r['status'] = "ok";
			$this->log_activity($this->session->userdata('nama').' menambah data mata pelajaran user');
        } else if ($data['_mode_mapel'] == 'edit'){
            $this->Model_users->update_data($insert,$id,'mapel');
            $r['status'] = "ok";
			$this->log_activity($this->session->userdata('nama').' mengubah data mata pelajaran user');
        } else {
            $r['status'] = "gagal";
			$this->log_activity($this->session->userdata('nama').' gagal mengelola data mata pelajaran user');
        }
        header('Content-Type: application/json');
        echo json_encode($r);
	}

	public function save_kelas() {
        $data = $this->input->post();

		$r['status'] = "";
		
		$idusers = $data['idusers'];

        $insert = [
            'idusers' => $idusers,
            'idkelas' => filter($data['kelas'])
        ];
        $id = $data['_id_kelas'];

        if ($this->Model_users->check_data($insert,'kelas')){
            return false;
        }

        if ($data['_mode_kelas'] == 'add'){
            $this->Model_users->create_data($insert,'kelas');
            $r['status'] = "ok";
			$this->log_activity($this->session->userdata('nama').' menambah data kelas user');
        } else if ($data['_mode_kelas'] == 'edit'){
            $this->Model_users->update_data($insert,$id,'kelas');
            $r['status'] = "ok";
			$this->log_activity($this->session->userdata('nama').' mengubah data kelas user');
        } else {
            $r['status'] = "gagal";
			$this->log_activity($this->session->userdata('nama').' gagal mengelola data kelas user');
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
			$config['upload_path'] = './assets/upload/guru/';
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
			$dir = "assets/upload/guru/".$foto;
			$dir_thumbnails = "assets/upload/guru/thumbnails/".$foto;
			unlink($dir);
			unlink($dir_thumbnails);
			
			if (filter($data['users_groups'])!=3){
				$insert_main = [
					'first_name' => filter($data['u_nama_awal']),
					'last_name' => filter($data['u_nama_akhir']),
					'email' => filter($data['u_email']),
					'phone' => filter($data['u_telepon']),
					'multirole' => 'N'
				];
			} else {
				$insert_main = [
					'first_name' => filter($data['u_nama_awal']),
					'last_name' => filter($data['u_nama_akhir']),
					'email' => filter($data['u_email']),
					'phone' => filter($data['u_telepon']),
					'multirole' => 'Y'
				];
			}
			
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
			$this->log_activity($this->session->userdata('nama').' mengubah data user');
		} else {
			if (filter($data['users_groups'])!=3){
				$insert_main = [
					'first_name' => filter($data['u_nama_awal']),
					'last_name' => filter($data['u_nama_akhir']),
					'email' => filter($data['u_email']),
					'phone' => filter($data['u_telepon']),
					'multirole' => 'N'
				];
			} else {
				$insert_main = [
					'first_name' => filter($data['u_nama_awal']),
					'last_name' => filter($data['u_nama_akhir']),
					'email' => filter($data['u_email']),
					'phone' => filter($data['u_telepon']),
					'multirole' => 'Y'
				];
			}
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
			$this->log_activity($this->session->userdata('nama').' mengubah data user');
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
                'source_image'  => './assets/upload/guru/'.$file_name,
                'maintain_ratio'=> FALSE,
                'width'         => 200,
                'height'        => 200,
                'new_image'     => './assets/upload/guru/thumbnails/'.$file_name
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
		$data = [
			'idusers' => $id
		];
		$check = $this->Model_users->check_data($data,'wali');
		if ($check){
			$r['status'] = "walikelas";
			$this->log_activity($this->session->userdata('nama').' gagal menghapus data user');
			header('Content-Type: application/json');
			echo json_encode($r);
			return false;
		}
		$this->load->model('Model_web_config');
		$this->load->model('Model_delete');
		$no_validate = $this->Model_web_config->read_data_no_validate_delete()->config_value;
        if ($no_validate=='0'){
			if ($this->Model_delete->check_data($data,'sr_catatan')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_diklat')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_ekstra_siswa')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_kehadiran')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_kelas')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_kelas_guru')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_kesehatan_siswa')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_mata_pelajaran_guru')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_kompetensi_dasar')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_siswa_guru')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_nilai_keterampilan')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_nilai_pengetahuan')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_nilai_pengetahuan_utsuas')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_nilai_sosial')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_nilai_spiritual')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_nk_deskripsi')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_np_deskripsi')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_nso_deskripsi')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_nsp_deskripsi')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_rencana_bs_spiritual')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_rencana_bs_sosial')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_rencana_kd_pengetahuan')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_rencana_kd_keterampilan')){
                $r['status'] = "gagal";
            } else {
				$this->Model_delete->delete_data($data,'sr_log_activity');
                $this->Model_delete->delete_data($data,'sr_users');
                $this->Model_delete->delete_data(array('user_id'=>$id),'users_groups');
                $this->Model_delete->delete_data(array('id'=>$id),'users');
                $r['status'] = "ok";
                $this->log_activity($this->session->userdata('nama').' menghapus data kelas');
            }
		} else {
			$foto = $this->Model_users->read_data_by_id($id)->u_photo;
			if (!empty($foto)){
				$dir = "assets/upload/guru/".$foto;
				$dir_thumbnails = "assets/upload/guru/thumbnails/".$foto;
				unlink($dir);
				unlink($dir_thumbnails);
			}
			$this->Model_users->delete_activity($id);
			$this->Model_users->delete_groups($id);
			$this->Model_users->delete_diklat_users($id);
			$this->Model_users->delete_mapel_users($id);
			$this->Model_users->delete_kelas_users($id);
			$this->Model_users->delete_subdata($id);
			$this->Model_users->delete_data($id);
			$r['status'] = "ok";
			$this->log_activity($this->session->userdata('nama').' menghapus data user beserta data yang terhubung dengan user tersebut');
		}
		
        header('Content-Type: application/json');
        echo json_encode($r);
	}
	
	public function delete_diklat($id) {
        $this->Model_users->delete_diklat($id);
        $r['status'] = "ok";
		$this->log_activity($this->session->userdata('nama').' menghapus data diklat user');
        header('Content-Type: application/json');
        echo json_encode($r);
	}
	
	public function delete_mapel($id) {
        $this->Model_users->delete_mapel($id);
        $r['status'] = "ok";
		$this->log_activity($this->session->userdata('nama').' menghapus data mata pelajaran user');
        header('Content-Type: application/json');
        echo json_encode($r);
	}
	
	public function delete_kelas($id) {
        $this->Model_users->delete_kelas($id);
        $r['status'] = "ok";
		$this->log_activity($this->session->userdata('nama').' menghapus data kelas user');
        header('Content-Type: application/json');
        echo json_encode($r);
	}

	public function send_notifikasi_password($email,$password,$group)
	{
		$config = [
			'protocol' => 'smtp',
			'smtp_host' => 'mail.ghalyfadhillah.com',
			'smtp_port' => 465,
			'smtp_user' => 'robots@ghalyfadhillah.com',
			'smtp_pass' => '4456Robots1123',
			'mailtype' => 'html',
			'smtp_crypto' => 'ssl',
			'charset' => 'utf-8',
			'newline' => "\r\n",
			'wordwrap' => TRUE
		];
		if ($group==2){
			$level_user = 'Guru';
		} else if ($group==3) {
			$level_user = 'Guru Kelas';
		}
		$data = array(
			'identity'=>$email,
			'password_code'=>$password,
			'level'=>$level_user
		);
		$this->load->library('email');
		$this->email->initialize($config);
		$this->load->helpers('url');
		$this->email->set_newline("\r\n");

		$this->email->from('robots@ghalyfadhillah.com','SIPS | REGISTRASI');
		$this->email->to($email);
		$this->email->subject("PASSWORD ANDA");
		$body = $this->load->view('auth/email/password.tpl.php',$data,TRUE);
		$this->email->message($body);

		if ($this->email->send()) {
			$this->session->set_flashdata('success','Email Send sucessfully');
		} 
		else {
			echo "Email not send .....";
			show_error($this->email->print_debugger());
		}
	}

	public function check_email()
    {
        $data = $this->input->post();
        if($this->Model_users->check_detail_data(filter($data['u_email']),'email')){
            $r['status'] = "gagal";
        } else {
            $r['status'] = "ok";
        }
        header('Content-Type: application/json');
        echo json_encode($r);
    }

    public function check_telepon()
    {
        $data = $this->input->post();
        if($this->Model_users->check_detail_data(filter($data['u_telepon']),'telepon')){
            $r['status'] = "gagal";
        } else {
            $r['status'] = "ok";
        }
        header('Content-Type: application/json');
        echo json_encode($r);
    }

	function randomPassword() {
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
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