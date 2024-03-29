<!DOCTYPE html>
<html>
<head>
	<title>ระบบบริหารจัดการรถยนต์</title>
	<meta charset="utf-8">
	<?php 
	include "Header.php";
	?>
	<link rel="icon" href="<?php echo base_url('assets/favicon.ico')?>" sizes="16x16">
	
</head>
<style type="text/css">
body{
	font-family: 'Prompt', sans-serif;
}
.head{
	font-weight: bold;
}	
p{
	font-size: 13pt;
}
.manualimg{
	width: 90%;
	height: : auto;
}
.imgcon{
	text-align: center;
}
.sidenav {
	position: fixed;	
	top:10%;
	margin-left: 0px;
	width: 170px;
}
.but{
	background-color: #fcd522;
	border-radius: 0px;
	color:black;
	margin-bottom: 15px;
	box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.5);
}

</style>
<body >
	
	<?php 
	include "NavbarChooser.php";
	?>	
	<div class="sidenav">
		<a href="#page1" class="snav"><button class="but btn">การออกรถ</button></a>
		<a href="#page2" class="snav"><button class="but btn">การตรวจสอบข้อมูล<br>ย้อนหลัง</button></a>
	</div>
	<div class="container" id="boxCal">
		<div id="page1">
			<h1 align="center">คู่มือการใช้งาน</h1>
			<h2 align="center">การออกรถ</h2>
			<p>ในหน้าหลัก คุณสามารถดูรายละเอียดรถของคุณได้จากปฏิทิน</p>
			<div class="imgcon">
				<img class="manualimg" src="<?php echo base_url('application/views/img/driver1.JPG')?>">
			</div>
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รายการรถด้านซ้าย คือรายการรถที่คุณจะต้องขับ กดปุ่ม "ยืนยันเวลากลับ" ก่อนออกรถเพื่อใส่รายละเอียดเพิ่มเติม เมื่อคุณกดออกรถแล้ว คุณสามารถเพิ่มข้อมูลเพื่อบันทึกอุบัติเหตุ หรือรายละเอียดเพิ่มเติมระหว่างการขับได้ คุณไม่สามารถกลับมาแก้ข้อมูลได้อีก กรุณาตรวจสอบก่อนกดยืนยัน</p>
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ปฏิทิน แสดงรายการรถทั้งหมดที่คุณต้องขับ คุณสามารถคลิกเพื่อเข้าไปดูข้อมูลการจองเพิ่มเติมได้ดังภาพล่าง</p>
			<div class="imgcon">
				<img class="manualimg" src="<?php echo base_url('application/views/img/driver2.JPG')?>">
			</div>
		</div>

<br><br>
		<div id="page2">
			<h2 align="center">ตรวจสอบข้อมูลย้อนหลัง</h2>
			<div class="imgcon">
				<img class="manualimg" src="<?php echo base_url('application/views/img/driver3.JPG')?>">
			</div>
			<p>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เมนูประวัติการออกรถ แสดงข้อมูลการใช้งานรถย้อนหลังของคุณ คุณไม่สามารถแก้ไขข้อมูลอะไรในหน้านี้ได้ หากต้องการแก้ไข กรุณาติดต่อเจ้าหน้าที่
			</p>
		</div>
		<br><br>
	</div>
</body>
</html>