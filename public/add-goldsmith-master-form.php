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
        $weight_method=$db->escapeString($fn->xss_clean($_POST['weight_method']));
        $display_subcategory=$db->escapeString($fn->xss_clean($_POST['display_subcategory']));
        $rate_method=$db->escapeString($fn->xss_clean($_POST['rate_method']));
        $credit_note = (isset($_POST['credit_note']) && !empty($_POST['credit_note'])) ? $db->escapeString($fn->xss_clean($_POST['credit_note'])) : "0";
        $debit_note = (isset($_POST['debit_note']) && !empty($_POST['debit_note'])) ? $db->escapeString($fn->xss_clean($_POST['debit_note'])) : "0";
        $huid_charge=$db->escapeString($fn->xss_clean($_POST['huid_charge']));
        $credit_limit=$db->escapeString($fn->xss_clean($_POST['credit_limit']));
        $activate_stone_pieces=$db->escapeString($fn->xss_clean($_POST['activate_stone_pieces']));
        $stone_weight = (isset($_POST['stone_weight']) && !empty($_POST['stone_weight'])) ? $db->escapeString($fn->xss_clean($_POST['stone_weight'])) : "0";
        $stone_charges = (isset($_POST['stone_charges']) && !empty($_POST['stone_charges'])) ? $db->escapeString($fn->xss_clean($_POST['stone_charges'])) : "0";
        $shop_type=$db->escapeString($fn->xss_clean($_POST['shop_type']));
        $corporate_type=$db->escapeString($fn->xss_clean($_POST['corporate_type']));


        
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
        if (empty($display_subcategory)) {
            $error['display_subcategory'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($weight_method)) {
            $error['weight_method'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($rate_method)) {
            $error['rate_method'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($huid_charge)) {
            $error['huid_charge'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($credit_limit)) {
            $error['credit_limit'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($activate_stone_pieces)) {
            $error['activate_stone_pieces'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($shop_type)) {
            $error['shop_type'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($corporate_type)) {
            $error['corporate_type'] = " <span class='label label-danger'>Required!</span>";
        }
       

        if ( !empty($name) && !empty($goldsmith_type) && !empty($mobile) && !empty($digital_signature_number) && !empty($gst_number) && !empty($pan_number) && !empty($email) && !empty($address) && !empty($place)  && !empty($display_subcategory)  && !empty($weight_method) && !empty($rate_method) && !empty($huid_charge)  && !empty($credit_limit)  && !empty($activate_stone_pieces)  && !empty($shop_type)  && !empty($corporate_type))
        {
                $sql = "INSERT INTO goldsmith_master (name,goldsmith_type,mobile,digital_signature_number,gst_number,pan_number,email,address,place,open_cash_debit,open_cash_credit,open_pure_debit,open_pure_credit,weight_method,display_subcategory,rate_method,credit_note,debit_note,huid_charge,credit_limit,activate_stone_pieces,stone_weight,stone_charges,shop_type,corporate_type) VALUES('$name','$goldsmith_type','$mobile','$digital_signature_number','$gst_number','$pan_number','$email','$address','$place','$open_cash_debit','$open_cash_credit','$open_pure_debit','$open_pure_credit','$weight_method','$display_subcategory','$rate_method','$credit_note','$debit_note','$huid_charge','$credit_limit','$activate_stone_pieces','$stone_weight','$stone_charges','$shop_type','$corporate_type')";
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
                                    <label for="exampleInputEmail1">Digital Sign Phone Number</label> <i class="text-danger asterik">*</i><?php echo isset($error['digital_signature_number']) ? $error['digital_signature_number'] : ''; ?>
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
                        <br>
                        <div class="row">
                                <div class='form-group col-md-4'>
                                        <label for="">Weight Method</label> <i class="text-danger asterik">*</i> <?php echo isset($error['weight_method']) ? $error['weight_method'] : ''; ?><br>
                                        <select id="weight_method" name="weight_method" class="form-control">
                                            <option value="Accurate Weight">Accurate Weight</option>
                                            <option value="Approximate Weight">Approximate Weight</option>
                                        </select>
                                 </div>
                                 <div class='form-group col-md-4'>
                                        <label for="">Display Sub Category</label> <i class="text-danger asterik">*</i> <?php echo isset($error['display_subcategory']) ? $error['display_subcategory'] : ''; ?><br>
                                        <select id="display_subcategory" name="display_subcategory" class="form-control">
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                 </div>
                                 <div class='form-group col-md-4'>
                                        <label for="">Rate Cut Method</label> <i class="text-danger asterik">*</i> <?php echo isset($error['rate_method']) ? $error['rate_method'] : ''; ?><br>
                                        <select id="rate_method" name="rate_method" class="form-control">
                                            <option value="TDS">TDS Rate</option>
                                            <option value="TCS">TCS Rate</option>
                                        </select>
                                 </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Credit Note</label> <i class="text-danger asterik">*</i><?php echo isset($error['credit_note']) ? $error['credit_note'] : ''; ?>
                                    <input type="number" class="form-control" name="credit_note">
                                </div>
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Debit Note</label> <i class="text-danger asterik">*</i><?php echo isset($error['debit_note']) ? $error['debit_note'] : ''; ?>
                                    <input type="number" class="form-control" name="debit_note">
                                </div>
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">HUID Charge</label> <i class="text-danger asterik">*</i><?php echo isset($error['huid_charge']) ? $error['huid_charge'] : ''; ?>
                                    <input type="number" class="form-control" name="huid_charge" required>
                                </div>
                            </div>    
                        </div>
                        <br>
                        <div class="row">
                               <div class='form-group col-md-3'>
                                    <label for="exampleInputEmail1">Credit Limit</label> <i class="text-danger asterik">*</i><?php echo isset($error['credit_limit']) ? $error['credit_limit'] : ''; ?>
                                    <input type="text" class="form-control" name="credit_limit" required>
                                </div>
                                 <div class='form-group col-md-3'>
                                        <label for="">Activate Stone Pieces</label> <i class="text-danger asterik">*</i> <?php echo isset($error['activate_stone_pieces']) ? $error['activate_stone_pieces'] : ''; ?><br>
                                        <select id="activate_stone_pieces" name="activate_stone_pieces" class="form-control" required>
                                           <option value="">Select</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                 </div>
                                <div class='form-group col-md-3' id="stone_weight" style="display:none">
                                    <label for="exampleInputEmail1">Stone Weight/piece</label> <i class="text-danger asterik">*</i>
                                    <input type="text" class="form-control" name="stone_weight">
                                </div>
                                <div class='form-group col-md-3' id="stone_charges" style="display:none">
                                    <label for="exampleInputEmail1">Stone Charges</label> <i class="text-danger asterik">*</i>
                                    <input type="number" class="form-control" name="stone_charges">
                                </div>
                        </div>
                        <br>
                        <div class="row">
                               <div class='form-group col-md-4'>
                                        <label for="">Shop Type</label> <i class="text-danger asterik">*</i> <?php echo isset($error['shop_type']) ? $error['shop_type'] : ''; ?><br>
                                        <select id="shop_type" name="shop_type" class="form-control" required>
                                            <option value="Single Shop">Single Shop</option>
                                            <option value="Corporate">Corporate</option>
                                        </select>   
                                 </div>
                                 <div class='form-group col-md-4' id="corporate_type" style="display:none">
                                        <label for="">Corporate Type</label> <i class="text-danger asterik">*</i>
                                        <select  name="corporate_type" class="form-control">
                                            <option value="Head Office">Head Office</option>
                                            <option value="Branch">Branch</option>
                                            <option value="Delivery">Delivery</option>
                                        </select>   
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
<script>
    $("#activate_stone_pieces").change(function() {
        activate_stone_pieces = $("#activate_stone_pieces").val();
        if(activate_stone_pieces == "Yes"){
            $("#stone_weight").show();
            $("#stone_charges").show();

        }
        if(activate_stone_pieces == "No"){
            $("#stone_weight").hide();
            $("#stone_charges").hide();
        }
        if(activate_stone_pieces == ""){
            $("#stone_weight").hide();
            $("#stone_charges").hide();
        }
    });
</script>

<!---Shop type --->
<script>
    $("#shop_type").change(function() {
        shop_type = $("#shop_type").val();
        if(shop_type == "Corporate"){
            $("#corporate_type").show();

        }
        if(shop_type == "Single Shop"){
            $("#corporate_type").hide();
        }
    });
</script>
