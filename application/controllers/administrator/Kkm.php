<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kkm extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Ion_auth_model');
		$this->load->model('Model_profile');
		$this->load->model('Model_kkm');
		$this->load->model('Model_kelas');
		$this->load->model('Model_mapel');
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
		$this->data['p_tahun_pelajaran']= $p_tahun.' (Semester '.$p_semester.')';
		$this->data['tahunpelajaran_dipilih']= $this->Model_tahunpelajaran->read_data_by_id($this->session->userdata('tahun'));
        $this->data['u_photo'] = $this->Model_users->read_data_by_id($this->session->userdata('user_id'))->u_photo;
    }

    public function index()
    {
        $this->data['list_kelas'] = $this->Model_kelas->list_kelas();
		$this->data['list_kelas_attribute'] = [
			'name' => 'idkelas',
			'id' => 'idkelas',
			'class' => 'form-control',
			'required' => 'required'
        ];
        $this->data['list_mapel'] = $this->Model_mapel->list_mapel();
		$this->data['list_mapel_attribute'] = [
			'name' => 'idmata_pelajaran',
			'id' => 'idmata_pelajaran',
			'class' => 'form-control',
			'required' => 'required'
		];
        $this->template->load('administrator/template','administrator/kkm/kkm',$this->data);
    }

    public function ajax_list()
	{
		//get_datatables terletak di model
		$list = $this->Model_kkm->get_datatables();
		$data = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_kkm) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $data_kkm->k_romawi.' ('.$data_kkm->k_keterangan.')';
			$row[] = $data_kkm->mp_kode.' '.$data_kkm->mp_nama;
			$row[] = $data_kkm->k_kkm;
            $row[] = '<a onclick="return edit('.$data_kkm->idkkm.')" class="btn btn-info btn-sm text-light"><i class="fa fa-edit"></i> Edit</a> 
                      <a onclick="return delete_data(\''.$data_kkm->idkkm.'\',\''.$data_kkm->mp_nama.'\',\''.$data_kkm->k_romawi.'\')" class="btn btn-danger btn-sm text-light"><i class="fa fa-window-close"></i> Hapus</a>';

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_kkm->count_all(),
			"recordsFiltered" => $this->Model_kkm->count_filtered(),
			"data" => $data
		);
		//output to json format
		echo json_encode($output);
    }
    
    public function edit($id)
    {
        $check = $this->Model_kkm->read_data_by_id($id);
        $data = array();
        if(empty($check)){
            $data['data']['idkkm'] = "";
            $data['data']['mode'] = "add";
            $data['data']['idkelas'] = "";
            $data['data']['idmata_pelajaran'] = "";
            $data['data']['k_kkm'] = "";
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
            'idkelas' => filter($data['idkelas']),
            'idmata_pelajaran' => filter($data['idmata_pelajaran']),
            'k_kkm' => filter($data['k_kkm'])
        ];
        $id = $data['_id'];

        if ($this->Model_kkm->check_data($insert)){
            return false;
        }

        if ($data['_mode'] == 'add'){
            $this->Model_kkm->create_data($insert);
            $r['status'] = "ok";
        } else if ($data['_mode'] == 'edit'){
            $this->Model_kkm->update_data($insert,$id);
            $r['status'] = "ok";
        } else {
            $r['status'] = "gagal";
        }
        header('Content-Type: application/json');
        echo json_encode($r);
    }

    public function delete($id) {
        $this->load->model('Model_web_config');
		$no_validate = $this->Model_web_config->read_data_no_validate_delete()->config_value;
        if ($no_validate=='0'){
            $r['status'] = "gagal";
        } else {
            $this->Model_kkm->delete_data($id);
            $r['status'] = "ok";
        }
        
        header('Content-Type: application/json');
        echo json_encode($r);
    }

}