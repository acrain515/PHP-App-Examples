<?php

  echo 'Tasks NVX';

  require_once('../dwdev.php');
  require_once('../local.php');
  
  $resultX= $local->query("Truncate table Tasks_NVX");

  $result= oci_parse($oracle,"Select b.PARENT_WORK_QUEUE_ID,a.WORK_QUEUE_ID,
  a.DOCUMENT_NUMBER,a.TASK_NUMBER,a.TASK_TYPE,a.TASK_STATUS,
  --TO_CHAR(a.ASSIGNED_FROM_DATE,'MM/DD/YYYY') as ASSIGNED_DATE,
  TO_CHAR(a.SCHEDULED_COMPLETION_DATE,'MM/DD/YYYY') as SCHED_COMP_DATE,
  TO_CHAR(a.ESTIMATED_COMPLETION_DATE,'MM/DD/YYYY') as EST_COMP_DATE,
  TO_CHAR(a.REVISED_COMPLETION_DATE,'MM/DD/YYYY') as REV_COMP_DATE,
  TO_CHAR(a.ACTUAL_COMPLETION_DATE,'MM/DD/YYYY') as COMP_DATE,
  TO_CHAR(a.ACTUAL_RELEASE_DATE,'MM/DD/YYYY') as RELEASE_DATE,
  a.REQUIRED_IND,a.REQ_PLAN_ID,a.AUTO_COMP_IND,a.SEQUENCE,a.REJECT_STATUS
  --e.PLAN_NAME as PROV_PLAN
  from ASAP.TASK@pmeta a
  left join ASAP.WORK_QUEUE@pmeta b
  on a.WORK_QUEUE_ID=b.WORK_QUEUE_ID
  left join ASAP.SERV_REQ@pmeta c
  on a.DOCUMENT_NUMBER=c.DOCUMENT_NUMBER
  where a.LAST_MODIFIED_DATE>SYSDATE-365
  and a.SCHEDULED_COMPLETION_DATE>SYSDATE-365
  and (b.PARENT_WORK_QUEUE_ID in ('NPROV','TRUNKING','SVGSDES','SVGSPRV') or b.WORK_QUEUE_ID in ('NPROV','TRUNKING','SVGSDES','SVGSPRV'))
  and (SUPPLEMENT_TYPE is null or SUPPLEMENT_TYPE!='1')");
  oci_execute($result);

  while ($row = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS)) {
  
    $parent= $row['PARENT_WORK_QUEUE_ID'];
	$queue= $row['WORK_QUEUE_ID'];
	$doc= $row['DOCUMENT_NUMBER'];
	$taskNumber= $row['TASK_NUMBER'];
	$task= $row['TASK_TYPE'];
	$status= $row['TASK_STATUS'];
	$schedCompDate= $row['SCHED_COMP_DATE'];
	$estCompDate= $row['EST_COMP_DATE'];
	$revCompDate= $row['REV_COMP_DATE'];
	$compDate= $row['COMP_DATE'];
	$releaseDate= $row['RELEASE_DATE'];
	$required= $row['REQUIRED_IND'];
	$reqPlan= $row['REQ_PLAN_ID'];
	$auto= $row['AUTO_COMP_IND'];
	$sequence= $row['SEQUENCE'];
	$reject= $row['REJECT_STATUS'];
	
    echo $parent . '</br>';
	echo $queue . '</br>';
	
	$result2= $local->query("Insert into Tasks_NVX (PARENT_QUEUE,QUEUE,DOCUMENT_NUMBER,TASK_NUMBER,TASK,STATUS,SCHED_COMP_DATE,
	EST_COMP_DATE,REV_COMP_DATE,COMP_DATE,RELEASE_DATE,REQUIRED_IND,REQ_PLAN_ID,AUTO_COMP_IND,SEQUENCE,REJECT_STATUS)
	values ('$parent','$queue','$doc','$taskNumber','$task','$status','$schedCompDate','$estCompDate','$revCompDate','$compDate',
	'$releaseDate','$required','$reqPlan','$auto','$sequence','$reject')"); 
	
  }
  
?>



