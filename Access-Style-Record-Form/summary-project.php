<style>
* { font-family: Arial;font-size:13px; }
table { border-collapse:collapse; }
th { border:1px solid #777;padding:4px 2px;background: linear-gradient(to bottom, rgba(168,255,5,1) 0%, rgba(242,255,61,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a8ff05', endColorstr='#f2ff3d', GradientType=0 ); 
		text-align:center; }
td { border:1px solid #ccc; }
button { background: #fff;border:0; }
button:hover { cursor:pointer;opacity:0.8; }

</style>

<table>
<tr><th>Project Name</th><th>Circuit Count</th><th>Sum MRC</th><th>Pend Review</th><th>Pend Review MRC</th><th>Go to Form</th></tr>
<?php  

  if(isset($_POST['go'])) {

  require_once('../connection.php');
	
	  $result= $mysqli->query("Select PROJECT from Dbb group by PROJECT");
		while($row= $result->fetch_assoc()) { 
		
		  $project= $row['PROJECT'];
			
			$result2= $mysqli->query("Select count(*) as COUNT,sum(MRC) as SUM from Dbb where PROJECT='$project'");
			$row2= $result2->fetch_assoc();
			
			$count= $row2['COUNT'];
			$sum= $row2['SUM'];
			
			$result3= $mysqli->query("Select count(*) as COUNT,sum(MRC) as SUM from Dbb
			where PROJECT='$project'
			and RESEARCH_STATUS like 'Pending Review'");
			$row3= $result3->fetch_assoc();
			
			$pendingCount= $row3['COUNT'];
			$pendingSum= $row3['SUM'];
			
			if($pendingCount==0) { $pendingCount=""; $pendingSum=""; }
	
			
			echo '<tr>';
			echo '<form method="post" action="tracking.php" target="blank">';
			echo '<td>' . $project . '</td>';
			echo '<td style="text-align:center;">' . $count . '</td>';
			echo '<td style="text-align:center;">$' . number_format(round($sum)) . '</td>';
			echo '<td style="text-align:center;">' . $pendingCount . '</td>';
			echo '<td style="text-align:center;">';
			if($pendingSum!='') { echo '$' . number_format(round($pendingSum)); }
			echo '</td>';
			echo '<input type="hidden" name="filter" value="">';
			echo '<input type="hidden" name="filterType" value="equals">';
			echo '<input type="hidden" name="filterField" value="PROJECT">';
			echo '<input type="hidden" name="filterValue" value="'.$project.'">';
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