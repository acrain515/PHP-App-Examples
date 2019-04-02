<html>
  <head>
	<style>
	body { font-family: Arial; }
	</style>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <?php 
		if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE')!==false) {
		  echo '<script type="javascript">';
		}
		
		else {
		  echo '<script type="text/javascript">';
		}
		?>
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
         ['Month', 'Adds ($000s)',{ role: 'annotation' },{ role: 'style' }, 'Goal'],
         <?php include('source/ds3-finds-monthly-savings-source.php'); ?>
      ]);

    var options = {
      titlePosition : 'none',
			chartArea: { width: '80%' },
			legend: { position: 'bottom' },
      seriesType: 'bars',
      series: {0: { color:'#54D9FC' }, 1: {type: 'line',color: 'red'}}
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }
    </script>
  </head>
  <body>
	  <div style="width:320px;text-align:center;">
    <div id="chart_div" style="width: 320px; height: 200px;border:1px solid #ccc;">
		</div>
		</div>
  </body>
</html>
