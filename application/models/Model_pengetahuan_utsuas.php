<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Model_pengetahuan_utsuas extends CI_Model
{
    protected $table = 'sr_nilai_pengetahuan_utsuas';
	protected $id = 'idnp_utsuas';
	protected $order = 'DESC';
    
	var $column = array('idnp_utsuas','s_nama','np_uts','np_uas');

	function _get_datatables_query()
	{
        $this->db->join('sr_tahun_pelajaran','sr_tahun_pelajaran.idtahun_pelajaran = sr_nilai_pengetahuan_utsuas.idtahun_pelajaran','left');
        $this->db->join('sr_users','sr_users.idusers = sr_nilai_pengetahuan_utsuas.idusers','left');
        $this->db->join('sr_siswa','sr_siswa.idsiswa = sr_nilai_pengetahuan_utsuas.idsiswa','left');
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

	public function get_datatables($idkelas,$idmapel,$tahun,$id)
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'],$_POST['start']);
        $this->db->where('sr_nilai_pengetahuan_utsuas.idkelas',$idkelas);
        $this->db->where('sr_nilai_pengetahuan_utsuas.idmata_pelajaran',$idmapel);
        $this->db->where('sr_nilai_pengetahuan_utsuas.idtahun_pelajaran',$tahun);
		$this->db->where('sr_nilai_pengetahuan_utsuas.idusers',$id);
		$query = $this->db->get();
		return $query->result();
    }

	public function count_filtered($idkelas,$idmapel,$tahun,$id)
	{
		$this->_get_datatables_query();
        $this->db->where('sr_nilai_pengetahuan_utsuas.idkelas',$idkelas);
        $this->db->where('sr_nilai_pengetahuan_utsuas.idmata_pelajaran',$idmapel);
        $this->db->where('sr_nilai_pengetahuan_utsuas.idtahun_pelajaran',$tahun);
		$this->db->where('sr_nilai_pengetahuan_utsuas.idusers',$id);
		$query = $this->db->get();
		return $query->num_rows();
    }

	public function count_all($idkelas,$idmapel,$tahun,$id)
	{
        $this->db->from($this->table);
        $this->db->join('sr_tahun_pelajaran','sr_tahun_pelajaran.idtahun_pelajaran = sr_nilai_pengetahuan_utsuas.idtahun_pelajaran','left');
        $this->db->join('sr_users','sr_users.idusers = sr_nilai_pengetahuan_utsuas.idusers','left');
        $this->db->join('sr_siswa','sr_siswa.idsiswa = sr_nilai_pengetahuan_utsuas.idsiswa','left');
        $this->db->join('sr_kelas','sr_kelas.idkelas = sr_siswa.idkelas','left');
        $this->db->where('sr_nilai_pengetahuan_utsuas.idkelas',$idkelas);
        $this->db->where('sr_nilai_pengetahuan_utsuas.idmata_pelajaran',$idmapel);
        $this->db->where('sr_nilai_pengetahuan_utsuas.idtahun_pelajaran',$tahun);
		$this->db->where('sr_nilai_pengetahuan_utsuas.idusers',$id);
		return $this->db->count_all_results();
    }
    
    public function read_data_by_id($id)
    {
		$this->db->select('*','edit as mode');
        $this->db->join('sr_siswa','sr_siswa.idsiswa = sr_pengetahuan.idsiswa','left');
        $this->db->where($this->id,$id);
        return $this->db->get($this->table)->row_array();
    }
    
    public function read_data_siswa($idsiswa,$idkelas,$idmapel,$tahun,$id)
    {
        $this->db->where('idtahun_pelajaran',$tahun);
        $this->db->where('idkelas',$idkelas);
        $this->db->where('idmata_pelajaran',$idmapel);
        $this->db->where('idusers',$id);
        $this->db->where('idsiswa',$idsiswa);
        $check = $this->db->get($this->table);
        if($check->num_rows()>0){
            return $check->row();
        } else {
            return false;
        }
    }

    public function read_all_data_siswa($idsiswa,$idkelas,$idmapel,$tahun)
    {
        $this->db->where('idtahun_pelajaran',$tahun);
        $this->db->where('idkelas',$idkelas);
        $this->db->where('idmata_pelajaran',$idmapel);
        $this->db->where('idsiswa',$idsiswa);
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

    public function check_data_pengetahuan($idkelas,$idmapel,$tahun,$id)
    {
        $this->db->where('idtahun_pelajaran',$tahun);
        $this->db->where('idkelas',$idkelas);
        $this->db->where('idmata_pelajaran',$idmapel);
        $this->db->where('idusers',$id);
        $check = $this->db->get($this->table)->num_rows();
        if($check>0){
            return true;
        } else {
            return false;
        }
    }

    public function check_duplikat_siswa_utsuas($idsiswa,$idkelas,$idmapel)
    {   
        $this->db->where('idusers',$this->session->userdata('user_id'));
        $this->db->where('idsiswa',$idsiswa);
        $this->db->where('idtahun_pelajaran',$this->session->userdata('tahun'));
        $this->db->where('idkelas',$idkelas);
        $this->db->where('idmata_pelajaran',$idmapel);
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

    public function reset_data_utsuas($idkelas,$idmapel)
    {
        $this->db->where('idkelas',$idkelas);
        $this->db->where('idmata_pelajaran',$idmapel);
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

    public function delete_old_data($id,$idkelas,$idmapel)
    {
        $this->db->limit(1);
        $this->db->where('idsiswa',$id);
        $this->db->where('idusers',$this->session->userdata('user_id'));
        $this->db->where('idtahun_pelajaran',$this->session->userdata('tahun'));
        $this->db->where('idkelas',$idkelas);
        $this->db->where('idmata_pelajaran',$idmapel);
        $this->db->order_by($this->id,'DESC');
        $this->db->delete($this->table);
        
    }
    
    public function batch_pengetahuan($tahun,$id,$idkelas,$idmapel)
    {
        $this->db->select('idsiswa');
        $this->db->where('idkelas',$idkelas);
        $siswa = $this->db->get('sr_siswa');
        if($siswa->num_rows()>0){
            $result_utsuas = array();
            foreach ($siswa->result() as $row){
                $result_utsuas[] = [
                    'idtahun_pelajaran' => $tahun,
                    'idmata_pelajaran' => $idmapel,
                    'idusers' => $id,
                    'idkelas' => $idkelas,
                    'idsiswa' => $row->idsiswa,
                    'np_uts' => 0,
                    'np_uas' => 0
                ];
            }
            $this->db->insert_batch('sr_nilai_pengetahuan_utsuas', $result_utsuas);
            return true;
        } else {
            return false;
        }
    }
    
    public function batch_pengetahuan_new($tahun,$id,$idkelas,$idmapel)
    {
        if($this->check_data(array('idnp_utsuas'=>$this->session->userdata('insert_batch_pengetahuan_utsuas')))){
            return false;
        }
        $this->db->select('*');
        $this->db->join('sr_siswa','sr_nilai_pengetahuan_utsuas.idsiswa = sr_siswa.idsiswa','left');
        $this->db->where('sr_siswa.idkelas',$idkelas);
        $this->db->where('sr_siswa.idsiswa is not null');
        $this->db->where('sr_nilai_pengetahuan_utsuas.idusers !=',$id);
        $this->db->where('sr_nilai_pengetahuan_utsuas.idtahun_pelajaran ', $tahun);
        $this->db->where('sr_nilai_pengetahuan_utsuas.idmata_pelajaran ', $idmapel);
        $check = $this->db->get('sr_nilai_pengetahuan_utsuas');

        if($check->num_rows()>0){
            $result_utsuas = array();
            foreach ($check->result() as $row){
                $result_utsuas[] = [
                    'idtahun_pelajaran' => $tahun,
                    'idmata_pelajaran' => $idmapel,
                    'idusers' => $id,
                    'idkelas' => $idkelas,
                    'idsiswa' => $row->idsiswa,
                    'np_uts' => 0,
                    'np_uas' => 0
                ];
                // $iddelete = $row->idnp_utsuas;
                // $this->db->where('idnp_utsuas',$iddelete);
                // $this->db->delete('sr_nilai_pengetahuan_utsuas');
            }
            $this->db->insert_batch('sr_nilai_pengetahuan_utsuas', $result_utsuas);
            $this->session->set_userdata('insert_batch_pengetahuan_utsuas',$this->db->insert_id());
            return true;
        } else {
            $this->session->unset_userdata('insert_batch_pengetahuan_utsuas');
            return false;
        }
    }
}