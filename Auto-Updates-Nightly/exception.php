Exception </br>

</br>

<?php

  require_once('../prod.php');
	require_once('../functions.php');
	
	$datas= array();
	
	$result= $mysqli->query("Select * from Project_Tasks");
	while($row= $result->fetch_assoc()) {
	
	  $orderNumber= $row['ORDER_NUMBER'];
	  $task= $row['TASK_TYPE'];
	  $daysReady= $row['DAYS_READY'];
	  $releaseDate= $row['RELEASE_DATE'];
	  $activityInd= $row['ACTIVITY_IND'];
	  $rateCode= $row['RATE_CODE'];
		$owner= $row['TASK_OWNER'];
		$pastSLA= $row['PAST_SLA'];
		
		/*
		$pastSLA= str_replace("V","1",$pastSLA);
		$pastSLA= str_replace("W","2",$pastSLA);
		$pastSLA= str_replace("X","3",$pastSLA);
		$pastSLA= str_replace("Y","4",$pastSLA);
		$pastSLA= str_replace("Z","5",$pastSLA);

		if($pastSLA=='') { $pastSLA="0"; }
	  */
		
		echo 'Order Number: ' . $orderNumber . '</br>';
		
		//GET FULL NAME FROM USERS TABLE USING PARTIAL NAME FROM PROJECT_TASKS TABLE
		$result2= $mysqli->query("Select N_WIN,NAME from Users
		where NAME like '$owner%'");
		if(($result2)&&(mysqli_num_rows($result2)>0)) {
		  $row2= $result2->fetch_assoc();
		  $ownerFull= $row2['NAME'];
	  }
		
		else { $ownerFull= $owner; }
		
		//echo $ownerFull . '</br>';
		
		
		//GET SUBPROJECT,INTERNAL_CKT,OWNERS, AND CLLI FROM TRACKING FOR ORDER
		$result3= $mysqli->query("Select SUBPROJECT,INTERNAL_CKT_CLN,NEW_ACTL,ASSIGNED_TO,DESIGNER,PROVISIONER
		from Simple
		where INTERNAL_ORDER='$orderNumber' limit 1");
		//IF ORDER IS IN TRACKING
		if(($result3)&&(mysqli_num_rows($result3)>0)) {
		  $row3= $result3->fetch_assoc();
			
			$inUtopia="1";
			
		  $subProject= $row3['SUBPROJECT'];
		  $internalCktCln= $row3['INTERNAL_CKT_CLN'];
		  $clli= $row3['NEW_ACTL'];
		  $assignedTo= $row3['ASSIGNED_TO'];
			$ncsOwner= $row3['DESIGNER'];
			$provOwner= $row3['PROVISIONER'];
			
			if($ncsOwner!='') {
			  $result8= $mysqli->query("Select N_WIN from Users where NAME='$ncsOwner'");
			  $row8= $result8->fetch_assoc();
			  $ncsTeam= $row8['N_WIN'];
			}
			else { $ncsTeam=""; }
			
			if($provOwner!='') {
			  $result9= $mysqli->query("Select N_WIN from Users where NAME='$provOwner'");
			  $row9= $result9->fetch_assoc();
			  $provTeam= $row9['N_WIN'];
			}
			else { $provTeam= ""; }
			
			echo 'INTERNALCKTCLN: ' . $internalCktCln . '</br>';	

		
		  //CALCULATE ASSOCIATED SAVINGS
		  if($activityInd!='N') {
		    $result4= $mysqli->query("Select sum(SAVINGS) as ORDER_SAVINGS
		    from Simple
		    where INTERNAL_ORDER='$orderNumber'");
		    $row4= $result4->fetch_assoc();
		    $orderSavings= $row4['ORDER_SAVINGS'];
			
			  if(($orderSavings<=20)&&($rateCode=='DS1')) {
			
			    if($assignedTo!='') {
		        $result4= $mysqli->query("Select sum(SAVINGS) as ORDER_SAVINGS
		        from Simple
		        where INTERNAL_CKT_CLN='$assignedTo'");
		        $row4= $result4->fetch_assoc();
		        $orderSavings+= $row4['ORDER_SAVINGS'];
		      }
			  }
		  }
		
		  else {
			  
		    $resultSavings= $mysqli->query("Select sum(SAVINGS) as ORDER_SAVINGS
		    from Simple
		    where INTERNAL_ORDER='$assignedTo'");
		    $rowSavings= $resultSavings->fetch_assoc();
		    $orderSavings= $rowSavings['ORDER_SAVINGS'];
		  }
			
			echo 'Order Savings: ' . $orderSavings . '</br>';
			
		  //RELATED ORDERs
		  $relatedOrders= "";
		
		  //ORDERS RELATED TO GROOM DS1
		  if($rateCode=='DS1') {
		    //DISC DS3 ORDER
		    //GET DS3 THAT DS1 ARE ASSIGNED TO
		    $result6= $mysqli->query("Select ASSIGNED_TO from Simple
			  where INTERNAL_ORDER='$orderNumber' and ASSIGNED_TO!='' limit 1");
			  $row6= $result6->fetch_assoc();
			  $assignedTo= $row6['ASSIGNED_TO'];
			
			  //GET ID AND ORDER_NUMBER FOR DS3 DS1 ARE ASSIGNED TO
			  $result7= $mysqli->query("Select ID,INTERNAL_ORDER from Simple
			  where INTERNAL_CKT_CLN='$assignedTo' limit 1");
			  if(($result7)&&(mysqli_num_rows($result7)>0)) {
			    $row7= $result7->fetch_assoc();
			    $discDS3Order= $row7['INTERNAL_ORDER'];
			    $discDS3ID= $row7['ID'];
				
				  if($discDS3Order=='TBD') {
				  	
					  $relatedOrders.= 'ID:'.$discDS3ID.'(DS3 Disc)::';
			    }
					
			    else {
					  $relatedOrders.= $discDS3Order.'(DS3 Disc)::';
					
					  //NEW DS3 ORDER
			      $result8= $mysqli->query("Select ID,INTERNAL_ORDER from Simple
					  where ASSIGNED_TO='$discDS3Order' or ASSIGNED_TO='ID: $discDS3ID' limit 1");
					  if(($result8)&&(mysqli_num_rows($result8)>0)) {
					    $row8= $result8->fetch_assoc();
						
					  	$newDS3Order= $row8['INTERNAL_ORDER'];
						
						  $relatedOrders.= $newDS3Order.'(DS3 New)::';
					  }	
				  }
			  }	
		  }
		
		  //ORDERS RELATED TO GROOM DS3
		  else if(($rateCode=='DS3')&&($activityInd!='N')) {
		    $result6= $mysqli->query("Select ASSIGNED_TO from Simple
			  where INTERNAL_ORDER='$orderNumber' and ASSIGNED_TO!='' limit 1");
			  if(($result6)&&(mysqli_num_rows($result6)>0)) {
			    $row6= $result6->fetch_assoc();
			    $relatedOrders.= $row6['ASSIGNED_TO'].'(DS3 New)::';
			  }
		  }
		
		  //ORDERS RELATED TO NEW DS3
		  else if(($rateCode=='DS3')&&($activityInd=='N')) {
		    $result6= $mysqli->query("Select ASSIGNED_TO from Simple
			  where INTERNAL_ORDER='$orderNumber' and ASSIGNED_TO!='' limit 1");
			  if(($result6)&&(mysqli_num_rows($result6)>0)) {
			    $row6= $result6->fetch_assoc();
			    $ds3NewAssignedTo= $row6['ASSIGNED_TO'];
			    if(strpos($ds3NewAssignedTo,'ID:')!==false) {
			      $assignedToID= str_replace("ID: ","",$ds3NewAssignedTo);
					
					  $result7= $mysqli->query("Select ID,INTERNAL_ORDER from Simple
					  where ID='$assignedToID'");
					  $row7= $result7->fetch_assoc();
					  $discDS3Order= $row7['INTERNAL_ORDER'];
					  $discDS3ID= $row7['ID'];
					
					  if($discDS3Order=='TBD') {
					
					    $relatedOrders.= 'ID:' . $discDS3ID.'(DS3 Disc)::';
			      }
					
					  else {
					    $relatedOrders.= $discDS3Order.'(DS3 Disc)::';
					  }
				  }
				
				  else {
				    $relatedOrders.= $ds3NewAssignedTo.'(DS3 Disc)::';
			  	}
			  }  
		  }
		}
		
		
		else { 
		  $subProject= "";
		  $internalCktCln= "";
		  $clli= "";
		  $assignedTo= "";
			$orderSavings= "";
			$relatedOrders="";
			$ncsOwner="";
			$ncsTeam="";
			$provOwner="";
			$provTeam="";
			$inUtopia="0";
		}
		
	  //echo 'Order Number: ' . $orderNumber . '</br>';
		//echo 'Ready Task: ' . $task . '</br>';
		//echo 'Task Owner: ' . $ownerFull . '</br>';
		//echo 'Release Date: ' . $releaseDate . '</br>';
		//echo 'Past SLA: ' . $pastSLA . '</br>';
		//echo 'Project: ' . $subProject . '</br>';
		//echo 'Related Orders: ' . $relatedOrders . '</br>';
		//echo 'Order Savings: ' . $orderSavings . '</br>';
		//echo 'Activity Ind: ' . $activityInd . '</br>';
		//echo 'Rate Code: ' . $rateCode . '</br>';
		//echo 'Clli: ' . $clli . '</br>';
		//echo 'NCS: ' . $ncsOwner . '</br>';
		//echo 'NCS Team: ' . $ncsTeam . '</br>';
		//echo 'Prov: ' . $provOwner . '</br>';
		//echo 'Prov Team: ' . $provTeam . '</br>';
		
		array_push($datas,array($orderNumber,$task,$pastSLA,$orderSavings,$releaseDate,$rateCode,$clli,$inUtopia,
		$activityInd,$subProject,$relatedOrders,$ownerFull,$ncsOwner,$ncsTeam,$provOwner,$provTeam));
		
		echo '</br>';
	}
			
	$resultX= $mysqli->query("Delete from Exception");
		
	foreach($datas as $data) {
	
	  $orderNumber= $data[0];
		$task= $data[1];
		$pastSLA= $data[2];
		$orderSavings= $data[3];
		$releaseDate= $data[4];
		$rateCode= $data[5];
		$clli= $data[6];
		$inUtopia= $data[7];
		$orderType= $data[8];
		$project= $data[9];
		$relatedOrders= $data[10];
		$owner= $data[11];
		$ncsOwner= $data[12];
		$ncsTeam= $data[13];
		$provOwner= $data[14];
		$provTeam= $data[15];
		
		$result9= $mysqli->query("Insert into Exception
		(ORDER_NUMBER,READY_TASK,PAST_SLA,SAVINGS,RELEASE_DATE,RATE_CODE,CLLI,IN_UTOPIA,
		ACTIVITY_IND,PROJECT,RELATED_ORDERS,TASK_OWNER,NCS_OWNER,NCS_TEAM,PROV_OWNER,PROV_TEAM)
		values
		('$orderNumber','$task','$pastSLA','$orderSavings','$releaseDate','$rateCode','$clli','$inUtopia',
		'$orderType','$project','$relatedOrders','$owner','$ncsOwner','$ncsTeam','$provOwner','$provTeam')
		");
	}
		
  nextUrl("rate-code-update.php");
	
		
?>






