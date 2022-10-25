<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;


$sql_query = "SELECT value FROM settings WHERE variable = 'Currency'";
$pincode_ids_exc = "";
$db->sql($sql_query);
$res_cur = $db->getResult();
?>
<?php
if (isset($_POST['btnAdd'])) {
    if ($permissions['goldsmithmaster']['create'] == 1) {
        $error = array();
        $name = $db->escapeString($fn->xss_clean($_POST['name']));
        $goldsmith_type = $db->escapeString($fn->xss_clean($_POST['goldsmith_type']));
        $mobile = $db->escapeString($fn->xss_clean($_POST['mobile']));
        $digital_signature_number = $db->escapeString($fn->xss_clean($_POST['digital_signature_number']));
        $gst_number =$db->escapeString($fn->xss_clean($_POST['gst_number']));
        $pan_number = $db->escapeString($fn->xss_clean($_POST['pan_number']));
        $email = $db->escapeString($fn->xss_clean($_POST['email']));
        $address=$db->escapeString($fn->xss_clean($_POST['address']));
        $place=$db->escapeString($fn->xss_clean($_POST['place']));
        $open_cash_debit = (isset($_POST['open_cash_debit']) && !empty($_POST['open_cash_debit'])) ? $db->escapeString($fn->xss_clean($_POST['open_cash_debit'])) : "0";
        $open_cash_credit = (isset($_POST['open_cash_credit']) && !empty($_POST['open_cash_credit'])) ? $db->escapeString($fn->xss_clean($_POST['open_cash_credit'])) : "0";
        $open_pure_debit = (isset($_POST['open_pure_debit']) && !empty($_POST['open_pure_debit'])) ? $db->escapeString($fn->xss_clean($_POST['open_pure_debit'])) : "0";
        $open_pure_credit = (isset($_POST['open_pure_credit']) && !empty($_POST['open_pure_credit'])) ? $db->escapeString($fn->xss_clean($_POST['open_pure_credit'])) : "0";

        
        if (empty($name)) {
            $error['name'] = " <span class='label label-danger'>Required!</span>";
        }
         
        if (empty($goldsmith_type)) {
            $error['goldsmith_type'] = " <span class='label label-danger'>Required!</span>";
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
        if (empty($email)) {
            $error['email'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($address)) {
            $error['address'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($place)) {
            $error['place'] = " <span class='label label-danger'>Required!</span>";
        }
       
       
       

        if ( !empty($name) && !empty($goldsmith_type) && !empty($mobile) && !empty($digital_signature_number) && !empty($gst_number) && !empty($pan_number) && !empty($email) && !empty($address) && !empty($place))
        {
                $sql = "INSERT INTO goldsmith_master (name,goldsmith_type,mobile,digital_signature_number,gst_number,pan_number,email,address,place,open_cash_debit,open_cash_credit,open_pure_debit,open_pure_credit) VALUES('$name','$goldsmith_type','$mobile','$digital_signature_number','$gst_number','$pan_number','$email','$address','$place','$open_cash_debit','$open_cash_credit','$open_pure_debit','$open_pure_credit')";
                $db->sql($sql);
                $goldsmithmaster_result = $db->getResult();
                if (!empty($goldsmithmaster_result)) {
                    $goldsmithmaster_result = 0;
                } else {
                    $goldsmithmaster_result = 1;
                }
                if ($goldsmithmaster_result == 1) {
                    $sql = "SELECT id FROM goldsmith_master ORDER BY id DESC LIMIT 1";
                    $db->sql($sql);
                    $res = $db->getResult();
                    $goldsmith_master_id = $res[0]['id'];
                    for ($i = 0; $i < count($_POST['subcategory_id']); $i++) {
                        $subcategory_id = $db->escapeString(($_POST['subcategory_id'][$i]));
                        $touch = (isset($_POST['touch'][$i]) && !empty($_POST['touch'][$i])) ? $db->escapeString($fn->xss_clean($_POST['touch'][$i])) : "0";
                        $sql = "INSERT INTO goldsmith_master_variant (goldsmith_master_id,subcategory_id,touch) VALUES('$goldsmith_master_id','$subcategory_id','$touch')";
                        $db->sql($sql);
                        $tab_result = $db->getResult();
                    }
                    if (!empty($tab_result)) {
                        $tab_result = 0;
                    } else {
                        $tab_result = 1;
                    }

                    $error['add_menu'] = "<section class='content-header'>
                    <span class='label label-success'>Dealer Goldsmith Master Added Successfully</span>
                    <h4><small><a  href='goldsmithmasters.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Goldsmith Master</a></small></h4>
                    </section>";
                }
                else {
                    $error['add_menu'] = " <span class='label label-danger'>Failed</span>";

                }
            }else{
                    $error['add_menu'] = " <span class='label label-danger'>Dealer Goldsmith Master Already Exists</span>";

                }
    }else{
        $error['check_permission'] = " <section class='content-header'><span class='label label-danger'>You have no permission to create gold smith master</span></section>";
    }
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
                                <div class='form-group col-md-4'>
                                        <label for="">Goldsmith Type</label> <i class="text-danger asterik">*</i> <?php echo isset($error['goldsmith_type']) ? $error['goldsmith_type'] : ''; ?><br>
                                        <select id="goldsmith_type" name="goldsmith_type" class="form-control">
                                            <option value="Both">Both</option>
                                            <option value="Seller">Seller</option>
                                            <option value="Buyer">Buyer</option>
                                        </select>
                                 </div>
                               <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Payment Mobile Number</label> <i class="text-danger asterik">*</i><?php echo isset($error['mobile']) ? $error['mobile'] : ''; ?>
                                    <input type="number" class="form-control" name="mobile" required>
                                </div>
                            
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Digital Signature Number</label> <i class="text-danger asterik">*</i><?php echo isset($error['digital_signature_number']) ? $error['digital_signature_number'] : ''; ?>
                                    <input type="number" class="form-control" name="digital_signature_number" required>
                                </div>
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">GST Number</label> <i class="text-danger asterik">*</i><?php echo isset($error['gst_number']) ? $error['gst_number'] : ''; ?>
                                    <input type="text" class="form-control" name="gst_number" required>
                                </div>
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">PAN Number</label> <i class="text-danger asterik">*</i><?php echo isset($error['pan_number']) ? $error['pan_number'] : ''; ?>
                                    <input type="text" class="form-control" name="pan_number" required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div id="packate_div">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group packate_div">
                                        <label for="exampleInputEmail1">Subcategory</label> <i class="text-danger asterik">*</i>
                                            <select id='subcategory_id' name="subcategory_id[]" class='form-control' required>
                                                <option value="">--Select Subcategory--</option>
                                                    <?php
                                                    $sql = "SELECT id,name FROM `subcategories`";
                                                    $db->sql($sql);
                                                    $result = $db->getResult();
                                                    foreach ($result as $value) {
                                                    ?>
                                                        <option value='<?= $value['id'] ?>'><?= $value['name'] ?></option>
                                                <?php } ?>
                                            </select> 
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group packate_div">
                                        <label for="exampleInputEmail1">Touch</label> <i class="text-danger asterik">*</i>
                                        <input type="text"  class="form-control" name="touch[]" required/>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <label>Tab</label>
                                    <a class="add_packate_variation" title="Add variation" style="cursor: pointer;color:white;"><button class="btn btn-warning">Add more</button></a>
                                </div>
                                <div id="variations">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-3'>
                                    <label for="exampleInputEmail1">Open Cash Debit</label> <i class="text-danger asterik">*</i><?php echo isset($error['open_cash_debit']) ? $error['open_cash_debit'] : ''; ?>
                                    <input type="text" class="form-control" name="open_cash_debit">
                                </div>
                                <div class='col-md-3'>
                                    <label for="exampleInputEmail1">Open Cash Credit</label> <i class="text-danger asterik">*</i><?php echo isset($error['open_cash_credit']) ? $error['open_cash_credit'] : ''; ?>
                                    <input type="text" class="form-control" name="open_cash_credit">
                                </div>
                                <div class='col-md-3'>
                                    <label for="exampleInputEmail1">Open Pure Debit</label> <i class="text-danger asterik">*</i><?php echo isset($error['open_pure_debit']) ? $error['open_pure_debit'] : ''; ?>
                                    <input type="text" class="form-control" name="open_pure_debit">
                                </div>
                                <div class='col-md-3'>
                                    <label for="exampleInputEmail1">Open Pure Credit</label> <i class="text-danger asterik">*</i><?php echo isset($error['open_pure_credit']) ? $error['open_pure_credit'] : ''; ?>
                                    <input type="text" class="form-control" name="open_pure_credit">
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
            <?php echo isset($error['check_permission']) ? $error['check_permission'] : ''; ?>
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
        $email = "required",
        $address="required",
        $place="required",
         }
    });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        var max_fields =8;
        var wrapper = $("#packate_div");
        var add_button = $(".add_packate_variation");

        var x = 1;
        $(add_button).click(function (e) {
            e.preventDefault();
            if (x < max_fields) {
                x++;
                $(wrapper).append('<div class="row"><div class="col-md-6"><div class="form-group"><label for="subcategory">Sub Category</label>' +'<select id=subcategory_id name="subcategory_id[]" class="form-control" required><option value="">Select</option><?php
                                                            $sql = "SELECT id,name FROM `subcategories`";
                                                            $db->sql($sql);
                                                            $result = $db->getResult();
                                                            foreach ($result as $value) {
                                                            ?><option value="<?= $value['id'] ?>"><?= $value['name'] ?></option><?php } ?></select></div></div>'+ '<div class="col-md-4"><div class="form-group"><label for="touch">Touch</label>'+'<input number="text" class="form-control" name="touch[]" /></div></div>'+'<div class="col-md-1" style="display: grid;"><label>Tab</label><a class="remove" style="cursor:pointer;color:white;"><button class="btn btn-danger">Remove</button></a></div>'+'</div>');
            }
            else{
                alert('You Reached the limits')
            }
        });

        $(wrapper).on("click", ".remove", function (e) {
            e.preventDefault();
            $(this).closest('.row').remove();
            x--;
        })
    });
</script>
