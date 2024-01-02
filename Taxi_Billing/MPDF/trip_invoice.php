<?php
require_once 'vendor/autoload.php'; 
include ('../config/config.inc.php');

$tripdetails = FETCH_all("SELECT * FROM `trip` WHERE `id`=?", $_REQUEST['id']);

$billno=date('m/Y/',strtotime($tripdetails['date'])).$tripdetails['bill_no'];
 

$message = '<div style="padding-top:30px; padding-left:10px; padding-right:10px;"><table style="width:100%; font-family:"Lato", sans-serif; line-height:18px;" >
                <tr>
                <td align="center"><h2>Sri Madurai Meenakshi<br>
Tours and Travels</h2></td>
                </tr>
                <tr>
                <td align="center" style="font-size:18px;">4B,West Marrat Street, <br>Madurai -625001</td>
                </tr>

                </table>
                <table width="100%">
                <tr>
                <td width="70%" valign="top"><img src="'.$sitename.'images/logo.png" width="250"></td>
                <td width="30%" align="right">
                <table width="100%">
                <tr>
                <td><strong>Mob:+918667459121<strong></td>
                </tr>
                <tr>
                <td><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+918681894167<strong></td>
                </tr>
                </table>
                </td>
                </tr>';
                 if($tripdetails['gsttype']=='1') {
                $message .='<tr>
                <td colspan="2"><br>&nbsp;&nbsp;&nbsp;<strong>GST: </strong>'.getprofile('gstno',1).'</td>
                </tr>';
                }
                $message .='</table>
                <table style="width:100%; border-top:1px dashed #000; font-size:15px;" >
                

                <tr>

                    <td width="40%" align="left" valign="top">
                    <table width="100%" cellpadding="5" cellspacing="0">
                     <tr>
                    <td><strong><h3> Bill No</h3></strong></td>
                    <td> : </td> 
                    <td>'.$billno.'</td>
                    </tr>
                    <tr><td colspan="3">&nbsp; </td></tr>
                    <tr>
                    <td><strong>Customer Name</strong></td>
                    <td> : </td> 
                    <td>'.getcustomer('name',$tripdetails['customer_name']).'</td>
                    </tr>
                      <tr>
                    <td><strong>Customer Number</strong></td>
                    <td> : </td> 
                    <td>'.getcustomer('mobileno',$tripdetails['customer_name']).'</td>
                    </tr>
                    </table>
                    </td>
<td width="30%" align="left" valign=top""><table width="100%" cellpadding="5" cellspacing="0">
 <tr>
                    <td colspan="3" align="center"><strong><h2>INVOICE</h2></strong></td>
                    </tr>
                    <tr><td colspan="3">&nbsp; </td></tr>
                    <tr>
                    <td><strong>From</strong></td>
                    <td> : </td> 
                    <td>'.$tripdetails['fromcity'].'</td>
                    </tr>
                      <tr>
                    <td><strong>To</strong></td>
                    <td> : </td> 
                    <td>'.$tripdetails['tocity'].'</td>
                    </tr>
                    </table>
                    </td>
                    <td width="35%" align="right"><table width="100%" cellpadding="5" cellspacing="0">
                    <tr>
                    <td><strong>Pickup Date</strong></td>
                    <td> : </td> 
                    <td>'.date('d-m-Y',strtotime($tripdetails['pickup_date'])).'</td>
                    </tr>
                      <tr>
                    <td><strong>Pickup Time</strong></td>
                    <td> : </td> 
                    <td>'.date('h:i a',strtotime($tripdetails['pickup_time'])).'</td>
                    </tr>
                    <tr>
                    <td><strong>Drop Date</strong></td>
                    <td> : </td> 
                    <td>'.date('d-m-Y',strtotime($tripdetails['drop_date'])).'</td>
                    </tr>
                      <tr>
                    <td><strong>Drop Time</strong></td>
                    <td> : </td> 
                    <td>'.date('h:i a',strtotime($tripdetails['drop_time'])).'</td>
                    </tr>
                    </table>
                    </td>
                    </tr>
			
             </table> 
             <table width="100%" style="background-color:#d7d8e5;" cellpadding="10">
             <tr>
             <td><strong>Description</strong></td>
             <td  align="right"><strong>Amount</strong></td>
             </tr>
             </table>
               <table width="100%"  cellspacing="0" cellpadding="5">
             <tr>
             <td><strong>Day Rent</strong><br><br>
             Vehicle Rent.<br><br>
            Per Kilometer Charge &nbsp;Rs.'.$tripdetails['per_km_charge'].'x'.$tripdetails['total_km'].'km
             </td>
             <td align="right" valign="bottom"><strong>'.number_format($tripdetails['total_km_charge'],2).'</strong></td>
             </tr>
             </table>
              <table width="100%"  cellspacing="0" cellpadding="5">
             <tr>
             <td>Driver Allowance&nbsp;&nbsp;Rs.'.number_format($tripdetails['driver_allowance'],2).'x1</td>
             <td align="right" valign="bottom"><strong>'.number_format($tripdetails['driver_allowance'],2).'</strong></td>
             </tr>
             </table>';
             if($tripdetails['toll_charge']!='' || $tripdetails['permit_charge']!='' || $tripdetails['waiting_charge']!='') {
              $message .='<table width="100%"  cellspacing="0" cellpadding="5">
               <tr>
               <td colspan="2"><strong>Other Charges</strong></td></tr>
              ';
               if($tripdetails['toll_charge']!='') {
             $message .='<tr>
             <td>
             Toll Gate Charge</td>
             <td align="right" valign="bottom"><strong>'.number_format($tripdetails['toll_charge'],2).'</strong></td>
             </tr>';
} 

 if($tripdetails['permit_charge']!='') {
             $message .='<tr>
             <td>
             Other Permit Charge</td>
             <td align="right" valign="bottom"><strong>'.number_format($tripdetails['permit_charge'],2).'</strong></td>
             </tr>';
} 
 if($tripdetails['waiting_charge']!='') {
             $message .='<tr>
             <td>
            Waiting Charge</td>
             <td align="right" valign="bottom"><strong>'.number_format($tripdetails['waiting_charge'],2).'</strong></td>
             </tr>';
} 
             $message .='</table>';
            }

           
             $message .='<table width="30%"  cellspacing="0" cellpadding="5">
             <tr>
             <td colspan="3"><strong>Travel Details</strong></td>
             </tr>
             <tr>
             <td>Starting KM</td>
             <td> = </td>
             <td  align="right">'.$tripdetails['start_km'].'</td>
             </tr>
             <tr>
             <td>Closing KM</td>
             <td> = </td>
             <td  align="right">'.$tripdetails['end_km'].'</td>
             </tr>
             <tr>
             <td>Total KM</td>
             <td> = </td>
             <td align="right">'.$tripdetails['total_km'].'</td>
             </tr>
            

             </table>
              <table width="100%" style="background-color:#d7d8e5;" cellpadding="15">
             <tr>
             <td><strong>Total Amount</strong></td>
             <td  align="right"><strong>'.number_format($tripdetails['sub_total'],2).'</strong></td>
             </tr>
             </table>
             <br>
             <table width="100%" style="background-color:#d7d8e5;" cellpadding="10">
             <tr>
             <td align="center"><strong>Driver and Vehicle Details</strong></td>
             </tr>
             </table>
             <br>
             <table width="100%">
             <tr>
             <td width="60%">
             <table width="100%" cellspacing="0" cellpadding="5">
             <tr>
             <td><strong>Driver Name</strong></td>
             <td>:</td>
             <td>'.$tripdetails['driver_name'].'</td>
             </tr>
              <tr>
             <td><strong>Driver Number</strong></td>
             <td>:</td>
             <td>'.$tripdetails['driver_mobileno'].'</td>
             </tr>
              <tr>
             <td><strong>Vehicle Type</strong></td>
             <td>:</td>
             <td>'.getmodel('model',$tripdetails['vehicle_model']).'</td>
             </tr>
              <tr>
             <td><strong>Vehicle Number</strong></td>
             <td>:</td>
             <td>'.$tripdetails['vehicleno'].'</td>
             </tr>
             </table></td>';
                if($tripdetails['gsttype']=='1') {
             $message .='<td width="40%" align="right" valign="top"><table width="100%" cellspacing="0" cellpadding="5">
             <tr>
             <td><strong>Sub Total</strong></td>
             <td>:</td>
             <td>'.number_format($tripdetails['sub_total'],2).'</td>
             </tr>';
          
              $gstpercent=$tripdetails['gstpercent']/2;
              $gstpercentval=$tripdetails['gst_amt']/2;
             $message .='<tr>
             <td><strong style="color:blue; font-style:underline;">CGST@'.$gstpercent.'%</strong></td>
             <td>:</td>
             <td>'.$gstpercentval.'</td>
             </tr>
              <tr>
             <td><strong style="color:blue; font-style:underline;">SGST@'.$gstpercent.'%</strong></td>
             <td>:</td>
             <td>'.$gstpercentval.'</td>
             </tr><tr>
             <td><strong>TOTAL AMOUNT</strong></td>
             <td><strong>:</strong></td>
             <td><strong>'.number_format($tripdetails['grand_total'],2).'</strong></td>
             </tr>
             </table></td>';
           }
             $message .='</tr>
             </table>';
             if($tripdetails['gsttype']=='2') {
             $message .='<p style="font-weight:bold; text-align:center;">*Declaration: Composition taxable person not eligible to collect tax on supplies</p>';
             } else {
 $message .='<p style="font-weight:bold; text-align:center;">This is computer generated invoice no signature required.</p>';
             }
             $message .='</div>
             ';

// echo $message;

$mpdf = new \Mpdf\Mpdf();
$mpdf->setHTMLHeader('<img src="'.$sitename.'img/header.jpeg">');
$mpdf->SetDisplayMode('default');
$mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
$filename = "test.txt";

$file = fopen($filename, "w");
fwrite($file, $message);
$mpdf->SetTitle('Trip Invoice');
$mpdf->keep_table_proportions = false;
$mpdf->shrink_this_table_to_fit = 0;
$mpdf->SetAutoPageBreak(true, 10);
$mpdf->WriteHTML(file_get_contents($filename));
$mpdf->setAutoBottomMargin = 'stretch';

$mpdf->setHTMLFooter('<img src="'.$sitename.'img/footer.jpeg">');
$mpdf->Output('yourFileName.pdf', 'I');
?>
