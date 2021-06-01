<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Model_pengetahuan extends CI_Model
{
    protected $table = 'sr_nilai_pengetahuan';
	protected $id = 'idnilai_pengetahuan';
	protected $order = 'DESC';
    
	var $column = array('idnilai_pengetahuan','s_nama','np_harian','idnilai_pengetahuan','idnilai_pengetahuan','idnilai_pengetahuan','idnilai_pengetahuan','idnilai_pengetahuan','idnilai_pengetahuan','idnilai_pengetahuan');

	function _get_datatables_query()
	{
        $this->db->join('sr_tahun_pelajaran','sr_tahun_pelajaran.idtahun_pelajaran = sr_nilai_pengetahuan.idtahun_pelajaran','left');
        $this->db->join('sr_users','sr_users.idusers = sr_nilai_pengetahuan.idusers','left');
        $this->db->join('sr_siswa','sr_siswa.idsiswa = sr_nilai_pengetahuan.idsiswa','left');
        $this->db->join('sr_kelas','sr_kelas.idkelas = sr_siswa.idkelas','left');
        $this->db->join('sr_kompetensi_dasar','sr_kompetensi_dasar.idkompetensi_dasar = sr_nilai_pengetahuan.idkompetensi_dasar','left');
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

	public function get_datatables($idkelas,$idmapel,$idkd,$tahun,$id)
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'],$_POST['start']);
        $this->db->where('sr_nilai_pengetahuan.idkelas',$idkelas);
        $this->db->where('sr_nilai_pengetahuan.idmata_pelajaran',$idmapel);
        $this->db->where('sr_nilai_pengetahuan.idkompetensi_dasar',$idkd);
        $this->db->where('sr_nilai_pengetahuan.idtahun_pelajaran',$tahun);
		$this->db->where('sr_nilai_pengetahuan.idusers',$id);
		$query = $this->db->get();
		return $query->result();
    }

    // baru ditambah 1-1-21
    public function get_datatables_siswa($idkelas,$tahun,$id)
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'],$_POST['start']);
        $this->db->where('sr_nilai_pengetahuan.idkelas',$idkelas);
        $this->db->where('sr_nilai_pengetahuan.idtahun_pelajaran',$tahun);
        $this->db->where('sr_nilai_pengetahuan.idusers',$id);
        $this->db->group_by('sr_nilai_pengetahuan.idsiswa');
		$query = $this->db->get();
		return $query->result();
    }

	public function count_filtered($idkelas,$idmapel,$idkd,$tahun,$id)
	{
		$this->_get_datatables_query();
        $this->db->where('sr_nilai_pengetahuan.idkelas',$idkelas);
        $this->db->where('sr_nilai_pengetahuan.idmata_pelajaran',$idmapel);
        $this->db->where('sr_nilai_pengetahuan.idkompetensi_dasar',$idkd);
        $this->db->where('sr_nilai_pengetahuan.idtahun_pelajaran',$tahun);
		$this->db->where('sr_nilai_pengetahuan.idusers',$id);
		$query = $this->db->get();
		return $query->num_rows();
    }

	public function count_all($idkelas,$idmapel,$idkd,$tahun,$id)
	{
        $this->db->from($this->table);
        $this->db->join('sr_tahun_pelajaran','sr_tahun_pelajaran.idtahun_pelajaran = sr_nilai_pengetahuan.idtahun_pelajaran','left');
        $this->db->join('sr_users','sr_users.idusers = sr_nilai_pengetahuan.idusers','left');
        $this->db->join('sr_siswa','sr_siswa.idsiswa = sr_nilai_pengetahuan.idsiswa','left');
        $this->db->join('sr_kelas','sr_kelas.idkelas = sr_siswa.idkelas','left');
        $this->db->join('sr_kompetensi_dasar','sr_kompetensi_dasar.idkompetensi_dasar = sr_nilai_pengetahuan.idkompetensi_dasar','left');
        $this->db->where('sr_nilai_pengetahuan.idkelas',$idkelas);
        $this->db->where('sr_nilai_pengetahuan.idmata_pelajaran',$idmapel);
        $this->db->where('sr_nilai_pengetahuan.idkompetensi_dasar',$idkd);
        $this->db->where('sr_nilai_pengetahuan.idtahun_pelajaran',$tahun);
		$this->db->where('sr_nilai_pengetahuan.idusers',$id);
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
            return $check->result();
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
            return $check->result();
        } else {
            return false;
        }
    }

    public function read_np_deskripsi($tahun,$idmapel,$id,$idkelas,$idsiswa)
    {
        $this->db->where('idtahun_pelajaran',$tahun);
        $this->db->where('idmata_pelajaran',$idmapel);
        $this->db->where('idusers',$id);
        $this->db->where('idkelas',$idkelas);
        $this->db->where('idsiswa',$idsiswa);
        $check = $this->db->get('sr_np_deskripsi');
        if ($check->num_rows()>0){
            return $check->row();
        } else {
            return false;
        }
    }

    public function read_all_np_deskripsi($tahun,$idmapel,$idkelas,$idsiswa)
    {
        $this->db->where('idtahun_pelajaran',$tahun);
        $this->db->where('idmata_pelajaran',$idmapel);
        $this->db->where('idkelas',$idkelas);
        $this->db->where('idsiswa',$idsiswa);
        $check = $this->db->get('sr_np_deskripsi');
        if ($check->num_rows()>0){
            return $check->row();
        } else {
            return false;
        }
    }

    public function create_np_deskripsi($data)
    {
        $this->db->insert('sr_np_deskripsi',$data);
    }

    public function update_np_deskripsi($data,$id)
    {
        $this->db->where('idnp_deskripsi',$id);
        $this->db->update('sr_np_deskripsi',$data);
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

    public function check_data_pengetahuan($idkelas,$idmapel,$idkd,$tahun,$id)
    {
        $this->db->where('idtahun_pelajaran',$tahun);
        $this->db->where('idkelas',$idkelas);
        $this->db->where('idmata_pelajaran',$idmapel);
        $this->db->where('idkompetensi_dasar',$idkd);
        $this->db->where('idusers',$id);
        $check = $this->db->get($this->table)->num_rows();
        if($check>0){
            return true;
        } else {
            return false;
        }
    }

    public function check_duplikat_siswa($idsiswa,$idkelas,$idmapel,$idkd)
    {   
        $this->db->where('idusers',$this->session->userdata('user_id'));
        $this->db->where('idsiswa',$idsiswa);
        $this->db->where('idtahun_pelajaran',$this->session->userdata('tahun'));
        $this->db->where('idkelas',$idkelas);
        $this->db->where('idmata_pelajaran',$idmapel);
        $this->db->where('idkompetensi_dasar',$idkd);
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

    public function reset_data_harian($idkelas,$idmapel,$idkd)
    {
        $this->db->where('idkelas',$idkelas);
        $this->db->where('idmata_pelajaran',$idmapel);
        $this->db->where('idkompetensi_dasar',$idkd);
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

    public function delete_old_data($id,$idkelas,$idmapel,$idkd)
    {
        $this->db->limit(1);
        $this->db->where('idsiswa',$id);
        $this->db->where('idusers',$this->session->userdata('user_id'));
        $this->db->where('idtahun_pelajaran',$this->session->userdata('tahun'));
        $this->db->where('idkelas',$idkelas);
        $this->db->where('idmata_pelajaran',$idmapel);
        $this->db->where('idkompetensi_dasar',$idkd);
        $this->db->order_by($this->id,'DESC');
        $this->db->delete($this->table);
    }
    
    public function batch_pengetahuan($tahun,$id,$idkelas,$idmapel,$idkd)
    {
        $this->db->select('idsiswa');
        $this->db->where('idkelas',$idkelas);
        $siswa = $this->db->get('sr_siswa');
        if($siswa->num_rows()>0){
            $result = array();
            foreach ($siswa->result() as $row){
                $result[] = [
                    'idtahun_pelajaran' => $tahun,
                    'idmata_pelajaran' => $idmapel,
                    'idkompetensi_dasar' => $idkd,
                    'idusers' => $id,
                    'idsiswa' => $row->idsiswa,
                    'idkelas' => $idkelas,
                    'np_harian' => ''
                ];
            }
            $this->db->insert_batch('sr_nilai_pengetahuan', $result);
            return true;
        } else {
            return false;
        }
    }

    public function batch_pengetahuan_new($tahun,$id,$idkelas,$idmapel,$idkd)
    {
        if($this->check_data(array('idnilai_pengetahuan'=>$this->session->userdata('insert_batch_pengetahuan')))){
            return false;
        }
        $this->db->select('*');
        $this->db->join('sr_siswa','sr_nilai_pengetahuan.idsiswa = sr_siswa.idsiswa','left');
        $this->db->where('sr_siswa.idsiswa is not null');
        $this->db->where('sr_nilai_pengetahuan.idkelas',$idkelas);
        $this->db->where('sr_nilai_pengetahuan.idusers !=',$id);
        $this->db->where('sr_nilai_pengetahuan.idtahun_pelajaran ', $tahun);
        $this->db->where('sr_nilai_pengetahuan.idmata_pelajaran ', $idmapel);
        $check = $this->db->get('sr_nilai_pengetahuan');

        if($check->num_rows()>0){
            $result = array();
            $result_utsuas = array();
            foreach ($check->result() as $row){
                $result[] = [
                    'idtahun_pelajaran' => $tahun,
                    'idmata_pelajaran' => $idmapel,
                    'idkompetensi_dasar' => $idkd,
                    'idusers' => $id,
                    'idsiswa' => $row->idsiswa,
                    'idkelas' => $idkelas,
                    'np_harian' => ''
                ];
            }
            $this->db->insert_batch('sr_nilai_pengetahuan', $result);
            $this->session->set_userdata('insert_batch_pengetahuan',$this->db->insert_id());
            return true;
        } else {
            $this->session->unset_userdata('insert_batch_pengetahuan');
            return false;
        }
    }
	
}