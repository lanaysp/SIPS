<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Model_activity extends CI_Model
{
    protected $table = 'sr_log_activity';
	protected $id = 'idlog';
	protected $order = 'DESC';

	var $column = array('idlog','sr_tahun_pelajaran.tp_tahun','first_name','email','phone','activity','log_date','idlog');

	function _get_datatables_query()
	{
		$this->db->join('users','users.id = sr_log_activity.idusers','left');
		$this->db->join('sr_tahun_pelajaran','sr_tahun_pelajaran.idtahun_pelajaran = sr_log_activity.idtahun_pelajaran','left');
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

    public function read_data_by_identity($data)
    {
        $this->db->where('email',$data);
        $check = $this->db->get('users');
        if ($check->num_rows()>0){
            return $check->row()->id;
        } else {
            return false;
        }
    }

    public function create_data($data)
    {
        $this->db->insert($this->table,$data);
    }

    public function delete_data($id)
    {
        $this->db->where($this->id,$id);
        $this->db->delete($this->table);
	}
	
	public function delete_all()
    {
        $this->db->empty_table($this->table);
    }

}