<style>
body { font-family: Arial; }
table { border-collapse:collapse;font-family:Arial; }
td { border: 1px solid #ccc;padding:2px; }
h3 { font-size:20px; }
</style>

<body>
<?php

  require_once('../connection.php');
  
  if(!isset($_COOKIE['oatmeal'])) { echo '<meta http-equiv="REFRESH" content="0;url=login.php">'; } 

  $raisin= $_COOKIE['oatmeal'];
  //$raisin= "qm7he7fs7t";

  $result2= $mysqli->query("Select * from Users where RAISIN='$raisin'");
  $row2= $result2->fetch_assoc();

  $name= $row2['NAME'];
  
  $query= "Select ";
  $source= $_POST['source'];
  $queryName= $_POST['queryName'];
	$queryName= trim($queryName);
  $fields= $_POST['field'];
  $count= count($fields);
  //echo $count . '</br>';
  for($x=0;$x<($count-1);$x++) {
   
    $query.= $fields[$x] . ',';
  }
  
  $query.= $fields[$count-1];
  
  $query.= ' from ' . $source;
  
  $op= $_POST['op']; 
	$crit= $_POST['crit'];
	
	$criterias= array();
	$operators= array();
	
	//print_r($fields);
	//print_r($op) . '</br>';
	
	
	//OPERATOR COUNT, START AT ZERO
	$oCount= 0;
	
	foreach($op as $field2=>$operator) {
	
	  if($operator!='') {
	  
	    $oCount++;
	  
	    array_push($operators,array($field2,$operator));
    }
	}
	
	//CRITERIA COUNT, START AT ZERO
	$cCount= 0;
	
	foreach($crit as $field3=>$criteria) {
	
	  if($criteria!='') {
	  
	    $cCount++;
		
		array_push($criterias,$criteria);
	  }
	}
	
	//echo 'oCount: ' . $oCount . '</br>';
	//echo 'cCount: ' . $cCount . '</br>';
	
	if($oCount!=$cCount) { 
	  echo 'Error:  Number of Operators and Criteria do not match.';
	}
	
	if($oCount>0) {
	
	  if($operators[0][1]=='like') {
	   
	    $query .= ' where ' . $operators[0][0] . ' like \'%' .  $criterias[0] . '%\'';
	  }
	  
	  else {
	  
	    $query .= ' where ' . $operators[0][0] . ' '  . $operators[0][1] . ' \'' .  $criterias[0] . '\'';
	  }
	}
	
    if($oCount>1) {
	
	  for($z=1;$z<$oCount;$z++) {
	  
	    if($operators[$z][1]=='like') {
		
		  $query .= ' and ' . $operators[$z][0] . ' like \'%' .  $criterias[$z] . '%\'';
		}
		
		else {
	  
	      $query .= ' and ' . $operators[$z][0] . ' '  . $operators[$z][1] . ' \'' .  $criterias[$z] . '\'';
		}
      }
	}
	  
    echo 'Query: ' . $query . '</br>';
	

	
	$result= $mysqli->query("$query limit 1");
	if(($result)&&(mysqli_num_rows($result)>0)) {
	/*
		echo '<table>';
		
		//HEADER FIELDS
	  echo '<tr>';
	
	  foreach($fields as $field) {
	
	    echo '<th>' . $field . '</th>';
	  }
	  echo '</tr>';
		
		//RESULT ROWS
	  while($row= $result->fetch_assoc()) {
	
	    echo '<tr>';
	    foreach($row as $item) { echo '<td>' . $item . '</td>'; }
	    echo '</tr>';
	  }
		
		*/
	
	  $nameNoSpace= str_replace(" ","",$name);
	  
	  $fileDir = 'Custom/'.$nameNoSpace;
	  
	  $filename = 'Custom/'.$nameNoSpace.'/'.$queryName.'.php';
	  
	  if(!file_exists($fileDir)) {
	   
	    mkdir($fileDir,0777,true);
	  }
  
    $myfile = fopen($filename, "w") or die("Unable to open file!");
			
		fwrite($myfile,"<?php \n");
		
		  fwrite($myfile,"  require_once('../../../connection.php'); \n");
		  fwrite($myfile,"\n");
		
		  fwrite($myfile,"echo \"<div style=\\\"display:none;\\\">$query endQuery</div>\";");
		  fwrite($myfile,"\n");
		  fwrite($myfile,"\n");
	  
	    fwrite($myfile,"echo '<table>'; \n");
	      fwrite($myfile,"echo '<tr>'; \n");
	        foreach($fields as $field) {
	          fwrite($myfile,"echo '<th>$field</th>';");
	        }
	      fwrite($myfile,"echo '</tr>'; \n");
	      fwrite($myfile,"\n");
        
				//write query statement
	      fwrite($myfile,"  $");
	      fwrite($myfile,"resultNew=");
	      fwrite($myfile," $");
	      fwrite($myfile,"mysqli");
	      fwrite($myfile,"->");
	      fwrite($myfile,"query(");
	      fwrite($myfile,"\"$query\");");
	      fwrite($myfile,"\n");
				
				//write fetch while statement
	      fwrite($myfile,"  while( $");
	      fwrite($myfile,"row= $");
	      fwrite($myfile,"resultNew");
	      fwrite($myfile,"->");
	      fwrite($myfile,"fetch");
	      fwrite($myfile,"_assoc()) { \n");
	      fwrite($myfile,"\n");
		
		      //write result rows
	        fwrite($myfile,"    echo '<tr>';");
	        fwrite($myfile,"\n");
	        fwrite($myfile,"    fo");
	        fwrite($myfile,"reach(");
	        fwrite($myfile,"$");
	        fwrite($myfile,"row");
	        fwrite($myfile," as ");
	        fwrite($myfile,"$");
	        fwrite($myfile,"item) {");
	        fwrite($myfile,"\n");
	          fwrite($myfile,"      echo '<td>' . $");
	          fwrite($myfile,"item . '</td>';");
	          fwrite($myfile,"\n");
	          fwrite($myfile,"    }");
	          fwrite($myfile,"\n");
	        fwrite($myfile,"    echo '</tr>';");
	        fwrite($myfile,"\n");
	      fwrite($myfile,"  } \n");
	      fwrite($myfile,"\n");
			fwrite($myfile,"echo '</table>'; \n");
    fwrite($myfile,"?>");
    fclose($myfile);

  echo '<h3> Save Successful </h3>';
  echo 'Reloading...';	
	
	?>
	
	<script>
  setTimeout(function(){
	  parent.location.reload();
	}, 2000);
  </script>
	
	<?php
  	
	}
	
	else {
	
	  echo 'No Results Found.';
	}
	
	 
?>


