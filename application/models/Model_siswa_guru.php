<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Model_siswa_guru extends CI_Model
{
    protected $table = 'sr_siswa_guru';
	protected $id = 'idsiswa_guru';
	protected $order = 'DESC';

	var $column = array('idsiswa_guru','k_tingkat','s_nisn','s_nama','s_nik','s_jenis_kelamin','s_tl_idkota','s_tanggal_lahir','s_wali','s_dusun','s_domisili','s_abk','s_bsm_pip','s_keluarga_miskin','idsiswa_guru');

	function _get_datatables_query()
	{
        $this->db->join('sr_tahun_pelajaran','sr_tahun_pelajaran.idtahun_pelajaran = sr_siswa_guru.idtahun_pelajaran','left');
        $this->db->join('sr_kelas','sr_kelas.idkelas = sr_siswa_guru.idkelas','left');
		$this->db->join('sr_siswa','sr_siswa.idsiswa = sr_siswa_guru.idsiswa','left');
        $this->db->join('sr_provinsi','sr_provinsi.province_id = sr_siswa.s_tl_idprovinsi','left');
		$this->db->join('sr_kota','sr_kota.city_id = sr_siswa.s_tl_idkota','left');
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
		$this->db->where('sr_kelas.idusers',$id);
		$this->db->where('sr_siswa_guru.idtahun_pelajaran',$this->session->userdata('tahun'));
		$query = $this->db->get();
		return $query->result();
	}

	public function count_filtered($id)
	{
		$this->_get_datatables_query();
        $this->db->where('sr_kelas.idusers',$id);
        $this->db->where('sr_tahun_pelajaran.idtahun_pelajaran',$this->session->userdata('tahun'));
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($id)
	{
		$this->db->from($this->table);
        $this->db->where('idkelas',$id);
        $this->db->where('idtahun_pelajaran',$this->session->userdata('tahun'));
		return $this->db->count_all_results();
    }

    public function create_data($data)
    {
        $this->db->insert($this->table,$data);
    }
    
    public function read_data_by_id($id)
    {
		$this->db->select('*','edit as mode');
		$this->db->join('sr_siswa','sr_siswa.idsiswa = sr_siswa_guru.idsiswa','left');
        $this->db->where($this->id,$id);
        return $this->db->get($this->table)->row_array();
    }
    
    public function read_data_by_siswa($id,$tahun,$idusers)
    {
		$this->db->select('*','edit as mode');
        $this->db->join('sr_siswa','sr_siswa.idsiswa = sr_siswa_guru.idsiswa','left');
        $this->db->join('sr_kelas','sr_kelas.idkelas = sr_siswa_guru.idkelas','left'); // baru ??
        $this->db->where('sr_siswa_guru.idsiswa',$id);
        $this->db->where('sr_siswa_guru.idtahun_pelajaran',$tahun);
        $this->db->where('sr_siswa_guru.idusers',$idusers);
        return $this->db->get($this->table)->row_array();
    }
    
    public function read_data_by_kelas($idkelas,$tahun,$idusers)
    {
		$this->db->select('*','edit as mode');
        $this->db->join('sr_siswa','sr_siswa.idsiswa = sr_siswa_guru.idsiswa','left');
        $this->db->join('sr_kelas','sr_kelas.idkelas = sr_siswa_guru.idkelas','left'); // baru ??
        $this->db->join('users','sr_kelas.idusers = users.id','left'); // baru ??
        $this->db->where('sr_siswa_guru.idkelas',$idkelas);
        $this->db->where('sr_siswa_guru.idtahun_pelajaran',$tahun);
        $this->db->where('sr_siswa_guru.idusers',$idusers);
        return $this->db->get($this->table)->result();
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

    // 1
    public function check_data_peserta($idkelas,$tahun,$id)
    {
        $this->db->where('idtahun_pelajaran',$tahun);
        $this->db->where('idkelas',$idkelas);
        $this->db->where('idusers',$id);
        $check = $this->db->get($this->table)->num_rows();
        if($check>0){
            return true;
        } else {
            return false;
        }
    }

    public function update_data($data,$id)
    {
        $this->db->where($this->id,$id);
        $this->db->update($this->table,$data);
    }
	
	// ************* WALI KELAS ************* \\

	var $periodik_column = array('idsiswa_guru','k_tingkat','s_nama','s_tinggi_badan','s_berat_badan','s_jarak_sekolah','s_waktu_sekolah','idsiswa_guru');

	function _get_datatables_query_p()
	{
        $this->db->join('sr_tahun_pelajaran','sr_tahun_pelajaran.idtahun_pelajaran = sr_siswa_guru.idtahun_pelajaran','left');
        $this->db->join('sr_kelas','sr_kelas.idkelas = sr_siswa_guru.idkelas','left');
		$this->db->join('sr_siswa','sr_siswa.idsiswa = sr_siswa_guru.idsiswa','left');
		$this->db->from($this->table);

		$i = 0;

		foreach ($this->periodik_column as $item){
			if ($_POST['search']['value']){
				if ($i===0){
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->periodik_column) - 1 == $i){
					$this->db->group_end();
				}
			}
			$periodik_column[$i] = $item;
			$i++;
		}

		if (isset($_POST['order'])){
			$this->db->order_by($periodik_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)){
			$order = $this->order;
			$this->db->order_by(key($order),$order[key($order)]);
		}
	}

	public function get_datatables_wali_p($id)
	{
		$this->_get_datatables_query_p();
		if ($_POST['length'] != -1)
		$this->db->limit($_POST['length'],$_POST['start']);
		$this->db->where('sr_kelas.idusers',$id);
		$this->db->where('sr_siswa_guru.idtahun_pelajaran',$this->session->userdata('tahun'));
		$query = $this->db->get();
		return $query->result();
	}

	public function count_filtered_wali_p($id)
	{
		$this->_get_datatables_query_p();
        $this->db->where('sr_kelas.idusers',$id);
        $this->db->where('sr_tahun_pelajaran.idtahun_pelajaran',$this->session->userdata('tahun'));
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_wali_p($id)
	{
		$this->db->from($this->table);
        $this->db->where('idkelas',$id);
        $this->db->where('idtahun_pelajaran',$this->session->userdata('tahun'));
		return $this->db->count_all_results();
	}

	// ************* PENGHAPUSAN FOREIGN KEY ************* \\

	public function delete_fk_kehadiran($tahun,$id)
	{
		$this->db->where('idsiswa',$id);
		$this->db->where('idtahun_pelajaran',$tahun);
        $this->db->delete('sr_kehadiran');
	}

    // ************* PENGHAPUSAN FOREIGN KEY ************* //

    public function check_duplikat_siswa($idsiswa,$idkelas)
    {   
        $this->db->where('idusers',$this->session->userdata('user_id'));
        $this->db->where('idsiswa',$idsiswa);
        $this->db->where('idtahun_pelajaran',$this->session->userdata('tahun'));
        $this->db->where('idkelas',$idkelas);
        $check = $this->db->get($this->table)->num_rows();
        if($check>1){
            return true;
        } else {
            return false;
        }
    }

    public function delete_old_data($id,$idkelas)
    {
        $this->db->limit(1);
        $this->db->where('idsiswa',$id);
        $this->db->where('idusers',$this->session->userdata('user_id'));
        $this->db->where('idtahun_pelajaran',$this->session->userdata('tahun'));
        $this->db->where('idkelas',$idkelas);
        $this->db->order_by($this->id,'DESC');
        $this->db->delete($this->table);
    }

    public function reset_data($idkelas)
    {
        $this->db->where('idkelas',$idkelas);
        $this->db->where('idusers',$this->session->userdata('user_id'));
        $this->db->where('idtahun_pelajaran',$this->session->userdata('tahun'));
        $this->db->delete($this->table);
        return true;
    }
    
    // 2
    public function batch_peserta($tahun,$id,$idkelas)
    {
        $this->db->select('idsiswa');
        $this->db->where('idkelas',$idkelas);
        $siswa = $this->db->get('sr_siswa');
        if($siswa->num_rows()>0){
            $result = array();
            foreach ($siswa->result() as $row){
                $result[] = [
                    'idtahun_pelajaran' => $tahun,
                    'idkelas' => $idkelas,
                    'idusers' => $id,
                    'idsiswa' => $row->idsiswa
                ];
            }
            $this->db->insert_batch('sr_siswa_guru', $result);
            return true;
        } else {
            return false;
        }
    }

    public function batch_peserta_new($tahun,$id,$idkelas)
    {
        if($this->check_data(array('idsiswa_guru'=>$this->session->userdata('insert_batch_peserta')))){
            return false;
        }
        $this->db->select('*');
        $this->db->join('sr_siswa','sr_siswa_guru.idsiswa = sr_siswa.idsiswa','left');
        $this->db->where('sr_siswa.idkelas',$idkelas);
        $this->db->where('sr_siswa.idsiswa is not null');
        $this->db->where('sr_siswa_guru.idusers !=',$id);
        $this->db->where('sr_siswa_guru.idtahun_pelajaran ', $tahun);
        $check = $this->db->get('sr_siswa_guru');

        if($check->num_rows()>0){
            $result = array();
            $result_utsuas = array();
            foreach ($check->result() as $row){
                $result[] = [
                    'idtahun_pelajaran' => $tahun,
                    'idkelas' => $idkelas,
                    'idusers' => $id,
                    'idsiswa' => $row->idsiswa
                ];
            }
            $this->db->insert_batch('sr_siswa_guru', $result);
            $this->session->set_userdata('insert_batch_peserta',$this->db->insert_id());
            return true;
        } else {
            $this->session->unset_userdata('insert_batch_peserta');
            return false;
        }
    }
}