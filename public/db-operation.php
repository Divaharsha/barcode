<?php
session_start();
// include_once('../api-firebase/send-email.php');
include('../includes/crud.php');
$db = new Database();
$db->connect();
$db->sql("SET NAMES 'utf8'");
$auth_username = $db->escapeString($_SESSION["user"]);

include_once('../includes/custom-functions.php');
$fn = new custom_functions;
include_once('../includes/functions.php');
$function = new functions;
$config = $fn->get_configurations();
$time_slot_config = $fn->time_slot_config();
if (isset($config['system_timezone']) && isset($config['system_timezone_gmt'])) {
    date_default_timezone_set($config['system_timezone']);
    $db->sql("SET `time_zone` = '" . $config['system_timezone_gmt'] . "'");
} else {
    date_default_timezone_set('Asia/Kolkata');
    $db->sql("SET `time_zone` = '+05:30'");
}

//transaction row delete

if (isset($_POST['delete_variant'])) {
    $v_id = $db->escapeString(($_POST['id']));
    $sql = "DELETE FROM daily_transaction WHERE id = $v_id";
    $db->sql($sql);
    $result = $db->getResult();
    if ($result) {
        echo 1;
    } else {
        echo 0;
    }
}






















function checkadmin($auth_username)
{
    $db = new Database();
    $db->connect();
    $db->sql("SELECT `username` FROM `admin` WHERE `username`='$auth_username' LIMIT 1");
    $res = $db->getResult();
    if (!empty($res)) {

        return true;
    } else {
        return false;
    }
}
if (defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) {
    echo '<label class="alert alert-danger">This operation is not allowed in demo panel!.</label>';
    return false;
}




if (isset($_POST['system_configurations'])) {
    $date = $db->escapeString(date('Y-m-d'));
    $currency = empty($_POST['currency']) ? '₹' : $db->escapeString($fn->xss_clean($_POST['currency']));
    $sql = "UPDATE `settings` SET `value`='" . $currency . "' WHERE `variable`='currency'";
    $db->sql($sql);
    $message = "<div class='alert alert-success'> Settings updated successfully!</div>";
    $_POST['system_timezone_gmt'] = (trim($_POST['system_timezone_gmt']) == '00:00') ? "+" . trim($db->escapeString($fn->xss_clean($_POST['system_timezone_gmt']))) : $db->escapeString($fn->xss_clean($_POST['system_timezone_gmt']));

    if (preg_match("/[a-z]/i", $db->escapeString($fn->xss_clean($_POST['current_version'])))) {
        $_POST['current_version'] = 0;
    }
    if (preg_match("/[a-z]/i", $db->escapeString($fn->xss_clean($_POST['minimum_version_required'])))) {
        $_POST['minimum_version_required'] = 0;
    }
    if (preg_match("/[a-z]/i", $db->escapeString($fn->xss_clean($_POST['delivery_charge'])))) {
        $_POST['delivery_charge'] = 0;
    }
    if (preg_match("/[a-z]/i", $db->escapeString($fn->xss_clean($_POST['min-refer-earn-order-amount'])))) {
        $_POST['min-refer-earn-order-amount'] = 0;
    }
    if (preg_match("/[a-z]/i", $db->escapeString($fn->xss_clean($_POST['min_amount'])))) {
        $_POST['min_amount'] = 0;
    }
    if (preg_match("/[a-z]/i", $db->escapeString($fn->xss_clean($_POST['max-refer-earn-amount'])))) {
        $_POST['max-refer-earn-amount'] = 0;
    }
    if (preg_match("/[a-z]/i", $db->escapeString($fn->xss_clean($_POST['minimum-withdrawal-amount'])))) {
        $_POST['minimum-withdrawal-amount'] = 0;
    }
    if (preg_match("/[a-z]/i", $db->escapeString($fn->xss_clean($_POST['refer-earn-bonus'])))) {
        $_POST['refer-earn-bonus'] = 0;
    }
    // if (preg_match("/[a-z]/i", $db->escapeString($fn->xss_clean($_POST['tax'])))) {
    //     $_POST['tax'] = 0;
    // }
    $_POST['store_address'] = (!empty(trim($_POST['store_address']))) ? preg_replace("/[\r\n]{2,}/", "<br>", $_POST['store_address']) : "";

    $settings_value = json_encode($fn->xss_clean_array($_POST));

    $sql = "UPDATE settings SET value='" . $settings_value . "' WHERE variable='system_timezone'";
    $db->sql($sql);
    $res = $db->getResult();
    $sql_logo = "select value from `settings` where variable='Logo' OR variable='logo'";
    $db->sql($sql_logo);
    $res_logo = $db->getResult();
    $file_name = $_FILES['logo']['name'];

    if (!empty($_FILES["logo"]["tmp_name"]) && $_FILES["logo"]["size"] > 0) {
        $tmp = explode('.', $file_name);
        $ext = end($tmp);
        // $mimetype = mime_content_type($_FILES["logo"]["tmp_name"]);
        // if (!in_array($mimetype, array('image/jpg', 'image/jpeg', 'image/gif', 'image/png'))) {
        //     echo " <span class='label label-danger'>Logo Image type must jpg, jpeg, gif, or png!</span>";
        //     return false;
        // } else {
        $result = $fn->validate_image($fn->xss_clean_array($_FILES["logo"]));
        if (!$result) {
            echo " <span class='label label-danger'>Logo Image type must jpg, jpeg, gif, or png!</span>";
            return false;
        } else {
            $old_image = '../dist/img/' . $res_logo[0]['value'];
            if (file_exists($old_image)) {
                unlink($old_image);
            }

            $target_path = '../dist/img/';
            $filename = "logo." . strtolower($ext);
            $full_path = $target_path . '' . $filename;
            if (!move_uploaded_file($_FILES["logo"]["tmp_name"], $full_path)) {
                $message = "Image could not be uploaded<br/>";
            } else {
                //Update Logo - id = 5
                $sql = "UPDATE `settings` SET `value`='" . $filename . "' WHERE `variable` = 'logo'";
                $db->sql($sql);
            }
        }
    }

    echo "<p class='alert alert-success'>Settings Saved!</p>";
}
if (isset($_POST['payment_method_settings'])) {
    if (defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) {
        echo '<label class="alert alert-danger">This operation is not allowed in demo panel!.</label>';
        return false;
    }
    $data = $fn->get_settings('payment_methods', true);
    if (empty($data)) {
        $json_data = json_encode($fn->xss_clean_array($_POST));
        $sql = "INSERT INTO `settings`(`variable`, `value`) VALUES ('payment_methods','$json_data')";
        $db->sql($sql);
        echo "<div class='alert alert-success'> Settings created successfully!</div>";
    } else {
        $json_data = json_encode($fn->xss_clean_array($_POST));
        $sql = "UPDATE `settings` SET `value`='$json_data' WHERE `variable`='payment_methods'";
        $db->sql($sql);
        echo "<div class='alert alert-success'> Settings updated successfully!</div>";
    }
}



if (isset($_POST['add_dr_gold']) && $_POST['add_dr_gold'] == 1) {
    $sql = "select * from settings where variable = 'doctor_brown'";
    $db->sql($sql);
    $res = $db->getResult();
    if (empty($res)) {
        $settings_value = json_encode($fn->xss_clean_array($_POST));
        $sql = "INSERT INTO settings (`variable`,`value`) VALUES ('doctor_brown','$settings_value ')";
        if ($db->sql($sql)) {
            $response['error'] = false;
            $response['message'] = "Your system is registered and activated successfully!";
        } else {
            $response['error'] = true;
            $response['message'] = "Something went wrong please try again!";
        }
    } else {
        $response['error'] = false;
        $response['message'] = "Your system is already activated!";
    }
    print_r(json_encode($response));
}



if (isset($_POST['add_system_user']) && $_POST['add_system_user'] == 1) {
    $id = $_SESSION['id'];
    $username = $db->escapeString($fn->xss_clean($_POST['username']));
    $email = $db->escapeString($fn->xss_clean($_POST['email']));
    if (empty($email)) {
        echo " <label class='alert alert-danger'>Email required!</label>";
        return false;
    }
    $valid_mail = "/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i";
    if (!preg_match($valid_mail, $email)) {
        echo " <label class='alert alert-danger'>Wrong email format!</label>";
        return false;
    }

    $password = $db->escapeString($fn->xss_clean($_POST['password']));
    $password = md5($password);
    $role = $db->escapeString($fn->xss_clean($_POST['role']));


    $sql = "SELECT id FROM admin WHERE username='" . $username . "'";
    $db->sql($sql);
    $res = $db->getResult();
    $count = $db->numRows($res);
    if ($count > 0) {
        echo '<label class="alert alert-danger">Username Already Exists!</label>';
        return false;
    }

    $sql = "SELECT id FROM admin WHERE email='" . $email . "'";
    $db->sql($sql);
    $res = $db->getResult();
    $count = $db->numRows($res);
    if ($count > 0) {
        echo '<label class="alert alert-danger">Email Already Exists!</label>';
        return false;
    }
    $permissions['goldsmithmaster'] = array("create" => $db->escapeString($fn->xss_clean($_POST['is-create-goldsmithmaster'])), "read" => $db->escapeString($fn->xss_clean($_POST['is-read-goldsmithmaster'])), "update" => $db->escapeString($fn->xss_clean($_POST['is-update-goldsmithmaster'])), "delete" => $db->escapeString($fn->xss_clean($_POST['is-delete-goldsmithmaster'])));

    $permissions['openmaster'] = array("create" => $db->escapeString($fn->xss_clean($_POST['is-create-openmaster'])), "read" => $db->escapeString($fn->xss_clean($_POST['is-read-openmaster'])), "update" => $db->escapeString($fn->xss_clean($_POST['is-update-openmaster'])), "delete" => $db->escapeString($fn->xss_clean($_POST['is-delete-openmaster'])));

    $permissions['dailytransaction'] = array("create" => $db->escapeString($fn->xss_clean($_POST['is-create-dailytransaction'])), "read" => $db->escapeString($fn->xss_clean($_POST['is-read-dailytransaction'])), "update" => $db->escapeString($fn->xss_clean($_POST['is-update-dailytransaction'])), "delete" => $db->escapeString($fn->xss_clean($_POST['is-delete-dailytransaction'])));

    $permissions['suspenseaccount'] = array("create" => $db->escapeString($fn->xss_clean($_POST['is-create-suspenseaccount'])), "read" => $db->escapeString($fn->xss_clean($_POST['is-read-suspenseaccount'])), "update" => $db->escapeString($fn->xss_clean($_POST['is-update-suspenseaccount'])), "delete" => $db->escapeString($fn->xss_clean($_POST['is-delete-suspenseaccount'])));

    $permissions['transactionregister'] = array("create" => $db->escapeString($fn->xss_clean($_POST['is-create-transactionregister'])), "read" => $db->escapeString($fn->xss_clean($_POST['is-read-transactionregister'])), "update" => $db->escapeString($fn->xss_clean($_POST['is-update-transactionregister'])), "delete" => $db->escapeString($fn->xss_clean($_POST['is-delete-transactionregister'])));

    $permissions['dealerreport'] = array("create" => $db->escapeString($fn->xss_clean($_POST['is-create-dealerreport'])), "read" => $db->escapeString($fn->xss_clean($_POST['is-read-dealerreport'])), "update" => $db->escapeString($fn->xss_clean($_POST['is-update-dealerreport'])), "delete" => $db->escapeString($fn->xss_clean($_POST['is-delete-dealerreport'])));

    $permissions['areawisereport'] = array("create" => $db->escapeString($fn->xss_clean($_POST['is-create-areawisereport'])), "read" => $db->escapeString($fn->xss_clean($_POST['is-read-areawisereport'])), "update" => $db->escapeString($fn->xss_clean($_POST['is-update-areawisereport'])), "delete" => $db->escapeString($fn->xss_clean($_POST['is-delete-areawisereport'])));

    $permissions['stockreport'] = array("create" => $db->escapeString($fn->xss_clean($_POST['is-create-stockreport'])), "read" => $db->escapeString($fn->xss_clean($_POST['is-read-stockreport'])), "update" => $db->escapeString($fn->xss_clean($_POST['is-update-stockreport'])), "delete" => $db->escapeString($fn->xss_clean($_POST['is-delete-stockreport'])));

    $encoded_permissions = json_encode($permissions);
    $sql = "INSERT INTO admin (username,email,password,role,permissions,created_by)
                        VALUES('$username', '$email', '$password', '$role','$encoded_permissions','$id')";
    if ($db->sql($sql)) {
        echo '<label class="alert alert-success">' . $role . ' Added Successfully!</label>';
    } else {
        echo '<label class="alert alert-danger">Some Error Occrred! please try again.</label>';
    }
}
if (isset($_GET['delete_system_user']) && $_GET['delete_system_user'] == 1) {
    $id = $db->escapeString($fn->xss_clean($_GET['id']));
    $sql = "DELETE FROM `admin` WHERE id=" . $id;
    if ($db->sql($sql)) {
        echo 0;
    } else {
        echo 1;
    }
}
if (isset($_POST['update_system_user']) && $_POST['update_system_user'] == 1) {
    if (!checkadmin($auth_username)) {
        echo "<label class='alert alert-danger'>Access denied - You are not authorized to access this page.</label>";
        return false;
    }
    $id = $db->escapeString($fn->xss_clean($_POST['system_user_id']));
    $permissions['goldsmithmaster'] = array("create" => $db->escapeString($fn->xss_clean($_POST['permission-is-create-goldsmithmaster'])), "read" => $db->escapeString($fn->xss_clean($_POST['permission-is-read-goldsmithmaster'])), "update" => $db->escapeString($fn->xss_clean($_POST['permission-is-update-goldsmithmaster'])), "delete" => $db->escapeString($fn->xss_clean($_POST['permission-is-delete-goldsmithmaster'])));

    $permissions['openmaster'] = array("create" => $db->escapeString($fn->xss_clean($_POST['permission-is-create-openmaster'])), "read" => $db->escapeString($fn->xss_clean($_POST['permission-is-read-openmaster'])), "update" => $db->escapeString($fn->xss_clean($_POST['permission-is-update-openmaster'])), "delete" => $db->escapeString($fn->xss_clean($_POST['permission-is-delete-openmaster'])));

    $permissions['dailytransaction'] = array("create" => $db->escapeString($fn->xss_clean($_POST['permission-is-create-dailytransaction'])), "read" => $db->escapeString($fn->xss_clean($_POST['permission-is-read-dailytransaction'])), "update" => $db->escapeString($fn->xss_clean($_POST['permission-is-update-dailytransaction'])), "delete" => $db->escapeString($fn->xss_clean($_POST['permission-is-delete-dailytransaction'])));

    $permissions['transactionregister'] = array("create" => $db->escapeString($fn->xss_clean($_POST['permission-is-create-transactionregister'])), "read" => $db->escapeString($fn->xss_clean($_POST['permission-is-read-transactionregister'])), "update" => $db->escapeString($fn->xss_clean($_POST['permission-is-update-transactionregister'])), "delete" => $db->escapeString($fn->xss_clean($_POST['permission-is-delete-transactionregister'])));

    $permissions['suspenseaccount'] = array("create" => $db->escapeString($fn->xss_clean($_POST['permission-is-create-suspenseaccount'])), "read" => $db->escapeString($fn->xss_clean($_POST['permission-is-read-suspenseaccount'])), "update" => $db->escapeString($fn->xss_clean($_POST['permission-is-update-suspenseaccount'])), "delete" => $db->escapeString($fn->xss_clean($_POST['permission-is-delete-suspenseaccount'])));

    $permissions['dealerreport'] = array("create" => $db->escapeString($fn->xss_clean($_POST['permission-is-create-dealerreport'])), "read" => $db->escapeString($fn->xss_clean($_POST['permission-is-read-dealerreport'])), "update" => $db->escapeString($fn->xss_clean($_POST['permission-is-update-dealerreport'])), "delete" => $db->escapeString($fn->xss_clean($_POST['permission-is-delete-dealerreport'])));

    $permissions['areawisereport'] = array("create" => $db->escapeString($fn->xss_clean($_POST['permission-is-create-areawisereport'])), "read" => $db->escapeString($fn->xss_clean($_POST['permission-is-read-areawisereport'])), "update" => $db->escapeString($fn->xss_clean($_POST['permission-is-update-areawisereport'])), "delete" => $db->escapeString($fn->xss_clean($_POST['permission-is-delete-areawisereport'])));

    $permissions['stockreport'] = array("create" => $db->escapeString($fn->xss_clean($_POST['permission-is-create-stockreport'])), "read" => $db->escapeString($fn->xss_clean($_POST['permission-is-read-stockreport'])), "update" => $db->escapeString($fn->xss_clean($_POST['permission-is-update-stockreport'])), "delete" => $db->escapeString($fn->xss_clean($_POST['permission-is-delete-stockreport'])));

    $permissions = json_encode($permissions);
    $sql = "UPDATE admin SET permissions='" . $permissions . "' WHERE id=" . $id;
    if ($db->sql($sql)) {
        echo '<label class="alert alert-success">Updated Successfully!</label>';
    } else {
        echo '<label class="alert alert-danger">Some Error Occrred! please try again.</label>';
    }
}
if (isset($_POST['delete_sus_weight'])) {
    $susvid = $db->escapeString($fn->xss_clean($_POST['id']));
    $sql = "DELETE FROM `suspense_account_variant` WHERE id=" . $susvid;
    if ($db->sql($sql)) {
        echo 0;
    } else {
        echo 1;
    }
}

