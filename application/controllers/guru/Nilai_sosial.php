<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Nilai_sosial extends CI_Controller
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
        $this->load->model('Model_sosial');
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

        // Untuk menambah data
        $this->data['list_siswa'] = $this->Model_siswa->list_siswa();
		$this->data['list_siswa_attribute'] = [
			'name' => 'list_siswa',
			'id' => 'list_siswa',
			'class' => 'form-control select2bs4',
			'required' => 'required'
        ];
        $this->template->load('guru/template','guru/nilai_sosial/nilai_sosial',$this->data);
    }

    public function ajax_list()
	{
		//get_datatables terletak di model
		$idkelas = $this->uri->segment(4);
        
        $ck_sosial = $this->Model_sosial->check_data_sosial($idkelas,$this->session->userdata('tahun'),$this->session->userdata('user_id'));

        if($ck_sosial!=true){
            $this->Model_sosial->batch_sosial($this->session->userdata('tahun'),$this->session->userdata('user_id'),$idkelas);
            if ($idkelas!=''){
                $this->session->set_userdata('new_batch','Y');
            }
        } 
        // else {
        //     $this->Model_sosial->batch_sosial_new($this->session->userdata('tahun'),$this->session->userdata('user_id'),$idkelas);
        // }

        $list = $this->Model_sosial->get_datatables($idkelas,$this->session->userdata('tahun'),$this->session->userdata('user_id'));

        $ck_rencana = [
            'idtahun_pelajaran' => filter($this->session->userdata('tahun')),
            'idusers' => filter($this->session->userdata('user_id')),
            'idkelas' => $idkelas
        ];
        $rencana = $this->Model_sosial->check_rencana_sosial($ck_rencana);
        if($rencana == ''){
            $jml_penilaian = 0;
            $rbs_so_kd = 0;
        } else {
            $jml_penilaian = $rencana['rbs_so'];
            $rbs_so_kd = $rencana['rbs_so_kd'];
        }
        
        $data = array();
        $input_nilai = array();
        $no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_sosial) {
            $duplikat = $this->Model_sosial->check_duplikat_siswa($data_sosial->idsiswa,$idkelas);
            if ($duplikat){
                $this->Model_sosial->delete_old_data($data_sosial->idsiswa,$idkelas);
            }
			$no++;
			$row = array();
			$row[] = $no;
            $row[] = $data_sosial->s_nama;

            $list_sosial = $this->Model_sosial->list_sosial_by_id($rbs_so_kd);
            $list_sosial_attribute = [
                'name' => 'nilai_sosial[]',
                'id' => 'nilai_sosial[]',
                'class' => 'form-control',
                'required' => 'required',
                'data-id' => $data_sosial->idnilai_sosial
            ];
            $list_sosial_meningkat_attribute = [
                'name' => 'nilai_sosial_meningkat[]',
                'id' => 'nilai_sosial_meningkat',
                'class' => 'form-control',
                'required' => 'required',
                'data-id' => $data_sosial->idnilai_sosial
            ];
            for ($i = 0; $i<$jml_penilaian; $i++){
                $explode = explode(",",$data_sosial->nilai_sosial);
                $count = (Integer)count($explode)-1;

                if($count>0 && $jml_penilaian<=$count){
                    $input_nilai[$i] = form_dropdown('',$list_sosial,$explode[$i],$list_sosial_attribute);
                } else if ($count>0){
                    if (isset($explode[$i])){
                        $input_nilai[$i] = form_dropdown('',$list_sosial,$explode[$i],$list_sosial_attribute);
                    } else {
                        $input_nilai[$i] = form_dropdown('',$list_sosial,'',$list_sosial_attribute);
                    }
                } else {
                    $input_nilai[$i] = form_dropdown('',$list_sosial,'',$list_sosial_attribute);
                }
            }
            $row[] = $input_nilai;

            $row[] = form_dropdown('',$list_sosial,$data_sosial->nilai_sosial_meningkat,$list_sosial_meningkat_attribute);

            $row[] = '<center>
                      <a onclick="return delete_data_harian(\''.$data_sosial->idnilai_sosial.'\',\''.$data_sosial->s_nama.'\',\''.$idkelas.'\')" class="btn btn-danger btn-sm text-light"><i class="fa fa-window-close"></i></a>
                      </center>';

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_sosial->count_all($idkelas,$this->session->userdata('tahun'),$this->session->userdata('user_id')),
			"recordsFiltered" => $this->Model_sosial->count_filtered($idkelas,$this->session->userdata('tahun'),$this->session->userdata('user_id')),
			"data" => $data
		);
		//output to json format
		echo json_encode($output);
    }

    public function jumlah_nilai()
    {
        $idkelas = $this->uri->segment(4);
        
        $ck_rencana = [
            'idtahun_pelajaran' => filter($this->session->userdata('tahun')),
            'idusers' => filter($this->session->userdata('user_id')),
            'idkelas' => $idkelas
        ];
        $rencana = $this->Model_sosial->check_rencana_sosial($ck_rencana);
        $jml_data = $this->Model_sosial->count_all($idkelas,$this->session->userdata('tahun'),$this->session->userdata('user_id'));
        if($rencana == ''){
            $r['data']['_jumlah_nilai'] = 0;
            $r['data']['_jumlah_data'] = 0;
            $r['data']['new_batch'] = $this->session->userdata('new_batch');
        } else {
            $r['data']['_jumlah_nilai'] = $rencana['rbs_so'];
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
        $this->load->view('guru/nilai_sosial/_kompetensi_dasar',$this->data);
    }

    public function update_nilai()
    {
        $data = $this->input->post();

        if ($data['status']=='rutin'){
            $id = filter($data['idnilai_sosial_new']);
            $insert = [
                'nilai_sosial' => filter($data['semua_nilai'])
            ];
        } else if ($data['status']=='meningkat'){
            $id = filter($data['idnilai']);
            $insert = [
                'nilai_sosial_meningkat' => filter($data['nilai'])
            ];
        }
        $this->Model_sosial->update_data($insert,$id);
        $this->log_activity($this->session->userdata('nama').' mengupdate data penilaian sikap sosial');
    }

    public function reset_data($idkelas) 
    {
        if ($this->Model_sosial->reset_data($idkelas)){
            $r['status'] = "ok"; 
            $this->log_activity($this->session->userdata('nama').' mereset data penilaian sikap sosial');
        }  
        header('Content-Type: application/json');
        echo json_encode($r);
    }

    public function add_one_siswa()
    {
        $data = $this->input->post();
        $idkelas = $data['idkelas'];
        $idsiswa = $data['idsiswa'];

        $check_kelas_siswa = $this->Model_siswa->read_data_by_id($idsiswa);
        $kelas_siswa = $check_kelas_siswa['idkelas'];
        if ($kelas_siswa!=$idkelas){
            $r['status'] = 'kelas';
        } else {
            $check_siswa = [
                    'idtahun_pelajaran' => $this->session->userdata('tahun'),
                    'idusers' => $this->session->userdata('user_id'),
                    'idkelas' => $idkelas,
                    'idsiswa' => $idsiswa
            ];
            if ($this->Model_sosial->check_data($check_siswa)){
                $r['status'] = 'ada';
            } else {
                $create = [
                    'idtahun_pelajaran' => $this->session->userdata('tahun'),
                    'idusers' => $this->session->userdata('user_id'),
                    'idkelas' => $idkelas,
                    'idsiswa' => $idsiswa,
                    'nilai_sosial' => '',
                    'nilai_sosial_meningkat' => 0
                ];
                $this->Model_sosial->create_data($create);
                $r['status'] = 'ok';
                $this->log_activity($this->session->userdata('nama').' menambah 1 data siswa baru ke dalam daftar penilaian sikap sosial');
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode($r);
    }

    // public function delete_harian($id,$nama) 
    // {
    //     $this->Model_sosial->delete_data($id);
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