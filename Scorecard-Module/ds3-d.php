<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">

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
         ['Month', 'Save ($000s)',{ role: 'annotation' },{ role: 'style' }],
         <?php include('source/ds3-d-source.php'); ?>
      ]);

    var options = {
      titlePosition : 'none',
			chartArea: { width: '80%' },
			legend: { position: 'top' },
      seriesType: 'bars',
      series: {0: { color:'#54D9FC' }}
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }
    </script>
  </head>
  <body>
	  <div style="width:460px;text-align:center;">
    <div id="chart_div" style="width: 460px; height: 280px;border:1px solid #ccc;padding:0;">
		</div>
		</div>
  </body>
</html>
