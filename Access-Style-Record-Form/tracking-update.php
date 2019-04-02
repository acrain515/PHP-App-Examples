<!DOCTYPE html>
<?php

  include('../cookie.php');

  date_default_timezone_set('America/New_York');
	
	$date= date("Y-m-d h:i:s");

  if(isset($_POST['fieldValue'])) { 

    require_once('../connection.php');	
	
	  $id= $_POST['id'];
	  $field= $_POST['field'];
		$fieldValue= $_POST['fieldValue'];
		
		if(strpos($field,'DATE')!==false ) {
		
		  $fieldValue= strtotime($fieldValue);
			$fieldValue= date("Y-m-d",$fieldValue);
			
			if($fieldValue=='1969-12-31') { $fieldValue= "0000-00-00"; }
		  $result9= $mysqli->query("Update Dbb set $field= '$fieldValue',
			LAST_UPDATE='$date',
  		LAST_UPDATE_USER='$name' 
			where ID='$id'");
		}
		
		else if(($field=='NOTES')||($field=='RESEARCH_STATUS')) { 
		
		  $record= $_POST['record'];
			$idString= $_POST['idString'];
			
			if(isset($_POST['search'])) { $search= $_POST['search']; }
			
			if($field=='NOTES') {
		
		    $result= $mysqli->query("Select NOTES from Dbb where ID='$id'");
			  $row= $result->fetch_assoc();
			
			  $notes= $row['NOTES'];
				$date= date("m/d/Y");
				
				$fieldValue= nl2br($fieldValue);
				
			  $fieldValue= '^L^' . $date . '^P^' . $user . '^P^' . $fieldValue . ' ' . $notes;
				
				$fieldValue= mysqli_real_escape_string($mysqli,$fieldValue);
			}
			
			
		  $result9= $mysqli->query("Update Dbb set $field= '$fieldValue',
			LAST_UPDATE='$date',
  		LAST_UPDATE_USER='$name'
			where ID='$id'");
			
			
			echo '<body onload="document.createElement(\'form\').submit.call(document.getElementById(\'redirectForm\'))">';
			if(isset($_POST['search'])) { 
			  echo '<form id="redirectForm" name="redirectForm" method="post" action="tracking.php">';
				echo '<input type="hidden" name="idString" value="'.$idString.'">';
			  echo '<input type="hidden" name="record" value="'.$record.'">';
			  echo '<input type="hidden" name="search" value="'.$search.'">';
			}
			
			else {
			
			  echo '<form id="redirectForm" name="redirectForm" method="post" action="tracking-simple.php?id='.$id.'">';
			}
			echo '<input style="width:1;height:1;" type="submit" value="submit">';
			echo '</form>';
		}
		
		else { 
			
		  echo 'ID: ' . $id . '</br>';
		  echo 'Field: ' . $field . '</br>';
		  echo 'Field Value: ' . $fieldValue . '</br>';
		
		  $fieldValue= mysqli_real_escape_string($mysqli,$fieldValue);
		  $result9= $mysqli->query("Update Dbb set $field= '$fieldValue',
			LAST_UPDATE='$date',
  		LAST_UPDATE_USER='$name' 
			where ID='$id'");	
		}
	}
	
?>



