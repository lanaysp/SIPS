<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kesehatan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Ion_auth_model');
		$this->load->model('Model_profile');
        $this->load->model('Model_kesehatan');
        $this->load->model('Model_tahunpelajaran');
        $this->load->model('Model_users');
        $this->load->model('Model_activity');
		
        $this->load->library('Template');
        $this->load->library('Ion_auth');
		
        if (!$this->ion_auth->is_admin()){redirect('Auth/login');}
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
    }

    public function index()
    {
        $this->template->load('administrator/template','administrator/kesehatan/kesehatan',$this->data);
    }

    public function ajax_list()
	{
		//get_datatables terletak di model
		$list = $this->Model_kesehatan->get_datatables();
		$data = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_kesehatan) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $data_kesehatan->ks_aspek;
            $row[] = '<a onclick="return edit('.$data_kesehatan->idkesehatan.')" class="btn btn-info btn-sm text-light"><i class="fa fa-edit"></i> Edit</a> 
                      <a onclick="return delete_data(\''.$data_kesehatan->idkesehatan.'\',\''.$data_kesehatan->ks_aspek.'\')" class="btn btn-danger btn-sm text-light"><i class="fa fa-window-close"></i> Hapus</a>';

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_kesehatan->count_all(),
			"recordsFiltered" => $this->Model_kesehatan->count_filtered(),
			"data" => $data
		);
		//output to json format
		echo json_encode($output);
    }
    
    public function edit($id)
    {
        $check = $this->Model_kesehatan->read_data_by_id($id);
        $data = array();
        if(empty($check)){
            $data['data']['idkesehatan'] = "";
            $data['data']['mode'] = "add";
            $data['data']['ks_aspek'] = "";
        } else {
            $data['data'] = $check;
        }
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function save() {
        $data = $this->input->post();

        $r['status'] = "";

        $insert = [
            'ks_aspek' => filter($data['ks_aspek'])
        ];
        $id = $data['_id'];

        if ($this->Model_kesehatan->check_data($insert)){
            return false;
        }

        if ($data['_mode'] == 'add'){
            $this->Model_kesehatan->create_data($insert);
            $r['status'] = "ok";
        } else if ($data['_mode'] == 'edit'){
            $this->Model_kesehatan->update_data($insert,$id);
            $r['status'] = "ok";
        } else {
            $r['status'] = "gagal";
        }
        header('Content-Type: application/json');
        echo json_encode($r);
    }

    public function delete($id,$data) {
        $this->load->model('Model_web_config');
        $this->load->model('Model_delete');
        $data = [
            'idkesehatan' => $id
        ];
		$no_validate = $this->Model_web_config->read_data_no_validate_delete()->config_value;
        if ($no_validate=='0'){
            if ($this->Model_delete->check_data($data,'sr_kesehatan_siswa')){
                $r['status'] = "gagal";
            } else {
                $this->Model_kesehatan->delete_data($id);
                $r['status'] = "ok";
                $this->log_activity($this->session->userdata('nama').' menghapus data kesehatan');
            }
        } else {
            $this->Model_delete->delete_data($data,'sr_kesehatan_siswa');
            $this->Model_delete->delete_data($data,'sr_kesehatan');
            $r['status'] = "ok";
            $this->log_activity($this->session->userdata('nama').' menghapus data kesehatan beserta seluruh data yang terhubung');
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