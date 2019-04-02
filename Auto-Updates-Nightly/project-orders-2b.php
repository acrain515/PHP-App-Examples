Project Orders 2b </br> 
What: Install Order </br>
From: Longhaul </br>
To: Project_Orders </br></br>
<?php

  //GETS ALL INSTALL ORDERS FROM LONGHAUL, INSERTS INTO PROJECT ORDERS TABLE WHERE NOT YET EXISTING 
  require_once('../prod.php');
	require_once('../functions.php');
  
  $result= $mysqli->query("Select ORDER_NUM
  from Longhaul
  where ORDER_NUM!=''
	and STATUS!='Complete'
  ");
  while($row= $result->fetch_assoc()) {
  
    $order= $row['ORDER_NUM'];
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
	
	nextUrl("project-orders-2c.php");
  
?>
