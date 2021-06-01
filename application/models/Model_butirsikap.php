<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Model_butirsikap extends CI_Model
{
    protected $table = 'sr_butir_sikap';
	protected $id = 'idbutir_sikap';
	protected $order = 'DESC';

	var $column = array('idbutir_sikap','bs_kategori','bs_kode','bs_keterangan','idbutir_sikap');

	function _get_datatables_query()
	{
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

	public function get_datatables()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
		$this->db->limit($_POST['length'],$_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
    }
    
    public function read_data_by_id($id)
    {
		$this->db->select('*','edit as mode');
        $this->db->where($this->id,$id);
        return $this->db->get($this->table)->row_array();
	}
	
	public function check_data($data)
    {
        $this->db->select('*');
        $this->db->where($data);
        $check = $this->db->get($this->table)->num_rows();
        if($check>0){
            return true;
        } else {
            return false;
        }
    }

    public function create_data($data)
    {
        $this->db->insert($this->table,$data);
    }

    public function update_data($data,$id)
    {
        $this->db->where($this->id,$id);
        $this->db->update($this->table,$data);
    }

    public function delete_data($id)
    {
        $this->db->where($this->id,$id);
        $this->db->delete($this->table);
	}
	
	// ************ GURU ************* \\

	public function list_kd_by_id($tahun,$idmapel,$id,$kategori,$idkelas)
    {
		if($kategori=='Pengetahuan'){
			$this->db->order_by('kd_kode','ASC');
			$this->db->where('idtahun_pelajaran',$tahun);
			$this->db->where('idmata_pelajaran',$idmapel);
			$this->db->where('idkelas',$idkelas);
			$this->db->where('idusers',$id);
			$this->db->where('kd_kategori',$kategori);
			$this->db->where('kd_status','Y');
			$query = $this->db->get($this->table);
			if ($query->num_rows() > 0){
				foreach ($query->result_array() as $row){
					$result[''] = '- Pilih Penilaian -';
					$result['utsuas'] = 'Ujian Tengah/Akhir Semester (UTS/UAS)';
					$result[$row['idkompetensi_dasar']] = ucwords($row['kd_kode'].' - '.$row['kd_nama']);
				}
				return $result;
			}
		} else {
			$this->db->order_by('kd_kode','ASC');
			$this->db->where('idtahun_pelajaran',$tahun);
			$this->db->where('idmata_pelajaran',$idmapel);
			$this->db->where('idkelas',$idkelas);
			$this->db->where('idusers',$id);
			$this->db->where('kd_kategori',$kategori);
			$this->db->where('kd_status','Y');
			$query = $this->db->get($this->table);
			if ($query->num_rows() > 0){
				foreach ($query->result_array() as $row){
					$result[''] = '- Pilih Penilaian -';
					$result[$row['idkompetensi_dasar']] = ucwords($row['kd_kode'].' - '.$row['kd_nama']);
				}
				return $result;
			}
		}
		
	}
	
	// Spiritual
	public function check_rencana_spiritual($data)
    {
        $this->db->select('*');
        $this->db->where($data);
        return $this->db->get('sr_rencana_bs_spiritual')->row_array();
	}

	public function check_rencana_spiritual_result($data)
    {
        $this->db->select('*');
        $this->db->where($data);
        return $this->db->get('sr_rencana_bs_spiritual')->result();
	}
	
	public function create_rencana_spiritual($data)
    {
		$this->db->insert('sr_rencana_bs_spiritual',$data);
		$id = $this->db->insert_id();
		$this->session->set_userdata('idrencana_spiritual_new',$id);
	}
	
	public function update_rencana_spiritual($data,$id)
    {
        $this->db->where('idrencana_bs_spiritual',$id);
        $this->db->update('sr_rencana_bs_spiritual',$data);
	}
	
	public function get_datatables_spiritual($tahun,$id,$idkelas)
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
		$this->db->limit($_POST['length'],$_POST['start']);
		$this->db->where('bs_kategori','Spiritual');
		$query = $this->db->get();
		return $query->result();
    }

	public function count_filtered_spiritual($tahun,$id)
	{
		$this->_get_datatables_query();
		$this->db->where('bs_kategori','Spiritual');
		$query = $this->db->get();
		return $query->num_rows();
    }

	public function count_all_spiritual($tahun,$id)
	{
		$this->db->from($this->table);
		$this->db->where('bs_kategori','Spiritual');
		return $this->db->count_all_results();
	}

	// Sosial
	public function check_rencana_sosial($data)
    {
        $this->db->select('*');
        $this->db->where($data);
        return $this->db->get('sr_rencana_bs_sosial')->row_array();
	}

	public function check_rencana_sosial_result($data)
    {
        $this->db->select('*');
        $this->db->where($data);
        return $this->db->get('sr_rencana_bs_sosial')->result();
	}
	
	public function create_rencana_sosial($data)
    {
        $this->db->insert('sr_rencana_bs_sosial',$data);
		$id = $this->db->insert_id();
		$this->session->set_userdata('idrencana_sosial_new',$id);
	}
	
	public function update_rencana_sosial($data,$id)
    {
        $this->db->where('idrencana_bs_sosial',$id);
        $this->db->update('sr_rencana_bs_sosial',$data);
	}
	
	public function get_datatables_sosial($tahun,$id,$idkelas)
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
		$this->db->limit($_POST['length'],$_POST['start']);
		$this->db->where('bs_kategori','Sosial');
		$query = $this->db->get();
		return $query->result();
    }

	public function count_filtered_sosial($tahun,$id)
	{
		$this->_get_datatables_query();
		$this->db->where('bs_kategori','Sosial');
		$query = $this->db->get();
		return $query->num_rows();
    }

	public function count_all_sosial($tahun,$id)
	{
		$this->db->from($this->table);
		$this->db->where('bs_kategori','Sosial');
		return $this->db->count_all_results();
	}
	
	// Keterampilan
	public function check_rencana_keterampilan($data)
    {
        $this->db->select('*');
        $this->db->where($data);
        return $this->db->get('sr_rencana_kd_keterampilan')->row_array();
	}
	
	public function create_rencana_keterampilan($data)
    {
        $this->db->insert('sr_rencana_kd_keterampilan',$data);
	}
	
	public function update_rencana_keterampilan($data,$id)
    {
        $this->db->where('idrencana_kd_keterampilan',$id);
        $this->db->update('sr_rencana_kd_keterampilan',$data);
	}
	
	public function get_datatables_keterampilan($idmapel,$tahun,$id)
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'],$_POST['start']);
        $this->db->where('sr_kompetensi_dasar.idmata_pelajaran',$idmapel);
        $this->db->where('sr_kompetensi_dasar.idtahun_pelajaran',$tahun);
        $this->db->where('sr_kompetensi_dasar.kd_kategori','Keterampilan');
		$this->db->where('users.id',$id);
		$query = $this->db->get();
		return $query->result();
    }

	public function count_filtered_keterampilan($idmapel,$tahun,$id)
	{
		$this->_get_datatables_query();
        $this->db->where('sr_kompetensi_dasar.idmata_pelajaran',$idmapel);
        $this->db->where('sr_kompetensi_dasar.idtahun_pelajaran',$tahun);
        $this->db->where('sr_kompetensi_dasar.kd_kategori','Keterampilan');
		$this->db->where('users.id',$id);
		$query = $this->db->get();
		return $query->num_rows();
    }

	public function count_all_keterampilan($idmapel,$tahun,$id)
	{
		$this->db->from($this->table);
        $this->db->join('sr_tahun_pelajaran','sr_tahun_pelajaran.idtahun_pelajaran = sr_kompetensi_dasar.idtahun_pelajaran','left');
        $this->db->join('sr_mata_pelajaran','sr_mata_pelajaran.idmata_pelajaran = sr_kompetensi_dasar.idmata_pelajaran','left');
        $this->db->join('users','users.id = sr_kompetensi_dasar.idusers','left');
        $this->db->where('sr_kompetensi_dasar.idmata_pelajaran',$idmapel);
        $this->db->where('sr_kompetensi_dasar.idtahun_pelajaran',$tahun);
        $this->db->where('sr_kompetensi_dasar.kd_kategori','Keterampilan');
		$this->db->where('users.id',$id);
		return $this->db->count_all_results();
    }

}