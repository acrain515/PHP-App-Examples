<!DOCTYPE html>
<head>
<title>Miranda Intervals NVX</title>
<style>
body { font-family: Arial; font-size: 12px; }
table { border-collapse: collapse; }
th { border: 1px solid #333;padding: 4px; background: #222;color: #fff; }
th.purple { background: purple; }
td { border: 1px solid #333; text-align: center;padding:2px; }
</style>
</head>
<body>

<?php

  require_once('../local.php');

  $system= "NVX";
  echo '<table>';
  echo '<tr>';
  echo '<th>Order</th><th>Type</th><th>Task</th><th>Status</th><th>Queue</th><th>Parent Queue</th><th>Comp Date</th><th>Release</th><th>Interval</th><th>Aging</th><th>Sched Comp Date</th>
  <th>Rev Comp</th><th>Seq</th><th>Reject</th>';
  echo '</tr>';

  $lines= array();
  $installs= array();
  $disconnects= array();
  $installTasks= array();
  $disconnectTasks= array();

  $result= $local->query("Select * from Tasks_$system where (PARENT_QUEUE in ('NPROV','TRUNKING') or QUEUE in ('NPROV','TRUNKING')) and RELEASE_DATE!=''");
  while ($row= $result->fetch_assoc()) {

    $result2= $local->query("Select * from Service_Requests_$system where DOCUMENT_NUMBER='$row[DOCUMENT_NUMBER]'");
    if(($result2)&&(mysqli_num_rows($result2)>0)) {
      $row2= $result2->fetch_assoc();

      if($row2['ACT_TYPE']=='D') { $orderType= "Disconnect"; } else { $orderType= "Install"; }


      if($row['COMP_DATE']!='') { 
        $splitComp= explode("/",$row['COMP_DATE']);
        $splitRel= explode("/",$row['RELEASE_DATE']);
        $interval= (($splitComp[2]-$splitRel[2])*365)+(($splitComp[0]-$splitRel[0])*30)+($splitComp[1]-$splitRel[1]); 
      } 
      else { $interval=""; }

      if($row['COMP_DATE']=='') { 
        $splitRel= explode("/",$row['RELEASE_DATE']);
        $aging= ((date("Y")-$splitRel[2])*365)+((date("m")-$splitRel[0])*30)+(date("d")-$splitRel[1]); 
      } 
      else { $aging=""; } 

    array_push($lines,array($row2['ORDER_NUMBER'],$orderType,$row['TASK'],$row['STATUS'],$row['QUEUE'],$row['PARENT_QUEUE'],$row['COMP_DATE'],$row['RELEASE_DATE'],$interval,$aging,
      $row['SCHED_COMP_DATE'],$row['REV_COMP_DATE'],$row['SEQUENCE'],$row['REJECT_STATUS']));

      if(($orderType=='Install')&&($interval!='')) { array_push($installTasks,$row['TASK']) ; array_push($installs,array($row['TASK'],$interval)); }
      if(($orderType=='Disconnect')&&($interval!='')) { array_push($disconnectTasks,$row['TASK']); array_push($disconnects,array($row['TASK'],$interval)); }

      }
    }

    foreach($lines as $line) {
     echo "<tr>\n";
    foreach($line as $item) {
      echo "<td>" . ($item!==null ? htmlentities($item,ENT_QUOTES) : "&nbps;") . "</td>\n";
    }
    echo "</tr>\n";
  }

  echo '</table>';

  $installUnique= array_unique($installTasks);
  $disconnectUnique= array_unique($disconnectTasks);

  echo '</br></br>';
 
  echo '<h3>Installs</h3>';
  echo '<table>';
  echo '<tr><th>Task</th><th>Count</th><th>Avg Interval</th></tr>';
  foreach($installUnique as $task) {

    echo '<tr>';
    echo '<td>' . $task . '</td>';

    $count=0;
    $sum=0;
    foreach($installs as $install) {
      if($install[0]==$task) { $count++; $sum+= $install[1]; }
    }

    echo '<td>' . $count . '</td>';
    echo '<td>' . round($sum/$count) . '</td>';

    echo '</tr>';
  }

  echo '</table>';

  echo '<h3>Disconnects</h3>';
  echo '<table>';
  echo '<tr><th>Task</th><th>Count</th><th>Avg Interval</th></tr>';
  foreach($disconnectUnique as $task) {

    echo '<tr>';
    echo '<td>' . $task . '</td>';

    $count=0;
    $sum=0;
    foreach($disconnects as $disconnect) {
      if($disconnect[0]==$task) { $count++; $sum+= $disconnect[1]; }
    }

    echo '<td>' . $count . '</td>';
    echo '<td>' . round($sum/$count) . '</td>';

    echo '</tr>';
  }

  echo '</table>';


?> 
    