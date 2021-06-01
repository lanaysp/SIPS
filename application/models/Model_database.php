<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Model_database extends CI_Model
{
	public function backup_database()
	{
		// Load the DB utility class
		$this->load->dbutil();

		// Backup your entire database and assign it to a variable
		$prefs = array(
			'tables'        => array(),   // Array of tables to backup.
			'ignore'        => array(),                     // List of tables to omit from the backup
			'format'        => 'zip',                       // gzip, zip, txt
			'filename'      => 'database.sql',              // File name - NEEDED ONLY WITH ZIP FILES
			'add_drop'      => TRUE,                        // Whether to add DROP TABLE statements to backup file
			'add_insert'    => TRUE,                        // Whether to add INSERT data to backup file
			'newline'       => "\n",                        // Newline character used in backup file
			'foreign_key_checks' => FALSE
		);
		
		$backup =& $this->dbutil->backup($prefs);
		$db_name = 'backup-'. date("Y-m-d-H-i-s") .'.zip';
		$save = FCPATH.'database/'.$db_name;

		// Load the file helper and write the file to your server
		$this->load->helper('file');
		write_file($save, $backup);

		$this->load->helper('download');
		force_download($db_name, $backup); 
	}

	function restore_database($db_name)
	{
		$folder = FCPATH;
		$folder = str_replace('\\', '/', $folder);  
		$path = $folder.'database_restore/';
		$sql_filename = $db_name;

        $sql_contents = file_get_contents($path.$sql_filename);
        //rtrim($sql_contents, "\n;" );
		$sql_contents = explode(";", $sql_contents);

		foreach($sql_contents as $query)
		{
			$pos = strpos($query,'ci_sessions');
			var_dump($pos);
			if($pos == false){
				$result = $this->db->query($query);
			} else {
				continue;
			}
		}
	}
	
}