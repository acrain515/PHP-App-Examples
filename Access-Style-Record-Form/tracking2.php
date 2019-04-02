<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<head>
<?php 

  require_once('../connection.php'); 
	include('../cookie.php');
  date_default_timezone_set('America/New_York');

  //FILTER CAPABILITY FIELDS ARRAY	
	$filterFields= array("CUSTOMER_NAME","LEC_CKT","INTERNAL_CKT","CLLI","RESEARCHER",
	"BILL_ACCT","INV_ACCT","RESEARCH_STATUS","VENDOR","PROJECT","SUBPROJECT");
?>

  <style>
    body { 
		  margin:0;padding:0;background-image:url('../images/grad2.jpg');background-repeat:no-repeat;
		  font-family:Arial;color:#222;font-size:11px;font-weight:bold;
		}
    a { text-decoration: none;color: #333; }
    #header { width:100%;height:40px;margin:0;padding:0;background:#fff;color#777;box-shadow:0 1px 4px rgba(0, 0, 0, 0.5); }
    #navbar { width:980px;margin:0 auto;padding:5px;background:#fff; }
    #logo { float:left; }
    #logo td { border: 0;padding:0;text-align:left;width:100px; }
    #menu { float:right; }
    #menu td { padding: 6px 16px; }
    #menu a { color: #222; text-decoration: none;font-size: 16px; }
    #menu a:hover { color: #ff0073; }
    #navbar table { border-collapse:collapse; }
    #main { width:1000px;background:#fff;margin:40px auto;padding:20px 20px 40px 20px;
    box-shadow:0 1px 4px rgba(0, 0, 0, 0.5), 0 0 40px rgba(0, 0, 0, 0.1) inset;
    min-height:600px; }
		
		#main table { width:100%;border:1px solid #999; }
		#main td { padding: 4px; }
		input { font-size: 12px;padding:2px;border:1px solid #ccc;width:90%;background:#ededed; }
		input:hover { border:1px solid #888; }
		input:focus { border: 1px solid #ff0082;background: #fff;outline: none; }
		select { width:96%; }
		select:hover { border:1px solid #aaa; }
		select:focus { border: 1px solid #ff0082;background: #fff;outline: none; }
		textarea:hover { border:1px solid #aaa; }
		textarea:focus { border: 1px solid #ff0082;background: #fff;outline: none; }
		input[type="radio"] { padding:0;margin:0;overflow:hidden;display:inline-block; }
		button.record-nav { background:#fff;border:0;width:14px; }
		img.record-nav { height:14px; width:14px; }
		button.record-nav:hover { cursor:pointer;opacity:0.85;}
		input[type="submit"] { width:60px;color:#fff;font-weight:bold;background:#ee377e;border:1px solid #777;border-radius:1px; }
		input[type="submit"]:hover { background: #e21b68;cursor:pointer; }
  </style>

	<style>
	<?php foreach($filterFields as $fieldName) { ?>
	  span.toggle<?php echo $fieldName; ?>:hover { cursor: pointer; }
		span.<?php echo $fieldName; ?> { 
		  display: none; background:#bbb;z-index:10;position:absolute;right:400px;top:200px;width:200px;
		  padding:4px;height:210px;border: 2px solid #bfff00; 
		}
	<?php } ?>
  </style>
	
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	
	<script>
    $(function() { $( "#DISC_SR_DATE" ).datepicker(); });
	  $(function() { $( "#SOFT_DISC_DATE" ).datepicker(); });
	  $(function() { $( "#RESEARCH_DATE" ).datepicker(); });
    $(function() { $( "#TO_SD_DATE" ).datepicker(); });
    $(function() { $( "#TO_LEC_DATE" ).datepicker(); });
    $(function() { $( "#FOC_DATE" ).datepicker(); });
    $(function() { $( "#DISC_COMPLETE_DATE" ).datepicker(); });
	  $(function() { $( "#DISPUTE_START_DATE" ).datepicker(); });
	  $(function() { $( "#DISPUTE_COMPLETE_DATE" ).datepicker(); });
		
		<?php foreach($filterFields as $fieldName) { ?>
		$(document).ready(function(){ $("span.toggle<?php echo $fieldName; ?>").click(function(){ $("span.<?php echo $fieldName; ?>").toggle(); }); });
		<?php } ?>
  </script>
		
</head>

<!-- / HEAD --> <!-- / HEAD --> <!-- / HEAD -->
<!-- / HEAD --> <!-- / HEAD --> <!-- / HEAD -->


<body>
  <div id="header">
    <div id="navbar">
      <div id="logo">
        <table>
          <tr><td><a href="index.php"><img src="../images/ulogo.png" height="28" border="0"></a></td></tr>
        </table>
      </div>
      
    </div>
  </div>

<div id="main">
<div id="order">

<?php 

  if(isset($_POST['search'])) {  
	  $search= $_POST['search'];
	}
	
	else { $search= ""; }

  if(isset($_POST['filter'])) { 
	  $filterField= $_POST['filterField'];
		$filterValue= $_POST['filterValue'];
		$filterType= $_POST['filterType'];
		
		//echo 'Filter Field: ' . $filterField . '</br>';
		
		if($filterType=='equals') { $search.= " and " . $filterField . "= '" . $filterValue . "'"; }
		else if($filterType=='contains') { $search.= " and " . $filterField . " like '%" . $filterValue . "%'"; }
		else if($filterType=='endsWith') {  $search.= " and " . $filterField . " like '%" . $filterValue . "'"; }
		else if($filterType=='beginsWith') { $search.= " and " . $filterField . " like '" . $filterValue . "%'"; }
		else if($filterType=='notEqual') { $search.= " and " . $filterField . " != '" . $filterValue . "'"; }
		else if($filterType=='notContain') { $search.= " and " . $filterField . " not like '%" . $filterValue . "%'"; }
	}
	
	//echo 'Search: ' . $search . '</br>';
	//echo '</br>';

  if(isset($_POST['idString'])) { 
	
	  $idString= $_POST['idString'];
		$idString= rtrim($idString,",");
		$currentRecord= $_POST['record'];
    //echo 'Posted</br>';
		//echo 'ID String: </br>' . $idString . '</br>';
		//echo 'Posted Record Nav: ' . $currentRecord . '</br>';
		
		$idArray= explode(",",$idString);
		//echo 'Id Array: </br>';
		//print_r($idArray);
	}
	
  else { 
	
	  $idArray= array();
    $idString= "";

    $x=0;		
		
	  $result= $mysqli->query("Select ID from Dbb where 1 $search");
		if(($result)&&(mysqli_num_rows($result)>0)) {
	    while($row= $result->fetch_assoc()) {
		
		    $x++;
		    array_push($idArray,$row['ID']);
			  $idString.= $row['ID'] .',';
	    }
		
	    sort($idArray);
		  //print_r($idArray);
		
		  $currentRecord= 0;
		  //echo 'idString: ' . $idString . '</br>';
		}
		
		else { echo '<span style="color:red;">No Results for Selected Filter.</span></br>'; }
		
	}
	
	//echo 'Current Record (on page): ' . $currentRecord . '</br>';
	$displayRecord= $currentRecord+1;
	$countRecords= count($idArray);
	$firstRecord= 0;
	$prevRecord= $currentRecord-1;
	$nextRecord= $currentRecord+1;
	$lastRecord= $countRecords-1;
	//echo 'Count: ' . $countRecords . '</br>';

	$dataID= $idArray[$currentRecord];
	//echo 'Current Data ID (in table): ' . $dataID . '</br>';
	
	echo 'Displaying Record ' . $displayRecord . ' of ' . $countRecords . '</br>';
	
	$result= $mysqli->query("Select * from Dbb where ID='$dataID'");
	$row= $result->fetch_assoc();
	
//SELECT OPTIONS ARRAYS
	$discStatusOptions= array("Acknowledged","Confirmed","Complete");
	$ynOptions= array("y","n");
	$researchStatusOptions= array("Bill Correction","Disconnect","Dispute","Further Review","Non-billing","Pending Review","Report Error","Soft Disc");
	$billSysOptions= array("RC7","RC8","Aptis");
	$statusOptions= array("In Service","Disconnected","Pending Disc","Pending Act");
	$invSysOptions= array("PAE-MSS","NVX-MSS","WIN-MSS","TSG");
	

  $processFailureOptions= array();
	$resultFailure= $mysqli->query("Select * from Dbb_Process_Failure order by FAILURE");
	while($rowFailure= $resultFailure->fetch_assoc()) {
	
	  $option= $rowFailure['FAILURE'];
		array_push($processFailureOptions,$option);
	}
					     

//SHOW STANDARD TEXT FORM FUNCTION
  function showForm($row,$name,$filter,$search,$style) {

	  $value= $row[$name];
		if(strpos($name,'_DATE')!==false) { 
		  if($value=='0000-00-00') { $value=""; }
			else { $value= strtotime($value); $value= date("m/d/Y",$value); }
		}
    echo '<form method="post" action="tracking-update.php" target="hiddenFrame">';
	  echo '<input ';
	  if($style!='X') { echo ' style="'.$style.'"'; }
	  echo 'type="text" id="'.$name.'" name="fieldValue" value="'. $value . '" onChange="this.form.submit()">';
	  echo '<input type="hidden" name="field" value="'.$name.'">';
	  echo '<input type="hidden" name="id" value="' . $row['ID'] . '">';
	  if($filter=='y') {
	    echo ' <span class="toggle'.$name.'"><img src="filter-icon.png"';
	    if(strpos($search,$name)==false) { echo ' style="opacity:0.4;"'; } 
	    echo '" border="0"></span>';
	  }
	  echo '</form>';	 
  }
	
//SHOW SELECT FIELD FORM FUNCTION
  function showFormSelect($row,$name,$filter,$search,$style,$options) {
				
	  $value= $row[$name];

		echo '<form method="post" action="tracking-update.php" target="hiddenFrame">';
		echo '<select ';
		if($style!='X') { echo ' style="'.$style.'"'; }
		echo 'name="fieldValue" onChange="this.form.submit()">';
		echo '<option value=""></option>';
	  foreach($options as $option) {
		  echo '<option value="'.$option.'"';		
			if($value==$option) { echo ' selected="true"'; }
			echo '>'.$option.'</option>';
		}
		echo '</select>';
		echo '<input type="hidden" name="field" value="'.$name.'">';
	  echo '<input type="hidden" name="id" value="'.$row['ID'].'">';
	  echo '</form>';
	}
	
?>

<div style="width:510px;float:right;margin:15px 0 0 0;">

<div style="float:left;width:400px;">
<table>
	<!-- PROJECT INFO-->
		<tr>
		  <td style="font-size:14px;color:#333;font-weight:300;font-family:Tahoma;width:160px;">
			  <b>Project:</b>
			  <?php 
				  echo $row['PROJECT']; 
				  echo '<span class="togglePROJECT"><img src="filter-icon.png"';
	        if(strpos($search,'PROJECT')==false) { echo ' style="opacity:0.4;"'; } 
	        echo '" border="0"></span>';
				?>
			</td>
			<td style="font-size:14px;color:#333;font-weight:300;font-family:Tahoma;width:220px;">
			  <b>SubProject:</b>
		    <?php echo $row['SUBPROJECT']; 
				  echo '<span class="toggleSUBPROJECT"><img src="filter-icon.png"';
	        if(strpos($search,'SUBPROJECT')==false) { echo ' style="opacity:0.4;"'; } 
	        echo '" border="0"></span>';
				?>
			</td>  
		</tr>
	</table>
</div>

<!-- RECORD NAV -->
<div style="float:right;width:100px;">
<form method="post" action="tracking.php">
<table style="height:31px;">
<tr>
<td style="padding:0 2px 0 0;">
<button class="record-nav" name="record" value="<?php echo $firstRecord; ?>" onClick="this.form.submit()">
<img style="width:14px;height:14px;" src="first-icon.png">
</button>
</td>
<td style="padding:0 2px 0 0;">
<button class="record-nav"  name="record" value="<?php echo $prevRecord; ?>" onClick="this.form.submit()">
<img style="width:14px;height:14px;" src="previous-icon.png">
</button>
</td>
<td style="padding:0 2px 0 0;">
<button class="record-nav" name="record" value="<?php echo $nextRecord; ?>" onClick="this.form.submit()">
<img style="width:14px;height:14px;" src="next-icon.png">
</button>
</td>
<td style="padding:0 2px 0 0;">
<button class="record-nav" name="record" value="<?php echo $lastRecord; ?>" onClick="this.form.submit()">
<img style="width:14px;height:14px;" src="last-icon.png">
</button>
</td>
</tr>
</table>
<input type="hidden" name="idString" value="<?php echo $idString; ?>">
</form>
</div>
</div>


<div style="margin:15px 0 0 0;float:left;width:460px;border:1px solid #bababa;border-radius:3px;padding:5px;
background: #70dbff;background: linear-gradient(to right,#70dbff,#eee);">


<!-- CUSTOMER + REVENUE ACCOUNT INFO -->
<div style="background:#fff;">
<table>
<tr><td colspan="3">Customer Name</br><?php showForm($row,"CUSTOMER_NAME","y",$search,"X");  echo "\n\n"; ?></td></tr>
<tr><td colspan="3">Address</br><?php showForm($row,"ADDRESS","n",$search,"X");  echo "\n\n"; ?></td></tr>
<tr>
<td>Bill Sys</br><?php showFormSelect($row,"BILL_SYS","n",$search,"X",$billSysOptions);  echo "\n\n"; ?></td>
<td>Bill Account Status</br><?php showFormSelect($row,"BILL_ACCT_STATUS","n",$search,"X",$statusOptions);  echo "\n\n"; ?></td>
<td>Billing Acct</br><?php showForm($row,"BILL_ACCT","y",$search,"width:100px;");  echo "\n\n"; ?></td>
</tr>
</table>
</div>
	
<!-- LEC ID AND MRC INFO -->
		<div style="margin:10px 0 0 0;background:#fff;">
      <table>
      <tr>
			  <td colspan="2" >LEC Circuit ID</br>
				<?php showForm($row,"LEC_CKT","y",$search,"X");  echo "\n\n"; ?></td>
<td>MRC</br><?php showForm($row,"MRC","n",$search,"background:#e7f6ac;border:1px solid #bbb;width:60px;");  echo "\n\n"; ?></td>
			</tr>
			<tr>
				<td>BAN</br>
				<?php showForm($row,"BAN","n",$search,"width:100px;");  echo "\n\n"; ?></td>
				<td style="width:280px;">Vendor</br>
				<?php showForm($row,"VENDOR","y",$search,"X");  echo "\n\n"; ?></td>
				<td>ACNA</br>
				<?php showForm($row,"ACNA","n",$search,"width:40px;");  echo "\n\n"; ?></td>
			</tr>
		  </table>
		</div>
		
<!-- INVENTORY INFO -->
<div style="margin:10px 0 0 0;background:#fff;">
<table>
<tr>
<td colspan="2">Internal Circuit ID</br><?php showForm($row,"INTERNAL_CKT","y",$search,"X");  echo "\n\n"; ?></td>
<td>Int Circuit Status</br><?php showFormSelect($row,"INV_CKT_STATUS","n",$search,"width:130px;",$statusOptions);  echo "\n\n"; ?></td>
</tr>
<tr>  
<td>Inv Sys</br><?php showFormSelect($row,"INV_SYS","n",$search,"width:128px;",$invSysOptions);  echo "\n\n"; ?></td>
<td style="width:240px;">Inv Account</br><?php showForm($row,"INV_ACCT","y",$search,"width:128px;");  echo "\n\n"; ?></td>
<td>Inv Acct Status</br>
<?php showFormSelect($row,"INV_ACCT_STATUS","n",$search,"width:130px;",$statusOptions);  echo "\n\n"; ?></td>	
</tr>
<tr>
<td>Disc Serv Req</br>
<?php showForm($row,"DISC_SR","n",$search,"width:128px;");  echo "\n\n"; ?></td>
				<td>Disc SR Closed User</br>
				<?php showForm($row,"DISC_SR_USER","n",$search,"width:128px;");  echo "\n\n"; ?></td>
				<td>Disc SR Date</br>
				<?php showForm($row,"DISC_SR_DATE","n",$search,"width:130px;");  echo "\n\n"; ?></td>
			</tr>
			</table>
	  </div>
		
	<!--CFA AND XCONNECT INFO-->
		<div style="margin:10px 0 0 0;background:#fff;">
			<table>
			<tr>
			  <td>Colo</br>
				<?php showForm($row,"CLLI","y",$search,"width:120px;");  echo "\n\n"; ?></td>
			  <td colspan="3">CFA</br>
				<?php showForm($row,"VENDOR_CFA","n",$search,"X");  echo "\n\n"; ?></td>
			</tr>
			<tr>
				<td>Terminating Equipment</br>
				<?php showForm($row,"TERM_EQUIPMENT","n",$search,"X");  echo "\n\n"; ?></td>
			
				<td>xCon?</br>
				<?php showFormSelect($row,"XCON_ACTIVE","n",$search,"width:60px;",$ynOptions);  echo "\n\n"; ?></td>
				<td>Cond. Code?</br>
				<?php showFormSelect($row,"XCON_COND_CODE","n",$search,"width:60px;",$ynOptions);  echo "\n\n"; ?></td>
				<td>Soft Disc Date</br>
				<?php showForm($row,"SOFT_DISC_DATE","n",$search,"X");  echo "\n\n"; ?></td>
			</tr>
		  </table>
		</div>
	</div>
		
		
		
<!-- RIGHT SIDE -->
<div style="float:right;width:500px;padding:0 10px;">
	
<!-- NOTES -->
<div style="margin:15px 0 0 0;width:480px;border:1px solid #00A4FF;border-radius:3px;padding:15px;
background:#dcdcdc;background: linear-gradient(to left,#dcdcdc,#fff);">
Notes </br>
<iframe style="border:1px solid #777;padding:0;" src="notes.php?id=<?php echo $row['ID']; ?>" width="470" height="200"></iframe>
</br></br>
<form method="post" action="tracking-update.php">
<textarea style="width:470px;height:160px;resize:none;font-family:Arial;font-size:11px;background:#ededed;" name="fieldValue">
</textarea>
<input type="hidden" name="field" value="NOTES">
<input type="hidden" name="record" value="<?php echo $currentRecord; ?>">
<input type="hidden" name="idString" value="<?php echo $idString; ?>">
<input type="hidden" name="search" value="<?php echo $search; ?>">
<input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
<div style="margin:10px 0 0 0;width:96%;text-align:right;">
<input type="submit" value="ADD">
</div>
</form>
	</div>
	<!-- END RIGHT SIDE-->
	</div>
		
	<div style="clear:both;"></div>
	
	<!-- RESEARCH INFORMATION -->
	<div style="
	<?php 
	
	  if(($row['RESEARCH_STATUS']=='Disconnect')||($row['RESEARCH_STATUS']=='Disc Complete')
	  ||($row['RESEARCH_STATUS']=='Bill Correction')||($row['RESEARCH_STATUS']=='Dispute')) { echo 'float:right;';}
		else { echo 'float:left;'; }
	?>
margin:20px 0 0 0;width:380px;border:1px solid #777;border-radius:3px;padding:5px;
background:#ffc429;background: linear-gradient(to right,#eeff3d,#bfff00);">
 <table style="border:0;">
<tr>
<td>Research User ID</br><?php showForm($row,"RESEARCHER","y",$search,"width:160px;");  echo "\n\n"; ?></td>
<td>Date Reviewed</br><?php showForm($row,"RESEARCH_DATE","n",$search,"X");  echo "\n\n"; ?></td>
</tr>
<tr>
<td>Process Failure</br>
<?php showFormSelect($row,"PROCESS_FAILURE","n",$search,"X",$processFailureOptions);  echo "\n\n"; ?></td>
<!--RESEARCH STATUS-->
<td style="border:2px dotted #333;width:160px;">Research Status</br>
<form method="post" action="tracking-update.php">
<select name="fieldValue" onChange="this.form.submit()">
<option value="<?php echo $row['RESEARCH_STATUS']; ?>" selected="true"><?php echo $row['RESEARCH_STATUS']; ?></option>
<?php 
  foreach($researchStatusOptions as $option) {
	  if($option!==$row['RESEARCH_STATUS']) { echo '<option value="'.$option.'">'.$option.'</option>'; }
	}
?>
</select>
<?php 
	    echo '<span class="toggleRESEARCH_STATUS"><img src="filter-icon.png"';
	    if(strpos($search,'RESEARCH_STATUS')==false) { echo ' style="opacity:0.4;"'; } 
	    echo '" border="0"></span>';
?>


<input type="hidden" name="field" value="RESEARCH_STATUS">
<input type="hidden" name="record" value="<?php echo $currentRecord; ?>">
<input type="hidden" name="idString" value="<?php echo $idString; ?>">
<input type="hidden" name="search" value="<?php echo $search; ?>">
<input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
</form>
</td>

</tr>
</table>
</div>
	
	
	<!-- DISCONNECT INFORMATION -->
	<?php 
	
	  if(($row['RESEARCH_STATUS']=='Disconnect')||($row['RESEARCH_STATUS']=='Disc Complete')) {
	?>
	<div style="float:left;margin:20px 0 0 0;width:580px;border:1px solid #777;border-radius:3px;padding:5px;
	background:#c1ff21;background: linear-gradient(to right,#fe2b19,#ff9e00);">
    <table style="border:0;">
      <tr>
			  <td>Disc Order User ID</br><?php showForm($row,"DISC_USER","n",$search,"X");  echo "\n\n"; ?></td>
				<td>Date Assigned</br><?php showForm($row,"TO_SD_DATE","n",$search,"X");  echo "\n\n"; ?></td>
				<td>PON</br><?php showForm($row,"PON","n",$search,"X");  echo "\n\n"; ?></td>
				<td>Status</br><?php showFormSelect($row,"DISC_STATUS","n",$search,"X",$discStatusOptions);  echo "\n\n"; ?></td>
			</tr>
			<tr>
			  <td>Order #</br><?php showForm($row,"LEC_ORDER","n",$search,"X");  echo "\n\n"; ?></td>
			  <td>Date Sent</br><?php showForm($row,"TO_LEC_DATE","n",$search,"X");  echo "\n\n"; ?></td>
				<td>FOC Date</br><?php showForm($row,"FOC_DATE","n",$search,"X");  echo "\n\n"; ?></td>
				<td>Complete Date</br><?php showForm($row,"DISC_COMPLETE_DATE","n",$search,"X");  echo "\n\n"; ?></td>
			</tr>
		</table>
	</div>
	<?php } ?>
	
 <!-- DISPUTE INFORMATION -->
 <?php 
	
	  if($row['RESEARCH_STATUS']=='Dispute') {
	?>
	<div style="float:left;margin:20px 0 0 0;width:580px;border:1px solid #777;border-radius:3px;padding:5px;
	background:#c1ff21;background: linear-gradient(to right,#fe2b19,#ff9e00);">
    <table style="border:0;">
		  <tr>
			  <td>Disc Order User ID</br><?php showForm($row,"DISC_USER","n",$search,"X");  echo "\n\n"; ?></td>
				<td>Date Assigned</br><?php showForm($row,"TO_SD_DATE","n",$search,"X");  echo "\n\n"; ?></td>
				<td>PON</br><?php showForm($row,"PON","n",$search,"X");  echo "\n\n"; ?></td>
				<td>Status</br><?php showFormSelect($row,"DISC_STATUS","n",$search,"X",$discStatusOptions);  echo "\n\n"; ?></td>
			</tr>
			<tr>
			  <td>Order #</br><?php showForm($row,"LEC_ORDER","n",$search,"X");  echo "\n\n"; ?></td>
			  <td>Date Sent</br><?php showForm($row,"TO_LEC_DATE","n",$search,"X");  echo "\n\n"; ?></td>
				<td>FOC Date</br><?php showForm($row,"FOC_DATE","n",$search,"X");  echo "\n\n"; ?></td>
				<td>Complete Date</br><?php showForm($row,"DISC_COMPLETE_DATE","n",$search,"X");  echo "\n\n"; ?></td>
			</tr>
      <tr>
			  <td>Dispute User ID</br><?php showForm($row,"DISPUTE_USER","n",$search,"X");  echo "\n\n"; ?></td>
				<td>Date Initiated</br><?php showForm($row,"DISPUTE_START_DATE","n",$search,"X");  echo "\n\n"; ?></td>
				<td>Date Completed</br><?php showForm($row,"DISPUTE_COMPLETE_DATE","n",$search,"X");  echo "\n\n"; ?></td>
				<td>Total $ Credited</br><?php showForm($row,"DISPUTE_RECOVERED_AMOUNT","n",$search,"X");  echo "\n\n"; ?></td>	
			</tr>
		</table>
	</div>
	<?php } ?>
	
	
	
	<!-- BILL REVENUE CORRECTION INFORMATION -->
	<?php 
	
	  if($row['RESEARCH_STATUS']=='Bill Correction') {
	?>
	<div style="float:left;margin:20px 0 0 0;width:580px;border:1px solid #777;border-radius:3px;padding:5px;
	background:#c1ff21;background: linear-gradient(to right,#fe2b19,#ff9e00);">
    <table style="border:0;">
      <tr>
			  <td>Bill Correction User ID</br>
				<input type="text" name="billCorrectUser" value=""></td>
				<td>Date Corrected</br>
				<input type="text" name="billCorrectDate" value=""></td>
				<td>Current MRR $</br>
				<input type="text" name="currentMRR" value=""></td>
				<td>MRR $ Added</br>
				<input type="text" name="mrrAdded" value=""></td>
			</tr>
		</table>
	</div>
	<?php } ?>
			
	<div style="clear:both;"></div>
				

<input type="hidden" name="id" value="<?php echo $row['ID']; ?>"/>
<input type="hidden" name="internalOrder" value="<?php echo $row['INTERNAL_ORDER']; ?>"/>

<?php foreach($filterFields as $fieldName) { ?>
<span class="<?php echo $fieldName; ?>">
Filter:</br>
<form method="post" action="tracking.php">
<table style="border:0;">
<tr><td style="width:20px;"><input type="radio" name="filterType" value="equals" checked="checked"></td><td>Equals</td></tr>
<tr><td style="width:20px;"><input type="radio" name="filterType" value="beginsWith"></td><td>Begins With</td></tr>
<tr><td style="width:20px;"><input type="radio" name="filterType" value="contains"></td><td>Contains</td></tr>
<tr><td style="width:20px;"><input type="radio" name="filterType" value="endsWith"></td><td>Ends With</td></tr>
<tr><td style="width:20px;"><input type="radio" name="filterType" value="notEqual"></td><td>Not Equal To</td></tr>
<tr><td style="width:20px;"><input type="radio" name="filterType" value="notContain"></td><td>Does not Contain</td></tr>
<tr><td colspan="2"><input style="border:1px solid #333;" type="text" name="filterValue" onChange="this.form.submit()"></td></tr>
</table>
<input type="hidden" name="filterField" value="<?php echo $fieldName; ?>">
<input type="hidden" name="filter" value="">
<input type="hidden" name="search" value="<?php echo $search; ?>">
</form>
</span>
<?php } ?>

</div>
</div>
<iframe style="display:none;" name="hiddenFrame" id="hiddenFrame"></iframe>
</body>

