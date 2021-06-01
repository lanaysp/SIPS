<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Rapor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Ion_auth_model');
		$this->load->model('Model_profile');
        $this->load->model('Model_tahunpelajaran');
        $this->load->model('Model_users');
        
        $this->load->model('Model_siswa');
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
        $this->load->model('Model_kesehatan_siswa');
        $this->load->model('Model_prestasi');
		
        $this->load->library('Template');
        $this->load->library('Ion_auth');
		
        if (!$this->ion_auth->is_admin()){redirect('Auth/login');}
        $this->data['logo_aplikasi']= $this->Model_profile->read_data()->pr_logo;
		$this->data['nama_aplikasi']= $this->Model_profile->read_data()->pr_nama_aplikasi;
		$this->data['ket_aplikasi']= $this->Model_profile->read_data()->pr_ket_aplikasi;
        $this->data['nama_sekolah']= $this->Model_profile->read_data()->pr_nama;
        $this->data['alamat']= $this->Model_profile->read_data()->pr_alamat;
        $this->data['provinsi']= $this->Model_profile->read_data()->province;
        $this->data['kota']= $this->Model_profile->read_data()->city_name;
        $this->data['kecamatan']= $this->Model_profile->read_data()->subdistrict_name;
        // Tahun pelajaran
        $tahun = $this->Model_tahunpelajaran->read_data_by_id($this->session->userdata('tahun'));
		$tahun_explode = explode('-',$tahun['tp_tahun']);
		$p_tahun = $tahun_explode[0];
		$p_semester = $tahun_explode[1];
		$this->data['tahun_pelajaran']= $p_tahun;
		$this->data['semester']= $p_semester;
        $this->data['u_photo'] = $this->Model_users->read_data_by_id($this->session->userdata('user_id'))->u_photo;
    }

    public function sampul()
    {
        $id_decrypt = decrypt_sr(base64_decode($this->uri->segment(4)));
        $siswa = $this->Model_siswa->read_data_by_id($id_decrypt);
        $this->data['siswa'] = $siswa;
        $this->load->view('administrator/cetak_rapor/sampul',$this->data);
    }

    public function biodata()
    {
        $id_decrypt = decrypt_sr(base64_decode($this->uri->segment(4)));
        $siswa = $this->Model_siswa->read_data_by_id($id_decrypt);
        $sekolah = $this->Model_profile->read_data();
        $this->data['siswa'] = $siswa;
        $this->data['sekolah'] = $sekolah;
        $this->load->view('administrator/cetak_rapor/biodata',$this->data);
    }

    public function rapor()
    {
        error_reporting(0);
        $id_decrypt = decrypt_sr(base64_decode($this->uri->segment(4)));
        $siswa = $this->Model_siswa->read_data_by_id($id_decrypt);
        $sekolah = $this->Model_profile->read_data();
        $idkelas = $siswa['idkelas'];
        $idsiswa = $siswa['idsiswa'];

        $kelas = $this->Model_users->read_users_by_kelas($idkelas);
        if ($kelas!=false){
            $idusers = $kelas->idusers;
        } else {
            $idusers = 0;
        }

        $this->data['siswa'] = $siswa;
        $this->data['sekolah'] = $sekolah;

        // Variabel
        $this->data['nilai_pengetahuan_keterampilan'] = '';
        $this->data['nilai_ekstrakurikuler'] = '';
        $this->data['nilai_spiritual'] = '';
        $this->data['nilai_sosial'] = '';
        $this->data['nilai_ekstrakurikuler'] = '';
        $this->data['nilai_kehadiran_sakit'] = '';
        $this->data['nilai_kehadiran_izin'] = '';
        $this->data['nilai_kehadiran_tk'] = '';
        $this->data['nilai_catatan'] = '';
        $this->data['nilai_periodik_berat'] = '';
        $this->data['nilai_periodik_tinggi'] = '';
        $this->data['nilai_kesehatan'] = '';
        $this->data['nilai_prestasi'] = '';
        $this->data['kepala_sekolah'] = $this->Model_profile->read_data()->pr_kepala_sekolah;
        $this->data['kepala_nbmnip'] = $this->Model_profile->read_data()->pr_kepala_nbmnip;
        $this->data['walikelas'] = '';
        $this->data['walikelas_nbmnip'] = '';
        $nomor = 1;
        $nomor_ekstra = 1;
        $nomor_kesehatan = 1;
        $nomor_prestasi = 1;

        // Pengambilan Data dari masing-masing penilaian
        $spiritual_deskripsi = $this->Model_spiritual->read_nsp_deskripsi($this->session->userdata('tahun'),$idusers,$idkelas,$idsiswa);
        $sosial_deskripsi = $this->Model_sosial->read_nso_deskripsi($this->session->userdata('tahun'),$idusers,$idkelas,$idsiswa);
        $ekstra = $this->Model_ekstra_siswa->read_data_by_siswa($idsiswa,$this->session->userdata('tahun'),$idusers);
        $kehadiran = $this->Model_kehadiran->read_data_by_siswa($idsiswa,$this->session->userdata('tahun'),$idusers);
        $catatan = $this->Model_catatan->read_data_by_siswa($idsiswa,$this->session->userdata('tahun'),$idusers);
        $periodik = $this->Model_siswa_guru->read_data_by_siswa($idsiswa,$this->session->userdata('tahun'),$idusers);
        $kesehatan = $this->Model_kesehatan_siswa->read_data_by_siswa($idsiswa,$this->session->userdata('tahun'),$idusers);
        $prestasi = $this->Model_prestasi->read_data_by_siswa($idsiswa,$this->session->userdata('tahun'),$idusers);
        $walikelas = $this->Model_kelas->read_data_by_wali($idusers);

        // Data Wali Kelas
        if ($walikelas!=false){
            $this->data['walikelas'] = $walikelas->first_name.' '.$walikelas->last_name;
            $this->data['walikelas_nbmnip'] = $walikelas->u_nbm_nip;
        }

        // Data Periodik
        if ($periodik!=''){
            $this->data['nilai_periodik_berat'] = $periodik['s_berat_badan'];
            $this->data['nilai_periodik_tinggi'] = $periodik['s_tinggi_badan'];
        }

        // Data Kesehatan
        if ($kesehatan!=false){
            foreach ($kesehatan as $row){
                $this->data['nilai_kesehatan'] .= '
                    <tr>
                        <td class="ctr">'.$nomor_kesehatan.'</td>
                        <td>'.$row->ks_aspek.'</td>
                        <td>'.$row->ks_deskripsi.'</td>
                    </tr>
                ';
                $nomor_kesehatan ++;
            }
        }

        // Data Prestasi
        if ($prestasi!=false){
            foreach ($prestasi as $row){
                $this->data['nilai_prestasi'] .= '
                    <tr>
                        <td class="ctr">'.$nomor_prestasi.'</td>
                        <td>'.$row->p_jenis.'</td>
                        <td>'.$row->p_keterangan.'</td>
                    </tr>
                ';
                $nomor_prestasi ++;
            }
        }

        // Data Deskripsi Spiritual Sosial
        if ($spiritual_deskripsi!=false){
            $this->data['nilai_spiritual'] = $spiritual_deskripsi->nsp_deskripsi;
        }

        if ($sosial_deskripsi!=false){
            $this->data['nilai_sosial'] = $sosial_deskripsi->nso_deskripsi;
        }

        // Data Kehadiran
        if ($kehadiran!=false){
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
        }
        
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

        // Data nilai kelompok A
        $mapel_a = $this->Model_mapel->read_data_a();
        if ($mapel_a!=false){
            $this->data['nilai_pengetahuan_keterampilan'] .= '<tr><td colspan="9"><b>Kelompok A (Wajib)</b></td></tr>';
            foreach ($mapel_a as $m_row){
                $c_kkm = $this->Model_kkm->read_data_by_mapel($m_row->idmata_pelajaran);
                if ($c_kkm!=false){
                    $m_kkm = $c_kkm->k_kkm;
                } else {
                    $m_kkm = '* ..';
                }

                $idmapel = $m_row->idmata_pelajaran;

                $kkm = $this->Model_kkm->read_data_by_mapel($idmapel);
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

                $pengetahuan_deskripsi = $this->Model_pengetahuan->read_all_np_deskripsi($this->session->userdata('tahun'),$idmapel,$idkelas,$idsiswa);
                $keterampilan_deskripsi = $this->Model_keterampilan->read_all_nk_deskripsi($this->session->userdata('tahun'),$idmapel,$idkelas,$idsiswa);
                
                if ($pengetahuan_deskripsi!=false){
                    $pdeskripsi = $pengetahuan_deskripsi->np_deskripsi;
                } else {
                    $pdeskripsi = '';
                }
    
                if ($keterampilan_deskripsi!=false){
                    $kdeskripsi = $keterampilan_deskripsi->nk_deskripsi;
                } else {
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
                        // Mengambil data KKM
                        $kompetensi_dasar = $this->Model_kompetensi->read_data_by_id($row->idkompetensi_dasar);
                        if (!empty($kompetensi_dasar)){
                            $kd_nama = $kompetensi_dasar['kd_nama'];
                        } else {
                            $kd_nama = '##belum ada nama KD##';
                        }
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
                                $kdp_deskripsi .= $kdp_desk.' '.strtolower($kd_nama).'. ';
                            } else {
                                $kdp_deskripsi = '';
                            }
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
                        // Mengambil data KKM
                        $kompetensi_dasar = $this->Model_kompetensi->read_data_by_id($row->idkompetensi_dasar);
                        if (!empty($kompetensi_dasar)){
                            $kd_nama = $kompetensi_dasar['kd_nama'];
                        } else {
                            $kd_nama = '##belum ada nama KD##';
                        }
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
                                $kdk_deskripsi .= $kdk_desk.' '.strtolower($kd_nama).'. ';
                            } else {
                                $kdk_deskripsi = '';
                            }
                            
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
                    $p_predikat = "* ...";
                    $p_deskripsi = "<b>* Interval Predikat Belum diinput! *</b>";
                    $k_predikat = "* ...";
                    $k_deskripsi = "<b> *Interval Predikat Belum diinput! *</b>";
                }
                
            } else {
                $p_predikat = "";
                $p_deskripsi = "<b>* KKM Belum diinput! *</b>";
                $k_predikat = "";
                $k_deskripsi = "<b>* KKM Belum diinput! *</b>";
            }

            if ($rata_kd_p==0 AND $kkm==false){
                $nilai_akhir_pengetahuan = '-';
            } else {
                $nilai_akhir_pengetahuan = $na_pengetahuan;
            }

            if ($rata_kd_k==0 AND $kkm==false){
                $nilai_akhir_keterampilan = '-';
            } else {
                $nilai_akhir_keterampilan = $na_keterampilan;
            }
                
                $this->data['nilai_pengetahuan_keterampilan'] .= '
                    <tr>
                        <td class="ctr" width="3%;">'.$nomor.'</td>
                        <td>'.$m_row->mp_nama.'</td>
                        <td class="ctr">'.$m_kkm.'</td>
                        <td class="ctr">'.$nilai_akhir_pengetahuan.'</td>
                        <td class="ctr">'.$p_predikat.'</td>
                        <td class="font_kecil">'.$p_deskripsi.' '.$kdp_deskripsi.' '.$pdeskripsi.'</td>
                        <td class="ctr">'.$nilai_akhir_keterampilan.'</td>
                        <td class="ctr">'.$k_predikat.'</td>
                        <td class="font_kecil">'.$k_deskripsi.' '.$kdk_deskripsi.' '.$kdeskripsi.'</td>
                    </tr>
                ';
                $nomor ++;
            }
        }

        // Data nilai kelompok B
        $mapel_b = $this->Model_mapel->read_data_b();
        if ($mapel_b!=false){
            $this->data['nilai_pengetahuan_keterampilan'] .= '<tr><td colspan="8"><b>Kelompok B (Muatan)</b></td></tr>';
            foreach ($mapel_b as $m_row){
                $c_kkm = $this->Model_kkm->read_data_by_mapel($m_row->idmata_pelajaran);
                if ($c_kkm!=false){
                    $m_kkm = $c_kkm->k_kkm;
                } else {
                    $m_kkm = '* ..';
                }

                $idmapel = $m_row->idmata_pelajaran;

                $kkm = $this->Model_kkm->read_data_by_mapel($idmapel);
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

                $pengetahuan_deskripsi = $this->Model_pengetahuan->read_all_np_deskripsi($this->session->userdata('tahun'),$idmapel,$idkelas,$idsiswa);
                $keterampilan_deskripsi = $this->Model_keterampilan->read_all_nk_deskripsi($this->session->userdata('tahun'),$idmapel,$idkelas,$idsiswa);
                
                if ($pengetahuan_deskripsi!=false){
                    $pdeskripsi = $pengetahuan_deskripsi->np_deskripsi;
                } else {
                    $pdeskripsi = '';
                }
    
                if ($keterampilan_deskripsi!=false){
                    $kdeskripsi = $keterampilan_deskripsi->nk_deskripsi;
                } else {
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
                        // Mengambil data KKM
                        $kompetensi_dasar = $this->Model_kompetensi->read_data_by_id($row->idkompetensi_dasar);
                        if (!empty($kompetensi_dasar)){
                            $kd_nama = $kompetensi_dasar['kd_nama'];
                        } else {
                            $kd_nama = '##belum ada nama KD##';
                        }
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
                                $kdp_deskripsi .= $kdp_desk.' '.strtolower($kd_nama).'. ';
                            } else {
                                $kdp_deskripsi = '';
                            }
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
                        // Mengambil data KKM
                        $kompetensi_dasar = $this->Model_kompetensi->read_data_by_id($row->idkompetensi_dasar);
                        if (!empty($kompetensi_dasar)){
                            $kd_nama = $kompetensi_dasar['kd_nama'];
                        } else {
                            $kd_nama = '##belum ada nama KD##';
                        }
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
                                $kdk_deskripsi .= $kdk_desk.' '.strtolower($kd_nama).'. ';
                            } else {
                                $kdk_deskripsi = '';
                            }
                            
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
                    $p_predikat = "* ...";
                    $p_deskripsi = "<b>* Interval Predikat Belum diinput! *</b>";
                    $k_predikat = "* ...";
                    $k_deskripsi = "<b> *Interval Predikat Belum diinput! *</b>";
                }
                
            } else {
                $p_predikat = "";
                $p_deskripsi = "<b>* KKM Belum diinput! *</b>";
                $k_predikat = "";
                $k_deskripsi = "<b>* KKM Belum diinput! *</b>";
            }

            if ($rata_kd_p==0 AND $kkm==false){
                $nilai_akhir_pengetahuan = '-';
            } else {
                $nilai_akhir_pengetahuan = $na_pengetahuan;
            }

            if ($rata_kd_k==0 AND $kkm==false){
                $nilai_akhir_keterampilan = '-';
            } else {
                $nilai_akhir_keterampilan = $na_keterampilan;
            }
                
                $this->data['nilai_pengetahuan_keterampilan'] .= '
                    <tr>
                        <td class="ctr" width="3%;">'.$nomor.'</td>
                        <td>'.$m_row->mp_nama.'</td>
                        <td class="ctr">'.$m_kkm.'</td>
                        <td class="ctr">'.$nilai_akhir_pengetahuan.'</td>
                        <td class="ctr">'.$p_predikat.'</td>
                        <td class="font_kecil">'.$p_deskripsi.' '.$kdp_deskripsi.' '.$pdeskripsi.'</td>
                        <td class="ctr">'.$nilai_akhir_keterampilan.'</td>
                        <td class="ctr">'.$k_predikat.'</td>
                        <td class="font_kecil">'.$k_deskripsi.' '.$kdk_deskripsi.' '.$kdeskripsi.'</td>
                    </tr>
                ';
                $nomor ++;
            }
        }

        $this->load->view('administrator/cetak_rapor/rapor',$this->data);
    }
}