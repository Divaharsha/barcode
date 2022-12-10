<?php
session_start();

// set time for session timeout
$currentTime = time() + 25200;
$expired = 3600;

// if session not set go to login page
if (!isset($_SESSION['user'])) {
    header("location:index.php");
}

// if current time is more than session timeout back to login page
if ($currentTime > $_SESSION['timeout']) {
    session_destroy();
    header("location:index.php");
}

// destroy previous session timeout and create new one
unset($_SESSION['timeout']);
$_SESSION['timeout'] = $currentTime + $expired;

header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


include_once('../includes/custom-functions.php');
$fn = new custom_functions;
include_once('../includes/crud.php');
include_once('../includes/variables.php');
$db = new Database();
$db->connect();
$config = $fn->get_configurations();
$low_stock_limit = $config['low-stock-limit'];

if (isset($config['system_timezone']) && isset($config['system_timezone_gmt'])) {
    date_default_timezone_set($config['system_timezone']);
    $db->sql("SET `time_zone` = '" . $config['system_timezone_gmt'] . "'");
} else {
    date_default_timezone_set('Asia/Kolkata');
    $db->sql("SET `time_zone` = '+05:30'");
}


//goldsmith master table goes here
if (isset($_GET['table']) && $_GET['table'] == 'goldsmith_master') {
    $offset = 0;
    $limit = 10;
    $where = '';
    $sort = 'id';
    $order = 'DESC';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($_GET['offset']);
    if (isset($_GET['limit']))
        $limit = $db->escapeString($_GET['limit']);
    if (isset($_GET['sort']))
        $sort = $db->escapeString($_GET['sort']);
    if (isset($_GET['order']))
        $order = $db->escapeString($_GET['order']);

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($_GET['search']);
        $where .= "WHERE gm.name like '%" . $search . "%' OR gm.id like '%" . $search . "%' OR gm.goldsmith_type like '%" . $search . "%' OR gm.place like '%" . $search . "%' OR gm.shop_type like '%" . $search . "%'";
    }
    if (isset($_GET['sort'])){
        $sort = $db->escapeString($_GET['sort']);
    }
    if (isset($_GET['order'])){
        $order = $db->escapeString($_GET['order']);
    }
    $sql = "SELECT COUNT(`id`) as total FROM `goldsmith_master` gm" .$where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];
   
    $sql = "SELECT * FROM `goldsmith_master` gm
    $where ORDER BY $sort $order LIMIT $offset, $limit";   
     $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        
        $operate = ' <a href="edit-goldsmithmaster.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $update_touch = '<a href="update-touch.php?id=' . $row['id'] . '" class="label label-primary" title="View">Update Touch</a>';
        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $tempRow['goldsmith_type'] = $row['goldsmith_type'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['digital_signature_number'] = $row['digital_signature_number'];
        $tempRow['gst_number'] = $row['gst_number'];
        $tempRow['pan_number'] = $row['pan_number'];
        $tempRow['open_cash_debit'] = $row['open_cash_debit'];
        $tempRow['open_cash_credit'] = $row['open_cash_credit'];
        $tempRow['open_pure_debit'] = $row['open_pure_debit'];
        $tempRow['open_pure_credit'] = $row['open_pure_credit'];
        $tempRow['email'] = $row['email'];
        $tempRow['address'] = $row['address'];
        $tempRow['place'] = $row['place'];
        $tempRow['shop_type'] = $row['shop_type'];
        $tempRow['operate'] = $operate;
        $tempRow['update_touch'] = $update_touch;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

//suspense account table goes here
if (isset($_GET['table']) && $_GET['table'] == 'suspense_account') {

    $offset = 0;
    $limit = 10;
    $where = '';
    $sort = 'id';
    $order = 'DESC';
    if (isset($_GET['type']) && $_GET['type'] != '') {
        $type = $db->escapeString($fn->xss_clean($_GET['type']));
        $where .= " WHERE type = '$type' ";
    }
    if (isset($_GET['offset']))
        $offset = $db->escapeString($_GET['offset']);
    if (isset($_GET['limit']))
        $limit = $db->escapeString($_GET['limit']);
    if (isset($_GET['sort']))
        $sort = $db->escapeString($_GET['sort']);
    if (isset($_GET['order']))
        $order = $db->escapeString($_GET['order']);

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($_GET['search']);
        $where .= "WHERE type like '%" . $search . "%' OR name like '%" . $search . "%'";
    }
    if (isset($_GET['sort'])){
        $sort = $db->escapeString($_GET['sort']);
    }
    if (isset($_GET['order'])){
        $order = $db->escapeString($_GET['order']);
    }
    $sql = "SELECT COUNT(`id`) as total FROM `suspense_account` ";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];
   
    $sql = "SELECT * FROM suspense_account $where ORDER BY $sort $order LIMIT $offset,$limit";
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $id = $row['id'];
        
        if($type == 'Weight'){
            $operate = ' <a href="edit-suspense.php?name=' . $row['holder_name'] . '"><i class="fa fa-edit"></i>Edit</a>';
            $sql = "SELECT SUM(weight) AS inwardtotal FROM suspense_account_variant WHERE suspense_account_id = '$id' AND method = 'Inward'";
            $db->sql($sql);
            $invardres = $db->getResult();
            $num = $db->numRows($invardres);
            if($num > 0) {
                $invtotal = $invardres[0]['inwardtotal'];
    
            }
            else{
                $invtotal = 0;
                
            }
            $sql = "SELECT SUM(weight) AS outwardtotal FROM suspense_account_variant WHERE suspense_account_id = '$id' AND method = 'Outward'";
            $db->sql($sql);
            $outvardres = $db->getResult();
            $num = $db->numRows($outvardres);
            if($num > 0) {
                $outvtotal = $outvardres[0]['outwardtotal'];
    
            }
            else{
                $outvtotal = 0;
                
            }
                        

        }
        else{
            $operate = ' <a href="edit-suspense-cash.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
            $sql = "SELECT * FROM suspense_account_cash WHERE suspense_account_id = '$id'";
            $db->sql($sql);
            $res = $db->getResult();
            $invtotal = $res[0]['inward'];
            $outvtotal = $res[0]['outward'];

        }
        $total = $invtotal - $outvtotal;


        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['holder_name'];
        $tempRow['total'] = $total;
        $tempRow['finaltotal'] = $total;
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}



// data of 'Fund Transfer' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'unit') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && $_GET['search'] != '') {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where = " Where `id` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `short_code` like '%" . $search . "%' OR `conversion` like '%" . $search . "%' ";
    }

    $sql = "SELECT COUNT(`id`) as total FROM `unit` $where";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `unit` $where ORDER BY $sort $order LIMIT $offset,$limit";
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = ' <a href="edit-unit.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $tempRow['short_code'] = $row['short_code'];
        $tempRow['parent_id'] = $row['parent_id'];
        $tempRow['conversion'] = $row['conversion'];
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}


if (isset($_GET['table']) && $_GET['table'] == 'time-slots') {

    $offset = 0;
    $limit = 10;
    $sort = 'last_order_time';
    $order = 'ASC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && $_GET['search'] != '') {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where = " Where `id` like '%" . $search . "%' OR `title` like '%" . $search . "%' OR `from_time` like '%" . $search . "%' OR `to_time` like '%" . $search . "%' OR `last_order_time` like '%" . $search . "%'";
    }

    $sql = "SELECT COUNT(*) as total FROM `time_slots` " . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `time_slots` " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        $operate = "<a class='btn btn-xs btn-primary edit-time-slot' data-id='" . $row['id'] . "' data-toggle='modal' data-target='#editTimeSlotModal' title='Edit'><i class='fa fa-pencil-square-o'></i></a>";
        $operate .= " <a class='btn btn-xs btn-danger delete-time-slot' data-id='" . $row['id'] . "' title='Delete'><i class='fa fa-trash-o'></i></a>";
        $tempRow['id'] = $row['id'];
        $tempRow['title'] = $row['title'];
        $tempRow['from_time'] = $row['from_time'];
        $tempRow['to_time'] = $row['to_time'];
        $tempRow['last_order_time'] = $row['last_order_time'];
        if ($row['status'] == 0)
            $tempRow['status'] = "<label class='label label-danger'>Deactive</label>";
        else
            $tempRow['status'] = "<label class='label label-success'>Active</label>";
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'Promo Codes' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'system-users') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'ASC';
    $where = '';
    $condition = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && $_GET['search'] != '') {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where = " Where `id` like '%" . $search . "%' OR `username` like '%" . $search . "%' OR `email` like '%" . $search . "%' OR `role` like '%" . $search . "%' OR `date_created` like '%" . $search . "%'";
    }
    if ($_SESSION['role'] != 'super admin') {
        if (empty($where)) {
            $condition .= ' where created_by=' . $_SESSION['id'];
        } else {
            $condition .= ' and created_by=' . $_SESSION['id'];
        }
    }

    $sql = "SELECT COUNT(id) as total FROM `admin`" . $where . "" . $condition;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `admin`" . $where . "" . $condition . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        if ($row['created_by'] != 0) {
            $sql = "SELECT username FROM admin WHERE id=" . $row['created_by'];
            $db->sql($sql);
            $created_by = $db->getResult();
        }

        if ($row['role'] != 'super admin') {
            $operate = "<a class='btn btn-xs btn-primary edit-system-user' data-id='" . $row['id'] . "' data-toggle='modal' data-target='#editSystemUserModal' title='Edit'><i class='fa fa-pencil-square-o'></i></a>";
            $operate .= " <a class='btn btn-xs btn-danger delete-system-user' data-id='" . $row['id'] . "' title='Delete'><i class='fa fa-trash-o'></i></a>";
        } else {
            $operate = '';
        }
        if ($row['role'] == 'super admin') {
            $role = '<span class="label label-success">Super Admin</span>';
        }
        if ($row['role'] == 'admin') {
            $role = '<span class="label label-primary">Admin</span>';
        }
        if ($row['role'] == 'editor') {
            $role = '<span class="label label-warning">Editor</span>';
        }
        $tempRow['id'] = $row['id'];
        $tempRow['username'] = $row['username'];
        $tempRow['email'] = $row['email'];
        $tempRow['permissions'] = $row['permissions'];
        $tempRow['role'] = $role;
        $tempRow['created_by_id'] = $row['created_by'] != 0 ? $row['created_by'] : '-';
        $tempRow['created_by'] = $row['created_by'] != 0 ? $created_by[0]['username'] : '-';
        $tempRow['date_created'] = date('d-m-Y h:i:sa', strtotime($row['date_created']));
        $tempRow['operate'] = $operate;

        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

if (isset($_GET['table']) && $_GET['table'] == 'daily_transaction') {

    $offset = 0;
    $limit = 10;
    $where = '';
    $sort = 'id';
    $order = 'DESC';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($_GET['offset']);
    if (isset($_GET['limit']))
        $limit = $db->escapeString($_GET['limit']);
    if (isset($_GET['sort']))
        $sort = $db->escapeString($_GET['sort']);
    if (isset($_GET['order']))
        $order = $db->escapeString($_GET['order']);

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($_GET['search']);
        $where .= "WHERE dt.id like '%" . $search . "%' OR gm.name like '%" . $search . "%' OR dt.type like '%" . $search . "%'  OR dt.amount like '%" . $search . "%' OR dt.category like '%" . $search . "%'";
    }
    if (isset($_GET['sort'])){
        $sort = $db->escapeString($_GET['sort']);
    }
    if (isset($_GET['order'])){
        $order = $db->escapeString($_GET['order']);
    }

    $join = "LEFT JOIN `goldsmith_master` gm ON dt.goldsmith_master_id = gm.id LEFT JOIN `subcategories` s ON dt.subcategory_id = s.id";

    $sql = "SELECT COUNT(*) as total FROM `daily_transaction` dt  $join " . $where . "";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];
   
    $sql = "SELECT dt.id AS id,dt.*,gm.name AS goldsmith_master_name,s.name AS subcategory FROM `daily_transaction` dt $join 
    $where ORDER BY $sort $order LIMIT $offset, $limit";  
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        $operate= '<a href="edit-dailytransaction.php?id=' . $row['id'] . '" ><i class="fa fa-edit" ></i>Edit</a>';
        //$operate .= '<a href="view-daily_transaction.php?id=' . $row['id'] . '" class="btn btn-primary btn-xs" style="margin-left:5px;!important">View</a>';
        $tempRow['id'] = $row['id'];
        $tempRow['goldsmith_master_name'] = $row['goldsmith_master_name'];
        $tempRow['date'] = $row['date'];
        $tempRow['type'] = $row['type'];
        $tempRow['subcategory'] = $row['subcategory'];
        $tempRow['weight'] = $row['weight'];
        $tempRow['stone_weight'] = $row['stone_weight'];
        $tempRow['wastage'] = $row['wastage'];
        $tempRow['touch'] = $row['touch'];
        $tempRow['rate'] = $row['rate'];
        $tempRow['gst'] = $row['gst'];
        $tempRow['amount'] = $row['amount'];
        $tempRow['mc'] = $row['mc'];
        $tempRow['purity'] = $row['purity'];
        $tempRow['rate_method'] = $row['rate_method'];
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}
if (isset($_GET['table']) && $_GET['table'] == 'dealer_daily_transaction') {

    $offset = 0;
    $limit = 10;
    $where = '';
    $sort = 'id';
    $order = 'DESC';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($_GET['offset']);
    if (isset($_GET['limit']))
        $limit = $db->escapeString($_GET['limit']);
    if (isset($_GET['sort']))
        $sort = $db->escapeString($_GET['sort']);
    if (isset($_GET['order']))
        $order = $db->escapeString($_GET['order']);

    if (isset($_GET['goldsmith_master_id'])) {
        $goldsmith_master_id = $db->escapeString($fn->xss_clean($_GET['goldsmith_master_id']));
        $where .= " WHERE goldsmith_master_id = '$goldsmith_master_id' ";
    }
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($_GET['search']);
        $where .= "AND type like '%" . $search . "%' OR category like '%" . $search . "%'";
    }
    if (isset($_GET['sort'])){
        $sort = $db->escapeString($_GET['sort']);
    }
    if (isset($_GET['order'])){
        $order = $db->escapeString($_GET['order']);
    }

    $sql = "SELECT COUNT(`id`) as total FROM `daily_transaction` ";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];
   
    $sql = "SELECT * FROM daily_transaction " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        $operate= '<a href="edit-dailytransaction.php?id=' . $row['id'] . '" ><i class="fa fa-edit" ></i>Edit</a>';
        //$operate .= '<a href="view-daily_transaction.php?id=' . $row['id'] . '" class="btn btn-primary btn-xs" style="margin-left:5px;!important">View</a>';
        $tempRow['id'] = $row['id'];
        $tempRow['goldsmith_master_id'] = $row['goldsmith_master_id'];
        $tempRow['date'] = $row['date'];
        $tempRow['type'] = $row['type'];
        $tempRow['category'] = $row['category'];
        $tempRow['weight'] = $row['weight'];
        $tempRow['stone_weight'] = $row['stone_weight'];
        $tempRow['wastage'] = $row['wastage'];
        $tempRow['touch'] = $row['touch'];
        $tempRow['rate'] = $row['rate'];
        $tempRow['gst'] = $row['gst'];
        $tempRow['amount'] = $row['amount'];
        $tempRow['mc'] = $row['mc'];
        $tempRow['purity'] = $row['purity'];
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

//transactionregister table goes here
if (isset($_GET['table']) && $_GET['table'] == 'transactionregister') {

    $offset = 0;
    $limit = 10;
    $where = '';
    $sort = 'id';
    $order = 'DESC';

    if (isset($_GET['type']) && $_GET['type'] != '') {
        $type = $db->escapeString($fn->xss_clean($_GET['type']));
        $where .= " AND type = '$type' ";
    }
    if (isset($_GET['gm_id']) && $_GET['gm_id'] != '') {
        $gm_id = $db->escapeString($fn->xss_clean($_GET['gm_id']));
        $where .= " AND dt.goldsmith_master_id	 = $gm_id";
    }
    if (isset($_GET['particular']) && $_GET['particular'] != '') {
        $particular = $db->escapeString($fn->xss_clean($_GET['particular']));
        $where .= " AND dt.category	 = '$particular'";
    }
    if (isset($_GET['place']) && $_GET['place'] != '') {
        $place = $db->escapeString($fn->xss_clean($_GET['place']));
        $where .= " AND gm.place = '$place'";
    }
    if ((isset($_GET['fromdate']) && $_GET['fromdate'] != '') && (isset($_GET['todate']) && $_GET['todate'] != '')) {
        $fromdate = $db->escapeString($fn->xss_clean($_GET['fromdate']));
        $todate = $db->escapeString($fn->xss_clean($_GET['todate']));
        $where .= " AND date >= '$fromdate' and date < '$todate'";
    }

    if (isset($_GET['offset']))
        $offset = $db->escapeString($_GET['offset']);
    if (isset($_GET['limit']))
        $limit = $db->escapeString($_GET['limit']);
    if (isset($_GET['sort']))
        $sort = $db->escapeString($_GET['sort']);
    if (isset($_GET['order']))
        $order = $db->escapeString($_GET['order']);

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($_GET['search']);
        $where .= "WHERE dt.type like '%" . $search . "%' OR gm.name like '%" . $search . "%'";
    }
    if (isset($_GET['sort'])){
        $sort = $db->escapeString($_GET['sort']);
    }
    if (isset($_GET['order'])){
        $order = $db->escapeString($_GET['order']);
    }
    $sql = "SELECT COUNT(*) as total FROM `daily_transaction` dt,`goldsmith_master` gm WHERE dt.goldsmith_master_id	 = gm.id" . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];
   
    $sql = "SELECT *,dt.id AS id FROM daily_transaction dt,goldsmith_master gm WHERE dt.goldsmith_master_id	 = gm.id" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

    
        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $tempRow['date'] = $row['date'];
        $tempRow['type'] = $row['type'];
        $tempRow['category'] = $row['category'];
        $tempRow['weight'] = $row['weight'];
        $tempRow['stone_weight'] = $row['stone_weight'];
        $tempRow['wastage'] = $row['wastage'];
        $tempRow['touch'] = $row['touch'];
        $tempRow['rate'] = $row['rate'];
        $tempRow['gst'] = $row['gst'];
        $tempRow['amount'] = $row['amount'];
        $tempRow['mc'] = $row['mc'];
        $tempRow['purity'] = $row['purity'];
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

if (isset($_GET['table']) && $_GET['table'] == 'dealerledger') {

    $offset = 0;
    $limit = 10;
    $where = '';
    $sort = 'id';
    $order = 'DESC';
    
    if (isset($_GET['sundry']) && $_GET['sundry'] != '') {
        $sundry = $db->escapeString($fn->xss_clean($_GET['sundry']));
        $where .= "WHERE sundry = '$sundry' ";
    }

     


   
    $sql = "SELECT COUNT(`id`) as total FROM `goldsmith_master` "  . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];
   
    $sql = "SELECT * FROM goldsmith_master "  . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a href="dealerdailytransactions.php?id=' . $row['id'] . '" class="btn btn-primary btn-xs" style="margin-left:5px;!important">View</a>';
        

        
       
        $tempRow['name'] = $row['name'];
        $tempRow['sundry'] = $row['sundry'];
        $tempRow['open_debit'] = $row['open_debit'];
        $tempRow['open_credit'] = $row['open_credit'];
        $tempRow['pure_debit'] = $row['pure_debit'];
        $tempRow['pure_credit'] = $row['pure_credit'];
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

//areawise dealerledger report goes here
if (isset($_GET['table']) && $_GET['table'] == 'areawiseledger') {

    $offset = 0;
    $limit = 10;
    $where = '';
    $sort = 'id';
    $order = 'DESC';
    if (isset($_GET['offset']))
    $offset = $db->escapeString($_GET['offset']);
    if (isset($_GET['limit']))
        $limit = $db->escapeString($_GET['limit']);
    if (isset($_GET['sort']))
        $sort = $db->escapeString($_GET['sort']);
    if (isset($_GET['order']))
        $order = $db->escapeString($_GET['order']);

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($_GET['search']);
        $where .= "AND place like '%" . $search . "%'";
    }
    if (isset($_GET['sort'])){
        $sort = $db->escapeString($_GET['sort']);
    }
    if (isset($_GET['order'])){
        $order = $db->escapeString($_GET['order']);
    }

    $sql = "SELECT COUNT(`id`) as total FROM `goldsmith_master` ";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];
   
    $sql = "SELECT * FROM goldsmith_master WHERE place != '' ". $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        
        $operate= '<a href="dealerledgerreport.php?id=' . $row['id'] . '" class="label label-primary" title="View">View</a>';
        $tempRow['place'] = $row['place'];
        $tempRow['open_debit'] = $row['open_debit'];
        $tempRow['open_credit'] = $row['open_credit'];
        $tempRow['pure_debit'] = $row['pure_debit'];
        $tempRow['pure_credit'] = $row['pure_credit'];
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

//categories
if (isset($_GET['table']) && $_GET['table'] == 'categories') {

    $offset = 0;
    $limit = 10;
    $where = '';
    $sort = 'id';
    $order = 'DESC';
    if (isset($_GET['offset']))
    $offset = $db->escapeString($_GET['offset']);
    if (isset($_GET['limit']))
    $limit = $db->escapeString($_GET['limit']);
    if (isset($_GET['sort']))
    $sort = $db->escapeString($_GET['sort']);
    if (isset($_GET['order']))
    $order = $db->escapeString($_GET['order']);

    if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $db->escapeString($_GET['search']);
    $where .= "WHERE name like '%" . $search . "%' OR id like '%" . $search . "%'";
    }
    if (isset($_GET['sort'])){
    $sort = $db->escapeString($_GET['sort']);
    }
    if (isset($_GET['order'])){
    $order = $db->escapeString($_GET['order']);
    }
    $sql = "SELECT COUNT(`id`) as total FROM `categories` ";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
           $total = $row['total'];

    $sql = "SELECT * FROM categories " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;

    $rows = array();
    $tempRow = array();

   foreach ($res as $row) {


        $operate = ' <a href="edit-category.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
        }
        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
}

//sub-categories
if (isset($_GET['table']) && $_GET['table'] == 'sub_categories') {

    $offset = 0;
    $limit = 10;
    $where = '';
    $sort = 'id';
    $order = 'DESC';
    if (isset($_GET['offset']))
    $offset = $db->escapeString($_GET['offset']);
    if (isset($_GET['limit']))
    $limit = $db->escapeString($_GET['limit']);
    if (isset($_GET['sort']))
    $sort = $db->escapeString($_GET['sort']);
    if (isset($_GET['order']))
    $order = $db->escapeString($_GET['order']);

    if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $db->escapeString($_GET['search']);
    $where .= "AND s.name like '%" . $search . "%' OR s.id like '%" . $search . "%' OR c.name like '%" . $search . "%' ";
    }
    if (isset($_GET['sort'])){
    $sort = $db->escapeString($_GET['sort']);
    }
    if (isset($_GET['order'])){
    $order = $db->escapeString($_GET['order']);
    }
    $sql = "SELECT COUNT(s.id) as total FROM `subcategories` s " . $where . "";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
           $total = $row['total'];

    $sql = "SELECT s.*,s.id AS id,c.name AS category_name FROM `subcategories` s,`categories` c  WHERE s.category_id=c.id" . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;

    $rows = array();
    $tempRow = array();

   foreach ($res as $row) {


        $operate = ' <a href="edit-sub_category.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $tempRow['id'] = $row['id'];
        $tempRow['category_name'] = $row['category_name'];
        $tempRow['name'] = $row['name'];
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
        }
        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
}

//products
if (isset($_GET['table']) && $_GET['table'] == 'products') {
    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';

    if (isset($_GET['status']) && $_GET['status'] != '') {
        $status = $db->escapeString($fn->xss_clean($_GET['status']));
        $where .= "AND p.status = '$status' ";
    }
    if (isset($_GET['offset']))
    $offset = $db->escapeString($_GET['offset']);
    if (isset($_GET['limit']))
    $limit = $db->escapeString($_GET['limit']);
    if (isset($_GET['sort']))
    $sort = $db->escapeString($_GET['sort']);
    if (isset($_GET['order']))
    $order = $db->escapeString($_GET['order']);

    if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $db->escapeString($_GET['search']);
    $where .= "AND p.id like '%" . $search . "%' OR g.name like '%" . $search . "%' OR s.name like '%" . $search . "%'  OR p.size like '%" . $search . "%'  OR p.huid_number like '%" . $search . "%' ";
    }

    if (isset($_GET['sort'])) {
        $sort = $db->escapeString($_GET['sort']);
    }
    if (isset($_GET['order'])) {
        $order = $db->escapeString($_GET['order']);
    }
    
    $join = "LEFT JOIN `subcategories` s ON p.subcategory_id = s.id LEFT JOIN `goldsmith_master` g ON g.id = p.goldsmith_id WHERE p.id IS NOT NULL ";

    $sql = "SELECT COUNT(p.id) as `total` FROM `products` p $join " . $where . "";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
           $total = $row['total'];
    $sql = "SELECT p.id AS id,p.*,s.name AS subcategory_name,g.name AS goldsmith_name  
            FROM `products` p 
            $join 
            $where ORDER BY $sort $order LIMIT $offset, $limit"; 
    $db->sql($sql);
    $res = $db->getResult();
    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

   foreach ($res as $row) {


        $update = ' <a href="edit-product.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $update .= '<a  href="delete-product.php?id=' . $row['id'] . '" <i class="fa fa-trash text text-danger"></i>Delete</a>';
        $operate = '<a href="view-product.php?id=' . $row['id'] . '" class="label label-primary" title="View">View</a>';
        $tempRow['id'] = $row['id'];
        $tempRow['subcategory_name'] = $row['subcategory_name'];
        $tempRow['goldsmith_name'] = $row['goldsmith_name'];
        $tempRow['huid_number'] = $row['huid_number'];
        $tempRow['gross_weight'] = $row['gross_weight'];
        $tempRow['size'] = $row['size'];
        $tempRow['stone_weight'] = $row['stone_weight'];
        $tempRow['net_weight'] = $row['net_weight'];
        $tempRow['wastage'] = $row['wastage'];
        $tempRow['cover_weight'] = $row['cover_weight'];
        if(!empty($row['image'])){
            $tempRow['image'] = "<a data-lightbox='category' href='" . $row['image'] . "' data-caption='" . $row['image'] . "'><img src='" . $row['image'] . "' title='" . $row['image'] . "' height='50' /></a>";

        }else{
            $tempRow['image'] = 'No Image';

        }
        if ($row['status'] == 1)
        $tempRow['status'] = "<label class='label label-success'>Approved</label>";
         else
        $tempRow['status'] = "<label class='label label-danger'>Not-Approved</label>";
        $tempRow['operate'] = $operate;
        $tempRow['update'] = $update;
        $rows[] = $tempRow;
        }
        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
}

$db->disconnect();