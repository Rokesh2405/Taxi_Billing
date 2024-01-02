<?php
$dynamic = '';
$menu = '1,0,0,0';
$index='1';
include ('require/header.php');
//print_r($_SESSION);
?>
<style>
    table. tr,td{
       border-color: #000; 
    }
    /*.content-wrapper{*/
    /*    background-image : url("img/coins1.jpg");*/
    /*    height: 480px;*/
    /*}*/
</style>
<!-- Left side column. contains the logo and sidebar -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php
    if ($_SESSION['type'] == 'admin') {
        ?>
        <section class="content-header">

            <h2>
                <b> Droptaxi Billing </b>
                <small>Control panel</small>
            </h2>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Droptaxi Billing</li>
            </ol>
        </section>
<section class="content">

<div class="row">
    
         <div class="col-md-3">
                <!-- small box -->
                <a href="<?php echo $sitename; ?>master/addtrip.htm">
                <div class="small-box"style="background-color:#00c0ef;">
                    <div class="inner">
                        <h3 style="color:white;">
                          &nbsp;</h3>
                        <p style="color:white;">ADD TRIP<br> click here to add</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-car" style="font-size:50px;"></i>
                    </div>
                   
                </div>
                
                </a>
            </div>
         <div class="col-md-3">
                <!-- small box -->
                <a href="<?php echo $sitename; ?>master/trip.htm">
                <div class="small-box"style="background-color:#00c0ef;">
                    <div class="inner">
                        <h3 style="color:white;">
                           <?php
                            $link1 = FETCH_all("SELECT COUNT(*) AS `totsale` FROM trip WHERE `id`!=?", '0');
 echo $link1['totsale'];
                           ?></h3>
                        <p style="color:white;">TOTAL TRIPS<br> click here to details</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-car" style="font-size:50px;"></i>
                    </div>
                   
                </div>
                
                </a>
            </div>
             <div class="col-md-3">
                <!-- small box -->
                <a href="<?php echo $sitename; ?>master/customer.htm">
                <div class="small-box"style="background-color:#00c0ef;">
                    <div class="inner">
                        <h3 style="color:white;">
                           <?php
                            $link1 = FETCH_all("SELECT COUNT(*) AS `totsale` FROM customer WHERE `id`!=?", '0');
 echo $link1['totsale'];
                           ?></h3>
                        <p style="color:white;">TOTAL CUSTOMERS<br> click here to details</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user" style="font-size:50px;"></i>
                    </div>
                   
                </div>
                
                </a>
            </div>
           
 <div class="col-md-3">
                <!-- small box -->
                <a href="<?php echo $sitename; ?>process/expense_report.htm">
                <div class="small-box"style="background-color:#00c0ef;">
                    <div class="inner">
                        <h3 style="color:white;">
                           <?php
                            $link1 = FETCH_all("SELECT SUM(`amount`) AS `totsale` FROM daily_expense WHERE `id`!=?", '0');
 echo $link1['totsale'];
                           ?></h3>
                        <p style="color:white;">TOTAL EXPENSE<br> click here to details</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-car" style="font-size:50px;"></i>
                    </div>
                   
                </div>
                
                </a>
            </div>
        </div>
        <div class="row">
<div class="col-md-6"><h4><strong>With GST Invoice</strong></h4>
  <table id="normalexamples" class="table table-bordered table-striped" style="border:1px solid;">
                            <thead>
                                <tr align="center" style="font-size:19px;">
                                   
                                    <th>Date</th>

<th>Customer Mobileno</th>
                                    <th>Total Amount</th>
                                    <th>GST Amount</th>
                                  <th>Action</th>

                                </tr>
                            </thead>
<?php  

$message1 = $db->prepare("SELECT * FROM `trip` WHERE `id`!='0'  AND `gsttype`='1' ORDER BY `cudate` DESC");
$m=1;
 $message1->execute();
while($message = $message1->fetch(PDO::FETCH_ASSOC)) {
        
$totsalemat+=$message['grand_total'];                                       
  ?>
                                    
                                         <tr>
                                     
                                        <td><?php echo date('d-m-Y',strtotime($message['date'])); ?></td>
                                       
                                        
                                          <td><?php echo getcustomer('mobileno',$message['customer_name']); ?></td>
                                        <td>Rs. <?php echo $message['grand_total']; ?></td>
                                         
                                        <td>Rs. <?php echo $message['gst_amt']; ?></td>
                                   
                                     <td></strong><a href="<?php echo $sitename; ?>master/<?php echo $message['id']; ?>/edittrip.htm" target="_blank"><i class="fa fa-view" style="cursor:pointer;"> View </i></a></strong></td>
                                         </tr>
                                                <?php
                                                $m++;
}
                                            ?>
                            <tfoot>
                            </tfoot>
                        </table>
                      
</div>
<div class="col-md-6"><h4><strong>With Out GST Invoice</strong></h4>
 <table id="normalexamples1" class="table table-bordered table-striped" style="border:1px solid;" width="80%">
                            <thead>
                                <tr align="center" style="font-size:19px;">
                                    <th style="width:3%;">Sno</th>
                                    <th style="width:8%">Date</th>
                                
                                     <th style="width:8%">Customer Mobileno</th>
                                    <th style="width:8%">Total Amount</th>
                                  <th style="width:8%">Action</th>

                                </tr>
                            </thead>
<?php  

$message1 = $db->prepare("SELECT * FROM `trip` WHERE `id`!='0'  AND `gsttype`='2' ORDER BY `cudate` DESC");
$m=1;
 $message1->execute();
while($message = $message1->fetch(PDO::FETCH_ASSOC)) {
        
$totsalemat+=$message['grand_total'];                                       
  ?>
                                    
                                         <tr>
                                        <td><?php echo $m; ?></td>
                                        <td><?php echo date('d-m-Y',strtotime($message['date'])); ?></td>
                                      <td><?php echo getcustomer('mobileno',$message['customer_name']); ?></td>
                                        <td>Rs. <?php echo $message['grand_total']; ?></td>
                                       
                                     <td><strong><a href="<?php echo $sitename; ?>master/<?php echo $message['id']; ?>/edittrip.htm" target="_blank"><i class="fa fa-view" style="cursor:pointer;"> View </i></a></strong></td>
                                         </tr>
                                                <?php
                                                $m++;
}
                                            ?>
                            <tfoot>
                            </tfoot>
                        </table>
            
</div>
        </div>
        </section><!-- /.content -->
    <?php } else { ?>
        <section class="content-header">
            <h1>
                Welcome to HOTEL
            </h1>
        </section>

<?php } ?>
</div><!-- /.content-wrapper -->
<?php include 'require/footer.php'; ?>      
<script type="text/javascript">
  
  $('#normalexamples').dataTable({
        "bProcessing": false,
        "bServerSide": false,
        //"scrollX": true,
        "searching": true,
    "ordering":false,
         });
     $('#normalexamples1').dataTable({
        "bProcessing": false,
        "bServerSide": false,
        //"scrollX": true,
        "searching": true,
    "ordering":false,
         });
              
</script>