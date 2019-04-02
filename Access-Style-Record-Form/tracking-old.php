<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<head>

<?php require_once('../connection.php'); ?>
<?php date_default_timezone_set('America/New_York'); ?>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

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
		input { font-size: 12px;padding:2px;border:1px solid #ccc;width:96%;background:#ededed; }
		input:hover { border:1px solid #888; }
		input:focus { border: 1px solid #ff0082;background: #fff;outline: none; }
		select { width:96%; }
		select:hover { border:1px solid #aaa; }
		select:focus { border: 1px solid #ff0082;background: #fff;outline: none; }
		textarea:hover { border:1px solid #aaa; }
		textarea:focus { border: 1px solid #ff0082;background: #fff;outline: none; }
  </style>

  <script type="text/javascript">  
    $(document).ready(function(){
      $("#report tr.hide").hide();
      $("#report tr.show").show();
      $(".arrow").click(function(){
      $(this).parents("tr").next("tr").toggle();
      $(this).toggleClass("up");
    });
  //$("#report").jExpand();
  });
  </script>


  <script>
    $(function() { $( "#forecastFOC" ).datepicker(); });
    $(function() { $( "#initialFOC" ).datepicker(); });
    $(function() { $( "#revisedFOC" ).datepicker(); });
    $(function() { $( "#actualFOC" ).datepicker(); });
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
      
    </div>
  </div>

<div id="main">
<div id="order">

<script>
  $(function() { $( "#discSRDate" ).datepicker(); });
	$(function() { $( "#softDiscDate" ).datepicker(); });
	$(function() { $( "#researchDate" ).datepicker(); });
  $(function() { $( "#dateAssigned" ).datepicker(); });
  $(function() { $( "#dateSent" ).datepicker(); });
  $(function() { $( "#focDate" ).datepicker(); });
  $(function() { $( "#completeDate" ).datepicker(); });
	$(function() { $( "#disputeIniated" ).datepicker(); });
	$(function() { $( "#disputeCompleted" ).datepicker(); });
</script>

<?php 

  $result= $mysqli->query("Select * from Dbb limit 1");
	$row= $result->fetch_assoc();
	
	$cbKey= $row['CB_KEY'];
	//echo $cbKey;

?>

<form method="post" action="tracking-update.php">


  <div style="margin:15px 0 0 0;float:left;width:460px;border:1px solid #00A4FF;border-radius:3px;padding:5px;
	background: #70dbff;background: linear-gradient(to right,#70dbff,#eee);">
  
	<!-- CUSTOMER + REV ACCOUNT INFO -->
	  <div style="background:#fff;">
		  <table>
			<tr>
			  <td colspan="3">Customer Name</br>
				<input type="text" name="customerName" value="<?php echo $row['CUSTOMER_NAME']; ?>"></td>
			</tr>
			<tr>
			  <td colspan="3">Address</br>
				<input type="text" name="address" value="<?php echo $row['ADDRESS']; ?>"></td>
			</tr>
			<tr>
				<td>Bill Sys</br>
				<select name="billSys">
				  <option value=""></option>
				  <option value="RC7" <?php if($row['BILL_SYS']=='RC7') { echo ' selected="true"'; } ?>>
					RC7</option>
					<option value="RC8" <?php if($row['BILL_SYS']=='RC8') { echo ' selected="true"'; } ?>>
					RC8</option>
					<option value="Aptis" <?php if($row['BILL_SYS']=='Aptis') { echo ' selected="true"'; } ?>>
					Aptis</option>
				</select></td>
				<td>Bill Account Status</br>
				<select name="billAcctStatus">
				  <option value=""></option>
				  <option value="In Service" <?php if($row['BILL_ACCT_STATUS']=='In Service') { echo ' selected="true"'; } ?>>
					In Service</option>
					<option value="Disconnected" <?php if($row['BILL_ACCT_STATUS']=='Disconnected') { echo ' selected="true"'; } ?>>
					Disconnected</option>
					<option value="Pending Disc" <?php if($row['BILL_ACCT_STATUS']=='Pending Disc') { echo ' selected="true"'; } ?>>
					Pend Disc</option>
					<option value="Pending Act" <?php if($row['BILL_ACCT_STATUS']=='Pending Act') { echo ' selected="true"'; } ?>>
					Pend Act</option>
				</select></td>
				<td>Bill Account</br>
				<input type="text" name="billAccount" value="<?php echo $row['BILL_ACCT']; ?>"></td>
			</tr>
			<tr>
				
				
			</tr>
		  </table>
	  </div>
	
		<!-- LEC ID AND MRC INFO -->
		<div style="margin:10px 0 0 0;background:#fff;">
      <table>
      <tr>
			  <td colspan="2" >LEC Circuit ID</br>
				<input type="text" name="lecCkt" value="<?php echo $row['LEC_CKT']; ?>"></td>
				<td>MRC</br>
				<input style="background:#e7f6ac;border:1px solid #bbb;" type="text" name="mrc" value="<?php echo $row['mrc']; ?>"></td>
			</tr>
			<tr>
				<td>BAN</br>
				<input type="text" name="ban" value="<?php echo $row['BAN']; ?>"></td>
				<td>Vendor</br>
				<input type="text" name="vendor" value="<?php echo $row['VENDOR']; ?>"></td>
				<td>ACNA</br>
				<input type="text" name="acna" value="<?php echo $row['ACNA']; ?>"></td>
			</tr>
		  </table>
		</div>
		
	<!-- INVENTORY INFO -->
		<div style="margin:10px 0 0 0;background:#fff;">
		  <table>
			<tr>
			  <td colspan="2">Internal Circuit ID</br>
				<input type="text" name="internalCkt" value="<?php echo $row['INTERNAL_CKT']; ?>"></td>
				<td>Inventory Circuit Status</br>
				<select name="invCktStatus">
				  <option value=""></option>
				  <option value="In Service" <?php if($row['BILL_ACCT_STATUS']=='In Service') { echo ' selected="true"'; } ?>>
					In Service</option>
					<option value="Disconnected" <?php if($row['BILL_ACCT_STATUS']=='Disconnected') { echo ' selected="true"'; } ?>>
					Disconnected</option>
					<option value="Pending Disc" <?php if($row['BILL_ACCT_STATUS']=='Pending Disc') { echo ' selected="true"'; } ?>>
					Pend Disc</option>
					<option value="Pending Act" <?php if($row['BILL_ACCT_STATUS']=='Pending Act') { echo ' selected="true"'; } ?>>
					Pend Act</option>
				</select></td>
			</tr>
			<tr>
			  <td>Inv Sys</br>
				<select name="invSys">
				  <option value=""></option>
				  <option value="NVX-MSS" <?php if($row['INV_SYS']=='NV-MSS') { echo ' selected="true"'; } ?>>
					NV-MSS</option>
					<option value="PAE-MSS" <?php if($row['INV_SYS']=='PAE-MSS') { echo ' selected="true"'; } ?>>
					PAE-MSS</option>
					<option value="WIN-MSS" <?php if($row['INV_SYS']=='WIN-MSS') { echo ' selected="true"'; } ?>>
					WIN-MSS</option>
				</select></td>
			  <td>Inv Account</br>
				<input type="text" name="invAccount" value="<?php echo $row['INV_ACCT']; ?>"></td>
				<td>Inv Account Status</br>
				<select name="invAcctStatus">
				  <option value=""></option>
				  <option value="In Service" <?php if($row['INV_ACCT_STATUS']=='In Service') { echo ' selected="true"'; } ?>>
					In Service</option>
					<option value="Disconnected" <?php if($row['INV_ACCT_STATUS']=='Disconnected') { echo ' selected="true"'; } ?>>
					Disconnected</option>
					<option value="Pending Disc" <?php if($row['INV_ACCT_STATUS']=='Pending Disc') { echo ' selected="true"'; } ?>>
					Pend Disc</option>
					<option value="Pending Act" <?php if($row['INV_ACCT_STATUS']=='Pending Act') { echo ' selected="true"'; } ?>>
					Pend Act</option>
				</select></td>	
			</tr>
			<tr>
				<td>Disc Serv Req</br>
				<input type="text" name="discSR" value="<?php echo $row['DISC_SR']; ?>"></td>
				<td>Disc SR Date</br>
				<input type="text" id="discSRDate" name="discSRDate" value="<?php echo $row['DISC_SR_DATE']; ?>"></td>
				<td>Disc SR Closed User</br>
				<input type="text" name="discSRUser" value="<?php echo $row['DISC_SR_DATE']; ?>"></td>
			</tr>
			</table>
	  </div>
		
	<!--CFA AND XCONNECT INFO-->
		<div style="margin:10px 0 0 0;background:#fff;">
			<table>
			<tr>
			  <td>Colo</br>
				<input type="text" name="clli" value="<?php echo $row['CLLI']; ?>"></td>
			  <td colspan="3">CFA</br>
				<input type="text" name="cfa" value="<?php echo $row['VENDOR_CFA']; ?>"></td>
			</tr>
			<tr>
				<td>Terminating Equipment</br>
				<input type="text" name="termEquipment" value="<?php echo $row['TERM_EQUIPMENT']; ?>"></td>
			
				<td>xCon?</br>
				<select name="xCon">
				  <option value=""></option>
				  <option value="y" <?php if($row['XCON_ACTIVE']=='y') { echo ' selected="true"'; } ?>>y</option>
				  <option value="n" <?php if($row['XCON_ACTIVE']=='n') { echo ' selected="true"'; } ?>>n</option>
			  </select></td>
				<td>Soft Disc Date</br>
				<input type="text" id="softDiscDate" name="softDiscDate" value=""></td>
				<td>Cond. Code?</br>
				<select name="xConCondCode">
				  <option value=""></option>
				  <option value="y" <?php if($row['XCON_COND_CODE']=='y') { echo ' selected="true"'; } ?>>y</option>
				  <option value="n" <?php if($row['XCON_COND_CODE']=='n') { echo ' selected="true"'; } ?>>n</option>
			  </select></td>
			</tr>
		  </table>
		</div>
	</div>
		
		
		
		
<!-- RIGHT SIDE --><!-- RIGHT SIDE --><!-- RIGHT SIDE -->
<!-- RIGHT SIDE --><!-- RIGHT SIDE --><!-- RIGHT SIDE -->
		
	<div style="float:right;width:500px;padding:15px 10px;">

	<!-- PROJECT INFO-->
	  <div style="background:#fff;">
		  <span style="font-size:16px;color:#333;font-weight:300;font-family:Tahoma;"><b>Project:</b>
			&nbsp; <?php echo $row['PROJECT']; ?></span>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<span style="font-size:16px;color:#333;font-weight:300;"><b>SubProject:</b>
			&nbsp; <?php echo $row['SUBPROJECT']; ?></span>
	  </div>
		
  <!-- NOTES -->
	<div style="margin:15px 0 0 0;width:480px;border:1px solid #00A4FF;border-radius:3px;padding:15px;
	background:#dcdcdc;background: linear-gradient(to left,#dcdcdc,#fff);">
	  Notes </br>
		<iframe style="border:1px solid #777;" src="notes.php?cb=<?php echo $cbKey; ?>" width="470" height="200"></iframe>
		</br></br>

	  <textarea style="width:470px;height:200px;resize:none;font-family:Arial;font-size:11px;background:#ededed;" 
		name="notes"></textarea>
	</div>
	<!-- END RIGHT SIDE-->
	</div>
	
	
		
	<div style="clear:both;"></div>

	
	<!-- RESEARCH INFORMATION -->
	
	<div style="float:left;margin:20px 0 0 0;width:580px;border:1px solid #777;border-radius:3px;padding:5px;
	background:#ffc429;background: linear-gradient(to right,#eeff3d,#bfff00);">
    <table style="border:0;">
      <tr>
			  <td>Research User ID</br>
				<input type="text" name="researchUser" value=""></td>
				<td>Date Reviewed</br>
				<input type="text" id="researchDate" name="researchDate" value=""></td>
				<td>Process Failure</br>
				<select name="processFailure">
				  <option value=""></option>
					<?php
					$resultFailure= $mysqli->query("Select * from Dbb_Process_Failure order by FAILURE");
					while($rowFailure= $resultFailure->fetch_assoc()) {
					  echo '<option value="'.$rowFailure['ID'].'"';
						if($rowFailure['ID']==$processFailure) { echo ' selected="true"'; }
						echo '>'.$rowFailure['FAILURE'].'</option>';
					}
					?>
				</select></td>
				<td style="border:2px dotted #333;">Research Status</br>
				<select name="researchStatus">
				  <option value=""></option>
					<option value="Bill Correction" <?php if($row['RESEARCH_STATUS']=='Bill Correction') { echo ' selected="true"'; } ?>>
					Bill Correction</option>
				  <option value="Disconnect" <?php if($row['RESEARCH_STATUS']=='Disconnect') { echo ' selected="true"'; } ?>>
					Disconnect</option>
					<option value="Dispute" <?php if($row['RESEARCH_STATUS']=='Dispute') { echo ' selected="true"'; } ?>>
					Dispute</option>
					<option value="Further Review" <?php if($row['RESEARCH_STATUS']=='Further Review') { echo ' selected="true"'; } ?>>
					Further Review</option>
					<option value="Report Error" <?php if($row['RESEARCH_STATUS']=='Report Error') { echo ' selected="true"'; } ?>>
					Report Error</option>
					<option value="Soft Disc" <?php if($row['RESEARCH_STATUS']=='Soft Disc') { echo ' selected="true"'; } ?>>
					Soft Disc</option>
				</select></td>
				
			</tr>
		</table>
	</div>
	
	
	
	<!-- DISCONNECT INFORMATION -->
	
	<div style="float:left;margin:20px 0 0 0;width:580px;border:1px solid #777;border-radius:3px;padding:5px;
	background:#c1ff21;background: linear-gradient(to right,#fe2b19,#ff9e00);">
    <table style="border:0;">
      <tr>
			  <td>Disc Order User ID</br>
				<input type="text" name="discUser" value=""></td>
				<td>Date Assigned</br>
				<input type="text" id="dateAssigned" name="discAssignedDate" value=""></td>
				<td>PON</br>
				<input type="text" name="discPon" value=""></td>
				<td>Status</br>
				<select name="discStatus">
				  <option value=""></option>
				  <option value="Acknowledged" <?php if($row['DISC_STATUS']=='Acknowledged') { echo ' selected="true"'; } ?>>
					Acknowledged</option>
					<option value="Confirmed" <?php if($row['DISC_STATUS']=='Confirmed') { echo ' selected="true"'; } ?>>
					Confirmed</option>
					<option value="Complete" <?php if($row['DISC_STATUS']=='Complete') { echo ' selected="true"'; } ?>>
					Complete</option>
				</select></td>
			</tr>
			<tr>
			  <td>Order #</br>
				<input type="text" name="discOrder" value=""></td>
			  <td>Date Sent</br>
				<input type="text" id="dateSent" name="dateSent" value=""></td>
				<td>FOC Date</br>
				<input type="text" id="focDate" name="focDate" value=""></td>
				<td>Complete Date</br>
				<input type="text" id="completeDate" name="completeDate" value=""></td>
			</tr>
		</table>
	</div>
	
 <!-- DISPUTE INFORMATION -->
	
	<div style="float:left;margin:20px 0 0 0;width:580px;border:1px solid #777;border-radius:3px;padding:5px;
	background:#c1ff21;background: linear-gradient(to right,#fe2b19,#ff9e00);">
    <table style="border:0;">
      <tr>
			  <td>Dispute User ID</br>
				<input type="text" name="disputeUser" value=""></td>
				<td>Date Initiated</br>
				<input type="text" id="disputeInitiated" name="disputeInitiated" value=""></td>
				<td>Date Completed</br>
				<input type="text" id="disputeCompleted" name="disputeCompleted" value=""></td>
				<td>Total $ Credited</br>
				<input type="text" name="disputeSavings" value=""></td>		
			</tr>
		</table>
	</div>
	
	
	
	 <!-- BILL REVENUE CORRECTION INFORMATION -->
	
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
			
	<div style="clear:both;"></div>
				

<input type="hidden" name="id" value="<?php echo $row['ID']; ?>"/>
<input type="hidden" name="internalOrder" value="<?php echo $row['INTERNAL_ORDER']; ?>"/>
<div style="width:95%;height:50px;margin:10px auto;">
</div>
</form>

</div>
</div>
</body>