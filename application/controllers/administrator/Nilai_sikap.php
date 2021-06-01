<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Nilai_sikap extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Ion_auth_model');
		$this->load->model('Model_profile');
        $this->load->model('Model_tahunpelajaran');
        $this->load->model('Model_users');

        $this->load->model('Model_kelas');
        $this->load->model('Model_mapel');
        $this->load->model('Model_siswa_guru');
        $this->load->model('Model_spiritual');
        $this->load->model('Model_sosial');
        $this->load->model('Model_butirsikap');
		
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
        $this->template->load('administrator/template','administrator/nilai_sikap/nilai_sikap',$this->data);
    }

    public function ajax_list()
	{
        //get_datatables terletak di model
        $idkelas = $this->uri->segment(4);
        $kelas = $this->Model_users->read_users_by_kelas($idkelas);
        if ($kelas!=false){
            $idusers = $kelas->idusers;
        } else {
            $idusers = 0;
        }

		//get_datatables terletak di model
        $list = $this->Model_siswa_guru->get_datatables_wali_p($idusers);
        
		$data = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_siswa) {
            
            $spiritual_deskripsi = $this->Model_spiritual->read_nsp_deskripsi($this->session->userdata('tahun'),$idusers,$idkelas,$data_siswa->idsiswa);
            $sosial_deskripsi = $this->Model_sosial->read_nso_deskripsi($this->session->userdata('tahun'),$idusers,$idkelas,$data_siswa->idsiswa);

            if ($spiritual_deskripsi!=false){
                $nsp_deskripsi = $spiritual_deskripsi->nsp_deskripsi;
            } else {
                $nsp_deskripsi = '';
            }

            if ($sosial_deskripsi!=false){
                $nso_deskripsi = $sosial_deskripsi->nso_deskripsi;
            } else {
                $nso_deskripsi = '';
            }

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $data_siswa->s_nama;
			$row[] = $nsp_deskripsi;
            $row[] = $nso_deskripsi;

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_siswa_guru->count_all_wali_p($idkelas),
			"recordsFiltered" => $this->Model_siswa_guru->count_filtered_wali_p($idusers),
			"data" => $data
		);
		//output to json format
		echo json_encode($output);
    }

}