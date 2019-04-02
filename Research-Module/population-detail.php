<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<head>
  <link rel="icon" href="../images/favicon.ico">
  <link rel="shortcut icon" href="../images/favicon.ico">

  <title>Network Population Circuit Detail - UTOPIA</title>

<?php require_once('../connection.php'); ?>

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
#home table { border-collapse: collapse; }
#home h2 { font-size:28px; }
#home h3 { font-size:16px;border-bottom:2px #87ea09 dashed; }
#home { width: 1000px; margin: 0 auto; }
#module { font-family: Arial;float:left;padding:10px; }
#modBlock { border: 1px solid #ccc;padding:10px;margin: 0 0 10px 0; }
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
	
	  if(isset($_GET['cbKey'])) { $cbKey= $_GET['cbKey']; }
	  
	  $result= $mysqli->query("Select * from Population where CB_KEY='$cbKey' limit 1");
	  $row= $result->fetch_assoc();
	  
	?>

      <h2>Circuit Detail</h2>

      <div id="module">

		<div id="modBlock">
		<h3>Invoice Information</h3>
		  <table>
		    <tr><td><b>LEC Ckt</b></td><td><?php echo $row['LEC_CKT']; ?></td></tr>
		    <tr><td><b>Datamart MRC</b></td><td><?php echo $row['MRC']; ?></td></tr>
		    <tr><td><b>Vendor</b></td><td><?php echo $row['VENDOR_NM']; ?></td></tr>
		    <tr><td><b>Vendor Group</b></td><td><?php echo $row['VENDOR_GRP']; ?></td></tr>
		    <tr><td><b>BAN</b></td><td><?php echo $row['BAN']; ?></td></tr>
		    <tr><td><b>Bill Aloc</b></td><td><?php echo $row['UNQ_A_CLLI']; ?></td></tr>
			<tr><td><b>Bill Zloc</b></td><td><?php echo $row['UNQ_Z_CLLI']; ?></td></tr>
			<tr><td><b>Term</b></td><td><?php echo $row['TERM']; ?></td></tr>
			<tr><td><b>Term Start</b></td><td><?php echo $row['TERM_START']; ?></td></tr>
			<tr><td><b>Term End</b></td><td><?php echo $row['TERM_END']; ?></td></tr>
		  </table>
	    </div>
	  </div>
	  
	  <div id="module">
	          <div id="modBlock">
		<h3>Inventory Information</h3>
		  <table>
		    <tr><td><b>Internal Ckt</b></td><td><?php echo $row['EXCHANGE_CARRIER_CIRCUIT_ID']; ?></td></tr>
		    <tr><td><b>Parent Ckt</b></td><td><?php echo $row['PARENT_CKT']; ?></td></tr>
		    <tr><td><b>Sys</b></td><td><?php echo $row['ASAP_INSTANCE']; ?></td></tr>
		    <tr><td><b>Rate Code</b></td><td><?php echo $row['RATE_CODE']; ?></td></tr>
			<tr><td><b>Inv Aloc</b></td><td><?php echo $row['INV_A_CLLI']; ?></td></tr>
			<tr><td><b>Inv Zloc</b></td><td><?php echo $row['INV_Z_CLLI']; ?></td></tr>
			<tr><td><b>Design ID</b></td><td><?php echo $row['CIRCUIT_DESIGN_ID']; ?></td></tr>
		  </table>
		</div>
        <div id="modBlock">
		<h3>Company Information</h3>
		  <table>
		  <tr><td><b>Company</b></td><td><?php echo $row['COMPANY']; ?></td></tr>
		  <tr><td><b>BU</b></td><td><?php echo $row['BU']; ?></td></tr>
		  <tr><td><b>Revex Group</b></td><td><?php echo $row['REVEX_GRP']; ?></td></tr>
		  <tr><td><b>Fin Group</b></td><td><?php echo $row['FIN_GRP']; ?></td></tr>
		  </table>
	    </div>
		</br>
	  
	</div>
  </div>
 </body>
	
	
