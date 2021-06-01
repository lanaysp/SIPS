<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Model_kelas extends CI_Model
{
    protected $table = 'sr_kelas';
	protected $id = 'idkelas';
	protected $order = 'DESC';

	var $column = array('idkelas','first_name','k_tingkat','k_romawi','k_keterangan','idkelas');

	function _get_datatables_query()
	{
        $this->db->join('users','users.id = sr_kelas.idusers','left');
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
	
	public function count_all_dashboard()
	{
		$this->db->where('k_keterangan !=','LULUS');
		$this->db->where('k_keterangan !=','PINDAH');
		return $this->db->get($this->table)->num_rows();
    }

    public function list_kelas()
    {
        $this->db->order_by('k_tingkat','ASC');
		$query = $this->db->get($this->table);
		if ($query->num_rows() > 0){
			foreach ($query->result_array() as $row){
				$result[''] = '- Pilih Kelas -';
				$result[$row['idkelas']] = ucwords($row['k_romawi'].' - '.$row['k_keterangan']);
			}
			return $result;
		}
	}
	
	public function read_data()
    {
		$this->db->select('*');
		$this->db->join('users','users.id = sr_kelas.idusers','left');
        $this->db->where('sr_kelas.k_romawi !=','LULUS');
        $this->db->where('sr_kelas.k_romawi !=','PINDAH');
		$check =  $this->db->get($this->table);
		if ($check->num_rows()>0){
			return $check->result();
		} else {
			return false;
		}
	}
    
    public function read_data_by_id($id)
    {
		$this->db->select('*','edit as mode');
		$this->db->join('users','users.id = sr_kelas.idusers','left');
        $this->db->where($this->id,$id);
        return $this->db->get($this->table)->row_array();
	}

	public function read_data_by_tingkat($tingkat)
    {
		$this->db->select('*','edit as mode');
        $this->db->where('k_tingkat',$tingkat);
        $check =  $this->db->get($this->table);
		if ($check->num_rows()>0){
			return $check->row();
		} else {
			return false;
		}
	}

	public function read_data_by_wali($id)
    {
		$this->db->select('*','edit as mode');
		$this->db->join('users','users.id = sr_kelas.idusers','left');
		$this->db->join('sr_users','sr_users.idusers = sr_kelas.idusers','left');
        $this->db->where('sr_kelas.idusers',$id);
        $check = $this->db->get($this->table);
        if($check->num_rows()>0){
            return $check->row();
        } else {
            return false;
        }
	}

	public function read_total_data_by_wali($id)
    {
		$this->db->join('users','users.id = sr_kelas.idusers','left');
		$this->db->join('sr_users','sr_users.idusers = sr_kelas.idusers','left');
        $this->db->where('sr_kelas.idusers',$id);
        $check = $this->db->get($this->table);
        return $check->num_rows();
	}

	public function read_high_level_class()
	{
		$this->db->select('idkelas, k_tingkat');
		$this->db->limit(1);
		$this->db->order_by('k_tingkat',$this->order);
        $this->db->where('k_romawi !=','LULUS');
        $this->db->where('k_romawi !=','PINDAH');
        $check = $this->db->get($this->table);
        if($check->num_rows()>0){
            return $check->row();
        } else {
            return false;
        }
	}

	public function read_lulus_class()
	{
		$this->db->select('idkelas');
		$this->db->limit(1);
        $this->db->where('k_romawi','LULUS');
        $check = $this->db->get($this->table);
        if($check->num_rows()>0){
            return $check->row();
        } else {
            return false;
        }
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
		$this->db->where('idkelas',$id);
		$this->db->delete('sr_kompetensi_dasar');
		$this->db->where('idkelas',$id);
		$this->db->delete('sr_kkm');
		$this->db->where('idkelas',$id);
		$this->db->delete('sr_nso_deskripsi');
		$this->db->where('idkelas',$id);
		$this->db->delete('sr_nsp_deskripsi');
		$this->db->where('idkelas',$id);
		$this->db->delete('sr_np_deskripsi');
		$this->db->where('idkelas',$id);
		$this->db->delete('sr_nk_deskripsi');
		$this->db->where('idkelas',$id);
		$this->db->delete('sr_nilai_sosial');
		$this->db->where('idkelas',$id);
		$this->db->delete('sr_nilai_spiritual');
		$this->db->where('idkelas',$id);
		$this->db->delete('sr_nilai_pengetahuan');
		$this->db->where('idkelas',$id);
		$this->db->delete('sr_nilai_pengetahuan_utsuas');
		$this->db->where('idkelas',$id);
		$this->db->delete('sr_rencana_bs_sosial');
		$this->db->where('idkelas',$id);
		$this->db->delete('sr_rencana_bs_spiritual');
		$this->db->where('idkelas',$id);
		$this->db->delete('sr_rencana_kd_keterampilan');
		$this->db->where('idkelas',$id);
		$this->db->delete('sr_rencana_kd_pengetahuan');
		$this->db->where('idkelas',$id);
		$this->db->delete('sr_kelas_guru');
		$this->db->where('idkelas',$id);
		$this->db->delete('sr_siswa_guru');

        $this->db->where($this->id,$id);
        $this->db->delete($this->table);
    }

	// ************* WALI KELAS ************* \\
	public function check_kelas($id)
	{
		$this->db->where('idusers',$id);
		$check = $this->db->get($this->table);
		if ($check->num_rows()>0){
			return $check->row();
		} else {
			return false;
		}
	}

	// ************* GURU ************* \\
	public function list_kelas_by_id($id)
    {
        $this->db->order_by('k_tingkat','ASC');
		$this->db->join('sr_kelas_guru','sr_kelas_guru.idkelas = sr_kelas.idkelas','');
		$this->db->where('sr_kelas_guru.idusers',$id);
		$query = $this->db->get($this->table);
		if ($query->num_rows() > 0){
			foreach ($query->result_array() as $row){
				$result[''] = '- Pilih Kelas -';
				$result[$row['idkelas']] = ucwords($row['k_romawi'].' - '.$row['k_keterangan']);
			}
			return $result;
		}
	}
	
}