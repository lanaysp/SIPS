<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kompetensi_dasar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Ion_auth_model');
		$this->load->model('Model_profile');
		$this->load->model('Model_tahunpelajaran');
        $this->load->model('Model_users');
        $this->load->model('Model_activity');
        
        $this->load->model('Model_mapel');
        $this->load->model('Model_kelas');
        $this->load->model('Model_kompetensi');
		
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
			'class' => 'form-control',
			'required' => 'required'
        ];
        $this->data['list_mapel'] = $this->Model_mapel->list_mapel_by_id($this->session->userdata('user_id'));
		$this->data['list_mapel_attribute'] = [
			'name' => 'idmata_pelajaran',
			'id' => 'idmata_pelajaran',
			'class' => 'form-control col-lg-8',
			'required' => 'required'
        ];
        $this->data['list_kategori'] = [
            '' => '- Pilih Kategori -',
            'Pengetahuan' => 'Pengetahuan',
            'Keterampilan' => 'Keterampilan'
        ];
		$this->data['list_kategori_attribute'] = [
			'name' => 'kd_kategori',
			'id' => 'kd_kategori',
			'class' => 'form-control',
			'required' => 'required'
        ];
        $this->template->load('guru/template','guru/kompetensi_dasar/kompetensi_dasar',$this->data);
    }

    public function ajax_list()
	{
		//get_datatables terletak di model
		$idmapel = $this->uri->segment(4);
        $list = $this->Model_kompetensi->get_datatables($idmapel,$this->session->userdata('tahun'),$this->session->userdata('user_id'));
        
		$data = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_kompetensi) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $data_kompetensi->k_tingkat.' ('.$data_kompetensi->k_keterangan.')';
			$row[] = $data_kompetensi->kd_kategori;
			$row[] = $data_kompetensi->kd_kode;
			$row[] = $data_kompetensi->kd_nama;
            $row[] = '<a onclick="return edit('.$data_kompetensi->idkompetensi_dasar.')" class="btn btn-info btn-sm text-light"><i class="fa fa-edit"></i> Edit</a> 
                      <a onclick="return delete_data(\''.$data_kompetensi->idkompetensi_dasar.'\',\''.$data_kompetensi->kd_nama.'\')" class="btn btn-danger btn-sm text-light"><i class="fa fa-window-close"></i> Hapus</a>';

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_kompetensi->count_all($idmapel,$this->session->userdata('tahun'),$this->session->userdata('user_id')),
			"recordsFiltered" => $this->Model_kompetensi->count_filtered($idmapel,$this->session->userdata('tahun'),$this->session->userdata('user_id')),
			"data" => $data
		);
		//output to json format
		echo json_encode($output);
    }

    public function edit($id)
    {
        $check = $this->Model_kompetensi->read_data_by_id($id);
        $data = array();
        if(empty($check)){
            $data['data']['idkompetensi_dasar'] = "";
            $data['data']['mode'] = "add";
            $data['data']['idkelas'] = "";
            $data['data']['kd_kategori'] = "";
            $data['data']['kd_kode'] = "";
            $data['data']['kd_nama'] = "";
        } else {
            $data['data'] = $check;
        }
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function save() {
        $data = $this->input->post();

        $r['status'] = "";

        $check = [
            'idtahun_pelajaran' => filter($this->session->userdata('tahun')),
            'idusers' => filter($this->session->userdata('user_id')),
            'idmata_pelajaran' => filter($data['_idmata_pelajaran']),
            'idkelas' => filter($data['idkelas']),
            'kd_kategori' => filter($data['kd_kategori']),
            'kd_kode' => filter($data['kd_kode']),
            'kd_nama' => filter($data['kd_nama']),
        ];

        $check_exist = [
            'idtahun_pelajaran' => filter($this->session->userdata('tahun')),
            'idmata_pelajaran' => filter($data['_idmata_pelajaran']),
            'idkelas' => filter($data['idkelas'])
        ];

        $insert = [
            'idtahun_pelajaran' => filter($this->session->userdata('tahun')),
            'idusers' => filter($this->session->userdata('user_id')),
            'idmata_pelajaran' => filter($data['_idmata_pelajaran']),
            'idkelas' => filter($data['idkelas']),
            'kd_kategori' => filter($data['kd_kategori']),
            'kd_kode' => filter($data['kd_kode']),
            'kd_nama' => filter($data['kd_nama']),
            'kd_status' => 'N'
        ];
        
        $id = $data['_id'];

        if ($this->Model_kompetensi->check_data($check)){
            return false;
        }

        if ($this->Model_kompetensi->check_exist_data($check_exist)){
            $r['status'] = "exist";
            header('Content-Type: application/json');
            echo json_encode($r);
            return false;
        }

        if ($data['_mode'] == 'add'){
            $this->Model_kompetensi->create_data($insert);
            $this->log_activity($this->session->userdata('nama').' menambah data kompetensi dasar '.filter($data['kd_nama']));
            $r['status'] = "ok";
        } else if ($data['_mode'] == 'edit'){
            $this->Model_kompetensi->update_data($check,$id);
            $this->log_activity($this->session->userdata('nama').' mengubah data kompetensi dasar '.filter($data['kd_nama']));
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
            'idkompetensi_dasar' => $id
        ];
        $no_validate = $this->Model_web_config->read_data_no_validate_delete()->config_value;
        if ($no_validate=='0'){
            if ($this->Model_delete->check_data($data,'sr_nilai_pengetahuan')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_nilai_keterampilan')){
                $r['status'] = "gagal";
            } else {
                $this->Model_kompetensi->delete_data($id);
                $r['status'] = "ok";
                $this->log_activity($this->session->userdata('nama').' menghapus data kompetensi dasar');
            }
        } else {
            $this->Model_delete->delete_data($data,'sr_nilai_pengetahuan');
            $this->Model_delete->delete_data($data,'sr_nilai_keterampilan');
            $this->Model_delete->delete_data($data,'sr_kompetensi_dasar');
            $r['status'] = "ok";
            $this->log_activity($this->session->userdata('nama').' menghapus data kompetensi dasar beserta seluruh data yang terhubung');
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