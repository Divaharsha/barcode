<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
?>
<?php

if (isset($_POST['btnAdd'])) {

        $date=date('Y-m-d H:i:s');
        $subcategory = $db->escapeString($fn->xss_clean($_POST['subcategory']));
        $goldsmith = $db->escapeString($fn->xss_clean($_POST['goldsmith']));
        $huid_number = $db->escapeString($fn->xss_clean($_POST['huid_number']));
        $entry_type = $db->escapeString($fn->xss_clean($_POST['entry_type']));
        $size = (isset($_POST['size']) && !empty($_POST['size'])) ? $db->escapeString($fn->xss_clean($_POST['size'])) : "0";
        $gross_weight = (isset($_POST['gross_weight']) && !empty($_POST['gross_weight'])) ? $db->escapeString($fn->xss_clean($_POST['gross_weight'])) : "0";
        $stone_weight = (isset($_POST['stone_weight']) && !empty($_POST['stone_weight'])) ? $db->escapeString($fn->xss_clean($_POST['stone_weight'])) : "0";       
        $net_weight = (isset($_POST['net_weight']) && !empty($_POST['net_weight'])) ? $db->escapeString($fn->xss_clean($_POST['net_weight'])) : "0";
        $wastage = (isset($_POST['wastage']) && !empty($_POST['wastage'])) ? $db->escapeString($fn->xss_clean($_POST['wastage'])) : "0";
        $cover_weight = (isset($_POST['cover_weight']) && !empty($_POST['cover_weight'])) ? $db->escapeString($fn->xss_clean($_POST['cover_weight'])) : "0";
        $stone_pieces = (isset($_POST['stone_pieces']) && !empty($_POST['stone_pieces'])) ? $db->escapeString($fn->xss_clean($_POST['stone_pieces'])) : "0";
        $stone_charges = (isset($_POST['stone_charges']) && !empty($_POST['stone_charges'])) ? $db->escapeString($fn->xss_clean($_POST['stone_charges'])) : "0";
        $pair = $db->escapeString($fn->xss_clean($_POST['pair']));
        $pair_size = (isset($_POST['pair_size']) && !empty($_POST['pair_size'])) ? $db->escapeString($fn->xss_clean($_POST['pair_size'])) : "0";

        $seller_id = $fn->xss_clean_array($_POST['seller_ids']);
        $seller_ids = implode(",", $seller_id);

        // get image info
        $menu_image = $db->escapeString($_FILES['product_image']['name']);
        $image_error = $db->escapeString($_FILES['product_image']['error']);
        $image_type = $db->escapeString($_FILES['product_image']['type']);

        // create array variable to handle error
        $error = array();
            // common image file extensions
        $allowedExts = array("gif", "jpeg", "jpg", "png");

        // get image file extension
        error_reporting(E_ERROR | E_PARSE);
        $extension = end(explode(".", $_FILES["product_image"]["name"]));
          

        
        if (empty($subcategory)) {
            $error['subcategory'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($goldsmith)) {
            $error['goldsmith'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($huid_number)) {
            $error['huid_number'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($entry_type)) {
            $error['entry_type'] = " <span class='label label-danger'>Required!</span>";
        }

        if (!empty($subcategory) && !empty($goldsmith) && !empty($huid_number))
        {
                        $result = $fn->validate_image($_FILES["product_image"]);
                        // create random image file name
                        $string = '0123456789';
                        $file = preg_replace("/\s+/", "_", $_FILES['product_image']['name']);
                        $menu_image = $function->get_random_string($string, 4) . "-" . date("Y-m-d") . "." . $extension;
                
                        // upload new image
                        $upload = move_uploaded_file($_FILES['product_image']['tmp_name'], 'upload/products/' . $menu_image);
                
                        // insert new data to menu table
                        $upload_image = 'upload/products/' . $menu_image;


                $sql = "SELECT category_id FROM subcategories WHERE category_id='$subcategory'";
                $db->sql($sql);
                $res = $db->getResult();
                $category_id = $res[0]['category_id'];

                if($entry_type=='Order Entry'){
                        $sql = "INSERT INTO products (category_id,subcategory_id,goldsmith_id,huid_number,entry_type,gross_weight,size,stone_weight,net_weight,wastage,cover_weight,tag_weight,stone_pieces,stone_charges,sellers,pair,pair_size,date,image,status) VALUES('$category_id','$subcategory','$goldsmith','$huid_number','$entry_type','$gross_weight','$size','$stone_weight','$net_weight','$wastage','$cover_weight',NULL,'$stone_pieces','$stone_charges','$seller_ids','$pair','$pair_size',NULL,'$upload_image',0)";
                        $db->sql($sql);
                }
                else{
                    $sql = "INSERT INTO products (category_id,subcategory_id,goldsmith_id,huid_number,entry_type,gross_weight,size,stone_weight,net_weight,wastage,cover_weight,tag_weight,stone_pieces,stone_charges,sellers,pair,pair_size,date,image,status) VALUES('$category_id','$subcategory','$goldsmith','$huid_number','$entry_type','$gross_weight','$size','$stone_weight','$net_weight','$wastage','$cover_weight',NULL,'$stone_pieces','$stone_charges',NULL,'$pair','$pair_size','$date','$upload_image',0)";
                    $db->sql($sql);
                }
                $product_result = $db->getResult();
                if (!empty($product_result)) {
                    $product_result = 0;
                } else {
                    $product_result = 1;
                }
                if ($product_result == 1) {
                    $error['add_product'] = "<section class='content-header'>
                                                    <span class='label label-success'>Product Added Successfully</span>
                                                    <h4><small><a  href='products.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Products</a></small></h4>
                                                     </section>";
                } else {
                    $error['add_product'] = " <span class='label label-danger'>Failed</span>";
                }

            }else{
                $error['add_product'] = " <span class='label label-danger'>Product Already Exists</span>";

            }


}

?>
<section class="content-header">
    <h1>Add Product</h1>
    <?php echo isset($error['add_product']) ? $error['add_product'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form id='add_product_form' method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4">
                                   <label for="">Select Dealer Goldsmith</label> <i class="text-danger asterik">*</i>
                                        <select id='goldsmith' name="goldsmith" class='form-control' required>
                                            <option value="">Select</option>
                                                <?php
                                                $sql = "SELECT id,name FROM `goldsmith_master`";
                                                $db->sql($sql);
                                                $result = $db->getResult();
                                                foreach ($result as $value) {
                                                ?>
                                                    <option value='<?= $value['id'] ?>'><?= $value['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Select Subcategory</label> <i class="text-danger asterik">*</i>
                                        <select id='subcategory' name="subcategory" class='form-control' required>
                                            <option value="">--Select sub-category--</option>
                                                <?php
                                                $sql = "SELECT * FROM `subcategories`";
                                                $db->sql($sql);
                                                $result = $db->getResult();
                                                foreach ($result as $value) {
                                                ?>
                                                    <option value='<?= $value['id'] ?>'><?= $value['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-5'>
                                    <label for="exampleInputEmail1"> HUID Number</label> <i class="text-danger asterik">*</i><?php echo isset($error['huid_number']) ? $error['huid_number'] : ''; ?>
                                    <input type="text" class="form-control" name="huid_number" required>
                                </div>
                                <div class='col-md-5'>
                                    <label for="exampleInputEmail1">Entry Type</label> <i class="text-danger asterik">*</i><?php echo isset($error['entry_type']) ? $error['entry_type'] : ''; ?>
                                    <select id="entry_type" name="entry_type" class="form-control">
                                            <option value="Lot Entry">Lot Entry</option>
                                            <option value="Order Entry">Order Entry</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                               <div class="col-md-12">
                                    <div id="seller_id" class="form-group" style="display:none;">
                                        <label for="exampleInputEmail1">Select Buyer/Seller</label> <i class="text-danger asterik">*</i><br>
                                        <select id='seller_ids' name="seller_ids[]" multiple>
                                        <option value=''>Select</option>
                                                    <?php
                                                    $sql = "SELECT id,name FROM `goldsmith_master`";
                                                    $db->sql($sql);

                                                    $result = $db->getResult();
                                                    foreach ($result as $value) {
                                                    ?>
                                                        <option value='<?= $value['id'] ?>'><?= $value['name'] ?></option>
                                                    <?php } ?>
                                        </select>
                                    </div>
                                </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">Gross Weight</label> <i class="text-danger asterik">*</i><?php echo isset($error['gross_weight']) ? $error['gross_weight'] : ''; ?>
                                    <input type="number" class="form-control" name="gross_weight" id="gross_weight">
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">Stone Weight</label> <i class="text-danger asterik">*</i><?php echo isset($error['stone_weight']) ? $error['stone_weight'] : ''; ?>
                                    <input type="number" class="form-control" name="stone_weight" id="stone_weight">
                                </div>
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Net Weight</label> <i class="text-danger asterik">*</i><?php echo isset($error['net_weight']) ? $error['net_weight'] : ''; ?>
                                    <input type="number" class="form-control" name="net_weight" id="net_weight">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Size</label> <i class="text-danger asterik">*</i><?php echo isset($error['size']) ? $error['size'] : ''; ?>
                                    <input type="number" class="form-control" name="size">
                                </div>
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Stone Pieces</label> <i class="text-danger asterik">*</i><?php echo isset($error['stone_pieces']) ? $error['stone_pieces'] : ''; ?>
                                    <input type="number" class="form-control" name="stone_pieces">
                                </div>
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Stone Charges</label> <i class="text-danger asterik">*</i><?php echo isset($error['stone_charges']) ? $error['stone_charges'] : ''; ?>
                                    <input type="number" class="form-control" name="stone_charges">
                                </div>
                               
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-3">
                                    <label for="exampleInputEmail1">Wastage</label> <i class="text-danger asterik">*</i><?php echo isset($error['wastage']) ? $error['wastage'] : ''; ?>
                                    <input type="number" class="form-control" name="wastage">
                                </div>
                                <div class='col-md-3'>
                                    <label for="exampleInputEmail1">Cover Weight</label> <i class="text-danger asterik">*</i><?php echo isset($error['cover_weight']) ? $error['cover_weight'] : ''; ?>
                                    <input type="number" class="form-control" name="cover_weight">
                                </div>
                                <div class="col-md-3">
                                    <label for="exampleInputEmail1">Pair</label> <i class="text-danger asterik">*</i><?php echo isset($error['pair']) ? $error['pair'] : ''; ?>
                                    <select id="pair" name="pair" class="form-control">
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                    </select>
                                </div>
                                <div class='col-md-3' style="display:none;" id="pairs">
                                    <label for="exampleInputEmail1">Pair Size</label> <i class="text-danger asterik">*</i><?php echo isset($error['cover_weight']) ? $error['cover_weight'] : ''; ?>
                                    <input type="number" class="form-control" name="pair_size" id="pair_size">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="fom-group">
                                <div class="col-md-4">
                                    <label for="">Image</label><i class="text-danger asterik">*</i><?php echo isset($error['product_image']) ? $error['product_image'] : ''; ?>
                                         <label for="cropzee-input" class="image-previewer" data-cropzee="cropzee-input"></label>
                                        <input type="file" name="product_image" id="cropzee-input" accept="image/png,  image/jpeg" id="product_image" required/><br>
                                </div>
                            </div>
                        </div>


                    </div>
                    <!-- /.box-body -->
                 
                    <div class="box-footer">
                        <input type="submit" class="btn-primary btn" value="Add" name="btnAdd" />&nbsp;
                        <input type="reset" onClick="refreshPage()" class="btn-warning btn" value="Clear" />
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<div class="separator"> </div>
<script defer src="https://cdn.crop.guide/loader/l.js?c=123ABC"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
    $('#add_product_form').validate({

        ignore: [],
        debug: false,
        rules: {
            subcategory: "required",
            goldsmith: "required",
         }
    });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });
    $(document).ready(function () {
        $('#seller_ids').select2({
        width: '100%',
        placeholder: 'Type in name to search',

    });
    });
</script>
<script>
    $("#entry_type").change(function() {
        entry_type = $("#entry_type").val();
        if(entry_type == "Order Entry"){
            $("#seller_id").show();

        }
        else{
            $("#seller_id").hide();
        }
    });
</script>
<script>
    $("#pair").change(function() {
        pair = $("#pair").val();
        if(pair == "Yes"){
            $("#pairs").show();
        }
        else{
            $("#pairs").hide();
        }
    });
</script>
<script>
    $(document).ready(function (){
            $("#gross_weight, #stone_weight").change(function () {
            $("#net_weight").val($("#gross_weight").val()-$("#stone_weight").val());
            });
        });
 </script>
<script>
		$(document).ready(function(){
			$("#cropzee-input").cropzee({startSize: [85, 85, '%'],});
		});
	</script>

<!--code for page clear-->
<script>
    function refreshPage(){
    window.location.reload();
} 
</script>

<?php $db->disconnect(); ?>
