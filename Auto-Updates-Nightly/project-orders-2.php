Project Orders 2 </br> 
What: INTERNAL_ORDER </br>
From: Simple </br>
To: Project_Orders </br></br>
<?php

  //GETS ALL PENDING ORDERS FROM SIMPLE, INSERTS INTO PROJECT ORDERS TABLE WHERE NOT YET EXISTING 
  require_once('../prod.php');
	require_once('../functions.php');
  
  $result= $mysqli->query("Select INTERNAL_ORDER,PROV_SYS
  from Simple
  where STATUS not in ('COMPLETE','CANCELLED')
  and INTERNAL_ORDER!='TBD'
  group by INTERNAL_ORDER
  ");
  while($row= $result->fetch_assoc()) {
  
    $order= $row['INTERNAL_ORDER'];
	  $sys= $row['PROV_SYS'];
	  $sysOrd= $sys.'-'.$order;
	
	  $result2= $mysqli->query("Select * from Project_Orders
	  where ORDER_NUMBER='$order'");
	  if(($result2)&&(mysqli_num_rows($result2)<1)) {
	  
	    $result3= $mysqli->query("Insert into Project_Orders
	    (SYSORD,ORDER_NUMBER,INVENTORY_SYS,STATUS)
	    values
	    ('$sysOrd','$order','$sys','Pending')");
	  }
  }
	
	nextUrl("project-orders-2b.php");
  
?>

