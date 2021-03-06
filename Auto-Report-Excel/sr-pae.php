<?php

  echo 'SR PAE';

  require_once('../dwdev.php');
  require_once('../local.php');
  
  $resultX= $local->query("Truncate table Service_Requests_PAE");

  $result= oci_parse($oracle,"Select q1.DOCUMENT_NUMBER,ORDER_NUMBER,COMP_DATE,TYPE,PON,PROJECT,ACT_TYPE,SUP,OWNER
  from (
  Select distinct DOCUMENT_NUMBER
  from (
  Select b.PARENT_WORK_QUEUE_ID,a.WORK_QUEUE_ID,
  a.TASK_NUMBER,a.DOCUMENT_NUMBER,a.TASK_TYPE,a.TASK_STATUS,
  TO_CHAR(a.SCHEDULED_COMPLETION_DATE,'MM/DD/YYYY') as SCHED_COMP_DATE,
  TO_CHAR(a.ESTIMATED_COMPLETION_DATE,'MM/DD/YYYY') as EST_COMP_DATE,
  TO_CHAR(a.REVISED_COMPLETION_DATE,'MM/DD/YYYY') as REV_COMP_DATE,
  TO_CHAR(a.ACTUAL_COMPLETION_DATE,'MM/DD/YYYY') as COMP_DATE,
  TO_CHAR(a.ACTUAL_RELEASE_DATE,'MM/DD/YYYY') as RELEASE_DATE,
  a.REQUIRED_IND,a.REQ_PLAN_ID,a.AUTO_COMP_IND,a.SEQUENCE,a.REJECT_STATUS
  from SIM.ASAP_TASK@oltp a
  left join SIM.ASAP_WORK_QUEUE@oltp b
  on a.WORK_QUEUE_ID=b.WORK_QUEUE_ID
  left join SIM.ASAP_SERV_REQ@oltp c
  on a.DOCUMENT_NUMBER=c.DOCUMENT_NUMBER
  where a.LAST_MODIFIED_DATE>SYSDATE-365
  and a.SCHEDULED_COMPLETION_DATE>SYSDATE-365
  and (b.PARENT_WORK_QUEUE_ID in ('NETPROV','NETPRV1','NETSVG','SVGSPRV','SVGSDES') or b.WORK_QUEUE_ID in ('NETPROV','NETPRV1','NETSVG','SVGSPRV','SVGSDES'))
  and (SUPPLEMENT_TYPE is null or SUPPLEMENT_TYPE!='1')
  )) q1
  inner join (
  Select DOCUMENT_NUMBER,ORDER_NUMBER,TO_CHAR(ORDER_COMPL_DT,'MM/DD/YYYY') as COMP_DATE,
  TYPE_OF_SR as TYPE,PON,PROJECT_IDENTIFICATION as PROJECT,ACTIVITY_IND as ACT_TYPE,SUPPLEMENT_TYPE as SUP,RESPONSIBLE_PARTY as OWNER
  from SIM.ASAP_SERV_REQ@oltp
  ) q2
  on q1.DOCUMENT_NUMBER=q2.DOCUMENT_NUMBER");
  oci_execute($result);

  while ($row = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS)) {
  
    $doc= $row['DOCUMENT_NUMBER'];
	$orderNumber= $row['ORDER_NUMBER'];
	$compDate= $row['COMP_DATE'];
	$type= $row['TYPE'];
	$pon= $row['PON'];
	$project= $row['PROJECT'];
	$act= $row['ACT_TYPE'];
	$sup= $row['SUP'];
	$owner= $row['OWNER'];
	
	echo 'DOC: ' . $doc . '</br>';
	echo 'Order: ' . $orderNumber . '</br>';
	echo $compDate . '</br>';
	echo $type . '</br>';
	echo $pon . '</br>';
	echo $project . '</br>';
	echo $act . '</br>';
	echo $sup . '</br>';
	echo 'Owner: ' . $owner . '</br>';
	echo '</br>';
	
	$result2= $local->query("Insert into Service_Requests_PAE (DOCUMENT_NUMBER,ORDER_NUMBER,COMP_DATE,ACT_TYPE,SUP,OWNER)
	values ('$doc','$orderNumber','$compDate','$act','$sup','$owner')");
	
  }
  
?>

	