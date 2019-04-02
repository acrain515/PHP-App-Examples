<style>
* { font-family: Arial;font-size:12px; }
table { border-collapse: collapse; }
th { padding: 2px;border:1px solid #bababa; }
td { border: 1px solid #ccc;padding:2px; }
</style>

<table>
<tr>
<th>LEC_CKT</th>
<th>LEC_CKT_CLN</th>
<th>BAN</th>
<th>CB_KEY</th>
<th>MRC</th>
<th>PROJECT</th>
<th>SUBPROJECT</th>
<th>DATE_ADDED</th>
<th>TO_SD_DATE</th>
<th>RESEARCHER</th>
<th>RESEARCH_DATE</th>
<th>RESEARCH_STATUS</th>
<th>PROCESS_FAILURE</th>
<th>DISC_STATUS</th>
<th>PON</th>
<th>DISC_USER</th>
<th>TO_LEC_DATE</th>
<th>LEC_ORDER</th>
<th>FOC_DATE</th>
<th>DISC_COMPLETE_DATE</th>

</tr>

<?php  

  require_once('../connection.php');
	
	if(isset($_POST['circuits'])) {
	
	  $circuits= $_POST['circuits'];
		
		//echo $orders . '</br>';
		
		$splitCircuits= explode("\n",$circuits);
		
		foreach($splitCircuits as $lecCktCln) {
		
		  $lecCktCln= trim($lecCktCln);
		  //echo $order . '</br>';
			
			
			$result= $mysqli->query("Select * from Dbb where LEC_CKT_CLN='$lecCktCln'");
			if(($result)&&(mysqli_num_rows($result)>0)) {
			  while($row= $result->fetch_assoc()) {
				
				  echo '<tr>';
					echo '<td>' . $row['LEC_CKT'] . '</td>';
					echo '<td>' . $row['LEC_CKT_CLN'] . '</td>';
					echo '<td>' . $row['BAN'] . '</td>';
					echo '<td>' . $row['CB_KEY'] . '</td>';
					echo '<td>' . $row['MRC'] . '</td>';
					echo '<td>' . $row['PROJECT'] . '</td>';
					echo '<td>' . $row['SUBPROJECT'] . '</td>';
					echo '<td>' . $row['DATE_ADDED'] . '</td>';
					echo '<td>' . $row['TO_SD_DATE'] . '</td>';
					echo '<td>' . $row['RESEARCHER'] . '</td>';
					echo '<td>' . $row['RESEARCH_DATE'] . '</td>';
					echo '<td>' . $row['RESEARCH_STATUS'] . '</td>';
					echo '<td>' . $row['PROCESS_FAILURE'] . '</td>';
					echo '<td>' . $row['DISC_STATUS'] . '</td>';
					echo '<td>' . $row['PON'] . '</td>';
					echo '<td>' . $row['DISC_USER'] . '</td>';
					echo '<td>' . $row['TO_LEC_DATE'] . '</td>';
					echo '<td>' . $row['LEC_ORDER'] . '</td>';
					echo '<td>' . $row['FOC_DATE'] . '</td>';
					echo '<td>' . $row['DISC_COMPLETE_DATE'] . '</td>';
				  echo '</tr>';
			  }	
			}
			
			//END FOREACH CIRCUIT
		}
		
		//END IF POSTED
	}
	
?>

</table>


