<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CarModel extends CI_Model {

	public function add($input){
		
		return $this->db->insert('currentreservation', $input);
	}

	public function showReserve(){
		$query = $this->db->select('cr.*, color')      
		->from('cartype as ct')					     
		->join('cars as c', 'c.carTypeId = ct.carTypeId')      
		->join('currentreservation as cr', 'cr.plateLicense = c.plateLicense')      
		->get();

		$result = $query->result_array();
		return $result;		
	}

	public function showCar(){
		$result = "";

		$this->db->select('*');
		$car = $this->db->get('cartype');
				
		foreach ($car->result() as $row)
		{
			$result .= $row->CarType."<br>";
			$result .= "&emsp;ทะเบียน<br>";
			
			$resultPlate = $this->db->select('plateLicense')
			->from('cars')
			->join('carType', 'cars.carTypeId = carType.cartypeid')
			->where('carType', $row->CarType)
			->get();

			foreach($resultPlate->result() as $plate){

				$result .= "&emsp;&emsp;".$plate->plateLicense."<br>";

			}
			$result .= "<br>";
		}
		
		return $result;
		
	}

	

}

/* End of file CarModel.php */
/* Location: ./application/models/CarModel.php */
/*
$cars, $date, $driver, $timeS, $timeE, $plateLicense, $place
*/