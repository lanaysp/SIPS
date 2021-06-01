<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Ion_auth_model');
		$this->load->model('Model_profile');
        $this->load->model('Model_siswa');
        $this->load->model('Model_tahunpelajaran');
        $this->load->model('Model_users');
        $this->load->model('Model_alamat');
        $this->load->model('Model_kelas');
        $this->load->model('Model_mapel');
        $this->load->model('Model_kkm');
        $this->load->model('Model_kompetensi');
        $this->load->model('Model_pengetahuan');
        $this->load->model('Model_pengetahuan_utsuas');
        $this->load->model('Model_spiritual');
        $this->load->model('Model_sosial');
        $this->load->model('Model_butirsikap');
        $this->load->model('Model_keterampilan');
        $this->load->model('Model_web_config');
        $this->load->model('Model_activity');
		
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
        $this->template->load('administrator/template','administrator/siswa/siswa',$this->data);
    }

    public function ajax_list()
	{
        //get_datatables terletak di model
        $high_level = $this->Model_kelas->read_high_level_class()->k_tingkat;
        $naik_kelas = $this->Model_web_config->read_data_naik_kelas()->config_value;
		$idkelas = $this->uri->segment(4);
		if($idkelas==''){
			$list = $this->Model_siswa->get_datatables();
		} else {
			$list = $this->Model_siswa->get_datatables_by_id($idkelas);
		}
		$data = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_siswa) {
			$no++;
			$row = array();
            $row[] = $no;
            if ($naik_kelas=='1'){
                if ($data_siswa->k_tingkat==$high_level){
                    $row[] = $data_siswa->s_nama. '
                    <br/><a onclick="return naik('.$data_siswa->idsiswa.')" class="btn btn-info btn-sm text-light"><i class="fas fa-arrow-up"></i> Lulus</a>
                    <a onclick="return turun('.$data_siswa->idsiswa.')" class="btn btn-warning btn-sm text-light"><i class="fas fa-arrow-down"></i> Turun</a>
                    <a onclick="return diagramNilai(\''.$data_siswa->idsiswa.'\',\''.$data_siswa->s_nama.'\')" class="btn btn-primary btn-sm text-light">Diagram</a>
                    ';
                } else if ($data_siswa->k_tingkat>$high_level) {
                    $row[] = $data_siswa->s_nama. '
                    <br/><a onclick="return turun('.$data_siswa->idsiswa.')" class="btn btn-warning btn-sm text-light"><i class="fas fa-arrow-down"></i> Turun</a>
                    ';
                } else {
                    $row[] = $data_siswa->s_nama. '
                    <br/><a onclick="return naik('.$data_siswa->idsiswa.')" class="btn btn-success btn-sm text-light"><i class="fas fa-arrow-up"></i> Naik</a>
                    <a onclick="return turun('.$data_siswa->idsiswa.')" class="btn btn-warning btn-sm text-light"><i class="fas fa-arrow-down"></i> Turun</a>
                    <a onclick="return diagramNilai(\''.$data_siswa->idsiswa.'\',\''.$data_siswa->s_nama.'\')" class="btn btn-primary btn-sm text-light">Diagram</a>
                    ';
                }
            } else {
                $row[] = $data_siswa->s_nama;
            }
            
			$row[] = $data_siswa->s_nisn;
			$row[] = $data_siswa->s_nik;
			$row[] = $data_siswa->s_jenis_kelamin;
			$row[] = $data_siswa->city_name;
			$row[] = date('d-M-Y',strtotime($data_siswa->s_tanggal_lahir));
			$row[] = $data_siswa->s_email.'<br/>'.$data_siswa->s_telepon;
			$row[] = $data_siswa->s_wali;
			$row[] = $data_siswa->s_dusun.'/'.$data_siswa->s_desa.'/'.$data_siswa->s_kecamatan;
			$row[] = $data_siswa->s_domisili;
			$row[] = $data_siswa->s_abk;
			$row[] = $data_siswa->s_bsm_pip;
            $row[] = $data_siswa->s_keluarga_miskin;
            $row[] = '
            <a onclick="return edit('.$data_siswa->idsiswa.')" class="btn btn-info btn-sm text-light"><i class="fa fa-edit"></i> Edit</a> 
            <a onclick="return delete_data(\''.$data_siswa->idsiswa.'\',\''.$data_siswa->s_nama.'\')" class="btn btn-danger btn-sm text-light"><i class="fa fa-window-close"></i> Hapus</a>
            ';
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_siswa->count_all($idkelas),
			"recordsFiltered" => $this->Model_siswa->count_filtered($idkelas),
			"data" => $data
		);
		//output to json format
		echo json_encode($output);
    }

    public function diagram()
    {
        //get_datatables terletak di model
		$idkelas = $this->input->post('idkelas');
        $idsiswa = $this->input->post('idsiswa');
        $s_nama = $this->input->post('s_nama');
        $kelas = $this->Model_users->read_users_by_kelas($idkelas);
        if ($kelas!=false){
            $idusers = $kelas->idusers;
        } else {
            $idusers = 0;
        }
        
        $mata_pelajaran = '';
        $mapel_kkm = '';
        $na_pengetahuan_text = '';
        $na_keterampilan_text = '';
        $mapel = $this->Model_mapel->read_data();
        if ($mapel!=false){
            $total_mapel = count($mapel);
            foreach ($mapel as $m_row){
                $c_kkm = $this->Model_kkm->read_data_by_mapel($m_row->idmata_pelajaran);
                if ($c_kkm!=false){
                    $m_kkm = $c_kkm->k_kkm;
                } else {
                    $m_kkm = '(..)';
                }
                if (strlen($m_row->mp_nama)>25){
                    $mp_nama = '('.$m_row->mp_kode.')'.' (Grup '.$m_row->mp_kelompok.')';
                } else {
                    $mp_nama = $m_row->mp_nama.' (Grup '.$m_row->mp_kelompok.')';
                }
                $mata_pelajaran .= "'$mp_nama'". ", ";
                $mapel_kkm .= "'$m_kkm'". ", ";
                $idmapel = $m_row->idmata_pelajaran;
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
                // Pemanggilan data tiap siswa terhadap nilai pengetahuan dan keterampilan
                $pengetahuan = $this->Model_pengetahuan->read_all_data_siswa($idsiswa,$idkelas,$idmapel,$this->session->userdata('tahun'));
                $pengetahuan_utsuas = $this->Model_pengetahuan_utsuas->read_all_data_siswa($idsiswa,$idkelas,$idmapel,$this->session->userdata('tahun'));
                $keterampilan = $this->Model_keterampilan->read_all_data_siswa($idsiswa,$idkelas,$idmapel,$this->session->userdata('tahun'));
    
                $total_kd_np = 0;
                $total_kd = 0;
                $total_rata_kd = 0;
    
                $total_kd_nk = 0;
                $total_kd_k = 0;
                $total_rata_kd_k = 0;
    
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
                $na_pengetahuan_text .= "'$na_pengetahuan'". ", ";
                $na_keterampilan_text .= "'$na_keterampilan'". ", ";
                
            }
            $this->data['mapel'] = $mata_pelajaran;
            $this->data['mapel_kkm'] = $mapel_kkm;
            $this->data['pengetahuan_nilai'] = $na_pengetahuan_text;
            $this->data['keterampilan_nilai'] = $na_keterampilan_text;
            $this->data['s_nama'] = $s_nama;
        } else {
            $this->data['mapel'] = null;
            $this->data['mapel_kkm'] = null;
            $this->data['pengetahuan_nilai'] = null;
            $this->data['keterampilan_nilai'] = null;
            $this->data['s_nama'] = null;
        }

        // SIKAP 
        $all_id_spiritual = '';
        $all_id_sosial = '';
        $all_id_spiritual_meningkat = '';
        $all_id_sosial_meningkat = '';
        $nilai_spiritual = array();
        $sp_butirsikap = array();
        $nilai_sp_generate = array();
        $sp_generate = null;
        $nilai_sp_meningkat_generate = array();
        $sp_meningkat_generate = null;
        $nilai_so_generate = array();
        $so_generate = null;
        $nilai_so_meningkat_generate = array();
        $so_meningkat_generate = null;
        $nilai_spiritual_meningkat = array();
        $sp_meningkat_butirsikap = array();
        $nilai_sosial = array();
        $so_butirsikap = array();
        $nilai_sosial_meningkat = array();
        $so_meningkat_butirsikap = array();
        $sp_rencana = '';
        $sp_jml_rencana = null;
        $total_users_rencana_spiritual = 0;
        $so_jml_rencana = null;
        $total_users_rencana_sosial = 0;
        
        $check_rencana_spiritual = [
            'idtahun_pelajaran' => filter($this->session->userdata('tahun')),
            'idkelas' => $idkelas
        ];
        $spiritual_rencana = $this->Model_butirsikap->check_rencana_spiritual_result($check_rencana_spiritual);
        if (!empty($spiritual_rencana)){
            foreach($spiritual_rencana as $sp_r){
                $total_users_rencana_spiritual = count($spiritual_rencana);
                $sp_jml_rencana += $sp_r->rbs_sp;
            }
            $total_rencana_spiritual = $total_users_rencana_spiritual + $sp_jml_rencana;
            $this->data['total_rencana_spiritual'] = $total_rencana_spiritual;
        } else {
            $this->data['total_rencana_spiritual'] = null;
        }
        
        $check_rencana_sosial = [
            'idtahun_pelajaran' => filter($this->session->userdata('tahun')),
            'idkelas' => $idkelas
        ];
        $sosial_rencana = $this->Model_butirsikap->check_rencana_sosial_result($check_rencana_sosial);
        if (!empty($sosial_rencana)){
            foreach($sosial_rencana as $so_r){
                $total_users_rencana_sosial = count($sosial_rencana);
                $so_jml_rencana += $so_r->rbs_so;
            }
            $total_rencana_sosial = $total_users_rencana_sosial + $so_jml_rencana;
            $this->data['total_rencana_sosial'] = $total_rencana_sosial;
        } else {
            $this->data['total_rencana_sosial'] = null;
        }
        
        $spiritual = $this->Model_spiritual->read_all_data($idsiswa,$this->session->userdata('tahun'));
        $sosial = $this->Model_sosial->read_all_data($idsiswa,$this->session->userdata('tahun'));
        // Data Deskripsi Spiritual Sosial
        if ($spiritual!=false){
            foreach ($spiritual as $row){
                $all_id_spiritual .= $row->nilai_spiritual;
                $all_id_spiritual_meningkat .= $row->nilai_spiritual_meningkat.',';
            }
            $sp_explode = explode(',',$all_id_spiritual);
            sort($sp_explode);
            $sp_count = (Integer)count($sp_explode)-1;
            for ($i=0;$i<=$sp_count;$i++){
                $check_sp_butirsikap = $this->Model_butirsikap->read_data_by_id($sp_explode[$i]);
                if ($check_sp_butirsikap!=null){
                    $sp_butirsikap[] = $check_sp_butirsikap['bs_keterangan'];
                } else {
                    continue;
                }
            }
            $sp_array_count = array_count_values($sp_butirsikap);
            foreach($sp_array_count as $key => $val) {
                $sp_generate += $val;
            }
            $nilai_sp_generate = $sp_generate;

            $sp_meningkat_explode = explode(',',$all_id_spiritual_meningkat);
            sort($sp_meningkat_explode);
            $sp_meningkat_count = (Integer)count($sp_meningkat_explode)-1;
            for ($i=0;$i<=$sp_meningkat_count;$i++){
                $check_sp_butirsikap_meningkat = $this->Model_butirsikap->read_data_by_id($sp_meningkat_explode[$i]);
                if ($check_sp_butirsikap_meningkat!=null){
                    $sp_meningkat_butirsikap[] = $check_sp_butirsikap_meningkat['bs_keterangan'];
                } else {
                    continue;
                }
            }

            $sp_meningkat_array_count = array_count_values($sp_meningkat_butirsikap);
            foreach($sp_meningkat_array_count as $key => $val) {
                $sp_meningkat_generate += $val;
            }
            $nilai_sp_meningkat_generate = $sp_meningkat_generate;
            $this->data['total_poin_spiritual'] = $nilai_sp_generate + $nilai_sp_meningkat_generate;
            $nilai_akhir_spiritual = ($nilai_sp_generate + $nilai_sp_meningkat_generate)/$total_rencana_spiritual*4;
            $this->data['nilai_akhir_spiritual'] = $nilai_akhir_spiritual;
            if ($nilai_akhir_spiritual > 3.33 AND $nilai_akhir_spiritual <= 4.00){
                $predikat_spiritual = 'A (Sangat Baik)';
            } else if ($nilai_akhir_spiritual > 2.33 AND $nilai_akhir_spiritual <= 3.33){
                $predikat_spiritual = 'B (Baik)';
            } else if ($nilai_akhir_spiritual > 1.33 AND $nilai_akhir_spiritual <= 2.33){
                $predikat_spiritual = 'C (Cukup)';
            } else {
                $predikat_spiritual = 'D (Kurang)';
            }
            $this->data['nilai_predikat_spiritual'] = $predikat_spiritual;
        } else {
            $this->data['total_poin_spiritual'] = null;
            $this->data['nilai_akhir_spiritual'] = null;
            $this->data['nilai_predikat_spiritual'] = null;
        }

        if ($sosial!=false){
            foreach ($sosial as $row){
                $all_id_sosial .= $row->nilai_sosial;
                $all_id_sosial_meningkat .= $row->nilai_sosial_meningkat.',';
            }
            $so_explode = explode(',',$all_id_sosial);
            sort($so_explode);
            $so_count = (Integer)count($so_explode)-1;
            for ($i=0;$i<=$so_count;$i++){
                $check_so_butirsikap = $this->Model_butirsikap->read_data_by_id($so_explode[$i]);
                if ($check_so_butirsikap!=null){
                    $so_butirsikap[] = $check_so_butirsikap['bs_keterangan'];
                } else {
                    continue;
                }
            }
            $so_array_count = array_count_values($so_butirsikap);
            foreach($so_array_count as $key => $val) {
                $so_generate += $val;
            }
            $nilai_so_generate = $so_generate;
            $so_meningkat_explode = explode(',',$all_id_sosial_meningkat);
            sort($so_meningkat_explode);
            $so_meningkat_count = (Integer)count($so_meningkat_explode)-1;
            for ($i=0;$i<=$so_meningkat_count;$i++){
                $check_so_butirsikap_meningkat = $this->Model_butirsikap->read_data_by_id($so_meningkat_explode[$i]);
                if ($check_so_butirsikap_meningkat!=null){
                    $so_meningkat_butirsikap[] = $check_so_butirsikap_meningkat['bs_keterangan'];
                } else {
                    continue;
                }
            }
            $so_meningkat_array_count = array_count_values($so_meningkat_butirsikap);
            foreach($so_meningkat_array_count as $key => $val) {
                $so_meningkat_generate += $val;
            }
            $nilai_so_meningkat_generate = $so_meningkat_generate;
            $this->data['total_poin_sosial'] = $nilai_so_generate + $nilai_so_meningkat_generate;
            $nilai_akhir_sosial = ($nilai_so_generate + $nilai_so_meningkat_generate)/$total_rencana_sosial*4;
            $this->data['nilai_akhir_sosial'] = $nilai_akhir_sosial;
            if ($nilai_akhir_sosial > 3.33 AND $nilai_akhir_sosial <= 4.00){
                $predikat_sosial = 'A (Sangat Baik)';
            } else if ($nilai_akhir_sosial > 2.33 AND $nilai_akhir_sosial <= 3.33){
                $predikat_sosial = 'B (Baik)';
            } else if ($nilai_akhir_sosial > 1.33 AND $nilai_akhir_sosial <= 2.33){
                $predikat_sosial = 'C (Cukup)';
            } else {
                $predikat_sosial = 'D (Kurang)';
            }
            $this->data['nilai_predikat_sosial'] = $predikat_sosial;
        } else {
            $this->data['total_poin_sosial'] = null;
            $this->data['nilai_akhir_sosial'] = null;
            $this->data['nilai_predikat_sosial'] = null;
        }
        
        $this->load->view('administrator/siswa/diagram',$this->data);
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
		$this->load->view('administrator/siswa/_kota',$this->data);
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
		$this->load->view('administrator/siswa/_kota',$this->data);
    }
    
    public function naik_turun_kelas()
    {
        $data = $this->input->post();
        $tipe = $data['tipe'];
        $idsiswa = $data['idsiswa'];
        $lulus = $this->Model_kelas->read_lulus_class()->idkelas;
        $high_level = $this->Model_kelas->read_high_level_class()->idkelas;

        $check = $this->Model_siswa->read_data_by_id($idsiswa);
        if (!empty($check)){
            if ($tipe=='naik'){
                $kelas = $this->Model_kelas->read_data_by_tingkat($check['k_tingkat']+1);
                if ($kelas!=false){
                    $idkelas = $kelas->idkelas;
                } else if ($check['k_romawi']=='LULUS'){
                    $idkelas = $high_level;
                } else {
                    $idkelas = $lulus;
                }
                
                $update = [
                    'idkelas' => $idkelas
                ];
                $this->Model_siswa->update_data($update,$idsiswa);
                $r['status'] = 'ok';
            } else {
                if ($check['k_tingkat']==1){
                    $r['status'] = 'gagal';
                } else {
                    $kelas = $this->Model_kelas->read_data_by_tingkat($check['k_tingkat']-1);
                    if ($kelas!=false){
                        $idkelas = $kelas->idkelas;
                    } else if ($check['k_romawi']=='LULUS'){
                        $idkelas = $high_level;
                    } else {
                        $idkelas = $lulus;
                    }
                    
                    $update = [
                        'idkelas' => $idkelas
                    ];
                    $this->Model_siswa->update_data($update,$idsiswa);
                    $r['status'] = 'ok';
                }
            }
        } else {
            $r['status'] = 'gagal';
        }
        header('Content-Type: application/json');
        echo json_encode($r);
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
            $data['data']['s_email'] = "";
            $data['data']['s_telepon'] = "";
            $data['data']['s_kelas'] = "";
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
            's_email' => filter($data['s_email']),
            's_telepon' => filter($data['s_telepon']),
            'idkelas' => filter($data['s_kelas']),
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
            $this->log_activity($this->session->userdata('nama').' menambah data siswa '.filter($data['s_nama']));
        } else if ($data['_mode'] == 'edit'){
            $this->Model_siswa->update_data($insert,$id);
            $r['status'] = "ok";
            $this->log_activity($this->session->userdata('nama').' mengubah data siswa '.filter($data['s_nama']));
        } else {
            $r['status'] = "gagal";
            $this->log_activity($this->session->userdata('nama').' gagal mengelola data siswa '.filter($data['s_nama']));
        }
        header('Content-Type: application/json');
        echo json_encode($r);
    }

    public function check_email()
    {
        $data = $this->input->post();
        if($this->Model_siswa->check_detail_data(filter($data['s_email']),'email')){
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
        if($this->Model_siswa->check_detail_data(filter($data['s_telepon']),'telepon')){
            $r['status'] = "gagal";
        } else {
            $r['status'] = "ok";
        }
        header('Content-Type: application/json');
        echo json_encode($r);
    }

    public function delete($id) {
        $this->load->model('Model_delete');
        $this->load->model('Model_web_config');
        $data = [
            'idsiswa' => $id
        ];
        $no_validate = $this->Model_web_config->read_data_no_validate_delete()->config_value;
        if ($no_validate=='0'){
            if ($this->Model_delete->check_data($data,'sr_prestasi')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_catatan')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_ekstra_siswa')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_kehadiran')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_kesehatan_siswa')){
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
            } else {
                $this->Model_delete->delete_data($data,'sr_siswa');
                $r['status'] = "ok";
                $this->log_activity($this->session->userdata('nama').' menghapus data siswa');
            }
        } else {
            $this->Model_delete->delete_data($data,'sr_catatan');
            $this->Model_delete->delete_data($data,'sr_ekstra_siswa');
            $this->Model_delete->delete_data($data,'sr_kehadiran');
            $this->Model_delete->delete_data($data,'sr_kesehatan_siswa');
            $this->Model_delete->delete_data($data,'sr_prestasi');
            $this->Model_delete->delete_data($data,'sr_np_deskripsi');
            $this->Model_delete->delete_data($data,'sr_nk_deskripsi');
            $this->Model_delete->delete_data($data,'sr_nsp_deskripsi');
            $this->Model_delete->delete_data($data,'sr_nso_deskripsi');
            $this->Model_delete->delete_data($data,'sr_nilai_spiritual');
            $this->Model_delete->delete_data($data,'sr_nilai_sosial');
            $this->Model_delete->delete_data($data,'sr_nilai_pengetahuan');
            $this->Model_delete->delete_data($data,'sr_nilai_pengetahuan_utsuas');
            $this->Model_delete->delete_data($data,'sr_nilai_keterampilan');
            $this->Model_delete->delete_data($data,'sr_siswa');
            $r['status'] = "ok";
            $this->log_activity($this->session->userdata('nama').' menghapus data siswa beserta seluruh data yang terhubung');
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