<?php
defined('BASEPATH') || exit('No direct script access allowed');

class AddCar extends CI_Controller {   
	public function __construct(){
		parent::__construct();
		$this->load->model('AddCarModel');
	}

	public function index(){		
		redirect($base_url."HomeInfo");
	}

	public function Add(){		
		$data = array(		
			'PlateLicense'	=> $this->input->post('plateLicense'), 
			'Color' 		=> $this->input->post('color'),
			'CarTypeId' 	=> $this->input->post('carType'),
			'RegisterDate'	=> $this->input->post('RegisterDate'),
			'Price'			=> $this->input->post('price'),
			'Brand'			=> $this->input->post('brand'),
			'Generation'	=> $this->input->post('generation'),
			'serial'		=> $this->input->post('serial'),
			'PurchaseYear'	=> $this->input->post('PurchaseYear'),
			'Seat' 			=> $this->input->post('seat'),
			'itemLabel'		=> $this->input->post('itemLabel'),
			'DriverId' 		=> $this->input->post('driverId'),
			'fuel'			=> $this->input->post('Fuel'),
			'depID'			=> $this->input->post('depId'),
			'description'	=> $this->input->post('description')	
			);		
		$this -> AddCarModel -> add($data);
		
		$this->load->view('AllCar');
	}   

}

/* End of file AddCar.php */
/* Location: ./application/controllers/AddCar.php */