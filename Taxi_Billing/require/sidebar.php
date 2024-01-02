<aside class="main-sidebar">
<section class="sidebar" onmouseover="toggleSidebar()" onmouseout="toggleSidebar()">
<ul class="sidebar-menu">
<li class="header">MAIN NAVIGATION</li>
<li class="treeview <?php echo $tree1; ?>">
<a href="<?php echo $sitename; ?>">
<i class="fa fa-dashboard"></i> <span>Dashboard</span>
</a>
</li>
<?php if ($_SESSION['UID'] == '1') { ?>
<li class="treeview <?php echo $tree3; ?>" id="ul_18" style="display:block;">
<a href="#">
<i class="fa fa-asterisk"></i>
<span>Masters</span>
<span class="label label-success pull-right" id="span_18">6</span>
</a>
<ul class="treeview-menu">

<li <?php echo $smenuitem119; ?> id="li_122">
<a href="<?php echo $sitename; ?>master/ordertype.htm">
<i class="fa fa-circle-o"></i>Order Type Mgmt 
</a>
</li>
<li <?php echo $smenuitem119; ?> id="li_123">
<a href="<?php echo $sitename; ?>master/paymentmode.htm">
<i class="fa fa-circle-o"></i>Payment Mode Mgmt 
</a>
</li>
<!-- <li <?php echo $smenuitem155; ?> id="li_156">
<a href="<?php echo $sitename; ?>/master/salesman.htm">
<i class="fa fa-circle-o"></i>Driver Mgmt 
</a>
</li> -->
<li <?php echo $smenuitem119; ?> id="li_123">
<a href="<?php echo $sitename; ?>master/model.htm">
<i class="fa fa-circle-o"></i>Vehicle Model Mgmt 
</a>
</li>
<!-- <li <?php echo $smenuitem119; ?> id="li_123">
<a href="<?php echo $sitename; ?>master/city.htm">
<i class="fa fa-circle-o"></i>City Mgmt 
</a>
</li>
<li <?php echo $smenuitem119; ?> id="li_123">
<a href="<?php echo $sitename; ?>master/gst.htm">
<i class="fa fa-circle-o"></i>GST Mgmt 
</a>
</li>
<li <?php echo $smenuitem10; ?> id="li_10">
<a href="<?php echo $sitename; ?>master/package.htm">
<i class="fa fa-circle-o"></i>Trip Packages Mgmt 
</a>
</li> -->

</ul>
</li>
<li class="treeview <?php echo $tree3; ?>" id="ul_18" style="display:block;">
<a href="#">
<i class="fa fa-asterisk"></i>
<span>Users</span>
<span class="label label-success pull-right" id="span_18">1</span>
</a>
<ul class="treeview-menu">

<li <?php echo $smenuitem119; ?> id="li_122">
<a href="<?php echo $sitename; ?>master/customer.htm">
<i class="fa fa-circle-o"></i>Customers Mgmt 
</a>
</li>
</ul>
</li>
<li class="treeview <?php echo $tree3; ?>" id="ul_3">
<a href="#">
<i class="fa fa-money"></i>
<span>Trips</span>
<span class="label label-warning pull-right">1</span>
</a>
<ul class="treeview-menu">


<li <?php echo $smenuitem44; ?> id="li_44">
<a href="<?php echo $sitename; ?>master/trip.htm">
<i class="fa fa-circle-o"></i>Trip Invoice
</a>
</li>
</ul>
</li>


<li class="treeview <?php echo $tree4; ?>" id="ul_4">
<a href="#">
<i class="fa fa-money"></i>
<span>Expense</span>
<span class="label label-warning pull-right" id="span_4">2</span>
</a>
<ul class="treeview-menu">
<li <?php echo $smenuitem144; ?> id="li_144">
<a href="<?php echo $sitename; ?>master/expense_type.htm">
<i class="fa fa-circle-o"></i>Create Type 
</a>
</li>
<li <?php echo $smenuitem228; ?> id="li_228">
<a href="<?php echo $sitename; ?>master/adddaily_expense.htm">
<i class="fa fa-circle-o"></i>Daily Expense 
</a>
</li>



</ul>
</li>


<li class="treeview <?php echo $tree31; ?>" id="ul_31">
<a href="#">
<i class="fa fa-money"></i>
<span>Reports</span>
<span class="label label-warning pull-right" id="span_31">2</span>
</a>
<ul class="treeview-menu">
<li <?php echo $smenuitem28; ?> id="li_28">
<a href="<?php echo $sitename; ?>master/trip_report.htm">
<i class="fa fa-circle-o"></i>Trip Reports 
</a>
</li>


<li <?php echo $smenuitem27; ?> id="li_27">
<a href="<?php echo $sitename; ?>pages/process/expense_report.php">
<i class="fa fa-circle-o"></i>Expense Reports 
</a>
</li>

</ul>
</li>

<?php } else { ?>
<li class="treeview <?php echo $tree1; ?>">
<a href="<?php echo $sitename; ?>pages/process/addsales.php">
<i class="fa fa-money"></i> <span>Sales Order</span>
</a>
</li> 
<li class="treeview <?php echo $tree1; ?>">
<a href="<?php echo $sitename; ?>pages/process/receipt_payment.php">
<i class="fa fa-money"></i> <span>Receipt Details</span>
</a>
</li> 
<li class="treeview <?php echo $tree1; ?>">
<a href="<?php echo $sitename; ?>pages/process/stock_report.php">
<i class="fa fa-money"></i> <span>Stock Report</span>
</a>
</li> 
<li class="treeview <?php echo $tree1; ?>">
<a href="<?php echo $sitename; ?>pages/process/sales_report.php">
<i class="fa fa-money"></i> <span>Sales Report</span>
</a>
</li> 
<li <?php echo $smenuitem27; ?> id="li_31">
<a href="<?php echo $sitename; ?>pages/process/beatwise_report.php">
<i class="fa fa-circle-o"></i>Beat Wise Reports 
</a>
</li>
<li class="treeview <?php echo $tree1; ?>">
<a href="<?php echo $sitename; ?>logout.php">
<i class="fa fa-profile"></i> <span>Logout</span>
</a>
</li> 
<?php } ?>
<li class="treeview <?php echo $tree1; ?>">
<a href="<?php echo $sitename; ?>profile/viewprofile.htm">
<i class="fa fa-user"></i> <span>Edit Profile</span>
</a>
</li> 

</ul>
</section>
<!-- /.sidebar -->
</aside>
