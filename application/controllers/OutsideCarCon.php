<?php
defined('BASEPATH') || exit('No direct script access allowed');

class OutsideCarCon extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('ReservationModel');
		$this->load->model('CarsModel');
		$this->load->model('OutsideCarModel');
	}

	public function AddData(){
		$this->load->model('UserModel');
		$this->OutsideCarModel->AddPlateAndCost($_POST['plate'],$_POST['cost'], $_POST['hireId']);
		$id = $_POST['hireId'];
		$data = $this->OutsideCarModel->getOutsideInfoFromHire($id);
			$outsideinfo = array(
				'cartype' => $data['cartype'],
				'startdate' => $data['startdate'],
				'enddate' => $data['enddate'],
				'place' => $data['place'],
				'tel' => $data['tel'],
				'cost' => $data['cost'],
				'platelicense' => $data['platelicense'],
				'hireId' => $id,
				'departmentName' => $this->UserModel->getDepartmentName($this->session->userdata['logged_in']['department'])
			);
			$this->load->view('GenOutsideCost', $outsideinfo);
	//		$this->load->view('GenOutsideCost');
	}

	public function sendRequest(){
		$carTypeId = $this->input->post('cartype');
		$depID =  $this->session->userdata['logged_in']['department'];
		$dateS = $this->input->post('dateS2');
		$dateE = $this->input->post('dateE2');
		$place = $this->input->post('place2');
		$tel = $this-> input->post('tel2');
		$reason = ($_POST['reason']=="0")?$_POST['reasonText']:$_POST['reason'];
		$data = array(
				'carTypeId' => $carTypeId,
				'depID' =>$depID ,
				'dateS' =>$dateS ,
				'dateE' => $dateE,
				'place' => $place,
				'tel' => $tel,
				'reason' => $reason
			);
		$this->OutsideCarModel->add_OutsideCar($data);

		echo json_encode(array("status" => TRUE));
	}

	public function ajax_list_OutsideCar(){
		$depID =  $this->session->userdata['logged_in']['department'];
		$osc = $this->OutsideCarModel->getOutsideInfo($this->session->userdata['logged_in']['employeeCode']);
		$data = array();
		if($osc != null || $osc != ""){
		foreach ($osc as $value) {			
			if($value->getCarTypeId() ==='1'){
				$carType = "แท็กซี่";
			}else{
				$carType = "ตู้";
			}		
			$data[] = array(
					$carType ,
					"<center>".date("Y-m-d H:i", strtotime($value->getStartDate()))."</center>",
		            "<center>".date("Y-m-d H:i", strtotime($value->getEndDate()))."</center>",
		            $value->getPlace(),
		            $value->getTel(),
		            '<form action="'.base_url().'GenReport/AddInfo" method="post">'.
		            	'<input type="text" name="hireId" style="display:none;" value="'.$value->getHireId().'">'.
		            	'<button class="btn btn-info" type="submit">เบิกงบ</button>'.
		           '</form>'
				);
		}
	}
		 $output = array(            
                "data" => $data
            );		
		//output to json format
		echo json_encode($output);
	}
}