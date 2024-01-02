<?php
if (isset($_REQUEST['cid'])) {
    $thispageeditid = 10;
} else {
    $thispageaddid = 10;
}
$menu = "8,8,155";
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['cid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    
$imag = strtolower($_FILES["image"]["name"]);
    $pimage = getsalesman('image', $getid);

 if ($imag) {
        if ($pimage != '') {
            unlink("../../img/driver/" . $pimage);
        }
        $main = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $size = $_FILES['image']['size'];
        $width1 = 1000;
        $height1 = 300;
        $extension = getExtension($main);
        $extension = strtolower($extension);
        if (($extension == 'jpg') || ($extension == 'png') || ($extension == 'gif')) {
            $m = time();
            $imagev = strtolower($m) . "." . $extension;
            $thumppath = "../../img/driver/";
            $aaa = Imageupload($main, $size, $width1, $thumppath, $thumppath, '255', '255', '255', $height1, strtolower($m), $tmp);
           
        } else {
            $ext = '1';
        }
        $image = $imagev;
    } else {
        if ($getid!='') {
            $image = $pimage;
        } else {
            $image = '';
        }
    }



$msg = addsalesman($name,$mobileno,$address,$vehicle_no,$model,$image,$status,$getid);
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
            Driver
            <small><?php
                if ($_REQUEST['cid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Driver</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i> Master(s)</a></li>            
            <li><a href="<?php echo $sitename; ?>master/salesman.htm"><i class="fa fa-circle-o"></i> Driver</a></li>
            <li class="active"><?php
                if ($_REQUEST['cid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Driver</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department"  method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['cid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> Driver</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="row">
                      

                        <div class="col-md-4">
                            <label>Driver Name<span style="color:#FF0000;">*</span></label>
                            <input type="text"  required="required" name="name" id="name" placeholder="Enter Name" class="form-control" value="<?php echo stripslashes(getsalesman('name',$_REQUEST['cid'])); ?>" />
                        </div>
                         
                        <div class="col-md-4">
                            <label>Driver Mobileno<span style="color:#FF0000;">*</span></label>
                            <input type="text"  required="required" name="mobileno" id="mobileno" placeholder="Enter Mobileno" class="form-control" value="<?php echo stripslashes(getsalesman('mobileno',$_REQUEST['cid'])); ?>" />
                        </div>
                         <div class="col-md-4">
                            <label>Vehicle No<span style="color:#FF0000;">*</span></label>
                            <input type="text"  required="required" name="vehicle_no" id="vehicle_no" placeholder="Enter Vehicle No" class="form-control" value="<?php echo stripslashes(getsalesman('vehicle_no',$_REQUEST['cid'])); ?>" />
                        </div>

                    </div>
                    
                     <div class="clearfix"><br /></div>
                    <div class="row">
                    
                        <div class="col-md-4">
                                <div class="form-group">
                                    <label>Driver Proof </label>
                                    <input class="form-control spinner" <?php if (getsalesman('image', $_REQUEST['cid']) == '') { ?>  <?php } ?> name="image" type="file"> 
                                </div>
                        </div>
                            
                            <?php if (getsalesman('image', $_REQUEST['cid']) != '') { ?>
                                <div class="col-md-4" id="delimage">
                                    <label> </label>
                                    <img src="<?php echo $fsitename; ?>img/driver/<?php echo getsalesman('image', $_REQUEST['cid']); ?>" style="padding-bottom:10px;" height="100" />
                                    <button type="button" style="cursor:pointer;" class="btn btn-danger" name="del" id="del" onclick="javascript:deleteimage('<?php echo getsalesman('image', $_REQUEST['cid']); ?>', '<?php echo $_REQUEST['cid']; ?>', 'salesman', '../../../img/driver/', 'image', 'id');"><i class="fa fa-close">&nbsp;Delete Image</i></button>
                                </div>
                            <?php } ?>
                        
                        
                    </div>
                         <div class="clearfix"><br /></div>
                         <div class="row">
                      

                        <div class="col-md-4">
                            <label>Model<span style="color:#FF0000;">*</span></label>
                            <select name="model" class="form-control">
                                <option value="">Select</option>
                                <?php
                             $object = pFETCH("SELECT * FROM `model` WHERE `status`=?", '1');
                             while ($objectfetch = $object->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <option value="<?php echo $objectfetch['id']; ?>" <?php if (getsalesman('object', $_REQUEST['cid']) == $objectfetch['id']) { ?> selected <?php  } ?>><?php  echo $objectfetch['model']; ?></option>
                            <?php  } ?> 
                            </select>
                        </div>
                         
                         <div class="col-md-4">
                            <label>Address <span style="color:#FF0000;">*</span></label>
                            <textarea  required="required" name="address" id="address" placeholder="Enter address" class="form-control" ><?php echo getsalesman('address',$_REQUEST['cid']); ?></textarea>
                        </div> 
  <div class="col-md-4">
                           
                            <label>Status <span style="color:#FF0000;">*</span></label>                                  
                                                            <select name="status" class="form-control">
                                                                <option value="1" <?php
                                                                if (stripslashes(getsalesman('status', $_REQUEST['cid'])) == '1') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>Active</option>
                                                                <option value="0" <?php
                                                                if (stripslashes(getsalesman('status', $_REQUEST['cid']) == '0')) {
                                                                    echo 'selected';
                                                                }
                                                                ?>>Inactive</option>

                                                            </select>
                        </div>
                    </div>
                    
                   
                      <div class="clearfix"><br /></div>
                    

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>master/salesman.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['cid'] != '') {
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
            window.location.href = "<?php echo $sitename; ?>master/<?php echo getsalesman('id',$_REQUEST['cid']); ?>/editprovider.htm?delid=" + id;
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

            window.location.href = "<?php echo $sitename; ?>master/<?php echo getsalesman('id',$_REQUEST['cid']); ?>/editcustomer.htm?delid1=" + id;
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