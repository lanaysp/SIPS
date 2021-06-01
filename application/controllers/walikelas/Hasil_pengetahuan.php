<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil_pengetahuan extends CI_Controller
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
        $this->load->model('Model_pengetahuan');
        $this->load->model('Model_pengetahuan_utsuas');
        $this->load->model('Model_kompetensi');
        $this->load->model('Model_kkm');
        $this->load->model('Model_interval');
		
        $this->load->library('Template');
        $this->load->library('Ion_auth');
		
		if (!$this->ion_auth->is_walikelas()){redirect('Auth/login');}
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
        $this->data['list_kelas'] = $this->Model_kelas->list_kelas_by_id($this->session->userdata('user_id'));
		$this->data['list_kelas_attribute'] = [
			'name' => 'idkelas',
			'id' => 'idkelas',
			'class' => 'form-control col-lg-10',
			'required' => 'required'
        ];
        $this->data['list_mapel'] = $this->Model_mapel->list_mapel();
		$this->data['list_mapel_attribute'] = [
			'name' => 'idmata_pelajaran',
			'id' => 'idmata_pelajaran',
			'class' => 'form-control col-lg-10',
			'required' => 'required'
        ];
        $this->template->load('walikelas/template','walikelas/hasil_pengetahuan/hasil_pengetahuan',$this->data);
    }

    public function ajax_list_rincian()
	{
		//get_datatables terletak di model
		$idkelas = $this->uri->segment(4);
		$idmapel = $this->uri->segment(5);

        // baru ditambah 1-1-21
        $list = $this->Model_siswa_guru->get_datatables_wali_p($this->session->userdata('user_id'));

        $check = [
            'idtahun_pelajaran' => $this->session->userdata('tahun'),
            'idkelas' => $idkelas,
            'idmata_pelajaran' => $idmapel,
        ];
        $rencana = $this->Model_kompetensi->check_rencana_pengetahuan($check);
        if ($rencana!=false){
            $rp_loop = $rencana['rkdp_penilaian_harian'];
        } else {
            $rp_loop = 0;
        }

        $data = array();
        $input_nilai = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_deskripsi) {
            // Pemanggilan data tiap siswa terhadap nilai pengetahuan dan keterampilan
            $pengetahuan = $this->Model_pengetahuan->read_all_data_siswa($data_deskripsi->idsiswa,$idkelas,$idmapel,$this->session->userdata('tahun'));
            $pengetahuan_utsuas = $this->Model_pengetahuan_utsuas->read_all_data_siswa($data_deskripsi->idsiswa,$idkelas,$idmapel,$this->session->userdata('tahun'));
            
            $total_kd = 0;
            $kdp_harian = '';
            $kdp_harian_show = '';
            $kdp_deskripsi = '';

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
                            } else {
                                $p_nilai = 100;
                                $rp_loop = 1;
                            }
                        }
                        $total_kd += (Integer)$p_nilai;
                        if (isset($p_explode[$i]) AND $p_explode[$i]!=1){
                            $kdp_harian .= '<input type="text" class="col-2" value="'.$p_nilai.'" readonly /> ';
                        } else {
                            continue;
                        }
                    }
                    if ($rencana!=false){
                        $rp_loop = $rencana['rkdp_penilaian_harian'];
                    } else {
                        $rp_loop = 0;
                    }

                    $kompetensi_dasar = $this->Model_kompetensi->read_data_by_id($row->idkompetensi_dasar);
                    $kdp_deskripsi .= '<i class="fas fa-arrow-alt-circle-right"></i> '.$kompetensi_dasar['kd_kode'].' '.ucwords($kompetensi_dasar['kd_nama']).' <small>('.$rp_loop.')</small> <br/>';
                    $kdp_harian_show .= '<i class="fas fa-arrow-alt-circle-right"></i> '.$kdp_harian.' = '.$total_kd.'<br/>';
                    $kdp_harian = '';
                    $total_kd = 0;
                }
            }

            if ($pengetahuan_utsuas!=false){
                $n_uts = $pengetahuan_utsuas->np_uts;
                $n_uas = $pengetahuan_utsuas->np_uas;
            } else {
                $n_uts = 0;
                $n_uas = 0;
            }

			$no++;
			$row = array();
			$row[] = $no;
            $row[] = $data_deskripsi->s_nama;
            $row[] = $kdp_deskripsi;
            $row[] = $kdp_harian_show;
            $row[] = $n_uts;
            $row[] = $n_uas;
            
            $data[] = $row;
            
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_siswa->count_all_wali($idkelas),
			"recordsFiltered" => $this->Model_siswa->count_filtered_wali($this->session->userdata('user_id')),
			"data" => $data
		);
		//output to json format
		echo json_encode($output);
    }

    public function ajax_list_pengolahan()
	{
		//get_datatables terletak di model
		$idkelas = $this->uri->segment(4);
		$idmapel = $this->uri->segment(5);

        $list = $this->Model_siswa_guru->get_datatables_wali_p($this->session->userdata('user_id'));
        $kkm = $this->Model_kkm->read_data_by_mapel($idmapel);
        $check = [
            'idtahun_pelajaran' => $this->session->userdata('tahun'),
            'idkelas' => $idkelas,
            'idmata_pelajaran' => $idmapel,
        ];
        $rencana = $this->Model_kompetensi->check_rencana_pengetahuan($check);
        if ($rencana!=false){
            $rp_loop = $rencana['rkdp_penilaian_harian'];
        } else {
            $rp_loop = 0;
        }

        $data = array();
        $input_nilai = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_deskripsi) {
            // Pemanggilan data tiap siswa terhadap nilai pengetahuan dan keterampilan
            $pengetahuan = $this->Model_pengetahuan->read_all_data_siswa($data_deskripsi->idsiswa,$idkelas,$idmapel,$this->session->userdata('tahun'));

            $total_kd_np = 0;
            $total_kd = 0;
            $total_rata_kd = 0;
            $kdp_deskripsi = '';
            $kdp_nilai = '';
            $kdp_predikat = '';

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
                    if ($rencana!=false){
                        $rp_loop = $rencana['rkdp_penilaian_harian'];
                    } else {
                        $rp_loop = 0;
                    }
                    // Mengambil data KKM
                    $kompetensi_dasar = $this->Model_kompetensi->read_data_by_id($row->idkompetensi_dasar);
                    if ($kkm!=false)
                    {
                        $interval = $this->Model_interval->read_data_by_kkm($kkm->idkkm);
                        if ($interval!=false){
                            // Membandingkan nilai akhir dengan Interval KKM
                            if ($total_rata_kd >= $interval->amin && $total_rata_kd <= $interval->amax)
                            {
                                $p_predikat = "A";
                                $p_deskripsi = "Sangat Baik";
                            } else if ($total_rata_kd >= $interval->bmin && $total_rata_kd <= $interval->bmax){
                                $p_predikat = "B";
                                $p_deskripsi = "Baik";
                            } else if ($total_rata_kd >= $interval->cmin && $total_rata_kd <= $interval->cmax){
                                $p_predikat = "C";
                                $p_deskripsi = "Cukup";
                            } else if ($total_rata_kd >= $interval->dmin && $total_rata_kd <= $interval->dmax){
                                $p_predikat = "D";
                                $p_deskripsi = "Perlu Bimbingan";
                            }
                        } else {
                            $p_predikat = "(Error)";
                            $p_deskripsi = "Admin belum melakukan pengaturan interval predikat untuk mata pelajaran dan kelas ini!";
                        }
                        
                        //<i class="fas fa-arrow-alt-circle-right"></i>
                        //<i class="fas fa-angle-double-right"></i>
                        $kdp_deskripsi .= '<i class="fas fa-arrow-alt-circle-right"></i> '.$kompetensi_dasar['kd_kode'].' '.ucwords($kompetensi_dasar['kd_nama']).' <br/>';
                        $kdp_nilai .= '<i class="fas fa-arrow-alt-circle-right"></i> '.round($total_rata_kd).' <br/>';
                        $kdp_predikat .= '<i class="fas fa-arrow-alt-circle-right"></i> '.$p_predikat.' ('.$p_deskripsi.') <br/>';

                    }
                    $total_kd_np = $total_kd_np + $total_rata_kd;
                    $total_kd = 0;
                }
            }

			$no++;
			$row = array();
			$row[] = $no;
            $row[] = $data_deskripsi->s_nama;
            $row[] = $kdp_deskripsi;
            $row[] = $kdp_nilai;
            $row[] = $kdp_predikat;
            
            $data[] = $row;
            
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_siswa->count_all_wali($idkelas),
			"recordsFiltered" => $this->Model_siswa->count_filtered_wali($this->session->userdata('user_id')),
			"data" => $data
		);
		//output to json format
		echo json_encode($output);
    }

    public function ajax_list_rapor()
	{
		//get_datatables terletak di model
		$idkelas = $this->uri->segment(4);
		$idmapel = $this->uri->segment(5);

        $list = $this->Model_siswa_guru->get_datatables_wali_p($this->session->userdata('user_id'));
        $kkm = $this->Model_kkm->read_data_by_mapel($idmapel);
        $check = [
            'idtahun_pelajaran' => $this->session->userdata('tahun'),
            'idkelas' => $idkelas,
            'idmata_pelajaran' => $idmapel,
        ];
        $rencana = $this->Model_kompetensi->check_rencana_pengetahuan($check);
        if ($rencana!=false){
            $rp_loop = $rencana['rkdp_penilaian_harian'];
        } else {
            $rp_loop = 0;
        }

        $data = array();
        $input_nilai = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_deskripsi) {
            // Pemanggilan data tiap siswa terhadap nilai pengetahuan dan keterampilan
            $pengetahuan = $this->Model_pengetahuan->read_all_data_siswa($data_deskripsi->idsiswa,$idkelas,$idmapel,$this->session->userdata('tahun'));
            $pengetahuan_utsuas = $this->Model_pengetahuan_utsuas->read_all_data_siswa($data_deskripsi->idsiswa,$idkelas,$idmapel,$this->session->userdata('tahun'));

            $pengetahuan_deskripsi = $this->Model_pengetahuan->read_all_np_deskripsi($this->session->userdata('tahun'),$idmapel,$idkelas,$data_deskripsi->idsiswa);
            
            if ($pengetahuan_deskripsi!=false){
                $idpdeskripsi = $pengetahuan_deskripsi->idnp_deskripsi;
                $pdeskripsi = $pengetahuan_deskripsi->np_deskripsi;
            } else {
                $idpdeskripsi = '';
                $pdeskripsi = '';
            }

            $total_kd_np = 0;
            $total_kd = 0;
            $total_rata_kd = 0;
            $kdp_deskripsi = '';
            $kdp_desk = '';

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
                    if ($rencana!=false){
                        $rp_loop = $rencana['rkdp_penilaian_harian'];
                    } else {
                        $rp_loop = 0;
                    }
                    // Mengambil data KKM
                    $kompetensi_dasar = $this->Model_kompetensi->read_data_by_id($row->idkompetensi_dasar);
                    if ($kkm!=false)
                    {
                        $interval = $this->Model_interval->read_data_by_kkm($kkm->idkkm);
                        if ($interval!=false){
                            // Membandingkan nilai akhir dengan Interval KKM
                            if ($total_rata_kd >= $interval->amin && $total_rata_kd <= $interval->amax)
                            {
                                $kdp_desk = "Sudah sangat baik dalam ";
                            } else if ($total_rata_kd >= $interval->bmin && $total_rata_kd <= $interval->bmax){
                                $kdp_desk = "Sudah baik dalam ";
                            } else if ($total_rata_kd >= $interval->cmin && $total_rata_kd <= $interval->cmax){
                                $kdp_desk = "Sudah cukup dalam ";
                            } else if ($total_rata_kd >= $interval->dmin && $total_rata_kd <= $interval->dmax){
                                $kdp_desk = "Perlu bimbingan dalam ";
                            }
                        } else {
                            $kdp_desk = "(Error) Admin belum melakukan pengaturan interval predikat untuk mata pelajaran dan kelas ini!";
                        }
                        
                        $kdp_deskripsi .= $kdp_desk.' '.strtolower($kompetensi_dasar['kd_nama']).'. ';
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

            // Menghitung nilai akhir
            $na_pengetahuan = round((($rata_kd_p * 2) + $n_uts + $n_uas) / 4);

            // Mengambil data KKM
            if ($kkm!=false)
            {
                $interval = $this->Model_interval->read_data_by_kkm($kkm->idkkm);
                if ($interval!=false){
                     // Membandingkan nilai akhir dengan Interval KKM
                    if ($na_pengetahuan >= $interval->amin && $na_pengetahuan <= $interval->amax)
                    {
                        $p_predikat = "A";
                        $p_deskripsi = "Capaian kompetensi sudah tuntas dengan predikat Sangat Baik.";
                    } else if ($na_pengetahuan >= $interval->bmin && $na_pengetahuan <= $interval->bmax){
                        $p_predikat = "B";
                        $p_deskripsi = "Capaian kompetensi sudah tuntas dengan predikat Baik.";
                    } else if ($na_pengetahuan >= $interval->cmin && $na_pengetahuan <= $interval->cmax){
                        $p_predikat = "C";
                        $p_deskripsi = "Capaian kompetensi sudah tuntas dengan predikat Cukup.";
                    } else if ($na_pengetahuan >= $interval->dmin && $na_pengetahuan <= $interval->dmax){
                        $p_predikat = "D";
                        $p_deskripsi = "Capaian kompetensi belum tuntas dan perlu bimbingan.";
                    }
                } else {
                    $p_predikat = "(Error)";
                    $p_deskripsi = "Admin belum melakukan pengaturan interval predikat untuk mata pelajaran dan kelas ini !";
                }
                
            } else {
                $p_predikat = "(Error)";
                $p_deskripsi = "Admin belum menambahkan data interval predikat dan kkm, silahkan hubungi administrator!";
            }

			$no++;
			$row = array();
			$row[] = $no;
            $row[] = $data_deskripsi->s_nama;
            $row[] = $na_pengetahuan;
            $row[] = $p_predikat;
            $row[] = $p_deskripsi.' '.$kdp_deskripsi.' '.$pdeskripsi;
            
            $data[] = $row;
            
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_siswa->count_all_wali($idkelas),
			"recordsFiltered" => $this->Model_siswa->count_filtered_wali($this->session->userdata('user_id')),
			"data" => $data
		);
		//output to json format
		echo json_encode($output);
    }
}