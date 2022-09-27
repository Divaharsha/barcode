<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

if (isset($_GET['id'])) {
    $ID = $db->escapeString($fn->xss_clean($_GET['id']));
} else {
    // $ID = "";
    return false;
    exit(0);
}

if (isset($_POST['btnUpdate'])) {
    if ($permissions['goldsmithmaster']['update'] == 1) {
        $error = array();
        $name = $db->escapeString($fn->xss_clean($_POST['name']));
        $mobile = $db->escapeString($fn->xss_clean($_POST['mobile']));
        $digital_signature_number = $db->escapeString($fn->xss_clean($_POST['digital_signature_number']));
        $gst_number =$db->escapeString($fn->xss_clean($_POST['gst_number']));
        $pan_number = $db->escapeString($fn->xss_clean($_POST['pan_number']));
        $category = $db->escapeString($fn->xss_clean($_POST['category']));
        $sub_category = $db->escapeString($fn->xss_clean($_POST['sub_category']));
        $email = $db->escapeString($fn->xss_clean($_POST['email']));
        $address=$db->escapeString($fn->xss_clean($_POST['address']));
        $place=$db->escapeString($fn->xss_clean($_POST['place']));
        $open_cash_debit=$db->escapeString($fn->xss_clean($_POST['open_cash_debit']));
        $open_cash_credit=$db->escapeString($fn->xss_clean($_POST['open_cash_credit']));
        $open_pure_debit=$db->escapeString($fn->xss_clean($_POST['open_pure_debit']));
        $open_pure_credit=$db->escapeString($fn->xss_clean($_POST['open_pure_credit']));

        
        if (empty($name)) {
            $error['name'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($mobile)) {
            $error['mobile'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($digital_signature_number)) {
            $error['digital_signature_number'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($gst_number)) {
            $error['gst_number'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($pan_number)) {
            $error['pan_number'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($category)) {
            $error['category'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($sub_category)) {
            $error['sub_category'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($email)) {
            $error['email'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($address)) {
            $error['address'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($place)) {
            $error['place'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($open_cash_debit)) {
            $error['open_cash_debit'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($open_cash_credit)) {
            $error['open_cash_credit'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($open_pure_debit)) {
            $error['open_pure_debit'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($open_pure_credit)) {
            $error['open_pure_credit'] = " <span class='label label-danger'>Required!</span>";
        }
       
       
       

        if ( !empty($name) && !empty($mobile) && !empty($digital_signature_number) && !empty($gst_number) && !empty($pan_number) && !empty($category) && !empty($sub_category) && !empty($email) && !empty($address) && !empty($place) && !empty($open_cash_debit) && !empty($open_cash_credit) && !empty($open_pure_debit) && !empty($open_pure_credit))
        {
                $sql = "UPDATE goldsmith_master SET name='$name',mobile='$mobile',digital_signature_number='$digital_signature_number',gst_number='$gst_number',pan_number='$pan_number',category='$category',sub_category='$sub_category',open_cash_debit='$open_cash_debit',open_cash_credit='$open_cash_credit',open_pure_debit='$open_pure_debit',open_pure_credit='$open_pure_credit',email='$email',address='$address',place='$place' WHERE id='$ID'";
                $db->sql($sql);
                $goldsmithmaster_result = $db->getResult();
                if (!empty($goldsmithmaster_result)) {
                    $goldsmithmaster_result = 0;
                } else {
                    $goldsmithmaster_result = 1;
                }
                if ($goldsmithmaster_result == 1) {
                    $error['add_menu'] = "<section class='content-header'>
                                                    <span class='label label-success'>Dealer Goldsmith Master Updated Successfully</span>
                                                    <h4><small><a  href='goldsmithmasters.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Goldsmith Master</a></small></h4>
                                                     </section>";
                } else {
                    $error['add_menu'] = " <span class='label label-danger'>Failed</span>";
                }

        }
    }
    
}

$data = array();

$sql_query = "SELECT * FROM `goldsmith_master` WHERE id = '$ID'";
$db->sql($sql_query);
$res = $db->getResult();
foreach ($res as $row)
$data = $row;

?>
<section class="content-header">
    <h1>Edit Dealer Goldsmith Master</h1>
    <?php echo isset($error['add_menu']) ? $error['add_menu'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
        <?php if ($permissions['goldsmithmaster']['update'] == 0) { ?>
                <div class="alert alert-danger">You have no permission to update goldsmith master.</div>
            <?php } ?>
            <div class="box box-primary">
                <div class="box-header with-border">
                </div>
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form id='edit_goldsmith_master_form' method="post" enctype="multipart/form-data">
                    <div class="box-body">
                            <div class="row">
                                    <div class="form-group">
                                        <div class='col-md-4'>
                                            <label for="exampleInputEmail1"> Name</label> <i class="text-danger asterik">*</i><?php echo isset($error['name']) ? $error['name'] : ''; ?>
                                            <input type="text" class="form-control" name="name" value="<?php echo $data['name']?>">
                                        </div>
                                    <div class='col-md-4'>
                                            <label for="exampleInputEmail1">Payment Mobile Number</label> <i class="text-danger asterik">*</i><?php echo isset($error['mobile']) ? $error['mobile'] : ''; ?>
                                            <input type="number" class="form-control" name="mobile" value="<?php echo $data['mobile']?>">
                                        </div>
                                        <div class='col-md-4'>
                                            <label for="exampleInputEmail1">Digital Signature Number</label> <i class="text-danger asterik">*</i><?php echo isset($error['digital_signature_number']) ? $error['digital_signature_number'] : ''; ?>
                                            <input type="number" class="form-control" name="digital_signature_number" value="<?php echo $data['digital_signature_number']?>">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <div class='col-md-5'>
                                            <label for="exampleInputEmail1">GST Number</label> <i class="text-danger asterik">*</i><?php echo isset($error['gst_number']) ? $error['gst_number'] : ''; ?>
                                            <input type="text" class="form-control" name="gst_number" value="<?php echo $data['gst_number']?>">
                                        </div>
                                        <div class='col-md-5'>
                                            <label for="exampleInputEmail1">PAN Number</label> <i class="text-danger asterik">*</i><?php echo isset($error['pan_number']) ? $error['pan_number'] : ''; ?>
                                            <input type="text" class="form-control" name="pan_number" value="<?php echo $data['pan_number']?>">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <div class='col-md-5'>
                                            <label for="">Select Category</label> <i class="text-danger asterik">*</i>
                                                <select id='category' name="category" class='form-control' required>
                                                    <option value="">--Select Category--</option>
                                                        <?php
                                                        $sql = "SELECT * FROM `categories`";
                                                        $db->sql($sql);
                                                        $result = $db->getResult();
                                                        foreach ($result as $value) {
                                                        ?>
													 <option value='<?= $value['name'] ?>' <?= $value['name']==$data['category'] ? 'selected="selected"' : '';?>><?= $value['name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                        </div>
                                        <div class='col-md-5'>
                                        <label for="">Select Sub-Category</label> <i class="text-danger asterik">*</i>
                                                <select id='sub_category' name="sub_category" class='form-control' required>
                                                    <option value="">--Select sub-category--</option>
                                                        <?php
                                                        $sql = "SELECT * FROM `subcategories`";
                                                        $db->sql($sql);
                                                        $result = $db->getResult();
                                                        foreach ($result as $value) {
                                                        ?>
													 <option value='<?= $value['name'] ?>' <?= $value['name']==$data['sub_category'] ? 'selected="selected"' : '';?>><?= $value['name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <div class='col-md-3'>
                                            <label for="exampleInputEmail1">Open Cash Debit</label> <i class="text-danger asterik">*</i><?php echo isset($error['open_cash_debit']) ? $error['open_cash_debit'] : ''; ?>
                                            <input type="text" class="form-control" name="open_cash_debit" value="<?php echo $data['open_pure_debit']?>">
                                        </div>
                                        <div class='col-md-3'>
                                            <label for="exampleInputEmail1">Open Cash Debit</label> <i class="text-danger asterik">*</i><?php echo isset($error['open_cash_credit']) ? $error['open_cash_credit'] : ''; ?>
                                            <input type="text" class="form-control" name="open_cash_credit" value="<?php echo $data['open_cash_credit']?>">
                                        </div>
                                        <div class='col-md-3'>
                                            <label for="exampleInputEmail1">Open Cash Debit</label> <i class="text-danger asterik">*</i><?php echo isset($error['open_pure_debit']) ? $error['open_pure_debit'] : ''; ?>
                                            <input type="text" class="form-control" name="open_pure_debit" value="<?php echo $data['open_pure_debit']?>">
                                        </div>
                                        <div class='col-md-3'>
                                            <label for="exampleInputEmail1">Open Cash Debit</label> <i class="text-danger asterik">*</i><?php echo isset($error['open_pure_credit']) ? $error['open_pure_credit'] : ''; ?>
                                            <input type="text" class="form-control" name="open_pure_credit" value="<?php echo $data['open_pure_credit']?>">
                                        </div>
                                    </div>    
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <div class='col-md-4'>
                                            <label for="exampleInputEmail1">Email Id</label> <i class="text-danger asterik">*</i><?php echo isset($error['email']) ? $error['email'] : ''; ?>
                                            <input type="email" class="form-control" name="email" value="<?php echo $data['email']?>">
                                        </div>
                                        <div class='col-md-4'>
                                            <label for="exampleInputEmail1">Address</label> <i class="text-danger asterik">*</i><?php echo isset($error['address']) ? $error['address'] : ''; ?>
                                            <input type="text" class="form-control" name="address" value="<?php echo $data['address']?>">
                                        </div>
                                        <div class='col-md-4'>
                                            <label for="exampleInputEmail1">Place</label> <i class="text-danger asterik">*</i><?php echo isset($error['place']) ? $error['place'] : ''; ?>
                                            <input type="text" class="form-control" name="place" value="<?php echo $data['place']?>">
                                        </div>
                                    </div>    
                                </div>

                        

                    </div><!-- /.box-body -->
                    
                    <div class="box-footer">
                        <input type="submit" class="btn-primary btn" value="Update" name="btnUpdate" />&nbsp;
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<div class="separator"> </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>