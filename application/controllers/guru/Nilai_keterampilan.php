<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Nilai_keterampilan extends CI_Controller
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
        $this->load->model('Model_keterampilan');
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
        $this->template->load('guru/template','guru/nilai_keterampilan/nilai_keterampilan',$this->data);
    }

    public function ajax_list()
	{
		//get_datatables terletak di model
		$idkelas = $this->uri->segment(4);
		$idmapel = $this->uri->segment(5);
        $idkd = $this->uri->segment(6);
        
        $ck_keterampilan = $this->Model_keterampilan->check_data_keterampilan($idkelas,$idmapel,$idkd,$this->session->userdata('tahun'),$this->session->userdata('user_id'));

        if($ck_keterampilan!=true){
            $this->Model_keterampilan->batch_keterampilan($this->session->userdata('tahun'),$this->session->userdata('user_id'),$idkelas,$idmapel,$idkd);
            $this->session->set_userdata('new_batch','Y');
        } 
        // else {
        //     $this->Model_keterampilan->batch_keterampilan_new($this->session->userdata('tahun'),$this->session->userdata('user_id'),$idkelas,$idmapel,$idkd);
        // }

        $list = $this->Model_keterampilan->get_datatables($idkelas,$idmapel,$idkd,$this->session->userdata('tahun'),$this->session->userdata('user_id'));

        $ck_rencana = [
            'idtahun_pelajaran' => filter($this->session->userdata('tahun')),
            'idusers' => filter($this->session->userdata('user_id')),
            'idkelas' => $idkelas,
            'idmata_pelajaran' => $idmapel
        ];
        $rencana = $this->Model_kompetensi->check_rencana_keterampilan($ck_rencana);
        if($rencana == ''){
            $jml_ph = 0;
        } else {
            $jml_ph = $rencana['rkdk_penilaian_harian'];
        }
        
        $data = array();
        $input_nilai = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_keterampilan) {
            $duplikat = $this->Model_keterampilan->check_duplikat_siswa($data_keterampilan->idsiswa,$idkelas,$idmapel,$idkd);
            if ($duplikat){
                $this->Model_keterampilan->delete_old_data($data_keterampilan->idsiswa,$idkelas,$idmapel,$idkd);
            }
            
			$no++;
			$row = array();
			$row[] = $no;
            $row[] = $data_keterampilan->s_nama;
            for ($i = 0; $i<$jml_ph; $i++){
                $explode = explode(",",$data_keterampilan->nk_harian);
                $count = (Integer)count($explode)-1;
                if($count>0 && $jml_ph<=$count){
                    $input_nilai[$i] = ' Nilai '.($i+1).' <input class="col-2" name="nilai_harian[]" id="nilai_harian" type="number" data-id="'.$data_keterampilan->idnilai_keterampilan.'" value="'.$explode[$i].'"/> ';
                } else if($count>0){
                    if (isset($explode[$i])){
                        $input_nilai[$i] = ' Nilai '.($i+1).' <input class="col-2" name="nilai_harian[]" id="nilai_harian" type="number" data-id="'.$data_keterampilan->idnilai_keterampilan.'" value="'.$explode[$i].'"/> ';
                    } else {
                        $input_nilai[$i] = ' Nilai '.($i+1).' <input class="col-2" name="nilai_harian[]" id="nilai_harian" type="number" data-id="'.$data_keterampilan->idnilai_keterampilan.'" value=""/> ';
                    }
                } else {
                    $input_nilai[$i] = ' Nilai '.($i+1).' <input class="col-2" name="nilai_harian[]" id="nilai_harian" type="number" data-id="'.$data_keterampilan->idnilai_keterampilan.'" value=""/> ';
                }
            }
            $row[] = $input_nilai;
            //<center>
            //<a onclick="return delete_data_harian(\''.$data_keterampilan->idnilai_keterampilan.'\',\''.$data_keterampilan->s_nama.'\',\''.$idkelas.'\',\''.$idmapel.'\',\''.$idkd.'\')" class="btn btn-danger btn-sm text-light"><i class="fa fa-window-close"></i></a>
            //</center>

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_keterampilan->count_all($idkelas,$idmapel,$idkd,$this->session->userdata('tahun'),$this->session->userdata('user_id')),
			"recordsFiltered" => $this->Model_keterampilan->count_filtered($idkelas,$idmapel,$idkd,$this->session->userdata('tahun'),$this->session->userdata('user_id')),
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
        
        $ck_rencana = [
            'idtahun_pelajaran' => filter($this->session->userdata('tahun')),
            'idusers' => filter($this->session->userdata('user_id')),
            'idkelas' => $idkelas,
            'idmata_pelajaran' => $idmapel
        ];
        $rencana = $this->Model_kompetensi->check_rencana_keterampilan($ck_rencana);
        $jml_data = $this->Model_keterampilan->count_all($idkelas,$idmapel,$idkd,$this->session->userdata('tahun'),$this->session->userdata('user_id'));
        if($rencana == ''){
            $r['data']['_jumlah_nilai'] = 0;
            $r['data']['_jumlah_data'] = 0;
            $r['data']['new_batch'] = $this->session->userdata('new_batch');
        } else {
            $r['data']['_jumlah_nilai'] = $rencana['rkdk_penilaian_harian'];
            $r['data']['_jumlah_data'] = $jml_data;
            $r['data']['new_batch'] = $this->session->userdata('new_batch');
        }
        
        header('Content-Type: application/json');
        echo json_encode($r);
    }

    public function check_kd() {
        $data = $this->input->post();

        $r['status'] = "";

        $this->data['list_kd'] = $this->Model_kompetensi->list_kd_by_id($this->session->userdata('tahun'),filter($data['idmata_pelajaran']),$this->session->userdata('user_id'),'Keterampilan',filter($data['idkelas']));
		$this->data['list_kd_attribute'] = [
			'name' => 'idkompetensi_dasar',
			'id' => 'idkompetensi_dasar',
			'class' => 'col-lg-10',
			'required' => 'required'
        ];
        $this->load->view('guru/nilai_keterampilan/_kompetensi_dasar',$this->data);
    }

    public function update_nilai()
    {
        $data = $this->input->post();

        $insert = [
            'nk_harian' => filter($data['semua_nilai'])
        ];

        $id = filter($data['idnilai_keterampilan']);

        $this->Model_keterampilan->update_data($insert,$id);
        $this->log_activity($this->session->userdata('nama').' mengupdate nilai harian keterampilan');
    }

    public function reset_harian($idkelas,$idmapel,$idkd) 
    {
        if ($this->Model_keterampilan->reset_data_harian($idkelas,$idmapel,$idkd)){
            $r['status'] = "ok"; 
            $this->log_activity($this->session->userdata('nama').' mereset data nilai harian keterampilan');
        }  
        header('Content-Type: application/json');
        echo json_encode($r);
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
            $check_siswa = [
                'idtahun_pelajaran' => $this->session->userdata('tahun'),
                'idmata_pelajaran' => $idmapel,
                'idusers' => $this->session->userdata('user_id'),
                'idkelas' => $idkelas,
                'idsiswa' => $idsiswa,
                'idkompetensi_dasar' => $idkd
            ];
            if ($this->Model_keterampilan->check_data($check_siswa)){
                $r['status'] = 'ada';
            } else {
                $create = [
                    'idtahun_pelajaran' => $this->session->userdata('tahun'),
                    'idmata_pelajaran' => $idmapel,
                    'idusers' => $this->session->userdata('user_id'),
                    'idkelas' => $idkelas,
                    'idsiswa' => $idsiswa,
                    'idkompetensi_dasar' => $idkd,
                    'nk_harian' => ''
                ];
                $this->Model_keterampilan->create_data($create);
                $r['status'] = 'ok';
                $this->log_activity($this->session->userdata('nama').' menambah 1 data siswa baru ke dalam daftar penilaian harian keterampilan');
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode($r);
    }

    // public function delete_harian($id,$nama) 
    // {
    //     $this->Model_keterampilan->delete_data($id);
    //     $this->log_activity('menghapus data nilai pengetahuan harian siswa '.filter(str_replace('%20',' ',$nama)));
    //     $r['status'] = "ok";
    //     header('Content-Type: application/json');
    //     echo json_encode($r);
    // }

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