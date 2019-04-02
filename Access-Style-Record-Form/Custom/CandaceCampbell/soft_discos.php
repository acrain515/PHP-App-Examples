<?php 
  require_once('../../../connection.php'); 

echo "<div style=\"display:none;\">Select LEC_CKT,MRC,PROJECT,SUBPROJECT,CUSTOMER_NAME,ADDRESS,INTERNAL_CKT,INV_ACCT,VENDOR_CFA,SOFT_DISC_DATE,RESEARCHER,RESEARCH_DATE,RESEARCH_STATUS from  Dbb  where RESEARCH_STATUS = 'Soft Disc' endQuery</div>";

echo '<table>'; 
echo '<tr>'; 
echo '<th>LEC_CKT</th>';echo '<th>MRC</th>';echo '<th>PROJECT</th>';echo '<th>SUBPROJECT</th>';echo '<th>CUSTOMER_NAME</th>';echo '<th>ADDRESS</th>';echo '<th>INTERNAL_CKT</th>';echo '<th>INV_ACCT</th>';echo '<th>VENDOR_CFA</th>';echo '<th>SOFT_DISC_DATE</th>';echo '<th>RESEARCHER</th>';echo '<th>RESEARCH_DATE</th>';echo '<th>RESEARCH_STATUS</th>';echo '</tr>'; 

  $resultNew= $mysqli->query("Select LEC_CKT,MRC,PROJECT,SUBPROJECT,CUSTOMER_NAME,ADDRESS,INTERNAL_CKT,INV_ACCT,VENDOR_CFA,SOFT_DISC_DATE,RESEARCHER,RESEARCH_DATE,RESEARCH_STATUS from  Dbb  where RESEARCH_STATUS = 'Soft Disc'");
  while( $row= $resultNew->fetch_assoc()) { 

    echo '<tr>';
    foreach($row as $item) {
      echo '<td>' . $item . '</td>';
    }
    echo '</tr>';
  } 

echo '</table>'; 
?>