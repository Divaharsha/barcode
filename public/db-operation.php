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
$permissions = $fn->get_permissions($_SESSION['id']);
$config = $fn->get_configurations();
$time_slot_config = $fn->time_slot_config();
if (isset($config['system_timezone']) && isset($config['system_timezone_gmt'])) {
    date_default_timezone_set($config['system_timezone']);
    $db->sql("SET `time_zone` = '" . $config['system_timezone_gmt'] . "'");
} else {
    date_default_timezone_set('Asia/Kolkata');
    $db->sql("SET `time_zone` = '+05:30'");
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
    if ($permissions['settings']['update'] == 0) {
        echo '<label class="alert alert-danger">You have no permission to update settings</label>';
        return false;
    }
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
    if ($permissions['settings']['update'] == 0) {
        echo '<label class="alert alert-danger">You have no permission to update settings</label>';
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
if (isset($_POST['shiprocket_settings'])) {
    if (defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) {
        echo '<label class="alert alert-danger">This operation is not allowed in demo panel!.</label>';
        return false;
    }
    if ($permissions['settings']['update'] == 0) {
        echo '<label class="alert alert-danger">You have no permission to update settings</label>';
        return false;
    }
    $data = $fn->get_settings('shiprocket', true);
    if (empty($data)) {
        $json_data = json_encode($fn->xss_clean_array($_POST));
        $sql = "INSERT INTO `settings`(`variable`, `value`) VALUES ('shiprocket','$json_data')";
        $db->sql($sql);
        echo "<div class='alert alert-success'> Settings created successfully!</div>";
    } else {
        $json_data = json_encode($fn->xss_clean_array($_POST));
        $sql = "UPDATE `settings` SET `value`='$json_data' WHERE `variable`='shiprocket'";
        $db->sql($sql);
        echo "<div class='alert alert-success'> Settings updated successfully!</div>";
    }
}
if (isset($_POST['time_slot_config']) && $_POST['time_slot_config'] == 1) {
    if ($permissions['settings']['update'] == 0) {
        echo '<label class="alert alert-danger">You have no permission to update settings</label>';
        return false;
    }
    $_POST['allowed_days'] = empty($_POST['allowed_days']) ? 1 : $db->escapeString($fn->xss_clean($_POST['allowed_days']));
    if (!$time_slot_config) {
        $settings_value = json_encode($fn->xss_clean_array($_POST));
        $sql = "INSERT INTO settings (`variable`,`value`) VALUES ('time_slot_config','" . $settings_value . "')";
    } else {
        $settings_value = json_encode($fn->xss_clean_array($_POST));
        $sql = "UPDATE settings SET value='" . $settings_value . "' WHERE variable='time_slot_config'";
    }
    if ($db->sql($sql)) {
        echo "<p class='alert alert-success'>Saved Successfully!</p>";
    } else {
        echo "<p class='alert alert-danger'>Something went wrong please try again!</p>";
    }
}
if (isset($_POST['add_category_settings']) && $_POST['add_category_settings'] == 1) {
    if ($permissions['settings']['update'] == 0) {
        echo '<label class="alert alert-danger">You have no permission to update settings</label>';
        return false;
    }
    $sql = "select variable from settings where variable='categories_settings' ";
    $db->sql($sql);
    $res = $db->getResult();
    if (empty($res)) {
        $settings_value = json_encode($fn->xss_clean_array($_POST));
        $sql = "INSERT INTO settings (`variable`,`value`) VALUES ('categories_settings','" . $settings_value . "')";
    } else {
        $settings_value = json_encode($fn->xss_clean_array($_POST));
        $sql = "UPDATE settings SET value='" . $settings_value . "' WHERE variable='categories_settings'";
    }
    if ($db->sql($sql)) {
        echo "<p class='alert alert-success'>Saved Successfully!</p>";
    } else {
        echo "<p class='alert alert-danger'>Something went wrong please try again!</p>";
    }
}

if (isset($_POST['add_dr_gold']) && $_POST['add_dr_gold'] == 1) {
    if ($permissions['settings']['update'] == 0) {
        echo '<label class="alert alert-danger">You have no permission to update settings</label>';
        return false;
    }
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

if (isset($_POST['front_end_settings']) && $_POST['front_end_settings'] == 1) {
    if ($permissions['settings']['update'] == 0) {
        echo '<label class="alert alert-danger">You have no permission to update settings</label>';
        return false;
    }
    $res = $res_data = array();
    $loading_old = "";
    $web_logo_old = "";
    $favicon_old = "";
    $screenshots_old = "";
    $google_play_old = "";

    $sql = "select * from settings where variable = 'front_end_settings'";
    $db->sql($sql);
    $res = $db->getResult();
    $res_data = (!empty($res)) ? json_decode($res[0]['value'], true) : array();

    $loading_old = $res_data['loading'];
    $favicon_old = $res_data['favicon'];
    $web_logo_old = $res_data['web_logo'];
    $screenshots_old = $res_data['screenshots'];
    $google_play_old = $res_data['google_play'];

    if (isset($_FILES['favicon']) && !empty($_FILES['favicon']) && $_FILES['favicon']['error'] == 0 && $_FILES['favicon']['size'] > 0) {
        $favicon = $db->escapeString($fn->xss_clean($_FILES['favicon']['name']));
        $extension = pathinfo($_FILES["favicon"]["name"])['extension'];
        $result = $fn->validate_image($_FILES["favicon"]);
        if (!$result) {
            echo "<p class='alert alert-danger'>Image type must jpg, jpeg, gif, or png!</p>";
            return false;
        }

        $target_path = '../dist/img/';
        if (!empty($favicon_old) && $favicon_old != '') {
            unlink($target_path . $favicon_old);
        }
        $filename = microtime(true) . '.' . strtolower($extension);
        $full_path = $target_path . "" . $filename;

        if (!move_uploaded_file($_FILES["favicon"]["tmp_name"], $full_path)) {
            echo "<p class='alert alert-danger'>Invalid directory to load favicon!</p>";
            return false;
        }
        $_POST['favicon'] = $filename;
    } else {
        $_POST['favicon'] = $favicon_old;
    }

    if (isset($_FILES['web_logo']) && !empty($_FILES['web_logo']) && $_FILES['web_logo']['error'] == 0 && $_FILES['web_logo']['size'] > 0) {
        $web_logo = $db->escapeString($fn->xss_clean($_FILES['web_logo']['name']));
        $extension = pathinfo($_FILES["web_logo"]["name"])['extension'];
        $result = $fn->validate_image($_FILES["web_logo"]);
        if (!$result) {
            echo "<p class='alert alert-danger'>Image type must jpg, jpeg, gif, or png!</p>";
            return false;
        }

        $target_path = '../dist/img/';
        if (!empty($fweb_logo_old) && $web_logo_old != '') {
            unlink($target_path . $web_logo_old);
        }
        $filename = microtime(true) . '.' . strtolower($extension);
        $full_path = $target_path . "" . $filename;

        if (!move_uploaded_file($_FILES["web_logo"]["tmp_name"], $full_path)) {
            echo "<p class='alert alert-danger'>Invalid directory to load Web Logo!</p>";
            return false;
        }
        $_POST['web_logo'] = $filename;
    } else {
        $_POST['web_logo'] = $web_logo_old;
    }

    if (isset($_FILES['loading']) && !empty($_FILES['loading']) && $_FILES['loading']['error'] == 0 && $_FILES['loading']['size'] > 0) {
        $loading = $db->escapeString($fn->xss_clean($_FILES['loading']['name']));
        $extension = pathinfo($_FILES["loading"]["name"])['extension'];
        $result = $fn->validate_image($_FILES["loading"]);
        if (!$result) {
            echo "<p class='alert alert-danger'>Image type must jpg, jpeg, gif, or png!</p>";
            return false;
        }

        $target_path = '../dist/img/';
        if (!empty($loading_old) && $loading_old != '') {
            unlink($target_path . $loading_old);
        }
        $filename = microtime(true) . '.' . strtolower($extension);
        $full_path = $target_path . "" . $filename;

        if (!move_uploaded_file($_FILES["loading"]["tmp_name"], $full_path)) {
            echo "<p class='alert alert-danger'>Invalid directory to load loading Image!</p>";
            return false;
        }
        $_POST['loading'] = $filename;
    } else {
        $_POST['loading'] = $loading_old;
    }


    if (isset($_FILES['screenshots']) && !empty($_FILES['screenshots']) && $_FILES['screenshots']['error'] == 0 && $_FILES['screenshots']['size'] > 0) {
        $screenshots = $db->escapeString($fn->xss_clean($_FILES['screenshots']['name']));
        $extension = pathinfo($_FILES["screenshots"]["name"])['extension'];
        $result = $fn->validate_image($_FILES["screenshots"]);
        if (!$result) {
            echo "<p class='alert alert-danger'>Image type must jpg, jpeg, gif, or png!</p>";
            return false;
        }

        $target_path = '../dist/img/';
        if (!empty($screenshots_old) && $screenshots_old != '') {
            unlink($target_path . $screenshots_old);
        }
        $filename = microtime(true) . '.' . strtolower($extension);
        $full_path = $target_path . "" . $filename;

        if (!move_uploaded_file($_FILES["screenshots"]["tmp_name"], $full_path)) {
            echo "<p class='alert alert-danger'>Invalid directory to load App Screenshots!</p>";
            return false;
        }
        $_POST['screenshots'] = $filename;
    } else {
        $_POST['screenshots'] = $screenshots_old;
    }


    if (isset($_FILES['google_play']) && !empty($_FILES['google_play']) && $_FILES['google_play']['error'] == 0 && $_FILES['google_play']['size'] > 0) {
        $google_play = $db->escapeString($fn->xss_clean($_FILES['google_play']['name']));
        $extension = pathinfo($_FILES["google_play"]["name"])['extension'];
        $result = $fn->validate_image($_FILES["google_play"]);
        if (!$result) {
            echo "<p class='alert alert-danger'>Image type must jpg, jpeg, gif, or png!</p>";
            return false;
        }

        $target_path = '../dist/img/';
        if (!empty($google_play_old) && $google_play_old != '') {
            unlink($target_path . $google_play_old);
        }
        $filename = microtime(true) . '.' . strtolower($extension);
        $full_path = $target_path . "" . $filename;

        if (!move_uploaded_file($_FILES["google_play"]["tmp_name"], $full_path)) {
            echo "<p class='alert alert-danger'>Invalid directory to load Google Play Image!</p>";
            return false;
        }
        $_POST['google_play'] = $filename;
    } else {
        $_POST['google_play'] = $google_play_old;
    }
    $_POST['common_meta_description'] = str_replace("'", "''", $_POST['common_meta_description']);
    $_POST['common_meta_keywords'] = str_replace("'", "''", $_POST['common_meta_keywords']);
    if (empty($res)) {
        $settings_value = json_encode($fn->xss_clean_array($_POST));
        $sql = "INSERT INTO settings (`variable`,`value`) VALUES ('front_end_settings','$settings_value ')";
        if ($db->sql($sql)) {
            echo "<p class='alert alert-success'>Saved Successfully!</p>";
        } else {
            echo "<p class='alert alert-danger'>Something went wrong please try again!</p>";
        }
    } else {
        $settings_value = json_encode($fn->xss_clean_array($_POST));
        $sql = "UPDATE settings SET value='" . $settings_value . "' WHERE variable='front_end_settings'";
        if ($db->sql($sql)) {
            echo "<p class='alert alert-success'>Saved Successfully!</p>";
        } else {
            echo "<p class='alert alert-danger'>Something went wrong please try again!</p>";
        }
    }
}


if (isset($_POST['add_promo_code']) && $_POST['add_promo_code'] == 1) {
    if (!checkadmin($auth_username)) {
        echo "<label class='alert alert-danger'>Access denied - You are not authorized to access this page.</label>";
        return false;
    }
    if ($permissions['promo_codes']['create'] == 0) {
        echo '<label class="alert alert-danger">You have no permission to create promo code</label>';
        return false;
    }
    $promo_code = $db->escapeString($fn->xss_clean($_POST['promo_code']));
    $message = $db->escapeString($fn->xss_clean($_POST['message']));
    $start_date = $db->escapeString($fn->xss_clean($_POST['start_date']));
    $end_date = $db->escapeString($fn->xss_clean($_POST['end_date']));
    $no_of_users = $db->escapeString($fn->xss_clean($_POST['no_of_users']));
    $minimum_order_amount = $db->escapeString($fn->xss_clean($_POST['minimum_order_amount']));
    $discount = $db->escapeString($fn->xss_clean($_POST['discount']));
    $discount_type = $db->escapeString($fn->xss_clean($_POST['discount_type']));
    $max_discount_amount = $db->escapeString($fn->xss_clean($_POST['max_discount_amount']));
    $repeat_usage = $db->escapeString($fn->xss_clean($_POST['repeat_usage']));
    $no_of_repeat_usage = !empty($_POST['repeat_usage']) ? $db->escapeString($fn->xss_clean($_POST['no_of_repeat_usage'])) : 0;
    $status = $db->escapeString($fn->xss_clean($_POST['status']));

    $sql = "INSERT INTO promo_codes (promo_code,message,start_date,end_date,no_of_users,minimum_order_amount,discount,discount_type,max_discount_amount,repeat_usage,no_of_repeat_usage,status)
                        VALUES('$promo_code', '$message', '$start_date', '$end_date','$no_of_users','$minimum_order_amount','$discount','$discount_type','$max_discount_amount','$repeat_usage','$no_of_repeat_usage','$status')";
    if ($db->sql($sql)) {
        echo '<label class="alert alert-success">Promo Code Added Successfully!</label>';
    } else {
        echo '<label class="alert alert-danger">Some Error Occrred! please try again.</label>';
    }
}
if (isset($_POST['update_promo_code']) && $_POST['update_promo_code'] == 1) {
    if (!checkadmin($auth_username)) {
        echo "<label class='alert alert-danger'>Access denied - You are not authorized to access this page.</label>";
        return false;
    }
    if ($permissions['promo_codes']['update'] == 0) {
        echo '<label class="alert alert-danger">You have no permission to update promo code</label>';
        return false;
    }
    $id = $db->escapeString($fn->xss_clean($_POST['promo_code_id']));
    $promo_code = $db->escapeString($fn->xss_clean($_POST['update_promo']));
    $message = $db->escapeString($fn->xss_clean($_POST['update_message']));
    $start_date = $db->escapeString($fn->xss_clean($_POST['update_start_date']));
    $end_date = $db->escapeString($fn->xss_clean($_POST['update_end_date']));
    $no_of_users = $db->escapeString($fn->xss_clean($_POST['update_no_of_users']));
    $minimum_order_amount = $db->escapeString($fn->xss_clean($_POST['update_minimum_order_amount']));
    $discount = $db->escapeString($fn->xss_clean($_POST['update_discount']));
    $discount_type = $db->escapeString($fn->xss_clean($_POST['update_discount_type']));
    $max_discount_amount = $db->escapeString($fn->xss_clean($_POST['update_max_discount_amount']));
    $repeat_usage = $db->escapeString($fn->xss_clean($_POST['update_repeat_usage']));
    $no_of_repeat_usage = $repeat_usage == 0 ? '0' : $db->escapeString($fn->xss_clean($_POST['update_no_of_repeat_usage']));
    $status = $db->escapeString($fn->xss_clean($_POST['status']));

    $sql = "Update promo_codes set `promo_code`='" . $promo_code . "',`message`='" . $message . "',`start_date`='" . $start_date . "',`end_date`='" . $end_date . "',`no_of_users`='" . $no_of_users . "',`minimum_order_amount`='" . $minimum_order_amount . "',`discount`='" . $discount . "',`discount_type`='" . $discount_type . "',`max_discount_amount`='" . $max_discount_amount . "',`repeat_usage`='" . $repeat_usage . "',`no_of_repeat_usage`='" . $no_of_repeat_usage . "',`status`='" . $status . "' where `id`=" . $id;

    if ($db->sql($sql)) {
        echo "<label class='alert alert-success'>Promo Code Updated Successfully.</label>";
    } else {
        echo "<label class='alert alert-danger'>Some Error Occurred! Please Try Again.</label>";
    }
}
if (isset($_GET['delete_promo_code']) && $_GET['delete_promo_code'] == 1) {
    if ($permissions['promo_codes']['delete'] == 0) {
        echo 2;
        return false;
    }
    $id = $db->escapeString($fn->xss_clean($_GET['id']));
    $sql = "DELETE FROM `promo_codes` WHERE id=" . $id;
    if ($db->sql($sql)) {
        echo 0;
    } else {
        echo 1;
    }
}
if (isset($_POST['add_time_slot']) && $_POST['add_time_slot'] == 1) {
    if (!checkadmin($auth_username)) {
        echo "<label class='alert alert-danger'>Access denied - You are not authorized to access this page.</label>";
        return false;
    }
    if ($permissions['settings']['update'] == 0) {

        echo '<label class="alert alert-danger">You have no permission to add time slot</label>';
        return false;
    }
    $title = $db->escapeString($fn->xss_clean($_POST['title']));
    $from_time = $db->escapeString($fn->xss_clean($_POST['from_time']));
    $to_time = $db->escapeString($fn->xss_clean($_POST['to_time']));
    $last_order_time = $db->escapeString($fn->xss_clean($_POST['last_order_time']));
    $status = $db->escapeString($fn->xss_clean($_POST['status']));
    $sql = "INSERT INTO time_slots (title,from_time,to_time,last_order_time,status)
                        VALUES('$title', '$from_time', '$to_time', '$last_order_time','$status')";
    if ($db->sql($sql)) {
        echo '<label class="alert alert-success">Time Slot Added Successfully!</label>';
    } else {
        echo '<label class="alert alert-danger">Some Error Occrred! please try again.</label>';
    }
}
if (isset($_POST['update_time_slot']) && $_POST['update_time_slot'] == 1) {
    if (!checkadmin($auth_username)) {
        echo "<label class='alert alert-danger'>Access denied - You are not authorized to access this page.</label>";
        return false;
    }
    if ($permissions['settings']['update'] == 0) {

        echo '<label class="alert alert-danger">You have no permission to update time slot</label>';
        return false;
    }
    $id = $db->escapeString($fn->xss_clean($_POST['time_slot_id']));
    $title = $db->escapeString($fn->xss_clean($_POST['update_title']));
    $from_time = $db->escapeString($fn->xss_clean($_POST['update_from_time']));
    $to_time = $db->escapeString($fn->xss_clean($_POST['update_to_time']));
    $last_order_time = $db->escapeString($fn->xss_clean($_POST['update_last_order_time']));
    $status = $db->escapeString($fn->xss_clean($_POST['status']));
    $sql = "Update time_slots set `title`='" . $title . "',`from_time`='" . $from_time . "',`to_time`='" . $to_time . "',`last_order_time`='" . $last_order_time . "',`status`='" . $status . "' where `id`=" . $id;
    if ($db->sql($sql)) {
        echo "<label class='alert alert-success'>Time Slot Updated Successfully.</label>";
    } else {
        echo "<label class='alert alert-danger'>Some Error Occurred! Please Try Again.</label>";
    }
}
if (isset($_GET['delete_time_slot']) && $_GET['delete_time_slot'] == 1) {
    if ($permissions['settings']['update'] == 0) {

        echo 2;
        return false;
    }
    $id = $db->escapeString($fn->xss_clean($_GET['id']));
    $sql = "DELETE FROM `time_slots` WHERE id=" . $id;
    if ($db->sql($sql)) {
        echo 0;
    } else {
        echo 1;
    }
}

if (isset($_POST['add_system_user']) && $_POST['add_system_user'] == 1) {
    if (!checkadmin($auth_username)) {
        echo "<label class='alert alert-danger'>Access denied - You are not authorized to access this page.</label>";
        return false;
    }
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
    $permissions['orders'] = array("create" => $db->escapeString($fn->xss_clean($_POST['is-create-order'])), "read" => $db->escapeString($fn->xss_clean($_POST['is-read-order'])), "update" => $db->escapeString($fn->xss_clean($_POST['is-update-order'])), "delete" => $db->escapeString($fn->xss_clean($_POST['is-delete-order'])));

    $permissions['categories'] = array("create" => $db->escapeString($fn->xss_clean($_POST['is-create-category'])), "read" => $db->escapeString($fn->xss_clean($_POST['is-read-category'])), "update" => $db->escapeString($fn->xss_clean($_POST['is-update-category'])), "delete" => $db->escapeString($fn->xss_clean($_POST['is-delete-category'])));

    $permissions['sellers'] = array("create" => $db->escapeString($fn->xss_clean($_POST['is-create-seller'])), "read" => $db->escapeString($fn->xss_clean($_POST['is-read-seller'])), "update" => $db->escapeString($fn->xss_clean($_POST['is-update-seller'])), "delete" => $db->escapeString($fn->xss_clean($_POST['is-delete-seller'])));

    $permissions['subcategories'] = array("create" => $db->escapeString($fn->xss_clean($_POST['is-create-subcategory'])), "read" => $db->escapeString($fn->xss_clean($_POST['is-read-subcategory'])), "update" => $db->escapeString($fn->xss_clean($_POST['is-update-subcategory'])), "delete" => $db->escapeString($fn->xss_clean($_POST['is-delete-subcategory'])));

    $permissions['products'] = array("create" => $db->escapeString($fn->xss_clean($_POST['is-create-product'])), "read" => $db->escapeString($fn->xss_clean($_POST['is-read-product'])), "update" => $db->escapeString($fn->xss_clean($_POST['is-update-product'])), "delete" => $db->escapeString($fn->xss_clean($_POST['is-delete-product'])));

    $permissions['products_order'] = array("read" => $db->escapeString($fn->xss_clean($_POST['is-read-products-order'])), "update" => $db->escapeString($fn->xss_clean($_POST['is-update-products-order'])));

    $permissions['home_sliders'] = array("create" => $db->escapeString($fn->xss_clean($_POST['is-create-home-slider'])), "read" => $db->escapeString($fn->xss_clean($_POST['is-read-home-slider'])), "delete" => $db->escapeString($fn->xss_clean($_POST['is-delete-home-slider'])));

    $permissions['new_offers'] = array("create" => $db->escapeString($fn->xss_clean($_POST['is-create-new-offer'])), "read" => $db->escapeString($fn->xss_clean($_POST['is-read-new-offer'])), "delete" => $db->escapeString($fn->xss_clean($_POST['is-delete-new-offer'])));

    $permissions['promo_codes'] = array("create" => $db->escapeString($fn->xss_clean($_POST['is-create-promo'])), "read" => $db->escapeString($fn->xss_clean($_POST['is-read-promo'])), "update" => $db->escapeString($fn->xss_clean($_POST['is-update-promo'])), "delete" => $db->escapeString($fn->xss_clean($_POST['is-delete-promo'])));

    $permissions['featured'] = array("create" => $db->escapeString($fn->xss_clean($_POST['is-create-featured'])), "read" => $db->escapeString($fn->xss_clean($_POST['is-read-featured'])), "update" => $db->escapeString($fn->xss_clean($_POST['is-update-featured'])), "delete" => $db->escapeString($fn->xss_clean($_POST['is-delete-featured'])));

    $permissions['customers'] = array("read" => $db->escapeString($fn->xss_clean($_POST['is-read-customers'])), "update" => $db->escapeString($fn->xss_clean($_POST['is-update-customers'])));

    $permissions['payment'] = array("read" => $db->escapeString($fn->xss_clean($_POST['is-read-payment'])), "update" => $db->escapeString($fn->xss_clean($_POST['is-update-payment'])));

    $permissions['return_requests'] = array("read" => $db->escapeString($fn->xss_clean($_POST['is-read-return'])), "update" => $db->escapeString($fn->xss_clean($_POST['is-update-return'])), "delete" => $db->escapeString($fn->xss_clean($_POST['is-delete-return'])));

    $permissions['delivery_boys'] = array("create" => $db->escapeString($fn->xss_clean($_POST['is-create-delivery'])), "read" => $db->escapeString($fn->xss_clean($_POST['is-read-delivery'])), "update" => $db->escapeString($fn->xss_clean($_POST['is-update-delivery'])), "delete" => $db->escapeString($fn->xss_clean($_POST['is-delete-delivery'])));

    $permissions['notifications'] = array("create" => $db->escapeString($fn->xss_clean($_POST['is-create-notification'])), "read" => $db->escapeString($fn->xss_clean($_POST['is-read-notification'])), "delete" => $db->escapeString($fn->xss_clean($_POST['is-delete-notification'])));

    $permissions['transactions'] = array("read" => $db->escapeString($fn->xss_clean($_POST['is-read-transaction'])));

    $permissions['settings'] = array("read" => $db->escapeString($fn->xss_clean($_POST['is-read-settings'])), "update" => $db->escapeString($fn->xss_clean($_POST['is-update-settings'])));

    $permissions['locations'] = array("create" => $db->escapeString($fn->xss_clean($_POST['is-create-location'])), "read" => $db->escapeString($fn->xss_clean($_POST['is-read-location'])), "update" => $db->escapeString($fn->xss_clean($_POST['is-update-location'])), "delete" => $db->escapeString($fn->xss_clean($_POST['is-delete-location'])));

    $permissions['reports'] = array("create" => $db->escapeString($fn->xss_clean($_POST['is-create-report'])), "read" => $db->escapeString($fn->xss_clean($_POST['is-read-report'])));

    $permissions['faqs'] = array("create" => $db->escapeString($fn->xss_clean($_POST['is-create-faq'])), "read" => $db->escapeString($fn->xss_clean($_POST['is-read-faq'])), "update" => $db->escapeString($fn->xss_clean($_POST['is-update-faq'])), "delete" => $db->escapeString($fn->xss_clean($_POST['is-delete-faq'])));

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
    $permissions['orders'] = array("create" => $db->escapeString($fn->xss_clean($_POST['permission-is-create-order'])), "read" => $db->escapeString($fn->xss_clean($_POST['permission-is-read-order'])), "update" => $db->escapeString($fn->xss_clean($_POST['permission-is-update-order'])), "delete" => $db->escapeString($fn->xss_clean($_POST['permission-is-delete-order'])));

    $permissions['categories'] = array("create" => $db->escapeString($fn->xss_clean($_POST['permission-is-create-category'])), "read" => $db->escapeString($fn->xss_clean($_POST['permission-is-read-category'])), "update" => $db->escapeString($fn->xss_clean($_POST['permission-is-update-category'])), "delete" => $db->escapeString($fn->xss_clean($_POST['permission-is-delete-category'])));

    $permissions['sellers'] = array("create" => $db->escapeString($fn->xss_clean($_POST['permission-is-create-seller'])), "read" => $db->escapeString($fn->xss_clean($_POST['permission-is-read-seller'])), "update" => $db->escapeString($fn->xss_clean($_POST['permission-is-update-seller'])), "delete" => $db->escapeString($fn->xss_clean($_POST['permission-is-delete-seller'])));

    $permissions['subcategories'] = array("create" => $db->escapeString($fn->xss_clean($_POST['permission-is-create-subcategory'])), "read" => $db->escapeString($fn->xss_clean($_POST['permission-is-read-subcategory'])), "update" => $db->escapeString($fn->xss_clean($_POST['permission-is-update-subcategory'])), "delete" => $db->escapeString($fn->xss_clean($_POST['permission-is-delete-subcategory'])));

    $permissions['products'] = array("create" => $db->escapeString($fn->xss_clean($_POST['permission-is-create-product'])), "read" => $db->escapeString($fn->xss_clean($_POST['permission-is-read-product'])), "update" => $db->escapeString($fn->xss_clean($_POST['permission-is-update-product'])), "delete" => $db->escapeString($fn->xss_clean($_POST['permission-is-delete-product'])));

    $permissions['products_order'] = array("read" => $db->escapeString($fn->xss_clean($_POST['permission-is-read-products-order'])), "update" => $db->escapeString($fn->xss_clean($_POST['permission-is-update-products-order'])));

    $permissions['home_sliders'] = array("create" => $db->escapeString($fn->xss_clean($_POST['permission-is-create-home-slider'])), "read" => $db->escapeString($fn->xss_clean($_POST['permission-is-read-home-slider'])), "delete" => $db->escapeString($fn->xss_clean($_POST['permission-is-delete-home-slider'])));

    $permissions['new_offers'] = array("create" => $db->escapeString($fn->xss_clean($_POST['permission-is-create-new-offer'])), "read" => $db->escapeString($fn->xss_clean($_POST['permission-is-read-new-offer'])), "delete" => $db->escapeString($fn->xss_clean($_POST['permission-is-delete-new-offer'])));

    $permissions['promo_codes'] = array("create" => $db->escapeString($fn->xss_clean($_POST['permission-is-create-promo'])), "read" => $db->escapeString($fn->xss_clean($_POST['permission-is-read-promo'])), "update" => $db->escapeString($fn->xss_clean($_POST['permission-is-update-promo'])), "delete" => $db->escapeString($fn->xss_clean($_POST['permission-is-delete-promo'])));

    $permissions['featured'] = array("create" => $db->escapeString($fn->xss_clean($_POST['permission-is-create-featured'])), "read" => $db->escapeString($fn->xss_clean($_POST['permission-is-read-featured'])), "update" => $db->escapeString($fn->xss_clean($_POST['permission-is-update-featured'])), "delete" => $db->escapeString($fn->xss_clean($_POST['permission-is-delete-featured'])));

    $permissions['customers'] = array("read" => $db->escapeString($fn->xss_clean($_POST['permission-is-read-customers'])), "update" => $db->escapeString($fn->xss_clean($_POST['permission-is-update-customers'])));

    $permissions['payment'] = array("read" => $db->escapeString($fn->xss_clean($_POST['permission-is-read-payment'])), "update" => $db->escapeString($fn->xss_clean($_POST['permission-is-update-payment'])));

    $permissions['return_requests'] = array("read" => $db->escapeString($fn->xss_clean($_POST['permission-is-read-return'])), "update" => $db->escapeString($fn->xss_clean($_POST['permission-is-update-return'])), "delete" => $db->escapeString($fn->xss_clean($_POST['permission-is-delete-return'])));

    $permissions['delivery_boys'] = array("create" => $db->escapeString($fn->xss_clean($_POST['permission-is-create-delivery'])), "read" => $db->escapeString($fn->xss_clean($_POST['permission-is-read-delivery'])), "update" => $db->escapeString($fn->xss_clean($_POST['permission-is-update-delivery'])), "delete" => $db->escapeString($fn->xss_clean($_POST['permission-is-delete-delivery'])));

    $permissions['notifications'] = array("create" => $db->escapeString($fn->xss_clean($_POST['permission-is-create-notification'])), "read" => $db->escapeString($fn->xss_clean($_POST['permission-is-read-notification'])), "delete" => $db->escapeString($fn->xss_clean($_POST['permission-is-delete-notification'])));

    $permissions['transactions'] = array("read" => $db->escapeString($fn->xss_clean($_POST['permission-is-read-transaction'])));

    $permissions['fund_transfer_delivery_boy'] = array("read" => $db->escapeString($fn->xss_clean($_POST['permission-is-read-fund'])));

    $permissions['settings'] = array("read" => $db->escapeString($fn->xss_clean($_POST['permission-is-read-settings'])), "update" => $db->escapeString($fn->xss_clean($_POST['permission-is-update-settings'])));

    $permissions['locations'] = array("create" => $db->escapeString($fn->xss_clean($_POST['permission-is-create-location'])), "read" => $db->escapeString($fn->xss_clean($_POST['permission-is-read-location'])), "update" => $db->escapeString($fn->xss_clean($_POST['permission-is-update-location'])), "delete" => $db->escapeString($fn->xss_clean($_POST['permission-is-delete-location'])));

    $permissions['reports'] = array("create" => $db->escapeString($fn->xss_clean($_POST['permission-is-create-report'])), "read" => $db->escapeString($fn->xss_clean($_POST['permission-is-read-report'])));

    $permissions['faqs'] = array("create" => $db->escapeString($fn->xss_clean($_POST['permission-is-create-faq'])), "read" => $db->escapeString($fn->xss_clean($_POST['permission-is-read-faq'])), "update" => $db->escapeString($fn->xss_clean($_POST['permission-is-update-faq'])), "delete" => $db->escapeString($fn->xss_clean($_POST['permission-is-delete-faq'])));

    $permissions = json_encode($permissions);
    $sql = "UPDATE admin SET permissions='" . $permissions . "' WHERE id=" . $id;
    if ($db->sql($sql)) {
        echo '<label class="alert alert-success">Updated Successfully!</label>';
    } else {
        echo '<label class="alert alert-danger">Some Error Occrred! please try again.</label>';
    }
}

if (isset($_POST['seller_id']) && isset($_POST['save_seller_commission']) && !empty($_POST['save_seller_commission'])) {
    if (!checkadmin($auth_username)) {
        echo "<label class='alert alert-danger'>Access denied - You are not authorized to access this page.</label>";
        return false;
    }
    if ($permissions['sellers']['update'] == 0) {
        echo "<label class='alert alert-danger'>You have no permission to update seller.</label>";
        return false;
    }
    $seller_id = $db->escapeString($_POST['seller_id']);
    $category_ids = $fn->xss_clean_array($_POST['category_id']);
    $commission = $fn->xss_clean_array($_POST['commission']);
    for ($i = 0; $i < count($category_ids); $i++) {
        $result = $fn->get_data($columns = ['id'], "seller_id='" . $seller_id . "' and category_id='" . $category_ids[$i] . "'", 'seller_commission');
        if (isset($result[0]['id']) && !empty($result[0]['id'])) {
            $commission[$i] = isset($commission[$i]) && $commission[$i] > 0 ? $commission[$i] : 0;
            if ($commission[$i] > 0) {

                $sql = "update seller_commission set commission = " . $commission[$i] . " where id=" . $result[0]['id'];
            } else {
                $sql = "DELETE from seller_commission where id=" . $result[0]['id'];
            }
            $db->sql($sql);
        } else {
            if (!empty($commission[$i])) {
                $sql = "INSERT into seller_commission (seller_id,category_id,commission) VALUES ('" . $seller_id . "','" . $category_ids[$i] . "','" . $commission[$i] . "')";
                $db->sql($sql);
            }
        }
    }
    echo "<label class='alert alert-success'>Commission saved successfully.</label>";
}