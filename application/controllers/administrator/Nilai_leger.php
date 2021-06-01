<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Nilai_leger extends CI_Controller
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
        $this->load->model('Model_siswa_guru');
        $this->load->model('Model_pengetahuan');
        $this->load->model('Model_pengetahuan_utsuas');
        $this->load->model('Model_keterampilan');
        $this->load->model('Model_kompetensi');
		
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
		$this->data['p_tahun_pelajaran'] = $p_tahun.' (Semester '.$p_semester.')';
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
        $this->template->load('administrator/template','administrator/nilai_leger/nilai_leger',$this->data);
	}
	
	public function print()
	{
		// Variabel
		$this->data['cetak_leger'] = '';
		$idkelas = filter($this->uri->segment(4));
		$kelas = $this->Model_users->read_users_by_kelas($idkelas);
        if ($kelas!=false){
            $idusers = $kelas->idusers;
        } else {
            $idusers = 0;
		}

		// Data kelas dan walikelas
		$walikelas = $this->Model_kelas->read_data_by_wali($idusers);
		if ($walikelas!=false){
			$s_kelas = $walikelas->k_romawi;
			$s_keterangan = $walikelas->k_keterangan;
			$s_walikelas = $walikelas->first_name.' '.$walikelas->last_name;
		} else {
			$s_kelas = '';
			$s_keterangan = '';
			$s_walikelas = '';
		}
		$tahun_leger = $this->Model_tahunpelajaran->read_data_by_id($this->session->userdata('tahun'));
		$tahun_explode = explode('-',$tahun_leger['tp_tahun']);
		$p_tahun = $tahun_explode[0];
		$p_semester = $tahun_explode[1];
		$this->data['cetak_leger'] = '<p align="left"><b><u>LEGER NILAI PENGETAHUAN & KETERAMPILAN</u></b>
        <br>
        Kelas : '.$s_kelas.' ('.$s_keterangan.')<br/>Nama Wali : '.$s_walikelas.'<br/>Tahun Pelajaran '.$p_tahun.' (Semester '.$p_semester.')<hr style="border: solid 1px #000; margin-top: -10px"></p>';
		
		// Data mapel
		$mapel = $this->Model_mapel->read_data();
		$total_mapel = $this->Model_mapel->count_all();
		$total_mapel_p_k = 2 * (Integer)$total_mapel;
		if ($mapel!=null){
			$this->data['cetak_leger'] .= '<table class="table table-hover"><tr><td rowspan="2"><center>No</center></td>';
			$this->data['cetak_leger'] .= '<td rowspan="2"><center style="vertical-align:center;">Nama</center></td>';
			foreach ($mapel as $row){
				$this->data['cetak_leger'] .= '<td colspan="2"><center>'.$row->mp_kode.'</center></td>';
			}
			$this->data['cetak_leger'] .= '<td rowspan="2"><center>JUMLAH</center></td>';
			$this->data['cetak_leger'] .= '<td rowspan="2"><center>RATA - RATA</center></td></tr>';
			foreach ($mapel as $row) {
				$this->data['cetak_leger'] .= '<td><center>P</center></td><td><center>K</center></td>';
			}
		}
		
		$siswa = $this->Model_siswa_guru->read_data_by_kelas($idkelas,$this->session->userdata('tahun'),$idusers);
		if ($siswa!=null){
			$total_seluruh_nilai = 0;
			$total_seluruh_siswa = count($siswa);
			$s = 1;
			foreach ($siswa as $row){
				$this->data['cetak_leger'] .= '<tr><td><center>'.$s.'</center></td>';
				$this->data['cetak_leger'] .= '<td>'.$row->s_nama.'</td>';
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

						$this->data['cetak_leger'] .= '<td class="ctr">'.($na_pengetahuan).'</td><td class="ctr">'.($na_keterampilan).'</td>';
					}
					$this->data['cetak_leger'] .= '<td class="ctr">'.($jumlah_np+$jumlah_nk).'</td>';
					$this->data['cetak_leger'] .= '<td class="ctr">'.round((($jumlah_np+$jumlah_nk)/$total_mapel_p_k)).'</td></tr>';
					$total_seluruh_nilai += round((($jumlah_np+$jumlah_nk)/$total_mapel_p_k));
				}
			}
			$total_rata_kelas = ($total_seluruh_nilai/$total_seluruh_siswa);
			$this->data['cetak_leger'] .= '<tr><td class="ctr" colspan="'.($total_mapel_p_k+3).'">TOTAL RATA - RATA</td>';
			$this->data['cetak_leger'] .= '<td class="ctr">'.$total_seluruh_nilai.'</td></tr>';
			$this->data['cetak_leger'] .= '<tr><td class="ctr" colspan="'.($total_mapel_p_k+3).'">RATA - RATA KELAS (TOTAL RATA - RATA / JUMLAH SISWA)</td>';
			$this->data['cetak_leger'] .= '<td class="ctr">'.round($total_rata_kelas).'</td></tr>';
		}

		$this->load->view('administrator/cetak_leger/cetak_leger',$this->data);
	}
}