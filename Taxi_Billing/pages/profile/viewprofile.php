<?php
include ('../../config/config.inc.php');
$dynamic = '1';
$editor = '1';
include ('../../require/header.php');

if ($_REQUEST['del'] != '') {
    $msg = dellocationimage(getprofile('image', $_SESSION['UID']), $_SESSION['UID']);
    header("location:" . $sitename . "pages/profile/viewprofile.htm");
}

if (isset($_REQUEST['submit'])) {    
    $pimage = getprofile('image', $_SESSION['UID']);
    //  $image = '';
    $imag = strtolower($_FILES["image"]["name"]);
    if ($imag) {
        if ($pimage != '') {
            unlink("image/" . $pimage);
        }
        $main = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $size = $_FILES['image']['size'];
        $width = 1000;
        $height = 1000;
        $extension = getExtension($main);
        $extension = strtolower($extension);
        $m = time() . $i;
        $imagev = $m . "." . $extension;
        $thumppath = "image/";
        move_uploaded_file($tmp, $thumppath . $imagev);
        $image = $imagev;
    } else {
        $image = $pimage;
    }
        
    
    @extract($_REQUEST);
    $ip = $_SERVER['REMOTE_ADDR'];
    if ($password == $cpassword) {
        $msg = addprofile($gstno,$gstpercent,$per_km_charge,$footer_content,$terms,$tax,$title, $firstname, $lastname, $image, $cmpnyname, $recoveryemail, $phonenumber,$mail_option,  $caddress, $abn, $ip,$bank_name,$branch_name,$account_name,$account_no,$ifsc_code,$swift_code,$branch_address, $_SESSION['UID']);
    } else {
        $msg = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-exclamation-triangle"></i>Password Does not Match</h4></div>';
    }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            View Profile
            <small>Manage Profile</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Profile</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department" method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Manage Profile</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Profile Update</div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <!-- <div class="col-md-2">

                                    <label>Title <span style="color:#FF0000;">*</span></label>
                                    <select name="title" id="status" class="form-control">
                                        <option value="Mr" <?php
                                        if (getprofile('title', $_SESSION['UID']) == 'Mr') {
                                            echo 'selected';
                                        }
                                        ?>>Mr</option>
                                        <option value="Miss" <?php
                                        if (getprofile('title', $_SESSION['UID']) == 'Miss') {
                                            echo 'selected';
                                        }
                                        ?>>Miss</option>
                                        <option value="Mrs" <?php
                                        if (getprofile('title', $_SESSION['UID']) == 'Mrs') {
                                            echo 'selected';
                                        }
                                        ?>>Mrs</option>
                                        <option value="Er" <?php
                                        if (getprofile('title', $_SESSION['UID']) == 'Er') {
                                            echo 'selected';
                                        }
                                        ?>>Er</option>
                                        <option value="Dr" <?php
                                        if (getprofile('title', $_SESSION['UID']) == 'Dr') {
                                            echo 'selected';
                                        }
                                        ?>>Dr</option>
                                        <option value="Others" <?php
                                        if (getprofile('title', $_SESSION['UID']) == 'Others') {
                                            echo 'selected';
                                        }
                                        ?>>Others</option>
                                    </select>
                                </div> -->
                                <div class="col-md-5">
                                    <label>First Name <span style="color:#FF0000;">*</span></label>
                                    <input type="text" class="form-control" placeholder="Enter the first name" name="firstname" id="firstname" required="required" pattern="[0-9 A-Za-z .,-':()[]]{3,60}" title="Allowed Attributes (0-9 A-Za-z .,-':)" value="<?php
                                    if ($_SESSION['UID'] == '1') {

                                        echo getprofile('firstname', $_SESSION['UID']);
                                    } elseif ($_SESSION['UID'] != "") {

                                        //echo getemployees('empname', $_SESSION['UID']);
                                    }
                                    ?>" />
                                </div>
                                <div class="col-md-5">
                                    <label>Last Name </label>
                                    <input type="text" class="form-control" placeholder="Enter the last name" name="lastname" id="lastname" pattern="[0-9 A-Za-z .,-':()[]]{3,60}" title="Allowed Attributes (0-9 A-Za-z .,-':)" value="<?php echo getprofile('lastname', $_SESSION['UID']); ?>" />
                                </div>
                            </div>

                            <br />
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Image </label>
                                    <input type="file" class="form-control" name="image" id="image" />
                                </div>
                                <div class="col-md-6" id="delimage">
                                    <label> </label>
                                    <?php if (getprofile('image', $_SESSION['UID']) != '') { ?>
                                        <img src="<?php echo $sitename . 'pages/profile/image/' . getprofile('image', $_SESSION['UID']); ?>" style="padding-bottom:10px;" height="100" />
                                        <button type="button" style="cursor:pointer;" class="btn btn-danger" name="del" id="del" onclick="javascript:deleteimage('<?php echo getprofile('image', $_SESSION['UID']); ?>', '<?php echo $_SESSION['UID']; ?>', 'manageprofile', '../pages/profile/image/', 'image', 'pid');"><i class="fa fa-close">&nbsp;Delete Image</i></button>
                                    <?php }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                   
                     <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">GST Details</div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>GST No</label>
                                    <input type="text" name="gstno" class="form-control" value="<?php echo getprofile('gstno', $_SESSION['UID']); ?>">

                                </div>
                                <div class="col-md-4">
                                    <label>GST Percentage (%)</label>
                                    <input type="text" name="gstpercent" class="form-control" value="<?php echo getprofile('gstpercent', $_SESSION['UID']); ?>">

                                </div>
                            </div>
                        </div></div>


                        </div>
                    </div>

                </div><!-- /.box -->
                
                        <div class="box-footer">
                            <div class="col-md-12">
                                <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;">UPDATE</button>
                            </div>
                        </div>
        </form>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">

    function dellocationimage()
    {
        if (confirm("Please confirm you want to Delete this Image"))
        {
            window.location.href = '<?php echo $sitename . 'settings/' . $_SESSION['UID'] . '/delimagelocation.html'; ?>';
            return true;
        } else
        {
            return false;
        }
    }
</script>
<?php include ('../../require/footer.php'); ?>