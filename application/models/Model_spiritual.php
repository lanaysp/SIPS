<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Model_spiritual extends CI_Model
{
    protected $table = 'sr_nilai_spiritual';
	protected $id = 'idnilai_spiritual';
	protected $order = 'DESC';
    
	var $column = array('idnilai_spiritual','s_nama','nilai_spiritual','nilai_spiritual_meningkat');

	function _get_datatables_query()
	{
        $this->db->join('sr_tahun_pelajaran','sr_tahun_pelajaran.idtahun_pelajaran = sr_nilai_spiritual.idtahun_pelajaran','left');
        $this->db->join('sr_users','sr_users.idusers = sr_nilai_spiritual.idusers','left');
        $this->db->join('sr_siswa','sr_siswa.idsiswa = sr_nilai_spiritual.idsiswa','left');
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

	public function get_datatables($idkelas,$tahun,$id)
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'],$_POST['start']);
        $this->db->where('sr_nilai_spiritual.idkelas',$idkelas);
        $this->db->where('sr_nilai_spiritual.idtahun_pelajaran',$tahun);
		$this->db->where('sr_nilai_spiritual.idusers',$id);
		$query = $this->db->get();
		return $query->result();
    }

	public function count_filtered($idkelas,$tahun,$id)
	{
		$this->_get_datatables_query();
        $this->db->where('sr_nilai_spiritual.idkelas',$idkelas);
        $this->db->where('sr_nilai_spiritual.idtahun_pelajaran',$tahun);
		$this->db->where('sr_nilai_spiritual.idusers',$id);
		$query = $this->db->get();
		return $query->num_rows();
    }

	public function count_all($idkelas,$tahun,$id)
	{
        $this->db->from($this->table);
        $this->db->join('sr_tahun_pelajaran','sr_tahun_pelajaran.idtahun_pelajaran = sr_nilai_spiritual.idtahun_pelajaran','left');
        $this->db->join('sr_users','sr_users.idusers = sr_nilai_spiritual.idusers','left');
        $this->db->join('sr_siswa','sr_siswa.idsiswa = sr_nilai_spiritual.idsiswa','left');
        $this->db->join('sr_kelas','sr_kelas.idkelas = sr_siswa.idkelas','left');
        $this->db->where('sr_nilai_spiritual.idkelas',$idkelas);
        $this->db->where('sr_nilai_spiritual.idtahun_pelajaran',$tahun);
		$this->db->where('sr_nilai_spiritual.idusers',$id);
		return $this->db->count_all_results();
    }
    
    public function read_data_by_id($id)
    {
		$this->db->select('*','edit as mode');
        $this->db->join('sr_siswa','sr_siswa.idsiswa = sr_nilai_spiritual.idsiswa','left');
        $this->db->where($this->id,$id);
        return $this->db->get($this->table)->row_array();
    }

    public function read_data_by_siswa($id,$tahun,$idusers)
    {
		$this->db->select('*');
        $this->db->join('sr_siswa','sr_siswa.idsiswa = sr_nilai_spiritual.idsiswa','left');
        $this->db->where('sr_nilai_spiritual.idsiswa',$id);
        $this->db->where('sr_nilai_spiritual.idtahun_pelajaran',$tahun);
        $this->db->where('sr_nilai_spiritual.idusers',$idusers);
        $check = $this->db->get('sr_nilai_spiritual');
        if ($check->num_rows() > 0){
            return $check->row();
        } else {
            return false;
        }
    }

    public function read_all_data($id,$tahun)
    {
		$this->db->select('*');
        $this->db->join('sr_siswa','sr_siswa.idsiswa = sr_nilai_spiritual.idsiswa','left');
        $this->db->where('sr_nilai_spiritual.idsiswa',$id);
        $this->db->where('sr_nilai_spiritual.idtahun_pelajaran',$tahun);
        $check = $this->db->get('sr_nilai_spiritual');
        if ($check->num_rows() > 0){
            return $check->result();
        } else {
            return false;
        }
    }

    public function read_nsp_deskripsi($tahun,$id,$idkelas,$idsiswa)
    {
        $this->db->where('idtahun_pelajaran',$tahun);
        $this->db->where('idusers',$id);
        $this->db->where('idkelas',$idkelas);
        $this->db->where('idsiswa',$idsiswa);
        $check = $this->db->get('sr_nsp_deskripsi');
        if ($check->num_rows()>0){
            return $check->row();
        } else {
            return false;
        }
    }

    public function create_nsp_deskripsi($data)
    {
        $this->db->insert('sr_nsp_deskripsi',$data);
    }

    public function update_nsp_deskripsi($data,$id)
    {
        $this->db->where('idnsp_deskripsi',$id);
        $this->db->update('sr_nsp_deskripsi',$data);
    }
    
    public function list_spiritual_by_id($id)
    {
        $this->db->order_by('idbutir_sikap','ASC');
        $explode = explode(",",$id);
        $count = (Integer)count($explode)-1;
        $idspiritual = array($id);
        for ($i=0 ; $i<=$count ; $i++){
            $idspiritual[] .= $explode[$i];
        }
        $this->db->where_in('idbutir_sikap',$idspiritual);
		$query = $this->db->get('sr_butir_sikap');
		if ($query->num_rows() > 0){
			foreach ($query->result_array() as $row){
				$result[''] = '- Pilih Penilaian -';
				$result[$row['idbutir_sikap']] = ucwords($row['bs_keterangan']);
			}
			return $result;
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

	public function check_rencana_spiritual($data)
    {
        $this->db->select('*');
        $this->db->where($data);
        return $this->db->get('sr_rencana_bs_spiritual')->row_array();
	}

    public function check_data_spiritual($idkelas,$tahun,$id)
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

    public function create_data($data)
    {
        $this->db->insert($this->table,$data);
    }

    public function update_data($data,$id)
    {
        $this->db->where($this->id,$id);
        $this->db->update($this->table,$data);
    }

    public function reset_data($idkelas)
    {
        $this->db->where('idkelas',$idkelas);
        $this->db->where('idusers',$this->session->userdata('user_id'));
        $this->db->where('idtahun_pelajaran',$this->session->userdata('tahun'));
        $this->db->delete($this->table);
        return true;
    }

    public function delete_data($id)
    {
        $this->db->where($this->id,$id);
        $this->db->delete($this->table);
        $this->session->unset_userdata('insert_batch_spiritual');
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
    
    public function batch_spiritual($tahun,$id,$idkelas)
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
                    'idkelas' => $idkelas,
                    'idsiswa' => $row->idsiswa,
                    'nilai_spiritual' => '',
                    'nilai_spiritual_meningkat' => ''
                ];
            }
            $this->db->insert_batch('sr_nilai_spiritual', $result);
            return true;
        } else {
            return false;
        }
    }

    public function batch_spiritual_new($tahun,$id,$idkelas)
    {
        if($this->check_data(array('idnilai_spiritual'=>$this->session->userdata('insert_batch_spiritual')))){
            return false;
        }
        $this->db->select('*');
        $this->db->join('sr_siswa','sr_nilai_spiritual.idsiswa = sr_siswa.idsiswa','left');
        $this->db->where('sr_siswa.idkelas',$idkelas);
        $this->db->where('sr_siswa.idsiswa is not null');
        $this->db->where('sr_nilai_spiritual.idusers !=',$id);
        $this->db->where('sr_nilai_spiritual.idtahun_pelajaran ', $tahun);
        $check = $this->db->get('sr_nilai_spiritual');

        if($check->num_rows()>0){
            $result = array();
            $result_utsuas = array();
            foreach ($check->result() as $row){
                $result[] = [
                    'idtahun_pelajaran' => $tahun,
                    'idusers' => $id,
                    'idkelas' => $idkelas,
                    'idsiswa' => $row->idsiswa,
                    'nilai_spiritual' => '',
                    'nilai_spiritual_meningkat' => ''
                ];
            }
            $this->db->insert_batch('sr_nilai_spiritual', $result);
            $this->session->set_userdata('insert_batch_spiritual',$this->db->insert_id());
            return true;
        } else {
            $this->session->unset_userdata('insert_batch_spiritual');
            return false;
        }
    }
	
}