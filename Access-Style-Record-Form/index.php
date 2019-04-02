<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<head>
<?php 

  require_once('../connection.php'); 
	include('../cookie.php');
  date_default_timezone_set('America/New_York');
	
?>

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
    #main { width:1000px;height:1000px;background:#fff;margin:40px auto;padding:20px 20px 40px 20px;
    box-shadow:0 1px 4px rgba(0, 0, 0, 0.5), 0 0 40px rgba(0, 0, 0, 0.1) inset;
    min-height:600px; }
		
		h2 { font-size:26px; }
		#main td { font-size: 18px;font-family:Georgia;padding:6px 12px; }
		
		button.togglePROJECT { font-size:20px;background:#fff;border:0;color:#444; }
		button.togglePROJECT:hover { cursor:pointer; }
		tr.PROJECT { display: none; }
		
		button.toggleRESEARCHER { font-size:20px;background:#fff;border:0;color:#444; }
		button.toggleRESEARCHER:hover { cursor:pointer; }
		tr.RESEARCHER { display: none; }
		
		button.toggleDISCONNECTS { font-size:20px;background:#fff;border:0;color:#444; }
		button.toggleDISCONNECTS:hover { cursor:pointer; }
		tr.DISCONNECTS { display: none; }
		
		button.toggleRESEARCH_STATUS { font-size:20px;background:#fff;border:0;color:#444; }
		button.toggleRESEARCH_STATUS:hover { cursor:pointer; }
		tr.RESEARCH_STATUS { display: none; }
		
		button.viewAll { font-size:20px;background:#fff;border:0; }
		button.viewAll:hover { cursor:pointer; }
		
		input[type="submit"] { background: #00c7ff;color:#fff;font-weight:bold;width:60px;padding:5px 12px;
		border:1px solid #777;border-radius:2px;		}
		input[type="submit"]:hover { background #009fcc;cursor:pointer; }
		
	</style>
	
	<script>
		$(document).ready(function(){ $("span.togglePROJECT").click(function(){ 
		  $("tr.PROJECT").toggle(); }); 
		});
		$(document).ready(function(){ $("span.toggleRESEARCHER").click(function(){ 
		  $("tr.RESEARCHER").toggle(); }); 
		});
			$(document).ready(function(){ $("span.toggleDISCONNECTS").click(function(){ 
		  $("tr.DISCONNECTS").toggle(); }); 
		});
		$(document).ready(function(){ $("span.toggleRESEARCH_STATUS").click(function(){ 
		  $("tr.RESEARCH_STATUS").toggle(); }); 
		});
  </script>
	
	
</head>
<body>
  <div id="header">
    <div id="navbar">
      <div id="logo">
        <table>
          <tr><td><a href="../index.php"><img src="../images/ulogo.png" height="28" border="0"></a></td></tr>
        </table>
      </div> 
    </div>
  </div>

<div id="main">
<h2>DBB Tracking</h2>
<div style="float:left; width:620px;">
<table>

<!--
<tr>
<form method="post" action="summary-project.php" target="framePROJECT">
<td>Project Summary</td>
<td><span class="togglePROJECT">
<button class="togglePROJECT" name="go" value=""><b>+</b>
</button></td>
<td style="width:300px;"></td>
<input type="hidden" name="go" value="">
</form>
</tr>
<tr class="PROJECT">
<td colspan="3">
<iframe id="framePROJECT" name="framePROJECT" style="border:1px solid #ccc;width:600px;height:400px;" 
src="summary-project.php">
</iframe>
</td>
</tr>


<tr>
<form method="post" action="summary-researcher.php" target="frameRESEARCHER">
<td>Researcher Summary</td>
<td><span class="toggleRESEARCHER">
<button class="toggleRESEARCHER" name="go" value=""><b>+</b>
</button></td>
<td style="width:300px;"></td>
<input type="hidden" name="go" value="">
</form>
</tr>
<tr class="RESEARCHER">
<td colspan="3">
<iframe id="frameRESEARCHER" name="frameRESEARCHER" style="border:1px solid #ccc;width:600px;height:400px;" 
src="summary-researcher.php">
</iframe>
</td>
</tr>
-->

<?php if ($org=='DBB-SMB') { ?>
<tr>
<td>Datatable - SMB</td><td><a href="research-smb.php"><button class="viewAll"><img style="width:14px;" src="next-icon.png"></button></td><td></td>
</tr>
<?php } ?>

<?php if ($org=='DBB-ENT') { ?>
<tr>
<td>Datatable - ENT</td><td><a href="research-ent.php"><button class="viewAll"><img style="width:14px;" src="next-icon.png"></button></td><td></td>
</tr>
<?php } ?>

<tr>
<td>Datatable - All Circuits</td><td><a href="research-simple.php"><button class="viewAll"><img style="width:14px;" src="next-icon.png"></button></td><td></td>
</tr>

<?php if ($org=='DBB-ENT') { ?>
<tr>
<form method="post" action="tracking.php" target="blank">
<td>Form - ENT</td>
<input type="hidden" name="filter" value="">
<input type="hidden" name="filterType" value="equals">
<input type="hidden" name="filterField" value="PSR_USER">
<input type="hidden" name="filterValue" value="ENT">
<td>
<button class="viewAll" onClick="this.form.submit()"><img style="width:14px;" src="next-icon.png"></button>
</td>
<td></td>
</form>
</tr>
<?php } ?>

<?php if ($org=='DBB-SMB') { ?>
<tr>
<form method="post" action="tracking.php" target="blank">
<td>Form - SMB</td>
<input type="hidden" name="filter" value="">
<input type="hidden" name="filterType" value="in">
<input type="hidden" name="filterField" value="PSR_USER">
<input type="hidden" name="filterValue" value="'SMB','Residential'">
<td>
<button class="viewAll" onClick="this.form.submit()"><img style="width:14px;" src="next-icon.png"></button>
</td>
<td></td>
</form>
</tr>
<?php } ?>

<tr>
<td>Form - All Circuits</td><td><a href="tracking.php"><button class="viewAll"><img style="width:14px;" src="next-icon.png"></button></td><td></td>
</tr>

<!--
<tr>
<td>Assign Circuits</td><td><a href="assign.php"><button class="viewAll"><img style="width:14px;" src="next-icon.png"></button></td><td></td>
</tr>
-->

<?php if ($org=='DBB-SMB') { ?>
<tr>
<td>Import Circuits</td><td><a href="import-smb.php"><button class="viewAll"><img style="width:14px;" src="next-icon.png"></button></td><td></td>
</tr>
<?php } ?>

<?php if ($org=='DBB-ENT') { ?>
<tr>
<td>Import Circuits</td><td><a href="import-ent.php"><button class="viewAll"><img style="width:14px;" src="next-icon.png"></button></td><td></td>
</tr>
<?php } ?>

<!--
<tr>
<td>Static Updates Pending</td><td><a href="static-updates-pending.php"><button class="viewAll"><img style="width:14px;" src="next-icon.png"></button></td><td></td>
</tr>


<tr>
<td>Static Updates Completed</td><td><a href="static-updates-completed.php"><button class="viewAll"><img style="width:14px;" src="next-icon.png"></button></td><td></td>
</tr>
-->

<?php if(($level=='a')||($name=='Candace Campbell')) { ?>
<tr>
<td>Flex Edit Import</td><td><a href="edit-import.php"><button class="viewAll"><img style="width:14px;" src="next-icon.png"></button></td><td></td>
</tr>

<tr>
<td>Circuit Check</td><td><a href="circuit-check.php"><button class="viewAll"><img style="width:14px;" src="next-icon.png"></button></td><td></td>
</tr>

<tr>
<td>User Admin</td><td><a href="user-admin.php"><button class="viewAll"><img style="width:14px;" src="next-icon.png"></button></td><td></td>
</tr>

<?php } ?>

<tr>
<td>Custom Query</td><td><a href="custom.php"><button class="viewAll"><img style="width:14px;" src="next-icon.png"></button></td><td></td>
</tr>

<!--
<tr>
<form method="post" action="disconnects.php" target="frameDISCONNECTS">
<td>To Be Disconnected</td>
<td><span class="toggleDISCONNECTS">
<button class="toggleDISCONNECTS" name="go" value=""><b>+</b>
</button></td>
<td style="width:300px;"></td>
<input type="hidden" name="go" value="">
</form>
</tr>
<tr class="DISCONNECTS">
<td colspan="3">
<iframe id="frameDISCONNECTS" name="frameDISCONNECTS" style="border:1px solid #ccc;width:960px;height:600px;" 
src="disconnects.php">
</iframe>
</td>
</tr>
-->

</table>
</div>

<div style="float:right;width:340px;border:1px solid #333;padding:5px;">
<span style="font-size:18px;font-family:Georgia;">Add Circuit</span>
<form method="post" action="circuit-add.php">
<table>
<tr><td style="font-family:Arial;font-size:14px;">Lec Ckt *</td><td> <input type="text" name="LEC_CKT"></td></tr>
<tr><td style="font-family:Arial;font-size:14px;">BAN * </td><td><input type="text" name="BAN"></td></tr>
<tr>
  <td style="font-family:Arial;font-size:14px;">Researcher: </td>
  <td>
	  <select name="RESEARCHER">
      <option value=""></option>
      <option value="<?php echo $name; ?>"><?php echo $name; ?></option>
    </select>
  </td> 
</tr>
<tr><td style="font-family:Arial;font-size:14px;">Project</td><td><input type="text" name="PROJECT"></td></tr>
<tr><td style="font-family:Arial;font-size:14px;">Sub Project</td><td><input type="text" name="SUBPROJECT"></td></tr>
<tr><td></td><td><input type="submit" value="ADD"></td></tr>
</form>

</div>

<div style="clear:both;"></div>


</div>
</body>