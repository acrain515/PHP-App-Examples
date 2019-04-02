
<style>
* { font-size:12px;font-family:Arial; }
textarea { width:460px;height:130px;resize:none;font-family:Arial;font-size:11px;background:#ededed; }
textarea:hover { border:1px solid #aaa; }
textarea:focus { border: 1px solid #ff0082;background: #fff;outline: none; }
input[type="submit"] { width:60px;color:#fff;font-weight:bold;background:#ee377e;border:1px solid #777;border-radius:1px; }
input[type="submit"]:hover { background: #e21b68;cursor:pointer; }
</style>

<div style="width:440px;">
<?php 

  $id= $_GET['id'];
	$noteID= $_GET['note'];
	//echo $cbKey . '</br>';
	
	require_once('../connection.php');
	require_once('../functions.php');

	
	$result= $mysqli->query("Select NOTES from Dbb where ID='$id'");
	$row= $result->fetch_assoc();

	$notes= $row['NOTES'];	
	//echo $row['NOTES'];
			
	$splitNotes= explode("^L^",$notes);
	$x=0;
	foreach($splitNotes as $note) {
	
	  $x++;
		if($x==$noteID) {
	
	    if(strpos($note,'^P^')!==false) {
	      $deletedNote= $note;
		  }
			
			else { 
			
			  $deletedNote= $note;
			}	
	  }
	}
	
	///echo 'Deleted Note: ' . $deletedNote . '</br>';
	$notes= str_replace($deletedNote,"",$notes);
	//echo $notes;
	$notes= mysqli_real_escape_string($mysqli,$notes);
	$result2= $mysqli->query("Update Dbb set NOTES='$notes'
	where ID='$id'");
	
	nextUrl("notes.php?id=$id");
			
?>
</div>

