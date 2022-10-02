<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

$sql_query = "SELECT id, name FROM categories ORDER BY id ASC";
$db->sql($sql_query);
$res = $db->getResult();

$sql_query = "SELECT value FROM settings WHERE variable = 'Currency'";
$pincode_ids_exc = "";
$db->sql($sql_query);
$res_cur = $db->getResult();

if (isset($_POST['btnAdd'])) {
    if ($permissions['goldsmithmaster']['create'] == 1) {
        $error = array();
        $name = $db->escapeString($fn->xss_clean($_POST['name']));
        $mobile = $db->escapeString($fn->xss_clean($_POST['mobile']));
        $digital_signature_number = $db->escapeString($fn->xss_clean($_POST['digital_signature_number']));
        $gst_number =$db->escapeString($fn->xss_clean($_POST['gst_number']));
        $pan_number = $db->escapeString($fn->xss_clean($_POST['pan_number']));
        $category_id = $db->escapeString($fn->xss_clean($_POST['category_id']));
        $subcategory_id = $db->escapeString($fn->xss_clean($_POST['subcategory_id']));
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
        if (empty($category_id)) {
            $error['category_id'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($subcategory_id)) {
            $error['subcategory_id'] = " <span class='label label-danger'>Required!</span>";
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
       
       
       

        if ( !empty($name) && !empty($mobile) && !empty($digital_signature_number) && !empty($gst_number) && !empty($pan_number) && !empty($category_id) && !empty($subcategory_id) && !empty($email) && !empty($address) && !empty($place) && !empty($open_cash_debit) && !empty($open_cash_credit) && !empty($open_pure_debit) && !empty($open_pure_credit))
        {
                $sql = "INSERT INTO goldsmith_master (name,mobile,digital_signature_number,gst_number,pan_number,category_id,subcategory_id,email,address,place,open_cash_debit,open_cash_credit,open_pure_debit,open_pure_credit) VALUES('$name','$mobile','$digital_signature_number','$gst_number','$pan_number','$category_id','$subcategory_id','$email','$address','$place','$open_cash_debit','$open_cash_credit','$open_pure_debit','$open_pure_credit')";
                $db->sql($sql);
                $goldsmithmaster_result = $db->getResult();
                if (!empty($goldsmithmaster_result)) {
                    $goldsmithmaster_result = 0;
                } else {
                    $goldsmithmaster_result = 1;
                }
                if ($goldsmithmaster_result == 1) {
                    $error['add_menu'] = "<section class='content-header'>
                                                    <span class='label label-success'>Dealer Goldsmith Master Added Successfully</span>
                                                    <h4><small><a  href='goldsmithmasters.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Goldsmith Master</a></small></h4>
                                                     </section>";
                } else {
                    $error['add_menu'] = " <span class='label label-danger'>Failed</span>";
                }

            }else{
                $error['add_menu'] = " <span class='label label-danger'>Dealer Goldsmith Master Already Exists</span>";

            }


        }
    }else{
        $error['check_permission'] = " <section class='content-header'><span class='label label-danger'>You have no permission to create gold smith master</span></section>";

    }

?>
<section class="content-header">
    <h1>Add Dealer Goldsmith Master</h1>
    <?php echo isset($error['add_menu']) ? $error['add_menu'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
        <?php if ($permissions['goldsmithmaster']['create'] == 0) { ?>
                <div class="alert alert-danger">You have no permission to create goldsmith master.</div>
            <?php } ?>
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form id='add_goldsmith_master_form' method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1"> Name</label> <i class="text-danger asterik">*</i><?php echo isset($error['name']) ? $error['name'] : ''; ?>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                               <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Payment Mobile Number</label> <i class="text-danger asterik">*</i><?php echo isset($error['mobile']) ? $error['mobile'] : ''; ?>
                                    <input type="number" class="form-control" name="mobile" required>
                                </div>
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Digital Signature Number</label> <i class="text-danger asterik">*</i><?php echo isset($error['digital_signature_number']) ? $error['digital_signature_number'] : ''; ?>
                                    <input type="number" class="form-control" name="digital_signature_number" required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-5'>
                                    <label for="exampleInputEmail1">GST Number</label> <i class="text-danger asterik">*</i><?php echo isset($error['gst_number']) ? $error['gst_number'] : ''; ?>
                                    <input type="text" class="form-control" name="gst_number" required>
                                </div>
                                <div class='col-md-5'>
                                    <label for="exampleInputEmail1">PAN Number</label> <i class="text-danger asterik">*</i><?php echo isset($error['pan_number']) ? $error['pan_number'] : ''; ?>
                                    <input type="text" class="form-control" name="pan_number" required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-5'>
                                    <label for="">Select Category</label> <i class="text-danger asterik">*</i><?php echo isset($error['category_id']) ? $error['category_id'] : ''; ?>
                                        <select id='category_id' name="category_id" class='form-control' required>
                                            <option value="">--Select Category--</option>
                                                <?php
                                                $sql = "SELECT * FROM `categories`";
                                                $db->sql($sql);
                                                $result = $db->getResult();
                                                foreach ($result as $value) {
                                                ?>
                                                    <option value='<?= $value['id'] ?>'><?= $value['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                </div>
                                <div class='col-md-5'>
                                <label for="">Select Sub-Category</label> <i class="text-danger asterik">*</i><?php echo isset($error['subcategory_id']) ? $error['subcategory_id'] : ''; ?>
                                        <select id='subcategory_id' name="subcategory_id" class='form-control' required>
                                            <option value="">--Select sub-category--</option>
                                        </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-3'>
                                    <label for="exampleInputEmail1">Open Cash Debit</label> <i class="text-danger asterik">*</i><?php echo isset($error['open_cash_debit']) ? $error['open_cash_debit'] : ''; ?>
                                    <input type="text" class="form-control" name="open_cash_debit" required>
                                </div>
                                <div class='col-md-3'>
                                    <label for="exampleInputEmail1">Open Cash Credit</label> <i class="text-danger asterik">*</i><?php echo isset($error['open_cash_credit']) ? $error['open_cash_credit'] : ''; ?>
                                    <input type="text" class="form-control" name="open_cash_credit" required>
                                </div>
                                <div class='col-md-3'>
                                    <label for="exampleInputEmail1">Open Pure Debit</label> <i class="text-danger asterik">*</i><?php echo isset($error['open_pure_debit']) ? $error['open_pure_debit'] : ''; ?>
                                    <input type="text" class="form-control" name="open_pure_debit" required>
                                </div>
                                <div class='col-md-3'>
                                    <label for="exampleInputEmail1">Open Pure Credit</label> <i class="text-danger asterik">*</i><?php echo isset($error['open_pure_credit']) ? $error['open_pure_credit'] : ''; ?>
                                    <input type="text" class="form-control" name="open_pure_credit" required>
                                </div>
                            </div>    
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Email Id</label> <i class="text-danger asterik">*</i><?php echo isset($error['email']) ? $error['email'] : ''; ?>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Address</label> <i class="text-danger asterik">*</i><?php echo isset($error['address']) ? $error['address'] : ''; ?>
                                    <input type="text" class="form-control" name="address" required>
                                </div>
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Place</label> <i class="text-danger asterik">*</i><?php echo isset($error['place']) ? $error['place'] : ''; ?>
                                    <input type="text" class="form-control" name="place" required>
                                </div>
                            </div>    
                        </div>


                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <input type="submit" class="btn-primary btn" value="Add Goldsmith Master" name="btnAdd" />&nbsp;
                        <input type="reset" class="btn-danger btn" value="Clear" id="btnClear" />
                    </div>
                </form>
            </div>
            <!-- <?php echo isset($error['check_permission']) ? $error['check_permission'] : ''; ?> -->
            <!-- /.box -->
        </div>
    </div>
</section>
<div class="separator"> </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
    $('#add_goldsmith_master_form').validate({

        ignore: [],
        debug: false,
        rules: {
            $name = "required",
        $mobile = "required",
        $digital_signature_number ="required",
        $gst_number ="required",
        $pan_number="required",
        $category_id = "required",
        $subcategory_id = "required",
        $email = "required",
        $address="required",
        $place="required",
        $open_cash_debit="required",
        $open_cash_credit="required",
        $open_pure_debit="required",
        $open_pure_credit="required",
         }
    });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });

</script>
<script>
     $(document).on('change', '#category_id', function() {
        $.ajax({
            url: "public/db-operation.php",
            data: "category_id=" + $('#category_id').val() + "&change_category=1",
            method: "POST",
            success: function(data) {
                $('#subcategory_id').html("<option value=''>---Select Subcategory---</option>" + data);
            }
        });
    });
</script>
