<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<head>
<style>
body { margin:0 padding:0;font-family: Arial;font-size:11px; }
a { color: #333;text-decoration:none; }
a:hover { color: #F42280; }
table { width:2000px;border-collapse:collapse; }
th,td { font-family: Arial Narrow; font-size:13px; }
th { font-weight: bold;font-size:14px;
border: 1px solid #444;font-size:12px;padding: 3px 6px;
background: rgba(168,255,5,1);
background: -moz-linear-gradient(top, rgba(168,255,5,1) 0%, rgba(242,255,61,1) 100%);
background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(168,255,5,1)), color-stop(100%, rgba(242,255,61,1)));
background: -webkit-linear-gradient(top, rgba(168,255,5,1) 0%, rgba(242,255,61,1) 100%);
background: -o-linear-gradient(top, rgba(168,255,5,1) 0%, rgba(242,255,61,1) 100%);
background: -ms-linear-gradient(top, rgba(168,255,5,1) 0%, rgba(242,255,61,1) 100%);
background: linear-gradient(to bottom, rgba(168,255,5,1) 0%, rgba(242,255,61,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a8ff05', endColorstr='#f2ff3d', GradientType=0 );
}
td { text-align:center;border: 1px solid #ccc;padding:3px 6px;letter-spacing:0.1px; }
input.short { width:50px; }
input { width:80%; }
select { font-family: Arial Narrow; font-size:11px; }
input[type="submit"] { width:100px;height:26px;margin:0;padding:4px 6px;background:#14aaff;color:#fff;font-size:12px;font-weight:bold;border:1px solid #cccccc; }
input[type="submit"]:hover { background:#0097ea;cursor:pointer; }
span.submit { width:100px;height:26px;margin:10px;padding:4px 6px;background:#14aaff;color:#fff;font-size:12px;font-weight:bold;border:1px solid #cccccc; }
span.submit a { font-family:Arial;color: #fff;text-decoration:none; }
span.submit:hover { background:#0097ea;cursor:pointer;border:1px solid #cccccc; }

th.large { width:220px; }
td.large { width:220px; }
td.large-input { width:220px;background:#eee; }
td.large-total { width:220px;background:#eee;font-weight:bold; }

th.med { width:100px; }
td.med { width:100px; }
td.med-input { width:100px;background:#eee; }
td.med-total { width:100px;background:#eee;font-weight:bold; }

th.med2 { width:140px; }
td.med2 { width:140px; }
td.med2-input { width:140px;background:#eee; }
td.med2-total { width:140px;background:#eee;font-weight:bold; }

th.small { width:60px; }
td.small { width:60px; }
td.small-input { width:60px;background:#eee; }
td.small-total { width:60px;background:#eee;font-weight:bold; }

</style>

<script src="../js/sorttable.js"></script>
</head>

<body>

<div style="width:1000px;height:40px;margin:0 auto;">
<a href="../index.php"><img src="../images/ulogo.png" height="28" border="0"></a>
</div>
<?php

  require_once('../connection.php');

  if(isset($_POST['limit'])) { $limit= $_POST['limit']; } else { $limit= "10"; }
  
  if(isset($_POST['cLimit'])) { 
    $cLimit= $_POST['cLimit'];
	
	if($cLimit!='') { $limit= $cLimit; }
  } 
  
    $search= '';

  if(isset($_POST['var'])) {
    $vars= $_POST['var'];
  
    //print_r($vars);
  
    foreach ($vars as $key=>$value) {
  
      if($value!='') {
  
		$search .= "and " . $key . " like '" . $value . "'";
		
		${$key}= $value;
		
	  }
    }
  }
	
  //echo 'Search: ' . $search . '</br>';
?>
<div style="width: 2060px;padding:20px;">
<form method="post" action="forecast2.php">
<table style="width:460px;">
<tr>
<td style="border:0;"><span class="submit"><a href="forecast2.php">CLEAR</a></span></td>
<td style="border:0;"><input type="submit" value="REFRESH"></td>
<td style="border:0;"><b>Show #:</b><select style="font-family:Arial;font-size:11px;" name="limit">
<option value="<?php echo $limit; ?>" selected="selected"><?php echo $limit; ?></option>
<option value="10">10</option>
<option value="25">25</option>
<option value="50">50</option>
<option value="100">100</option>
<option value="500">500</option>
</select>
</td>

<td style="border:0;"><b>Custom:</b> <input style="font-family:Arial;font-size:11px;" class="short" type="text" name="cLimit"></td>
</tr>
</table>
</br>

<table> 
<tr>
<td class="large-input"><input type="text" name="var[VENDOR_CKT_CLN]" value="<?php echo $VENDOR_CKT_CLN; ?>"></td>
<td class="large-input"><input type="text" name="var[INTERNAL_CKT_CLN]" value="<?php echo $INTERNAL_CKT_CLN; ?>"></td>
<td class="small-input"><input type="text" name="var[RATE_CODE]" value="<?php echo $RATE_CODE; ?>"></td>
<td class="med-input">
  <select name="var[NCS_OWNER]">
    <option value="<?php echo $NCS_OWNER; ?>" selected="selected"><?php echo $NCS_OWNER; ?></option>
    <?php 
      $result2= $mysqli->query("Select * from Users where ORG='Keith Hester' and NAME not in ('Adam','Keith Hester') group by NAME");
	  while($row2= $result2->fetch_assoc()) {
	    $name= $row2['NAME'];
	    echo '<option value="'.$name.'">'.$name.'</option>';
	  }
    ?>
  </select>
</td>
<td class="med-input">
  <select name="var[PROV_OWNER]">
    <option value="<?php echo $PROV_OWNER; ?>" selected="selected"><?php echo $PROV_OWNER; ?></option>
    <?php 
      $result2= $mysqli->query("Select * from Users where ORG='Tony Marler' and NAME not in ('Adam','Tony Marler') group by NAME");
	    while($row2= $result2->fetch_assoc()) {
	    $name= $row2['NAME'];
	    echo '<option value="'.$name.'">'.$name.'</option>';
	  }
    ?>
  </select>
</td>
<td class="small-input"></td>
<td class="small-input"></td>
<td class="small-input"></td>
<td class="med-input">
  <select name="var[PROJECT]">
    <option value="<?php echo $PROJECT; ?>" selected="selected"><?php echo $PROJECT; ?></option>
    <?php 
      $result2= $mysqli->query("Select * from Projects group by PROJECT");
	    while($row2= $result2->fetch_assoc()) {
	    $name= $row2['PROJECT'];
	    echo '<option value="'.$name.'">'.$name.'</option>';
	  }
    ?>
  </select>
</td>
<td class="med2-input">
  <select name="var[SUBPROJECT]">
    <option value="<?php echo $SUBPROJECT; ?>" selected="selected"><?php echo $SUBPROJECT; ?></option>
    <?php 
      $result2= $mysqli->query("Select * from Projects");
	    while($row2= $result2->fetch_assoc()) {
	    $name= $row2['SUBPROJECT'];
	    echo '<option value="'.$name.'">'.$name.'</option>';
	  }
    ?>
  </select>
</td>
<td class="med2-input">
  <select name="var[STATUS]">
    <option value="<?php echo $STATUS; ?>" selected="selected"><?php echo $STATUS; ?></option>
	<option value="PENDING SYSTEM READY">1 PEND SYS READY</option>
	<option value="PENDING PICKUP"> 2 PEND PICKUP</option>
    <option value="PENDING DS3 INSTALL">3 PEND DS3 INSTALL</option>
    <option value="PENDING INSTALL ORDER">4 PEND INSTALL ORDER</option>
	<option value="PENDING CUSTOMER ORDER">5 PEND CUST ORDER</option>
    <option value="PENDING DI ISSUE">6 PEND DI ISSUE</option>
    <option value="PENDING SUBORDINATE GROOM">7 PEND SUBORD GROOM</option>
    <option value="PENDING DESIGN">8 PEND DESIGN</option>
    <option value="PENDING FOC">9 PEND FOC</option>
	<option value="PENDING RESCHEDULE">10 PEND RESCHEDULE</option>
    <option value="PENDING VENDOR">11 PEND VENDOR</option>
    <option value="PENDING WIN">12 PEND WIN</option>
    <option value="FOC RECEIVED">13 FOC RECEIVED</option>
    <option value="PENDING DISC ORDER">14 PEND DISC ORDER</option>
    <option value="COMPLETE">15 COMPLETE</option>
    <option value="CLEARED">CLEARED</option>
    <option value="TRAFFIC">TRAFFIC</option>
    <option value="CANCELLED">CANCELLED</option>    
  </select>
</td>
<td class="med-input"><input type="text" name="var[INITIAL_FOC]" value="<?php echo $INITIAL_FOC; ?>"></td>
<td class="med-input"><input type="text" name="var[ACTUAL_FOC]" value="<?php echo $ACTUAL_FOC; ?>"></td>
<td class="med-input"><input type="text" name="var[INTERNAL_ORDER]" value="<?php echo $INTERNAL_ORDER; ?>"></td>
<td class="small-input"><input type="text" name="var[PROV_SYS]" value="<?php echo $PROV_SYS; ?>"></td>
<td class="med-input"><input type="text" name="var[NEW_ACTL]" value="<?php echo $NEW_ACTL; ?>"></td>
</tr>

</table>
</form>

<table class="sortable">
<thead>
<tr>
<th class="large">LEC Ckt</th>
<th class="large">Internal Ckt</th>
<th class="small">Rate Code</th>
<th class="med">NCS Owner</th>
<th class="med">Prov Owner</th>
<th class="small">MRC</th>
<th class="small">New MRC</th>
<th class="small">Savings</th>
<th class="med">Project</th>
<th class="med2">Sub Project</th>
<th class="med2">Status</th>
<th class="med">Initial FOC</th>
<th class="med">Actual FOC</th>
<th class="med">Internal Order</th>
<th class="small">Prov Sys</th>
<th class="med">New ACTL</th>
</tr>
</thead>

<tbody>
<?php 

  $mrcTotal= array();
  $newMRCTotal= array();
  $savingsTotal= array();
  

  if($search!='') { $result= $mysqli->query("Select * from Simple where ON_FORECAST='y' $search limit $limit"); }
  else { $result= $mysqli->query("Select * from Simple where ON_FORECAST='y' limit $limit"); }
  //$result2= $mysqli->query("Select count(*) as theCount from Simple where ON_FORECAST='y' $search limit $limit");
  //$row2= $result2->fetch_assoc();
  //$countAll= $row2['theCount'];
  while($row= $result->fetch_assoc()) {
  
    $id= $row['ID'];
    $vendorCkt= $row['VENDOR_CKT_CLN'];
	  $internalCkt= $row['INTERNAL_CKT_CLN'];
	  $mrc= $row['MRC'];
	  $newMRC= $row['NEW_MRC'];
	  $savings= $row['SAVINGS'];
	  $rateCode= $row['RATE_CODE'];
	  $ncsOwner= $row['NCS_OWNER'];
	  $provOwner= $row['PROV_OWNER'];
	  $project= $row['PROJECT'];
	  $subProject= $row['SUBPROJECT'];
	  $status= $row['STATUS'];
	  $initialFOC= $row['INITIAL_FOC'];
	  $actualFOC= $row['ACTUAL_FOC'];
	  $internalOrder= $row['INTERNAL_ORDER'];
	  $sys= $row['PROV_SYS'];
	  $newActl= $row['NEW_ACTL'];
	
	  array_push($mrcTotal,$mrc);
	  array_push($newMRCTotal,$newMRC);
	  array_push($savingsTotal,$savings);
	
	  echo '<tr>';
	  echo '<td class="large"><a href="assign.php?id='.$id.'" target="blank">' . $vendorCkt . '</a></td>';
	  echo '<td class="large">' . $internalCkt . '</td>';
	  echo '<td class="small">' . $rateCode . '</td>';
    echo '<td class="med">' . $ncsOwner . '</td>';
	  echo '<td class="med">' . $provOwner . '</td>';
	  echo '<td class="small">' . $mrc . '</td>';
	  echo '<td class="small">' . $newMRC . '</td>';
	  echo '<td class="small">' . $savings . '</td>';
	  echo '<td class="med">' . $project . '</td>';
	  echo '<td class="med2">' . $subProject . '</td>';
	  echo '<td class="med2">' . $status . '</td>';
	  echo '<td class="med">' . $initialFOC . '</td>';
	  echo '<td class="med">' . $actualFOC . '</td>';
	  echo '<td class="med">' .  $internalOrder . '</td>';
	  echo '<td class="small">' .  $sys . '</td>';
	  echo '<td class="med">' .  $newActl . '</td>';
    echo '</tr>';	
  }
  
  $totalMRC= array_sum($mrcTotal);
  $totalNewMRC= array_sum($newMRCTotal);
  $totalSavings= array_sum($savingsTotal);

  echo '<tr>';
  echo '<td class="large-total"></td>';
  echo '<td class="large-total"></td>';
  echo '<td class="small-total"></td>';
  echo '<td class="med-total"></td>';
  echo '<td class="med-total"></td>';
  echo '<td class="small-total">$ ' . number_format($totalMRC,2) . '</td>';
  echo '<td class="small-total">$ ' . number_format($totalNewMRC,2) . '</td>';
  echo '<td class="small-total">$ ' . number_format($totalSavings,2) . '</td>';
  echo '<td class="med-total"></td>';
  echo '<td class="med2-total"></td>';
  echo '<td class="med2-total"></td>';
  echo '<td class="med-total"></td>';
  echo '<td class="med-total"></td>';
  echo '<td class="med-total"></td>';
  echo '<td class="small-total"></td>';
  echo '<td class="med-total"></td>';
  echo '</tr>';	
  
  ?>
  
  
  </tbody>
  </table>
  </div>
  </body>