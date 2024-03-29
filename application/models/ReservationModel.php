<?php
defined('BASEPATH') || exit('No direct script access allowed');

class ReservationModel extends CI_Model {

	private $reserveId;
	private $employeeCode;
	private $plateLicense;
	private $startDate;
	private $endDate;
	private $place;
	private $driverId;
	private $color;
	private $carId;
	private $tel;
	private $departmentID;

	public function __construct(){
		parent::__construct();		
	}

	public function getDepartmentID(){
		return $this->departmentID;
	}

	public function getReserveId(){
		return $this->reserveId;
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

	public function getDriverId(){
		return $this->driverId;
	}

	public function getColor(){
		return $this->color;
	}

	public function getCarId(){
		return $this->carId;
	}

	public function setEmployeeCode($employeeCode){
		$this->employeeCode = $employeeCode;
	}

	public function setPlateLicense($plateLicense){
		$this->plateLicense = $plateLicense;
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

	public function setDriverId($driverId){
		$this->driverId = $driverId;
	}

	public function setColor($color){
		$this->color = $color;
	}

	public function setCarId($carId){
		$this->carId = $carId;
	}

	public function setReserveId($reserveId){
		$this->reserveId = $reserveId;
	}

	public function setTel($tel){
		$this->tel = $tel;
	}

	public function setDepartmentID($departmentID){
		$this->departmentID = $departmentID;
	}
	
	public function driverReserve(){
		$emId = $this->session->userdata['logged_in']['employeeCode'];
		$sql='SELECT cr.currentid, ct.CarType, c.PlateLicense, u.Name, cr.place, cr.StartDate, cr.EndDate '.
		'FROM currentreservation cr '.
		'join cars c on cr.carid = c.carId '.
		'join cartype ct on ct.CarTypeId = c.cartypeid '.
		'join user u on cr.EmployeeCode = u.EmployeeCode '.
		'where curdate()+1 > cr.startdate and cr.startdate> curdate() AND accept != \'1\'';
		$query= $this->db->query($sql);

		return $query;
	}

	public function checkDriver($emId){
		$sql = 'SELECT * FROM currentreservation '.
		'where driverid = \''.$emId.'\' and Accept = 1';
		$query= $this->db->query($sql);

		return $query;
	}

	public function depart($CurrentId, $driverId, $Departure, $CarMilesStart){		
		$data = array(
			'driverId' 		=> $driverId,
			'Departure' 		=> $Departure,
			'CarMilesStart' 	=> $CarMilesStart,
			'Accept'			=> "1"
			);
		$this->db->where('CurrentId', $CurrentId);
		$this->db->update('currentreservation', $data);	
	}

	public function arrive($id, $Arrival, $CarMilesEnd, $emId){		
		$sql = 'UPDATE previousreservation SET DriverId = \''.$emId.'\', Arrival = \''.$Arrival.'\', CarMilesEnd = '.$CarMilesEnd.' WHERE previousreservation.StatusId = '.$id;
		
		$query = $this->db->query('INSERT INTO previousreservation (StatusId, CarId, DriverId, EmployeeCode, depId, StartDate, EndDate, Place, Departure, CarMilesStart) SELECT currentId, carid, DriverId, EmployeeCode, depId, StartDate, EndDate, Place, Departure, CarMilesStart FROM currentreservation WHERE CurrentId = '.$id);

		$query = $this->db->query($sql);

		$this->db->delete('currentreservation', array('currentid' => $id));		
	}

	public function driving($driverId){		
		$sql='SELECT cr.currentid, ct.CarType, c.PlateLicense, u.Name, cr.place, cr.StartDate, cr.EndDate '.
		'FROM currentreservation cr '.
		'join cars c on cr.carid = c.carId '.
		'join cartype ct on ct.CarTypeId = c.cartypeid '.
		'join user u on cr.EmployeeCode = u.EmployeeCode '.
		'where cr.DriverId = \''.$driverId.'\'';
		
		$query= $this->db->query($sql);

		return $query;
	}

	public function getCurReserveFormEmpCode($employeeCode){
		$currentReserve = null;
		$r = "";
		$query = $this->db->query('SELECT cr.* , c.carId , ct.carTypeId , ct.Color , c.plateLicense FROM cartype ct JOIN cars c ON c.carTypeId = ct.carTypeId JOIN currentreservation cr ON cr.carId = c.carId where cr.EmployeeCode = '.$employeeCode);
		foreach ($query->result() as $row){
			$currentReserve = new ReservationModel;
			$this->matchReservationObject($currentReserve,$row);
			if($r === ""){
				$r = array();
			}
			array_push($r,$currentReserve);
		}		
		return $r;
	}

	public function getPrevReserveFormEmpCode($employeeCode){
		$currentReserve = null;
		$r = "";
		$query = $this->db->query('SELECT cr.* , c.carId , ct.carTypeId , ct.Color , c.plateLicense FROM cartype ct JOIN cars c ON c.carTypeId = ct.carTypeId JOIN previousreservation cr ON cr.carId = c.carId where cr.EmployeeCode = '.$employeeCode);
		foreach ($query->result() as $row){
			$currentReserve = new ReservationModel;
			$this->matchPrevObject($currentReserve,$row);
			if($r === ""){
				$r = array();
			}
			array_push($r,$currentReserve);
		}		
		return $r;
	}

	public function getCurrentReservation(){
		$reserveInfo = null;
		$r = "";
		$query = $this->db->query('SELECT cr.* , ct.Color, c.plateLicense FROM cartype ct JOIN cars c ON c.carTypeId = ct.carTypeId JOIN currentreservation cr ON cr.carId = c.carId');
		foreach ($query->result() as $row){
			$reserveInfo = new ReservationModel;
			$this->matchReservationObject($reserveInfo,$row);
			if($r === "") {
				$r = array();
			}
			array_push($r,$reserveInfo);
		}		
		return $r;	
	}

	public function getPrevReservation(){
		$reserveInfo = null;
		$r = "";
		$query = $this->db->query('SELECT cr.* , ct.Color, c.plateLicense FROM cartype ct JOIN cars c ON c.carTypeId = ct.carTypeId JOIN previousreservation cr ON cr.carId = c.carId');
		foreach ($query->result() as $row){
			$reserveInfo = new ReservationModel;
			$this->matchPrevObject($reserveInfo,$row);
			if($r === "") {
				$r = array();
			}
			array_push($r,$reserveInfo);
		}		
		return $r;	
	}

	public function getCurrentReservationFromID($rID){
		$reserveInfo = null;
		$query = $this->db->query('SELECT cr.* , c.carId , ct.carTypeId , ct.Color , c.plateLicense FROM cartype ct JOIN cars c ON c.carTypeId = ct.carTypeId JOIN currentreservation cr ON cr.carId = c.carId where CurrentId = '.$rID);
		foreach ($query->result() as $row){
			$reserveInfo = new ReservationModel;
			$this->matchReservationObject($reserveInfo,$row);
		}			
		return $reserveInfo;
	}

	public function getAllReserve(){
		$reserveInfo = null;
		$query = $this->db->query('SELECT cr.* , c.carId , ct.carTypeId , ct.Color , c.plateLicense FROM cartype ct JOIN cars c ON c.carTypeId = ct.carTypeId JOIN currentreservation cr ON cr.carId = c.carId');
		foreach ($query->result() as $row){
			$reserveInfo = new ReservationModel;
			$this->matchReservationObject($reserveInfo,$row);
		}			
		return $reserveInfo;
	}

	public function getReserveFromDate($startDateTime,$endDateTime,$carTypeId){
		$reserveInfo = null;
		$r = "";
		$query = $this->db->query('SELECT cr.* , c.carId , ct.carTypeId , ct.Color , c.plateLicense FROM cartype ct JOIN cars c ON c.carTypeId = ct.carTypeId JOIN currentreservation cr ON cr.carId = c.carId WHERE (startDate BETWEEN '. $startDateTime .' AND '. $endDateTime .') OR (endDate BETWEEN '. $startDateTime .' AND '. $endDateTime .')');
		foreach ($query->result() as $row){
			if($carTypeId == null || in_array($row->carTypeId,$carTypeId) )	{
				$reserveInfo = new ReservationModel;
				$this->matchReservationObject($reserveInfo,$row);
				if($r === "") {
					$r = array();
				}
				array_push($r,$reserveInfo);
			}
		}		
		return $r;	
	}

	public function getReserveFromCarID($carId){
		$query = $this->db->query('SELECT cr.* , c.carId , ct.carTypeId , ct.Color , c.plateLicense FROM cartype ct JOIN cars c ON c.carTypeId = ct.carTypeId JOIN currentreservation cr ON cr.carId = c.carId where c.carId = '.$carId);
		return $query->result_array();
	}

	public function getReserveFromCarTypeDriver($carTypeId ,$carId, $driverId){
		$reserveInfo = null;
		$r = "";
		$carIdCheck = $this->checkCarIdType($carId);
		$query = $this->db->query("SELECT cr.* , c.carId , ct.carTypeId , ct.Color , c.plateLicense FROM cartype ct JOIN cars c ON c.carTypeId = ct.carTypeId JOIN currentreservation cr ON cr.carId = c.carId where c.cartypeId = '".$carTypeId."' AND cr.DriverId = '". $driverId . "'" );

		foreach ($query->result() as $row) {
			if($carId == null || in_array($row->carId,$carId) || !in_array($row->carTypeId, $carIdCheck) ){
				$reserveInfo = new ReservationModel;
				$this->matchReservationObject($reserveInfo,$row);
				if($r === "") {
					$r = array();
				}
				array_push($r,$reserveInfo);
			}
		}		
		return $r;
	}

	public function getReserveFromDriver($driverId){
		$reserveInfo = null;
		$r = "";
		$query = $this->db->query("SELECT cr.* , c.carId , ct.carTypeId , ct.Color , c.plateLicense FROM cartype ct JOIN cars c ON c.carTypeId = ct.carTypeId JOIN currentreservation cr ON cr.carId = c.carId  where  cr.DriverId = '". $driverId . "'" );
		foreach ($query->result() as $row) {
				$reserveInfo = new ReservationModel;
				$this->matchReservationObject($reserveInfo,$row);
				if($r === "") {
					$r = array();
				}
				array_push($r,$reserveInfo);
			
		}		
		return $r;
	}

	public function getReserveFromCarTypeALLDriver($carTypeId ,$carId ){
		$reserveInfo = null;
		$r = "";
		$carIdCheck = $this->checkCarIdType($carId);
		$query = $this->db->query('SELECT cr.* , c.carId , ct.carTypeId , ct.Color , c.plateLicense FROM cartype ct JOIN cars c ON c.carTypeId = ct.carTypeId JOIN currentreservation cr ON cr.carId = c.carId where c.cartypeId = '.$carTypeId );

		foreach ($query->result() as $row) {
			if($carId == null || in_array($row->carId,$carId) || !in_array($row->carTypeId, $carIdCheck) ){
				$reserveInfo = new ReservationModel;
				$this->matchReservationObject($reserveInfo,$row);
				if($r === "") {
					$r = array();
				}
				array_push($r,$reserveInfo);
			}
		}		
		return $r;
	}
	public function getPreReserveFromDriver($driverId){
		$reserveInfo = null;
		$r = "";
		$query = $this->db->query("SELECT cr.* , c.carId, c.plateLicense , ct.* , c.plateLicense FROM cartype ct JOIN cars c ON c.carTypeId = ct.carTypeId JOIN previousreservation cr ON cr.carId = c.carId where cr.DriverId = '". $driverId . "'" );
		return $query->result_array();;
	}



	private function checkCarIdType($carId){
		$r = ['not','have'];
		if($carId != null){
			foreach ($carId as $value) {
				$query = $this->db->query('SELECT carTypeId FROM cars where carId = '.$value);
				foreach ($query->result() as $row){
					array_push($r,$row->carTypeId);
				}
			}
		}
		return $r;		
	}

	public function addReservation($carId, $startDate, $endDate, $depID, $place, $tel){
		$employeeCode = ($this->session->userdata['logged_in']['employeeCode']);
		if($this->checkReservation($carId, $startDate, $endDate)){
			$data = array(		
				'carId' => $carId,
				'DriverId' => 0,
				'depID' => $depID,	
				'StartDate' => $startDate,
				'EndDate' =>$endDate,			
				'place' => $place,
				'tel' => $tel,
				'EmployeeCode' =>$employeeCode
				);

			$query = $this->db->select('DriverId')
				->from('cars')
				->where('carId', $data["carId"])
				->get();
			foreach ($query->result() as $row){			
				$input["DriverId"] = $row->DriverId;
			}			
			return $this->db->insert('currentreservation', $data);
		}else{
			return false;
		}
	}

	// function for check that Reservation is not duplicate
	private function checkReservation($carId , $startDate , $endDate){
		$query = $this->db->query('SELECT carId FROM currentreservation WHERE carId = '.$carId.' AND ((EndDate BETWEEN (\''. $startDate .'\') AND (\''. $endDate .'\')) OR (StartDate BETWEEN (\''. $startDate .'\') AND (\''. $endDate .'\')) OR (StartDate <= (\''. $endDate .'\') AND EndDate >= (\''. $startDate .'\')))');
		$row = $query->row();
		if(!isset($row)){
			return true;
		}else{
			return false;
		}
	}

	public function checkReservationforEdit($carId , $startDate , $endDate , $reserveId){
		$query = $this->db->query('SELECT CurrentId FROM currentreservation WHERE  carId = '.$carId.' AND ((EndDate BETWEEN (\''. $startDate .'\') AND (\''. $endDate .'\')) OR (StartDate BETWEEN (\''. $startDate .'\') AND (\''. $endDate .'\')) OR (StartDate <= (\''. $endDate .'\') AND EndDate >= (\''. $startDate .'\')))');
		$row = $query->row();
		$num = 0;
		foreach ($query->result() as $row){
			if($row->CurrentId != $reserveId){
				$num++;
			}
		}
		if($num < 1){
			return true;
		}else{
			return false;
		}
	}

	public function checkDriverTimeforEdit($driverId , $startDate , $endDate , $reserveId){
		$query = $this->db->query('SELECT CurrentId FROM currentreservation WHERE  DriverId = '.$driverId.' AND ((EndDate BETWEEN (\''. $startDate .'\') AND (\''. $endDate .'\')) OR (StartDate BETWEEN (\''. $startDate .'\') AND (\''. $endDate .'\')) OR (StartDate <= (\''. $endDate .'\') AND EndDate >= (\''. $startDate .'\')))');
		$row = $query->row();
		$num = 0;
		foreach ($query->result() as $row){
			if($row->CurrentId != $reserveId){
				$num++;
			}
		}
		if($num < 1){
			return true;
		}else{
			return false;
		}
	}

	public function getCurReserveFormDepID($depID){
		$currentReserve = null;
		$r = "";
		$query = $this->db->query('SELECT cr.* , c.carId , ct.carTypeId , ct.Color , c.plateLicense FROM cartype ct JOIN cars c ON c.carTypeId = ct.carTypeId JOIN currentreservation cr ON cr.carId = c.carId where cr.depID = '.$depID);
		foreach ($query->result() as $row){
			$currentReserve = new ReservationModel;
			$this->matchReservationObject($currentReserve,$row);
			if($r === ""){
				$r = array();
			}
			array_push($r,$currentReserve);
		}		
		return $r;
	}

	public function getPrevReserveFormDepID($depID){
		$currentReserve = null;
		$r = "";
		$query = $this->db->query('SELECT cr.* , c.carId , ct.carTypeId , ct.Color , c.plateLicense FROM cartype ct JOIN cars c ON c.carTypeId = ct.carTypeId JOIN previousreservation cr ON cr.carId = c.carId where cr.depID = '.$depID);
		foreach ($query->result() as $row){
			$currentReserve = new ReservationModel;
			$this->matchPrevObject($currentReserve,$row);
			if($r === ""){
				$r = array();
			}
			array_push($r,$currentReserve);
		}		
		return $r;
	}

	public function deleteReserve($rID){
		$this->db->where('CurrentId', $rID);
		$this->db->delete('currentreservation');
	}

	public function updateReserve($where , $data){
		extract($data);
    	$this->db->where('currentId', $where);
    	$this->db->update('currentreservation', 
    		array(	'carId' => $carId ,
    				'depID' => $depID , 
    				'place' => $place , 
    				'startDate' => $dateS,
    				'endDate' => $dateE,
    				'Tel' => $tel
    			));
		return true;
	}

	public function updateAdminReserve($where , $data){
		extract($data);
    	$this->db->where('currentId', $where);
    	$this->db->update('currentreservation', 
    		array(	'carId' => $carId ,
    				'depID' => $depID ,
    				'DriverId' => $driverId, 
    				'place' => $place , 
    				'startDate' => $dateS,
    				'endDate' => $dateE,
    				'Tel' => $tel
    			));
		return true;
	}

	public function updateReserveAdmin($where , $data){
		extract($data);
		$this->db->where('currentId', $where);
		$this->db->update('currentreservation', 
			array(	'carId' => $carId ,
				'startDate' => $dateS,
				'endDate' => $dateE,
				//'employeeCode' => $empCode , 
				'place' => $place , 				
				'Tel' => $tel
				));
		return true;
	}	

	private function matchPrevObject($reserveInfo,$row){
		$reserveInfo->setReserveId($row->StatusId);
		$reserveInfo->setEmployeeCode($row->EmployeeCode);
		$reserveInfo->setPlateLicense($row->plateLicense);
		$reserveInfo->setStartDate($row->StartDate);	
		$reserveInfo->setEndDate($row->EndDate);
		$reserveInfo->setPlace($row->Place);
		$reserveInfo->setDriverId($row->DriverId);
		$reserveInfo->setColor($row->Color);
		$reserveInfo->setCarId($row->CarId);		
	}

	private function matchReservationObject($reserveInfo,$row){
		$reserveInfo->setReserveId($row->CurrentId);
		$reserveInfo->setEmployeeCode($row->EmployeeCode);
		$reserveInfo->setPlateLicense($row->plateLicense);
		$reserveInfo->setStartDate($row->StartDate);	
		$reserveInfo->setEndDate($row->EndDate);
		$reserveInfo->setPlace($row->Place);
		$reserveInfo->setDriverId($row->DriverId);
		$reserveInfo->setColor($row->Color);
		$reserveInfo->setCarId($row->carId);
		$reserveInfo->setTel($row->Tel);
		$reserveInfo->setDepartmentID($row->depID);
	}	

	public function getTelFromReserveId($id){
		$this->db->select('Tel');
		$this->db->where('CurrentId', $id);
		$query = $this->db->get('currentreservation');
		$Tel = "";
		foreach ($query->result() as $row){
			$Tel = $row->Tel;
		}
		return $Tel;
	}

	public function getReserverName($id){
		$sql = 'SELECT u.name from user u join currentreservation c on c.EmployeeCode = u.EmployeeCode';
		$query = $this->db->query($sql);
		$name = "";
		foreach ($query->result() as $row){
			$name = $row->name;
		}
		return $name;
	}

	public function getCurrentReservationFromDriver($emp){
		$currentReserve = null;
		$r = "";
		$query = $this->db->query('SELECT cr.* , c.carId , ct.carTypeId , ct.Color , c.plateLicense FROM cartype ct JOIN cars c ON c.carTypeId = ct.carTypeId JOIN currentreservation cr ON cr.carId = c.carId where cr.DriverId = '.$emp);
		foreach ($query->result() as $row){
			$currentReserve = new ReservationModel;
			$this->matchReservationObject($currentReserve,$row);
			if($r === ""){
				$r = array();
			}
			array_push($r,$currentReserve);
		}		
		return $r;
	}

	public function getPlateLiceseByReserve($reserveId){
		$sql = 'select c.plateLicense from previousreservation cr join cars c on cr.carId = c.carId where cr.StatusId = '.$reserveId;
		$query = $this->db->query($sql);
		foreach ($query->result() as $row){
			$result = $row->plateLicense;  
		}
		return $result;
	}

	public function getStartDateFromReserveId($reserveId){
		$sql = 'SELECT StartDate FROM previousreservation WHERE StatusId = '.$reserveId;
		$query = $this->db->query($sql);
		foreach ($query->result() as $row){
			$result = $row->StartDate;  
		}
		return $result;
	}

	public function getEndDateFromReserveId($reserveId){
		$sql = 'SELECT EndDate FROM previousreservation WHERE StatusId = '.$reserveId;
		$query = $this->db->query($sql);
		foreach ($query->result() as $row){
			$result = $row->EndDate;  
		}
		return $result;
	}

	public function getPlaceFromReserveId($reserveId){
		$sql = 'SELECT place FROM previousreservation WHERE StatusId = '.$reserveId;
		$query = $this->db->query($sql);
		foreach ($query->result() as $row){
			$result = $row->place;  
		}
		return $result;
	}

	public function getReserveTodayforDriver($empCode){
		$sql = 'SELECT * FROM currentreservation cr join cars c on cr.carId = c.carId join cartype ct on c.CarTypeId = ct.CarTypeId  WHERE cr.DriverId = \''.$empCode .'\' AND (CAST(StartDate AS DATE) <= CAST(CURRENT_TIMESTAMP AS DATE) AND CAST(EndDate AS DATE) >= CAST(CURRENT_TIMESTAMP AS DATE))';
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function update_Departure( $rID , $dateS ,$sMiles ){
    	$this->db->where('currentId', $rID);
    	$this->db->update('currentreservation', 
    		array(	'Departure' => $dateS ,
    				'CarMilesStart' => $sMiles	
    				));
		return true;
	}

	public function update_Arrival( $rID , $dateE , $eMiles){
		$sql = 'UPDATE previousreservation SET  Arrival = \''.$dateE.'\', CarMilesEnd = '.$eMiles.' WHERE previousreservation.StatusId = '.$rID;		
		$query = $this->db->query('INSERT INTO previousreservation (StatusId, CarId, DriverId, EmployeeCode, depId, StartDate, EndDate, Place, Departure, CarMilesStart) SELECT currentId, carid, DriverId, EmployeeCode, depId, StartDate, EndDate, Place, Departure, CarMilesStart FROM currentreservation WHERE CurrentId = '.$rID);
		$query = $this->db->query($sql);
		$this->db->delete('currentreservation', array('currentid' => $rID));	
	}

	public function getCarMilesStart($rID){
		$SQL = 'SELECT * FROM currentreservation WHERE currentId = '.$rID;
		$query = $this->db->query($SQL);
		return $query->row_array();
	}
}

/* End of file CarModel.php */
/* Location: ./application/models/CarModel.php */
/*
$cars, $date, $driver, $timeS, $timeE, $plateLicense, $place
*/