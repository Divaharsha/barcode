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
$category_data = array();
$sql = "select id,name from categories order by id asc";
$db->sql($sql);
$category_data = $db->getResult();
$sql = "select * from subcategories";
$db->sql($sql);
$subcategory = $db->getResult();

if (isset($_POST['btnUpdate'])) {
    if ($permissions['goldsmithmaster']['update'] == 1) {
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
        $open_pure_credit = (isset($_POST['open_pure_credit']) && !empty($_POST['open_pure_credit'])) ? $db->escapeString($fn->xss_clean($_POST['open_pure_credit'])) : "0";        $open_pure_credit=$db->escapeString($fn->xss_clean($_POST['open_pure_credit']));
        $weight_method=$db->escapeString($fn->xss_clean($_POST['weight_method']));
        $display_subcategory=$db->escapeString($fn->xss_clean($_POST['display_subcategory']));
        $rate_method=$db->escapeString($fn->xss_clean($_POST['rate_method']));
        $credit_note = (isset($_POST['credit_note']) && !empty($_POST['credit_note'])) ? $db->escapeString($fn->xss_clean($_POST['credit_note'])) : "0";
        $debit_note = (isset($_POST['debit_note']) && !empty($_POST['debit_note'])) ? $db->escapeString($fn->xss_clean($_POST['debit_note'])) : "0";
        $huid_charge = (isset($_POST['huid_charge']) && !empty($_POST['huid_charge'])) ? $db->escapeString($fn->xss_clean($_POST['huid_charge'])) : "0";
        $credit_limit = (isset($_POST['credit_limit']) && !empty($_POST['credit_limit'])) ? $db->escapeString($fn->xss_clean($_POST['credit_limit'])) : "0";
        $activate_stone_pieces=$db->escapeString($fn->xss_clean($_POST['activate_stone_pieces']));
        $stone_weight = (isset($_POST['stone_weight']) && !empty($_POST['stone_weight'])) ? $db->escapeString($fn->xss_clean($_POST['stone_weight'])) : "0";
        $stone_charges = (isset($_POST['stone_charges']) && !empty($_POST['stone_charges'])) ? $db->escapeString($fn->xss_clean($_POST['stone_charges'])) : "0";
        $shop_type=$db->escapeString($fn->xss_clean($_POST['shop_type']));
        $corporate_type=$db->escapeString($fn->xss_clean($_POST['corporate_type']));
        $subcat_id = (isset($_POST['subcat_ids'])) ? $fn->xss_clean_array($_POST['subcat_ids']) : "";
        $subcat_ids = "";
        if (!empty($subcat_id)) {
            $subcat_ids = implode(",", $subcat_id);
            $subcat_ids = $db->escapeString($subcat_ids);
        }

        
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
   

       
        if ( !empty($name) && !empty($goldsmith_type) && !empty($mobile) && !empty($digital_signature_number) && !empty($gst_number) && !empty($pan_number) && !empty($email) && !empty($address) && !empty($place)  && !empty($display_subcategory)  && !empty($weight_method) && !empty($rate_method)  && !empty($activate_stone_pieces)  && !empty($shop_type))
        {
                if($shop_type=='Single Shop'){
                    $sql = "UPDATE goldsmith_master SET name='$name',goldsmith_type='$goldsmith_type',mobile='$mobile',digital_signature_number='$digital_signature_number',gst_number='$gst_number',pan_number='$pan_number',open_cash_debit='$open_cash_debit',open_cash_credit='$open_cash_credit',open_pure_debit='$open_pure_debit',open_pure_credit='$open_pure_credit',email='$email',address='$address',place='$place',weight_method='$weight_method',display_subcategory='$display_subcategory',subcategories='$subcat_ids',rate_method='$rate_method',credit_note='$credit_note',debit_note='$debit_note',huid_charge='$huid_charge',credit_limit='$credit_limit',activate_stone_pieces='$activate_stone_pieces',stone_weight='$stone_weight',stone_charges='$stone_charges',shop_type='$shop_type',corporate_type='' WHERE id='$ID'";
                    $db->sql($sql);
                }
                else{
                    $sql = "UPDATE goldsmith_master SET name='$name',goldsmith_type='$goldsmith_type',mobile='$mobile',digital_signature_number='$digital_signature_number',gst_number='$gst_number',pan_number='$pan_number',open_cash_debit='$open_cash_debit',open_cash_credit='$open_cash_credit',open_pure_debit='$open_pure_debit',open_pure_credit='$open_pure_credit',email='$email',address='$address',place='$place',weight_method='$weight_method',display_subcategory='$display_subcategory',subcategories='$subcat_ids',rate_method='$rate_method',credit_note='$credit_note',debit_note='$debit_note',huid_charge='$huid_charge',credit_limit='$credit_limit',activate_stone_pieces='$activate_stone_pieces',stone_weight='$stone_weight',stone_charges='$stone_charges',shop_type='$shop_type',corporate_type='$corporate_type' WHERE id='$ID'";
                    $db->sql($sql);
                }
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

$sql_query = "SELECT * FROM goldsmith_master_variant WHERE goldsmith_master_id =" . $ID;
$db->sql($sql_query);
$resslot = $db->getResult();

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
                                                <label for="">Goldsmith Type</label> <i class="text-danger asterik">*</i> <?php echo isset($error['goldsmith_type']) ? $error['goldsmith_type'] : ''; ?><br>
                                                <select id="goldsmith_type" name="goldsmith_type" class="form-control">
                                                    <option value="Both"<?=$data['goldsmith_type'] == 'Both' ? ' selected="selected"' : '';?>>Both</option>
                                                    <option value="Seller"<?=$data['goldsmith_type'] == 'Seller' ? ' selected="selected"' : '';?> >Seller</option>
                                                    <option value="Buyer" <?=$data['goldsmith_type'] == 'Buyer' ? ' selected="selected"' : '';?>>Buyer</option>
                                                </select>
                                        </div>
                                        <div class='col-md-4'>
                                            <label for="exampleInputEmail1">Payment Mobile Number</label> <i class="text-danger asterik">*</i><?php echo isset($error['mobile']) ? $error['mobile'] : ''; ?>
                                            <input type="number" class="form-control" name="mobile" value="<?php echo $data['mobile']?>">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                         <div class='col-md-4'>
                                            <label for="exampleInputEmail1">Digital Signature Number</label> <i class="text-danger asterik">*</i><?php echo isset($error['digital_signature_number']) ? $error['digital_signature_number'] : ''; ?>
                                            <input type="number" class="form-control" name="digital_signature_number" value="<?php echo $data['digital_signature_number']?>">
                                        </div>
                                        <div class='col-md-4'>
                                            <label for="exampleInputEmail1">GST Number</label> <i class="text-danger asterik">*</i><?php echo isset($error['gst_number']) ? $error['gst_number'] : ''; ?>
                                            <input type="text" class="form-control" name="gst_number" value="<?php echo $data['gst_number']?>">
                                        </div>
                                        <div class='col-md-4'>
                                            <label for="exampleInputEmail1">PAN Number</label> <i class="text-danger asterik">*</i><?php echo isset($error['pan_number']) ? $error['pan_number'] : ''; ?>
                                            <input type="text" class="form-control" name="pan_number" value="<?php echo $data['pan_number']?>">
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
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <div class='col-md-3'>
                                            <label for="exampleInputEmail1">Open Cash Debit</label> <i class="text-danger asterik">*</i><?php echo isset($error['open_cash_debit']) ? $error['open_cash_debit'] : ''; ?>
                                            <input type="number" class="form-control" name="open_cash_debit" value="<?php echo $data['open_pure_debit']?>">
                                        </div>
                                        <div class='col-md-3'>
                                            <label for="exampleInputEmail1">Open Cash credit</label> <i class="text-danger asterik">*</i><?php echo isset($error['open_cash_credit']) ? $error['open_cash_credit'] : ''; ?>
                                            <input type="number" class="form-control" name="open_cash_credit" value="<?php echo $data['open_cash_credit']?>">
                                        </div>
                                        <div class='col-md-3'>
                                            <label for="exampleInputEmail1">Open Pure Debit</label> <i class="text-danger asterik">*</i><?php echo isset($error['open_pure_debit']) ? $error['open_pure_debit'] : ''; ?>
                                            <input type="number" class="form-control" name="open_pure_debit" value="<?php echo $data['open_pure_debit']?>">
                                        </div>
                                        <div class='col-md-3'>
                                            <label for="exampleInputEmail1">Open Pure Credit</label> <i class="text-danger asterik">*</i><?php echo isset($error['open_pure_credit']) ? $error['open_pure_credit'] : ''; ?>
                                            <input type="number" class="form-control" name="open_pure_credit" value="<?php echo $data['open_pure_credit']?>">
                                        </div>
                                    </div>    
                                </div>
                                <br>
                                <div class="row">
                                        <div class='form-group col-md-4'>
                                                <label for="">Weight Method</label> <i class="text-danger asterik">*</i> <?php echo isset($error['weight_method']) ? $error['weight_method'] : ''; ?><br>
                                                <select id="weight_method" name="weight_method" class="form-control">
                                                    <option value="Accurate Weight"<?=$data['weight_method'] == 'Accurate Weight' ? ' selected="selected"' : '';?>>Accurate Weight</option>
                                                    <option value="Approximate Weight"<?=$data['weight_method'] == 'Approximate Weight' ? ' selected="selected"' : '';?> >Approximate Weight</option>
                                                </select>
                                        </div>
                                        <div class='form-group col-md-4'>
                                                <label for="">Rate Cut Method</label> <i class="text-danger asterik">*</i> <?php echo isset($error['rate_method']) ? $error['rate_method'] : ''; ?><br>
                                                <select id="rate_method" name="rate_method" class="form-control">
                                                    <option value="TDS"<?=$data['rate_method'] == 'TDS' ? ' selected="selected"' : '';?>>TDS Rate</option>
                                                    <option value="TCS"<?=$data['rate_method'] == 'TCS' ? ' selected="selected"' : '';?> >TCS Rate</option>
                                                </select>
                                        </div>
                                        <div class='form-group col-md-4'>
                                                <label for="">Display Sub Category</label> <i class="text-danger asterik">*</i> <?php echo isset($error['display_subcategory']) ? $error['display_subcategory'] : ''; ?><br>
                                                <select id="display_subcategory" name="display_subcategory" class="form-control">
                                                    <option value="Yes"<?=$data['display_subcategory'] == 'Yes' ? ' selected="selected"' : '';?>>Yes</option>
                                                    <option value="No"<?=$data['display_subcategory'] == 'No' ? ' selected="selected"' : '';?>>No</option>
                                                </select>
                                        </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="subcat_id" class="form-group" >
                                            <label for='subcat_id'>Subcategories</label>
                                            <select name='subcat_ids[]' id='subcat_ids' class='form-control' multiple="multiple">
                                                <?php 
                                                $sql = 'select id,name from `subcategories`  order by id desc';
                                                $db->sql($sql);
                                                $result = $db->getResult();
                                                foreach ($result as $value) {
                                                    $subcategories = explode(',', $res[0]['subcategories']);
                                                    $selected = in_array($value['id'], $subcategories) ? 'selected' : '';
                                                ?>
                                                    <option value='<?= $value['id'] ?>' <?= $selected ?>><?= $value['name'] ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <div class='col-md-4'>
                                            <label for="exampleInputEmail1">Credit Note</label> <i class="text-danger asterik">*</i><?php echo isset($error['credit_note']) ? $error['credit_note'] : ''; ?>
                                            <input type="number" class="form-control" name="credit_note" value="<?php echo $data['credit_note']?>">
                                        </div>
                                        <div class='col-md-4'>
                                            <label for="exampleInputEmail1">Debit Note</label> <i class="text-danger asterik">*</i><?php echo isset($error['debit_note']) ? $error['debit_note'] : ''; ?>
                                            <input type="number" class="form-control" name="debit_note" value="<?php echo $data['debit_note']?>">
                                        </div>
                                        <div class='col-md-4'>
                                            <label for="exampleInputEmail1">HUID Charge</label> <i class="text-danger asterik">*</i><?php echo isset($error['huid_charge']) ? $error['huid_charge'] : ''; ?>
                                            <input type="number" class="form-control" name="huid_charge" value="<?php echo $data['huid_charge']?>">
                                        </div>
                                    </div>    
                                </div>
                                <br>
                                <div class="row">
                                    <div class='form-group col-md-3'>
                                            <label for="exampleInputEmail1">Credit Limit</label> <i class="text-danger asterik">*</i><?php echo isset($error['credit_limit']) ? $error['credit_limit'] : ''; ?>
                                            <input type="text" class="form-control" name="credit_limit" value="<?php echo $data['credit_limit']?>">
                                        </div>
                                        <div class='form-group col-md-3'>
                                                <label for="">Activate Stone Pieces</label> <i class="text-danger asterik">*</i> <?php echo isset($error['activate_stone_pieces']) ? $error['activate_stone_pieces'] : ''; ?><br>
                                                <select id="activate_stone_pieces" name="activate_stone_pieces" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="Yes"<?=$data['activate_stone_pieces'] == 'Yes' ? ' selected="selected"' : '';?>>Yes</option>
                                                    <option value="No"<?=$data['activate_stone_pieces'] == 'No' ? ' selected="selected"' : '';?>>No</option>
                                                </select>
                                        </div>
                                        <div class='form-group col-md-3' id="weights">
                                            <label for="exampleInputEmail1">Stone Weight/piece</label> <i class="text-danger asterik">*</i>
                                            <input type="text" class="form-control" name="stone_weight" id="stone_weight" value="<?php echo $data['stone_weight']?>">
                                        </div>
                                        <div class='form-group col-md-3' id="charges">
                                            <label for="exampleInputEmail1">Stone Charges</label> <i class="text-danger asterik">*</i>
                                            <input type="number" class="form-control" name="stone_charges" id="stone_charges" value="<?php echo $data['stone_charges']?>">
                                        </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class='form-group col-md-4'>
                                                <label for="">Shop Type</label> <i class="text-danger asterik">*</i> <?php echo isset($error['shop_type']) ? $error['shop_type'] : ''; ?><br>
                                                <select id="shop_type" name="shop_type" class="form-control" required>
                                                    <option value="Single Shop"<?=$data['shop_type'] == 'Single Shop' ? ' selected="selected"' : '';?>>Single Shop</option>
                                                    <option value="Corporate"<?=$data['shop_type'] == 'Corporate' ? ' selected="selected"' : '';?>>Corporate</option>
                                                </select>   
                                        </div>
                                        <div class='form-group col-md-4' id="old_corporate_type">
                                            <?php
                                            if($data['shop_type']=='Corporate'){
                                                ?>
                                                <label for="">Corporate Type</label> <i class="text-danger asterik">*</i>
                                                <select  name="corporate_type" class="form-control">
                                                   <option value="">select</option>
                                                    <option value="Head Office"<?=$data['corporate_type'] == 'Head Office' ? ' selected="selected"' : '';?>>Head Office</option>
                                                    <option value="Branch"<?=$data['corporate_type'] == 'Branch' ? ' selected="selected"' : '';?>>Branch</option>
                                                    <option value="Delivery"<?=$data['corporate_type'] == 'Delivery' ? ' selected="selected"' : '';?>>Delivery</option>
                                                </select>   
                                           <?php  } ?>
                                               
                                        </div>
                                        <div class='form-group col-md-4' id="corporates" style="display:none">
                                                <label for="">Corporate Type</label> <i class="text-danger asterik">*</i>
                                                <select  id="corporate_type" name="corporate_type" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="Head Office">Head Office</option>
                                                    <option value="Branch">Branch</option>
                                                    <option value="Delivery">Delivery</option>
                                                </select>   
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
       $(document).ready(function () {
        $('#subcat_ids').select2({
        width: '100%',
        placeholder: 'Type in name to search',

    });
    });
</script>
<script>
    $("#display_subcategory").change(function() {
        display_subcategory = $("#display_subcategory").val();
        if(display_subcategory == "No"){
            $("#subcat_id").show();
        }
        else{
            $("#subcat_id").hide();
            $("#subcat_ids").val("");
        }
    });
</script>
<script>
    $("#activate_stone_pieces").change(function() {
        activate_stone_pieces = $("#activate_stone_pieces").val();
        if(activate_stone_pieces == "Yes"){
            $("#weights").show();
            $("#charges").show();

        }
        if(activate_stone_pieces == "No"){
            $("#weights").hide();
            $("#charges").hide();
            $("#stone_weight").val('');
            $("#stone_charges").val('');
        }
        if(activate_stone_pieces == ""){
            $("#weights").hide();
            $("#charges").hide();
            $("#stone_weight").val('');
            $("#stone_charges").val('');
        }
    });
</script>

<!---Shop type --->
<script>
    $("#shop_type").change(function() {
        shop_type = $("#shop_type").val();
        if(shop_type == "Single Shop"){
            $("#old_corporate_type").hide();
            $("#corporate_type").val('');
        }
        if(shop_type == "Corporate"){
            $("#corporates").show();
        }
    });
</script>
<!-- <script>
    $(document).ready(function () {
        var max_fields = 7;
        var wrapper = $("#packate_div");
        var add_button = $(".add_packate_variation");

        var x = 1;
        $(add_button).click(function (e) {
            e.preventDefault();
            if (x < max_fields) {
                x++;
				$(wrapper).append('<div class="row"><div class="col-md-6"><div class="form-group"><label for="subcategory_id">Subcategory</label>' + '<select id=subcategory_id name="insert_subcategory_id[]" class="form-control" required><option value="">Select</option>'+
																'<?php
                                                                $sql = "SELECT * FROM `subcategories`";
                                                                $db->sql($sql);
                                                                $resslot = $db->getResult();
																foreach ($resslot as  $row) {
																	echo "<option value=" . $row['id'] . ">" . $row['name'] . "</option>";
																}
																?>' 
															+'</select></div></div>'+'<div class="col-md-4"><div class="form-group"><label for="touch">Touch</label>'+'<input type="text" class="form-control" name="insert_touch[]" required /></div></div>'+'<div class="col-md-1" style="display:grid;"><label>Tab</label><a class="remove text-danger" style="cursor:pointer;color:white;"><button class="btn btn-danger">Remove</button></a></div>'+'</div>');
            } else {
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
<script>
    $(document).on('click', '.remove_variation', function() {
        if ($(this).data('id') == 'data_delete') {
            if (confirm('Are you sure? Want to delete this row')) {
                var id = $(this).closest('div.row').find("input[id='goldsmith_master_variant_id']").val();
                $.ajax({
                    url: 'public/db-operation.php',
                    type: "post",
                    data: 'id=' + id + '&delete_variant=1',
                    success: function(result) {
                        if (result) {
                            location.reload();
                        } else {
                            alert("Variant not deleted!");
                        }
                    }
                });
            }
        } else {
            $(this).closest('.row').remove();
        }
    });
</script> -->