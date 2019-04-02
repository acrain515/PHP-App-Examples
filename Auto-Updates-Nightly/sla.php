<?php
	  if($task=='RDLR') { $sla= "5"; }
	  
	  if(($activityInd=='D')&&($rateCode=='DS3')) {
	    if(($task=='RCVFOC')||($task=='RCVFOC2')) { $sla= "5"; }
		  else { $sla= "1"; }
	  }
	  
	  else if(($activityInd=='N')&&($rateCode=='DS3')) {
	    if(($task=='LOA/CFA')||($task=='RCVFOC')) {
		  $sla= "5";
		}
		else if(($task=='RDLR')||($task=='RCVDLR')) { $sla= "15"; }
		else if (($task=='SX-CONN')||($task=='INST FAC')) { $sla="3"; }
		else if($task=='RMTXCON') { $sla="2"; }
		else { $sla= "1"; }
	  }
	  
	  else {
	    if(($task=='DD')||($task=='SNDASR')||($task=='SEND ASR')||($task=='SCHDTENT')) { $sla= "2"; }
		else if($task=='RCVFOC') { $sla="10"; }
		else if(($task=='NEGOTIATE')||($task=="NEGOTIAT")) { $sla="15"; }
		else { $sla= "1"; }
	  }
	  
	  //echo 'SLA: ' . $sla . '</br>';
	  
?>




