
<style>
* { font-size:12px; }
</style>
<div style="width:440px;">
<table>
<?php 

  $id= $_GET['id'];
	//echo $cbKey . '</br>';
	
	require_once('../connection.php');
	
	$result= $mysqli->query("Select NOTES from Dbb where ID='$id'");
	$row= $result->fetch_assoc();

	$notes= $row['NOTES'];	
	//echo $row['NOTES'];
			
	$splitNotes= explode("^L^",$notes);
	$x=0;
	foreach($splitNotes as $note) {
	
	  $x++;
		if($x>0) {
	
	    if(strpos($note,'^P^')!==false) {
	      $splitNote= explode("^P^",$note);
	      $noteDate= $splitNote[0];
			  $noteBy= $splitNote[1];
	      $noteText= $splitNote[2];
			  //$noteExcerpt= substr($noteText,0,80);
				
        
        echo '<tr>';
        echo '<td>';
				echo '<a title="Edit" href="note-edit.php?id='.$id.'&note='.$x.'">';
				echo '<img style="height:14px;border:0;" src="gear-icon.png">';
				echo '</a>';
				echo '&nbsp;&nbsp;';
				echo '<a title="Delete" href="note-delete.php?id='.$id.'&note='.$x.'"';
				echo 'onclick="if (confirm(\'Are you sure?\')) { return true; } else { return false; }">';
				echo '<img style="height:12px;border:0;" src="delete-icon.png">';
				echo '</a>';
        echo '</td>';					
		    echo '<td style="color: #77a200;"><b>' .  $noteBy . '</b></td>';
				echo '<td></td>';
        echo '<td style="text-align:right;color:#77a200;"><b>'	. $noteDate . '</b></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td colspan="3">' . $noteText . '</td>';
			  echo '</tr>';
				echo '<tr><td colspan="3" style="border-bottom:1px dotted #999;">&nbsp;</td>';
			}
	  }
	
	  else { echo $note . '</br>'; }
	}
			
?>
</table>
</div>