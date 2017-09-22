<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<?php 
	include "Header.php";
	?>
	<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
	<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
	<link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
	
	<link href="<?php echo base_url('assets/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css')?>" rel="stylesheet">
	<script src="<?php echo base_url('assets/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js')?>"></script>
	<link rel="icon" href="<?php echo base_url('assets/favicon.ico')?>" sizes="16x16">
	
</head>
<body >

	<?php 
	include "NavbarChooser.php";
	?>
	<div class="container">
	<a href="<?php echo base_url() ?>ManageCar/AddCar"><button class="btn btn-primary">เพิ่มรถ</button></a>
	<br>
	<br>
	<table id="table" class="table table-striped table-bordered table-hover" width="100%">
			<thead>
				<tr>
					<td class="head">ทะเบียนรถ</td>					
					<td class="head">ประเภทรถ</td> 
					<td class="head">วันที่จดทะเบียน</td>
					<td class="head">ราคา</td>
					<td class="head">ยี่ห้อ รุ่น</td>
					<td class="head">หมายเลขเครื่อง</td>
					<td class="head">ปีที่ซื้อ</td>
					<td class="head">จำนวนที่นั่ง</td>
					<td class="head">รหัสครุภัณฑ์</td>
					<td class="head">พนักงานขับรถ</td>
					<td class="head">เชื้อเพลิง</td>
					<td class="head">หน่วยงาน</td>
					<td class="head">หมายเหตุ</td>
					<td class="head"></td>
				</tr>
			</thead>
			<tbody>
				
			</tbody>							
		</table>
	
	</div>
</body>
</html>