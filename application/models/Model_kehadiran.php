<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Model_kehadiran extends CI_Model
{
    protected $table = 'sr_kehadiran';
	protected $id = 'idkehadiran';
	protected $order = 'DESC';
    
	var $column = array('idkehadiran','sr_kelas.k_tingkat','s_nama','kh_sakit','kh_izin','kh_tanpa_keterangan','kh_created','sr_siswa.idsiswa');

	function _get_datatables_query()
	{
        $this->db->join('sr_tahun_pelajaran','sr_tahun_pelajaran.idtahun_pelajaran = sr_kehadiran.idtahun_pelajaran','left');
        $this->db->join('sr_users','sr_users.idusers = sr_kehadiran.idusers','left');
        $this->db->join('sr_siswa','sr_siswa.idsiswa = sr_kehadiran.idsiswa','left');
        $this->db->join('sr_kelas','sr_kelas.idkelas = sr_siswa.idkelas','left');
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
    
    var $column_admin = array('idkehadiran','sr_kelas.k_tingkat','sr_siswa.s_nama','kh_sakit','kh_izin','kh_tanpa_keterangan','users.first_name','kh_created','sr_siswa.idsiswa');

	function _get_datatables_query_admin()
	{
        $this->db->join('sr_tahun_pelajaran','sr_tahun_pelajaran.idtahun_pelajaran = sr_kehadiran.idtahun_pelajaran','left');
        $this->db->join('sr_users','sr_users.idusers = sr_kehadiran.idusers','left');
        $this->db->join('users','users.id = sr_users.idusers','left');
        $this->db->join('sr_siswa','sr_siswa.idsiswa = sr_kehadiran.idsiswa','left');
        $this->db->join('sr_kelas','sr_kelas.idkelas = sr_siswa.idkelas','left');
		$this->db->from($this->table);

		$i = 0;

		foreach ($this->column_admin as $item){
			if ($_POST['search']['value']){
				if ($i===0){
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_admin) - 1 == $i){
					$this->db->group_end();
				}
			}
			$column_admin[$i] = $item;
			$i++;
		}

		if (isset($_POST['order'])){
			$this->db->order_by($column_admin[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)){
			$order = $this->order;
			$this->db->order_by(key($order),$order[key($order)]);
		}
	}

	public function get_datatables($tahun,$id)
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'],$_POST['start']);
        $this->db->where('sr_kehadiran.idtahun_pelajaran',$tahun);
		$this->db->where('sr_users.idusers',$id);
		$query = $this->db->get();
		return $query->result();
    }
    
    public function get_datatables_admin($tahun,$idusers)
	{
		$this->_get_datatables_query_admin();
		if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'],$_POST['start']);
        $this->db->where('sr_kehadiran.idtahun_pelajaran',$tahun);
        $this->db->where('sr_kehadiran.idusers',$idusers);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_filtered($tahun,$id)
	{
		$this->_get_datatables_query();
        $this->db->where('sr_kehadiran.idtahun_pelajaran',$tahun);
		$this->db->where('sr_users.idusers',$id);
		$query = $this->db->get();
		return $query->num_rows();
    }
    
    public function count_filtered_admin($tahun,$idusers)
	{
		$this->_get_datatables_query_admin();
        $this->db->where('sr_kehadiran.idtahun_pelajaran',$tahun);
        $this->db->where('sr_kehadiran.idusers',$idusers);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($tahun,$id)
	{
		$this->db->from($this->table);
        $this->db->where('idtahun_pelajaran',$tahun);
        $this->db->join('sr_siswa','sr_siswa.idsiswa = sr_kehadiran.idsiswa','left');
        $this->db->join('sr_kelas','sr_kelas.idkelas = sr_siswa.idkelas','left');
		$this->db->where('sr_kelas.idkelas',$id);
		return $this->db->count_all_results();
    }

    public function count_all_admin($tahun,$idusers)
	{
		$this->db->from($this->table);
        $this->db->where('sr_kehadiran.idtahun_pelajaran',$tahun);
        $this->db->where('sr_kehadiran.idusers',$idusers);
        $this->db->join('sr_siswa','sr_siswa.idsiswa = sr_kehadiran.idsiswa','left');
        $this->db->join('sr_kelas','sr_kelas.idkelas = sr_siswa.idkelas','left');
		return $this->db->count_all_results();
    }
    
    public function read_data_by_id($id)
    {
		$this->db->select('*','edit as mode');
        $this->db->join('sr_siswa','sr_siswa.idsiswa = sr_kehadiran.idsiswa','left');
        $this->db->where($this->id,$id);
        return $this->db->get($this->table)->row_array();
    }
    
    public function read_data_by_siswa($id,$tahun,$idusers)
    {
		$this->db->select('*','edit as mode');
        $this->db->join('sr_siswa','sr_siswa.idsiswa = sr_kehadiran.idsiswa','left');
        $this->db->where('sr_kehadiran.idtahun_pelajaran',$tahun);
        $this->db->where('sr_kehadiran.idusers',$idusers);
        $this->db->where('sr_kehadiran.idsiswa',$id);
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

    public function check_data_kehadiran($tahun,$id)
    {
        $this->db->where('idtahun_pelajaran',$tahun);
        $this->db->where('idusers',$id);
        $check = $this->db->get($this->table)->num_rows();
        if($check>0){
            return true;
        } else {
            return false;
        }
    }

    public function check_duplikat_siswa($idsiswa)
    {   
        $this->db->where('idusers',$this->session->userdata('user_id'));
        $this->db->where('idsiswa',$idsiswa);
        $this->db->where('idtahun_pelajaran',$this->session->userdata('tahun'));
        $check = $this->db->get($this->table)->num_rows();
        if($check>1){
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

    public function reset_data()
    {
        $this->db->where('idusers',$this->session->userdata('user_id'));
        $this->db->where('idtahun_pelajaran',$this->session->userdata('tahun'));
        $this->db->delete($this->table);
        return true;
    }

    public function delete_data($id)
    {
        $this->db->where($this->id,$id);
        $this->db->delete($this->table);
    }

    public function delete_old_data($id)
    {
        $this->db->limit(1);
        $this->db->where('idsiswa',$id);
        $this->db->where('idusers',$this->session->userdata('user_id'));
        $this->db->where('idtahun_pelajaran',$this->session->userdata('tahun'));
        $this->db->order_by($this->id,'DESC');
        $this->db->delete($this->table);
    }
    
    public function batch_kehadiran($tahun,$id,$idkelas)
    {
        $this->db->select('idsiswa');
        $this->db->where('idkelas',$idkelas);
        $siswa = $this->db->get('sr_siswa');
        if($siswa->num_rows()>0){
            $result = array();
            foreach ($siswa->result() as $row){
                $result[] = [
                    'idtahun_pelajaran' => $tahun,
                    'idusers' => $id,
                    'idsiswa' => $row->idsiswa,
                    'kh_sakit' => 0,
                    'kh_izin' => 0,
                    'kh_tanpa_keterangan' => 0,
                    'kh_created' => date('Y-m-d H:i:s')
                ];
            }
            $this->db->insert_batch('sr_kehadiran', $result);
            return true;
        } else {
            return false;
        }
    }

    public function batch_kehadiran_new($tahun,$id,$idkelas)
    {
        if($this->check_data(array('idkehadiran'=>$this->session->userdata('insert_batch_kehadiran')))){
            return false;
        }
        $this->db->select('sr_siswa.idsiswa');
        $this->db->join('sr_siswa','sr_kehadiran.idsiswa = sr_siswa.idsiswa','left');
        $this->db->where('sr_siswa.idkelas',$idkelas);
        $this->db->where('sr_siswa.idsiswa is not null');
        $this->db->where('sr_kehadiran.idusers !=',$id);
        $this->db->where('sr_kehadiran.idtahun_pelajaran ', $tahun);
        $this->db->group_by('sr_kehadiran.idusers');
        $check = $this->db->get('sr_kehadiran');

        if($check->num_rows()>0){
            $result = array();
            foreach ($check->result() as $row){
                $result[] = [
                    'idtahun_pelajaran' => $tahun,
                    'idusers' => $id,
                    'idsiswa' => $row->idsiswa,
                    'kh_sakit' => 0,
                    'kh_izin' => 0,
                    'kh_tanpa_keterangan' => 0,
                    'kh_created' => date('Y-m-d H:i:s')
                ];
            }
            $this->db->insert_batch('sr_kehadiran', $result);
            $this->session->set_userdata('insert_batch_kehadiran',$this->db->insert_id());
            return true;
        } else {
            $this->session->unset_userdata('insert_batch_kehadiran');
            return false;
        }
    }

    public function update_batch_hadir($tahun,$id,$idkelas)
    {
        $this->db->select('*');
        $this->db->join('sr_siswa','sr_kehadiran.idsiswa = sr_siswa.idsiswa','left');
        $this->db->where('sr_siswa.idkelas',$idkelas);
        $this->db->where('sr_siswa.idsiswa is not null');
        $this->db->where('sr_kehadiran.idusers !=',$id);
        $this->db->where('sr_kehadiran.idtahun_pelajaran ', $tahun);
        $check = $this->db->get('sr_kehadiran');

        if($check->num_rows()>0){
            $result = array();
            $idresult = array();
            foreach ($check->result() as $row){
                $result[] = [
                    'idtahun_pelajaran' => $tahun,
                    'idusers' => $id,
                    'idsiswa' => $row->idsiswa,
                    'kh_sakit' => 0,
                    'kh_izin' => 0,
                    'kh_tanpa_keterangan' => 0,
                    'kh_created' => date('Y-m-d H:i:s')
                ];

                $iddelete = $row->idkehadiran;
                $this->db->where('idkehadiran',$iddelete);
                $this->db->delete('sr_kehadiran');
            }
            $this->db->insert_batch('sr_kehadiran', $result);
            return true;
        } else {
            return false;
        }
    }
	
}