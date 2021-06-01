<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Web_config extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Ion_auth_model');
		$this->load->model('Model_profile');
        $this->load->model('Model_tahunpelajaran');
        $this->load->model('Model_users');
        $this->load->model('Model_web_config');
		
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
		$this->data['tahunpelajaran_dipilih']= $this->Model_tahunpelajaran->read_data_by_id($this->session->userdata('tahun'));
        $this->data['u_photo'] = $this->Model_users->read_data_by_id($this->session->userdata('user_id'))->u_photo;
    }

    public function index()
    {
        $this->data['naik_kelas'] = $this->Model_web_config->read_data_naik_kelas()->config_value;
        $this->data['check_rapor'] = $this->Model_web_config->read_data_check_rapor()->config_value;
        $this->data['reset_password'] = $this->Model_web_config->read_data_reset_password()->config_value;
        $this->data['new_version'] = $this->Model_web_config->read_data_new_version()->config_value;
        $this->data['no_validate_delete'] = $this->Model_web_config->read_data_no_validate_delete()->config_value;
        $this->template->load('administrator/template','administrator/web_config/web_config',$this->data);
    }

    public function change_value()
    {
        $data = $this->input->post();
        $config_name = filter($data['config_name']);

        if ($config_name=='naik_kelas'){
            $naik_kelas = $this->Model_web_config->read_data_naik_kelas()->config_value;
            if ($naik_kelas=='1'){
                $naik_value = '0';
            } else {
                $naik_value = '1';
            }
            $update = [
                'config_value' => $naik_value
            ];
            if ($this->Model_web_config->update_data($config_name,$update)){
                $r['status'] = "ok";
            } else {
                $r['status'] = "gagal";
            }
        } else if ($config_name=='check_rapor') {
            $check_rapor = $this->Model_web_config->read_data_check_rapor()->config_value;
            if ($check_rapor=='1'){
                $check_value = '0';
            } else {
                $check_value = '1';
            }
            $update = [
                'config_value' => $check_value
            ];
            if ($this->Model_web_config->update_data($config_name,$update)){
                $r['status'] = "ok";
            } else {
                $r['status'] = "gagal";
            }
        } else if ($config_name=='reset_password') {
            $reset_password = $this->Model_web_config->read_data_reset_password()->config_value;
            if ($reset_password=='1'){
                $check_value = '0';
            } else {
                $check_value = '1';
            }
            $update = [
                'config_value' => $check_value
            ];
            if ($this->Model_web_config->update_data($config_name,$update)){
                $r['status'] = "ok";
            } else {
                $r['status'] = "gagal";
            }
        } else if ($config_name=='new_version') {
            $new_version = $this->Model_web_config->read_data_new_version()->config_value;
            if ($new_version=='1'){
                $check_value = '0';
            } else {
                $check_value = '1';
            }
            $update = [
                'config_value' => $check_value
            ];
            if ($this->Model_web_config->update_data($config_name,$update)){
                $r['status'] = "ok";
            } else {
                $r['status'] = "gagal";
            }
        } else if ($config_name=='no_validate_delete') {
            $check_rapor = $this->Model_web_config->read_data_no_validate_delete()->config_value;
            if ($check_rapor=='1'){
                $check_value = '0';
            } else {
                $check_value = '1';
            }
            $update = [
                'config_value' => $check_value
            ];
            if ($this->Model_web_config->update_data($config_name,$update)){
                $r['status'] = "ok";
            } else {
                $r['status'] = "gagal";
            }
        }

        header('Content-Type: application/json');
        echo json_encode($r);
    }
    
}