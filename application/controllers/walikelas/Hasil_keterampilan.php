<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil_keterampilan extends CI_Controller
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
        $this->template->load('walikelas/template','walikelas/hasil_keterampilan/hasil_keterampilan',$this->data);
    }

    public function ajax_list_rincian()
	{
		//get_datatables terletak di model
		$idkelas = $this->uri->segment(4);
		$idmapel = $this->uri->segment(5);

        $list = $this->Model_siswa_guru->get_datatables_wali_p($this->session->userdata('user_id'));

        $check = [
            'idtahun_pelajaran' => $this->session->userdata('tahun'),
            'idkelas' => $idkelas,
            'idmata_pelajaran' => $idmapel,
        ];
        $rencana = $this->Model_kompetensi->check_rencana_keterampilan($check);
        if ($rencana!=false){
            $rk_loop = $rencana['rkdk_penilaian_harian'];
        } else {
            $rk_loop = 0;
        }

        $data = array();
        $input_nilai = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_deskripsi) {
            // Pemanggilan data tiap siswa terhadap nilai pengetahuan dan keterampilan
            $keterampilan = $this->Model_keterampilan->read_all_data_siswa($data_deskripsi->idsiswa,$idkelas,$idmapel,$this->session->userdata('tahun'));
            
            $total_kd = 0;
            $kdk_harian = '';
            $kdk_harian_show = '';
            $kdk_deskripsi = '';

            // Menghitung total nilai yang diinput sesuai rencana penilaian
            if ($keterampilan!=false){
                foreach ($keterampilan as $row)
                {   
                    $kd = count($keterampilan);
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
                            } else {
                                $k_nilai = 100;
                                $rk_loop = 1;
                            }
                        }
                        $total_kd += (Integer)$k_nilai;
                        if (isset($k_explode[$i]) AND $k_explode[$i]!=1){
                            $kdk_harian .= '<input type="text" class="col-2" value="'.$k_nilai.'" readonly /> ';
                        } else {
                            continue;
                        }
                    }
                    if ($rencana!=false){
                        $rk_loop = $rencana['rkdk_penilaian_harian'];
                    } else {
                        $rk_loop = 0;
                    }

                    $kompetensi_dasar = $this->Model_kompetensi->read_data_by_id($row->idkompetensi_dasar);
                    $kdk_deskripsi .= '<i class="fas fa-arrow-alt-circle-right"></i> '.$kompetensi_dasar['kd_kode'].' '.ucwords($kompetensi_dasar['kd_nama']).' <small>('.$rk_loop.')</small> <br/>';
                    $kdk_harian_show .= '<i class="fas fa-arrow-alt-circle-right"></i> '.$kdk_harian.' = '.$total_kd.'<br/>';
                    $kdk_harian = '';
                    $total_kd = 0;
                }
            }

			$no++;
			$row = array();
			$row[] = $no;
            $row[] = $data_deskripsi->s_nama;
            $row[] = $kdk_deskripsi;
            $row[] = $kdk_harian_show;
            
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
        $rencana = $this->Model_kompetensi->check_rencana_keterampilan($check);
        if ($rencana!=false){
            $rk_loop = $rencana['rkdk_penilaian_harian'];
        } else {
            $rk_loop = 0;
        }

        $data = array();
        $input_nilai = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_deskripsi) {
            // Pemanggilan data tiap siswa terhadap nilai pengetahuan dan keterampilan
            $keterampilan = $this->Model_keterampilan->read_all_data_siswa($data_deskripsi->idsiswa,$idkelas,$idmapel,$this->session->userdata('tahun'));

            $total_kd_np = 0;
            $total_kd = 0;
            $total_rata_kd = 0;
            $kdk_deskripsi = '';
            $kdk_nilai = '';
            $kdk_predikat = '';
            $k_predikat = '';
            $k_deskripsi = '';

            // Menghitung total nilai yang diinput sesuai rencana penilaian
            if ($keterampilan!=false){
                foreach ($keterampilan as $row)
                {   
                    $kd = count($keterampilan);
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
                        $total_kd = $total_kd + (Integer)$k_nilai;
                    }
                    $total_rata_kd = $total_kd/$rk_loop;
                    if ($rencana!=false){
                        $rk_loop = $rencana['rkdk_penilaian_harian'];
                    } else {
                        $rk_loop = 0;
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
                                $k_predikat = "A";
                                $k_deskripsi = "Sangat Baik";
                            } else if ($total_rata_kd >= $interval->bmin && $total_rata_kd <= $interval->bmax){
                                $k_predikat = "B";
                                $k_deskripsi = "Baik";
                            } else if ($total_rata_kd >= $interval->cmin && $total_rata_kd <= $interval->cmax){
                                $k_predikat = "C";
                                $k_deskripsi = "Cukup";
                            } else if ($total_rata_kd >= $interval->dmin && $total_rata_kd <= $interval->dmax){
                                $k_predikat = "D";
                                $k_deskripsi = "Perlu Bimbingan";
                            }
                        } else {
                            $k_predikat = "(Error)";
                            $k_deskripsi = "Admin belum melakukan pengaturan interval predikat untuk mata pelajaran dan kelas ini!";
                        }
                        
                        //<i class="fas fa-arrow-alt-circle-right"></i>
                        //<i class="fas fa-angle-double-right"></i>
                        $kdk_deskripsi .= '<i class="fas fa-arrow-alt-circle-right"></i> '.$kompetensi_dasar['kd_kode'].' '.ucwords($kompetensi_dasar['kd_nama']).' <br/>';
                        $kdk_nilai .= '<i class="fas fa-arrow-alt-circle-right"></i> '.round($total_rata_kd).' <br/>';
                        $kdk_predikat .= '<i class="fas fa-arrow-alt-circle-right"></i> '.$k_predikat.' ('.$k_deskripsi.') <br/>';

                    }
                    $total_kd_np = $total_kd_np + $total_rata_kd;
                    $total_kd = 0;
                }
            }

			$no++;
			$row = array();
			$row[] = $no;
            $row[] = $data_deskripsi->s_nama;
            $row[] = $kdk_deskripsi;
            $row[] = $kdk_nilai;
            $row[] = $kdk_predikat;
            
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
        $rencana = $this->Model_kompetensi->check_rencana_keterampilan($check);
        if ($rencana!=false){
            $rk_loop = $rencana['rkdk_penilaian_harian'];
        } else {
            $rk_loop = 0;
        }

        $data = array();
        $input_nilai = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_deskripsi) {
            // Pemanggilan data tiap siswa terhadap nilai pengetahuan dan keterampilan
            $keterampilan = $this->Model_keterampilan->read_all_data_siswa($data_deskripsi->idsiswa,$idkelas,$idmapel,$this->session->userdata('tahun'));
            $keterampilan_deskripsi = $this->Model_keterampilan->read_all_nk_deskripsi($this->session->userdata('tahun'),$idmapel,$idkelas,$data_deskripsi->idsiswa);
            
            if ($keterampilan_deskripsi!=false){
                $idkdeskripsi = $keterampilan_deskripsi->idnk_deskripsi;
                $kdeskripsi = $keterampilan_deskripsi->nk_deskripsi;
            } else {
                $idkdeskripsi = '';
                $kdeskripsi = '';
            }

            $total_kd_np = 0;
            $total_kd = 0;
            $total_rata_kd = 0;
            $kdk_deskripsi = '';
            $kdk_desk = '';

            // Menghitung total nilai yang diinput sesuai rencana penilaian
            if ($keterampilan!=false){
                foreach ($keterampilan as $row)
                {   
                    $kd = count($keterampilan);
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
                        $total_kd = $total_kd + (Integer)$k_nilai;
                    }
                    $total_rata_kd = $total_kd/$rk_loop;
                    if ($rencana!=false){
                        $rk_loop = $rencana['rkdk_penilaian_harian'];
                    } else {
                        $rk_loop = 0;
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
                                $kdk_desk = "Sudah sangat baik dalam ";
                            } else if ($total_rata_kd >= $interval->bmin && $total_rata_kd <= $interval->bmax){
                                $kdk_desk = "Sudah baik dalam ";
                            } else if ($total_rata_kd >= $interval->cmin && $total_rata_kd <= $interval->cmax){
                                $kdk_desk = "Sudah cukup dalam ";
                            } else if ($total_rata_kd >= $interval->dmin && $total_rata_kd <= $interval->dmax){
                                $kdk_desk = "Perlu bimbingan dalam ";
                            }
                        } else {
                            $kdk_desk = "(Error) Admin belum melakukan pengaturan interval predikat untuk mata pelajaran dan kelas ini!";
                        }
                        
                        $kdk_deskripsi .= $kdk_desk.' '.strtolower($kompetensi_dasar['kd_nama']).'. ';
                    }
                    $total_kd_np = $total_kd_np + $total_rata_kd;
                    $total_kd = 0;
                }
                $rata_kd_p = ceil($total_kd_np / $kd);  
            } else {
                $rata_kd_p = 0;
            }

            // Menghitung nilai akhir
            $na_pengetahuan = round($rata_kd_p);

            // Mengambil data KKM
            if ($kkm!=false)
            {
                $interval = $this->Model_interval->read_data_by_kkm($kkm->idkkm);
                if ($interval!=false){
                     // Membandingkan nilai akhir dengan Interval KKM
                    if ($na_pengetahuan >= $interval->amin && $na_pengetahuan <= $interval->amax)
                    {
                        $k_predikat = "A";
                        $k_deskripsi = "Capaian kompetensi sudah tuntas dengan predikat Sangat Baik.";
                    } else if ($na_pengetahuan >= $interval->bmin && $na_pengetahuan <= $interval->bmax){
                        $k_predikat = "B";
                        $k_deskripsi = "Capaian kompetensi sudah tuntas dengan predikat Baik.";
                    } else if ($na_pengetahuan >= $interval->cmin && $na_pengetahuan <= $interval->cmax){
                        $k_predikat = "C";
                        $k_deskripsi = "Capaian kompetensi sudah tuntas dengan predikat Cukup.";
                    } else if ($na_pengetahuan >= $interval->dmin && $na_pengetahuan <= $interval->dmax){
                        $k_predikat = "D";
                        $k_deskripsi = "Capaian kompetensi belum tuntas dan perlu bimbingan.";
                    } else {
                        $k_predikat = "Error !";
                        $k_deskripsi = "Perhitungan salah !";
                    }
                } else {
                    $k_predikat = "(Error)";
                    $k_deskripsi = "Admin belum melakukan pengaturan interval predikat untuk mata pelajaran dan kelas ini !";
                }
                
            } else {
                $k_predikat = "Error!";
                $k_deskripsi = "Admin belum menambahkan data interval predikat, silahkan hubungi administrator!";
            }

			$no++;
			$row = array();
			$row[] = $no;
            $row[] = $data_deskripsi->s_nama;
            $row[] = $na_pengetahuan;
            $row[] = $k_predikat;
            $row[] = $k_deskripsi.' '.$kdk_deskripsi.' '.$kdeskripsi;
            
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