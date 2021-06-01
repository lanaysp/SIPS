<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Rencana_sosial extends CI_Controller
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
        $this->load->model('Model_butirsikap');
		
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
        $this->data['list_ph'] = [
            '' => '- Pilih Jumlah PH -',
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',
            '8' => '8',
            '9' => '9',
            '10' => '10',
        ];
		$this->data['list_ph_attribute'] = [
			'name' => 'jumlah_ph',
			'id' => 'jumlah_ph',
			'class' => 'form-control col-lg-10',
			'required' => 'required'
        ];
        $this->template->load('guru/template','guru/rencana_sosial/rencana_sosial',$this->data);
    }

    public function ajax_list()
	{
		//get_datatables terletak di model
		$idkelas = $this->uri->segment(4);
        $list = $this->Model_butirsikap->get_datatables_sosial($this->session->userdata('tahun'),$this->session->userdata('user_id'),$idkelas);
        
		$data = array();
        $no = $_POST['start'];
        
        $check = [
            'idtahun_pelajaran' => filter($this->session->userdata('tahun')),
            'idusers' => filter($this->session->userdata('user_id')),
            'idkelas' => $idkelas
        ];
        $spiritual = $this->Model_butirsikap->check_rencana_sosial($check);
        
        $explode = explode(',',$spiritual['rbs_so_kd']);
        $count = (Integer)count($explode) -1;
        sort($explode);

		// Membuat loop/ perulangan
		foreach ($list as $data_sosial) {
            $no++;
			$row = array();
			$row[] = $no;
			$row[] = $data_sosial->bs_kategori;
            $row[] = $data_sosial->bs_kode;
            $row[] = $data_sosial->bs_keterangan;
            if($count>0){
                for($i=1;$i<=$count;$i++){
                    $check = $explode[$i];
                    if ($check==$data_sosial->idbutir_sikap){
                        $check = '<center><input type="checkbox" name="kd_status" id="kd_status" value="'.$data_sosial->idbutir_sikap.'" checked></center>';
                    break;
                    } else {
                        $check = '<center><input type="checkbox" name="kd_status" id="kd_status" value="'.$data_sosial->idbutir_sikap.'"></center>';
                    }
                }
            } else {
                $check = '<center><input type="checkbox" name="kd_status" id="kd_status" value="'.$data_sosial->idbutir_sikap.'"></center>';
            }
            $row[] = $check;
            
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_butirsikap->count_all_sosial($this->session->userdata('tahun'),$this->session->userdata('user_id')),
			"recordsFiltered" => $this->Model_butirsikap->count_filtered_sosial($this->session->userdata('tahun'),$this->session->userdata('user_id')),
			"data" => $data
		);
		//output to json format
		echo json_encode($output);
    }

    public function update_rencana_sosial() {
        $data = $this->input->post();
        $r['status'] = "";

        $insert = [
            'rbs_so_kd' => filter($data['idbutir_sikap'])
        ];
        $check_id = $data['idrencana_bs_sosial'];
        if ($check_id==null){
            $id = $this->session->userdata('idrencana_sosial_new');
        } else{
            $id = $check_id;
        }

        $this->Model_butirsikap->update_rencana_sosial($insert,$id);
        $this->log_activity($this->session->userdata('nama').' mengubah status kompetensi dasar yang dipilih ');
        $r['status'] = "ok";

        header('Content-Type: application/json');
        echo json_encode($r);
    }

    public function save() {
        $data = $this->input->post();

        $r['status'] = "";

        $check = [
            'idtahun_pelajaran' => filter($this->session->userdata('tahun')),
            'idusers' => filter($this->session->userdata('user_id')),
            'idkelas' => filter($data['idkelas'])
        ];

        $insert = [
            'idtahun_pelajaran' => filter($this->session->userdata('tahun')),
            'idusers' => filter($this->session->userdata('user_id')),
            'idkelas' => filter($data['idkelas']),
            'rbs_so' => filter($data['jumlah_ph'])
        ];
        $id = $this->Model_butirsikap->check_rencana_sosial($check);

        if ($id != ''){
            $this->Model_butirsikap->update_rencana_sosial($insert,$id['idrencana_bs_sosial']);
            $this->log_activity($this->session->userdata('nama').' mengubah data rencana spiritual');
            $r['status'] = "update";
        } else {
            $this->Model_butirsikap->create_rencana_sosial($insert);
            $this->log_activity($this->session->userdata('nama').' menambah data rencana spiritual');
            $r['status'] = "insert";
        }
        
        header('Content-Type: application/json');
        echo json_encode($r);
    }

    public function check_penilaian() {
        $data = $this->input->post();

        $r['status'] = "";

        $check = [
            'idtahun_pelajaran' => filter($this->session->userdata('tahun')),
            'idusers' => filter($this->session->userdata('user_id')),
            'idkelas' => filter($data['idkelas'])
        ];
        
        $id = $this->Model_butirsikap->check_rencana_sosial($check);

        if ($id != ''){
            $r['status'] = "y";
            $r['data'] = $id;
        } else {
            $r['status'] = "n";
            $r['data']['rbs_so'] = "";
            $r['data']['idrencana_bs_sosial'] = "";
            $r['data']['rbs_so_kd'] = "";
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