<?php
$menu = "3,3,28";
$thispageid = 10;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable = '1';
include ('../../require/header.php');
if(isset($_REQUEST['export']))
{
@extract($_REQUEST);
$url=$sitename.'pages/master/export.php?type=trip&fromdate='.$_REQUEST['fromdate'].'&todate='.$_REQUEST['todate'].'&gsttype='.$_REQUEST['gsttype'];
echo "<script>window.open('".$url."', '_blank');</script>";
}
?>
<style type="text/css">
    .row { margin:0;}
  
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Sales Report
            <small>List of Report</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i>Report(s)</a></li>
            <li class="active"><a href="#"><i class="fa fa-circle-o"></i>Sales Report Mgmt</a></li>            
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">List of Sales Report</h3>
            </div><!-- /.box-header -->
            <div class="box-header">
                <div class="panel panel-info">

                        <div class="panel-heading">

                            <div class="panel-title">
Search
                            </div>

                        </div>

                        <div class="panel-body">
						<form name="sform" method="post" autocomplete="off">
						<div class="row">
						<div class="col-md-3">
					 <label>Form Date <span style="color:red;">*</span></label>
						 <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right usedatepicker hasDatepicker" name="fromdate" id="fromdate" required="required" value="<?php echo $_REQUEST['fromdate']; ?>">
                            </div>
					 	</div>
						<div class="col-md-3">
						<label>To Date <span style="color:red;">*</span></label>
						<div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right usedatepicker hasDatepicker" name="todate" id="todate" required="required" value="<?php echo $_REQUEST['todate']; ?>">
                            </div>
						
						</div>
                        <div class="col-md-3">
                        <label>Customer Name / Mobileno</label>
                     

                                <input type="text" class="form-control" name="cusname" id="cusname" value="<?php echo $_REQUEST['cusname']; ?>">
                          
                        </div>
						<div class="col-md-3">
						<label>GST Type </label>
						<select name="gsttype" class="form-control" required>
						<option value="">Select</option>
						<option value="1" <?php if($_REQUEST['gsttype']=='1') { ?> selected="selected" <?php } ?>>With GST</option>
						<option value="2" <?php if($_REQUEST['gsttype']=='2') { ?> selected="selected" <?php } ?>>Without GST</option>
                        </select>
						</div>
						
						

						</div>
						<br>
						

						
						<div class="row">
						
						<div class="col-md-3"><br>
						<button type="submit" class="btn btn-info btn-sm" name="search" style="font-size:16px;">Search</button>&nbsp;&nbsp;&nbsp;
						<button type="submit" class="btn btn-info btn-sm" name="export" style="font-size:16px;">Export Excel</button>
						</div>
						</div>
						</form>
						</div></div>
            </div><!-- /.box-header -->

            <div class="box-body">
                <?php echo $msg; ?>
				<?php
				 global $db;
$s='';
if($_REQUEST['fromdate']!='' && $_REQUEST['todate']!='') {
$s1[]="(`date`>='".date('d-m-Y',strtotime($_REQUEST['fromdate']))."'  AND `date`<='".date('d-m-Y',strtotime($_REQUEST['todate']))."')";
}
if($_REQUEST['gsttype']!='')
{
$s1[]="`gsttype`='".$_REQUEST['gsttype']."'";
}


if($_REQUEST['cusname']!='') {
$sel=pFETCH("SELECT * FROM `customer` WHERE `status`=? AND (`name` LIKE '%".$_REQUEST['cusname']."%' OR `mobileno` LIKE '%".$_REQUEST['cusname']."%') ", 1);
while ($fdepart = $sel->fetch(PDO::FETCH_ASSOC)) {
$cusarray[]=    $fdepart['id'];
}

}
if(is_countable($cusarray) && count($cusarray)>0) {
    $cusexp=implode(',',$cusarray);
$s1[]='`customer_name` IN ('.$cusexp.')'; 
}

$m=1;
if(is_countable($cusarray) && count($s1)>0) {
$s=implode('  AND  ',$s1);
}


if($s!='') { 
$tomes = $db->prepare("SELECT SUM(`grand_total`) AS `totamt` FROM `trip` WHERE `id`!='0' AND $s ORDER BY `cudate` DESC");
}
else{
$tomes = $db->prepare("SELECT SUM(`grand_total`) AS `totamt` FROM `trip` WHERE `id`!='0' ORDER BY `cudate` DESC");	
}

 $tomes->execute();
 $tomesfetch = $tomes->fetch(PDO::FETCH_ASSOC);

				?>
				<br>
				<br>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center" style="font-size:19px;">
                                    <th style="width:3%;">Sno</th>
                                    <th style="width:8%">Date</th>
                                    <th style="width:8%">Invoice No</th>
                                     <th style="width:8%">Customer Name</th>
                                      <th style="width:8%">Mobileno</th>
                                    <th style="width:10%">Total Amount</th>
                                    <?php if($_REQUEST['gsttype']=='1') { ?>
									 <th style="width:10%">GST Amount</th>
                                    <?php } ?>
                                </tr>
                            </thead>
<?php  
if($s!='') { 
//echo "SELECT * FROM `online_order` WHERE `id`!='0' AND $s ORDER BY `cudate` DESC";

 $message1 = $db->prepare("SELECT * FROM `trip` WHERE `id`!='0' AND $s ORDER BY `cudate` DESC");
}
else{
$message1 = $db->prepare("SELECT * FROM `trip` WHERE `id`!='0' ORDER BY `cudate` DESC");	
}
$m=1;
 $message1->execute();
while($message = $message1->fetch(PDO::FETCH_ASSOC)) {
		
$totsalemat+=$message['grand_total'];										
  ?>
                                    
                                         <tr>
                                        <td><?php echo $m; ?></td>
                                        <td><?php echo date('d-m-Y',strtotime($message['date'])); ?></td>
                                        <td><?php echo $message['bill_no']; ?></td>
                                         <td><?php echo getcustomer('name',$message['customer_name']); ?></td>
                                          <td><?php echo getcustomer('mobileno',$message['customer_name']); ?></td>
                                        <td>Rs. <?php echo $message['grand_total']; ?></td>
                                         <?php if($_REQUEST['gsttype']=='1') { ?>
                                        <td>Rs. <?php echo $message['gst_amt']; ?></td>
                                    <?php } ?>
                                         </tr>
                                                <?php
												$m++;
}
                                            ?>
                            <tfoot>
                            </tfoot>
                        </table>
                      
                    </div>
                </form>
          
<!-- <div class="row" style="position: absolute;left:1px;top: 40%;">
				<div class="col-md-12"><h2>Total Trip Amount: <span style="color:blue;">Rs .<?php echo number_format($totsalemat,2); ?></span></h2></div>
				</div>
				<br> -->
		  </div><!-- /.box-body -->
        </div><!-- /.box -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
include ('../../require/footer.php');
?>  
<script>
function getordertype(a) {
	     $.post("<?php echo $sitename; ?>config/functions_ajax.php", {ordermethod: a},
                function (data) {
					//alert(data);
                    $('#order_type').html(data);
                });
    }
	
</script>
<script type="text/javascript">
  
  $('#normalexamples').dataTable({
        "bProcessing": false,
        "bServerSide": false,
        //"scrollX": true,
        "searching": true,
	"ordering":false,
         });
		 
</script>