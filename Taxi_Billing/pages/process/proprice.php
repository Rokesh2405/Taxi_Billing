<?php 
include ('../../config/config.inc.php');

if($_POST['request1'] == 1){
 $search = $_POST['search'];
$customer = pFETCH("SELECT * FROM `stock_product` WHERE objectname like'%".$search."%' AND `id`!=?", '0');
while ($row = $customer->fetch(PDO::FETCH_ASSOC)) 
{
  $response[] = array("value"=>$row['id'],"label"=>$row['objectname']);
 }

 // encoding array to json format
 echo json_encode($response);
 exit;
}

if($_POST['request'] == 1){
 $search = $_POST['search'];
$customer = pFETCH("SELECT * FROM `object` WHERE (objectname like'%".$search."%' OR productcode like'%".$search."%' ) AND `id`!=?", '0');
while ($row = $customer->fetch(PDO::FETCH_ASSOC)) 
{
	$labl=$row['objectname'];
  $response[] = array("value"=>$row['id'],"label"=>$labl);
 }

 // encoding array to json format
 echo json_encode($response);
 exit;
}
if($_REQUEST['hsn']!='') {
  $hsn=$_REQUEST['hsn'];
$Tostkqry = FETCH_all("SELECT sum(`pquantity`) AS `totqty` FROM `purchase_object_detail` WHERE `hsn`=?", $hsn);
$usedqtyqry = FETCH_all("SELECT sum(`qty`) AS `totqty` FROM `sales_order_details` WHERE `hsn`=?", $hsn);
$remqty=$Tostkqry['totqty'] - $usedqtyqry['totqty'];
$returnqtyqry = FETCH_all("SELECT sum(`qty`) AS `totqty` FROM `sales_return_details` WHERE `hsn`=?", $hsn);
$totstk=$remqty+$returnqtyqry['totqty'];


if($remqty>=$_REQUEST['qty']) {
echo "allow|".$remqty;
}
else
{
echo "notallow|".$remqty;
}

exit;
}

if($_REQUEST['stockdata']!='') {
$link22 = FETCH_all("SELECT  * FROM `stock_product` WHERE `id`=? ", $_REQUEST['stockdata']);
echo $link22['price'];
}
if($_REQUEST['data']!='') {
$link22 = FETCH_all("SELECT  * FROM `object` WHERE `id`=? ", $_REQUEST['data']);
$gstvalue=$link22['price']*(getgst('gst',$link22['gst'])/100);
echo $link22['price'].'-'.($_REQUEST['gst']+$gstvalue).'-'.getgst('gst',$link22['gst']).'-'.$link22['hsn'].'-'.$link22['mrp_price'];
}

if($_REQUEST['purchasebillno']!='') {
$link22 = FETCH_all("SELECT  * FROM `purchase` WHERE `bill_number`=? ", $_REQUEST['purchasebillno']);
if($link22['id']!='') {
echo "<span style='color:red;'>Bill No Already Exist</span>";
}
else
{
echo "";	
}

}

if($_REQUEST['billno']!='') {
$link22 = FETCH_all("SELECT  * FROM `online_order` WHERE `bill_number`=? ", $_REQUEST['billno']);
if($link22['id']!='') {
echo "<span style='color:red;'>Bill No Already Exist</span>";
}
else
{
echo "";	
}

}
?>