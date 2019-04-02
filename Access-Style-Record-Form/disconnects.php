<style>
* { font-family: Arial;font-size:12px; }
table { border-collapse:collapse; }
th { border:1px solid #777;padding:4px 2px;background: linear-gradient(to bottom, rgba(168,255,5,1) 0%, rgba(242,255,61,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a8ff05', endColorstr='#f2ff3d', GradientType=0 ); 
		text-align:center; }
td { border:1px solid #ccc;padding:2px 4px; }
button { background: #fff;border:0; }
button:hover { cursor:pointer;opacity:0.8; }

</style>

<table>
<tr><th>Circuit ID</th><th>Vendor</th><th>MRC</th><th>Project</th><th>SubProject</th>
<th>Researcher</th><th>Assigned</th><th>Sent?</th><th>FOC?</th><th></th></tr>
<?php  

  date_default_timezone_set('America/New_York');

  if(isset($_POST['go'])) {

  require_once('../connection.php');
	
	  $result= $mysqli->query("Select LEC_CKT_CLN,VENDOR,MRC,LEC_ORDER,FOC_DATE,
		PROJECT,SUBPROJECT,RESEARCHER,RESEARCH_DATE from Dbb
		where RESEARCH_STATUS in ('Disconnect','Disc Under Protest')
		and DISC_STATUS!='Complete'
		and RESEARCH_DATE>'2015-01-01'
		order by MRC desc");
		while($row= $result->fetch_assoc()) { 
		
		  $lecCkt= $row['LEC_CKT_CLN'];
			$vendor= $row['VENDOR'];
			$mrc= $row['MRC'];
			$lecOrder= $row['LEC_ORDER'];
			$focDate= $row['FOC_DATE'];
			$researchDate= $row['RESEARCH_DATE'];
			$researcher= $row['RESEARCHER'];
			$project= $row['PROJECT'];
			$subProject= $row['SUBPROJECT'];
			
			//if($focDate=='0000-00-00') { $focDate= ""; }
			//else { $focDate= strtotime($focDate); $focDate= date("m/d/Y",$focDate); }
			
			if($researchDate=='0000-00-00') { $assigned= ""; }
			else { $assigned= strtotime($researchDate); $assigned= date("m/d/Y",$assigned); }
			
			if($focDate=='0000-00-00') { $foc= "N"; }
			else { $foc= "Y"; }
			
			if($lecOrder=='') { $sent= "N"; }
			else { $sent= "Y"; }
			
			echo '<tr>';
			echo '<form method="post" action="tracking.php" target="blank">';
			echo '<td>' . $lecCkt . '</td>';
			echo '<td style="text-align:center;">' . $vendor . '</td>';
			echo '<td style="text-align:center;width:60px;">$' . number_format($mrc) . '</td>';
			echo '<td style="text-align:center;">' . $project . '</td>';
			echo '<td style="text-align:center;">' . $subProject . '</td>';
			echo '<td style="text-align:center;">' . $researcher . '</td>';
			echo '<td style="text-align:center;width:60px;">' . $assigned . '</td>';
			echo '<td style="text-align:center;">';
      if($sent=='Y') { echo '<img style="width:14px;border:0;" src="check-icon.png">'; }
			echo '</td>';
			echo '<td style="text-align:center;">';
      if($foc=='Y') { echo '<img style="width:14px;border:0;" src="check-icon.png">'; }
			echo '</td>';
			
			echo '<input type="hidden" name="filter" value="">';
			echo '<input type="hidden" name="filterType" value="equals">';
			echo '<input type="hidden" name="filterField" value="LEC_CKT_CLN">';
			echo '<input type="hidden" name="filterValue" value="'.$lecCkt.'">';
			echo '<td style="text-align:center;">';
			echo '<button onClick="this.form.submit()">';
      echo '<img style="width:14px;height:14px;" src="next-icon.png">';
      echo '</button>';
			echo '</td>';
			echo '</form>';
			echo '</tr>';
		}
	}
		
	?>
</table>