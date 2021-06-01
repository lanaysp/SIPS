<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Interval_predikat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Ion_auth_model');
		$this->load->model('Model_profile');
        $this->load->model('Model_interval');
		$this->load->model('Model_tahunpelajaran');
        $this->load->model('Model_users');
        $this->load->model('Model_kelas');
        $this->load->model('Model_kkm');
		
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
        $this->data['edit_kkm'] = $this->Model_kkm->list_kkm();
		$this->data['edit_kkm_attr'] = [
			'name' => 'kkm',
			'id' => 'kkm',
			'class' => 'form-control',
			'required' => 'required'
		];
        $this->template->load('administrator/template','administrator/interval_predikat/interval_predikat',$this->data);
    }

    public function ajax_list()
	{
		//get_datatables terletak di model
		$list = $this->Model_interval->get_datatables();
		$data = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_interval) {
            $interval = number_format((100 - $data_interval->k_kkm)/3,2);
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $data_interval->k_tingkat.' ('.$data_interval->k_keterangan.')';
			$row[] = '('.$data_interval->mp_kode.') '.$data_interval->mp_nama;
			$row[] = $data_interval->k_kkm;
			$row[] = $interval.' => antara '.floor($interval).' atau '.ceil($interval);
			$row[] = $data_interval->amin.' - '.$data_interval->amax;
			$row[] = $data_interval->bmin.' - '.$data_interval->bmax;
			$row[] = $data_interval->cmin.' - '.$data_interval->cmax;
			$row[] = $data_interval->dmin.' - '.$data_interval->dmax;
            $row[] = '<a onclick="return edit('.$data_interval->idinterval_predikat.')" class="btn btn-info btn-sm text-light"><i class="fa fa-edit"></i> Edit</a> 
                      <a onclick="return delete_data(\''.$data_interval->idinterval_predikat.'\',\''.$data_interval->mp_nama.'\',\''.$data_interval->k_keterangan.'\')" class="btn btn-danger btn-sm text-light"><i class="fa fa-window-close"></i> Hapus</a>';

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_interval->count_all(),
			"recordsFiltered" => $this->Model_interval->count_filtered(),
			"data" => $data
		);
		//output to json format
		echo json_encode($output);
    }

    public function read_interval()
    {
        $kkm = $this->Model_kkm->read_data_by_id($this->uri->segment(4));
        if($kkm==''){
            return false;
        }
        $nilai_kkm = $kkm['k_kkm'];
        $interval = (100 - $nilai_kkm)/3;
        $this->data['interval'] = $interval;
        $this->load->view('administrator/interval_predikat/interval_result',$this->data);
    }
    
    public function edit($id)
    {
        $check = $this->Model_interval->read_data_by_id($id);
        $data = array();
        if(empty($check)){
            $data['data']['idinterval_predikat'] = "";
            $data['data']['mode'] = "add";
            $data['data']['kkm'] = "";
            $data['data']['amax'] = "";
            $data['data']['bmax'] = "";
            $data['data']['cmax'] = "";
            $data['data']['dmax'] = "";
            $data['data']['amin'] = "";
            $data['data']['bmin'] = "";
            $data['data']['cmin'] = "";
            $data['data']['dmin'] = "";
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
            'idkkm' => filter($data['kkm']),
            'amax' => filter($data['amax']),
            'bmax' => filter($data['bmax']),
            'cmax' => filter($data['cmax']),
            'dmax' => filter($data['dmax']),
            'amin' => filter($data['amin']),
            'bmin' => filter($data['bmin']),
            'cmin' => filter($data['cmin']),
            'dmin' => filter($data['dmin']),
        ];
        $id = $data['_id'];

        if ($this->Model_interval->check_data($insert)){
            return false;
        }

        if ($data['_mode'] == 'add'){
            $this->Model_interval->create_data($insert);
            $r['status'] = "ok";
        } else if ($data['_mode'] == 'edit'){
            $this->Model_interval->update_data($insert,$id);
            $r['status'] = "ok";
        } else {
            $r['status'] = "gagal";
        }
        header('Content-Type: application/json');
        echo json_encode($r);
    }

    public function delete($id) {
        $this->Model_interval->delete_data($id);
        $r['status'] = "ok";
        header('Content-Type: application/json');
        echo json_encode($r);
    }

}