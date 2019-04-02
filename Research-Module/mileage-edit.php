<style>
body { font-size:14px; }
input { width:300px; }
td { padding: 4px 0;font-size:14px; }
input[type="submit"] { width: 80px;height:30px; background:#14aaff;border:1px solid #ccc;color:#fff;
font-weight:bold;border-radius:1px; }
input[type="submit"]:hover { background: #1492DA;cursor:pointer; }
</style>

<body>
<div style="width:400px;margin:0 auto;font-family:Arial;">
<h2>Mileage Edit</h2>
<?php  

  require_once('../connection.php');

  if(isset($_POST['updated'])) { 
	
	  $cbKey= $_POST['updated'];
		$internalCkt= $_POST['internalCkt'];
		$clli= $_POST['clli'];
		
		$result= $mysqli->query("Update Mileage set 
		INTERNAL_CKT='$internalCkt',CLLI='$clli'
		where CB_KEY='$cbKey'");
		
		echo 'Update Successful.</br> You may now close this window.</br>';
	
	}

  else if(isset($_GET['cbKey'])) {  
	
	  $cbKey= $_GET['cbKey'];
		
		//echo $cbKey . '</br>';
		
		$result= $mysqli->query("Select * from Mileage where CB_KEY='$cbKey'");
		$row= $result->fetch_assoc();
		
		echo '</br>';
		echo '<b>Lec Ckt: ' . $row['LEC_CKT'] . '</b></br></br>';
		echo '<table>';
		echo '<form method="post" action="mileage-edit.php">';
		echo '<tr><td>Internal Ckt: </td>';
    echo '<td><input type="text" name="internalCkt" value="' . $row['INTERNAL_CKT'] . '"></td></tr>';
		echo '<tr><td>CLLI: </td>';
		echo '<td><input type="text" name="clli" value="' . $row['CLLI'] . '"></td></tr>';
		
		echo '<input type="hidden" name="updated" value="'.$cbKey.'">';
		echo '<tr><td colspan="2" style="text-align:center;"><input type="submit" value="SAVE"></td></tr>';
		echo '</form>';
		echo '</table>';
		
	}
	
?>
</div>
</body>