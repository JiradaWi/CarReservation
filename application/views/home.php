<html>
<head>
	<meta charset="utf-8">
	<title></title>
	
	<?php 
	include "header.php";
	?>
	<script src='<?php echo base_url(); ?>fullcalendar/lib/moment.min.js'></script>
	<script src='<?php echo base_url(); ?>fullcalendar/fullcalendar.js'></script>
	<script type='text/javascript' src='<?php echo base_url(); ?>fullcalendar/gcal.js'></script>
	<link rel='stylesheet' href='<?php echo base_url(); ?>fullcalendar/fullcalendar.css' />
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel='stylesheet' href='<?php echo base_url(); ?>application/Views/css/hr.css' />
	
	<style type="text/css">
	

	</style>
</head>

<body class="container">

	<br>
	<?php 
	include "navbarUserNew.php";
	?>
	<br>
	<div>
		<div class="row"> 
			<div class="col-md-9 col-md-offset">
				<iframe id="calender" name="calender" src="../calendar"></iframe>
			</div>

			<div class="col-md-3 ">
				<div id="holdList" style="padding: 1px; margin : 10px;">
						<form action="../search/searchCar" class="form-horizontal" target="calender"  method="POST" accept-charset="utf-8" style="align-items:center;">
							<center style="font-size: 25px">รายการรถ</center>

							<div id="divCarList1">
								<ul>
									<div class="headList" style="background-color:#3B94B1">
										<li >
											<div class="checkbox" >
												<input  id="listCar1" name='carType[]' onchange='uncheckFunc(1)' type='checkbox' value=1>
												<label for="listCar1"> เก๋ง </label>
											</div> 

										</li>
									</div>
									<li  >
										<?php 
										foreach ($Type1 as  $value) {
											echo "<ul><li><div class='checkbox'>";
											echo "<input name='carId[]' class='list1' onchange='checkFunc(1)' id='listC". $value->getCarId()."' type='checkbox' value=". $value->getCarId()."> " ;
											echo  "<label for='listC". $value->getCarId()."'>".$value->getPlateLicese()."</label></div></li></ul>";
										}
										?>
									</li>
								</ul>
							</div>
							<div id="divCarList2">
								<ul>
									<div class="headList" style="background-color:#8DE748">
										<li >
											<div class="checkbox" >
												<input id="listCar2" name='carType[]' onchange='uncheckFunc(2)' type='checkbox' value=2>
												<label for="listCar2"> ปิ๊กอัพ  </label>
											</div> 
										</li>
									</div>
									<li >
										<?php 
										foreach ($Type2 as  $value) {
											echo "<ul><li><div class='checkbox'>";
											echo "<input name='carId[]' class='list2' onchange='checkFunc(2)' id='listC". $value->getCarId()."' type='checkbox' value=". $value->getCarId()."> " ;
											echo  "<label for='listC". $value->getCarId()."'>".$value->getPlateLicese()."</label></div></li></ul>";
										}
										?>
									</li>
								</ul>	
							</div>
							<div id="divCarList3">
								<ul>
									<div class="headList" style="background-color:#FFF44F">
										<li >
											<div class="checkbox" >
												<input id="listCar3"  name='carType[]' onchange='uncheckFunc(3)' type='checkbox' value=3>
												<label for="listCar3"> ตุ๊กตุ๊ก </label>
											</div> 

										</li>
									</div>
									<li >
										<?php 
										foreach ($Type3 as  $value) {
											echo "<ul><li><div class='checkbox'>";
											echo "<input name='carId[]' class='list3' onchange='checkFunc(3)' id='listC". $value->getCarId()."' type='checkbox' value=". $value->getCarId()."> " ;
											echo  "<label for='listC". $value->getCarId()."'>".$value->getPlateLicese()."</label></div></li></ul>";
										}
										?>
									</li>
								</ul>

							</div>					
							<div id="divCarList4">
								<ul >
									<div class="headList" style="background-color:#EF4A6D">
										<li>
											<div class="checkbox" >
												<input id="listCar4" name='carType[]' onchange='uncheckFunc(4)' type='checkbox' value=4> 
												<label for="listCar4"> ซาเล้ง </label>
											</div> 

										</li>
									</div>
									<li >
										<?php 
										foreach ($Type4 as  $value) {
											echo "<ul><li><div class='checkbox'>";
											echo "<input name='carId[]' class='list4' onchange='checkFunc(4)' id='listC". $value->getCarId()."' type='checkbox' value=". $value->getCarId()."> " ;
											echo  "<label for='listC". $value->getCarId()."'>".$value->getPlateLicese()."</label></div></li></ul>";
										}
										?>
									</li>
								</ul>
							</div>	
							<div id="divCarList5">
								<ul>
									<div class="headList" style="background-color:#FF964F">
										<li>
											<div class="checkbox" >
												<input id="listCar5" name='carType[]' onchange='uncheckFunc(5)' type='checkbox' value=5>
												<label for="listCar5"> รถตู้ </label>
											</div> 
										</li>
									</div>
									<li >
										<?php 
										foreach ($Type5 as  $value) {
											echo "<ul><li><div class='checkbox'>";
											echo "<input name='carId[]' class='list5' onchange='checkFunc(5)' id='listC". $value->getCarId()."' type='checkbox' value=". $value->getCarId()."> " ;
											echo  "<label for='listC". $value->getCarId()."'>".$value->getPlateLicese()."</label></div></li></ul>";
										}
										?>
									</li>
								</ul>
							</div>	
							<hr>
							<center>
								<button id="searchbut" type="submit" data-target="#calender" class="btn btn-primary">ค้นหารถ</button>
								<button class="btn btn-primary" data-toggle="modal" data-target="#reserve">จองรถ</button>
							</center>

						</form>
				
				</div>	
				<br>

			</div>
		</div>
		<br><br>


	</div>

	<br>

	<form action="add" method="post">
		<div class="modal fade" id="reserve" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">จองรถ</h4>
					</div>
					<div class="modal-body">
						<div id="information">

							<b>เลือกรถ: </b>
							<select name="cars"  id="cartype" onchange="changeDetect()" class="form-control">
								<option>เลือกประเภทรถ</option>
								<option value="1">เก๋ง</option>
								<option value="2">ปิ๊กอัพ</option>
								<option value="3">ตุ๊กตุ๊ก</option>
								<option value="4">ซาเล้ง</option>						
							</select>

							<br>

							<b>วันที่: </b><input type="date" name="date" id="day"  value="เลือกวันที่ปฏิทิน" class="form-control" >

							<input type="hidden" value="2" name="driver" id="driverr">
							<br><br>

							<div class="form-inline">
								<b>เวลา: </b> ตั้งแต่ <input type="time" class="form-control" name="timeS" placeholder="ชช:นน:วว"> 
								ถึง <input type="time" class="form-control" name="timeE" placeholder="ชช:นน:วว">
							</div>
							<br>
							<b>เลือกทะเบียนรถ:</b>
							<select name="plateLicense" id="plate" class="form-control" onchange="driver()">
								<option value='นม 66'>เลือกประเภทรถก่อน</option>
							</select>
							<br>
							<b>สถานที่:</b>
							<textarea class="form-control" name="place"></textarea>
							<br><br>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary" >ยืนยันการจอง</button>

					</div>
				</div>
			</div>
		</div>
	</form>

	<form class="form-inline">
		<div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">ค้นหารถ</h4>
					</div>
					<div class="modal-body">
						<iframe id="listCars" name="listCars" src="#"></iframe>

					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary" >ค้นหารถ</button>

					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
		function checkFunc(ch){
			if(ch == 1){
				document.getElementById("listCar1").checked = true;
			}else if(ch == 2){
				document.getElementById("listCar2").checked = true;
			}else if(ch == 3){
				document.getElementById("listCar3").checked = true;
			}else if(ch == 4){
				document.getElementById("listCar4").checked = true;
			}else if(ch == 5){
				document.getElementById("listCar5").checked = true;
			}

		}
		function uncheckFunc(ch){
			list = null;
			if(ch == 1){
				list = document.getElementsByClassName("list1");
			}else if(ch == 2){
				list = document.getElementsByClassName("list2");
			}else if(ch == 3){
				list = document.getElementsByClassName("list3");
			}else if(ch == 4){
				list = document.getElementsByClassName("list4");
			}else if(ch == 5){
				list = document.getElementsByClassName("list5");
			}

			for (var i = 0; i < list.length; i++) {
				list[i].checked = false;
			}
		}
		</script>
	</body>
	</html>