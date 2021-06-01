<?php defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Tahun_pelajaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Ion_auth_model');
		$this->load->model('Model_profile');
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
        $this->template->load('administrator/template','administrator/tahun_pelajaran/tahun_pelajaran',$this->data);
    }

    public function ajax_list()
	{
		//get_datatables terletak di model
		$list = $this->Model_tahunpelajaran->get_datatables();
		$data = array();
		$no = $_POST['start'];

		// Membuat loop/ perulangan
		foreach ($list as $data_tahunpelajaran) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $data_tahunpelajaran->tp_tahun;
            $row[] = '<a onclick="return edit('.$data_tahunpelajaran->idtahun_pelajaran.')" class="btn btn-info btn-sm text-light"><i class="fa fa-edit"></i> Edit</a> 
                      <a onclick="return delete_data(\''.$data_tahunpelajaran->idtahun_pelajaran.'\',\''.$data_tahunpelajaran->tp_tahun.'\')" class="btn btn-danger btn-sm text-light"><i class="fa fa-window-close"></i> Hapus</a>';

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Model_tahunpelajaran->count_all(),
			"recordsFiltered" => $this->Model_tahunpelajaran->count_filtered(),
			"data" => $data
		);
		//output to json format
		echo json_encode($output);
    }
    
    public function edit($id)
    {
        $check = $this->Model_tahunpelajaran->read_data_by_id($id);
        $data = array();
        if(empty($check)){
            $data['data']['idtahun_pelajaran'] = "";
            $data['data']['mode'] = "add";
            $data['data']['tp_tahun'] = "";
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
            'tp_tahun' => filter($data['tp_tahun'])
        ];
        $id = $data['_id'];

        if ($this->Model_tahunpelajaran->check_data($insert)){
            return false;
        }

        if ($data['_mode'] == 'add'){
            $this->Model_tahunpelajaran->create_data($insert);
            $r['status'] = "ok";
            $this->log_activity($this->session->userdata('nama').' menambah data tahun pelajaran');
        } else if ($data['_mode'] == 'edit'){
            $this->Model_tahunpelajaran->update_data($insert,$id);
            $r['status'] = "ok";
            $this->log_activity($this->session->userdata('nama').' mengubah data tahun pelajaran');
        } else {
            $r['status'] = "gagal";
            $this->log_activity($this->session->userdata('nama').' gagal mengelola data tahun pelajaran');
        }
        header('Content-Type: application/json');
        echo json_encode($r);
    }

    public function delete($id) {
        $this->load->model('Model_delete');
        $this->load->model('Model_web_config');
        $data = [
            'idtahun_pelajaran' => $id
        ];
        $no_validate = $this->Model_web_config->read_data_no_validate_delete()->config_value;
        if ($no_validate=='0'){
            if ($this->Model_delete->check_data($data,'sr_kehadiran')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_ekstra_siswa')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_kesehatan_siswa')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_kompetensi_dasar')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_nilai_keterampilan')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_nilai_pengetahuan')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_nilai_pengetahuan_utsuas')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_nilai_spiritual')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_nilai_sosial')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_nk_deskripsi')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_np_deskripsi')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_nso_deskripsi')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_nsp_deskripsi')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_prestasi')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_profile')){
                $r['status'] = "profile";
            } else if ($this->Model_delete->check_data($data,'sr_rencana_bs_sosial')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_rencana_bs_spiritual')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_rencana_kd_pengetahuan')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_rencana_kd_keterampilan')){
                $r['status'] = "gagal";
            } else if ($this->Model_delete->check_data($data,'sr_siswa_guru')){
                $r['status'] = "gagal";
            } else {
                $this->Model_delete->delete_data($data,'sr_log_activity');
                $this->Model_delete->delete_data($data,'sr_tahun_pelajaran');
                $r['status'] = "ok";
                $this->log_activity($this->session->userdata('nama').' menghapus data tahun pelajaran');
            }
        } else if ($no_validate=='1'){
            if ($this->Model_delete->check_data($data,'sr_profile')){
                $r['status'] = "profile";
            } else {
                $this->Model_delete->delete_data($data,'sr_log_activity');
                $this->Model_delete->delete_data($data,'sr_kehadiran');
                $this->Model_delete->delete_data($data,'sr_prestasi');
                $this->Model_delete->delete_data($data,'sr_ekstra_siswa');
                $this->Model_delete->delete_data($data,'sr_kesehatan_siswa');
                $this->Model_delete->delete_data($data,'sr_ekstra_siswa');
                $this->Model_delete->delete_data($data,'sr_nso_deskripsi');
                $this->Model_delete->delete_data($data,'sr_nsp_deskripsi');
                $this->Model_delete->delete_data($data,'sr_nk_deskripsi');
                $this->Model_delete->delete_data($data,'sr_np_deskripsi');
                $this->Model_delete->delete_data($data,'sr_nilai_pengetahuan');
                $this->Model_delete->delete_data($data,'sr_nilai_pengetahuan_utsuas');
                $this->Model_delete->delete_data($data,'sr_nilai_keterampilan');
                $this->Model_delete->delete_data($data,'sr_nilai_sosial');
                $this->Model_delete->delete_data($data,'sr_nilai_spiritual');
                $this->Model_delete->delete_data($data,'sr_rencana_bs_spiritual');
                $this->Model_delete->delete_data($data,'sr_rencana_bs_sosial');
                $this->Model_delete->delete_data($data,'sr_rencana_kd_keterampilan');
                $this->Model_delete->delete_data($data,'sr_rencana_kd_pengetahuan');
                $this->Model_delete->delete_data($data,'sr_kompetensi_dasar');
                $this->Model_delete->delete_data($data,'sr_siswa_guru');

                $this->Model_delete->delete_data($data,'sr_tahun_pelajaran');
                $r['status'] = "ok";
                $this->log_activity($this->session->userdata('nama').' menghapus data tahun pelajaran beserta seluruh data yang terhubung');
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode($r);
    }

    // file upload functionality
    public function upload() 
	{
    	$data = array();
    	 // Load form validation library
         $this->load->library('form_validation');
         $this->form_validation->set_rules('fileURL', 'Upload File', 'callback_checkFileValidation');
         if($this->form_validation->run() == false) {
            $r['status'] = "validasi";
         } else {
            // If file uploaded
            if(!empty($_FILES['fileURL']['name'])) { 
            	// get file extension
            	$extension = pathinfo($_FILES['fileURL']['name'], PATHINFO_EXTENSION);

            	if($extension == 'csv'){
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} elseif($extension == 'xlsx') {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
				}
				// file path
				$spreadsheet = $reader->load($_FILES['fileURL']['tmp_name']);
				$allDataInSheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
			
				// array Count
				$arrayCount = count($allDataInSheet);
	            $flag = 0;
	            $createArray = array('Tahun_Pelajaran');
	            $makeArray = array('Tahun_Pelajaran' => 'Tahun_Pelajaran');
	            $SheetDataKey = array();
	            foreach ($allDataInSheet as $dataInSheet) {
	                foreach ($dataInSheet as $key => $value) {
	                    if (in_array(trim($value), $createArray)) {
	                        $value = preg_replace('/\s+/', '', $value);
	                        $SheetDataKey[trim($value)] = $key;
	                    } 
	                }
	            }
	            $dataDiff = array_diff_key($makeArray, $SheetDataKey);
	            if (empty($dataDiff)) {
                	$flag = 1;
            	}
            	// match excel sheet column
	            if ($flag == 1) {
	                for ($i = 2; $i <= $arrayCount; $i++) {
	                    $addresses = array();
	                    $tahun_pelajaran = $SheetDataKey['Tahun_Pelajaran'];
	                    $tp_tahun = filter_var(trim($allDataInSheet[$i][$tahun_pelajaran]), FILTER_SANITIZE_STRING);
                        if (empty($tp_tahun)){
                            continue;
                        }
	                    $fetchData[] = array('tp_tahun' => $tp_tahun);
	                }   
	                $r['dataInfo'] = $fetchData;
	                $this->Model_tahunpelajaran->setBatchImport($fetchData);
	                $this->Model_tahunpelajaran->importData();
                    $r['status'] = "ok";
	            } else {
	                $r['status'] = "tipe_file";
	            }
	            //$this->load->view('spreadsheet/display', $data);
        	} else {
                $r['status'] = "gagal";
            }              
    	}
        header('Content-Type: application/json');
        echo json_encode($r);
	}

    // checkFileValidation
    public function checkFileValidation($string) 
    {
        $file_mimes = array('text/x-comma-separated-values', 
            'text/comma-separated-values', 
            'application/octet-stream', 
            'application/vnd.ms-excel', 
            'application/x-csv', 
            'text/x-csv', 
            'text/csv', 
            'application/csv', 
            'application/excel', 
            'application/vnd.msexcel', 
            'text/plain', 
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );
        if(isset($_FILES['fileURL']['name'])) {
              $arr_file = explode('.', $_FILES['fileURL']['name']);
              $extension = end($arr_file);
              if(($extension == 'xlsx' || $extension == 'xls' || $extension == 'csv') && in_array($_FILES['fileURL']['type'], $file_mimes)){
                  return true;
              }else{
                  $this->form_validation->set_message('checkFileValidation', 'Please choose correct file.');
                  return false;
              }
          }else{
              $this->form_validation->set_message('checkFileValidation', 'Please choose a file.');
              return false;
          }
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