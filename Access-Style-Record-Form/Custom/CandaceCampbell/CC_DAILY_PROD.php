<?php 
  require_once('../../../connection.php'); 

echo "<div style=\"display:none;\">Select LEC_CKT,MRC,INTERNAL_CKT,RESEARCHER,RESEARCH_DATE,RESEARCH_STATUS from                Dbb where RESEARCHER = 'CC' and RESEARCH_DATE = '2016-02-02' endQuery</div>";

echo '<table>'; 
echo '<tr>'; 
echo '<th>LEC_CKT</th>';echo '<th>MRC</th>';echo '<th>INTERNAL_CKT</th>';echo '<th>RESEARCHER</th>';echo '<th>RESEARCH_DATE</th>';echo '<th>RESEARCH_STATUS</th>';echo '</tr>'; 

  $resultNew= $mysqli->query("Select LEC_CKT,MRC,INTERNAL_CKT,RESEARCHER,RESEARCH_DATE,RESEARCH_STATUS from                Dbb where RESEARCHER = 'CC' and RESEARCH_DATE = '2016-02-02'");
  while( $row= $resultNew->fetch_assoc()) { 

    echo '<tr>';
    foreach($row as $item) {
      echo '<td>' . $item . '</td>';
    }
    echo '</tr>';
  } 

echo '</table>'; 
?>