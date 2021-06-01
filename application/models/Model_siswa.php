<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Model_siswa extends CI_Model
{
    protected $table = 'sr_siswa';
	protected $id = 'idsiswa';
	protected $order = 'DESC';

	var $column = array('idsiswa','k_tingkat','s_nisn','s_nama','s_nik','s_jenis_kelamin','s_tl_idkota','s_tanggal_lahir','s_wali','s_dusun','s_domisili','s_abk','s_bsm_pip','s_keluarga_miskin','idsiswa');

	function _get_datatables_query()
	{
        $this->db->join('sr_kelas','sr_kelas.idkelas = sr_siswa.idkelas','left');
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

	public function get_datatables()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
		$this->db->limit($_POST['length'],$_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_datatables_tingkat($data)
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
		$this->db->limit($_POST['length'],$_POST['start']);
		$this->db->where('sr_kelas.k_tingkat',$data);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_datatables_by_id($data)
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
		$this->db->limit($_POST['length'],$_POST['start']);
		$this->db->where('sr_kelas.idkelas',$data);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_filtered($data)
	{
		$this->_get_datatables_query();
		$this->db->where('sr_kelas.idkelas',$data);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($data)
	{
		$this->db->from($this->table);
        $this->db->join('sr_kelas','sr_kelas.idkelas = sr_siswa.idkelas','left');
		$this->db->where('sr_kelas.idkelas',$data);
		return $this->db->count_all_results();
	}
	
	public function count_all_dashboard()
	{
        $this->db->join('sr_kelas','sr_kelas.idkelas = sr_siswa.idkelas','left');
		$this->db->where('sr_kelas.k_keterangan !=','LULUS');
		$this->db->where('sr_kelas.k_keterangan !=','PINDAH');
		return $this->db->get($this->table)->num_rows();
    }
    
    public function read_data_by_id($id)
    {
		$this->db->select('*','edit as mode');
        $this->db->join('sr_kelas','sr_kelas.idkelas = sr_siswa.idkelas','left');
        $this->db->join('sr_provinsi','sr_provinsi.province_id = sr_siswa.s_tl_idprovinsi','left');
		$this->db->join('sr_kota','sr_kota.city_id = sr_siswa.s_tl_idkota','left');
        $this->db->where($this->id,$id);
        return $this->db->get($this->table)->row_array();
	}

	public function read_data_by_nisn($nisn)
    {
		$this->db->select('*','edit as mode');
        $this->db->join('sr_kelas','sr_kelas.idkelas = sr_siswa.idkelas','left');
        $this->db->join('sr_provinsi','sr_provinsi.province_id = sr_siswa.s_tl_idprovinsi','left');
		$this->db->join('sr_kota','sr_kota.city_id = sr_siswa.s_tl_idkota','left');
        $this->db->where('sr_siswa.s_nisn',$nisn);
		$check = $this->db->get($this->table);
		if ($check->num_rows()>0){
			return $check->row_array();
		} else {
			return false;
		}
	}

	public function read_data_by_idkelas($idkelas)
	{
		$this->db->where('idkelas',$idkelas);
		return $this->db->get($this->table)->num_rows();
	}

	public function read_data_by_kelas($data)
	{
		$this->db->where($data);
		return $this->db->get($this->table)->result();
	}

	public function siswa_by_class()
	{
		$this->db->join('sr_kelas','sr_kelas.idkelas = sr_siswa.idkelas','left');
        $this->db->group_by('sr_kelas.idkelas');
        $this->db->order_by('sr_kelas.k_tingkat','ASC');
        $this->db->select('sr_kelas.k_romawi');
        $this->db->select("count(*) as total");
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
	
	public function check_detail_data($data,$type)
    {
		if ($type=='email'){
			$this->db->where('s_email',$data);
		} else {
			$this->db->where('s_telepon',$data);
		}
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
		$this->db->where('idsiswa',$id);
		$this->db->delete('sr_nso_deskripsi');
		$this->db->where('idsiswa',$id);
		$this->db->delete('sr_nsp_deskripsi');
		$this->db->where('idsiswa',$id);
		$this->db->delete('sr_catatan ');
		$this->db->where('idsiswa',$id);
		$this->db->delete('sr_kesehatan_siswa');
		$this->db->where('idsiswa',$id);
		$this->db->delete('sr_prestasi');
		$this->db->where('idsiswa',$id);
		$this->db->delete('sr_ekstra_siswa');
		$this->db->where('idsiswa',$id);
		$this->db->delete('sr_kehadiran');
		$this->db->where('idsiswa',$id);
		$this->db->delete('sr_siswa_guru');
		$this->db->where('idsiswa',$id);
		$this->db->delete('sr_np_deskripsi');
		$this->db->where('idsiswa',$id);
		$this->db->delete('sr_nk_deskripsi');
		$this->db->where('idsiswa',$id);
		$this->db->delete('sr_nilai_sosial');
		$this->db->where('idsiswa',$id);
		$this->db->delete('sr_nilai_spiritual');
		$this->db->where('idsiswa',$id);
		$this->db->delete('sr_nilai_pengetahuan');
		$this->db->where('idsiswa',$id);
		$this->db->delete('sr_nilai_pengetahuan_utsuas');

		$this->db->where($this->id,$id);
		$this->db->delete($this->table);
	}
	
	// ************* WALI KELAS ************* \\

	var $periodik_column = array('idsiswa','k_tingkat','s_nama','s_tinggi_badan','s_berat_badan','s_jarak_sekolah','s_waktu_sekolah','idsiswa');

	function _get_datatables_query_p()
	{
        $this->db->join('sr_kelas','sr_kelas.idkelas = sr_siswa.idkelas','left');
        $this->db->join('sr_provinsi','sr_provinsi.province_id = sr_siswa.s_tl_idprovinsi','left');
		$this->db->join('sr_kota','sr_kota.city_id = sr_siswa.s_tl_idkota','left');
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

	public function get_datatables_wali($id)
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
		$this->db->limit($_POST['length'],$_POST['start']);
		$this->db->where('sr_kelas.idusers',$id);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_filtered_wali($id)
	{
		$this->_get_datatables_query();
		$this->db->where('sr_kelas.idusers',$id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_wali($id)
	{
		$this->db->from($this->table);
		$this->db->where('idkelas',$id);
		return $this->db->count_all_results();
	}
	
	public function get_datatables_wali_p($id)
	{
		$this->_get_datatables_query_p();
		if ($_POST['length'] != -1)
		$this->db->limit($_POST['length'],$_POST['start']);
		$this->db->where('sr_kelas.idusers',$id);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_filtered_wali_p($id)
	{
		$this->_get_datatables_query_p();
		$this->db->where('sr_kelas.idusers',$id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_wali_p($id)
	{
		$this->db->from($this->table);
		$this->db->where('idkelas',$id);
		return $this->db->count_all_results();
	}

	public function list_siswa()
	{
        $this->db->join('sr_kelas','sr_kelas.idkelas = sr_siswa.idkelas','left');
		$this->db->order_by('s_nama','ASC');
		$query = $this->db->get($this->table);
		if ($query->num_rows() > 0){
			foreach ($query->result_array() as $row){
				$result[''] = '- Pilih Siswa -';
				$result[$row['idsiswa']] = ucwords($row['s_nama'].' - NISN ('.$row['s_nisn'].')'.' - Kelas ('.$row['k_romawi'].')');
			}
			return $result;
		}
	}

	// ************* WALI KELAS ************* //

	public function list_siswa_by_wali($idkelas)
	{
		$this->db->order_by('s_nama','ASC');
		$this->db->where('idkelas',$idkelas);
		$query = $this->db->get($this->table);
		if ($query->num_rows() > 0){
			foreach ($query->result_array() as $row){
				$result[''] = '- Pilih Siswa -';
				$result[$row['idsiswa']] = ucwords($row['s_nama'].' - NISN ('.$row['s_nisn'].')');
			}
			return $result;
		}
	}

	// ************* PENGHAPUSAN FOREIGN KEY ************* \\

	public function delete_fk_kehadiran($tahun,$id)
	{
		$this->db->where('idsiswa',$id);
		$this->db->where('idtahun_pelajaran',$tahun);
        $this->db->delete('sr_kehadiran');
	}

	// ************* PENGHAPUSAN FOREIGN KEY ************* //
}