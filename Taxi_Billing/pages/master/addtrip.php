<?php

if (isset($_REQUEST['id'])) {
    $thispageeditid = 10;
} else {
    $thispageaddid = 10;
}
$menu = "18,18,118";
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');
if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['id'];
    $ip = $_SERVER['REMOTE_ADDR'];
   

    $msg = addtrip($billtype,$fromcity,$tocity,$driver_name,$driver_mobileno,$vehicleno,$permit_charge,$waiting_charge,$gstpercent,$customer_name,$order_method,$date,$gsttype,$bill_no,$driver,$trip_package,$trip_type,$vehicle_model,$total_km,$total_km_charge,$toll_charge,$driver_allowance,$total_charge,$per_km_charge,$pickup_date,$drop_date,$pickup_time,$drop_time,$start_km,$end_km,$sub_total,$gst_amt,$gstpercentval,$grand_total,$getid);
}
if(isset($_REQUEST['createaccount'])) {
global $db;
@extract($_REQUEST);
    
$status=1;
$resa = $db->prepare("INSERT INTO `customer` (`cusid`,`name`,`mobileno`,`address`,`status`) VALUES (?,?,?,?,?)");
$resa->execute(array($cusid,$name,$mobileno,$address,$status));
 $insid = $db->lastInsertId();    
 if($_REQUEST['id']=='') {
$url="addtrip.htm?pid=".$insid; 
}
else
{
$url=$_REQUEST['id']/"edittrip.htm?pid=".$insid;  
}
 echo "<script>window.location.assign('".$url."')</script>";  
}

?>


        <link rel="stylesheet" href="<?php echo $sitename; ?>dist/wickedpicker.min.css">
    
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Trip Invoice
            <small><?php
                if ($_REQUEST['cid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Trip Invoice</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i> Master(s)</a></li>            
            <li><a href="<?php echo $sitename; ?>master/trip.htm"><i class="fa fa-circle-o"></i> Trip Invoice</a></li>
            <li class="active"><?php
                if ($_REQUEST['id'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Trip Invoice</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department"  method="post" enctype="multipart/form-data" autocomplete="off" onsubmit="return confirm('Do you really want to submit the form?');">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['id'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> Trip</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;">
                       <span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                     <div class="row">
                        <div class="col-md-4" >
                        <table width="100%">
                        <tr>
                        <td colspan="2"><label>Customer name</label></td>
                        </tr>
                        <tr>
                        <td  style="margin-top: 5px;">
                    
                             <select name="customer_name" <?php if($_REQUEST['type']=='view') { ?> readonly="readonly" <?php } ?> id="supplierid" class="form-control select2"  style="font-weight: bold; font-size:13px;">
                             <option value="">Select</option>
                             <?php
$customer = pFETCH("SELECT * FROM `customer` WHERE `status`=?", '1');
while ($customerfetch = $customer->fetch(PDO::FETCH_ASSOC)) 
{
?>
 <option value="<?php echo $customerfetch['id']; ?>" <?php if($customerfetch['id']==gettrip('customer_name',$_REQUEST['id'])  || $customerfetch['id']==$_REQUEST['pid']) { ?> selected="selected" <?php } ?>><?php echo $customerfetch['name'].'-'.$customerfetch['mobileno']; ?></option>
<?php } ?>                          
                             </select>
                             
                   
                        </td>
                        <td style="vertical-align:bottom;">
                        <?php if($_REQUEST['type']!='view') { ?>
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal" style="height:36px;"><i class="fa fa-plus" aria-hidden="true" alt="Add Customer" title="Add Customer"></i></button>
                        <?php } ?>
                        </td>
                        </tr>
                        </table>
                
                        </div>
                        <div class="col-md-2" style="margin-left:29px;">

                            <label>Order Method <span style="color:#FF0000;">*</span></label>   
<select name="order_method" class="form-control" required="required" style="margin-top: 2px;width:fit-content;" <?php if($_REQUEST['type']=='view') { ?> readonly="readonly" <?php } ?>>
                        <option value="">Select</option>
                         <?php
$ordermethod = pFETCH("SELECT * FROM `ordertype` WHERE `status`=?", '1');
while ($ordermethodfetch = $ordermethod->fetch(PDO::FETCH_ASSOC)) 
{
?>
 <option value="<?php echo $ordermethodfetch['id']; ?>" <?php if($ordermethodfetch['id']==gettrip('order_method',$_REQUEST['id'])) { ?> selected="selected" <?php } ?>><?php echo $ordermethodfetch['ordertype']; ?></option>
<?php } ?>                          

                        </select>                           
                            </div>
                     

                        <div class="col-md-2">
                            <label>Date<span style="color:#FF0000;">*</span></label>
                            <div class="input-group date" style="margin-top: 2px;">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input <?php if($_REQUEST['type']=='view') { ?> readonly="readonly" <?php } ?> type="date" class="form-control" name="date" id="date" required="required" value="<?php if(gettrip('date',$_REQUEST['id'])!='') { echo gettrip('date',$_REQUEST['id']); } else { echo date('Y-m-d'); } ?>">
                            </div>  
                        </div>
                        
                        

<div class="col-md-2">

                            <label>GST Type<span style="color:#FF0000;">*</span></label>   
<select name="gsttype" id="gsttype" class="form-control" required="required" style="margin-top: 2px;width:fit-content;" onchange="getbillno(this.value);">
    <option value="">Select</option>
                        <option value="1"  <?php if(1==gettrip('gsttype',$_REQUEST['id'])) { ?> selected="selected" <?php } ?>>With GST</option>
                        <option value="2" <?php if(2==gettrip('gsttype',$_REQUEST['id'])) { ?> selected="selected" <?php } ?>>Without GST</option>
                        </select>                           
                            </div>
                           

                        </div>
                   

                     <div class="clearfix"><br /></div>
                     <div class="row">


                         <div class="col-md-2">



    <table width="100%">
                        <tr>
                        <td colspan="2"><label>Bill Number<span style="color:#FF0000;">*</span></label>
                    
                       &nbsp;&nbsp;&nbsp;<label>Manual Bill</label>&nbsp;<input type="checkbox" name="billtype" id="chkRead" value="1" <?php if(gettrip('billtype',$_REQUEST['id'])=='1') { ?> checked="checked" <?php } ?>> 
                                <div style="display:block;" id="bilresult11"></div>
                    
                    <?php //} ?>
                      
                                </td>
                        </tr>
                        <tr>
                        <td colspan="2"><input type="text" class="form-control"  name="bill_no" id="bill_no" style="width:fit-content;" <?php if(gettrip('billtype',$_REQUEST['id'])!='1') { ?> readonly<?php } ?> value="<?php echo gettrip('bill_no',$_REQUEST['id']); ?>"></td>
                        
                        
                        </tr>
                        </table>
   
                        </div>
                    <div class="col-md-2" style="margin-left:15px;">

                            <label>Pickup Date<span style="color:#FF0000;">*</span></label> 
                            <input type="date" name="pickup_date" class="form-control" required value="<?php if(gettrip('date',$_REQUEST['id'])!='') { echo gettrip('pickup_date',$_REQUEST['id']); } else { echo date('d-m-Y'); } ?>">
                        </div>
                         <div class="col-md-2" style="margin-left:15px;">
                            <label>Pickup Time<span style="color:#FF0000;">*</span></label> 
                            <input type="time" name="pickup_time" class="form-control" required value="<?php if(gettrip('pickup_time',$_REQUEST['id'])!='') { echo gettrip('pickup_time',$_REQUEST['id']); } else { echo date('H:i'); } ?>" >
                        </div>
                         <div class="col-md-2">

                            <label>Drop Date<span style="color:#FF0000;">*</span></label> 
                            <input type="date" value="<?php if(gettrip('date',$_REQUEST['id'])!='') { echo gettrip('drop_date',$_REQUEST['id']); } else { echo date('d-m-Y'); } ?>" name="drop_date" class="form-control" required>
                        </div>
                         <div class="col-md-2" >

                            <label>Drop Time<span style="color:#FF0000;">*</span></label> 
                            <input type="time" value="<?php if(gettrip('drop_time',$_REQUEST['id'])!='') { echo gettrip('drop_time',$_REQUEST['id']); } else { echo date('H:i'); } ?>" name="drop_time" class="form-control" required>
                        </div>
                    </div>
                        <div class="clearfix"><br /></div>
                    <div class="panel panel-info">
  <div class="panel-heading">Trip Details</div>
  <div class="panel-body">
<!-- <div class="row">
     <div class="col-md-4">
         <label>Driver Name<span style="color:#FF0000;">*</span></label>   
         <select name="driver" id="driver" class="form-control" required>
            <option value="">Select</option>
              <?php
$driver = pFETCH("SELECT * FROM `salesman` WHERE `status`=?", '1');
while ($driverfetch = $driver->fetch(PDO::FETCH_ASSOC)) 
{ ?>
     <option value="<?php echo $driverfetch['id']; ?>" <?php if($driverfetch['id']==gettrip('driver',$_REQUEST['id'])) { ?> selected="selected" <?php } ?>><?php echo $driverfetch['name']; ?></option>
<?php } ?>
         </select>
       
    </div> -->
   <!--  <div class="col-md-4">
         <label>Trip Type<span style="color:#FF0000;">*</span></label>
         <select name="trip_type" id="trip_type" class="form-control" required>
         <option value="">Select</option>
         <option value="1" <?php if(1==gettrip('trip_type',$_REQUEST['id'])) { ?> selected="selected" <?php } ?>>Single Trip</option> 
         <option value="2" <?php if(2==gettrip('trip_type',$_REQUEST['id'])) { ?> selected="selected" <?php } ?>>Round Trip</option> 
         </select>  
     </div>
    <div class="col-md-4">
         <label>Trip Package<span style="color:#FF0000;">*</span></label>   
         <select name="trip_package" id="trip_package" class="form-control" required onchange="gettripdetails(this.value);">
            <option value="">Select</option>
              <?php
$package = pFETCH("SELECT * FROM `package` WHERE `status`=?", '1');
while ($packagefetch = $package->fetch(PDO::FETCH_ASSOC)) 
{ ?>
     <option value="<?php echo $packagefetch['id']; ?>" <?php if($packagefetch['id']==gettrip('trip_package',$_REQUEST['id'])) { ?> selected="selected" <?php } ?>><?php echo getcity('city',$packagefetch['fromcity']).' - '.getcity('city',$packagefetch['tocity']); ?></option>
<?php } ?>
         </select>
       
    </div>


</div> -->
<br>
<div class="row">
    <div class="col-md-4">
 <label>Driver Name<span style="color:#FF0000;">*</span></label>   
 <input type="text" value="<?php echo gettrip('driver_name',$_REQUEST['id']); ?>" name="driver_name" id="driver_name" class="form-control" required>
  </div>
    <div class="col-md-4">
 <label>Driver Mobileno<span style="color:#FF0000;">*</span></label>   
 <input type="text" value="<?php echo gettrip('driver_mobileno',$_REQUEST['id']); ?>" name="driver_mobileno" id="driver_mobileno" class="form-control" required>
  </div>
 

    <div class="col-md-4">
     <label>Vehicle Model<span style="color:#FF0000;">*</span></label>   
         <select name="vehicle_model" id="vehicle_model" class="form-control" required>
            <option value="">Select</option>
              <?php
$model = pFETCH("SELECT * FROM `model` WHERE `status`=?", '1');
while ($modelfetch = $model->fetch(PDO::FETCH_ASSOC)) 
{ ?>
     <option value="<?php echo $modelfetch['id']; ?>" <?php if($modelfetch['id']==gettrip('vehicle_model',$_REQUEST['id'])) { ?> selected="selected" <?php } ?>><?php echo $modelfetch['model']; ?></option>
<?php } ?>
         </select>
       
</div>

</div><br>
<div class="row">
    <div class="col-md-4">
 <label>Vehicle No<span style="color:#FF0000;">*</span></label>   
 <input type="text" value="<?php echo gettrip('vehicleno',$_REQUEST['id']); ?>" name="vehicleno" id="vehicle_no" class="form-control" required>
  </div> 
  <div class="col-md-4">
 <label>From City<span style="color:#FF0000;">*</span></label>   
 <input type="text" value="<?php echo gettrip('fromcity',$_REQUEST['id']); ?>" name="fromcity" id="from_city" class="form-control" required>
  </div> 
   
    <div class="col-md-4">
 <label>To City<span style="color:#FF0000;">*</span></label>   
 <input type="text" value="<?php echo gettrip('tocity',$_REQUEST['id']); ?>" name="tocity" id="from_city" class="form-control" required>
  </div> 

  
</div>
<br>
<div class="row">
    <div class="col-md-4">
 <label>Starting Km<span style="color:#FF0000;">*</span></label>   
 <input type="text" value="<?php echo gettrip('start_km',$_REQUEST['id']); ?>" name="start_km" id="start_km" class="form-control" required>
  </div> 
  <div class="col-md-4">
 <label>Ending Km<span style="color:#FF0000;">*</span></label>   
 <input type="text" value="<?php echo gettrip('end_km',$_REQUEST['id']); ?>" name="end_km" id="end_km" class="form-control" required>
  </div> 

     <div class="col-md-4">
 <label>Total Km<span style="color:#FF0000;">*</span></label>   

 <input type="text" value="<?php echo gettrip('total_km',$_REQUEST['id']); ?>" name="total_km" id="total_km" class="form-control" required>
  </div> 
     
</div>
<br>
<div class="row">
<div class="col-md-4">
 <label>Per Km Charge<span style="color:#FF0000;">*</span></label>   
 <input type="text" name="per_km_charge" id="per_km_charge" class="form-control"  value="<?php echo gettrip('per_km_charge',$_REQUEST['id']); ?>">

  </div> 
 <div class="col-md-4">
 <label>Total Km Charge<span style="color:#FF0000;">*</span></label>   
 <input type="text" name="total_km_charge" value="<?php echo gettrip('total_km_charge',$_REQUEST['id']); ?>" id="total_km_charge" class="form-control" required>
  </div>  
  
 
    <div class="col-md-4">
 <label>Driver Allowance</label>   
 <input type="text" name="driver_allowance"  value="<?php echo gettrip('driver_allowance',$_REQUEST['id']); ?>" id="driver_allowance" class="form-control">
  </div> 
    
</div>
<br>
<div class="row">
    <div class="col-md-4">
 <label>Toll Charge</label>   
 <input type="text" name="toll_charge" id="toll_charge" class="form-control" value="<?php echo gettrip('toll_charge',$_REQUEST['id']); ?>" class="form-control">
  </div>
    <div class="col-md-4">
 <label>Other Permit Charge</label>   
 <input type="text" name="permit_charge" class="form-control" value="<?php echo gettrip('permit_charge',$_REQUEST['id']); ?>" id="permit_charge">
  </div>
     <div class="col-md-4">
 <label>Waiting Charge</label>   
 <input type="text" name="waiting_charge" class="form-control" value="<?php echo gettrip('waiting_charge',$_REQUEST['id']); ?>" id="waiting_charge" class="form-control" >
  </div>

</div>
<br>
<div class="row">
<div class="col-md-4">
 <label>Total Charge<span style="color:#FF0000;">*</span></label>   
 <input type="text" name="total_charge" value="<?php echo gettrip('total_charge',$_REQUEST['id']); ?>" id="total_charge" class="form-control" required>
  </div> 
    </div>

  </div>
</div>
<div class="row">

    <div class="col-md-9" align="right"><label>Subtotal</label></div>
    <div class="col-md-3" align="right"><input type="text" name="sub_total" id="sub_total" value="<?php echo gettrip('sub_total',$_REQUEST['id']); ?>" class="form-control" required></div>
</div>
<br>
<div class="row" <?php if(gettrip('gsttype',$_REQUEST['id'])=='1') { ?>style="display:block;" <?php } else { ?> style="display:none;" <?php } ?> id="gstdisp">
    <div class="col-md-9" align="right"><label>GST ( <span id="gstpercent"><?php echo gettrip('gstpercent',$_REQUEST['id']); ?> %</span> )</label></div>
    <div class="col-md-3" align="right"> <input type="hidden" name="gstpercent" id="gstpercent1" class="form-control" value="<?php echo gettrip('gstpercent',$_REQUEST['id']); ?>">
            <input type="text" name="gst_amt" id="gst_amt" value="<?php echo gettrip('gst_amt',$_REQUEST['id']); ?>" class="form-control"></div>
</div>
<br>
<div class="row">
    <div class="col-md-9" align="right"><label>Grand Total</label></div>
    <div class="col-md-3" align="right"><input type="hidden" name="gstpercentval" id="gstpercentval" value="<?php echo getprofile('gstpercent',$_SESSION['UID']); ?>">
            <input type="text" name="grand_total" id="grand_total" class="form-control" value="<?php echo gettrip('grand_total',$_REQUEST['id']); ?>"></div>
</div>


                    
                   
                </div><!-- /.box-body -->
                <div class="box-footer">
                     
 
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>master/trip.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-3"> <?php
                                if ($_REQUEST['id'] != '') { ?>
                        <a href="<?php echo $sitename; ?>MPDF/trip_invoice.php?id=<?php echo $_REQUEST['id']; ?>" target="_blank"><button type="button" name="submit" id="submit" class="btn btn-success"><i class="fa fa-print"></i>&nbsp;&nbsp;&nbsp;PRINT</button></a>&nbsp;&nbsp;&nbsp;
                    <?php } ?></div>
                        <div class="col-md-3">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['id'] != '') {
                                    echo 'UPDATE';
                                } else {
                                    echo 'SAVE & PRINT';
                                }
                                ?></button>
                        </div>
                    </div>
                </div>
            </div><!-- /.box -->
        </form>
        <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><strong>Add New Customer</strong></h4>
        </div>
        <form name="mform" method="post">
       <div class="row" style="padding:10px;">
                        
                        
                        <div class="col-md-6">
                            <label>Name <span style="color:#FF0000;">*</span></label>
                            <input type="text"  required="required" name="name" id="name" placeholder="Enter Name" class="form-control" value="<?php echo stripslashes(getcustomer('name',$_REQUEST['cid'])); ?>" />
                        </div>
                         <div class="col-md-6">
                            <label>Mobile Number <span style="color:#FF0000;">*</span></label>
                            <input type="text"  required="required" name="mobileno" id="mobileno" placeholder="Enter Mobile No" class="form-control" value="<?php echo stripslashes(getcustomer('mobileno',$_REQUEST['cid'])); ?>" />
                        </div>
                       

                        </div>
                        <br>
                        <div class="row" style="padding:10px;">
                       

                         <div class="col-md-12">
                            <label>Address <span style="color:#FF0000;">*</span></label>
                            <textarea  required="required" name="address" id="address" placeholder="Enter address" class="form-control" ><?php echo getcustomer('address',$_REQUEST['cid']); ?></textarea>
                        </div>
                         <!-- <div class="col-md-4">
                             <label>Receipt Number <span style="color:#FF0000;">*</span></label>
                         <?php //$purid = get_bill_settings('prefix', '2') . str_pad(get_bill_settings('current_value', '2'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
                                    ?>
                                    <input type="text" name="receipt_no" id="receipt_no" placeholder="Enter the Receipt Number"  class="form-control" value="<?php echo (getcustomer('receipt_no',$_REQUEST['cid'])); ?>" />
                        </div>  -->
                    </div>
        
        <div class="modal-footer">
          <button type="submit" name="createaccount" class="btn btn-default" name="newcustomer">Save</button> &nbsp; &nbsp;&nbsp; <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
       </form>
      </div>
      
    </div>
  </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include ('../../require/footer.php'); ?>
<script type="text/javascript">
 $("#chkRead").change(function () {

                if ($(this).is(":checked")) 
                {

                    $('#bill_no').removeAttr("readonly")
                }
                else 
                {
                     a=$('#gsttype').val();
                     $.ajax({
            url: "<?php echo $sitename; ?>getdetails.php",
            data: {gsttype: a}
        }).done(function (data) {
            $('#bill_no').val(data);
        });

                    $('#bill_no').attr('readonly', true);
                }
            });
  function getbillno(a) {
    if(a==1){
$("#gstdisp").css("display", "block");
$("#gstdisp1").css("display", "block");
 gtotcharge= $('#sub_total').val();
 gstpercentval= $('#gstpercentval').val();
      

$('#gstpercent').html(gstpercentval+'%');
$('#gstpercent1').val(gstpercentval);
gstres=parseFloat(gtotcharge)*(gstpercentval/100);
fintotal=parseFloat(gtotcharge)+parseFloat(gstres);
$('#gst_amt').val(gstres.toFixed(2));


 $('#grand_total').val(fintotal.toFixed(2));

    }else
    {
        $("#gstdisp").css("display", "none");
        $("#gstdisp1").css("display", "none");
gtotcharge= $('#sub_total').val();
$('#gstpercent').html();
$('#gstpercent1').val('');  
gstres='';
fintotal=parseFloat(gtotcharge);
$('#gst_amt').val(''); 
$('#grand_total').val(fintotal.toFixed(2));
    }
        $.ajax({
            url: "<?php echo $sitename; ?>getdetails.php",
            data: {gsttype: a}
        }).done(function (data) {
            $('#bill_no').val(data);
        });
    }

function gettripdetails(a) {
  
        $.ajax({
            url: "<?php echo $sitename; ?>getdetails.php",
            data: {tripid: a}
        }).done(function (data) {
              const res = data.split("#");
            $('#per_km_charge').val(res[0]);
            $('#toll_charge').val(res[1]);
            $('#driver_allowance').val(res[2]);
             $('#gstpercentval').val(res[3]);
        });
    }
 $(document).on('keyup', '#start_km,#end_km', function (e){
     
     startkm=$('#start_km').val();
      gsttype=$('#gsttype').val();
     endkm=$('#end_km').val();
     if(startkm!='' && endkm!=''){
     totkm=parseFloat(endkm)-parseFloat(startkm);
     $('#total_km').val(totkm);
     if($('#per_km_charge').val()!='' && $('#total_km').val()!='') {
      toll_charge=$('#toll_charge').val();
    trip_type=$('#trip_type').val();
    driver_allowance=$('#driver_allowance').val();
    gstpercentval=$('#gstpercentval').val();
     if(totkm!=='') {
      per_km_charge=$('#per_km_charge').val();
      totcharge=(parseFloat(per_km_charge)*parseFloat(totkm));
      gtotcharge=totcharge;
      $('#total_km_charge').val(totcharge.toFixed(2));
     }
     permit_charge=$('#permit_charge').val();
    waiting_charge=$('#waiting_charge').val();
      if(driver_allowance!='')
     {
gtotcharge=parseFloat(totcharge)+parseFloat(driver_allowance);
     }
      if(toll_charge!='')
     {
gtotcharge=parseFloat(toll_charge)+parseFloat(totcharge);
     }
      if(permit_charge!='')
     {
gtotcharge=parseFloat(totcharge)+parseFloat(permit_charge);
     }
      if(waiting_charge!='')
     {
gtotcharge=parseFloat(totcharge)+parseFloat(waiting_charge);
     }

     $('#total_charge').val(gtotcharge.toFixed(2));
       $('#sub_total').val(gtotcharge.toFixed(2));
       if(gsttype=='1')  {
$('#gstpercent').html(gstpercentval+'%');
$('#gstpercent1').val(gstpercentval);
gstres=parseFloat(gtotcharge)*(gstpercentval/100);
fintotal=parseFloat(gtotcharge)+parseFloat(gstres);
$('#gst_amt').val(gstres.toFixed(2));
}
else
{
$('#gstpercent').html();
$('#gstpercent1').val('');  
gstres='';
fintotal=parseFloat(gtotcharge);
$('#gst_amt').val('');  
}

 $('#grand_total').val(fintotal.toFixed(2));

 }
}
 });

 $(document).on('keyup', '#toll_charge,#driver_allowance,#permit_charge,#waiting_charge', function (e){
    gsttype=$('#gsttype').val();
     toll_charge=$('#toll_charge').val();
      permit_charge=$('#permit_charge').val();
    waiting_charge=$('#waiting_charge').val();
     driver_allowance=$('#driver_allowance').val();
     
          toll_charge=$('#toll_charge').val();
    trip_type=$('#trip_type').val();
   

    gstpercentval=$('#gstpercentval').val();
     totcharge=$('#total_km_charge').val();
      gtotcharge=totcharge;
    

      if(driver_allowance!='')
     {
gtotcharge=parseFloat(gtotcharge)+parseFloat(driver_allowance);
     }
      if(toll_charge!='')
     {
gtotcharge=parseFloat(toll_charge)+parseFloat(gtotcharge);
     }
      if(permit_charge!='')
     {
gtotcharge=parseFloat(gtotcharge)+parseFloat(permit_charge);
     }
      if(waiting_charge!='')
     {
gtotcharge=parseFloat(gtotcharge)+parseFloat(waiting_charge);
     }


     $('#total_charge').val(gtotcharge.toFixed(2));
       $('#sub_total').val(gtotcharge.toFixed(2));
       if(gsttype=='1')  {
$('#gstpercent').html(gstpercentval+'%');
$('#gstpercent1').val(gstpercentval);
gstres=parseFloat(gtotcharge)*(gstpercentval/100);
fintotal=parseFloat(gtotcharge)+parseFloat(gstres);
$('#gst_amt').val(gstres.toFixed(2));
}
else
{
$('#gstpercent').html();
$('#gstpercent1').val('');  
gstres='';
fintotal=parseFloat(gtotcharge);
$('#gst_amt').val('');  
}
 $('#grand_total').val(fintotal.toFixed(2));

 
 });


 $(document).on('keyup', '#per_km_charge,#total_km', function (e){
    if($('#per_km_charge').val()!='' && $('#total_km').val()!='') {
    gsttype=$('#gsttype').val();
    toll_charge=$('#toll_charge').val();
    trip_type=$('#trip_type').val();
    driver_allowance=$('#driver_allowance').val();
    gstpercentval=$('#gstpercentval').val();
     if($(this).val()!=='') {
      per_km_charge=$('#per_km_charge').val();
      totcharge=(parseFloat(per_km_charge)*$('#total_km').val());
      gtotcharge=totcharge;
      $('#total_km_charge').val(totcharge.toFixed(2));
     }
    
    permit_charge=$('#permit_charge').val();
    waiting_charge=$('#waiting_charge').val();
    
      if(driver_allowance!='')
     {
gtotcharge=parseFloat(gtotcharge)+parseFloat(driver_allowance);
     }
      if(toll_charge!='')
     {
gtotcharge=parseFloat(gtotcharge)+parseFloat(totcharge);
     }
      if(permit_charge!='')
     {
gtotcharge=parseFloat(gtotcharge)+parseFloat(permit_charge);
     }
      if(waiting_charge!='')
     {
gtotcharge=parseFloat(gtotcharge)+parseFloat(waiting_charge);
     }


     $('#total_charge').val(gtotcharge.toFixed(2));
       $('#sub_total').val(gtotcharge.toFixed(2));
if(gsttype=='1')  {
$('#gstpercent').html(gstpercentval+'%');
$('#gstpercent1').val(gstpercentval);
gstres=parseFloat(gtotcharge)*(gstpercentval/100);
fintotal=parseFloat(gtotcharge)+parseFloat(gstres);
$('#gst_amt').val(gstres.toFixed(2));
}
else
{
$('#gstpercent').html();
$('#gstpercent1').val('');  
gstres='';
fintotal=parseFloat(gtotcharge);
$('#gst_amt').val('');  
}
 $('#grand_total').val(fintotal.toFixed(2));
}
 });

</script>

<!-- Timepicker Js -->
<script src="<?php echo $sitename;?>dist/wickedpicker.min.js"></script>

<script>
  var twelveHour = $('.timepicker-12-hr').wickedpicker();
            $('.time').text('//JS Console: ' + twelveHour.wickedpicker('time'));
            $('.timepicker-24-hr').wickedpicker({twentyFour: false});
            $('.timepicker-12-hr-clearable').wickedpicker({clearable: true});



</script>

