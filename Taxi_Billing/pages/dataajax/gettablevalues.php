<?php

include ('../../config/config.inc.php');



function mres($value) {
    $search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
    $replace = array("\\\\", "\\0", "\\n", "\\r", "\'", '\"', "\\Z");
    return str_replace($search, $replace, $value);
}
if ($_REQUEST['types'] == 'expensetable') {
    $aColumns = array('id', 'type', 'status');
    $sIndexColumn = "id";
    $editpage = ($_REQUEST['db_table_for'] == 'live') ? "editbill" : "editbill";
    $sTable = "expense_type";
}
if ($_REQUEST['types'] == 'triptable') {
    $aColumns = array('id','date','customer_name','driver_name','vehicle_model','grand_total');
    $sIndexColumn = "id";
   // $editpage = ($_REQUEST['db_table_for'] == 'live') ? "editbill" : "editbill";
    $sTable = "trip";
}
if ($_REQUEST['types'] == 'packagetable') {
    $aColumns = array('id','package','status');
    $sIndexColumn = "id";
   // $editpage = ($_REQUEST['db_table_for'] == 'live') ? "editbill" : "editbill";
    $sTable = "package";
}
if ($_REQUEST['types'] == 'citytable') {
    $aColumns = array('id','city','status');
    $sIndexColumn = "id";
   // $editpage = ($_REQUEST['db_table_for'] == 'live') ? "editbill" : "editbill";
    $sTable = "city";
}
if ($_REQUEST['types'] == 'modeltable') {
    $aColumns = array('id','model','status');
    $sIndexColumn = "id";
   // $editpage = ($_REQUEST['db_table_for'] == 'live') ? "editbill" : "editbill";
    $sTable = "model";
}
if ($_REQUEST['types'] == 'gsttable') {
    $aColumns = array('id', 'gst','status');
    $sIndexColumn = "id";
    $editpage = ($_REQUEST['db_table_for'] == 'live') ? "editbill" : "editbill";
    $sTable = "gst";
}
if ($_REQUEST['types'] == 'ordertypetable') {
    $aColumns = array('id', 'ordertype','status');
    $sIndexColumn = "id";
    $editpage = ($_REQUEST['db_table_for'] == 'live') ? "editbill" : "editbill";
    $sTable = "ordertype";
}
if ($_REQUEST['types'] == 'financecustomertbale') {
    $aColumns = array('id','name', 'city','mobileno');
    $sIndexColumn = "id";
    $editpage = ($_REQUEST['db_table_for'] == 'live') ? "editbill" : "editbill";
    $sTable = "customer";
}
if ($_REQUEST['types'] == 'paymentmodetable') {
    $aColumns = array('id', 'paymentmode','status');
    $sIndexColumn = "id";
    $editpage = ($_REQUEST['db_table_for'] == 'live') ? "editbill" : "editbill";
    $sTable = "paymentmode";
}
if ($_REQUEST['types'] == 'salesmantable') {
    $aColumns = array('id','name','mobileno');
    $sIndexColumn = "id";
   // $editpage = ($_REQUEST['db_table_for'] == 'live') ? "editbill" : "editbill";
    $sTable = "salesman";
}

$aColumns1 = $aColumns;

function fatal_error($sErrorMessage = '') {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error');
    die($sErrorMessage);
}

$sLimit = "";

if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
    $sLimit = "LIMIT " . intval($_GET['iDisplayStart']) . ", " . intval($_GET['iDisplayLength']);
}

if($_REQUEST['types']=='invoicetable' || $_REQUEST['types']=='jobtable' || $_REQUEST['types']=='paysliptable'){
    $columnss = ['invoicetable'=>'datetime','jobtable'=>'created_date','paysliptable'=>'date'];
    $sOrder = "ORDER BY `".$columnss[$_REQUEST['types']]."` ASC";
}
else{
    $sOrder = "ORDER BY `$sIndexColumn` DESC";
}

if (isset($_GET['iSortCol_0'])) {
    $sOrder = "ORDER BY  ";
    if (in_array("order", $aColumns)) {
        $sOrder .= "`order` asc, ";
    } else if (in_array("Order", $aColumns)) {
        $sOrder .= "`Order` asc, ";
    }else if($_REQUEST['types']=='invoicetable' || $_REQUEST['types']=='jobtable' || $_REQUEST['types']=='paysliptable'){
        $columnss = ['invoicetable'=>'datetime','jobtable'=>'created_date','paysliptable'=>'date'];
        $sOrder .= "`".$columnss[$_REQUEST['types']]."` DESC, ";
    }
    for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
        if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
            $sOrder .= "`" . $aColumns[intval($_GET['iSortCol_' . $i])] . "` " . ($_GET['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
        }
        $sOrder = substr_replace($sOrder, "", -2);
        if ($sOrder == "ORDER BY ") {
            $sOrder = " ";
        }
    }
}

$sWhere = "";

if ($_REQUEST['types'] == 'invoicetable' || $_REQUEST['types'] == 'jobtable'  || $_REQUEST['types'] == 'paysliptable') {
    if (isset($_GET['status_filter']) && $_GET['status_filter'] != "") {
        if (strtolower($_GET['status_filter']) == '1') {
            $sWhere .= " AND `status`='1'";
        } else if (strtolower($_GET['status_filter']) == '2') {
            if($_REQUEST['types']=='jobtable'){
                $invcd = $db->prepare("SELECT `jobids` FROM `jobinvoice` WHERE `draft`='0'");
                $invcd->execute();
                $ds = [];
                while($finvc = $invcd->fetch()){
                    $ds[] = implode(',',explode(',',$finvc['jobids']));
                }
                if(empty($ds)){ $ds = array('0'); }
                $ds = array_diff($ds,array(''));
                $sWhere .= " AND (`$sIndexColumn` NOT IN (".implode(',', $ds).") AND `status`='2')";
            }else{
                $sWhere .= " AND `status`='2'";
            }
        }else if (strtolower($_GET['status_filter']) == '3') {
            if($_REQUEST['types']=='jobtable'){
                $invcd = $db->prepare("SELECT `jobids` FROM `jobinvoice` WHERE `draft`='0'");
                $invcd->execute();
                $ds = [];
                while($finvc = $invcd->fetch()){
                    $ds[] = implode(',',explode(',',$finvc['jobids']));
                }
                if(empty($ds)){ $ds = array('0'); }
                $ds = array_diff($ds,array(''));
                $sWhere .= " AND (`$sIndexColumn` IN (".implode(',', $ds).") AND `status`='2')";
            }else{
                $sWhere .= " AND `status`='3'";
            }
        }
else if ($_REQUEST['types'] == 'hotelusertable') {
            if ($aColumns1[$i] == $sIndexColumn) 
            {
                $row[] = $k;
            } 
            elseif ($aColumns1[$i] == 'user_profile_photo') 
            {
                $row[] = '<img src="' . $fsitename . 'img/users/thump/' . $aRow[$aColumns1[$i]] . '" style="padding-bottom:10px;" height="100" />';
            } 
            
            elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]]
                        ? "Active"
                        : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        }


        else if (strtolower($_GET['status_filter']) == 'draft') {
            $sWhere .= " AND `draft`='1'";
        }
    }elseif($_GET['status_filter'] == ""){
        
    }    
}
if(($_REQUEST['types'] == 'invoicetable' || $_REQUEST['types'] == 'jobtable') && $_GET['dateRange']!=''){
    $daates = explode(' to ',$_GET['dateRange']);
    $columnss = ['invoicetable'=>'datetime','jobtable'=>'pickup_date'];
    $sWhere .= " AND (DATE(`".$columnss[$_REQUEST['types']]."`) >= '".date("Y-m-d",strtotime($daates[0]))."' AND DATE(`".$columnss[$_REQUEST['types']]."`) <= '".date("Y-m-d",strtotime($daates[1]))."')";
}


if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
    $sWhere .= " AND (";
    for ($i = 0; $i < count($aColumns); $i++) {
        if(($_REQUEST['types']=='invoicetable' || $_REQUEST['types']=='jobtable') && $aColumns[$i]=='customer'){
            $sWhere .= " `customer` IN (SELECT `cid` FROM `customer` WHERE LOWER(`companyname`) LIKE '%".strtolower($_GET['sSearch'])."%') OR";
        }else if(($_REQUEST['types']=='paysliptable' || $_REQUEST['types']=='paycalculationtable') && $aColumns[$i]=='employee'){
            $sWhere .= " `employee` IN (SELECT `did` FROM `driver` WHERE LOWER(`firstname`) LIKE '%".strtolower($_GET['sSearch'])."%') OR";
        }else if($_REQUEST['types']=='jobtable' && $aColumns[$i]=='status'){        
            $jstatus = ["waiting"=>"1","job complete"=>"2","cancelled"=>"3"];            
            //$sWhere .= " `status`='".$jstatus[strtolower($_GET['sSearch'])]."' OR ";
        }else if($_REQUEST['types']=='paysliptable' && $aColumns[$i]=='status'){        
            $jstatus = ["draft"=>"1","payslip"=>"0"];            
            //$sWhere .= " `draft`='".$jstatus[strtolower($_GET['sSearch'])]."' OR ";
        }else if ($_REQUEST['types'] == 'invoicetable' && $aColumns[$i] == 'status') {
            
        }else if ($_REQUEST['types']=='returntable' && $aColumns[$i] == 'status') {
            if (strtolower($_GET['sSearch']) == 'Pawned') {
                $sWhere .= " `status`='1' OR ";
            } elseif (strtolower($_GET['sSearch']) == 'Returned') {
                $sWhere .= " `status`='0' OR ";
            } else {
                $sWhere .= "";
            }
        }else if ($_REQUEST['types']=='bankstatustable' && $aColumns[$i] == 'status') {
            if (strtolower($_GET['sSearch']) == 'Pawned') {
                $sWhere .= " `status`='1' OR ";
            } elseif (strtolower($_GET['sSearch']) == 'Returned') {
                $sWhere .= " `status`='0' OR ";
            } else {
                $sWhere .= "";
            }
        }else if ($aColumns[$i] == 'status') {
            if (strtolower($_GET['sSearch']) == 'active') {
                $sWhere .= " `status`='1' OR ";
            } elseif (strtolower($_GET['sSearch']) == 'inactive') {
                $sWhere .= " `status`='0' OR ";
            } else {
                $sWhere .= "";
            }
        } else {
            $sWhere .= "`" . $aColumns[$i] . "` LIKE '%" . mres($_GET['sSearch']) . "%' OR ";
        }
    }
    $sWhere = substr_replace($sWhere, "", -3);
    $sWhere .= ')';
}

if (($_REQUEST['types'] == 'drivertable') || ($_REQUEST['types'] == 'empcategorytable') || ($_REQUEST['types'] == 'uomtable') || ($_REQUEST['types'] == 'jobtypetable') || ($_REQUEST['types'] == 'customertable') || ($_REQUEST['types'] == 'innercategorytable') || ($_REQUEST['types'] == 'employeegrouptable') || ($_REQUEST['types'] == 'customergrouptable')) {
    $sWhere .= " AND `status`!='2'";
}else if($_REQUEST['types']=='jobtable'){
    $sWhere .= "AND `status`!='4'";
}
else if ($_REQUEST['types'] == 'offerstable') {
  $sWhere .= " `merchant`=".$_SESSION['merchant'];
}
else if($_REQUEST['types']=='onlineorder'){
	if($_SESSION['usertype']=='subuser') {
	 $sWhere .= " AND `createdby`='subuser' AND `created_id`=".$_SESSION['UID'];
	}
}


if ($sWhere != '') {
    $sWhere = "WHERE `$sIndexColumn`!='' $sWhere";
}
if ($_REQUEST['types'] == 'paycalculationtable') {
    $sWheree = ($sWhere!='') ? ' AND ' : ' WHERE ';
    $sWhere .= " $sWheree `subject`='Worker Charge' GROUP BY `employee`";
}




$sQuery = "SELECT SQL_CALC_FOUND_ROWS `" . str_replace(",", "`,`", implode(",", $aColumns)) . "` FROM $sTable $sWhere $sOrder $sLimit ";

$rResult = $db->prepare($sQuery);
$rResult->execute();


$sQuery = "SELECT FOUND_ROWS()";

$rResultFilterTotal = $db->prepare($sQuery);
$rResultFilterTotal->execute();

$aResultFilterTotal = $rResultFilterTotal->fetch();
$iFilteredTotal = $aResultFilterTotal[0];

$sQuery = "SELECT COUNT(" . $sIndexColumn . ") FROM $sTable";
$rResultTotal = $db->prepare($sQuery);
$rResultTotal->execute();

$aResultTotal = $rResultTotal->fetch();
$iTotal = $aResultTotal[0];

$output = array(
    "sEcho" => intval($_GET['sEcho']),
    "iTotalRecords" => $iTotal,
    "iTotalDisplayRecords" => $iFilteredTotal,
    "aaData" => array()
);

$ij = 1;
$k = $_GET['iDisplayStart'];

while ($aRow = $rResult->fetch(PDO::FETCH_ASSOC)) {
    $k++;
    $row = array();
    $row1 = '';
    for ($i = 0; $i < count($aColumns1); $i++) {
        if ($_REQUEST['types'] == 'drivertable') {

            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'title') {
                $row1 .= $aRow[$aColumns1[$i]] . ' ';
            } elseif ($aColumns1[$i] == 'firstname') {
                $row1 .= $aRow[$aColumns1[$i]] . ' ';
            } elseif ($aColumns1[$i] == 'lastname') {
                $row1 .= $aRow[$aColumns1[$i]];
                $row[] = $row1;
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        } 
        else if ($_REQUEST['types'] == 'triptable') {
             if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'customer_name') {
                $row[] = getcustomer('name',$aRow[$aColumns1[$i]]);
            } elseif ($aColumns1[$i] == 'vehicle_model') {
                $row[] = getmodel('model',$aRow[$aColumns1[$i]]);
            }
            elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        }

        else {
            if ($aColumns1[$i] == $sIndexColumn) {
                $row[] = $k;
            } elseif ($aColumns1[$i] == 'Status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } elseif ($aColumns1[$i] == 'status') {
                $row[] = $aRow[$aColumns1[$i]] ? "Active" : "Inactive";
            } else {
                $row[] = $aRow[$aColumns1[$i]];
            }
        }
    }
    
     /* View page  change start here */

    if ($_REQUEST['types'] == 'product1table') {
        $row[] = "<i class='fa fa-eye' onclick='javascript:viewthis(" . $aRow[$sIndexColumn] . ");' style='cursor:pointer;'> View</i>";
    } elseif (($_REQUEST['types'] != 'modeltable') && ($_REQUEST['types'] != 'triptable') && ($_REQUEST['types'] != 'packagetable') && ($_REQUEST['types'] != 'paymentmodetable') && ($_REQUEST['types'] != 'ordertypetable') && ($_REQUEST['types'] != 'gsttable') && ($_REQUEST['types'] != 'storeorder') &&  ($_REQUEST['types'] != 'objecttable1') &&  ($_REQUEST['types'] != 'expensetable') && ($_REQUEST['types'] != 'unittable') && ($_REQUEST['types'] != 'subcategorytable') && ($_REQUEST['types'] != 'categoriestable') && ($_REQUEST['types'] != 'beattable') && ($_REQUEST['types'] != 'beatsalesmantable') && ($_REQUEST['types'] != 'hotelusertable') && ($_REQUEST['types'] != 'objecttable') && (($_REQUEST['types'] != 'financecustomertbale') && ($_REQUEST['types'] != 'salesmantable') && ($_REQUEST['types'] != 'returntable') && ($_REQUEST['types'] != 'billtable') && ($_REQUEST['types'] != 'bankstatustable') && ($_REQUEST['types'] != 'suppliertable') && ($_REQUEST['types'] != 'salestable') && ($_REQUEST['types'] != 'silverobjecttable'))) {
        $row[] = "<i class='fa fa-eye' onclick='javascript:viewthis(" . $aRow[$sIndexColumn] . ");' style='cursor:pointer;'> </i>";
    }

     /* Edit page  change start here */
//    if ($_REQUEST['types'] == 'product1table') {
//        $row[] = "<i class='fa fa-edit' onclick='javascript:editthis(" . $aRow[$sIndexColumn] . ");' style='cursor:pointer;'> Edit</i>";
//    } elseif (($_REQUEST['types'] != 'newslettertable') && ($_REQUEST['types'] != 'gifttable' && ($_REQUEST['types'] != 'appointmenttable') && ($_REQUEST['types'] != 'contacttable') && ($_REQUEST['types'] != 'serviceenquirytable')  && ($_REQUEST['types'] != 'registertable') && ($_REQUEST['types'] != 'ordertable') )) {
//       $row[] = "<i class='md md-edit' onclick='javascript:editthis(" . $aRow[$sIndexColumn] . ");' style='cursor:pointer;'> </i>";
//    }
    
    
    /* Edit page  change start here */
    if ($_REQUEST['types'] == 'producttable') {
        $row[] = "<a href='" . $sitename . "products/" . $aRow[$sIndexColumn] . "/editproduct.htm' target='_blank' style='cursor:pointer;'><i class='fa fa-edit' ></i> Edit</a>";
    } else if ($_REQUEST['types'] == 'billtable') {
        $row[] = "<i class='fa fa-refresh' onclick='reset(" . $aRow[$sIndexColumn] . ");' style='cursor:pointer;'></i>";
        $row[] = "<i class='fa fa-edit' onclick='javascript:editthis(" . $aRow[$sIndexColumn] . ");' style='cursor:pointer;'></i>";
    } elseif (($_REQUEST['types'] == 'contacttable') || ($_REQUEST['types'] == 'paycalculationtable') || ($_REQUEST['types'] == 'paysliptable')) {
        if($_REQUEST['types']=='paysliptable'){
            $row[] = "<a class='btn btn-info' title='Print' style='padding: 3px 9px;float:left;' href='".$sitename."MPDF/invoice/payslip.php?id=".$aRow[$sIndexColumn]."' target='_blank'><i class='fa fa-print' style='cursor:pointer;'></i></a>
                    <a class='btn btn-info' title='Send Mail' onclick='sendMails(\"".$aRow[$sIndexColumn]."\")' style='padding: 3px 9px;float:left;margin-left:5px;' href='#'><i class='fa fa-envelope' style='cursor:pointer;'></i></a>";            
        }
        $row[] = "<i class='fa fa-eye' onclick='javascript:editthis(" . $aRow[$sIndexColumn] . ");' style='cursor:pointer;'> </i>";
    } else {       
       if(($_REQUEST['types'] != 'salesorder') &&  ($_REQUEST['types'] != 'onlineorder') && ($_REQUEST['types'] != 'salesreturn')  && ($_REQUEST['types'] != 'purchasetable') && ($_REQUEST['types'] != 'purchaseordertable') && ($_REQUEST['types'] != 'purchasereturntable')) {

        $row[] = "<i class='fa fa-edit' onclick='javascript:editthis(" . $aRow[$sIndexColumn] . ");' style='cursor:pointer;'> Edit </i>";
    }
         if($_REQUEST['types']=='invoicetable'){
            $row[] = "<a class='btn btn-info' title='Print' style='padding: 3px 9px;float:left;' href='".$sitename."MPDF/invoice/invoice.php?id=".$aRow[$sIndexColumn]."' target='_blank'><i class='fa fa-print' style='cursor:pointer;'></i></a>
                    <a class='btn btn-info' title='Send Mail' onclick='$(\"#Conatct_Persons_Modal\").modal(\"show\"); show_contacts(\"".$aRow['customer']."\",\"".$aRow[$sIndexColumn]."\");' style='padding: 3px 9px;float:left;margin-left:5px;' href='#'><i class='fa fa-envelope' style='cursor:pointer;'></i></a>";            
        }
    }
    $row[] = '<input type="checkbox"  name="chk[]" id="chk[]" value="' . $aRow[$sIndexColumn] . '" '.$data_invoiced.' '.$data_customer.' />';


    $output['aaData'][] = $row;
    $ij++;
}

echo json_encode($output);
?>
 
