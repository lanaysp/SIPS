<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mata_pelajaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Ion_auth_model');
		$this->load->model('Model_profile');
		$this->load->model('Model_mapel');
        $this->load->model('Model_tahunpelajaran');
        $this->load->model('Model_users');
        $this->load->model('Model_activity');
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
        $this->data['list_kelompok'] = [
			'' => '- Kelompok Mapel -',
			'A' => 'Kelompok A (Wajib)',
			'B' => 'Kelompok B (Muatan)'
		];
		$this->data['list_kelompok_attribute'] = [
			'name' => 'list_kelompok',
			'id' => 'list_kelompok',
			'class' => 'form-control',
			'required' => 'required'
        ];
        $this->template->load('administrator/template','administrator/mata_pelajaran/mata_pelajaran',$this->data);
    }

    public function ajax_list()
	{
		//get_datatables terletak di model
		$list = $this->Model_mapel->get_datatables();
		$data = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_mapel) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $data_mapel->mp_kode;
			$row[] = $data_mapel->mp_nama;
			$row[] = $data_mapel->mp_kelompok;
			$row[] = $data_mapel->mp_urutan;
            $row[] = '<a onclick="return edit('.$data_mapel->idmata_pelajaran.')" class="btn btn-info btn-sm text-light"><i class="fa fa-edit"></i> Edit</a> 
                      <a onclick="return delete_data(\''.$data_mapel->idmata_pelajaran.'\',\''.$data_mapel->mp_nama.'\')" class="btn btn-danger btn-sm text-light"><i class="fa fa-window-close"></i> Hapus</a>';

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_mapel->count_all(),
			"recordsFiltered" => $this->Model_mapel->count_filtered(),
			"data" => $data
		);
		//output to json format
		echo json_encode($output);
    }
    
    public function edit($id)
    {
        $check = $this->Model_mapel->read_data_by_id($id);
        $data = array();
        if(empty($check)){
            $data['data']['idmata_pelajaran'] = "";
            $data['data']['mode'] = "add";
            $data['data']['mp_kode'] = "";
            $data['data']['mp_nama'] = "";
            $data['data']['mp_kelompok'] = "";
            $data['data']['mp_urutan'] = "";
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
            'mp_kode' => filter($data['mp_kode']),
            'mp_nama' => filter($data['mp_nama']),
            'mp_kelompok' => filter($data['list_kelompok']),
            'mp_urutan' => filter($data['mp_urutan'])
        ];
        $id = $data['_id'];

        if ($this->Model_mapel->check_data($insert)){
            return false;
        }

        if ($data['_mode'] == 'add'){
            $this->Model_mapel->create_data($insert);
            $r['status'] = "ok";
        } else if ($data['_mode'] == 'edit'){
            $this->Model_mapel->update_data($insert,$id);
            $r['status'] = "ok";
        } else {
            $r['status'] = "gagal";
        }
        header('Content-Type: application/json');
        echo json_encode($r);
    }

    public function delete($id) {
        $this->load->model('Model_web_config');
        $this->load->model('Model_delete');
        $data = [
            'idmata_pelajaran' => $id
        ];
        $no_validate = $this->Model_web_config->read_data_no_validate_delete()->config_value;
        if ($no_validate=='0'){
            if ($this->Model_delete->check_data($data,'sr_nilai_keterampilan')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_nilai_pengetahuan')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_nilai_pengetahuan_utsuas')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_rencana_kd_pengetahuan')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_rencana_kd_keterampilan')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_kompetensi_dasar')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_kkm')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_mata_pelajaran_guru')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_np_deskripsi')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_nk_deskripsi')){
                $r['status'] = "gagal";
            } else {
                $this->Model_mapel->delete_data($id);
                $r['status'] = "ok";
                $this->log_activity($this->session->userdata('nama').' menghapus data mata pelajaran');
            }
        } else {
            $kkm = $this->Model_kkm->read_data_by_mapel($id);
            if ($kkm!=false){
                $this->Model_delete->delete_data(array('idkkm'=>$kkm->idkkm),'sr_interval_predikat');
            }
            $this->Model_delete->delete_data($data,'sr_nilai_keterampilan');
            $this->Model_delete->delete_data($data,'sr_nilai_pengetahuan');
            $this->Model_delete->delete_data($data,'sr_nilai_pengetahuan_utsuas');
            $this->Model_delete->delete_data($data,'sr_rencana_kd_pengetahuan');
            $this->Model_delete->delete_data($data,'sr_rencana_kd_keterampilan');
            $this->Model_delete->delete_data($data,'sr_mata_pelajaran_guru');
            $this->Model_delete->delete_data($data,'sr_kkm');
            $this->Model_delete->delete_data($data,'sr_nk_deskripsi');
            $this->Model_delete->delete_data($data,'sr_np_deskripsi');
            $this->Model_delete->delete_data($data,'sr_kompetensi_dasar');
            $this->Model_delete->delete_data($data,'sr_mata_pelajaran');
            $r['status'] = "ok";
            $this->log_activity($this->session->userdata('nama').' menghapus data mata pelajaran beserta seluruh data yang terhubung');
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