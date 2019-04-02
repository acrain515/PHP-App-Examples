<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<head>
<?php require_once('../cookie.php'); ?>

  <link rel="icon" href="../images/favicon.ico">
  <link rel="shortcut icon" href="../images/favicon.ico">

  <title>Customer T1 Mileage - UTOPIA</title>

  <script type="text/javascript" src="../js/jquery.js"></script>
  <script type="text/javascript" src="../js/jquery-ui.js"></script>
  <script type="text/javascript" src="../js/data-tables.js"></script>
  <script type="text/javascript" src="../js/fixed-header.js"></script>
  <link rel="stylesheet" type="text/css" href="../js/dt-searchtop.css">

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
#main { width:1100px;background:#fff;margin:40px auto;padding:20px 20px 40px 20px;
box-shadow:0 1px 4px rgba(0, 0, 0, 0.5), 0 0 40px rgba(0, 0, 0, 0.1) inset;
min-height:600px; }
</style>


<style>
h2 { font-size: 28px; }
#research2 { width: 1100px; margin:0 auto; }
#research2 a { text-decoration:none;color:#222; }
#research2 a:hover { color:#ff0073; }
#research2 th { text-align:center;font-size:11px; }
#research2 td { text-align:center;font-size:11px; }
#research2 input[type="submit"] { height:26px;margin:10px 0;padding:4px 6px;background:#14aaff;color:#fff;font-size:12px;font-weight:bold;border:1px solid #ccc; }
#research2 input[type="submit"]:hover { background:#0097ea;cursor:pointer; }
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
      <?php include('nav.php'); ?>
    </div>
  </div>

<div id="main">
<div id="research2">
<h2>Customer T1 Mileage</h2>


<script type="text/javascript">
$(document).ready(function() {

  // Setup - add a text input to each footer cell
  $('#example tfoot th').each( function (i) {
    var title = $('#example thead th').eq( $(this).index() ).text();
    if(i==2||i==3||i==4||i==5||i==8||i==9||i==10||i==11||i==12)
    $(this).html( '<input type="text" placeholder="'+title+'" />' );
  } );

  // DataTable
  var table = $("#example").DataTable({
    'processing': true,
    'serverSide': true,
    'ajax': "mileage-source.php"  
  });

  // Apply the search
  table.columns().eq( 0 ).each( function ( colIdx ) {
    $( 'input', table.column( colIdx ).footer() ).on( 'keyup change', function () {
      table
      .column( colIdx )
      .search( this.value )
      .draw();
    } );
  } );

} );
</script>


<script type="text/javascript">
$(document).ready(function() {
    $('#selectAll').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
        }
    });
   
});
</script>

<form method="post" action="mileage-manage.php">
  <table id="example" class="display" cellspacing="0" width="100%">
    <thead>
      <tr>
		    <th></th>
		    <th>Edit</th>
        <th>LEC Ckt</th>
        <th>Internal Ckt</th>
		    <th>Legacy Ckt</th>
        <th>Sys</th>
        <th>Qty</th>
        <th>Charge</th>
		    <th>Vendor</th>
        <th>CLLI</th>
		    <th>Inv Aloc</th>
				<th>Customer Name</th>
				<th>Customer Acct</th>
				<th>Segment</th>
        <th>SPA/UNE</th>
		    <th>Opt</th>
				<th>Dbb Opp</th>
		    <th>Fcast</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <th></th>
		    <th></th>
		    <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
		    <th></th>
		    <th></th>
		    <th></th>
		    <th></th>
		    <th></th>
				<th></th>
				<th></th>
				<th></th>
	      <th></th>
      </tr>
    </tfoot>
  </table>
  </br>
  Select All <input type="checkbox" id="selectAll"/>
  </br></br>
  Project:
  <select name="project">
    <option value=""></option>
	<?php

      require_once('../connection.php');
  
      $resultProject= $mysqli->query("Select * from Projects");

	  while($rowProject= $resultProject->fetch_assoc()) { 
	    echo '<option value="' . $rowProject['PROJECT'] . '::' . $rowProject['SUBPROJECT'] . '">' . $rowProject['SUBPROJECT'] . '</option>'; 
	  } 
	?>
  </select></br>
  <input type="hidden" name="table" value="Mileage">
  <input type="checkbox" name="toForecast">Add to Forecast</br>
  <input type="checkbox" name="flag">Set/Unset as Optimal</br>
  <input type="submit" value="GO" />
</div>
</body>
