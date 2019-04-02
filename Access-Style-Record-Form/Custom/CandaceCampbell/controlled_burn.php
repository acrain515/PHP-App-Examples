<?php 
  require_once('../../../connection.php'); 

echo "<div style=\"display:none;\">Select LEC_CKT,BAN,ACNA,MRC,PROJECT,SUBPROJECT,INTERNAL_CKT,INV_SYS,DISC_USER from  Dbb where SUBPROJECT like '%CONTROL_BURN%' and INV_SYS like '%NV-MSS%' and DISC_USER = 'CC' endQuery</div>";

echo '<table>'; 
echo '<tr>'; 
echo '<th>LEC_CKT</th>';echo '<th>BAN</th>';echo '<th>ACNA</th>';echo '<th>MRC</th>';echo '<th>PROJECT</th>';echo '<th>SUBPROJECT</th>';echo '<th>INTERNAL_CKT</th>';echo '<th>INV_SYS</th>';echo '<th>DISC_USER</th>';echo '</tr>'; 

  $resultNew= $mysqli->query("Select LEC_CKT,BAN,ACNA,MRC,PROJECT,SUBPROJECT,INTERNAL_CKT,INV_SYS,DISC_USER from  Dbb where SUBPROJECT like '%CONTROL_BURN%' and INV_SYS like '%NV-MSS%' and DISC_USER = 'CC'");
  while( $row= $resultNew->fetch_assoc()) { 

    echo '<tr>';
    foreach($row as $item) {
      echo '<td>' . $item . '</td>';
    }
    echo '</tr>';
  } 

echo '</table>'; 
?>