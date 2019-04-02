<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<head>

<?php 

  require_once('../cookie.php');
	require_once('../connection.php');
	require_once('../functions.php');
	
?>
  <link rel="icon" href="../images/favicon.ico">
  <link rel="shortcut icon" href="../images/favicon.ico">

  <title>Manual Add - UTOPIA</title>
<!--HEADER STYLE-->
<style>
body { margin:0;padding:0;background-image:url('../images/grad2.jpg');background-repeat:no-repeat;font-family:Arial;color:#222; }
a { text-decoration: none;color: #0097ea; }
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

<!-- PAGE STYLE-->
  <style>
    body { font-family:Arial; }
    h2 { font-size:28px; }
    #searchForm { margin:80px auto; }
		#searchForm table { margin: 0 auto;padding:10px; }
		#searchForm td { font-size:18px;white-space:nowrap;padding:2px 4px; }
		#searchForm input[type="radio"] { height:20px; }
    #searchForm input[type="submit"] { height:26px;margin:10px;padding:4px 6px;background:#14aaff;color:#fff;font-size:12px;font-weight:bold;border:1px solid #ccc; }
    #searchForm input[type="submit"]:hover { background:#0097ea;cursor:pointer; }
		#results { margin:40px auto; }
		#results table { border-collapse: collapse; }
		#results td { padding: 2px 4px;border:1px solid #ccc; }
		
  </style>
</head>

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
            <td><a href="../research.php">Research</a></td>
          </tr>
        </table>
      </div>
    </div>
  </div>

<div id="main">

  <h1>Manual Add</h1>

<?php
  
	if(isset($_POST['lecCkt'])) {  
	
	  $lecCkt= $_POST['lecCkt'];
		$lecCkt= clean($lecCkt);
		
		//CHECK IF ALREADY ON FORECAST
		$result= $mysqli->query("Select ID,INTERNAL_ORDER from Simple where VENDOR_CKT_CLN='$lecCkt'
    and STATUS not in ('COMPLETE','CANCELLED') limit 1");
		if(($result)&&(mysqli_num_rows($result)>0)) {
		
		  $onForecastReal= "y";
		  $row= $result->fetch_assoc();
			$id= $row['ID'];
		  $internalOrder= $row['INTERNAL_ORDER'];
			
			$link= orderPage($id,$internalOrder);
			
		  echo '<div style="margin:80px auto;width:400px;text-align:center;font-family:Arial;">';  
	    echo '<b>Notice: </b> LEC Circuit ID is already on Forecast.</br>';
			echo 'Click ';
			hyperlink($link,"HERE","blank");
			echo ' to view it or continue below.</br>';
			echo '</div>';
		}
		
		//CHECK IF IN MILEAGE TABLE
		$result= $mysqli->query("Select CB_KEY,BAN,VENDOR,ON_FORECAST from Mileage 
		where LEC_CKT='$lecCkt'");
		if(($result)&&(mysqli_num_rows($result)>0)) {
		
		  echo '<div id="results">';
		  echo 'LEC Circuit Found in Mileage Table</br></br>';
			
		  echo '<table>';
		  echo '<tr><th>LEC CKT</th><th>BAN</th><th>Vendor</th></tr>';
		
		  while($row= $result->fetch_assoc()) {  
			
			  $cbKey= $row['CB_KEY'];
				$ban= $row['BAN'];
				$vendor= $row['VENDOR'];
				$mrc= $row['MRC'];
				$onForecast= $row['ON_FORECAST'];
				
				echo '<tr>';
				echo '<td>' . $lecCkt . '</td>';
				echo '<td>' . $ban . '</td>';
				echo '<td>' . $vendor . '</td>';
				echo '<td>';
				hyperlink("test-test.php","Add to Forecast","blank");
				echo '</td>';
				echo '</tr>';
			}
			
		  echo '</table>';
			echo '</div>';
		}			
	}
	
	else {
	
	  error("DS1 For not Posted.</br> Redirecting..");
		previousPage("4");
	}
  
?>


</div>
</div>
</body>
  
  