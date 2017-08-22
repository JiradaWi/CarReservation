<html>
<head>
	<meta charset="utf-8">
		
	<?php 
	include "Header.php";
	?>
	<script src='<?php echo base_url(); ?>fullcalendar/lib/moment.min.js'></script>
	<script src='<?php echo base_url(); ?>fullcalendar/fullcalendar.js'></script>
	<script type='text/javascript' src='<?php echo base_url(); ?>fullcalendar/gcal.js'></script>
	<link rel='stylesheet' href='<?php echo base_url(); ?>fullcalendar/fullcalendar.css' />
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel='stylesheet' href='<?php echo base_url(); ?>application/views/css/hr.css' />
	<link href="<?php echo base_url('assets/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css')?>" rel="stylesheet">
	<script src="<?php echo base_url('assets/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js')?>"></script>

</head>

<body class="container" style="background-color:#fafafa">
	<?php 
		if (isset($this->session->userdata['logged_in'])) {
			$username = ($this->session->userdata['logged_in']['username']);
			$employeeCode = ($this->session->userdata['logged_in']['employeeCode']);
			$name = ($this->session->userdata['logged_in']['name']);
			$department = ($this->session->userdata['logged_in']['department']);
			$role = ($this->session->userdata['logged_in']['role']);
			include "NavbarUserLogged_in.php";
		}else{
			include "NavbarHome.php";
		}
	?>

	<div class="row"> 
		<div  id="calendar" class="col-md-10">
		
		</div>

		<div class="col-md-2">
			<?php if (isset($this->session->userdata['logged_in'])) { ?>						
				<button type='button' onclick="ajax_myHistory()" class="btn btn-default">ดูประวัติการจองของฉัน</button>
			<?php } ?>
			<div id="holdList" style="padding: 1px; margin : 0px;">
				<form  class="form-horizontal" style="align-items:center;">
					<center style="font-size: 25px">รายการรถ</center>

					<div id="divCarList1">
						<ul>
							<div class="headList" style="background-color:#E1628B">
								<li >
									<div class="checkbox" >
										<input  id="listCar1" name='carType[]' class="carType" onchange='uncheckFunc(1)' type='checkbox' value=1>
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
							<div class="headList" style="background-color:#FEDB6F">
								<li >
									<div class="checkbox" >
										<input id="listCar2" name='carType[]' class="carType" onchange='uncheckFunc(2)' type='checkbox' value=2>
										<label for="listCar2"> กระบะ(ปิ๊กอัพ)  </label>
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
							<div class="headList" style="background-color:#4D7FA3">
								<li >
									<div class="checkbox" >
										<input id="listCar3"  name='carType[]' class="carType" onchange='uncheckFunc(3)' type='checkbox' value=3>
										<label for="listCar3"> รถตู้ </label>
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
							<div class="headList" style="background-color:#9FE363">
								<li>
									<div class="checkbox" >
										<input id="listCar4" name='carType[]' class="carType" onchange='uncheckFunc(4)' type='checkbox' value=4> 
										<label for="listCar4"> ไมโครบัส </label>
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
					
					<hr>
					<center>	
						<button id="searchbut" onclick="ajax_search()" type="button" class="btn btn-primary">ค้นหารถ</button>
						<?php if (isset($this->session->userdata['logged_in'])) { ?>
						<button type='button'class="btn btn-primary" data-toggle="modal" data-target="#reserve">จองรถ</button>
						<?php } ?>
					</center>
				</form>					
			</div>	
			<br>
		</div>
	</div>
	<br><br>

	<form class="form-horizontal" id="formReserve" target="sendform" action="<?php echo base_url();?>Reserve/addReserve" method="post">
		
		<div class="modal fade" id="reserve" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="resetForm()"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">จองรถ</h4>
					</div>
					<div class="modal-body form">

						<div id="form-body">
							<div class="form-group">
								<label for="cartype" class="col-md-3 control-label">ประเภทรถ </label>
								<div class="col-md-8">
									<select name="cars" required id="cartype" onchange="changeType()" class="form-control">
										<option value="">เลือกประเภทรถ</option>
										<option value="1">เก๋ง</option>
										<option value="2">กระบะ</option>
										<option value="3">ตู้</option>
										<option value="4">ไมโครบัส</option>						
									</select>
								</div>	
							</div>

							<div class="form-group">
								<label for="plate" class="col-md-3 control-label">ทะเบียนรถ </label>
								<div class="col-md-8">
									<select required name="plateLicense" id="plate" class="form-control">
										<option value="">เลือกประเภทรถก่อน</option>
									</select>
								</div>	
							</div>

							<div class="form-group">
		                        <label class="col-md-3 control-label">วันที่เดินทาง</label>
		                        <div class="col-md-8 ">
		                            <input id="dateS" name="dateS"  class="form-control datetimepicker" type="text" autocomplete="off">
		                            <span class="help-block"></span>
		                        </div>	                    
		                    </div>
		                    <div class="form-group">
		                        <label class="col-md-3 control-label" >วันที่กลับ</label>
		                        <div class="col-md-8 ">
		                            <input id="dateE" name="dateE" class="form-control datetimepicker" type="text" autocomplete="off">
		                            <span class="help-block"></span>
		                        </div>
		                    </div>

		                     <div class="form-group">
		                        <label class="col-md-3 control-label" >สถานที่ </label>
		                        <div class="col-md-8">
		                           <textarea class="form-control" name="place" required ></textarea>
		                            <span class="help-block"></span>
		                        </div>
		                    </div>

							
							
							<br>
							<iframe style = "height: 0px; width: 100%" target="" src="/senior/application/views/Result.php" id="sendform" name="sendform"></iframe>
							
						</div>
						<div class="modal-footer">
							<button type="submit"  class="btn btn-primary" >ยืนยันการจอง</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>

	<div class="modal fade" id="modal_form" role="dialog">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		                <h3 class="modal-title">Reservation</h3>
		            </div>
		            <div class="modal-body form">
		                <form action="#" id="formEdit" class="form-horizontal">
		                    <input type="hidden" value="" id='id' name="id"/>
		                    <div class="form-body"> 	                
		                        <div class="form-group">
		                            <label class="col-md-3 control-label">ประเภทรถ</label>
		                            <div class="col-md-8">
		                                <select id="carType" class="form-control" onchange="changeTypeforEdit(this.value)" name="carType">
											<option value="1">เก๋ง</option>
											<option value="2">กระบะ</option>
											<option value="3">ตู้</option>
											<option value="4">ไมโครบัส</option>		
		                                </select>
		                                <span class="help-block"></span>
		                            </div>
		                        </div>

		                        <div class="form-group">
		                            <label class="col-md-3 control-label">ทะเบียนรถ</label>
		                            <div class="col-md-8">
		                                <select id="plateL" class="form-control" name="plateL"></select>
		                                <span class="help-block"></span>
		                            </div>
		                        </div>
		                        <div class="form-group">
		                            <label class="col-md-3 control-label">วันที่เดินทาง</label>
		                            <div class="col-md-8">
		                                 <input id="dateS2" name="dateS2"  class="form-control datetimepicker2" type="text" autocomplete="off">
		                                <span class="help-block"></span>
		                            </div>	                    
		                        </div>
		                        <div class="form-group">
		                            <label class="col-md-3 control-label" >วันที่กลับ</label>
		                            <div class="col-md-8">
		                                <input id="dateE2" name="dateE2" class="form-control datetimepicker2" type="text" autocomplete="off">
		                                <span class="help-block"></span>
		                            </div>
		                        </div>
		                        <div class="form-group">
		                            <label class="col-md-3 control-label">สถานที่</label>
		                            <div class="col-md-8">
		                                <textarea id="place" name="place" placeholder="place" class="form-control"></textarea>
		                                <span class="help-block"></span>
		                            </div>
		                        </div>
		            

		                 </div>
		                </form>
		            </div>
		            <div class="modal-footer">
		                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
		                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
		            </div>
		        </div><!-- /.modal-content -->
		    </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<!-- End Bootstrap modal -->
</body>
	<script type="text/javascript">


	function checkFunc(ch){
		switch(ch){
			case(1):document.getElementById("listCar1").checked = true; break;
			case(2):document.getElementById("listCar2").checked = true; break;
			case(3):document.getElementById("listCar3").checked = true; break;
			case(4):document.getElementById("listCar4").checked = true; break;
			case(5):document.getElementById("listCar5").checked = true; 
		}
	}

	function uncheckFunc(ch){
		list = null;
		switch(ch){
			case(1): list = document.getElementsByClassName("list1"); break;
			case(2): list = document.getElementsByClassName("list2"); break;
			case(3): list = document.getElementsByClassName("list3"); break;
			case(4): list = document.getElementsByClassName("list4"); break;
			case(5): list = document.getElementsByClassName("list5"); 
		}
		
		
		for (var i = 0; i < list.length; i++) {
			list[i].checked = false;
		}
	}

	function changeType(){
		select = document.getElementById('plate');
		e = document.getElementById('cartype');
		v = e.options[e.selectedIndex].value;
		
		select.innerHTML = "";		

			if(v==1){
				<?php foreach ($Type1 as $value) { ?>
					var opt = document.createElement('option');				
					opt.value = "<?php echo $value->getCarId(); ?>";
					opt.innerHTML = "<?php echo $value->getPlateLicese(); ?>";
					select.appendChild(opt);
				<?php } ?>
			}else if(v==2){
				<?php foreach ($Type2 as $value) { ?>	
					var opt = document.createElement('option');				
					opt.value = "<?php echo $value->getCarId(); ?>";
					opt.innerHTML = "<?php echo $value->getPlateLicese(); ?>";
					select.appendChild(opt);
					<?php } ?>
			}else if(v==3){
				<?php foreach ($Type3 as $value) { ?>		
					var opt = document.createElement('option');				
					opt.value = "<?php echo $value->getCarId(); ?>";
					opt.innerHTML = "<?php echo $value->getPlateLicese(); ?>";
					select.appendChild(opt);
				<?php } ?>
			}else if(v==4){
				<?php foreach ($Type4 as $value) { ?>	
					var opt = document.createElement('option');						
					opt.value = "<?php echo $value->getCarId(); ?>";
					opt.innerHTML = "<?php echo $value->getPlateLicese(); ?>";
					select.appendChild(opt);
				<?php } ?>
			}

		}
		function changeTypeforEdit(v){
		select = document.getElementById('plateL');
		
		
		select.innerHTML = "";		

			if(v==1){
				<?php foreach ($Type1 as $value) { ?>
					var opt = document.createElement('option');				
					opt.value = "<?php echo $value->getCarId(); ?>";
					opt.innerHTML = "<?php echo $value->getPlateLicese(); ?>";
					select.appendChild(opt);
				<?php } ?>
			}else if(v==2){
				<?php foreach ($Type2 as $value) { ?>	
					var opt = document.createElement('option');				
					opt.value = "<?php echo $value->getCarId(); ?>";
					opt.innerHTML = "<?php echo $value->getPlateLicese(); ?>";
					select.appendChild(opt);
					<?php } ?>
			}else if(v==3){
				<?php foreach ($Type3 as $value) { ?>		
					var opt = document.createElement('option');				
					opt.value = "<?php echo $value->getCarId(); ?>";
					opt.innerHTML = "<?php echo $value->getPlateLicese(); ?>";
					select.appendChild(opt);
				<?php } ?>
			}else if(v==4){
				<?php foreach ($Type4 as $value) { ?>	
					var opt = document.createElement('option');						
					opt.value = "<?php echo $value->getCarId(); ?>";
					opt.innerHTML = "<?php echo $value->getPlateLicese(); ?>";
					select.appendChild(opt);
				<?php } ?>
			}

		}		

		function resetForm(){
			select = document.getElementById('plate');
			select.innerHTML = "";
			var opt = document.createElement('option');	
			opt.innerHTML = "เลือกประเภทรถก่อน";
			select.appendChild(opt);
			document.getElementById("formReserve").reset();
			document.getElementById("sendform").style.height = '0px';			
		}


	
	function getDefualt_Calendar(){
			 $.ajax({
	                url: '<?php echo base_url('HomeInfo/ajax_loadEvent'); ?>',
	                type: "POST",
	                datatype: 'json',
	                success: function (doc) {
	                	data =JSON.parse(doc);	
						createCalendar(data)     
		              	
	                },error: function (err) {
	                    alert('Error in fetching data');
	                }
	            });
	}

	function createCalendar(data){
		  $('#calendar').fullCalendar({
				eventLimit: true, 
				editable: false,
				navLinks: true,
				header: {
					left: 'title',
					center: '',
					right : 'today month,agendaWeek,agendaDay prev,next listWeek'
				},	
				events: data,
				eventMouseover: function (calEvent,event, jsEvent) {
			        $(this).popover({
			            placement: 'top',
			            trigger: 'hover',
			            html:true,
			            content: 'เวลาออก : '+moment(calEvent.start).format('DD/MM h:mm a')+'<br />เวลากลับ : '
			            +moment(calEvent.end).format('DD/MM h:mm a'),
			            container: '#calendar'

			        });
			        $(this).popover('show');
			    	},
			    
			    eventClick: function(calEvent, jsEvent, view) {
			    	if(calEvent.editable){
			    		edit_reserve(calEvent.id);
			    	}else{
			    		alert("ดูข้อมูลการจอง แก้ไขและยกเลิก โดยกด \" ดูประวัติการจองของฉัน\"")
			    	}
			        
			        // change the border color just for fun

			    }

					           				
			});  


	}


	function refresh_calendar(){
		$('#calendar').fullCalendar('destroy');
		getDefualt_Calendar();
	}

	function reload_calendar(){
		   //createCalendar();
		 $('#calendar').fullCalendar('destroy');
		 getDefualt_Calendar()
		   //$('#calendar').fullCalendar('refetchEvents');
	}

	function ajax_search(){
		
			 $.ajax({
	                url: '<?php echo base_url('Search/searchCar'); ?>',
	                type: "POST",
	              	data: $('.carType:checked').serialize()+"&"+$('[name="carId[]"]:checked').serialize(),
	                datatype: 'json',
	                success: function (doc) {
	                	data =JSON.parse(doc);	
	                	$('#calendar').fullCalendar('destroy');
						createCalendar(data)   
		              
	                },error: function (err) {
	                    alert('Error in fetching data');
	                }
	            });
		
	}

	function ajax_myHistory(){
		
			 $.ajax({
	                url: '<?php echo base_url('Reserve/ajax_reserve_history'); ?>',
	                type: "POST",
	                datatype: 'json',
	                success: function (doc) {
	                	data =JSON.parse(doc);	
	                	$('#calendar').fullCalendar('destroy');
						createCalendar(data)   
		              
	                },error: function (err) {
	                    alert('Error in fetching data');
	                }
	            });
		

	}

	function edit_reserve(rID){
		    $('#formEdit')[0].reset(); // reset form on modals
		    $('.form-group').removeClass('has-error'); // clear error class
		    $('.help-block').empty(); // clear error string

		    //Ajax Load data from ajax
		    $.ajax({
		        url : "<?php echo site_url('Reserve/ajax_edit')?>/"+rID,
		        type: "GET",
		        dataType: "JSON",
		        success: function(data)
		        {
		            $('#id').val(data.reserveId);
		            $('[name="carType"]').val(data.carTypeId).change();
		            $('[name="plateL"]').val(data.carId).change();
		            $('[name="dateS2"]').datetimepicker('update',data.startDate);
		            $('[name="dateE2"]').datetimepicker('update',data.endDate);
		            $('[name="place"]').val(data.place);
		          	//changeType();
		            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
		            

		        },
		        error: function (jqXHR, textStatus, errorThrown)
		        {
		            alert('Error get data from ajax');
		        }
		    });
		}	

	function save()
	{
	    $('#btnSave').text('saving...'); //change button text
	    $('#btnSave').attr('disabled',true); //set button disable 

	    // ajax adding data to database
	    $.ajax({
	        url : "<?php echo site_url('Reserve/ajax_update')?>",
	        type: "POST",
	        data: $('#formEdit').serialize(),
	        dataType: "JSON",
	        success: function(data)
	        {

	            if(data.status) //if success close modal and reload ajax table
	            {
	                $('#modal_form').modal('hide');
	                ajax_myHistory();
	            }
	            else
	            {
	               alert('false');
	            }
	            $('#btnSave').text('save'); //change button text
            	$('#btnSave').attr('disabled',false); //set button enable 


	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	            alert('Error adding / update data');
	            $('#btnSave').text('save'); //change button text
	            $('#btnSave').attr('disabled',false); //set button enable 

	        }
	    });
	}


	var dateToday = new Date(); 
	var urls = 'HomeInfo/ajax_loadEvent';
	$(document).ready(function() {
			getDefualt_Calendar();
		
		  
		$('.datetimepicker').datetimepicker({
	    	container:'#reserve',
	        autoclose: true,
	        format: "yyyy-mm-dd hh:ii",
	        todayHighlight: true,
	       	orientation: "top auto",
	        todayBtn: true,
	        todayHighlight: true, 
	        
         });
		$('.datetimepicker2').datetimepicker({
	    	container:'#modal_form',
	        autoclose: true,
	        format: "yyyy-mm-dd hh:ii",
	        todayHighlight: true,
	       	orientation: "top auto",
	        todayBtn: true,
	        todayHighlight: true, 
	        
         });

		$('#dateS').datetimepicker('setStartDate', dateToday);
		$('#dateE').datetimepicker('setStartDate', dateToday);
		
	});
		</script>

	<?php include "Footer.php"; ?>

	</body>
	<style type="text/css">
	.popover{
		max-height: 70px;
		width: 200px;
	}

</style>

	</html>