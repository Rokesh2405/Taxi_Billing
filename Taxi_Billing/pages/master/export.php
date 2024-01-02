<?php include ('../../config/config.inc.php');
//Sales Report
if($_REQUEST['type']=='trip') {
$filename = "trip_report.csv";
$fp = fopen('php://output', 'w');
if($_REQUEST['gsttype']=='1') {
$header=array("Date","Invoice Number","Total Amount","GST Amount");
}
else
{
$header=array("Date","Invoice Number","Total Amount");
}
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);
fputcsv($fp, $header);


$s='';
if($_REQUEST['fromdate']!='' && $_REQUEST['todate']!='') {
$s1[]="(`date`>='".date('d-m-Y',strtotime($_REQUEST['fromdate']))."'  AND `date`<='".date('d-m-Y',strtotime($_REQUEST['todate']))."')";

}
if($_REQUEST['gsttype']!='')
{
$s1[]="`gsttype`='".$_REQUEST['gsttype']."'";
}

$m=1;
if(count($s1)>0) {
$s=implode('  AND  ',$s1);
}
if($s!='') { 
$message1 = $db->prepare("SELECT * FROM `trip` WHERE `id`!='0' AND $s");
}
else{
$message1 = $db->prepare("SELECT * FROM `trip` WHERE `id`!='0'");	
}

$message1->execute();
while($message = $message1->fetch(PDO::FETCH_ASSOC)) 
{


													 
    if($message['date']!='')
     {
       $date=date('d-m-Y h:i:s',strtotime($message['date']));  
     }
     else
     {
       $date='-';  
     }   
     
     if($message['bill_no']!='')
     {
       $bill_no=$message['bill_no'];  
     }
     else
     {
       $bill_no='-';  
     }   
     
      if($message['grand_total']!='')
     {
       $grand_total=$message['grand_total'];  
     }
     else
     {
       $grand_total='-';  
     }  
      if($message['gst_amt']!='')
     {
       $gst_amt=$message['gst_amt'];  
     }
     else
     {
       $gst_amt='-';  
     }  

if($_REQUEST['gsttype']=='1') {

      $res=array($date,$bill_no,$grand_total,$gst_amt);  
    }
    else
    {
      $res=array($date,$bill_no,$grand_total); 
    }

     fputcsv($fp, $res);
    }
 
exit;	
}

//Expense Report
if($_REQUEST['type']=='expense') {
$filename = "expense_report.csv";
$fp = fopen('php://output', 'w');

$header=array("Date","Expense Type","Rate","Bill No","Comment");

header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);
fputcsv($fp, $header);

if($_REQUEST['fromdate']!='' && $_REQUEST['todate']!='') {
$s1[]="(`date`>='".date('Y-m-d',strtotime($_REQUEST['fromdate']))."'  AND `date`<='".date('Y-m-d',strtotime($_REQUEST['todate']))."')";
}
if($_REQUEST['expense_type']!='')
{
$s1[]="`type`='".$_REQUEST['expense_type']."'";
}


if(count($s1)>0) {
$s=implode('  AND  ',$s1);
}
if($s!='') { 
$message1 = $db->prepare("SELECT * FROM `daily_expense` WHERE `id`!='0' AND $s");
}
else{
$message1 = $db->prepare("SELECT * FROM `daily_expense` WHERE `id`!='0'");	
}

$message1->execute();
while($message = $message1->fetch(PDO::FETCH_ASSOC)) 
{
    if($message['date']!='')
     {
       $date=date("d-m-Y",strtotime($message['date']));  
     }
     else
     {
       $date='-';  
     }   
 
if($message['type']!='') {
$exptype=getexpense('type',$message['type']);
}
else
{
$exptype='-';
}

	 
if($message['amount']!='') {
$amount=$message['amount'];
}
else
{
$amount='-';	
}
if($message['billno']!='') {
$billno=$message['billno'];
}
else
{
$billno='-';	
}
if($message['comment']!='') {
$comment=$message['comment'];
}
else
{
$comment='-';	
}
      $res=array($date,$exptype,$amount,$billno,$comment);  
     fputcsv($fp, $res);
}
exit;	
}

//Purchase Report
if($_REQUEST['type']=='purchase') {
$filename = "purchase_report.csv";
$fp = fopen('php://output', 'w');

$header=array("Date","Bill No","Supplier Name","Amount");

header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);
fputcsv($fp, $header);


$s='';
if($_REQUEST['fromdate']!='' && $_REQUEST['todate']!='') {
$s1[]="(`date`>='".date('Y-m-d',strtotime($_REQUEST['fromdate']))."'  AND `date`<='".date('Y-m-d',strtotime($_REQUEST['todate']))."')";
}
if($_REQUEST['supplier']!='')
{
$s1[]="`supplierid`='".$_REQUEST['supplier']."'";
}
if($_REQUEST['billno']!='')
{
$s1[]="`bill_number`='".$_REQUEST['billno']."'";
}

$m=1;
if(count($s1)>0) {
$s=implode('  AND  ',$s1);
}
if($s!='') { 
$message1 = $db->prepare("SELECT * FROM `purchase` WHERE `id`!='0' AND $s");
}
else{
$message1 = $db->prepare("SELECT * FROM `purchase` WHERE `id`!='0'");	
}

$message1->execute();
while($message = $message1->fetch(PDO::FETCH_ASSOC)) 
{
    if($message['date']!='')
     {
       $date=date("d-m-Y",strtotime($message['date']));  
     }
     else
     {
       $date='-';  
     }   
     
 if($message['bill_number']!='') {
$billno=$message['bill_number'];
}
else
{
$billno='-';	
}
if($message['supplierid']!='') {
$supplier=getsupplier('suppliername',$message['supplierid']);
}
else
{
$supplier='-';	
}
if($message['tot_amt']!='') {
$totamt='Rs. '.number_format($message['tot_amt'],2);
}
else
{
$totamt='-';	
}



      $res=array($date,$billno,$supplier,$totamt);  
     fputcsv($fp, $res);
}
exit;	
}


//Stock Report
if($_REQUEST['type']=='stock') {
$filename = "stock_report.csv";
$fp = fopen('php://output', 'w');

$header=array("Product","Total Quantity","Used Quantity","Available Quantity","Used Date");

header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);
fputcsv($fp, $header);

if($_REQUEST['fromdate']!='' && $_REQUEST['todate']!='') {
$s1[]="(`date`>='".date('Y-m-d',strtotime($_REQUEST['fromdate']))."'  AND `date`<='".date('Y-m-d',strtotime($_REQUEST['todate']))."')";
}
if($_REQUEST['product']!='')
{
$s1[]="`product`='".$_REQUEST['product']."'";
}


if(count($s1)>0) {
$s=implode('  AND  ',$s1);
}
if($s!='') { 
$message1 = $db->prepare("SELECT * FROM `stock_usage` WHERE `id`!='0' AND $s");
}
else{
$message1 = $db->prepare("SELECT * FROM `stock_usage` WHERE `id`!='0'");	
}

$message1->execute();
while($message = $message1->fetch(PDO::FETCH_ASSOC)) 
{
    if($message['date']!='')
     {
       $date=date("d-m-Y",strtotime($message['date']));  
     }
     else
     {
       $date='-';  
     }   
 
if($message['product']!='') {
$prodname=getobject1('objectname',$message['product']);
}
else
{
$prodname='-';
}

	 
	 
$Tostkqry = FETCH_all("SELECT sum(`pquantity`) AS `totqty` FROM `purchase_object_detail` WHERE `productid`=?", $message['product']);
$usedqtyqry = FETCH_all("SELECT sum(`quantity`) AS `totqty` FROM `stock_usage` WHERE `product`=?", $message['product']);
$remqty=$Tostkqry['totqty'] - $usedqtyqry['totqty'];
$totqgty=$Tostkqry['totqty'];
$usedqty=$usedqtyqry['totqty'];

$res=array($prodname,$totqgty,$remqty,$usedqty,$date);  
     fputcsv($fp, $res);
}
exit;	
}

//Payment Report
if($_REQUEST['type']=='payment') {
$filename = "payment_report.csv";
$fp = fopen('php://output', 'w');

$header=array("Date","Ref. Bill No","Supplier Name","Total Amount","Paid Amount","Balance Amount");

header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);
fputcsv($fp, $header);

$s='';
if($_REQUEST['fromdate']!='' && $_REQUEST['todate']!='') {
$s1[]="(date(`date`)>='".date('Y-m-d',strtotime($_REQUEST['fromdate']))."'  AND date(`date`)<='".date('Y-m-d',strtotime($_REQUEST['todate']))."')";
}
if($_REQUEST['billno']!='')
{
$s1[]="`billno`='".$_REQUEST['billno']."'";
}
if($_REQUEST['supplier_name']!='')
{
$s1[]="`supplier_id`='".$_REQUEST['supplier_name']."'";
}


if(count($s1)>0) {
$s=implode('  AND  ',$s1);
}
if($s!='') { 
$message1 = $db->prepare("SELECT * FROM `credit_history` WHERE `id`!='0' AND $s");
}
else{
$message1 = $db->prepare("SELECT * FROM `credit_history` WHERE `id`!='0'");	
}

$message1->execute();
while($message = $message1->fetch(PDO::FETCH_ASSOC)) 
{
    if($message['date']!='')
     {
       $date=date("d-m-Y",strtotime($message['date']));  
     }
     else
     {
       $date='-';  
     }   
 
if($message['billno']!='') {
$billno=$message['billno'];
}
else
{
$billno='-';
}

	 
if($message['supplier_id']!='') {
$supplier=getsupplier('suppliername',$message['supplier_id']);
}
else
{
$supplier='-';	
}


if($message['purchase_amt']!='') {
$purchase_amt='Rs. '.$message['purchase_amt'];
}
else
{
$purchase_amt='-';	
}

if($message['advance_amt']!='' && $message['inputamt']!='') {
	$blamt=$message['advance_amt']-$message['inputamt'];
$advance_amt= 'Rs. '.$blamt;
}
else
{
$advance_amt='-';	
}


if($message['inputamt']!='') {
$paid_amt='Rs. '.$message['inputamt'];
}
else
{
$paid_amt='-';	
}

if($message['balance_amt']!='') {
$balance_amt='Rs. '.$message['balance_amt'];
}
else
{
$balance_amt='-';	
}

$res=array($date,$billno,$supplier,$purchase_amt,$paid_amt,$balance_amt);  
     fputcsv($fp, $res);
}
exit;	
}

?>