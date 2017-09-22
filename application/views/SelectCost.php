<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<head>
  <?php 
  include "Header.php";
  ?>
  
  <script src="<?php echo base_url(); ?>table_to_excel/js/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>table_to_excel/js/jquery.table2excel.js"></script>

</head>

<body>
  <?php 
   include "NavbarChooser.php";   
  ?>

  <div class="con">

    <h2 style="text-align:center;font-size:36px">รายงานขอเบิกงบประมาณ</h2><hr>
    <p style="text-align:center;font-size:20px">
      <span style="text-align:center;font-size:20px;font-weight: bold;">ชื่อ-นามสกุลผู้จอง</span> 
      <?php echo $this->session->userdata['logged_in']['name'] ?> 
      <span style="text-align:center;font-size:20px;font-weight: bold;">หน่วยงาน</span> 
      <?php echo $departmentName ?> 
      <span style="text-align:center;font-size:20px;font-weight: bold;">ตำแหน่ง</span> 
      <?php echo $this->session->userdata['logged_in']['role'] ?>
    </p>

    <br>
    
    <center>
      <table class="table2excel" data-tableName="Header Table" style="font-size:18px;border: 1px solid #ddd;text-align: center;border-collapse: collapse;width: 80%" >
        <tr><p>
          วันที่ออกเอกสาร
          <?php    
          echo date("d-m-Y");
          ?>            
          </p>
        </tr>
        <tr>
          <th style="text-align:center;padding: 15px;border: 1px solid #ddd">หมายเลขการจอง</th>
          <th style="text-align:center;padding: 15px;border: 1px solid #ddd">ประเภทรถ</th>
          <th style="text-align:center;padding: 15px;border: 1px solid #ddd">ทะเบียนรถ</th>
          <th style="text-align:center;padding: 15px;border: 1px solid #ddd">วันเวลาที่เดินทาง</th>
          <th style="text-align:center;padding: 15px;border: 1px solid #ddd">วันเวลาที่กลับ</th>
          <th style="text-align:center;padding: 15px;border: 1px solid #ddd">สถานที่</th>
          <th style="text-align:center;padding: 15px;border: 1px solid #ddd">ออกรายงานเบิกงบประมาณ</th>
        </tr>
        <?php 
        if($reserveInfo != ""){
          foreach ($reserveInfo as $value) { 
            ?>
            <tr>
              <td style="padding: 15px;border: 1px solid #ddd"><?php echo $value->getReserveId() ?></td>
              <td style="padding: 15px;border: 1px solid #ddd"><?php echo $carType[$value->getCarId()] ?></td>
              <td style="padding: 15px;border: 1px solid #ddd"><?php echo $value->getPlateLicese() ?></td>
              <td style="padding: 15px;border: 1px solid #ddd"><?php echo $value->getStartDate() ?></td>
              <td style="padding: 15px;border: 1px solid #ddd"><?php echo $value->getEndDate() ?></td>
              <td style="padding: 15px;border: 1px solid #ddd"><?php echo $value->getPlace() ?></td>
              <td style="text-align:center;padding: 15px;border: 1px solid #ddd">
                <a href="<?php echo base_url(); ?>GenReport/GenCost?carTypeId=<?php echo $carType[$value->getCarId()]?>&reserveId=<?php echo $value->getReserveId()?>">
                    
                <button id="searchbut" type="submit" class="btn btn-primary">ออกรายงาน</button></a></td>
            </tr>
            <?php 
          }
        } else{
          echo "<td style='text-align:center;padding: 15px;border: 1px solid #ddd' colspan='6'>ไม่มีประวัติการจองรถ</td>";
        }
        ?>
      </table>
    </center>
    
    <br>

  </body>
  </html>

