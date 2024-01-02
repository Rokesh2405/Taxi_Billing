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
    $msg = addpackage($package,$fromcity,$tocity,$package_price,$gst,$driver_beta,$toll_charge,$status,$getid);
}

?>

<style>
       .form-control{
           font-size:19px;
       }
       label{
           font-size:19px;
       }
   </style>
    
    
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Package
            <small><?php
                if ($_REQUEST['id'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Package</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i> Master(s)</a></li>            
            <li><a href="<?php echo $sitename; ?>master/package.htm"><i class="fa fa-circle-o"></i> Package</a></li>
            <li class="active"><?php
                if ($_REQUEST['id'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Package</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department"  method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['id'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> Package</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="row">
                        
                        
                        <div class="col-md-4">
                            <label>Package Name<span style="color:#FF0000;">*</span></label>
							 <input type="text"  required="required" name="package" id="package" placeholder="Enter Package Name" autocomplete="off" class="form-control" value="<?php echo getpackage('package',$_REQUEST['id']); ?>" />
                        </div>
                         <div class="col-md-4">
                            <label>From City<span style="color:#FF0000;">*</span></label>
                             <select name="fromcity" class="form-control">
                                <option value="">Select</option>
                                <?php
                             $object = pFETCH("SELECT * FROM `city` WHERE `status`=?", '1');
                             while ($objectfetch = $object->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <option value="<?php echo $objectfetch['id']; ?>" <?php if (getpackage('fromcity', $_REQUEST['id']) == $objectfetch['id']) { ?> selected <?php  } ?>><?php  echo $objectfetch['city']; ?></option>
                            <?php  } ?> 
                            </select>
                        </div>
                         <div class="col-md-4">
                            <label>To City<span style="color:#FF0000;">*</span></label>
                             <select name="tocity" class="form-control">
                                <option value="">Select</option>
                                <?php
                             $object = pFETCH("SELECT * FROM `city` WHERE `status`=?", '1');
                             while ($objectfetch = $object->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <option value="<?php echo $objectfetch['id']; ?>" <?php if (getpackage('tocity', $_REQUEST['id']) == $objectfetch['id']) { ?> selected <?php  } ?>><?php  echo $objectfetch['city']; ?></option>
                            <?php  } ?> 
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                         <div class="col-md-4">
                            <label>Package Price<span style="color:#FF0000;">*</span></label>
                             <input type="text"  required="required" name="package_price" id="package_price" placeholder="Enter Package Price" autocomplete="off" class="form-control" value="<?php echo getpackage('package_price',$_REQUEST['id']); ?>" />
                        </div>
                         <div class="col-md-4">
                            <label>GST<span style="color:#FF0000;">*</span></label>
                            <select name="gst" class="form-control">
                                <option value="">Select</option>
                                <?php
                             $object = pFETCH("SELECT * FROM `gst` WHERE `status`=?", '1');
                             while ($objectfetch = $object->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <option value="<?php echo $objectfetch['id']; ?>" <?php if (getpackage('gst', $_REQUEST['id']) == $objectfetch['id']) { ?> selected <?php  } ?>><?php  echo $objectfetch['gst']; ?>%</option>
                            <?php  } ?> 
                            </select>
                        </div>
                         <div class="col-md-4">
                            <label>Driver Allowance<span style="color:#FF0000;">*</span></label>
                             <input type="text"  required="required" name="driver_beta" id="driver_beta" placeholder="Enter Driver Allowance" autocomplete="off" class="form-control" value="<?php echo getpackage('driver_beta',$_REQUEST['id']); ?>" />
                        </div>
                        
                    </div>
                    <br>
                    <div class="row">
                         <div class="col-md-4">
                            <label>Toll Charges<span style="color:#FF0000;">*</span></label>
                             <input type="text"  required="required" name="toll_charge" id="toll_charges" placeholder="Enter Toll Charges" autocomplete="off" class="form-control" value="<?php echo getpackage('toll_charge',$_REQUEST['id']); ?>" />
                        </div>
                          <div class="col-md-4">
                            <label>Status</label>
                          
                          <select name="status" class="form-control">
                         <option value="1" <?php if(getmodel('status', $_REQUEST['id'])=='1') { ?> selected="selected"<?php } ?>>Active</option>      
                         <option value="0" <?php if(getmodel('status', $_REQUEST['id'])=='0') { ?> selected="selected"<?php } ?>>Inactive</option>      
                          </select>
                      </div>
                        
                        
                    </div>
                    
                     <div class="clearfix"><br /></div>
                    
                    
                     <br>
                    
                   
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>master/package.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['id'] != '') {
                                    echo 'UPDATE';
                                } else {
                                    echo 'SUBMIT';
                                }
                                ?></button>
                        </div>
                    </div>
                </div>
            </div><!-- /.box -->
        </form>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include ('../../require/footer.php'); ?>
<script type="text/javascript">

     function show_contacts(id) {
        $.ajax({
            url: "<?php echo $sitename; ?>getpassup.php",
            data: {get_contacts_of_customer: id}
        }).done(function (data) {
            $('#choose_contacts_grid_table tbody').html(data);
        });
    }


      function delrec(elem, id) {
        if (confirm("Are you sure want to delete this Object?")) {
            $(elem).parent().remove();
            window.location.href = "<?php echo $sitename; ?>master/<?php echo getcustomer('id',$_REQUEST['id']); ?>/editprovider.htm?delid=" + id;
        }
    }


    $(document).ready(function (e) {
        
        $('#add_task').click(function () {

           
            var data = $('#firsttasktr').clone();
            var rem_td = $('<td />').html('<i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i>').click(function () {
                if (confirm("Do you want to delete the Offer?")) {
                    $(this).parent().remove();
                    re_assing_serial();
                   
                }
            });
            $(data).attr('id', '').show().append(rem_td);

            data = $(data);
            $('#task_table tbody').append(data);
             $('.usedatepicker').datepicker({
                autoclose: true
            });

           
            re_assing_serial();

        });
       
         $('#add_proof').click(function () {

           
            var data = $('#firstprooftr').clone();
            var rem_td = $('<td />').html('<i class="fa fa-trash fa-2x" style="color:#F00;cursor:pointer;"></i>').click(function () {
                if (confirm("Do you want to delete the Proof?")) {
                    $(this).parent().remove();
                    re_assing_serial();
                   
                }
            });
            $(data).attr('id', '').show().append(rem_td);

            data = $(data);
            $('#proof_table tbody').append(data);
             $('.usedatepicker').datepicker({
                autoclose: true
            });

           
            re_assing_serial();

        });

        

      });

    function del_addi(elem) {
        if (confirm("Are you sure want to remove this?")) {
            elem.parent().parent().remove();
            additionalprice();
        }
    }


   
   
    
    function re_assing_serial() {
        $("#task_table tbody tr").not('#firsttasktr').each(function (i, e) {
            $(this).find('td').eq(0).html(i + 1);
        });
        $("#proof_table tbody tr").not('#firstprooftr').each(function (i, e) {
            $(this).find('td').eq(0).html(i + 1);
        });
    }

    function delrec1(elem, id) {
        if (confirm("Are you sure want to delete this Details?")) {
            $(elem).parent().remove();

            window.location.href = "<?php echo $sitename; ?>master/<?php echo getcustomer('id',$_REQUEST['id']); ?>/editcustomer.htm?delid1=" + id;
        }
    }

    function interest_calculation(){
        var interest_amount = $('#amount').val();
        var interest_percent = $('#interestpercent').val();
        var a = (interest_percent / 100);
        // alert(a);
        var interest_total = interest_amount - (interest_amount *  a);
        // alert(interest_total);
        document.getElementById('interest').value = interest_total;
        // $('#interest').html(interest_total);
    }
    

</script>