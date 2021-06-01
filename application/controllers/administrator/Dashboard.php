<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Ion_auth_model');
		$this->load->model('Model_profile');
		$this->load->model('Model_alamat');
		$this->load->model('Model_tahunpelajaran');
		$this->load->model('Model_users');
		$this->load->model('Model_kelas');
		$this->load->model('Model_siswa');
		$this->load->model('Model_siswa_guru');
        $this->load->model('Model_pengetahuan');
        $this->load->model('Model_pengetahuan_utsuas');
        $this->load->model('Model_keterampilan');
        $this->load->model('Model_kompetensi');
		$this->load->model('Model_mapel');
		
        $this->load->library('Template');
        $this->load->library('Ion_auth');
        $this->load->library('Form_validation');
		
		if (!$this->ion_auth->is_admin()){redirect('Auth/login');}
		// Data Aplikasi
		$sekolah = $this->Model_profile->read_data();
		$this->data['logo_aplikasi']= $sekolah->pr_logo;
		$this->data['nama_aplikasi']= $sekolah->pr_nama_aplikasi;
		$this->data['ket_aplikasi']= $sekolah->pr_ket_aplikasi;
		// Tahun pelajaran
		$tahun_explode = explode('-',$sekolah->tp_tahun);
		$p_tahun = $tahun_explode[0];
		$p_semester = $tahun_explode[1];
		$this->data['p_tahun_pelajaran']= $p_tahun.' (Semester '.$p_semester.')';
		$this->data['tahunpelajaran_dipilih']= $this->Model_tahunpelajaran->read_data_by_id($this->session->userdata('tahun'));
        $this->data['u_photo'] = $this->Model_users->read_data_by_id($this->session->userdata('user_id'))->u_photo;
		
    }

    public function index()
    {		
		// Data sekolah
		$sekolah = $this->Model_profile->read_data();
		$this->data['idprofile']= $sekolah->idprofile;
		$this->data['kepala_sekolah']= $sekolah->pr_kepala_sekolah;
		$this->data['kepala_nbmnip']= $sekolah->pr_kepala_nbmnip;
		$this->data['nama']= $sekolah->pr_nama;
		$this->data['tahun_pelajaran']= $sekolah->tp_tahun;
		$this->data['alamat']= $sekolah->pr_alamat;
		$this->data['provinsi']= $sekolah->province;
		$this->data['kota']= $sekolah->city_name;
		$this->data['kecamatan']= $sekolah->subdistrict_name;
		$this->data['kodepos']= $sekolah->pr_kodepos;
		$this->data['telepon']= $sekolah->pr_telepon;
		$this->data['email']= $sekolah->pr_email;
		// Data Detail
		$this->data['npsn']= $sekolah->pr_npsn;
		$this->data['status']= $sekolah->pr_status;
		$this->data['bentuk_pendidikan']= $sekolah->pr_bentuk_pendidikan;
		$this->data['status_kepemilikan']= $sekolah->pr_status_kepemilikan;
		$this->data['sk_pendirian']= $sekolah->pr_sk_pendirian;
		$this->data['tanggal_sk_pendirian']= $sekolah->pr_tanggal_sk_pendirian;
		$this->data['sk_izin']= $sekolah->pr_sk_izin;
		$this->data['tanggal_sk_izin']= $sekolah->pr_tanggal_sk_izin;
		
		$this->data['edit_idprofile'] = [
			'name' => 'idprofile',
			'id' => 'idprofile',
			'type' => 'hidden',
			'required' => 'required',
			'value' => $this->data['idprofile'] 
		];
		$this->data['edit_nama'] = [
			'name' => 'p_nama',
			'id' => 'p_nama',
			'type' => 'text',
			'class' => 'form-control',
			'required' => 'required',
			'value' => $this->data['nama'] 
		];
		$this->data['edit_kepala_sekolah'] = [
			'name' => 'p_kepala_sekolah',
			'id' => 'p_kepala_sekolah',
			'type' => 'text',
			'class' => 'form-control',
			'required' => 'required',
			'value' => $this->data['kepala_sekolah'] 
		];
		$this->data['edit_kepala_nbmnip'] = [
			'name' => 'p_kepala_nbmnip',
			'id' => 'p_kepala_nbmnip',
			'type' => 'text',
			'class' => 'form-control',
			'required' => 'required',
			'value' => $this->data['kepala_nbmnip'] 
		];
		$this->data['tahun'] = $this->Model_tahunpelajaran->list_tahun();
		$this->data['tahun_select']= $sekolah->idtahun_pelajaran;
		$this->data['tahun_attribut'] = array(
			'name'			=>'p_tahun_pelajaran',
			'id'			=>'p_tahun_pelajaran',
			'class'			=>'form-control',
			'required'		=>'required'
		);
		$this->data['edit_alamat'] = [
			'name' => 'p_alamat',
			'id' => 'p_alamat',
			'type' => 'text',
			'class' => 'form-control',
			'required' => 'required',
			'value' => $this->data['alamat'] 
		];
		$this->data['edit_provinsi'] = $this->Model_alamat->read_provinsi();
		$this->data['edit_provinsi_select'] = $sekolah->province_id;
		$this->data['edit_provinsi_attribute'] = [
			'name' => 'p_provinsi',
			'id' => 'p_provinsi',
			'class' => 'form-control',
			'required' => 'required',
			'value' => $this->data['provinsi'] 
		];
		$this->data['edit_kota'] = $this->data['kota'];
		$this->data['edit_kota_select'] = $sekolah->city_id;
		$this->data['edit_kota_attribute'] = [
			'name' => 'p_kota',
			'id' => 'p_kota',
			'class' => 'form-control',
			'required' => 'required',
			'value' => $this->data['kota'] 
		];
		$this->data['edit_kecamatan'] = $this->data['kecamatan'];
		$this->data['edit_kecamatan_select'] = $sekolah->subdistrict_id;
		$this->data['edit_kecamatan_attribute'] = [
			'name' => 'p_kecamatan',
			'id' => 'p_kecamatan',
			'class' => 'form-control',
			'required' => 'required',
			'value' => $this->data['kecamatan'] 
		];
		$this->data['current_kota'] = array(
			'name'			=>'current_kota',
			'id'			=>'current_kota',
			'class'			=>'form-control',
			'required'		=>'required',
			'type'			=>'hidden',
			'value'			=>$sekolah->city_id
		);
		$this->data['current_kecamatan'] = array(
			'name'			=>'current_kecamatan',
			'id'			=>'current_kecamatan',
			'class'			=>'form-control',
			'required'		=>'required',
			'type'			=>'hidden',
			'value'			=>$sekolah->subdistrict_id
		);
		$this->data['edit_kodepos'] = [
			'name' => 'p_kodepos',
			'id' => 'p_kodepos',
			'type' => 'text',
			'class' => 'form-control',
			'required' => 'required',
			'value' => $this->data['kodepos'] 
		];
		$this->data['edit_telepon'] = [
			'name' => 'p_telepon',
			'id' => 'p_telepon',
			'type' => 'text',
			'class' => 'form-control',
			'required' => 'required',
			'value' => $this->data['telepon'] 
		];
		$this->data['edit_email'] = [
			'name' => 'p_email',
			'id' => 'p_email',
			'type' => 'text',
			'class' => 'form-control',
			'required' => 'required',
			'value' => $this->data['email'] 
		];
		// Data Detail
		$this->data['edit_npsn'] = [
			'name' => 'p_npsn',
			'id' => 'p_npsn',
			'type' => 'text',
			'class' => 'form-control',
			'required' => 'required',
			'value' => $this->data['npsn'] 
		];
		$this->data['edit_status'] = [
			'name' => 'p_status',
			'id' => 'p_status',
			'type' => 'text',
			'class' => 'form-control',
			'required' => 'required',
			'value' => $this->data['status'] 
		];
		$this->data['edit_bentuk_pendidikan'] = [
			'name' => 'p_bentuk_pendidikan',
			'id' => 'p_bentuk_pendidikan',
			'type' => 'text',
			'class' => 'form-control',
			'required' => 'required',
			'value' => $this->data['bentuk_pendidikan'] 
		];
		$this->data['edit_status_kepemilikan'] = [
			'name' => 'p_status_kepemilikan',
			'id' => 'p_status_kepemilikan',
			'type' => 'text',
			'class' => 'form-control',
			'required' => 'required',
			'value' => $this->data['status_kepemilikan'] 
		];
		$this->data['edit_sk_pendirian'] = [
			'name' => 'p_sk_pendirian',
			'id' => 'p_sk_pendirian',
			'type' => 'text',
			'class' => 'form-control',
			'required' => 'required',
			'value' => $this->data['sk_pendirian'] 
		];
		$this->data['edit_tanggal_sk_pendirian'] = [
			'name' => 'p_tanggal_sk_pendirian',
			'id' => 'p_tanggal_sk_pendirian',
			'type' => 'date',
			'class' => 'form-control',
			'required' => 'required',
			'value' => $this->data['tanggal_sk_pendirian'] 
		];
		$this->data['edit_sk_izin'] = [
			'name' => 'p_sk_izin',
			'id' => 'p_sk_izin',
			'type' => 'text',
			'class' => 'form-control',			
			'required' => 'required',
			'value' => $this->data['sk_izin'] 
		];
		$this->data['edit_tanggal_sk_izin'] = [
			'name' => 'p_tanggal_sk_izin',
			'id' => 'p_tanggal_sk_izin',
			'type' => 'date',
			'class' => 'form-control',
			'required' => 'required',
			'value' => $this->data['tanggal_sk_izin'] 
		];
		// Data Aplikasi
		$this->data['edit_nama_aplikasi'] = [
			'name' => 'p_nama_aplikasi',
			'id' => 'p_nama_aplikasi',
			'type' => 'text',
			'class' => 'form-control',
			'required' => 'required',
			'value' => $this->data['nama_aplikasi'] 
		];
		$this->data['edit_ket_aplikasi'] = [
			'name' => 'p_ket_aplikasi',
			'id' => 'p_ket_aplikasi',
			'type' => 'text',
			'class' => 'form-control',
			'required' => 'required',
			'value' => $this->data['ket_aplikasi'] 
		];
	
        $this->template->load('administrator/template','administrator/dashboard/dashboard',$this->data);
    }

	public function diagram()
	{
		$this->data['kelas'] = $this->Model_kelas->count_all_dashboard();
		$this->data['kelas_link'] = base_url('administrator/kelas/');
		$this->data['guru'] = $this->Model_users->count_all_dashboard();
		$this->data['guru_link'] = base_url('administrator/users/');
		$this->data['siswa'] = $this->Model_siswa->count_all_dashboard();
		$this->data['siswa_link'] = base_url('administrator/siswa/');
		$this->data['mapel'] = $this->Model_mapel->count_all_dashboard();
		$this->data['mapel_link'] = base_url('administrator/mata_pelajaran/');

		$siswa_chart = $this->Model_siswa->siswa_by_class();
        if (count($siswa_chart)>0){
            $siswa_kelas = "";
            $siswa_total = null;
            foreach ($siswa_chart as $row){
                $kelas = $row->k_romawi;
                $siswa_kelas .= "'$kelas'". ", ";
                $total = $row->total;
                $siswa_total .= "$total". ", ";
            }
            $this->data['siswa_kelas'] = $siswa_kelas;
            $this->data['siswa_total'] = $siswa_total;
        } else {
            $this->data['siswa_kelas'] = "";
            $this->data['siswa_total'] = null;
		}

		// GRAFIK RATA - RATA 
		$kelas_chart = $this->Model_kelas->read_data();
		if ($kelas_chart!=false){
			$kelas_chart_name = '';
			$kelas_chart_rata = null;
			foreach ($kelas_chart as $class_row)
			{
				$kls = $class_row->k_romawi;
				$kelas_chart_name .= "'$kls'". ", ";
				// Variabel
				$idkelas = $class_row->idkelas;
				$idusers = $class_row->idusers;
				
				
				// Data mapel
				$mapel = $this->Model_mapel->read_data();
				$total_mapel = $this->Model_mapel->count_all();
				$total_mapel_p_k = 2 * (Integer)$total_mapel;
				
				$siswa = $this->Model_siswa_guru->read_data_by_kelas($idkelas,$this->session->userdata('tahun'),$idusers);
				if ($siswa!=null){
					$total_seluruh_nilai = 0;
					$total_seluruh_siswa = count($siswa);
					$s = 1;
					foreach ($siswa as $row){
						$idsiswa = $row->idsiswa;
						$jumlah_np = 0;
						$jumlah_nk = 0;
						$s++;
						if ($mapel!=null){
							foreach ($mapel as $m_row){
								$idmapel = $m_row->idmata_pelajaran;
								// Pemanggilan data tiap siswa terhadap nilai pengetahuan dan keterampilan
								$pengetahuan = $this->Model_pengetahuan->read_all_data_siswa($idsiswa,$idkelas,$idmapel,$this->session->userdata('tahun'));
								$pengetahuan_utsuas = $this->Model_pengetahuan_utsuas->read_all_data_siswa($idsiswa,$idkelas,$idmapel,$this->session->userdata('tahun'));
								$keterampilan = $this->Model_keterampilan->read_all_data_siswa($idsiswa,$idkelas,$idmapel,$this->session->userdata('tahun'));
								
								$check = [
									'idtahun_pelajaran' => $this->session->userdata('tahun'),
									'idkelas' => $idkelas,
									'idmata_pelajaran' => $idmapel,
								];
								$rencana_p = $this->Model_kompetensi->check_rencana_pengetahuan($check);
								$rencana_k = $this->Model_kompetensi->check_rencana_keterampilan($check);
								if ($rencana_p!=false){
									$rp_loop = $rencana_p['rkdp_penilaian_harian'];
								} else {
									$rp_loop = 0;
								}
								if ($rencana_k!=false){
									$rk_loop = $rencana_k['rkdk_penilaian_harian'];
								} else {
									$rk_loop = 0;
								}

								$total_kd_np = 0;
								$total_kd = 0;
								$total_rata_kd = 0;
								$kdp_deskripsi = '';
								$kdp_desk = '';
				
								$total_kd_nk = 0;
								$total_kd_k = 0;
								$total_rata_kd_k = 0;
								$kdk_deskripsi = '';
								$kdk_desk = '';
				
								// Menghitung total nilai yang diinput sesuai rencana penilaian
								if ($pengetahuan!=false){
									foreach ($pengetahuan as $row)
									{   
										$kd = count($pengetahuan);
										$p_explode = explode(",",$row->np_harian);
										$p_count = (Integer)count($p_explode)-1;
										for ($i=0; $i<$rp_loop; $i++)
										{
											if (isset($p_explode[$i]) AND $p_explode[$i]!=1){
												$p_nilai = $p_explode[$i];
											} else {
												if($rp_loop>1){
													$p_nilai = 0;
													$rp_loop --;
													$i--;
												} else {
													$p_nilai = 100;
													$rp_loop = 1;
												}
											}
											$total_kd = $total_kd + (Integer)$p_nilai;
										}
										$total_rata_kd = $total_kd/$rp_loop;
										if ($rencana_p!=false){
											$rp_loop = $rencana_p['rkdp_penilaian_harian'];
										} else {
											$rp_loop = 0;
										}
										$total_kd_np = $total_kd_np + $total_rata_kd;
										$total_kd = 0;
									}
									$rata_kd_p = ceil($total_kd_np / $kd);  
								} else {
									$rata_kd_p = 0;
								}
					
								if ($pengetahuan_utsuas!=false){
									$n_uts = $pengetahuan_utsuas->np_uts;
									$n_uas = $pengetahuan_utsuas->np_uas;
								} else {
									$n_uts = 0;
									$n_uas = 0;
								}
					
								if ($keterampilan!=false){
									foreach ($keterampilan as $row)
									{   
										$kd_k = count($keterampilan);
										$k_explode = explode(",",$row->nk_harian);
										$k_count = (Integer)count($k_explode)-1;
										for ($i=0; $i<$rk_loop; $i++)
										{
											if (isset($k_explode[$i]) AND $k_explode[$i]!=1){
												$k_nilai = $k_explode[$i];
											} else {
												if($rk_loop>1){
													$k_nilai = 0;
													$rk_loop --;
													$i--;
												} else {
													$k_nilai = 100;
													$rk_loop = 1;
												}
											}
											$total_kd_k = $total_kd_k + (Integer)$k_nilai;
										}
										$total_rata_kd_k = $total_kd_k/$rk_loop;
										if ($rencana_k!=false){
											$rk_loop = $rencana_k['rkdk_penilaian_harian'];
										} else {
											$rk_loop = 0;
										}
										$total_kd_nk = $total_kd_nk + $total_rata_kd_k;
										$total_kd_k = 0;
									}
									$rata_kd_k = ceil($total_kd_nk / $kd_k);  
								} else {
									$rata_kd_k = 0;
								}
					
								// Menghitung nilai akhir
								$na_pengetahuan = round((($rata_kd_p * 2) + $n_uts + $n_uas) / 4);
								$na_keterampilan = round($rata_kd_k);

								$jumlah_np = $jumlah_np + $na_pengetahuan;
								$jumlah_nk = $jumlah_nk + $na_keterampilan;
							}
							$total_seluruh_nilai += round((($jumlah_np+$jumlah_nk)/$total_mapel_p_k));
						}
					}
					$total_rata_kelas = round(($total_seluruh_nilai/$total_seluruh_siswa));
					$kelas_chart_rata .= "$total_rata_kelas". ", ";
				} else {
					$total_rata_kelas = 0;
					$kelas_chart_rata .= "$total_rata_kelas". ", ";
				}
			}
			$this->data['kelas_chart_name'] = $kelas_chart_name;
            $this->data['kelas_chart_rata'] = $kelas_chart_rata;
			
		}			
		// GRAFIK RATA - RATA
		$this->load->view('administrator/dashboard/diagram',$this->data);
	}

	public function corona()
	{
		// COVID 19
		$indonesia= file_get_contents('https://api.kawalcorona.com/indonesia');
		$provinsi= file_get_contents('https://api.kawalcorona.com/indonesia/provinsi');
		$total_provinsi = json_decode($provinsi);

		$this->data['total_indonesia']= json_decode($indonesia);
		if (count($total_provinsi)>0){
            $covid_provinsi = "";
            $covid_positif = null;
            $covid_sembuh = null;
            $covid_meninggal = null;
            foreach ($total_provinsi as $row){
                $nama_provinsi = $row->attributes->Provinsi;
                $covid_provinsi .= "'$nama_provinsi'". ", ";
                $total_positif = $row->attributes->Kasus_Posi;
				$covid_positif.= "$total_positif". ", ";
				$total_sembuh = $row->attributes->Kasus_Semb;
				$covid_sembuh.= "$total_sembuh". ", ";
				$total_meninggal = $row->attributes->Kasus_Meni;
                $covid_meninggal.= "$total_meninggal". ", ";
            }
            $this->data['covid_provinsi'] = $covid_provinsi;
            $this->data['covid_positif'] = $covid_positif;
            $this->data['covid_sembuh'] = $covid_sembuh;
            $this->data['covid_meninggal'] = $covid_meninggal;
        } else {
            $this->data['covid_provinsi'] = "";
            $this->data['covid_positif'] = null;
            $this->data['covid_sembuh'] = null;
            $this->data['covid_meninggal'] = null;
		}

		$this->load->view('administrator/dashboard/corona',$this->data);
	}
	
	public function save_data()
	{
		$this->load->library('upload');
		$data = $this->input->post();
		
		$kota = $data['p_kota'];
		$kecamatan = $data['p_kecamatan'];
		if ($kota==0){
			$kota = $data['current_kota'];
		} else {
			$kota = $kota;
		}
		if ($kecamatan==0){
			$kecamatan = $data['current_kecamatan'];
		} else {
			$kecamatan = $kecamatan;
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
			$config['upload_path'] = './assets/upload/profile/';
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
				$new_logo = $data_upload['file_name'];
			}
			$logo = $this->Model_profile->read_data()->pr_logo;
			$dir = "assets/upload/profile/".$logo;
			$dir_thumbnails = "assets/upload/profile/thumbnails/".$logo;
			$dir_favicon = "assets/upload/profile/favicon/".$logo;
			unlink($dir);
			unlink($dir_thumbnails);
			unlink($dir_favicon);
			
			$create = [
				'idprovinsi' => filter($data['p_provinsi']),
				'idkota' => filter($kota),
				'idkecamatan' => filter($kecamatan),
				'pr_nama' => filter($data['p_nama']),
				'pr_kepala_sekolah' => filter($data['p_kepala_sekolah']),
				'pr_kepala_nbmnip' => filter($data['p_kepala_nbmnip']),
				'idtahun_pelajaran' => filter($data['p_tahun_pelajaran']),
				'pr_alamat' => filter($data['p_alamat']),
				'pr_kodepos' => filter($data['p_kodepos']),
				'pr_telepon' => filter($data['p_telepon']),
				'pr_email' => filter($data['p_email']),
				'pr_npsn' => filter($data['p_npsn']),
				'pr_status' => filter($data['p_status']),
				'pr_bentuk_pendidikan' => filter($data['p_bentuk_pendidikan']),
				'pr_status_kepemilikan' => filter($data['p_status_kepemilikan']),
				'pr_sk_pendirian' => filter($data['p_sk_pendirian']),
				'pr_tanggal_sk_pendirian' => filter($data['p_tanggal_sk_pendirian']),
				'pr_sk_izin' => filter($data['p_sk_izin']),
				'pr_tanggal_sk_izin' => filter($data['p_tanggal_sk_izin']),
				'pr_nama_aplikasi' => filter($data['p_nama_aplikasi']),
				'pr_ket_aplikasi' => filter($data['p_ket_aplikasi']),
				'pr_logo' => $new_logo
			];
			if ($this->Model_profile->update_data($create,filter($data['idprofile']))){
				$r['status'] = "success";
				$r['data'] = "Data berhasil diubah !";
				$this->log_activity($this->session->userdata('nama').' mengubah data profile sekolah');
			} else {
				$r['status'] = "error";
				$r['data'] = "Data gagal diubah !";
				$this->log_activity($this->session->userdata('nama').' gagal mengubah data profile sekolah');
			}
		} else {
			$create = [
				'idprovinsi' => filter($data['p_provinsi']),
				'idkota' => filter($kota),
				'idkecamatan' => filter($kecamatan),
				'pr_nama' => filter($data['p_nama']),
				'pr_kepala_sekolah' => filter($data['p_kepala_sekolah']),
				'pr_kepala_nbmnip' => filter($data['p_kepala_nbmnip']),
				'idtahun_pelajaran' => filter($data['p_tahun_pelajaran']),
				'pr_alamat' => filter($data['p_alamat']),
				'pr_kodepos' => filter($data['p_kodepos']),
				'pr_telepon' => filter($data['p_telepon']),
				'pr_email' => filter($data['p_email']),
				'pr_npsn' => filter($data['p_npsn']),
				'pr_status' => filter($data['p_status']),
				'pr_bentuk_pendidikan' => filter($data['p_bentuk_pendidikan']),
				'pr_status_kepemilikan' => filter($data['p_status_kepemilikan']),
				'pr_sk_pendirian' => filter($data['p_sk_pendirian']),
				'pr_tanggal_sk_pendirian' => filter($data['p_tanggal_sk_pendirian']),
				'pr_sk_izin' => filter($data['p_sk_izin']),
				'pr_tanggal_sk_izin' => filter($data['p_tanggal_sk_izin']),
				'pr_nama_aplikasi' => filter($data['p_nama_aplikasi']),
				'pr_ket_aplikasi' => filter($data['p_ket_aplikasi'])
			];
			if ($this->Model_profile->update_data($create,filter($data['idprofile']))){
				$r['status'] = "success";
				$r['data'] = "Data berhasil diubah !";
				$this->log_activity($this->session->userdata('nama').' mengubah data profile sekolah');
			} else {
				$r['status'] = "error";
				$r['data'] = "Data gagal diubah !";
				$this->log_activity($this->session->userdata('nama').' gagal mengubah data profile sekolah');
			}
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
                'source_image'  => './assets/upload/profile/'.$file_name,
                'maintain_ratio'=> FALSE,
                'width'         => 200,
                'height'        => 200,
                'new_image'     => './assets/upload/profile/thumbnails/'.$file_name
                ),
			// Thumbnails Image
            array(
                'image_library' => 'GD2',
                'source_image'  => './assets/upload/profile/'.$file_name,
                'maintain_ratio'=> FALSE,
                'width'         => 16,
                'height'        => 16,
                'new_image'     => './assets/upload/profile/favicon/'.$file_name
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
	
	public function read_kota()
	{
		$this->data['edit_kota'] = $this->Model_alamat->read_kota($this->uri->segment(4));
		$this->data['edit_kota_attribut'] = array(
			'id'			=>'p_kota',
			'name'			=>'p_kota',
			'class'			=>'form-control',
			'required'		=>'required',
			'style'			=>'width:100%;'
		);
		$this->load->view('administrator/dashboard/_kota',$this->data);
	}
	
	public function read_kecamatan()
	{
		$this->data['edit_kecamatan'] = $this->Model_alamat->read_kecamatan($this->uri->segment(4));
		$this->data['edit_kecamatan_attribut'] = array(
			'id'			=>'p_kecamatan',
			'name'			=>'p_kecamatan',
			'class'			=>'form-control',
			'required'		=>'required',
			'style'			=>'width:100%;'
		);
		$this->load->view('administrator/dashboard/_kecamatan',$this->data);
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