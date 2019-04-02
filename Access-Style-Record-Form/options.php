<?php  

  $discStatusOptions= array("Acknowledged","Confirmed","Complete");
	$ynOptions= array("y","n");
	$researchStatusOptions= array("Bill Correction","Billing Review","CDE Review","Complete","Correction Needed",
	"Disc Under Protest","Disconnect","Duplicate",
	"Further Review","Groom Opportunity","Internal Order Delayed","LEC Delayed","Negative Margin","Network",
	"No Action","Non-billing","Pending Disco","Pending FOC",
	"Pending Review","Provisioning Review",
	"Report Error","Soft Disc","Soft Disc Complete","Traffic Check");

	$billSysOptions= array("RC7","RC8","Aptis","CAMS","CABS");
	$statusOptions= array("In Service","Disconnected","Pending Disc","Pending Act");
	$invSysOptions= array("PAE","NVX","WIN","TSG","CAV");
	$failureOptions= array("Accrual Billing only","ASR/LSR Sent but no FOC","Biller Only Disco","Billing Conversion",
	"Cancel","CFA Incorrect","Circuit does not belong to customer","Circuit Reused","Disco LSR/ASR order error",
	"Disco Non-Pay","Feature - No Disco Sent","Groom Error","ICare order",
	"LEC Error","Migration Error","Move Order","No Disco Order","No disco sent","No Disco Task",
	"Order Entry Error","Other","Port Out","Records Error","Task Unrequired","Unworked Task","XREF not correct");
?>