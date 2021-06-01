<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Nilai_rapor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Ion_auth_model');
		$this->load->model('Model_profile');
		$this->load->model('Model_tahunpelajaran');
        $this->load->model('Model_users');
        
        $this->load->model('Model_mapel');
        $this->load->model('Model_kelas');
        $this->load->model('Model_siswa');
        $this->load->model('Model_siswa_guru');
        $this->load->model('Model_keterampilan');
        $this->load->model('Model_pengetahuan');
        $this->load->model('Model_pengetahuan_utsuas');
        $this->load->model('Model_kompetensi');
        $this->load->model('Model_kkm');
        $this->load->model('Model_interval');
		
        $this->load->library('Template');
        $this->load->library('Ion_auth');
		
		if (!$this->ion_auth->is_admin()){redirect('Auth/login');}
		// Data Aplikasi
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
        $this->data['list_kelas'] = $this->Model_kelas->list_kelas();
		$this->data['list_kelas_attribute'] = [
			'name' => 'idkelas',
			'id' => 'idkelas',
			'class' => 'form-control col-lg-10',
			'required' => 'required'
        ];
        $this->template->load('administrator/template','administrator/nilai_rapor/nilai_rapor',$this->data);
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
        
        $list = $this->Model_siswa_guru->get_datatables_wali_p($idusers);

        $data = array();
        $input_nilai = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_nilai_akhir) {
            $mata_pelajaran = '';
            $mapel_kkm = '';
            $na_pengetahuan_text = '';
            $na_keterampilan_text = '';
            $p_predikat_text = '';
            $p_deskripsi_text = '';
            $k_predikat_text = '';
            $k_deskripsi_text = '';

            $mapel = $this->Model_mapel->read_data();

            if ($mapel!=false){
                foreach ($mapel as $m_row){
                    $c_kkm = $this->Model_kkm->read_data_by_mapel($m_row->idmata_pelajaran);
                    if ($c_kkm!=false){
                        $m_kkm = $c_kkm->k_kkm;
                    } else {
                        $m_kkm = '(..)';
                    }
                    if (strlen($m_row->mp_nama)>25){
                        $mp_nama = '('.$m_row->mp_kode.')';
                    } else {
                        $mp_nama = $m_row->mp_nama;
                    }
                    $mata_pelajaran .= '<i class="fas fa-arrow-alt-circle-right"></i> '.$mp_nama.' <br/><br/>';
                    $mapel_kkm .= '<i class="fas fa-arrow-alt-circle-right"></i> '.$m_kkm.' <br/><br/>';

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
                    $pengetahuan = $this->Model_pengetahuan->read_all_data_siswa($data_nilai_akhir->idsiswa,$idkelas,$idmapel,$this->session->userdata('tahun'));
                    $pengetahuan_utsuas = $this->Model_pengetahuan_utsuas->read_all_data_siswa($data_nilai_akhir->idsiswa,$idkelas,$idmapel,$this->session->userdata('tahun'));
                    $keterampilan = $this->Model_keterampilan->read_all_data_siswa($data_nilai_akhir->idsiswa,$idkelas,$idmapel,$this->session->userdata('tahun'));
        
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

                    $na_pengetahuan_text .= '<i class="fas fa-arrow-alt-circle-right"></i> '.$na_pengetahuan.' <br/><br/>';
                    $na_keterampilan_text .= '<i class="fas fa-arrow-alt-circle-right"></i> '.$na_keterampilan.' <br/><br/>';
                    
                    $kkm = $this->Model_kkm->read_data_by_mapel($idmapel);
                    // Mengambil data KKM
                    if ($kkm!=false)
                    {
                        $interval = $this->Model_interval->read_data_by_kkm($kkm->idkkm);
                        if ($interval!=false) {
                            // Membandingkan nilai akhir dengan Interval KKM
                            if ($na_pengetahuan >= $interval->amin && $na_pengetahuan <= $interval->amax)
                            {
                                $p_predikat = "A";
                                $p_deskripsi = "<a onClick='return show_chart(\"".$m_row->idmata_pelajaran."\",\"".$data_nilai_akhir->idsiswa."\",\"".$data_nilai_akhir->s_nama."\",\"".$data_nilai_akhir->idkelas."\");' class='btn-sm btn-info text-light'>Tuntas</a>";
                            } else if ($na_pengetahuan >= $interval->bmin && $na_pengetahuan <= $interval->bmax){
                                $p_predikat = "B";
                                $p_deskripsi = "<a onClick='return show_chart(\"".$m_row->idmata_pelajaran."\",\"".$data_nilai_akhir->idsiswa."\",\"".$data_nilai_akhir->s_nama."\",\"".$data_nilai_akhir->idkelas."\");' class='btn-sm btn-info text-light'>Tuntas</a>";
                            } else if ($na_pengetahuan >= $interval->cmin && $na_pengetahuan <= $interval->cmax){
                                $p_predikat = "C";
                                $p_deskripsi = "<a onClick='return show_chart(\"".$m_row->idmata_pelajaran."\",\"".$data_nilai_akhir->idsiswa."\",\"".$data_nilai_akhir->s_nama."\",\"".$data_nilai_akhir->idkelas."\");' class='btn-sm btn-info text-light'>Tuntas</a>";
                            } else if ($na_pengetahuan >= $interval->dmin && $na_pengetahuan <= $interval->dmax){
                                $p_predikat = "D";
                                $p_deskripsi = "<a onClick='return show_chart(\"".$m_row->idmata_pelajaran."\",\"".$data_nilai_akhir->idsiswa."\",\"".$data_nilai_akhir->s_nama."\",\"".$data_nilai_akhir->idkelas."\");' class='btn-sm btn-warning'>Belum</a>";
                            }
            
                            if ($na_keterampilan >= $interval->amin && $na_keterampilan <= $interval->amax)
                            {
                                $k_predikat = "A";
                                $k_deskripsi = "<a onClick='return show_chart(\"".$m_row->idmata_pelajaran."\",\"".$data_nilai_akhir->idsiswa."\",\"".$data_nilai_akhir->s_nama."\",\"".$data_nilai_akhir->idkelas."\");' class='btn-sm btn-info text-light'>Tuntas</a>";
                            } else if ($na_keterampilan >= $interval->bmin && $na_keterampilan <= $interval->bmax){
                                $k_predikat = "B";
                                $k_deskripsi = "<a onClick='return show_chart(\"".$m_row->idmata_pelajaran."\",\"".$data_nilai_akhir->idsiswa."\",\"".$data_nilai_akhir->s_nama."\",\"".$data_nilai_akhir->idkelas."\");' class='btn-sm btn-info text-light'>Tuntas</a>";
                            } else if ($na_keterampilan >= $interval->cmin && $na_keterampilan <= $interval->cmax){
                                $k_predikat = "C";
                                $k_deskripsi = "<a onClick='return show_chart(\"".$m_row->idmata_pelajaran."\",\"".$data_nilai_akhir->idsiswa."\",\"".$data_nilai_akhir->s_nama."\",\"".$data_nilai_akhir->idkelas."\");' class='btn-sm btn-info text-light'>Tuntas</a>";
                            } else if ($na_keterampilan >= $interval->dmin && $na_keterampilan <= $interval->dmax){
                                $k_predikat = "D";
                                $k_deskripsi = "<a onClick='return show_chart(\"".$m_row->idmata_pelajaran."\",\"".$data_nilai_akhir->idsiswa."\",\"".$data_nilai_akhir->s_nama."\",\"".$data_nilai_akhir->idkelas."\");' class='btn-sm btn-warning'>Belum</a>";
                            }
                        } else {
                            $p_predikat = "(..)";
                            $p_deskripsi = "(..)";
                            $k_predikat = "(..)";
                            $k_deskripsi = "(..)";
                        }   
                    } else {
                        $p_predikat = "(..)";
                        $p_deskripsi = "(..)";
                        $k_predikat = "(..)";
                        $k_deskripsi = "(..)";
                    }
                    
                    $p_predikat_text .= '<i class="fas fa-arrow-alt-circle-right"></i> '.$p_predikat.' <br/><br/>';
                    $p_deskripsi_text .= '<i class="fas fa-arrow-alt-circle-right"></i> '.$p_deskripsi.' <br/><br/>';
                    $k_predikat_text .= '<i class="fas fa-arrow-alt-circle-right"></i> '.$k_predikat.' <br/><br/>';
                    $k_deskripsi_text .= '<i class="fas fa-arrow-alt-circle-right"></i> '.$k_deskripsi.' <br/><br/>';
                }
            }

			$no++;
			$row = array();
            $row[] = $no;
            // .' <br/> <a onClick="return print_rapor(\''.encrypt_sr($data_nilai_akhir->idsiswa).'\')" class="btn-sm btn-success text-light"><i class="fa fa-print"></i> Rapor</a>'
            $row[] = $data_nilai_akhir->s_nama;
            $row[] = $mata_pelajaran;
            $row[] = $mapel_kkm;
            $row[] = $na_pengetahuan_text;
            $row[] = $p_predikat_text;
            $row[] = $p_deskripsi_text;
            $row[] = $na_keterampilan_text;
            $row[] = $k_predikat_text;
            $row[] = $k_deskripsi_text;
            
            $data[] = $row;
            
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_siswa->count_all_wali($idkelas),
			"recordsFiltered" => $this->Model_siswa->count_filtered_wali($idusers),
			"data" => $data
		);
		//output to json format
		echo json_encode($output);
    }

    public function nilai_siswa_chart()
    {
        $data = $this->input->post();
        $token = filter($data['token']);
        if ($token!='access'){
            redirect(base_url());
        }
        $idmapel = filter($data['idmapel']);
        $idsiswa = filter($data['idsiswa']);
        $s_nama = filter($data['snama']);
        $idkelas = filter($data['idkelas']);

        $kelas = $this->Model_users->read_users_by_kelas($idkelas);
        if ($kelas!=false){
            $idusers = $kelas->idusers;
        } else {
            $idusers = 0;
        }
        $this->data['s_nama'] = $s_nama;
        $kkm = $this->Model_kkm->read_data_by_mapel($idmapel);
        $nama_mapel = $this->Model_mapel->read_one_data_by_id($idmapel);
        if($nama_mapel!=false){
            $this->data['nama_mapel'] = $nama_mapel->mp_nama;
        } else {
            $this->data['nama_mapel'] = '';
        }
        if ($kkm!=false){
            $this->data['kkm'] = $kkm->k_kkm;
        } else {
            $this->data['kkm'] = 0;
        }
        $pengetahuan_utsuas = $this->Model_pengetahuan_utsuas->read_all_data_siswa($idsiswa,$idkelas,$idmapel,$this->session->userdata('tahun'));
        if ($pengetahuan_utsuas!=false){
            $n_uts = $pengetahuan_utsuas->np_uts;
            $n_uas = $pengetahuan_utsuas->np_uas;
        } else {
            $n_uts = 0;
            $n_uas = 0;
        }
        $this->data['pengetahuan_kd_name'] = '';
        $this->data['pengetahuan_kd_rata'] = null;
        $this->data['keterampilan_kd_name'] = '';
        $this->data['keterampilan_kd_rata'] = null;

        // PENGETAHUAN
        $check_pengetahuan = [
            'idtahun_pelajaran' => $this->session->userdata('tahun'),
            'idkelas' => $idkelas,
            'idmata_pelajaran' => $idmapel,
        ];
        $rencana_pengetahuan = $this->Model_kompetensi->check_rencana_pengetahuan($check_pengetahuan);
        if ($rencana_pengetahuan!=false){
            $rp_loop = $rencana_pengetahuan['rkdp_penilaian_harian'];
        } else {
            $rp_loop = 0;
        }
        // Pemanggilan data tiap siswa terhadap nilai pengetahuan dan keterampilan
        $pengetahuan = $this->Model_pengetahuan->read_all_data_siswa($idsiswa,$idkelas,$idmapel,$this->session->userdata('tahun'));
        $total_kd_np = 0;
        $total_kd = 0;
        $total_rata_kd = 0;
        $pengetahuan_kd_name = '';
        $pengetahuan_kd_nilai = null;
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
                if ($rencana_pengetahuan!=false){
                    $rp_loop = $rencana_pengetahuan['rkdp_penilaian_harian'];
                } else {
                    $rp_loop = 0;
                }
                // Mengambil data KKM
                $kompetensi_dasar = $this->Model_kompetensi->read_data_by_id($row->idkompetensi_dasar);
                if ($kkm!=false)
                {
                    $kd_nama = $kompetensi_dasar['kd_kode'].' '.$kompetensi_dasar['kd_nama'];
                    $kd_nilai = round($total_rata_kd);
                    $pengetahuan_kd_name .= "'$kd_nama'". ", ";
                    $pengetahuan_kd_nilai .= "$kd_nilai". ", ";
                }
                $total_kd_np = $total_kd_np + $total_rata_kd;
                $total_kd = 0;
            }
            $this->data['pengetahuan_kd_name'] = $pengetahuan_kd_name;
            $this->data['pengetahuan_kd_rata'] = $pengetahuan_kd_nilai;
        }

        // KETERAMPILAN
        $check_keterampilan = [
            'idtahun_pelajaran' => $this->session->userdata('tahun'),
            'idkelas' => $idkelas,
            'idmata_pelajaran' => $idmapel,
        ];
        $rencana_keterampilan = $this->Model_kompetensi->check_rencana_keterampilan($check_keterampilan);
        if ($rencana_keterampilan!=false){
            $rk_loop = $rencana_keterampilan['rkdk_penilaian_harian'];
        } else {
            $rk_loop = 0;
        }

        // Pemanggilan data tiap siswa terhadap nilai pengetahuan dan keterampilan
        $keterampilan = $this->Model_keterampilan->read_all_data_siswa($idsiswa,$idkelas,$idmapel,$this->session->userdata('tahun'));
        $total_kd_nk = 0;
        $total_kd_k = 0;
        $total_rata_kd_k = 0;
        $keterampilan_kd_name = '';
        $keterampilan_kd_nilai = null;

        // Menghitung total nilai yang diinput sesuai rencana penilaian
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
                if ($rencana_keterampilan!=false){
                    $rk_loop = $rencana_keterampilan['rkdk_penilaian_harian'];
                } else {
                    $rk_loop = 0;
                }
                // Mengambil data KKM
                $kompetensi_dasar_k = $this->Model_kompetensi->read_data_by_id($row->idkompetensi_dasar);
                if ($kkm!=false)
                {
                    $kd_nama_k = $kompetensi_dasar_k['kd_kode'].' '.$kompetensi_dasar_k['kd_nama'];
                    $kd_nilai_k = round($total_rata_kd_k);
                    $keterampilan_kd_name .= "'$kd_nama_k'". ", ";
                    $keterampilan_kd_nilai .= "$kd_nilai_k". ", ";

                }
                $total_kd_nk = $total_kd_nk + $total_rata_kd_k;
                $total_kd_k = 0;
            }
            $this->data['keterampilan_kd_name'] = $keterampilan_kd_name;
            $this->data['keterampilan_kd_rata'] = $keterampilan_kd_nilai;
        }
        $this->data['pts_nilai'] = $n_uts;
        $this->data['pas_nilai'] = $n_uas;

        $this->load->view('administrator/nilai_rapor/nilai_siswa_chart',$this->data);
    }

    public function nilai_seluruh_siswa_chart()
    {
        $data = $this->input->post();
        $token = filter($data['token']);
        if ($token!='access'){
            redirect(base_url());
        }
        $idkelas = filter($data['idkelas']);
        if ($idkelas==null){
            return false;
        }
        $kelas = $this->Model_users->read_users_by_kelas($idkelas);
        if ($kelas!=false){
            $idusers = $kelas->idusers;
        } else {
            $idusers = 0;
        }
        // Data mapel
		$mapel = $this->Model_mapel->read_data();
		$total_mapel = $this->Model_mapel->count_all();
        $total_mapel_p_k = 2 * (Integer)$total_mapel;
        $siswa = $this->Model_siswa_guru->read_data_by_kelas($idkelas,$this->session->userdata('tahun'),$idusers);
        $this->data['s_nama'] = '';
        $this->data['s_nilai'] = null;
		if ($siswa!=null){
			$total_seluruh_nilai = 0;
			$total_seluruh_siswa = count($siswa);
			$s = 1;
			foreach ($siswa as $row){
				$this->data['s_nama'] .= "'$row->s_nama'". ", ";
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
                $this->data['s_nilai'] .= "'$total_seluruh_nilai'". ", ";
                $total_seluruh_nilai = 0;
			}
		}

        $this->load->view('administrator/nilai_rapor/nilai_seluruh_siswa_chart',$this->data);
    }
    
}