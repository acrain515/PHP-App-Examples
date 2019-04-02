<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<head>
<?php 

  require_once('../connection.php'); 
	require_once('../connection2.php');
	include('../cookie.php');
  date_default_timezone_set('America/New_York');

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
		$(function() { $( "#DISPUTE_ORIGINAL_FOC_DATE" ).datepicker(); });
		$(function() { $( "#BILLING_UPDATED" ).datepicker(); });
		
  </script>	
</head>


<body>
  <div id="header">
    <div id="navbar">
      <div id="logo">
        <table>
          <tr><td><a href="index.php"><img src="../images/ulogo.png" height="28" border="0"></a></td></tr>
        </table>
      </div>
			<div style="float:right;margin:5px 0 0 0;">
        <form method="post" action="http://utopia.dev.windstream.com:8080/mrr-mrc.php" target="_blank">
			    Sub ID: <input style="width:100px;" type="text" name="sub">
			    <input type="submit" value="GO">
			  </form>
			</div>
    </div>
  </div>

<div id="main">
<div id="order">

<?php 

  if(!isset($_GET['id'])) { }
  else { 
	
	  $id= $_GET['id'];

	  $result= $mysqli->query("Select * from Dbb where ID='$id'");
	  $row= $result->fetch_assoc();
	
    //SELECT OPTIONS ARRAYS
	  include('options.php');
					     
    //SHOW STANDARD TEXT FORM FUNCTION
    function showForm($row,$name,$style) { 

	    $value= $row[$name];
		  if(strpos($name,'DATE')!==false) { 
		    if($value=='0000-00-00') { $value=""; }
			  else { $value= strtotime($value); $value= date("m/d/Y",$value); }
		  }
		  if(strpos($name,'_ACCT')!==false) { 
		    if($value=='999999999') { $value=""; }
		  }
      echo '<form method="post" action="tracking-update.php" target="hiddenFrame">';
	    echo '<input ';
	    if($style!='X') { echo ' style="'.$style.'"'; }
	    echo ' type="text" id="'.$name.'" name="fieldValue" value="'. $value . '" onChange="this.form.submit()">';
	    echo '<input type="hidden" name="field" value="'.$name.'">';
	    echo '<input type="hidden" name="id" value="' . $row['ID'] . '">';
	    echo '</form>';	 
    }
	
    //SHOW SELECT FIELD FORM FUNCTION
    function showFormSelect($row,$name,$style,$options) {
				
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

<div style="float:right;width:400px;">
<table>
	<!-- PROJECT INFO-->
		<tr>
		  <td style="font-size:14px;color:#333;font-weight:300;font-family:Tahoma;width:160px;">
			  <b>Project:</b><?php echo $row['PROJECT']; ?>
			</td>
			<td style="font-size:14px;color:#333;font-weight:300;font-family:Tahoma;width:220px;">
			  <b>SubProject:</b><?php echo $row['SUBPROJECT']; ?>
			</td>  
		</tr>
	</table>
</div>

<div style="margin:15px 0 0 0;float:left;width:460px;border:1px solid #bababa;border-radius:3px;padding:5px;
background: #70dbff;background: linear-gradient(to right,#70dbff,#eee);">


<!-- CUSTOMER + REVENUE ACCOUNT INFO -->
<div style="background:#fff;">
<table>
<tr><td colspan="3">Customer Name</br><?php showForm($row,"CUSTOMER_NAME","X");  echo "\n\n"; ?></td></tr>
<tr><td colspan="3">Address</br><?php showForm($row,"ADDRESS","X");  echo "\n\n"; ?></td></tr>
<tr>
<td>Bill Sys</br><?php showFormSelect($row,"BILL_SYS","X",$billSysOptions);  echo "\n\n"; ?></td>
<td>Bill Account Status</br><?php showFormSelect($row,"BILL_ACCT_STATUS","X",$statusOptions);  echo "\n\n"; ?></td>
<td>Billing Acct</br><?php showForm($row,"BILL_ACCT","width:100px;");  echo "\n\n"; ?></td>
</tr>
</table>
</div>
	
<!-- LEC ID AND MRC INFO -->
		<div style="margin:10px 0 0 0;background:#fff;">
      <table>
      <tr>
			  <td colspan="2" >LEC Circuit ID
				
				  <?php 
					
					  $resultStatic= $dev->query("Select * from Static_Updates
						where LEC_CKT='$row[LEC_CKT]' and BAN='$row[BAN]' and DATE_COMPLETED='0000-00-00'");
						if(($resultStatic)&&(mysqli_num_rows($resultStatic)>0)) {
						  $static= "y";
						}
					?>
				  <a href="http://utopia.dev.windstream.com:8080/static-view-update.php?c=<?php echo $row['LEC_CKT_CLN']; ?>&b=<?php echo $row['BAN']; ?>&n=<?php echo $name; ?>" target="blank">
					<?php 
					
					if($static=='y') { echo '<img style="border:1px solid red;height:12px;" src="../images/gear.png">'; }
					else { echo '<img style="border:0;height:12px;" src="../images/gear.png">'; }
					
					?>
				  </a>
					</br>
				<input type="text" disabled value="<?php echo $row['LEC_CKT_CLN']; ?>">
				</td>
      <td>MRC</br><?php showForm($row,"MRC","background:#e7f6ac;border:1px solid #bbb;width:60px;");  echo "\n\n"; ?></td>
			</tr>
			<tr>
				<td>BAN</br>
				<?php showForm($row,"BAN","width:100px;");  echo "\n\n"; ?></td>
				<td style="width:280px;">Vendor</br>
				<?php showForm($row,"VENDOR","X");  echo "\n\n"; ?></td>
				<td>ACNA</br>
				<?php showForm($row,"ACNA","width:40px;");  echo "\n\n"; ?></td>
			</tr>
		  </table>
		</div>
		
<!-- INVENTORY INFO -->
<div style="margin:10px 0 0 0;background:#fff;">
<table>
<tr>
  <td style="min-width:180px;">Internal Circuit ID</br><?php showForm($row,"INTERNAL_CKT","width:160px;");  echo "\n\n"; ?></td>
  <td>Rate Code</br><?php showForm($row,"RATE_CODE","width:40px;");  echo "\n\n"; ?></td>
	<td>Inv Sys</br><?php showFormSelect($row,"INV_SYS","width:80px;",$invSysOptions);  echo "\n\n"; ?></td>
</tr>

<tr>  
<td>Inv Account</br><?php showForm($row,"INV_ACCT","width:160px;");  echo "\n\n"; ?></td>
<td>Int Circuit Status</br><?php showFormSelect($row,"INV_CKT_STATUS","width:110px;",$statusOptions);  echo "\n\n"; ?>
<td>Inv Acct Status</br>
<?php showFormSelect($row,"INV_ACCT_STATUS","width:80px;",$statusOptions);  echo "\n\n"; ?></td>	
</tr>
<tr>
<td>Disc Serv Req</br>
<?php showForm($row,"DISC_SR","width:128px;");  echo "\n\n"; ?></td>
<td>Disc SR Date</br>
				<?php showForm($row,"DISC_SR_DATE","width:60;");  echo "\n\n"; ?></td>
				<td>Disc SR User</br>
				<?php showForm($row,"DISC_SR_USER","width:80px;");  echo "\n\n"; ?></td>
				
			</tr>
			</table>
	  </div>
		
	<!--CFA AND XCONNECT INFO-->
		<div style="margin:10px 0 0 0;background:#fff;">
			<table>
			<tr>
			  <td>Colo</br>
				<?php showForm($row,"CLLI","width:120px;");  echo "\n\n"; ?></td>
			  <td colspan="3">CFA</br>
				<?php showForm($row,"VENDOR_CFA","X");  echo "\n\n"; ?></td>
			</tr>
			<tr>
				<td>Terminating Equipment</br>
				<?php showForm($row,"TERM_EQUIPMENT","X");  echo "\n\n"; ?></td>
			
				<td>xCon?</br>
				<?php showFormSelect($row,"XCON_ACTIVE","width:60px;",$ynOptions);  echo "\n\n"; ?></td>
				
				<td>Soft Disc Date</br>
				<?php showForm($row,"SOFT_DISC_DATE","X");  echo "\n\n"; ?></td>
				<td></td>
			</tr>
		  </table>
		</div>
		
		</br>
		Last Update: <?php echo $row['LAST_UPDATE']; ?>
		&nbsp; &nbsp; 
		By: <?php echo $row['LAST_UPDATE_USER']; ?>
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
<input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
<div style="margin:10px 0 0 0;width:96%;text-align:right;">
<input type="submit" value="ADD">
</div>
</form>
	</div>
	<!-- END RIGHT SIDE-->
	</div>
		
	<div style="clear:both;"></div>
	
	
	<!-- DISCONNECT INFORMATION -->

	<div style="float:left;margin:20px 10px 0 0;width:580px;border:1px solid #777;border-radius:3px;padding:5px;
	background:#c1ff21;background: linear-gradient(to right,#fe2b19,#ff9e00);">
    <table style="border:0;">
      <tr>
			  <td>Disc Order User ID</br><?php showForm($row,"DISC_USER","X");  echo "\n\n"; ?></td>
				<td>Date Assigned</br><?php showForm($row,"TO_SD_DATE","X");  echo "\n\n"; ?></td>
				<td>PON</br><?php showForm($row,"PON","X");  echo "\n\n"; ?></td>
				<td>Disc Status</br><?php showFormSelect($row,"DISC_STATUS","X",$discStatusOptions);  echo "\n\n"; ?></td>
			</tr>
			<tr>
			  <td>Order #</br><?php showForm($row,"LEC_ORDER","X");  echo "\n\n"; ?></td>
			  <td>Date Sent</br><?php showForm($row,"TO_LEC_DATE","X");  echo "\n\n"; ?></td>
				<td>FOC Date</br><?php showForm($row,"FOC_DATE","X");  echo "\n\n"; ?></td>
				<td>Complete Date</br><?php showForm($row,"DISC_COMPLETE_DATE","X");  echo "\n\n"; ?></td>
			</tr>
		</table>
	</div>

	
 <!-- DISPUTE INFORMATION -->
 <?php 
	
	  if($row['RESEARCH_STATUS']=='Disc Under Protest') {
	?>
	<div style="float:left;margin:20px 10px 0 0;width:580px;border:1px solid #777;border-radius:3px;padding:5px;
	background:#c1ff21;background: linear-gradient(to right,#fe2b19,#ff9e00);">
    <table style="border:0;">
		  <tr>
			  <td>Original LEC Order</br><?php showForm($row,"DISPUTE_ORIGINAL_LEC_ORDER","X");  echo "\n\n"; ?></td>
				<td>Original PON</br><?php showForm($row,"DISPUTE_ORIGINAL_PON","X");  echo "\n\n"; ?></td>
				<td>Original FOC Date</br><?php showForm($row,"DISPUTE_ORIGINAL_FOC_DATE","X");  echo "\n\n"; ?></td>
				<td></td>
			</tr>
		  <tr>
			  <td>Disc Order User ID</br><?php showForm($row,"DISC_USER","X");  echo "\n\n"; ?></td>
				<td>Date Assigned</br><?php showForm($row,"TO_SD_DATE","X");  echo "\n\n"; ?></td>
				<td>PON</br><?php showForm($row,"PON","X");  echo "\n\n"; ?></td>
				<td>Disc Status</br><?php showFormSelect($row,"DISC_STATUS","X",$discStatusOptions);  echo "\n\n"; ?></td>
			</tr>
			<tr>
			  <td>Order #</br><?php showForm($row,"LEC_ORDER","X");  echo "\n\n"; ?></td>
			  <td>Date Sent</br><?php showForm($row,"TO_LEC_DATE","X");  echo "\n\n"; ?></td>
				<td>FOC Date</br><?php showForm($row,"FOC_DATE","X");  echo "\n\n"; ?></td>
				<td>Complete Date</br><?php showForm($row,"DISC_COMPLETE_DATE","X");  echo "\n\n"; ?></td>
			</tr>
      <tr>
			  <td>Dispute User ID</br><?php showForm($row,"DISPUTE_USER","X");  echo "\n\n"; ?></td>
				<td>Date Initiated</br><?php showForm($row,"DISPUTE_START_DATE","X");  echo "\n\n"; ?></td>
				<td>Date Completed</br><?php showForm($row,"DISPUTE_COMPLETE_DATE","X");  echo "\n\n"; ?></td>
				<td>Total $ Credited</br><?php showForm($row,"DISPUTE_RECOVERED_AMOUNT","X");  echo "\n\n"; ?></td>	
			</tr>
		</table>
	</div>
	<?php } ?>
	
	
	
	<!-- BILL REVENUE CORRECTION INFORMATION -->
	<?php 
	
	  if($row['RESEARCH_STATUS']=='Bill Correction') {
	?>
	<div style="float:left;margin:20px 10px 0 0;width:580px;border:1px solid #777;border-radius:3px;padding:5px;
	background:#c1ff21;background: linear-gradient(to right,#fe2b19,#ff9e00);">
    <table style="border:0;">
      <tr>
				<td>Date Corrected</br>
				<?php showForm($row,"BILLING_UPDATED","X");  echo "\n\n"; ?></td>
				<input type="text" name="currentMRR" value=""></td>
				<td>MRR $ Added</br><?php showForm($row,"BILL_DIFF","X");  echo "\n\n"; ?></td>
			</tr>
		</table>
	</div>
	<?php } ?>
	
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
<td>Research User ID</br><?php showForm($row,"RESEARCHER","width:160px;");  echo "\n\n"; ?></td>
<td>Date Reviewed</br><?php showForm($row,"RESEARCH_DATE","X");  echo "\n\n"; ?></td>
</tr>
<tr>
<td>Process Failure</br>
<?php showFormSelect($row,"PROCESS_FAILURE","X",$failureOptions);  echo "\n\n"; ?></td>
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

<input type="hidden" name="field" value="RESEARCH_STATUS">
<input type="hidden" name="record" value="<?php echo $currentRecord; ?>">
<input type="hidden" name="idString" value="<?php echo $idString; ?>">
<input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
</form>
</td>

</tr>
</table>
</div>
			
	<div style="clear:both;"></div>
				

<input type="hidden" name="id" value="<?php echo $row['ID']; ?>"/>
<input type="hidden" name="internalOrder" value="<?php echo $row['INTERNAL_ORDER']; ?>"/>



</div>
</div>
<iframe style="display:none;" name="hiddenFrame" id="hiddenFrame"></iframe>

<?php } ?>
</body>

