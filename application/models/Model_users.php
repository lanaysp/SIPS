<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Model_users extends CI_Model
{
	protected $table = 'users';
	protected $id = 'id';
	protected $order = 'DESC';

	var $column = array('users.id','users.first_name','sr_users.u_nbm_nip','sr_users.u_status_pegawai','sr_users.u_tugas_tambahan','users.id','users.id','users.email','users.phone','users.id','users.id');

	function _get_datatables_query()
	{
        $this->db->join('sr_users','users.id = sr_users.idusers','left');
        //$this->db->join('sr_kelas','users.id = sr_kelas.idusers','left');
        $this->db->join('users_groups','users.id = users_groups.user_id','left');
		$this->db->join('groups','users_groups.group_id = groups.id','left');
		$this->db->from($this->table);

		$i = 0;

		foreach ($this->column as $item){
			if ($_POST['search']['value']){
				if ($i===0){
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column) - 1 == $i){
					$this->db->group_end();
				}
			}
			$column[$i] = $item;
			$i++;
		}

		if (isset($_POST['order'])){
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)){
			$order = $this->order;
			$this->db->order_by(key($order),$order[key($order)]);
		}
	}

	public function get_datatables($id)
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
		$this->db->limit($_POST['length'],$_POST['start']);
		if ($id==2){
			$this->db->where('users.multirole','N');
		} else if ($id==3) {
			$this->db->where('users.multirole','Y');
		}
		$this->db->where('groups.id',$id);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_filtered($id)
	{
		if ($id=='2'){
			$this->_get_datatables_query();
			$this->db->where('users.multirole','N');
			$this->db->where('groups.id',$id);
			$query = $this->db->get();
			return $query->num_rows();
		} else if ($id=='3'){
			$this->_get_datatables_query();
			$this->db->where('users.multirole','Y');
			$this->db->where('groups.id',$id);
			$query = $this->db->get();
			return $query->num_rows();
		}
	}

	public function count_all($id)
	{
		if ($id=='2'){
			$this->db->from($this->table);
			$this->db->join('users_groups','users.id = users_groups.user_id','left');
			$this->db->join('groups','users_groups.group_id = groups.id','left');
			$this->db->where('users.multirole','N');
			$this->db->where('groups.id',$id);
			return $this->db->count_all_results();

		} else if ($id=='3'){
			$this->db->from($this->table);
			$this->db->join('users_groups','users.id = users_groups.user_id','left');
			$this->db->join('groups','users_groups.group_id = groups.id','left');
			$this->db->where('users.multirole','Y');
			$this->db->where('groups.id',$id);
			return $this->db->count_all_results();
		}
	}

	public function count_all_dashboard()
	{
		$this->db->where('username is null');
		return $this->db->get($this->table)->num_rows();
	}
	
	public function read_data()
	{
        $this->db->select('*');
		$check = $this->db->get($this->table)->num_rows();
		if($check>0){
            // join detail table user 
			$this->db->join('sr_users','sr_users.idusers = users.id','left');
            // lokasi untuk tanggal lahir dan alamat
			$this->db->join('sr_provinsi','sr_provinsi.province_id = sr_users.u_tl_idprovinsi','left');
			$this->db->join('sr_kota','sr_kota.city_id = sr_users.u_tl_idkota','left');
            $this->db->order_by('users.first_name','ASC');
			return $this->db->get($this->table)->result();
		} else {
			return false;
		}
	}
	
	public function read_data_by_id($id)
	{
        $this->db->select('*');
        $this->db->where($this->id,$id);
		$check = $this->db->get($this->table)->num_rows();
		if($check>0){
            // join detail table user 
			$this->db->join('sr_users','sr_users.idusers = users.id','left');
            // lokasi untuk tanggal lahir dan alamat
			$this->db->join('sr_provinsi','sr_provinsi.province_id = sr_users.u_tl_idprovinsi','left');
			$this->db->join('sr_kota','sr_kota.city_id = sr_users.u_tl_idkota','left');
        
            $this->db->order_by($this->table.'.'.$this->id,'DESC');
            $this->db->where($this->id,$id);
			return $this->db->get($this->table)->row();
		} else {
			return false;
		}
	}

	public function read_users_groups_by_id($id)
	{
        $this->db->select('*');
        $this->db->where('user_id',$id);
		$check = $this->db->get('users_groups')->num_rows();
		if($check>0){
            // join detail table user 
			$this->db->join('groups','groups.id = users_groups.group_id','left');
			$this->db->where('user_id',$id);
			$this->db->order_by('group_id','desc');
			return $this->db->get('users_groups')->row();
		} else {
			return false;
		}
	}

	public function read_diklat_by_id($id)
	{
		$this->db->select('*');
        $this->db->where('idusers',$id);
		$check = $this->db->get('sr_diklat')->num_rows();
		if($check>0){        
            $this->db->order_by('d_tahun','ASC');
            $this->db->where('idusers',$id);
			return $this->db->get('sr_diklat')->result();
		} else {
			return false;
		}
	}

	public function read_mapel_by_id($id)
	{
		$this->db->select('*');
        $this->db->where('idusers',$id);
		$check = $this->db->get('sr_mata_pelajaran_guru')->num_rows();
		if($check>0){        
			$this->db->join('sr_mata_pelajaran','sr_mata_pelajaran.idmata_pelajaran = sr_mata_pelajaran_guru.idmata_pelajaran','left');
            $this->db->order_by('idmata_pelajaran_guru','DESC');
            $this->db->where('idusers',$id);
			return $this->db->get('sr_mata_pelajaran_guru')->result();
		} else {
			return false;
		}
	}
	
	public function read_kelas_by_id($id)
	{
		$this->db->select('*');
        $this->db->where('idusers',$id);
		$check = $this->db->get('sr_kelas_guru')->num_rows();
		if($check>0){        
			$this->db->join('sr_kelas','sr_kelas.idkelas = sr_kelas_guru.idkelas','left');
            $this->db->order_by('sr_kelas.k_tingkat','ASC');
            $this->db->where('sr_kelas_guru.idusers',$id);
			return $this->db->get('sr_kelas_guru')->result();
		} else {
			return false;
		}
	}

	public function read_users_by_kelas($id)
	{
		$this->db->select('*');
        $this->db->where('idkelas',$id);
		$check = $this->db->get('sr_kelas');
		if($check->num_rows()>0){        
			return $check->row();
		} else {
			return false;
		}
	}

	public function read_row_diklat_by_id($id)
    {
		$this->db->select('*','edit as mode');
		$this->db->join('users','users.id = sr_diklat.idusers','left');
        $this->db->where('sr_diklat.iddiklat',$id);
        return $this->db->get('sr_diklat')->row_array();
	}

	public function read_row_mapel_by_id($id)
    {
		$this->db->select('*','edit as mode');
		$this->db->join('users','users.id = sr_mata_pelajaran_guru.idusers','left');
        $this->db->where('sr_mata_pelajaran_guru.idmata_pelajaran_guru',$id);
        return $this->db->get('sr_mata_pelajaran_guru')->row_array();
	}

	public function read_row_kelas_by_id($id)
    {
		$this->db->select('*','edit as mode');
		$this->db->join('users','users.id = sr_kelas_guru.idusers','left');
        $this->db->where('sr_kelas_guru.idkelas_guru',$id);
        return $this->db->get('sr_kelas_guru')->row_array();
	}

	public function check_data($data,$table)
    {
        $this->db->select('*');
		$this->db->where($data);
		if ($table=='diklat'){
			$check = $this->db->get('sr_diklat')->num_rows();
		} else if ($table=='mapel'){
			$check = $this->db->get('sr_mata_pelajaran_guru')->num_rows();
		} else if ($table=='kelas'){
			$check = $this->db->get('sr_kelas_guru')->num_rows();
		} else if ($table=='wali'){
			$check = $this->db->get('sr_kelas')->num_rows();
		}  else if ($table=='users'){
			$check = $this->db->get($this->table)->num_rows();
		}
        if($check>0){
            return true;
        } else {
            return false;
        }
	}

	public function check_detail_data($data,$type)
    {
		if ($type=='email'){
			$this->db->where('email',$data);
		} else {
			$this->db->where('phone',$data);
		}
        $check = $this->db->get($this->table)->num_rows();
        if($check>0){
            return true;
        } else {
            return false;
        }
    }

	public function check_group($id,$level)
	{
		$this->db->select('*');
		$this->db->join('users_groups','users_groups.user_id = users.id','left');
		$this->db->join('groups','groups.id = users_groups.group_id','left');
		$this->db->where('users_groups.user_id',$id);
		$this->db->where('groups.name',$level);
		$check = $this->db->get($this->table)->num_rows();
		if($check>0){
			return true;
		} else {
			return false;
		}
	}

	public function list_users()
    {
        $this->db->order_by('first_name','ASC');
		$query = $this->db->get($this->table);
		if ($query->num_rows() > 0){
			foreach ($query->result_array() as $row){
				$result[''] = '- Pilih Wali Kelas -';
				$result[$row['id']] = ucwords($row['first_name'].' '.$row['last_name']);
			}
			return $result;
		}
	}
	
	public function create_data($data,$table)
    {
		if ($table=='data'){
			$this->db->insert($this->table,$data);
		} else if ($table=='diklat') {
			$this->db->insert('sr_diklat',$data);
		} else if ($table=='mapel') {
			$this->db->insert('sr_mata_pelajaran_guru',$data);
		} else if ($table=='kelas') {
			$this->db->insert('sr_kelas_guru',$data);
		} else if ($table=='sr_users') {
			$this->db->insert('sr_users',$data);
			$this->session->unset_userdata('insert_user_id');
		}
	}
	
	public function update_data($data,$id,$table)
    {
		if ($table=='data'){
			$this->db->where($this->id,$id);
        	$this->db->update($this->table,$data);
		} else if ($table=='diklat') {
			$this->db->where('iddiklat',$id);
        	$this->db->update('sr_diklat',$data);
		} else if ($table=='mapel') {
			$this->db->where('idmata_pelajaran_guru',$id);
        	$this->db->update('sr_mata_pelajaran_guru',$data);
		} else if ($table=='kelas') {
			$this->db->where('idkelas_guru',$id);
        	$this->db->update('sr_kelas_guru',$data);
		} else if ($table=='users') {
			$this->db->where($this->id,$id);
        	$this->db->update($this->table,$data);
		} else if ($table=='users_sub') {
			$this->db->where('idusers',$id);
        	$this->db->update('sr_users',$data);
		} else if ($table=='users_groups') {
			if ($data['group_id']==3){
				$insert = [
					'user_id' => $id,
					'group_id' => $data['group_id']
				];
				$this->db->insert('users_groups',$insert);
			} else {
				$this->db->where('user_id',$id);
				$this->db->where('group_id',3);
				$this->db->delete('users_groups');
			}
		}
    }

	public function delete_data($id)
    {

		$this->db->where('idusers',$id);
		$this->db->delete('sr_log_activity');
		$this->db->where('idusers',$id);
		$this->db->delete('sr_kompetensi_dasar');
		$this->db->where('idusers',$id);
		$this->db->delete('sr_diklat');
		$this->db->where('idusers',$id);
		$this->db->delete('sr_mata_pelajaran_guru');
		$this->db->where('idusers',$id);
		$this->db->delete('sr_kelas_guru');
		$this->db->where('idusers',$id);
		$this->db->delete('sr_nso_deskripsi');
		$this->db->where('idusers',$id);
		$this->db->delete('sr_nsp_deskripsi');
		$this->db->where('idusers',$id);
		$this->db->delete('sr_catatan ');
		$this->db->where('idusers',$id);
		$this->db->delete('sr_kesehatan_siswa');
		$this->db->where('idusers',$id);
		$this->db->delete('sr_prestasi');
		$this->db->where('idusers',$id);
		$this->db->delete('sr_ekstra_siswa');
		$this->db->where('idusers',$id);
		$this->db->delete('sr_kehadiran');
		$this->db->where('idusers',$id);
		$this->db->delete('sr_siswa_guru');
		$this->db->where('idusers',$id);
		$this->db->delete('sr_np_deskripsi');
		$this->db->where('idusers',$id);
		$this->db->delete('sr_nk_deskripsi');
		$this->db->where('idusers',$id);
		$this->db->delete('sr_nilai_sosial');
		$this->db->where('idusers',$id);
		$this->db->delete('sr_nilai_spiritual');
		$this->db->where('idusers',$id);
		$this->db->delete('sr_nilai_pengetahuan');
		$this->db->where('idusers',$id);
		$this->db->delete('sr_nilai_pengetahuan_utsuas');
		$this->db->where('idusers',$id);
		$this->db->delete('sr_rencana_bs_sosial');
		$this->db->where('idusers',$id);
		$this->db->delete('sr_rencana_bs_spiritual');
		$this->db->where('idusers',$id);
		$this->db->delete('sr_rencana_kd_keterampilan');
		$this->db->where('idusers',$id);
		$this->db->delete('sr_rencana_kd_pengetahuan');
		$this->db->where('idusers',$id);
		$this->db->delete('sr_users ');
		$this->db->where('idusers',$id);
		$this->db->delete('users_groups');
		$this->db->where('idusers',$id);

        $this->db->where($this->id,$id);
        $this->db->delete($this->table);
	}
	
	public function delete_subdata($id)
    {
        $this->db->where('idusers',$id);
        $this->db->delete('sr_users');
	}
	
	public function delete_groups($id)
    {
        $this->db->where('user_id',$id);
        $this->db->delete('users_groups');
	}

	public function delete_diklat_users($id)
    {
        $this->db->where('idusers',$id);
        $this->db->delete('sr_diklat');
	}

	public function delete_mapel_users($id)
    {
        $this->db->where('idusers',$id);
        $this->db->delete('sr_mata_pelajaran_guru');
	}

	public function delete_kelas_users($id)
    {
        $this->db->where('idusers',$id);
        $this->db->delete('sr_kelas_guru');
	}
	
	public function delete_diklat($id)
    {
        $this->db->where('iddiklat',$id);
        $this->db->delete('sr_diklat');
	}
	
	public function delete_mapel($id)
    {
        $this->db->where('idmata_pelajaran_guru',$id);
        $this->db->delete('sr_mata_pelajaran_guru');
	}
	
	public function delete_kelas($id)
    {
        $this->db->where('idkelas_guru',$id);
        $this->db->delete('sr_kelas_guru');
	}
	
	public function delete_activity($id)
    {
        $this->db->where('idusers',$id);
        $this->db->delete('sr_log_activity');
	}
	
}