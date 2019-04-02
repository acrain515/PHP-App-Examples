<style>
body { font-family:Arial;font-size:11px; }
th { font-size:12px; }
td { font-size:11px;border:1px solid #ccc;padding:2px; }
input[type="submit"] { height:26px;margin:10px 0;padding:4px 6px;background:#14aaff;color:#fff;font-size:12px;font-weight:bold;border:1px solid #ccc; }
input[type="submit"]:hover { background:#0097ea;cursor:pointer; }
</style>

<body>
<?php
  
  if((isset($_POST['source']))&&($_POST['queryName']!='')) {
  
    //echo '<span>Select Fields: </span></br></br>';
  
    require_once('../connection.php');
  
	  if(isset($_POST['new'])) { $new= "new"; }
    $source= $_POST['source'];
	  $queryName= $_POST['queryName'];
    //echo $source . '</br>';
		$queryName= str_replace("&","and",$queryName);
	
	  echo '<table>';
	  echo '<form method="post" action="custom3.php">';
	  echo '<tr><th></th><th>Field</th><th>Operator</th><th>Criteria</th></tr>';
		
		if($source=='Longhaul') { 

      $result2= $mysqli->query("Show columns from Longhaul_Projects");
	    while($row2= $result2->fetch_assoc()) {
	
	      $field= $row2['Field'];
	
	      echo '<tr>';
	      echo '<td><input type="checkbox" name="field[]" value="Longhaul_Projects.'.$field.'"></td>';
	      echo '<td>' . $field . '</td>';
	      echo '<td>';
	        echo '<select name="op['.$field.']">';
		      echo '<option value=""></option>';
		      echo '<option value="=">equals</option>';
				  echo '<option value="!=">does not equal</option>';
		      echo '<option value="like">like</option>';
		      echo '<option value=">">greater than</option>';
		      echo '<option value="<">less than</option>';
		    echo '</select>';
        echo '</td>';
        echo '<td><input type="text" name="crit['.$field.']"></td>';	  
	      echo '</tr>';	
      }				
		
		  $result2= $mysqli->query("Show columns from Longhaul");
	    while($row2= $result2->fetch_assoc()) {
	
	      $field= $row2['Field'];
	
	      echo '<tr>';
	      echo '<td><input type="checkbox" name="field[]" value="Longhaul.'.$field.'"></td>';
	      echo '<td>' . $field . '</td>';
	      echo '<td>';
	        echo '<select name="op['.$field.']">';
		      echo '<option value=""></option>';
		      echo '<option value="=">equals</option>';
				  echo '<option value="!=">does not equal</option>';
		      echo '<option value="like">like</option>';
					echo '<option value="in">in</option>';
				  echo '<option value="not in">not in</option>';
		      echo '<option value=">">greater than</option>';
		      echo '<option value="<">less than</option>';
		    echo '</select>';
        echo '</td>';
        echo '<td><input type="text" name="crit['.$field.']"></td>';	  
	      echo '</tr>';
	    }
		}
		
		else {
	
	    $result2= $mysqli->query("Show columns from $source");
	    while($row2= $result2->fetch_assoc()) {
	
	      $field= $row2['Field'];
	
	      echo '<tr>';
	      echo '<td><input type="checkbox" name="field[]" value="'.$field.'"></td>';
	      echo '<td>' . $field . '</td>';
	      echo '<td>';
	        echo '<select name="op['.$field.']">';
		      echo '<option value=""></option>';
		      echo '<option value="=">equals</option>';
				  echo '<option value="!=">does not equal</option>';
		      echo '<option value="like">like</option>';
					echo '<option value="in">in</option>';
				  echo '<option value="not in">not in</option>';
		      echo '<option value=">">greater than</option>';
		      echo '<option value="<">less than</option>';
		    echo '</select>';
        echo '</td>';
        echo '<td><input type="text" name="crit['.$field.']"></td>';	  
	      echo '</tr>';
	    }
		}
	
	  echo '<tr>';
	  echo '<input type="hidden" name="source" value="'.$source.'">';
	  echo '<input type="hidden" name="queryName" value="'.$queryName.'">';
		echo '<input type="hidden" name="new" value="'.$new.'">';
	  echo '<td style="border:0;"><input type="submit" value="SAVE"></td>';
	  echo '</tr>';
	  echo '</form>';	 
	  echo '</table>';
  }
  
  else { echo 'Source or Query Name not set.'; }
  
?>
</body>