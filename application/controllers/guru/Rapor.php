<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Rapor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Ion_auth_model');
		$this->load->model('Model_profile');
		$this->load->model('Model_alamat');
		$this->load->model('Model_tahunpelajaran');
		$this->load->model('Model_users');
        $this->load->model('Model_siswa_guru');
        
        $this->load->model('Model_mapel');
        $this->load->model('Model_kkm');
        $this->load->model('Model_pengetahuan');
        $this->load->model('Model_pengetahuan_utsuas');
        $this->load->model('Model_keterampilan');
        $this->load->model('Model_kompetensi');
        $this->load->model('Model_interval');
        $this->load->model('Model_kelas');
        $this->load->model('Model_spiritual');
        $this->load->model('Model_sosial');
        $this->load->model('Model_butirsikap');
        $this->load->model('Model_ekstra_siswa');
        $this->load->model('Model_kehadiran');
        $this->load->model('Model_catatan');
		
        $this->load->library('Template');
        $this->load->library('Ion_auth');
		
        if (!$this->ion_auth->is_guru()){redirect('Auth/login');}
        $this->data['logo_aplikasi']= $this->Model_profile->read_data()->pr_logo;
		$this->data['nama_aplikasi']= $this->Model_profile->read_data()->pr_nama_aplikasi;
		$this->data['ket_aplikasi']= $this->Model_profile->read_data()->pr_ket_aplikasi;
        $this->data['nama']= $this->Model_profile->read_data()->pr_nama;
		$this->data['p_tahun_pelajaran']= $this->Model_profile->read_data()->tp_tahun;
		$this->data['tahunpelajaran_aplikasi']= $this->Model_tahunpelajaran->read_data_by_id($this->session->userdata('tahun'));
        $this->data['u_photo'] = $this->Model_users->read_data_by_id($this->session->userdata('user_id'))->u_photo;
    }

    public function print($ids)
    {
        $id = decrypt_sr(base64_decode($ids));
        // Variabel
        $this->data['nilai_pengetahuan_keterampilan'] = '';
        $this->data['nilai_ekstrakurikuler'] = '';
        $this->data['nilai_spiritual'] = '';
        $this->data['nilai_sosial'] = '';
        $this->data['nilai_spiritual_meningkat'] = '';
        $this->data['nilai_sosial_meningkat'] = '';
        $this->data['nilai_ekstrakurikuler'] = '';
        $this->data['nilai_kehadiran_sakit'] = '';
        $this->data['nilai_kehadiran_izin'] = '';
        $this->data['nilai_kehadiran_tk'] = '';
        $this->data['nilai_catatan'] = '';
        $this->data['nilai_periodik'] = '';
        $this->data['nilai_kesehatan'] = '';
        $this->data['nilai_prestasi'] = '';
        $this->data['kepala_sekolah'] = $this->Model_profile->read_data()->pr_kepala_sekolah;
        $this->data['kepala_nbmnip'] = $this->Model_profile->read_data()->pr_kepala_nbmnip;
        $this->data['walikelas'] = '';
        $this->data['walikelas_nbmnip'] = '';
        $nomor = 1;
        $nomor_ekstra = 1;

        // Data sekolah
		$this->data['idprofile']= $this->Model_profile->read_data()->idprofile;
		$this->data['nama_sekolah']= $this->Model_profile->read_data()->pr_nama;
		$this->data['tahun_pelajaran']= $this->Model_profile->read_data()->tp_tahun;
		$this->data['alamat']= $this->Model_profile->read_data()->pr_alamat;
		$this->data['provinsi']= $this->Model_profile->read_data()->province;
		$this->data['kota']= $this->Model_profile->read_data()->city_name;
		$this->data['kecamatan']= $this->Model_profile->read_data()->subdistrict_name;
		$this->data['kodepos']= $this->Model_profile->read_data()->pr_kodepos;
		$this->data['telepon']= $this->Model_profile->read_data()->pr_telepon;
        $this->data['email']= $this->Model_profile->read_data()->pr_email;

        // Data siswa
        $siswa = $this->Model_siswa_guru->read_data_by_siswa($id,$this->session->userdata('tahun'),$this->session->userdata('user_id'));
        $this->data['siswa'] = $siswa;

        // Pengambilan Data dari masing-masing penilaian
        $spiritual = $this->Model_spiritual->read_data_by_siswa($id,$this->session->userdata('tahun'),$this->session->userdata('user_id'));
        $sosial = $this->Model_sosial->read_data_by_siswa($id,$this->session->userdata('tahun'),$this->session->userdata('user_id'));
        $ekstra = $this->Model_ekstra_siswa->read_data_by_siswa($id,$this->session->userdata('tahun'),$this->session->userdata('user_id'));
        $kehadiran = $this->Model_kehadiran->read_data_by_siswa($id,$this->session->userdata('tahun'),$this->session->userdata('user_id'));
        $catatan = $this->Model_catatan->read_data_by_siswa($id,$this->session->userdata('tahun'),$this->session->userdata('user_id'));
        $walikelas = $this->Model_kelas->read_data_by_wali($this->session->userdata('user_id'));

        // Data Wali Kelas
        if ($walikelas!=false){
            $this->data['walikelas'] = $walikelas->first_name.' '.$walikelas->last_name;
            $this->data['walikelas_nbmnip'] = $walikelas->u_nbm_nip;
        }

        // Data Deskripsi Spiritual Sosial
        if ($spiritual!=false){
            $sp_explode = explode(",",$spiritual->nilai_spiritual);
            $sp_count = (Integer)count($sp_explode)-1;
            for ($i=0; $i<$sp_count; $i++)
            {
                if ($i!=($sp_count-1)){
                    $dot = ',';
                } else {
                    $dot = '';
                }
                $this->data['nilai_spiritual'] .= strtolower($this->Model_butirsikap->read_data_by_id($sp_explode[$i])['bs_keterangan'].''.$dot.' ');
                $this->data['nilai_spiritual_meningkat'] = strtolower($this->Model_butirsikap->read_data_by_id($spiritual->nilai_spiritual_meningkat)['bs_keterangan']);
            }
        }

        if ($sosial!=false){
            $so_explode = explode(",",$sosial->nilai_sosial);
            $so_count = (Integer)count($so_explode)-1;
            for ($i=0; $i<$so_count; $i++)
            {
                if ($i!=($so_count-1)){
                    $dot = ',';
                } else {
                    $dot = '';
                }
                $this->data['nilai_sosial'] .= strtolower($this->Model_butirsikap->read_data_by_id($so_explode[$i])['bs_keterangan'].''.$dot.' ');
                $this->data['nilai_sosiall_meningkat'] = strtolower($this->Model_butirsikap->read_data_by_id($sosial->nilai_sosial_meningkat)['bs_keterangan']);
            }
        }

        // Data Kehadiran
        if ($kehadiran->kh_sakit==0){
            $sakit = '-';
        } else {
            $sakit = $kehadiran->kh_sakit;
        }
        if ($kehadiran->kh_izin==0){
            $izin = '-';
        } else {
            $izin = $kehadiran->kh_izin;
        }
        if ($kehadiran->kh_tanpa_keterangan==0){
            $tk = '-';
        } else {
            $tk = $kehadiran->kh_tanpa_keterangan;
        }
        $this->data['nilai_kehadiran_sakit'] = $sakit;
        $this->data['nilai_kehadiran_izin'] = $izin;
        $this->data['nilai_kehadiran_tk'] = $tk;

        // Data Ekstrakurikuler
        if ($ekstra!=false){
            foreach ($ekstra as $row){
                $this->data['nilai_ekstrakurikuler'] .= '
                    <tr>
                        <td class="ctr">'.$nomor_ekstra.'</td>
                        <td>'.$row->e_nama.'</td>
                        <td><center>'.$row->es_nilai.'</center></td>
                        <td>'.$row->es_deskripsi.'</td>
                    </tr>
                ';
                $nomor_ekstra ++;
            }
        }

        // Data Catatan
        if ($catatan!=false){
            $this->data['nilai_catatan'] = $catatan->catatan;
        } else {
            $this->data['nilai_catatan'] = '-';
        }

        // Data nilai
        $mapel = $this->Model_mapel->read_data();
        if ($mapel!=false){
            foreach ($mapel as $m_row){
                $c_kkm = $this->Model_kkm->read_data_by_mapel($m_row->idmata_pelajaran);
                if ($c_kkm!=false){
                    $m_kkm = $c_kkm->k_kkm;
                } else {
                    $m_kkm = '-';
                }
                $kelas = $this->Model_kelas->check_kelas($this->session->userdata('user_id'));
                if ($kelas!=false){
                    $idkelas = $kelas->idkelas;
                } else {
                    $idkelas = '';
                }
                $idmapel = $m_row->idmata_pelajaran;

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

                // Pemanggilan data tiap siswa terhadap nilai pengetahuan dan keterampilan
                $pengetahuan = $this->Model_pengetahuan->read_data_siswa($id,$idkelas,$idmapel,$this->session->userdata('tahun'),$this->session->userdata('user_id'));
                $pengetahuan_utsuas = $this->Model_pengetahuan_utsuas->read_data_siswa($id,$idkelas,$idmapel,$this->session->userdata('tahun'),$this->session->userdata('user_id'));
                $keterampilan = $this->Model_keterampilan->read_data_siswa($id,$idkelas,$idmapel,$this->session->userdata('tahun'),$this->session->userdata('user_id'));
                $pengetahuan_deskripsi = $this->Model_pengetahuan->read_np_deskripsi($this->session->userdata('tahun'),$idmapel,$this->session->userdata('user_id'),$idkelas,$id);
                $keterampilan_deskripsi = $this->Model_keterampilan->read_nk_deskripsi($this->session->userdata('tahun'),$idmapel,$this->session->userdata('user_id'),$idkelas,$id);
                
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
                            if (isset($p_explode[$i])){
                                $p_nilai = $p_explode[$i];
                            } else {
                                $p_nilai = 0;
                            }
                            $total_kd = $total_kd + (Integer)$p_nilai;
                        }
                        $total_rata_kd = $total_kd/$rp_loop;
                        // Mengambil data KKM
                        $kompetensi_dasar = $this->Model_kompetensi->read_data_by_id($row->idkompetensi_dasar);
                        if ($kkm!=false)
                        {
                            $interval = $this->Model_interval->read_data_by_kkm($kkm->idkkm);
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
                            $kdp_deskripsi .= $kdp_desk.' '.strtolower($kompetensi_dasar['kd_nama']).'. ';
                        }
                        $total_kd_np = $total_kd_np + $total_rata_kd;
                        $total_kd = 0;
                    }
                    $rata_kd_p = $total_kd_np / $kd;  
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
                            if (isset($k_explode[$i])){
                                $k_nilai = $k_explode[$i];
                            } else {
                                $k_nilai = 0;
                            }
                            $total_kd_k = $total_kd_k + (Integer)$k_nilai;
                        }
                        $total_rata_kd_k = $total_kd_k/$rk_loop;
                        // Mengambil data KKM
                        $kompetensi_dasar = $this->Model_kompetensi->read_data_by_id($row->idkompetensi_dasar);
                        if ($kkm!=false)
                        {
                            $interval = $this->Model_interval->read_data_by_kkm($kkm->idkkm);
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
                            $kdk_deskripsi .= $kdk_desk.' '.strtolower($kompetensi_dasar['kd_nama']).'. ';
                        }
                        $total_kd_nk = $total_kd_nk + $total_rata_kd_k;
                        $total_kd_k = 0;
                    }
                    $rata_kd_k = $total_kd_nk / $kd_k;  
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
                } else {
                    $p_predikat = "Error !";
                    $p_deskripsi = "Perhitungan salah !";
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
                $p_predikat = "-";
                $p_deskripsi = "";
                $k_predikat = "-";
                $k_deskripsi = "";
            }

                $this->data['nilai_pengetahuan_keterampilan'] .= '
                    <tr>
                        <td class="ctr" width="3%;">'.$nomor.'</td>
                        <td>'.$m_row->mp_nama.'</td>
                        <td class="ctr">'.$m_kkm.'</td>
                        <td class="ctr">'.$na_pengetahuan.'</td>
                        <td class="ctr">'.$p_predikat.'</td>
                        <td class="font_kecil">'.$p_deskripsi.' '.$kdp_deskripsi.' '.$pdeskripsi.'</td>
                        <td class="ctr">'.$na_keterampilan.'</td>
                        <td class="ctr">'.$k_predikat.'</td>
                        <td class="font_kecil">'.$k_deskripsi.' '.$kdk_deskripsi.' '.$kdeskripsi.'</td>
                    </tr>
                ';
                $nomor ++;
            }
        }
        
        $this->load->view('guru/rapor/rapor',$this->data);
    }
}