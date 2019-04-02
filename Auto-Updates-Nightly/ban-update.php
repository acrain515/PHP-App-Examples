BAN UPDATE </br>
</br>

<?php

	require_once('../prod.php');
	require_once('../functions.php');
	require_once('../kpi.php');
	
	$result= $mysqli->query("Select ID,VENDOR_CKT_CLN,VENDOR
	from Simple
  where VENDOR_CKT_CLN!=''
  and VENDOR_CKT_CLN!='NOTFOUND'	
	and BAN=''
	and STATUS not in ('COMPLETE','CANCELLED')
	and INTERNAL_ORDER!='TBD'
  ");
	if(($result)&&(mysqli_num_rows($result)>0)) {
	  while($row= $result->fetch_assoc()) {
	
	    $id= $row['ID'];
			$lecCkt= $row['VENDOR_CKT_CLN'];
			$vendor= $row['VENDOR'];
			
			echo $id . '</br>';
			echo $lecCkt . '</br>';
			
			
			$result2 = oci_parse($kpi,"Select BAN 
			from RCO.AB_CKT_COMP_STATIC
      where LEC_CKT='$lecCkt'
			and VENDOR_GRP='$vendor'
      and rownum<2
      ");
      oci_execute($result2);
      $row2 = oci_fetch_array($result2, OCI_ASSOC+OCI_RETURN_NULLS);
			
			$ban= $row2['BAN'];
			
			if($ban!='') {
			
			  echo 'BAN: ' . $ban . '</br>';
			
			  $result5= $mysqli->query("Update Simple set BAN='$ban'
			  where ID='$id'");
			}
			
			else {
			
			  $result2 = oci_parse($kpi,"Select BAN 
			  from RCO.AB_CKT_COMP_STATIC
        where LEC_CKT='$lecCkt'
			  and VENDOR_NM='$vendor'
        and rownum<2
        ");
        oci_execute($result2);
        $row2 = oci_fetch_array($result2, OCI_ASSOC+OCI_RETURN_NULLS);
			
			  $ban= $row2['BAN'];
				
				
			  if($ban!='') {
			
			    echo 'BAN: ' . $ban . '</br>';
			
			    $result5= $mysqli->query("Update Simple set BAN='$ban'
			    where ID='$id'");
			  }
				
				else {
			
			    $result5= $mysqli->query("Update Simple set BAN='X'
			    where ID='$id'");
				}
			}
			
			echo '</br>';
		}	
	}
	
	nextUrl("ban-update-2.php");
	
	
?>

