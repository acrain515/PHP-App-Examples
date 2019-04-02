<html>
  <head>
  
  <?php
  
    require_once('../connection2.php');
	
	$clli= $_GET['clli'];
	
	
  	  $result2= $dev->query("Select * from Cap_PAE where CLLI='$clli'");
	  $row2= $result2->fetch_assoc();
	  
	  $paeDS3= $row2['DS3'];
	  $paeUnassigned= $row2['UNASSIGNED'];
	  $paeInService= $row2['INSERVICE'];
	  $paePendAdd= $row2['PEND_ADD'];
	  $paePendDisc= $row2['PEND_DISC'];
	  $paeReserved= $row2['RESERVED'];
	  
	  ?>
  
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
          ['Pend Disc', <?php echo $paePendDisc; ?>],
          ['In Service', <?php echo $paeInService; ?>],
          ['Reserved', <?php echo $paeReserved; ?>],
          ['Unassigned', <?php echo $paeUnassigned; ?>],
          ['Pend Add', <?php echo $paePendAdd; ?>]
        ]);

        // Set chart options
        var options = { 'width':400,
                        'height':300,
					    'colors': ['#E1FF00','#F4006A','#11D0F4','#6CFF00','#FF6E00']
					  };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>

  <body>
  <div style="width:200px;height:200px;margin:-50px -20px;">
    <!--Div that will hold the pie chart-->
    <div id="chart_div"></div>
  </div>
  </body>
</html>