<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Deskripsi_sikap extends CI_Controller
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
        $this->load->model('Model_spiritual');
        $this->load->model('Model_sosial');
        $this->load->model('Model_butirsikap');
		
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
        $kelas = $this->Model_kelas->check_kelas($this->session->userdata('user_id'));
        if ($kelas!=false){
            $this->data['kelas'] = '( '.$kelas->k_romawi.' )';
        } else {
            $this->data['kelas'] = '';
        }
        $this->template->load('walikelas/template','walikelas/deskripsi_sikap/deskripsi_sikap',$this->data);
    }

    public function ajax_list()
    {
        //get_datatables terletak di model
		$list = $this->Model_siswa_guru->get_datatables_wali_p($this->session->userdata('user_id'));
        $siswa = $this->Model_kelas->check_kelas($this->session->userdata('user_id'));
        if ($siswa!=false){
            $idkelas = $siswa->idkelas;
        } else {
            $idkelas = '';
        }
		$data = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_siswa) {
            // Variabel Lama
            //$nilai_spiritual = '';
            //$nilai_spiritual_meningkat = '';
            //$nilai_sosial = '';
            //$nilai_sosial_meningkat = '';

            $all_id_spiritual = '';
            $all_id_sosial = '';
            $all_id_spiritual_meningkat = '';
            $all_id_sosial_meningkat = '';

            $sp_sort = '';
            $so_sort = '';
            $sp_meningkat_sort = '';
            $so_meningkat_sort = '';

            // $duplicate = array();
            // $duplicate_str = '';
            // $final_duplicate = array();

            $nilai_spiritual = array();
            $sp_butirsikap = array();
            $sp_duplicate = '';

            $nilai_sp_generate = array();
            $sp_generate = '';

            $nilai_sp_meningkat_generate = array();
            $sp_meningkat_generate = '';

            $nilai_so_generate = array();
            $so_generate = '';

            $nilai_so_meningkat_generate = array();
            $so_meningkat_generate = '';

            $nilai_spiritual_meningkat = array();
            $sp_meningkat_butirsikap = array();
            $sp_meningkat_duplicate = '';

            $final_auto_generate_spiritual = '';
            $final_auto_generate_sosial = '';

            $nilai_sosial = array();
            $so_butirsikap = array();
            $so_duplicate = '';

            $nilai_sosial_meningkat = array();
            $so_meningkat_butirsikap = array();
            $so_meningkat_duplicate = '';
            
            $spiritual = $this->Model_spiritual->read_all_data($data_siswa->idsiswa,$this->session->userdata('tahun'));
            $sosial = $this->Model_sosial->read_all_data($data_siswa->idsiswa,$this->session->userdata('tahun'));
            $spiritual_deskripsi = $this->Model_spiritual->read_nsp_deskripsi($this->session->userdata('tahun'),$this->session->userdata('user_id'),$idkelas,$data_siswa->idsiswa);
            $sosial_deskripsi = $this->Model_sosial->read_nso_deskripsi($this->session->userdata('tahun'),$this->session->userdata('user_id'),$idkelas,$data_siswa->idsiswa);

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
                    $sp_sort .= $sp_explode[$i].' ';
                    
                    $check_sp_butirsikap = $this->Model_butirsikap->read_data_by_id($sp_explode[$i]);
                    if ($check_sp_butirsikap!=null){
                        $sp_butirsikap[] = $check_sp_butirsikap['bs_keterangan'];
                        //$sp_butirsikap = '<i class="fas fa-arrow-alt-circle-right"></i> '.$check_sp_butirsikap['bs_keterangan'].' <br/>';
                        // $duplicate[] = $check_sp_butirsikap['bs_keterangan'];
                    } else {
                        continue;
                    }
                    //$nilai_spiritual .= $sp_butirsikap;
                }

                // $array_count = array_count_values($duplicate);
                // foreach($array_count as $key => $val) {
                //     $duplicate_str .= '<i class="fas fa-arrow-alt-circle-right"></i> '.$key.' ['.$val.']<br/>';
                // }
                // $final_duplicate = $duplicate_str;

                $sp_array_count = array_count_values($sp_butirsikap);
                foreach($sp_array_count as $key => $val) {
                    $sp_duplicate .= '<i class="fas fa-arrow-alt-circle-right"></i> '.$key.' [Poin: '.$val.']<br/>';
                    $sp_generate .= $key.'['.$val.'], ';
                }
                $nilai_spiritual = $sp_duplicate;
                $nilai_sp_generate = 'Selalu dilakukan '.$sp_generate;

                $sp_meningkat_explode = explode(',',$all_id_spiritual_meningkat);
                sort($sp_meningkat_explode);
                $sp_meningkat_count = (Integer)count($sp_meningkat_explode)-1;

                for ($i=0;$i<=$sp_meningkat_count;$i++){
                    $sp_meningkat_sort .= $sp_meningkat_explode[$i].' ';
                    
                    $check_sp_butirsikap_meningkat = $this->Model_butirsikap->read_data_by_id($sp_meningkat_explode[$i]);
                    if ($check_sp_butirsikap_meningkat!=null){
                        $sp_meningkat_butirsikap[] = $check_sp_butirsikap_meningkat['bs_keterangan'];
                    } else {
                        continue;
                    }
                    //$nilai_spiritual_meningkat .= $sp_meningkat_butirsikap;
                }
                $sp_meningkat_array_count = array_count_values($sp_meningkat_butirsikap);
                foreach($sp_meningkat_array_count as $key => $val) {
                    $sp_meningkat_duplicate .= '<i class="fas fa-arrow-alt-circle-right"></i> '.$key.' [Poin: '.$val.']<br/>';
                    $sp_meningkat_generate .= $key.'['.$val.'], ';
                }
                $nilai_spiritual_meningkat = $sp_meningkat_duplicate;
                $nilai_sp_meningkat_generate = 'Meningkat pada sikap '.$sp_meningkat_generate;
                //$nilai_spiritual = $all_id_spiritual.' | '.$sp_count.' | '.$sp_sort;

                $final_auto_generate_spiritual = $nilai_sp_generate.$nilai_sp_meningkat_generate;
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
                    $so_sort .= $so_explode[$i].' ';
                    
                    $check_so_butirsikap = $this->Model_butirsikap->read_data_by_id($so_explode[$i]);
                    if ($check_so_butirsikap!=null){
                        $so_butirsikap[] = $check_so_butirsikap['bs_keterangan'];
                        //$so_butirsikap = '<i class="fas fa-arrow-alt-circle-right"></i> '.$check_so_butirsikap['bs_keterangan'].' <br/>';
                    } else {
                        continue;
                        //$so_butirsikap = '';
                    }
                    //$nilai_sosial .= $so_butirsikap;
                }

                $so_array_count = array_count_values($so_butirsikap);
                foreach($so_array_count as $key => $val) {
                    $so_duplicate .= '<i class="fas fa-arrow-alt-circle-right"></i> '.$key.' [Poin: '.$val.']<br/>';
                    $so_generate .= $key.'['.$val.'], ';
                }
                $nilai_sosial = $so_duplicate;
                $nilai_so_generate = 'Selalu dilakukan '.$so_generate;

                $so_meningkat_explode = explode(',',$all_id_sosial_meningkat);
                sort($so_meningkat_explode);
                $so_meningkat_count = (Integer)count($so_meningkat_explode)-1;

                for ($i=0;$i<=$so_meningkat_count;$i++){
                    $so_meningkat_sort .= $so_meningkat_explode[$i].' ';
                    
                    $check_so_butirsikap_meningkat = $this->Model_butirsikap->read_data_by_id($so_meningkat_explode[$i]);
                    if ($check_so_butirsikap_meningkat!=null){
                        $so_meningkat_butirsikap[] = $check_so_butirsikap_meningkat['bs_keterangan'];
                    } else {
                        continue;
                    }
                    //$nilai_sosial_meningkat .= $so_meningkat_butirsikap;
                }
                $so_meningkat_array_count = array_count_values($so_meningkat_butirsikap);
                foreach($so_meningkat_array_count as $key => $val) {
                    $so_meningkat_duplicate .= '<i class="fas fa-arrow-alt-circle-right"></i> '.$key.' [Poin: '.$val.']<br/>';
                    $so_meningkat_generate .= $key.'['.$val.'], ';
                }
                $nilai_sosial_meningkat = $so_meningkat_duplicate;
                $nilai_so_meningkat_generate = 'Meningkat pada sikap '.$so_meningkat_generate;
                //$nilai_spiritual = $all_id_spiritual.' | '.$sp_count.' | '.$sp_sort;
                $final_auto_generate_sosial = $nilai_so_generate.$nilai_so_meningkat_generate;
            }

            if ($spiritual_deskripsi!=false){
                $idnsp_deskripsi = $spiritual_deskripsi->idnsp_deskripsi;
                $nsp_deskripsi = $spiritual_deskripsi->nsp_deskripsi;
            } else {
                $idnsp_deskripsi = '';
                $nsp_deskripsi = '';
            }

            if ($sosial_deskripsi!=false){
                $idnso_deskripsi = $sosial_deskripsi->idnso_deskripsi;
                $nso_deskripsi = $sosial_deskripsi->nso_deskripsi;
            } else {
                $idnso_deskripsi = '';
                $nso_deskripsi = '';
            }

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $data_siswa->s_nama.'<br/><a onClick="return show_chart(\''.$data_siswa->idsiswa.'\',\''.$data_siswa->s_nama.'\',\''.$data_siswa->idkelas.'\');" class="btn-sm btn-success text-light">Grafik Nilai</a>';
			$row[] = $nilai_spiritual;
			$row[] = $nilai_spiritual_meningkat;
			$row[] = $nsp_deskripsi.' <a onClick="return edit_deskripsi(\''.$idnsp_deskripsi.'\',\''.$nsp_deskripsi.'\',\''.$data_siswa->idsiswa.'\',\'spiritual\',\''.$data_siswa->s_nama.'\',\''.$data_siswa->idkelas.'\',\''.$final_auto_generate_spiritual.'\');" class="btn btn-sm"><i class="fa fa-edit text-primary"></i></a> <div id="edit_p_deskripsi"></div>';
			$row[] = $nilai_sosial;
			$row[] = $nilai_sosial_meningkat;
            $row[] = $nso_deskripsi.' <a onClick="return edit_deskripsi(\''.$idnso_deskripsi.'\',\''.$nso_deskripsi.'\',\''.$data_siswa->idsiswa.'\',\'sosial\',\''.$data_siswa->s_nama.'\',\''.$data_siswa->idkelas.'\',\''.$final_auto_generate_sosial.'\');" class="btn btn-sm"><i class="fa fa-edit text-primary"></i></a> <div id="edit_p_deskripsi"></div>';

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_siswa_guru->count_all_wali_p($idkelas),
			"recordsFiltered" => $this->Model_siswa_guru->count_filtered_wali_p($this->session->userdata('user_id')),
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
        $idsiswa = filter($data['idsiswa']);
        $s_nama = filter($data['snama']);
        $idkelas = filter($data['idkelas']);

        $all_id_spiritual = '';
        $all_id_sosial = '';
        $all_id_spiritual_meningkat = '';
        $all_id_sosial_meningkat = '';
        $sp_sort = '';
        $so_sort = '';
        $sp_meningkat_sort = '';
        $so_meningkat_sort = '';
        $nilai_spiritual = array();
        $sp_butirsikap = array();
        $sp_duplicate = '';
        $nilai_spiritual_meningkat = array();
        $sp_meningkat_butirsikap = array();
        $sp_meningkat_duplicate = '';
        $nilai_sosial = array();
        $so_butirsikap = array();
        $so_duplicate = '';
        $nilai_sosial_meningkat = array();
        $so_meningkat_butirsikap = array();
        $so_meningkat_duplicate = '';

        $sp_duplicate_name = '';
        $sp_duplicate_value = '';
        $sp_meningkat_duplicate_name = '';
        $sp_meningkat_duplicate_value = '';
        $so_duplicate_name = '';
        $so_duplicate_value = '';
        $so_meningkat_duplicate_name = '';
        $so_meningkat_duplicate_value = '';

        $this->data['butirsikap_nama_spiritual'] = '';
        $this->data['butirsikap_nilai_spiritual'] = '';
        $this->data['butirsikap_nama_spiritual_meningkat'] = '';
        $this->data['butirsikap_nilai_spiritual_meningkat'] = '';
        $this->data['butirsikap_nama_sosial'] = '';
        $this->data['butirsikap_nilai_sosial'] = '';
        $this->data['butirsikap_nama_sosial_meningkat'] = '';
        $this->data['butirsikap_nilai_sosial_meningkat'] = '';
        $this->data['s_nama'] = $s_nama;
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
                $sp_sort .= $sp_explode[$i].' ';
                
                $check_sp_butirsikap = $this->Model_butirsikap->read_data_by_id($sp_explode[$i]);
                if ($check_sp_butirsikap!=null){
                    $sp_butirsikap[] = $check_sp_butirsikap['bs_keterangan'];
                } else {
                    continue;
                }
            }
            $sp_array_count = array_count_values($sp_butirsikap);
            foreach($sp_array_count as $key => $val) {
                $sp_duplicate_name .= "'$key'". ", ";
                $sp_duplicate_value .= "$val". ", ";
            }
            $this->data['butirsikap_nama_spiritual'] = $sp_duplicate_name;
            $this->data['butirsikap_nilai_spiritual'] = $sp_duplicate_value;

            $sp_meningkat_explode = explode(',',$all_id_spiritual_meningkat);
            sort($sp_meningkat_explode);
            $sp_meningkat_count = (Integer)count($sp_meningkat_explode)-1;
            for ($i=0;$i<=$sp_meningkat_count;$i++){
                $sp_meningkat_sort .= $sp_meningkat_explode[$i].' ';
                
                $check_sp_butirsikap_meningkat = $this->Model_butirsikap->read_data_by_id($sp_meningkat_explode[$i]);
                if ($check_sp_butirsikap_meningkat!=null){
                    $sp_meningkat_butirsikap[] = $check_sp_butirsikap_meningkat['bs_keterangan'];
                } else {
                    continue;
                }
            }
            $sp_meningkat_array_count = array_count_values($sp_meningkat_butirsikap);
            foreach($sp_meningkat_array_count as $key => $val) {
                $sp_meningkat_duplicate_name .= "'$key'". ", ";
                $sp_meningkat_duplicate_value .= "$val". ", ";
            }
            $this->data['butirsikap_nama_spiritual_meningkat'] = $sp_meningkat_duplicate_name;
            $this->data['butirsikap_nilai_spiritual_meningkat'] = $sp_meningkat_duplicate_value;
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
                $so_sort .= $so_explode[$i].' ';
                
                $check_so_butirsikap = $this->Model_butirsikap->read_data_by_id($so_explode[$i]);
                if ($check_so_butirsikap!=null){
                    $so_butirsikap[] = $check_so_butirsikap['bs_keterangan'];
                } else {
                    continue;
                }
            }
            $so_array_count = array_count_values($so_butirsikap);
            foreach($so_array_count as $key => $val) {
                $so_duplicate_name .= "'$key'". ", ";
                $so_duplicate_value .= "$val". ", ";
            }
            $this->data['butirsikap_nama_sosial'] = $so_duplicate_name;
            $this->data['butirsikap_nilai_sosial'] = $so_duplicate_value;

            $so_meningkat_explode = explode(',',$all_id_sosial_meningkat);
            sort($so_meningkat_explode);
            $so_meningkat_count = (Integer)count($so_meningkat_explode)-1;
            for ($i=0;$i<=$so_meningkat_count;$i++){
                $so_meningkat_sort .= $so_meningkat_explode[$i].' ';
                
                $check_so_butirsikap_meningkat = $this->Model_butirsikap->read_data_by_id($so_meningkat_explode[$i]);
                if ($check_so_butirsikap_meningkat!=null){
                    $so_meningkat_butirsikap[] = $check_so_butirsikap_meningkat['bs_keterangan'];
                } else {
                    continue;
                }
            }
            $so_meningkat_array_count = array_count_values($so_meningkat_butirsikap);
            foreach($so_meningkat_array_count as $key => $val) {
                $so_meningkat_duplicate_name .= "'$key'". ", ";
                $so_meningkat_duplicate_value .= "$val". ", ";
            }
            $this->data['butirsikap_nama_sosial_meningkat'] = $so_meningkat_duplicate_name;
            $this->data['butirsikap_nilai_sosial_meningkat'] = $so_meningkat_duplicate_value;
        }
        $this->load->view('walikelas/deskripsi_sikap/deskripsi_sikap_chart',$this->data);
    }
    
    public function update_deskripsi()
    {
        $data = $this->input->post();
        $kelas = $this->Model_kelas->check_kelas($this->session->userdata('user_id'));
        if ($kelas!=false){
            $idkelas = $kelas->idkelas;
        } else {
            $idkelas = '';
        }
        if ($data['tipe_deskripsi']=='spiritual')
        {
            $deskripsi = preg_replace('/;+/', ';',preg_replace( "/\r|\n/", "", $this->input->post('deskripsi',true)));
            $update = [
                'idtahun_pelajaran' => $this->session->userdata('tahun'),
                'idusers' => $this->session->userdata('user_id'),
                'idkelas' => $idkelas,
                'idsiswa' => filter($data['idsiswa']),
                'nsp_deskripsi' =>  str_replace(array(";","'"),'',$deskripsi)
            ];
            $id = $data['iddeskripsi'];
            if ($id==''){
                $this->Model_spiritual->create_nsp_deskripsi($update);
            } else {
                $this->Model_spiritual->update_nsp_deskripsi($update,$id);
            }
            $r['status'] = "ok";
            $this->log_activity($this->session->userdata('nama').' mengelola data deskripsi sikap spiritual rapor siswa');
        } else if ($data['tipe_deskripsi']=='sosial'){
            $deskripsi = preg_replace('/;+/', ';',preg_replace( "/\r|\n/", "", $this->input->post('deskripsi',true)));
            $update = [
                'idtahun_pelajaran' => $this->session->userdata('tahun'),
                'idusers' => $this->session->userdata('user_id'),
                'idkelas' => $idkelas,
                'idsiswa' => filter($data['idsiswa']),
                'nso_deskripsi' => str_replace(array(";","'"),'',$deskripsi)
            ];
            $id = $data['iddeskripsi'];
            if ($id==''){
                $this->Model_sosial->create_nso_deskripsi($update);
            } else {
                $this->Model_sosial->update_nso_deskripsi($update,$id);
            }
            $r['status'] = "ok";
            $this->log_activity($this->session->userdata('nama').' mengelola data deskripsi sikap sosial rapor siswa');
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