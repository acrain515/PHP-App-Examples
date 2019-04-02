<style>
body { font-family:Arial;font-size:11px; }
th { font-size:12px; }
td { font-size:11px;border:1px solid #ccc;padding:2px; }
input[type="submit"] { height:26px;margin:10px 0;padding:4px 6px;background:#14aaff;color:#fff;font-size:12px;font-weight:bold;border:1px solid #ccc; }
input[type="submit"]:hover { background:#0097ea;cursor:pointer; }
h3 { font-size: 20px; }
</style>
<body>
<?php
  
  require_once('../connection.php');
  require_once('../cookie.php');
  
  $nameNoSpace= str_replace(" ","",$name);
	
	
	$queryName= $_GET['file'];
	
	//echo $nameNoSpace . '</br>';
	echo '<h3>Edit: ' .  $queryName . '</h3>';
	
	$directory="../research/custom/".$nameNoSpace;
	
	$contents= file_get_contents($directory.'/'.$queryName.'.php');
	
	//echo $contents . '</br>';
	
	$queryText= substr($contents,strpos($contents,"Select ") + 7);
	$queryText= substr($queryText,0,strpos($queryText,"endQuery"));
	
	//echo $queryText . '</br>';
	
	
	
	$splitQuery1= explode(" from",$queryText);
	$queryPart1= $splitQuery1[0];
	$queryPart2= $splitQuery1[1];
	$fieldsSet= explode(",",$queryPart1);
	//foreach($fieldsSet as $fieldSet) {
	
	 //echo 'FieldSet: ' . $fieldSet . '</br>';
	//}

	$splitQuery2= explode(" where ",$queryPart2);
	$source= $splitQuery2[0];
	$search= $splitQuery2[1];
	
	//echo 'Table: ' . $source .'</br>';
	
	//echo 'Search: ' . $search . '</br>';
	
	$length= strlen($source);
	if($length>50) { $source= "Longhaul";

  echo '<b> Edit not currently working for Longhaul tables. </b>';
	echo '<div style="display:none;">';
	}
	
	$crits= explode("and",$search);

	$criterias= array();
	
	foreach($crits as $crit) {
	
	  $crit= trim($crit);
	  //echo 'Crit: ' . $crit . '</br>';
		
		$splitCrit= explode(" ",$crit);
		$critField= $splitCrit[0];
		$critOperator= $splitCrit[1];
		$critVar= $splitCrit[2];
		
		if(($critOperator!='in')&&($critOperator!='not in')) {
		  $critVar= str_replace("'","",$critVar);
		}
		$critVar= str_replace('%',"",$critVar);
		
		array_push($criterias,array($critField,$critOperator,$critVar));
	}
	
	//print_r($criterias);
	
	
	echo '<table>';
	echo '<form method="post" action="custom3.php">';
	echo '<tr><th></th><th>Field</th><th>Operator</th><th>Criteria</th></tr>';
	
	$result2= $mysqli->query("Show columns from $source");
	while($row2= $result2->fetch_assoc()) {
	
	  $field= $row2['Field'];
	
	  echo "<tr> \n";
	  echo '<td><input type="checkbox" name="field[]" value="'.$field.'"';
		  foreach ($fieldsSet as $fieldSet) {
			
			  $fieldSet= trim($fieldSet);
	      if($fieldSet==$field) { echo ' checked'; }
	    }	
	  echo '></td>';
    echo "\n";
	  echo '<td>' . $field . '</td>';echo "\n";
	  echo '<td>';
	    echo '<select name="op['.$field.']">';	
	      foreach($criterias as $criteria) {
			    if($criteria[0]==$field) {
				    echo '<option value="'.$criteria[1].'" selected="true">'.$criteria[1].'</option>';
			    }
		    }
		    echo '<option value=""></option>';
		    echo '<option value="=">equals</option>';
				echo '<option value="!=">does not equal</option>';
		    echo '<option value="like">like</option>';
				echo '<option value="in">in</option>';
				echo '<option value="not in">not in</option>';
		    echo '<option value=">">greater than</option>';
		    echo '<option value="<">less than</option>';
		  echo '</select>';
    echo '</td>';echo "\n";
    echo '<td><input type="text" name="crit['.$field.']"';
	    foreach($criterias as $criteria) {
			  if($criteria[0]==$field) {
				  echo ' value="'.$criteria[2].'" ';
		    }
			}
		echo '></td>';echo "\n";	  
	  echo '</tr>';echo "\n";echo "\n";
			
	}
	
	echo '<tr>';
	echo '<input type="hidden" name="source" value="'.$source.'">';
	echo '<input type="hidden" name="queryName" value="'.$queryName.'">';
	echo '<td style="border:0;"><input type="submit" value="SAVE"></td>';
	echo '</tr>';
	echo '</form>';	 
	echo '</table>';
		


	?>