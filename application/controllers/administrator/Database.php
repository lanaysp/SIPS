<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Database extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Ion_auth_model');
        $this->load->model('Model_database');
        $this->load->library('Ion_auth');
		
        if (!$this->ion_auth->is_admin()){redirect('Auth/login');}
    }


    public function backup_database()
    {
        ini_set('max_execution_time', 0); 
        ini_set('memory_limit','2048M');
        $this->Model_database->backup_database();
    }

    public function restore_database($db_name)
    {
        ini_set('max_execution_time', 0); 
        ini_set('memory_limit','2048M');
        $this->Model_database->restore_database($db_name);
    }

    public function delete_database_restore()
    {
        $this->load->helper('file');
        $dir = FCPATH.'database_restore/';
        delete_files($dir);
    }

    function upload_database_restore()
    {
        $this->delete_database_restore();
        $config['upload_path'] = './database_restore/';
        $config['allowed_types'] = 'pdf|sql';
        $this->load->library('upload',$config);
        if ( ! $this->upload->do_upload('userfile')){
            echo "Restore Database Gagal..!";
        } else
        {
            $data = array('upload_data' => $this->upload->data());
            $upload_data 	= $this->upload->data();
            $file_name 	=   $upload_data['file_name'];
            $file_type 	=   $upload_data['file_type'];
            $file_size 	=   $upload_data['file_size'];
            $this->restore_database($file_name);
        }
        
    }

}