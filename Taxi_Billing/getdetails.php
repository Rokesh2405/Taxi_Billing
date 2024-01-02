<?php
include ('config/config.inc.php');
if($_REQUEST['gsttype']!=''){
if($_REQUEST['gsttype']=='1'){
	$getgstval = FETCH_all("SELECT * FROM `trip` WHERE `gsttype`=? ORDER BY `id` DESC", 1);
	$billno=$getgstval['bill_no']+1;
}
else
{
$getgstval = FETCH_all("SELECT * FROM `trip` WHERE `gsttype`=? ORDER BY `id` DESC", 2);
	$billno=$getgstval['bill_no']+1;	
}
echo $billno;
exit;
}
if($_REQUEST['tripid']!=''){
$gettripdetails = FETCH_all("SELECT * FROM `package` WHERE `id`=? ORDER BY `id` DESC", $_REQUEST['tripid']);
$percharge=getprofile('per_km_charge','1');
$gst=getgst('gst',$gettripdetails['gst']);
$toll_charge=$gettripdetails['toll_charge'];
$driver_beta=$gettripdetails['driver_beta'];
$res1=$percharge."#".$toll_charge.'#'.$driver_beta.'#'.$gst;
echo $res1;
exit;
}

?>