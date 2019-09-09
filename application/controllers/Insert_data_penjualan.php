<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Insert_data_penjualan extends REST_Controller {

	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('Global_m');
	}

	public function index_post()
	{

		$DataPenjualan = $this->post();

		// var_dump($DataPenjualan);exit();
		$this->db->trans_begin(); //transaction


		
		$data = array();
		$data['NamaPelanggan'] = $DataPenjualan['NamaPelanggan'];
		$data['Tanggal'] = $DataPenjualan['Tanggal'];
		$data['Jam'] = $DataPenjualan['Jam'];
		$data['Total'] = $DataPenjualan['Total'];
		$data['BayarTunai'] = $DataPenjualan['BayarTunai'];
		$data['Kembali'] = $DataPenjualan['Kembali'];

		$result = $this->Global_m->insertPenjualan($data); // insert datapenjualan

		if ($result > 0) { // mengecek apakah datapenjualan berhasil disimpan( >1 = ya | 0 = tidak)
			
			$dataDetail = array();
			$j = 0;
			foreach ($DataPenjualan['DetilPenjualan'] as $key => $val) {

				$dataDetail[$j]['NamaItem'] = $val['Item'];
				$dataDetail[$j]['Quantity'] = $val['Qty'];
				$dataDetail[$j]['HargaSatuan'] = $val['HargaSatuan'];
				$dataDetail[$j]['SubTotal'] = $val['SubTotal'];

				$j++;
			}
			$this->Global_m->insertPenjualanDetail($dataDetail); //insert batch datadetailpenjualan
		}
		

		if ($this->db->trans_status() === FALSE)
		{
		        $this->db->trans_rollback();
		        $response = array("status"=>"failed");
				$this->set_response($response, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
		}
		else
		{
		        $this->db->trans_commit();
		        $response = array("status"=>"success");
				$this->set_response($response, REST_Controller::HTTP_OK);
		}





		
		
	}

}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */