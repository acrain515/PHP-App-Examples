Project Orders 2c </br> 
What: Disc Order </br>
From: Longhaul </br>
To: Project_Orders </br></br>
<?php

  //GETS ALL PENDING ORDERS FROM SIMPLE, INSERTS INTO PROJECT ORDERS TABLE WHERE NOT YET EXISTING 
  require_once('../prod.php');
	require_once('../functions.php');

  $result= $mysqli->query("Select DPON
  from Longhaul
  where DPON!=''
	and DPON!='TBA'
	and STATUS!='Complete'
  ");
  while($row= $result->fetch_assoc()) {
  
    $order= $row['DPON'];
		$order= strtoupper($order);
	   
		echo $order . '</br>';

		$sys= "NF";
		$sysOrd= "NF-".$order;
	
	  $result2= $mysqli->query("Select * from Project_Orders
	  where ORDER_NUMBER='$order'");
	  if(($result2)&&(mysqli_num_rows($result2)<1)) {
	  
	    $result3= $mysqli->query("Insert into Project_Orders
	    (SYSORD,ORDER_NUMBER,INVENTORY_SYS,STATUS)
	    values
	    ('$sysOrd','$order','$sys','Pending')");
	  }
  }
	
	nextUrl("project-orders-2d.php");
  
?>
