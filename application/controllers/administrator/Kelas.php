<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Ion_auth_model');
		$this->load->model('Model_profile');
        $this->load->model('Model_kelas');
        $this->load->model('Model_users');
		$this->load->model('Model_tahunpelajaran');
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
        $this->data['list_users'] = $this->Model_users->list_users();
		$this->data['list_users_attribute'] = [
			'name' => 'idusers',
			'id' => 'idusers',
			'class' => 'form-control',
			'required' => 'required'
        ];
        $this->template->load('administrator/template','administrator/kelas/kelas',$this->data);
    }

    public function ajax_list()
	{
		//get_datatables terletak di model
		$list = $this->Model_kelas->get_datatables();
		$data = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_kelas) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $data_kelas->first_name.' '.$data_kelas->last_name;
			$row[] = $data_kelas->k_tingkat;
			$row[] = $data_kelas->k_romawi;
            $row[] = $data_kelas->k_keterangan;
            if ($data_kelas->k_romawi=='LULUS' OR $data_kelas->k_romawi=='PINDAH'){
                $row[] = '<a onclick="return edit('.$data_kelas->idkelas.')" class="btn btn-info btn-sm text-light"><i class="fa fa-edit"></i> Edit</a>';
            } else {
                $row[] = '<a onclick="return edit('.$data_kelas->idkelas.')" class="btn btn-info btn-sm text-light"><i class="fa fa-edit"></i> Edit</a> 
                          <a onclick="return delete_data(\''.$data_kelas->idkelas.'\',\''.$data_kelas->k_keterangan.'\',\''.$data_kelas->first_name.' '.$data_kelas->last_name.'\')" class="btn btn-danger btn-sm text-light"><i class="fa fa-window-close"></i> Hapus</a>';
            }
            

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_kelas->count_all(),
			"recordsFiltered" => $this->Model_kelas->count_filtered(),
			"data" => $data
		);
		//output to json format
		echo json_encode($output);
    }
    
    public function edit($id)
    {
        $check = $this->Model_kelas->read_data_by_id($id);
        $data = array();
        if(empty($check)){
            $data['data']['idkelas'] = "";
            $data['data']['mode'] = "add";
            $data['data']['idusers'] = "";
            $data['data']['k_tingkat'] = "";
            $data['data']['k_romawi'] = "";
            $data['data']['k_keterangan'] = "";
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
            'idusers' => filter($data['idusers']),
            'k_tingkat' => filter($data['k_tingkat']),
            'k_romawi' => filter(strtoupper($data['k_romawi'])),
            'k_keterangan' => filter(ucwords($data['k_keterangan']))
        ];
        $id = $data['_id'];

        if ($this->Model_kelas->check_data($insert)){
            return false;
        }

        if ($data['_mode'] == 'add'){
            $this->Model_kelas->create_data($insert);
            $r['status'] = "ok";
        } else if ($data['_mode'] == 'edit'){
            $this->Model_kelas->update_data($insert,$id);
            $r['status'] = "ok";
        } else {
            $r['status'] = "gagal";
        }
        header('Content-Type: application/json');
        echo json_encode($r);
    }

    public function delete($id) {
        $this->load->model('Model_delete');
        $this->load->model('Model_web_config');
        $data = [
            'idkelas' => $id
        ];
        $no_validate = $this->Model_web_config->read_data_no_validate_delete()->config_value;
        if ($no_validate=='0'){
            if ($this->Model_delete->check_data($data,'sr_siswa_guru')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_kelas_guru')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_siswa')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_kompetensi_dasar')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_kkm')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_nilai_keterampilan')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_nilai_pengetahuan')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_nilai_pengetahuan_utsuas')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_nilai_sosial')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_nilai_spiritual')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_nk_deskripsi')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_np_deskripsi')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_nso_deskripsi')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_nsp_deskripsi')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_rencana_bs_spiritual')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_rencana_bs_sosial')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_rencana_kd_pengetahuan')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_rencana_kd_keterampilan')){
                $r['status'] = "gagal";
            } else {
                $this->Model_delete->delete_data($data,'sr_kelas');
                $r['status'] = "ok";
                $this->log_activity($this->session->userdata('nama').' menghapus data kelas');
            }
        } else if ($no_validate=='1'){
            $this->load->model('Model_kkm');
            $this->load->model('Model_siswa');
            $kkm = $this->Model_kkm->read_data_by_kelas($data);
            foreach ($kkm as $row){
                $kkm_data = [
                    'idkkm' => $row->idkkm
                ];
                $this->Model_delete->delete_data($kkm_data,'sr_interval_predikat');
            }
            $siswa = $this->Model_siswa->read_data_by_kelas($data);
            foreach ($siswa as $row){
                $siswa_data = [
                    'idsiswa' => $row->idsiswa
                ];
                $this->Model_delete->delete_data($siswa_data,'sr_catatan');
                $this->Model_delete->delete_data($siswa_data,'sr_ekstra_siswa');
                $this->Model_delete->delete_data($siswa_data,'sr_kehadiran');
                $this->Model_delete->delete_data($siswa_data,'sr_kesehatan_siswa');
                $this->Model_delete->delete_data($siswa_data,'sr_prestasi');
            }
            $this->Model_delete->delete_data($data,'sr_np_deskripsi');//
            $this->Model_delete->delete_data($data,'sr_nk_deskripsi');//
            $this->Model_delete->delete_data($data,'sr_nsp_deskripsi');//
            $this->Model_delete->delete_data($data,'sr_nso_deskripsi');//
            $this->Model_delete->delete_data($data,'sr_nilai_spiritual');//
            $this->Model_delete->delete_data($data,'sr_nilai_sosial');//
            $this->Model_delete->delete_data($data,'sr_nilai_pengetahuan');//
            $this->Model_delete->delete_data($data,'sr_nilai_pengetahuan_utsuas');//
            $this->Model_delete->delete_data($data,'sr_nilai_keterampilan');//
            $this->Model_delete->delete_data($data,'sr_rencana_kd_keterampilan');//
            $this->Model_delete->delete_data($data,'sr_rencana_kd_pengetahuan');//
            $this->Model_delete->delete_data($data,'sr_rencana_bs_sosial');//
            $this->Model_delete->delete_data($data,'sr_rencana_bs_spiritual');//
            $this->Model_delete->delete_data($data,'sr_kkm');//
            $this->Model_delete->delete_data($data,'sr_kompetensi_dasar');//
            $this->Model_delete->delete_data($data,'sr_kelas_guru');//
            $this->Model_delete->delete_data($data,'sr_siswa_guru');//
            $this->Model_delete->delete_data($data,'sr_siswa');//
            $this->Model_delete->delete_data($data,'sr_kelas');//
            $r['status'] = "ok";
            $this->log_activity($this->session->userdata('nama').' menghapus data kelas beserta seluruh data yang terhubung');
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