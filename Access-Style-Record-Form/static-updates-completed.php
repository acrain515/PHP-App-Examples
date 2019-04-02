<style>
* { font-family: Arial;font-size:12px; }
h2 { font-size:30px; }
table { border-collapse:collapse; }
th { padding:2px 4px; }
td { padding: 2px 4px;border:1px solid #999; }
form { margin:0;padding:0; }
input { margin:0;padding:0; }
</style>

<h2>Static Updates Completed</h2>

<table>
<tr>
<th>CVBI_KEY</th>
<th>LEC_CKT</th>
<th>BAN</th>
<th>UPDATE_FIELD</th>
<th>UPDATE_VALUE</th>
<th>DATE_REQUESTED</th>
<th>REQUESTED_BY</th>
<th>DATE_COMPLETED</th>
</tr>
<?php 

  require_once('../connection2.php');
	
	$result= $dev->query("Select * from Static_Updates
	where DATE_COMPLETED!='0000-00-00'");
	while($row= $result->fetch_assoc()) {  
	
	  echo '<tr>';
	  foreach($row as $item) { 
		
		  echo '<td>' . $item . '</td>';
		}
		echo '</tr>';
	}
	
?>
</table>