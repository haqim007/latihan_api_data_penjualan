<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Global_m extends CI_Model {

	public function insertPenjualan($data){
		$this->db->insert('penjualan', $data);

		return $this->db->affected_rows();
	}

	public function insertPenjualanDetail($data){

		$this->db->insert_batch('penjualandetil', $data);

		return $this->db->affected_rows();
	}

}

/* End of file global_m.php */
/* Location: ./application/models/global_m.php */