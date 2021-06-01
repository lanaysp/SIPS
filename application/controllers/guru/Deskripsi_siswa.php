<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Deskripsi_siswa extends CI_Controller
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
        $this->load->model('Model_pengetahuan');
        $this->load->model('Model_pengetahuan_utsuas');
        $this->load->model('Model_keterampilan');
        $this->load->model('Model_kompetensi');
        $this->load->model('Model_kkm');
        $this->load->model('Model_interval');
		
        $this->load->library('Template');
        $this->load->library('Ion_auth');
		
		if (!$this->ion_auth->is_guru()){redirect('Auth/login');}
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
        $this->data['list_mapel'] = $this->Model_mapel->list_mapel_by_id($this->session->userdata('user_id'));
		$this->data['list_mapel_attribute'] = [
			'name' => 'idmata_pelajaran',
			'id' => 'idmata_pelajaran',
			'class' => 'form-control col-lg-10',
			'required' => 'required'
        ];
        $this->template->load('guru/template','guru/deskripsi_siswa/deskripsi_siswa',$this->data);
    }

    public function ajax_list()
	{
		//get_datatables terletak di model
		$idkelas = $this->uri->segment(4);
		$idmapel = $this->uri->segment(5);

        $list = $this->Model_pengetahuan->get_datatables_siswa($idkelas,$this->session->userdata('tahun'),$this->session->userdata('user_id'));
        $kkm = $this->Model_kkm->read_data_by_mapel($idmapel);
        $check = [
            'idtahun_pelajaran' => $this->session->userdata('tahun'),
            'idusers' => $this->session->userdata('user_id'),
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

        $data = array();
        $input_nilai = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_deskripsi) {
            // Pemanggilan data tiap siswa terhadap nilai pengetahuan dan keterampilan
            $pengetahuan = $this->Model_pengetahuan->read_data_siswa($data_deskripsi->idsiswa,$idkelas,$idmapel,$this->session->userdata('tahun'),$this->session->userdata('user_id'));
            $pengetahuan_utsuas = $this->Model_pengetahuan_utsuas->read_data_siswa($data_deskripsi->idsiswa,$idkelas,$idmapel,$this->session->userdata('tahun'),$this->session->userdata('user_id'));
            $keterampilan = $this->Model_keterampilan->read_data_siswa($data_deskripsi->idsiswa,$idkelas,$idmapel,$this->session->userdata('tahun'),$this->session->userdata('user_id'));

            $pengetahuan_deskripsi = $this->Model_pengetahuan->read_np_deskripsi($this->session->userdata('tahun'),$idmapel,$this->session->userdata('user_id'),$idkelas,$data_deskripsi->idsiswa);
            $keterampilan_deskripsi = $this->Model_keterampilan->read_nk_deskripsi($this->session->userdata('tahun'),$idmapel,$this->session->userdata('user_id'),$idkelas,$data_deskripsi->idsiswa);
            
            if ($pengetahuan_deskripsi!=false){
                $idpdeskripsi = $pengetahuan_deskripsi->idnp_deskripsi;
                $pdeskripsi = $pengetahuan_deskripsi->np_deskripsi;
            } else {
                $idpdeskripsi = '';
                $pdeskripsi = '';
            }

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
                            $p_nilai = 0;
                            $rp_loop --;
                            $i--;
                        }
                        $total_kd = $total_kd + (Integer)$p_nilai;
                    }
                    $total_rata_kd = $total_kd/$rp_loop;
                    if ($rencana_p!=false){
                        $rp_loop = $rencana_p['rkdp_penilaian_harian'];
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
                            $kdp_desk = "(Error) Administrator belum menginput data interval predikat dan KKM";
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
                            $k_nilai = 0;
                            $rk_loop --;
                            $i--;
                        }
                        $total_kd_k = $total_kd_k + (Integer)$k_nilai;
                    }
                    $total_rata_kd_k = $total_kd_k/$rk_loop;
                    if ($rencana_k!=false){
                        $rk_loop = $rencana_k['rkdk_penilaian_harian'];
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
                            if ($total_rata_kd_k >= $interval->amin && $total_rata_kd_k <= $interval->amax)
                            {
                                $kdk_desk = "Sudah sangat baik dalam ";
                            } else if ($total_rata_kd_k >= $interval->bmin && $total_rata_kd_k <= $interval->bmax){
                                $kdk_desk = "Sudah baik dalam ";
                            } else if ($total_rata_kd_k >= $interval->cmin && $total_rata_kd_k <= $interval->cmax){
                                $kdk_desk = "Sudah cukup dalam ";
                            } else if ($total_rata_kd_k >= $interval->dmin && $total_rata_kd_k <= $interval->dmax){
                                $kdk_desk = "Perlu bimbingan dalam ";
                            }
                        } else {
                            $kdk_desk = "(Error) Administrator belum menginput data interval predikat dan KKM";
                        }
                        
                        $kdk_deskripsi .= $kdk_desk.' '.strtolower($kompetensi_dasar['kd_nama']).'. ';
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

                    if ($na_keterampilan >= $interval->amin && $na_keterampilan <= $interval->amax)
                    {
                        $k_predikat = "A";
                        $k_deskripsi = "Capaian kompetensi sudah tuntas dengan predikat Sangat Baik.";
                    } else if ($na_keterampilan >= $interval->bmin && $na_keterampilan <= $interval->bmax){
                        $k_predikat = "B";
                        $k_deskripsi = "Capaian kompetensi sudah tuntas dengan predikat Baik.";
                    } else if ($na_keterampilan >= $interval->cmin && $na_keterampilan <= $interval->cmax){
                        $k_predikat = "C";
                        $k_deskripsi = "Capaian kompetensi sudah tuntas dengan predikat Cukup.";
                    } else if ($na_keterampilan >= $interval->dmin && $na_keterampilan <= $interval->dmax){
                        $k_predikat = "D";
                        $k_deskripsi = "Capaian kompetensi belum tuntas dan perlu bimbingan.";
                    }
                } else {
                    $p_predikat = "(Error)";
                    $p_deskripsi = "Admin belum menambahkan data interval predikat dan kkm, silahkan hubungi administrator!";
                    $k_predikat = "(Error)";
                    $k_deskripsi = "Admin belum menambahkan data interval predikat dan kkm, silahkan hubungi administrator!";
                }
                
            } else {
                $p_predikat = "(Error)";
                $p_deskripsi = "Admin belum menambahkan data interval predikat, silahkan hubungi administrator!";
                $k_predikat = "(Error)";
                $k_deskripsi = "Admin belum menambahkan data interval predikat, silahkan hubungi administrator!";
            }

			$no++;
			$row = array();
			$row[] = $no;
            $row[] = $data_deskripsi->s_nama;
            $row[] = $na_pengetahuan;
            $row[] = $p_predikat;
            $row[] = $p_deskripsi.' '.$kdp_deskripsi.' '.$pdeskripsi.' <a onClick="return edit_deskripsi(\''.$idpdeskripsi.'\',\''.$pdeskripsi.'\',\''.$data_deskripsi->idsiswa.'\',\'pengetahuan\');" class="btn btn-sm"><i class="fa fa-edit text-primary"></i></a> <div id="edit_p_deskripsi"></div>';
            $row[] = $na_keterampilan;
            $row[] = $k_predikat;
            $row[] = $k_deskripsi.' '.$kdk_deskripsi.' '.$kdeskripsi.' <a onClick="return edit_deskripsi(\''.$idkdeskripsi.'\',\''.$kdeskripsi.'\',\''.$data_deskripsi->idsiswa.'\',\'keterampilan\');" class="btn btn-sm"><i class="fa fa-edit text-primary"></i></a> <div id="edit_k_deskripsi"></div>';
            
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

    public function update_deskripsi()
    {
        $data = $this->input->post();

        if ($data['tipe_deskripsi']=='pengetahuan')
        {
            $update = [
                'idtahun_pelajaran' => $this->session->userdata('tahun'),
                'idmata_pelajaran' => filter($data['idmata_pelajaran']),
                'idusers' => $this->session->userdata('user_id'),
                'idkelas' => filter($data['idkelas']),
                'idsiswa' => filter($data['idsiswa']),
                'np_deskripsi' => ucwords(filter($data['deskripsi']))
            ];
            $id = $data['iddeskripsi'];
            if ($id==''){
                $this->Model_pengetahuan->create_np_deskripsi($update);
            } else {
                $this->Model_pengetahuan->update_np_deskripsi($update,$id);
            }
            $r['status'] = "ok";
            $this->log_activity($this->session->userdata('nama').' mengupdate data deskripsi nilai pengetahuan rapor siswa');
        } else if ($data['tipe_deskripsi']=='keterampilan'){
            $update = [
                'idtahun_pelajaran' => $this->session->userdata('tahun'),
                'idmata_pelajaran' => filter($data['idmata_pelajaran']),
                'idusers' => $this->session->userdata('user_id'),
                'idkelas' => filter($data['idkelas']),
                'idsiswa' => filter($data['idsiswa']),
                'nk_deskripsi' => ucwords(filter($data['deskripsi']))
            ];
            $id = $data['iddeskripsi'];
            if ($id==''){
                $this->Model_keterampilan->create_nk_deskripsi($update);
            } else {
                $this->Model_keterampilan->update_nk_deskripsi($update,$id);
            }
            $r['status'] = "ok";
            $this->log_activity($this->session->userdata('nama').' mengupdate data deskripsi nilai keterampilan rapor siswa');
        } else {
            $r['status'] = "gagal";
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