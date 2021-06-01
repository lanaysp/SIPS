<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Nilai_pengetahuan extends CI_Controller
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
        $this->load->model('Model_kompetensi');
        $this->load->model('Model_pengetahuan');
        $this->load->model('Model_pengetahuan_utsuas');
        $this->load->model('Model_siswa');
		
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
        $this->data['list_kd'] = [
            '' => '- Pilih Penilaian -'
        ];
		$this->data['list_kd_attribute'] = [
			'name' => 'idkompetensi_dasar',
			'id' => 'idkompetensi_dasar',
			'class' => 'form-control col-lg-10',
			'required' => 'required'
        ];
        // Untuk menambah data
        $this->data['list_siswa'] = $this->Model_siswa->list_siswa();
		$this->data['list_siswa_attribute'] = [
			'name' => 'list_siswa',
			'id' => 'list_siswa',
			'class' => 'form-control select2bs4',
			'required' => 'required'
        ];
        $this->template->load('guru/template','guru/nilai_pengetahuan/nilai_pengetahuan',$this->data);
    }

    public function ajax_list()
	{
		//get_datatables terletak di model
		$idkelas = $this->uri->segment(4);
		$idmapel = $this->uri->segment(5);
        $idkd = $this->uri->segment(6);
        
        $ck_pengetahuan = $this->Model_pengetahuan->check_data_pengetahuan($idkelas,$idmapel,$idkd,$this->session->userdata('tahun'),$this->session->userdata('user_id'));

        if($ck_pengetahuan!=true){
            $this->Model_pengetahuan->batch_pengetahuan($this->session->userdata('tahun'),$this->session->userdata('user_id'),$idkelas,$idmapel,$idkd);
            $this->session->set_userdata('new_batch','Y');
        } 
        // else {
        //     $this->Model_pengetahuan->batch_pengetahuan_new($this->session->userdata('tahun'),$this->session->userdata('user_id'),$idkelas,$idmapel,$idkd);
        // }

        $list = $this->Model_pengetahuan->get_datatables($idkelas,$idmapel,$idkd,$this->session->userdata('tahun'),$this->session->userdata('user_id'));

        $ck_rencana = [
            'idtahun_pelajaran' => filter($this->session->userdata('tahun')),
            'idusers' => filter($this->session->userdata('user_id')),
            'idkelas' => $idkelas,
            'idmata_pelajaran' => $idmapel
        ];
        $rencana = $this->Model_kompetensi->check_rencana_pengetahuan($ck_rencana);
        if($rencana == ''){
            $jml_ph = 0;
        } else {
            $jml_ph = $rencana['rkdp_penilaian_harian'];
        }
        
        $data = array();
        $input_nilai = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_pengetahuan) {
            $duplikat = $this->Model_pengetahuan->check_duplikat_siswa($data_pengetahuan->idsiswa,$idkelas,$idmapel,$idkd);
            if ($duplikat){
                $this->Model_pengetahuan->delete_old_data($data_pengetahuan->idsiswa,$idkelas,$idmapel,$idkd);
            }

			$no++;
			$row = array();
			$row[] = $no;
            $row[] = $data_pengetahuan->s_nama;
            for ($i = 0; $i<$jml_ph; $i++){
                $explode = explode(",",$data_pengetahuan->np_harian);
                $count = (Integer)count($explode)-1;
                if($count>0 && $jml_ph<=$count){
                    $input_nilai[$i] = ' Nilai '.($i+1).' <input class="col-2" name="nilai_harian[]" id="nilai_harian" type="number" data-id="'.$data_pengetahuan->idnilai_pengetahuan.'" value="'.$explode[$i].'"/> ';
                } else if($count>0){
                    if (isset($explode[$i])){
                        $input_nilai[$i] = ' Nilai '.($i+1).' <input class="col-2" name="nilai_harian[]" id="nilai_harian" type="number" data-id="'.$data_pengetahuan->idnilai_pengetahuan.'" value="'.$explode[$i].'"/> ';
                    } else {
                        $input_nilai[$i] = ' Nilai '.($i+1).' <input class="col-2" name="nilai_harian[]" id="nilai_harian" type="number" data-id="'.$data_pengetahuan->idnilai_pengetahuan.'" value=""/> ';
                    }
                } else {
                    $input_nilai[$i] = ' Nilai '.($i+1).' <input class="col-2" name="nilai_harian[]" id="nilai_harian" type="number" data-id="'.$data_pengetahuan->idnilai_pengetahuan.'" value=""/> ';
                }
            }
            $row[] = $input_nilai;
            //<center>
            //<a onclick="return delete_data_harian(\''.$data_pengetahuan->idnilai_pengetahuan.'\',\''.$data_pengetahuan->idsiswa.'\',\''.$data_pengetahuan->s_nama.'\',\''.$idkelas.'\',\''.$idmapel.'\',\''.$idkd.'\')" class="btn btn-danger btn-sm text-light"><i class="fa fa-window-close"></i></a>
            //</center>

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_pengetahuan->count_all($idkelas,$idmapel,$idkd,$this->session->userdata('tahun'),$this->session->userdata('user_id')),
			"recordsFiltered" => $this->Model_pengetahuan->count_filtered($idkelas,$idmapel,$idkd,$this->session->userdata('tahun'),$this->session->userdata('user_id')),
			"data" => $data
		);
		//output to json format
		echo json_encode($output);
    }

    public function ajax_list_uts_uas()
	{
		//get_datatables terletak di model
		$idkelas = $this->uri->segment(4);
        $idmapel = $this->uri->segment(5);

        $ck_utsuas = $this->Model_pengetahuan_utsuas->check_data_pengetahuan($idkelas,$idmapel,$this->session->userdata('tahun'),$this->session->userdata('user_id'));

        if($ck_utsuas!=true){
            $this->Model_pengetahuan_utsuas->batch_pengetahuan($this->session->userdata('tahun'),$this->session->userdata('user_id'),$idkelas,$idmapel);
            $this->session->set_userdata('new_batch','Y');
        } 
        // else {
        //     $this->Model_pengetahuan_utsuas->batch_pengetahuan_new($this->session->userdata('tahun'),$this->session->userdata('user_id'),$idkelas,$idmapel);
        // }

        $list = $this->Model_pengetahuan_utsuas->get_datatables($idkelas,$idmapel,$this->session->userdata('tahun'),$this->session->userdata('user_id'));
        
        $data = array();
        $input_nilai = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_pengetahuan) {
            $duplikat = $this->Model_pengetahuan_utsuas->check_duplikat_siswa_utsuas($data_pengetahuan->idsiswa,$idkelas,$idmapel);
            if ($duplikat==true){
                $this->Model_pengetahuan_utsuas->delete_old_data($data_pengetahuan->idsiswa,$idkelas,$idmapel);
            }
			$no++;
			$row = array();
			$row[] = $no;
            $row[] = $data_pengetahuan->s_nama;
			$row[] = '<input class="col-3" name="nilai_uts[]" id="nilai_uts" type="number" data-id="'.$data_pengetahuan->idnp_utsuas.'" value="'.$data_pengetahuan->np_uts.'"/>';
			$row[] = '<input class="col-3" name="nilai_uas[]" id="nilai_uas" type="number" value="'.$data_pengetahuan->np_uas.'"/>';
            //<center>
            //<a onclick="return delete_data_utsuas(\''.$data_pengetahuan->idnp_utsuas.'\',\''.$data_pengetahuan->s_nama.'\',\''.$idkelas.'\',\''.$idmapel.'\')" class="btn btn-danger btn-sm text-light"><i class="fa fa-window-close"></i></a>
            //</center>

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_pengetahuan_utsuas->count_all($idkelas,$idmapel,$this->session->userdata('tahun'),$this->session->userdata('user_id')),
			"recordsFiltered" => $this->Model_pengetahuan_utsuas->count_filtered($idkelas,$idmapel,$this->session->userdata('tahun'),$this->session->userdata('user_id')),
			"data" => $data
		);
		//output to json format
		echo json_encode($output);
    }

    public function jumlah_nilai()
    {
        $idkelas = $this->uri->segment(4);
        $idmapel = $this->uri->segment(5);
        $idkd = $this->uri->segment(6);
        
        if ($idkd=='utsuas'){
            $jml_data = $this->Model_pengetahuan_utsuas->count_all($idkelas,$idmapel,$this->session->userdata('tahun'),$this->session->userdata('user_id'));
            $r['data']['_jumlah_nilai'] = 2;
            $r['data']['_jumlah_data'] = $jml_data;
            $r['data']['new_batch'] = $this->session->userdata('new_batch');
        } else {
            $ck_rencana = [
                'idtahun_pelajaran' => filter($this->session->userdata('tahun')),
                'idusers' => filter($this->session->userdata('user_id')),
                'idkelas' => $idkelas,
                'idmata_pelajaran' => $idmapel
            ];
            $rencana = $this->Model_kompetensi->check_rencana_pengetahuan($ck_rencana);
            $jml_data = $this->Model_pengetahuan->count_all($idkelas,$idmapel,$idkd,$this->session->userdata('tahun'),$this->session->userdata('user_id'));
            if($rencana == ''){
                $r['data']['_jumlah_nilai'] = 0;
                $r['data']['_jumlah_data'] = 0;
                $r['data']['new_batch'] = $this->session->userdata('new_batch');
            } else {
                $r['data']['_jumlah_nilai'] = $rencana['rkdp_penilaian_harian'];
                $r['data']['_jumlah_data'] = $jml_data;
                $r['data']['new_batch'] = $this->session->userdata('new_batch');
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode($r);
    }

    public function check_kd() {
        $data = $this->input->post();

        $r['status'] = "";

        $this->data['list_kd'] = $this->Model_kompetensi->list_kd_by_id($this->session->userdata('tahun'),filter($data['idmata_pelajaran']),$this->session->userdata('user_id'),'Pengetahuan',filter($data['idkelas']));
		$this->data['list_kd_attribute'] = [
			'name' => 'idkompetensi_dasar',
			'id' => 'idkompetensi_dasar',
			'class' => 'col-lg-10',
			'required' => 'required'
        ];
        $this->load->view('guru/nilai_pengetahuan/_kompetensi_dasar',$this->data);
    }

    public function update_nilai()
    {
        $data = $this->input->post();

        $insert = [
            'np_harian' => filter($data['semua_nilai'])
        ];

        $id = filter($data['idnilai_pengetahuan']);

        $this->Model_pengetahuan->update_data($insert,$id);
        $this->log_activity($this->session->userdata('nama').' mengupdate nilai harian pengetahuan');
    }

    public function update_nilai_utsuas()
    {
        $data = $this->input->post();

        $insert = [
            'np_uts' => filter($data['n_uts']),
            'np_uas' => filter($data['n_uas'])
        ];

        $id = filter($data['idnp_utsuas_loop']);

        $this->Model_pengetahuan_utsuas->update_data($insert,$id);
        $this->log_activity($this->session->userdata('nama').' mengupdate nilai UTS UAS pengetahuan');
    }

    public function add_one_siswa()
    {
        $data = $this->input->post();
        $idmapel = $data['idmata_pelajaran'];
        $idkelas = $data['idkelas'];
        $idsiswa = $data['idsiswa'];
        $idkd = $data['idkompetensi_dasar'];

        $check_kelas_siswa = $this->Model_siswa->read_data_by_id($idsiswa);
        $kelas_siswa = $check_kelas_siswa['idkelas'];
        if ($kelas_siswa!=$idkelas){
            $r['status'] = 'kelas';
        } else {
            if ($idkd=='utsuas'){
                $check_siswa = [
                    'idtahun_pelajaran' => $this->session->userdata('tahun'),
                    'idmata_pelajaran' => $idmapel,
                    'idusers' => $this->session->userdata('user_id'),
                    'idkelas' => $idkelas,
                    'idsiswa' => $idsiswa
                ];
                if ($this->Model_pengetahuan_utsuas->check_data($check_siswa)){
                    $r['status'] = 'ada';
                } else {
                    $create = [
                        'idtahun_pelajaran' => $this->session->userdata('tahun'),
                        'idmata_pelajaran' => $idmapel,
                        'idusers' => $this->session->userdata('user_id'),
                        'idkelas' => $idkelas,
                        'idsiswa' => $idsiswa,
                        'np_uts' => 0,
                        'np_uas' => 0,
                    ];
                    $this->Model_pengetahuan_utsuas->create_data($create);
                    $r['status'] = 'ok';
                    $this->log_activity($this->session->userdata('nama').' menambah 1 data siswa baru ke dalam daftar penilaian UTS UAS pengetahuan');
                }
            } else {
                $check_siswa = [
                        'idtahun_pelajaran' => $this->session->userdata('tahun'),
                        'idmata_pelajaran' => $idmapel,
                        'idusers' => $this->session->userdata('user_id'),
                        'idkelas' => $idkelas,
                        'idsiswa' => $idsiswa,
                        'idkompetensi_dasar' => $idkd
                ];
                if ($this->Model_pengetahuan->check_data($check_siswa)){
                    $r['status'] = 'ada';
                } else {
                    $create = [
                        'idtahun_pelajaran' => $this->session->userdata('tahun'),
                        'idmata_pelajaran' => $idmapel,
                        'idusers' => $this->session->userdata('user_id'),
                        'idkelas' => $idkelas,
                        'idsiswa' => $idsiswa,
                        'idkompetensi_dasar' => $idkd,
                        'np_harian' => ''
                    ];
                    $this->Model_pengetahuan->create_data($create);
                    $r['status'] = 'ok';
                    $this->log_activity($this->session->userdata('nama').' menambah 1 data siswa baru ke dalam daftar penilaian harian pengetahuan');
                }
                
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode($r);
    }

    // public function delete_harian($id,$nama,$idsiswa,$idkelas,$idmapel,$idkd) 
    // {
    //     $duplikat = $this->Model_pengetahuan->check_duplikat_siswa($idsiswa,$idkelas,$idmapel,$idkd);
    //     if ($duplikat){
    //         $this->Model_pengetahuan->delete_old_data($idsiswa);
    //     } else {
    //         $this->Model_pengetahuan->delete_data($id);
    //     }
    //     $this->log_activity('menghapus data nilai pengetahuan harian siswa '.filter(str_replace('%20',' ',$nama))); 
    //     $r['status'] = "ok";   
    //     header('Content-Type: application/json');
    //     echo json_encode($r);
    // }

    // public function delete_utsuas($id,$nama) 
    // {
    //     $this->Model_pengetahuan_utsuas->delete_data($id);
    //     $this->log_activity('menghapus data nilai pengetahuan UTS / UAS siswa '.filter(str_replace('%20',' ',$nama)));
    //     $r['status'] = "ok";
    //     header('Content-Type: application/json');
    //     echo json_encode($r);
    // }

    public function reset_harian($idkelas,$idmapel,$idkd) 
    {
        if ($this->Model_pengetahuan->reset_data_harian($idkelas,$idmapel,$idkd)){
            $r['status'] = "ok"; 
            $this->log_activity($this->session->userdata('nama').' mereset data nilai harian pengetahuan');
        }  
        header('Content-Type: application/json');
        echo json_encode($r);
    }

    public function reset_utsuas($idkelas,$idmapel) 
    {
        if ($this->Model_pengetahuan_utsuas->reset_data_utsuas($idkelas,$idmapel)){
            $r['status'] = "ok"; 
            $this->log_activity($this->session->userdata('nama').' mereset data nilai UTS UAS pengetahuan');
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