<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Ion_auth_model');
		$this->load->model('Model_profile');
		$this->load->model('Model_alamat');
		$this->load->model('Model_tahunpelajaran');
		$this->load->model('Model_users');
		$this->load->model('Model_siswa');
		
        $this->load->library('Template');
        $this->load->library('Ion_auth');
        $this->load->library('Form_validation');
		
		if (!$this->ion_auth->is_guru()){redirect('Auth/login');}
		// Data Aplikasi
		$this->data['logo_aplikasi']= $this->Model_profile->read_data()->pr_logo;
		$this->data['nama_aplikasi']= $this->Model_profile->read_data()->pr_nama_aplikasi;
		$this->data['ket_aplikasi']= $this->Model_profile->read_data()->pr_ket_aplikasi;
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
		// Data sekolah
		$sekolah = $this->Model_profile->read_data();
		$this->data['idprofile']= $sekolah->idprofile;
		$this->data['nama']= $sekolah->pr_nama;
		$this->data['tahun_pelajaran']= $sekolah->tp_tahun;
		$this->data['alamat']= $sekolah->pr_alamat;
		$this->data['provinsi']= $sekolah->province;
		$this->data['kota']= $sekolah->city_name;
		$this->data['kecamatan']= $sekolah->subdistrict_name;
		$this->data['kodepos']= $sekolah->pr_kodepos;
		$this->data['telepon']= $sekolah->pr_telepon;
		$this->data['email']= $sekolah->pr_email;
		// Data Detail
		$this->data['npsn']= $sekolah->pr_npsn;
		$this->data['status']= $sekolah->pr_status;
		$this->data['bentuk_pendidikan']= $sekolah->pr_bentuk_pendidikan;
		$this->data['status_kepemilikan']= $sekolah->pr_status_kepemilikan;
		$this->data['sk_pendirian']= $sekolah->pr_sk_pendirian;
		$this->data['tanggal_sk_pendirian']= $sekolah->pr_tanggal_sk_pendirian;
		$this->data['sk_izin']= $sekolah->pr_sk_izin;
		$this->data['tanggal_sk_izin']= $sekolah->pr_tanggal_sk_izin;

		$mapel = $this->Model_users->read_mapel_by_id($this->session->userdata('user_id'));
		$kelas = $this->Model_users->read_kelas_by_id($this->session->userdata('user_id'));
		$mapel_data = '';
		$total_mapel = 0;
		$kelas_data = '';
		$total_kelas = 0;
		$total_siswa = 0;

		if ($mapel!=''){
			foreach ($mapel as $row){
				$mapel_data .= ' ('.$row->mp_kode.') '.$row->mp_nama.' |';
			}
			$this->data['total_mapel'] = count($mapel);
			$this->data['mapel_diampu'] = $mapel_data;
		} else {
			$this->data['total_mapel'] = 0;
			$this->data['mapel_diampu'] = '';
		}
		
		if ($kelas!=''){
			foreach ($kelas as $row){
				$kelas_data .= ' ('.$row->k_romawi.') '.$row->k_keterangan.' |';
				$siswa = $this->Model_siswa->read_data_by_idkelas($row->idkelas);
				$total_siswa += $siswa;
			}
			$this->data['total_kelas'] = count($kelas);
			$this->data['kelas_diampu'] = $kelas_data;
			$this->data['total_siswa'] = $total_siswa;
		} else {
			$this->data['total_siswa'] = 0;
			$this->data['total_kelas'] = 0;
			$this->data['kelas_diampu'] = '';
		}
        $this->template->load('guru/template','guru/dashboard/dashboard',$this->data);
    }

	public function corona()
	{
		// COVID 19
		$indonesia= file_get_contents('https://api.kawalcorona.com/indonesia');
		$provinsi= file_get_contents('https://api.kawalcorona.com/indonesia/provinsi');
		$total_provinsi = json_decode($provinsi);

		$this->data['total_indonesia']= json_decode($indonesia);
		if (count($total_provinsi)>0){
            $covid_provinsi = "";
            $covid_positif = null;
            $covid_sembuh = null;
            $covid_meninggal = null;
            foreach ($total_provinsi as $row){
                $nama_provinsi = $row->attributes->Provinsi;
                $covid_provinsi .= "'$nama_provinsi'". ", ";
                $total_positif = $row->attributes->Kasus_Posi;
				$covid_positif.= "$total_positif". ", ";
				$total_sembuh = $row->attributes->Kasus_Semb;
				$covid_sembuh.= "$total_sembuh". ", ";
				$total_meninggal = $row->attributes->Kasus_Meni;
                $covid_meninggal.= "$total_meninggal". ", ";
            }
            $this->data['covid_provinsi'] = $covid_provinsi;
            $this->data['covid_positif'] = $covid_positif;
            $this->data['covid_sembuh'] = $covid_sembuh;
            $this->data['covid_meninggal'] = $covid_meninggal;
        } else {
            $this->data['covid_provinsi'] = "";
            $this->data['covid_positif'] = null;
            $this->data['covid_sembuh'] = null;
            $this->data['covid_meninggal'] = null;
		}

		$this->load->view('guru/dashboard/corona',$this->data);
	}
}