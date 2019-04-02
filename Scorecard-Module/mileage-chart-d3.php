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
         ['Name', 'Finds (w/Savings)',{ role: 'annotation' },{ role: 'style' },'Goal'],
         <?php include('source/mileage-chart-d3-source.php'); ?>
      ]);

    var options = {
      titlePosition : 'none',
			chartArea: { width:'85%' },
			legend: { position: 'top',alignment: 'end', textStyle: {fontSize:10},background: {color:'blue'} },
			hAxis: { textStyle: {fontSize:10},textPosition:'out' },
      seriesType: 'bars',
	    isStacked: true,
      series: {0: { color:'#40C9FB' },1: { type: 'line',color:'red' }}
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }
    </script>
  </head>
  <body>
	  <div style="width:500px;text-align:center;">
		<span style="color:#000;font-weight:bold;font-size:11px;"></span>
    <div id="chart_div" style="width: 500px; height: 300px;border:0;">
		</div>
		</div>
  </body>
</html>
