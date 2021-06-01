<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cetak_rapor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Ion_auth_model');
		$this->load->model('Model_profile');
        $this->load->model('Model_siswa');
        $this->load->model('Model_tahunpelajaran');
        $this->load->model('Model_users');
        $this->load->model('Model_alamat');
        $this->load->model('Model_kelas');
		
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
        // list kelas
        $this->data['list_kelas'] = $this->Model_kelas->list_kelas();
		$this->data['list_kelas_attribute'] = [
			'name' => 'opsi_kelas',
			'id' => 'opsi_kelas',
			'class' => 'form-control col-lg-10',
			'required' => 'required'
        ];
        $this->template->load('administrator/template','administrator/cetak_rapor/cetak_rapor',$this->data);
    }

    public function ajax_list()
	{
		//get_datatables terletak di model
		$idkelas = $this->uri->segment(4);
		if($idkelas==''){
			$list = $this->Model_siswa->get_datatables();
		} else {
			$list = $this->Model_siswa->get_datatables_by_id($idkelas);
		}
		$data = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_siswa) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $data_siswa->s_nama;
			$row[] = $data_siswa->s_nisn;
            $row[] = '
            <a onclick="return sampul(\''.encrypt_sr($data_siswa->idsiswa).'\')" class="btn btn-info btn-sm text-light"><i class="fa fa-print"></i> Sampul</a> 
            <a onclick="return biodata(\''.encrypt_sr($data_siswa->idsiswa).'\')" class="btn btn-primary btn-sm text-light"><i class="fa fa-print"></i> Biodata</a>
            <a onclick="return rapor(\''.encrypt_sr($data_siswa->idsiswa).'\')" class="btn btn-success btn-sm text-light"><i class="fa fa-print"></i> Rapor</a> ';

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_siswa->count_all($idkelas),
			"recordsFiltered" => $this->Model_siswa->count_filtered($idkelas),
			"data" => $data
		);
		//output to json format
		echo json_encode($output);
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