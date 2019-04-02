<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<head>

<style>
body { margin:0;padding:0;background-image:url('../images/grad2.jpg');background-repeat:no-repeat;font-family:Arial;color:#222; }
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
</style>

<style>
* { font-family: Arial;font-size:18px; }
h2 { font-size:28px; }
td { padding: 2px 4px; }
td.label { min-width: 120px; }
input { width:300px;border-radius:2px;border:1px solid #aaa;font-size:16px; }
select { width: 300px;font-size:16px; }
option { font-size: 16px; }
input[type="submit"] { height:26px;width:100px;margin:10px;padding:4px 6px;background:#14aaff;color:#fff;font-size:12px;font-weight:bold;border:1px solid #ccc; }
input[type="submit"]:hover { background:#0097ea;cursor:pointer; }
</style>

<?php 

  require_once('../connection.php');
	require_once('../cookie.php');
	
?>

</head>

<body>
  <div id="header">
    <div id="navbar">
      <div id="logo">
        <table>
          <tr><td><a href="../index.php"><img src="../images/ulogo.png" height="28" border="0"></a></td></tr>
        </table>
      </div>
      <?php include('nav.php'); ?>
    </div>
  </div>

<div id="main">
<h2>Manual Add</h2>

<div style="width:460px;margin:80px auto;border:1px solid #ccc;padding:20px;">
<form method="post" action="manual-add-insert.php">
<table>
<tr>
<td>Internal Ckt:</td>
<td><input type="text" name="INTERNAL_CKT"></td>
</tr>

<tr>
<td>Rate Code:</td>
<td><input type="text" name="RATE_CODE"></td>
</tr>

<tr>
<td>Prov Sys:</td>
<td>
  <select name="PROV_SYS">
	<option value=""></option>
	<option value="PAE">PAE</option>
	<option value="NVX">NVX</option>
	<option value="WIN">WIN</option>
	<option value="TSG">TSG</option>
	</select>
</td>
</tr>

<tr>
<td>Vendor Ckt:</td>
<td><input type="text" name="VENDOR_CKT"></td>
</tr>

<tr>
<td>Vendor:</td>
<td><input type="text" name="VENDOR"></td>
</tr>

<tr>
<td>BAN:</td>
<td><input type="text" name="BAN"></td>

<tr>
<td>MRC:</td>
<td><input type="text" name="MRC"></td>
</tr>

<tr>
<td>Status:</td>
<td>
  <select name="STATUS">
	<option value=""></option>
	<?php include('../status-options.php'); ?>
	</select>
</td>
</tr>

<tr>
<td>Planner:</td>
<td>
  <select name="PLANNER">
	<option value=""></option>
	<?php 
	  $resultPlanner= $mysqli->query("Select NAME from Users where NAME!='Adam' order by NAME");
		while($rowPlanner= $resultPlanner->fetch_assoc()) { 
		
		  $plannerOption= $rowPlanner['NAME'];
			
			echo '<option value="'.$plannerOption.'">'.$plannerOption.'</option>';
		}
	
  ?>
  </select>
</td>
</tr>

<tr>
<td class="label">Project:</td>
<td>
  <select name="SUBPROJECT">
	<option value=""></option>
	<?php 
	  $resultProject= $mysqli->query("Select SUBPROJECT from Projects order by SUBPROJECT");
		while($rowProject= $resultProject->fetch_assoc()) { 
		
		  $projectOption= $rowProject['SUBPROJECT'];
			
			echo '<option value="'.$projectOption.'">'.$projectOption.'</option>';
		}
	
  ?>
  </select>
</td>
</tr>

<tr><td></td><td style="text-align:right;"><input type="submit" value="ADD"></td></tr>

</table>
</form>
</div>
