<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Log_activity extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Ion_auth_model');
		$this->load->model('Model_profile');
        $this->load->model('Model_activity');
        $this->load->model('Model_tahunpelajaran');
        $this->load->model('Model_users');
		
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
		$this->data['p_tahun_pelajaran'] = $p_tahun.' (Semester '.$p_semester.')';
		$this->data['tahunpelajaran_dipilih'] = $this->Model_tahunpelajaran->read_data_by_id($this->session->userdata('tahun'));
        $this->data['u_photo'] = $this->Model_users->read_data_by_id($this->session->userdata('user_id'))->u_photo;
    }

    public function index()
    {
        $this->template->load('administrator/template','administrator/activity/activity',$this->data);
    }

    public function ajax_list()
	{
		//get_datatables terletak di model
		$list = $this->Model_activity->get_datatables();
		$data = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_activity) {
			$tahun = $this->Model_tahunpelajaran->read_data_by_id($data_activity->idtahun_pelajaran);
			$tahun_explode = explode('-',$tahun['tp_tahun']);
			$p_tahun = $tahun_explode[0];
			$p_semester = $tahun_explode[1];
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $p_tahun.' (Semester '.$p_semester.')';
			$row[] = $data_activity->first_name.' '.$data_activity->last_name;
			$row[] = $data_activity->email;
			$row[] = $data_activity->phone;
			$row[] = $data_activity->activity;
			$row[] = date('d-M-Y / H:i:s',strtotime($data_activity->log_date));
            $row[] = '<a onclick="return delete_data(\''.$data_activity->idlog.'\',\''.$data_activity->first_name.' '.$data_activity->last_name.'\')" class="btn btn-danger btn-sm text-light"><i class="fa fa-window-close"></i> Hapus</a>';

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_activity->count_all(),
			"recordsFiltered" => $this->Model_activity->count_filtered(),
			"data" => $data
		);
		//output to json format
		echo json_encode($output);
    }

    public function delete($id) {
        $this->Model_activity->delete_data($id);
        $r['status'] = "ok";
        header('Content-Type: application/json');
        echo json_encode($r);
	}
	
	public function delete_all() {
        $this->Model_activity->delete_all();
        $r['status'] = "ok";
        header('Content-Type: application/json');
        echo json_encode($r);
    }

}