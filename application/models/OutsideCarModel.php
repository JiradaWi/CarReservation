<?php
defined('BASEPATH') || exit('No direct script access allowed');

class OutsideCarModel extends CI_Model {
	private $hireId;
	private $reserver;
	private $depID;
	private $carTypeId;
	private $startDate;
	private $endDate;
	private $place;
	private $tel;
	private $reason;

	private $plateLicense;	
	private $departmentID;
	

	public function __construct(){
		parent::__construct();		
	}

	public function getCarTypeId(){
		return $this->carTypeId;
	}

	public function setCarTypeId($carTypeId){
		$this->carTypeId = $carTypeId;
	}

	public function getDepartmentID(){
		return $this->departmentID;
	}

	public function getReserver(){
		return $this->reserver;
	}

	public function getHireId(){
		return $this->hireId;
	}

	public function getEmployeeCode(){
		return $this->employeeCode;
	}

	public function getPlateLicese(){
		return $this->plateLicense;
	}

	public function getStartDate(){
		return $this->startDate;
	}

	public function getEndDate(){
		return $this->endDate;
	}

	public function getPlace(){
		return $this->place;
	}

	public function getTel(){
		return $this->tel;
	}

	public function getReason(){
		return $this->reason;
	}

	public function getDepId(){
		return $this->depID;
	}

	public function setDepId($depId){
		$this->depID = $depId;
	}

	public function setEmployeeCode($employeeCode){
		$this->employeeCode = $employeeCode;
	}

	public function setPlateLicense($plateLicense){
		$this->plateLicense = $plateLicense;
	}

	public function setReserver($reserver){
		$this->reserver = $reserver;
	}

	public function setStartDate($startDate){
		 $this->startDate = $startDate;
	}

	public function setEndDate($endDate){
		 $this->endDate = $endDate;
	}

	public function setPlace($place){
		 $this->place = $place;
	}

	public function setHireId($hireId){
		 $this->hireId = $hireId;
	}

	public function setTel($tel){
		 $this->tel = $tel;
	}

	public function setDepartmentID($departmentID){
		$this->departmentID = $departmentID;
	}

	public function setReason($reason){
		$this->reason = $reason;
	}

	public function add_OutsideCar($data){
		extract($data);
    	$this->db->insert('hirecar',
    		array(	
    			'depID' =>$depID ,
    			'Reserver' => $this->session->userdata['logged_in']['employeeCode'],
    			'CarTypeId' => $carTypeId,
				'StartDate' =>$dateS,
				'EndDate' => $dateE,
				'place' => $place,
				'Tel' => $tel,
				'reason' => $reason
    		));
		return true;
	}

	public function getOutsideCarFromDepID($depID){
		$query = $this->db->get_where('hirecar', array('depID' => $depID));
		return $query->result_array();
	}

	public function getOutsideInfo($id){
		$this->db->select('*');
		$this->db->from('hirecar');
		$this->db->where('Reserver', $id);
		$query = $this->db->get();

		$r = "";
		foreach ($query->result() as $row){
			$outside = new OutsideCarModel;
			$this->matchObject($outside,$row);
			if($r === ""){
				$r = array();
			}
			array_push($r,$outside);
		}
		return $r;
	}

	public function getOutsideInfoFromHire($id){
		$this->db->select('*');
		$this->db->from('hirecar');
		$this->db->where('HireId', $id);
		$query = $this->db->get();

		foreach ($query->result() as $row) {
			$data = array(
			'cartype' 	=> $row->CarTypeId,
			'startdate' => $row->StartDate,
			'enddate' 	=> $row->EndDate,
			'place' 	=> $row->place,
			'tel' 		=> $row->Tel,
			'cost' 		=> $row->Cost,
			'platelicense' => $row->PlateLicense
		);			
		}
		return $data;
	}

	private function matchObject($outside,$row){
		$outside->setHireId($row->HireId);
		$outside->setReserver($row->Reserver);
		$outside->setStartDate($row->StartDate);	
		$outside->setEndDate($row->EndDate);	
		$outside->setPlace($row->place);
		$outside->setTel($row->Tel);
		$outside->setReason($row->reason);
		$outside->setCarTypeId($row->CarTypeId);
	}

	public function AddPlateAndCost($plate, $cost, $hireid){
		$data = array(
   			'PlateLicense' => $plate ,
   			'Cost' => $cost	
		);
		$this->db->where('HireId', $hireid);
		$this->db->update('hirecar', $data); 
		//$this->db->insert('mytable', $data); 
	}

	public function checkInfo($hireid){
		$this->db->select('Cost, PlateLicense');
		$this->db->from('hirecar');
		$this->db->where('HireId', $hireid);
		$query = $this->db->get();
		foreach ($query->result() as $row){
			if($row->Cost == "0" && $row->PlateLicense == " "){
				$ans = false;
			}else{
				$ans = true;
			}
		}
		return $ans;
	}
}