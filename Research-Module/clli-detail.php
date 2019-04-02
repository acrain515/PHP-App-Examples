<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<head>
  <link rel="icon" href="../images/favicon.ico">
  <link rel="shortcut icon" href="../images/favicon.ico">

  <title>Clli Detail - UTOPIA</title>

<!--HEADER STYLE-->
<style>
body { margin:0;padding:0;background-image:url('../images/grad2.jpg');background-repeat:no-repeat;font-family:Arial;color:#222; }
a { text-decoration: none;color: #333; }
#header { width:100%;height:40px;margin:0;padding:0;background:#fff;color#777;box-shadow:0 1px 4px rgba(0, 0, 0, 0.5); }
#navbar { width:980px;margin:0 auto;padding:5px;background:#fff; }
#logo { float:left; }
#logo td { border: 0;padding:0;text-align:left;width:100px; }
#menu { float:right; }
#menu td { padding: 6px 16px; }
#menu a { color: #222; text-decoration: none;font-size: 16px; }
#menu a:hover { color: #ff0073; }
#navbar table { border-collapse:collapse; }
#main { width:1000px;background:#fff;margin:40px auto;padding:20px 20px 40px 20px;
box-shadow:0 1px 4px rgba(0, 0, 0, 0.5), 0 0 40px rgba(0, 0, 0, 0.1) inset;
min-height:600px; }
</style>

<style>
a { text-decoration:none;color: #222; }
a:hover { cursor-style: pointer;color:#f4006e; }
table { border-collapse: collapse; }
#home h2 { font-size:28px; }
#home h3 { font-size:16px; }
#home { width: 1000px; margin: 0 auto; }
#module { font-family: Arial;float:left;padding:10px; }
#modBlock { border: 1px solid #ccc;padding:10px; }
#module td { font-size:13px;padding: 3px 6px; }
#module th { border: 1px solid #444;font-size:13px;padding: 3px 6px;
background: rgba(168,255,5,1);
background: -moz-linear-gradient(top, rgba(168,255,5,1) 0%, rgba(242,255,61,1) 100%);
background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(168,255,5,1)), color-stop(100%, rgba(242,255,61,1)));
background: -webkit-linear-gradient(top, rgba(168,255,5,1) 0%, rgba(242,255,61,1) 100%);
background: -o-linear-gradient(top, rgba(168,255,5,1) 0%, rgba(242,255,61,1) 100%);
background: -ms-linear-gradient(top, rgba(168,255,5,1) 0%, rgba(242,255,61,1) 100%);
background: linear-gradient(to bottom, rgba(168,255,5,1) 0%, rgba(242,255,61,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a8ff05', endColorstr='#f2ff3d', GradientType=0 );
 }
</style>

<body>
  <div id="header">
    <div id="navbar">
      <div id="logo">
        <table>
          <tr><td><a href="../index.php"><img src="../images/ulogo.png" height="28" border="0"></a></td></tr>
        </table>
      </div>
      <div id="menu">
        <table>
          <tr>
		    <td><a href="../search.php">Search</a></td>
            <td><a href="../projects.php">Projects</a></td>
            <td><a href="../research.php">Research & Reporting</a></td>
          </tr>
        </table>
      </div>
    </div>
  </div>

<div id="main">
  <div id="home">
	
<?php 
	
  require_once('../connection.php');
  require_once('../connection2.php');
	
  if(isset($_GET['clli'])) { $clli= $_GET['clli']; }
	  
    echo '<h2>CLLI Detail: ' . $clli . '</h2>';
	  
	  $result= $mysqli->query("Select * from Decision_Model where CLLI='$clli'");
	  $row= $result->fetch_assoc();
	  
	  $colo= $row['DS3_ATLANTA'];
	  $image= $row['DS3_RFP'];
	  
	  
	  $result2= $dev->query("Select * from Cap_PAE where CLLI='$clli'");
	  $row2= $result2->fetch_assoc();
	  
	  $paeDS3= $row2['DS3'];
	  $paeUnassigned= $row2['UNASSIGNED'];
	  $paeInService= $row2['INSERVICE'];
	  $paePendAdd= $row2['PEND_ADD'];
	  $paePendDisc= $row2['PEND_DISC'];
	  $paeReserved= $row2['RESERVED'];
	  
	  $result3= $dev->query("Select * from Cap_NVX where CLLI='$clli'");
	  $row3= $result3->fetch_assoc();
	  
	  $nvxDS3= $row3['DS3'];
	  $nvxUnassigned= $row3['UNASSIGNED'];
	  $nvxInService= $row3['INSERVICE'];
	  $nvxPendAdd= $row3['PEND_ADD'];
	  $nvxPendDisc= $row3['PEND_DISC'];
	  $nvxReserved= $row3['RESERVED'];
	  
	  
	  if($image=='1') {
	  
	    $six= strtolower(substr($clli,0,6));
	  
	    echo '<div style="float:left;">';
		echo '<img style="padding: 20px 20px 0 20px; width:280px;" src="images/'.$six.'.jpg">';
		echo '</div>';
      }
	  

	  if(($colo==1)||($colo==2)) {
		
		echo '<div id="module">';
	    echo '<div id="modBlock">';
		echo '<h3>Colo Detail</h3>';
		 
?>
	  
     
		<table>
		<tr><th>ACTL</th><th>Company</th><th>LEC</th><th>Type</th><th>ACNA</th>
		<th>Address</th><th>City</th><th>State</th></tr>
		  
		<?php
		  
	    $result4= $dev->query("Select * from Colos where CLLI='$clli'");
		while ($row4= $result4->fetch_assoc()) {
		
		  $actl= $row4['ACTL'];
		  $company= $row4['ORIGINAL_COMP'];
	      $lec= $row4['LEC'];
		  $type= $row4['COLO_TYPE'];
		  $acna= $row4['ACNA'];
		  $street= $row4['STREET'];
		  $city= $row4['CITY'];
		  $state= $row4['STATE'];
		  //$image= $row4['IMAGE'];
			  
		  echo '<tr>';
		  echo '<td>' . $actl . '</td>';
		  echo '<td>' . $company . '</td>';
		  echo '<td>' . $lec . '</td>';
		  echo '<td>' . $type . '</td>';
		  echo '<td>' . $acna . '</td>';
		  echo '<td>' . $street . '</td>';
		  echo '<td>' . $city . '</td>';
		  echo '<td>' . $state . '</td>';
		  echo '</tr>';
		}
			
		echo '</table>';
		echo '</div>';
			
			
		echo '<div style="clear:both;">';
		echo '</div></div>';
	  }
	  ?>
	  
	  	  <div id="module">
        <div id="modBlock">
		  <h3>Project Summary</h3>
		  <table>
		    <tr><th>Project</th><th>SubProject</th><th>DS3 Count</th><th>DS1 Count</th><th>Savings</th></tr>
	  
	  <?php 
	  
	    $ds1Total= 0;
		$ds3Total= 0;
		$savingsTotal= 0;
	  
	    $result5= $mysqli->query("Select PROJECT,SUBPROJECT from Simple where NEW_ACTL like '$clli%' 
		and STATUS not in ('COMPLETE','CANCELLED') group by PROJECT,SUBPROJECT");
		while($row5= $result5->fetch_assoc()) {
		
		  $project= $row5['PROJECT'];
		  $subproject= $row5['SUBPROJECT'];
		  
		  echo '<tr>';
		  echo '<td>' . $project . '</td>';
		  echo '<td>' . $subproject . '</td>';
		  
		  //PROJECT DS3 COUNT
		  $result6= $mysqli->query("Select count(*) as theCount from Simple where NEW_ACTL like '$clli'
		  and PROJECT='$project' and SUBPROJECT='$subproject' and RATE_CODE='DS3'");
		  $row6= $result6->fetch_assoc();
		  $ds3Count= $row6['theCount'];
		  
		  $ds3Total += $ds3Count;
		  
		  //PROJECT DS1 COUNT
		  $result7= $mysqli->query("Select count(*) as theCount from Simple where NEW_ACTL like '$clli'
		  and PROJECT='$project' and SUBPROJECT='$subproject' and RATE_CODE='DS1'");
		  $row7= $result7->fetch_assoc();
		  $ds1Count= $row7['theCount'];
		  
		  $ds1Total += $ds1Count;
		  
		  //PROJECT SAVINGS
		  $result8= $mysqli->query("Select sum(SAVINGS) as theSum from Simple where NEW_ACTL like '$clli'
		  and PROJECT='$project' and SUBPROJECT='$subproject'");
		  $row8= $result8->fetch_assoc();
		  $savings= $row8['theSum'];
		  
		  $savingsTotal += $savings;
		  
		  echo '<td style="text-align:center;">' . $ds3Count . '</td>';
		  echo '<td style="text-align:center;">' . $ds1Count . '</td>';
		  echo '<td style="text-align:center;">$' . number_format($savings) . '</td>';
		  
		  
		  
		  
		  echo '</tr>';
		}
		echo '<tr><td colspan="5">&nbsp;</td></tr>';
		
		echo '<tr>';
		echo '<td style="border-top:1px solid #333;" colspan="2"><b>Total: </b></td>';
		echo '<td style="text-align:center;border-top:1px solid #333;">' . $ds3Total . '</td>';
		echo '<td style="text-align:center;border-top:1px solid #333;">' . $ds1Total . '</td>';
		echo '<td style="text-align:center;border-top:1px solid #333;">$' . number_format($savingsTotal) . '</td>'; 
		echo '</tr>';
		
	  ?>

		  </table>
	    </div>
	  </div>
	  
	  <div id="module">
        <div id="modBlock">
		  <table>
		  <tr><td><b>Traffic DS1</b></td><td><?php echo $row['TRAFFIC']; ?></td></tr>
		  <tr><td><b>SPA DS1</b></td><td><?php echo $row['DS1_SPA']; ?></td></tr>
		  <tr><td><b>UNE DS1</b></td><td><?php echo $row['DS1_UNE']; ?></td></tr>
		  </table>
	    </div>
		</div>
		<div id="module">
		<div id="modBlock">
		  <table>
		  <tr><td><b>DS3 Now</b></td><td><?php echo $row['DS3_NOW']; ?></td></tr>
		  <tr><td><b>DS3 New</b></td><td><?php echo $row['DS3_NEW']; ?></td></tr>
		  <tr><td><b>DS3 Need</b></td><td><?php echo $row['DS3_NEED']; ?></td></tr>
		  <tr><td><b>DS3 Cost</b></td><td><?php echo '$(' . number_format($row['ADD_DS3']) . ')'; ?></td></tr>
		  <tr><td><b>TSP Cost</b></td><td><?php echo '$(' . number_format($row['TSP_COST']) . ')'; ?></td></tr>
		  <tr><td><b>ACP Cost</b></td><td><?php echo '$(' . number_format($row['ACP_COST']) . ')'; ?></td></tr>
		  </table>
	    </div>
	  </div>

	  <div style="clear:both;"></div>
	  
	  
	  <div id="module">
		<div id="modBlock">
		<h3>PAE MSS Capacity</h3>
		<!--
		  <table>
		    <tr><td><b>DS3</b></td><td><?php echo $paeDS3; ?></td></tr>
		    <tr><td><b>Unassigned</b></td><td><?php echo $paeUnassigned; ?></td></tr>
		    <tr><td><b>In Service</b></td><td><?php echo $paeInService; ?></td></tr>
		    <tr><td><b>Pend Add</b></td><td><?php echo $paePendAdd; ?></td></tr>
		    <tr><td><b>Pend Disc</b></td><td><?php echo $paePendDisc; ?></td></tr>
		    <tr><td><b>Reserved</b></td><td><?php echo $paeReserved; ?></td></tr>
		  </table>
		-->
		  
		  <iframe src="capacity-pae.php?clli=<?php echo $clli; ?>" frameborder="0" scrolling="no" height="230" width="400"></iframe>
	    </div>
	  </div>
	  
	  <div id="module">
		<div id="modBlock">
		<h3>NVX MSS Capacity</h3>
		<!--
		  <table>
		    <tr><td><b>DS3</b></td><td><?php echo $nvxDS3; ?></td></tr>
		    <tr><td><b>Unassigned</b></td><td><?php echo $nvxUnassigned; ?></td></tr>
		    <tr><td><b>In Service</b></td><td><?php echo $nvxInService; ?></td></tr>
		    <tr><td><b>Pend Add</b></td><td><?php echo $nvxPendAdd; ?></td></tr>
		    <tr><td><b>Pend Disc</b></td><td><?php echo $nvxPendDisc; ?></td></tr>
		    <tr><td><b>Reserved</b></td><td><?php echo $nvxReserved; ?></td></tr>
		  </table>
		  -->
		  <iframe src="capacity-nvx.php?clli=<?php echo $clli; ?>" frameborder="0" scrolling="no" height="230" width="400"></iframe>
	    </div>
	  </div>
	  
	  

	  
	  <div style="clear:both;"></div>
	  
	  


	  
	</div>
  </div>
 </body>
	
	
