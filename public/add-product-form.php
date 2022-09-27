<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
?>
<?php

if (isset($_POST['btnAdd'])) {

        $subcategory = $db->escapeString($fn->xss_clean($_POST['subcategory']));
        $goldsmith = $db->escapeString($fn->xss_clean($_POST['goldsmith']));
        $huid_number = $db->escapeString($fn->xss_clean($_POST['huid_number']));
        $gross_weight = $db->escapeString($fn->xss_clean($_POST['gross_weight']));
        $size = $db->escapeString($fn->xss_clean($_POST['size']));
        $stone_weight = $db->escapeString($fn->xss_clean($_POST['stone_weight']));
        $net_weight = $db->escapeString($fn->xss_clean($_POST['net_weight']));
        $wastage = $db->escapeString($fn->xss_clean($_POST['wastage']));
        $cover_weight = $db->escapeString($fn->xss_clean($_POST['cover_weight']));

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
        if (empty($gross_weight)) {
            $error['gross_weight'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($size)) {
            $error['size'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($stone_weight)) {
            $error['stone_weight'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($net_weight)) {
            $error['net_weight'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($wastage)) {
            $error['wastage'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($cover_weight)) {
            $error['cover_weight'] = " <span class='label label-danger'>Required!</span>";
        }
       

        if (!empty($subcategory) && !empty($goldsmith) && !empty($huid_number) && !empty($gross_weight) && !empty($size) && !empty($stone_weight) && !empty($net_weight) && !empty($wastage) && !empty($cover_weight))
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


                $sql = "INSERT INTO products (subcategory_id,goldsmith_id,huid_number,gross_weight,size,stone_weight,net_weight,wastage,cover_weight,tag_weight,image,status) VALUES('$subcategory','$goldsmith','$huid_number','$gross_weight','$size','$stone_weight','$net_weight','$wastage','$cover_weight',NULL,'$upload_image',0)";
                $db->sql($sql);
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
                                <div class="col-md-5">
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
                                <div class="col-md-5">
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
                                <div class='col-md-5'>
                                    <label for="exampleInputEmail1"> HUID Number</label> <i class="text-danger asterik">*</i><?php echo isset($error['huid_number']) ? $error['huid_number'] : ''; ?>
                                    <input type="text" class="form-control" name="huid_number" required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-5">
                                    <label for="exampleInputEmail1">Gross Weight</label> <i class="text-danger asterik">*</i><?php echo isset($error['gross_weight']) ? $error['gross_weight'] : ''; ?>
                                    <input type="number" class="form-control" name="gross_weight" required>
                                </div>
                                <div class='col-md-5'>
                                    <label for="exampleInputEmail1">Size</label> <i class="text-danger asterik">*</i><?php echo isset($error['size']) ? $error['size'] : ''; ?>
                                    <input type="number" class="form-control" name="size" required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-5">
                                    <label for="exampleInputEmail1">Stone Weight</label> <i class="text-danger asterik">*</i><?php echo isset($error['stone_weight']) ? $error['stone_weight'] : ''; ?>
                                    <input type="number" class="form-control" name="stone_weight" required>
                                </div>
                                <div class='col-md-5'>
                                    <label for="exampleInputEmail1">Net Weight</label> <i class="text-danger asterik">*</i><?php echo isset($error['net_weight']) ? $error['net_weight'] : ''; ?>
                                    <input type="number" class="form-control" name="net_weight" required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-5">
                                    <label for="exampleInputEmail1">Wastage</label> <i class="text-danger asterik">*</i><?php echo isset($error['wastage']) ? $error['wastage'] : ''; ?>
                                    <input type="number" class="form-control" name="wastage" required>
                                </div>
                                <div class='col-md-5'>
                                    <label for="exampleInputEmail1">Cover Weight</label> <i class="text-danger asterik">*</i><?php echo isset($error['cover_weight']) ? $error['cover_weight'] : ''; ?>
                                    <input type="number" class="form-control" name="cover_weight" required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="fom-group">
                                <div class="col-md-6">
                                         <label for="exampleInputFile">Image</label> <i class="text-danger asterik">*</i><?php echo isset($error['product_image']) ? $error['product_image'] : ''; ?>
                                        <input type="file" name="product_image" onchange="readURL(this);" accept="image/png,  image/jpeg" id="product_image" required/><br>
                                        <img id="blah" src="#" alt="" />
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
    $('#add_product_form').validate({

        ignore: [],
        debug: false,
        rules: {
            subcategory: "required",
            goldsmith: "required",
            size: "required",
            stone_weight: "required",
            net_weight: "required",
            wastage: "required",
            gross_weight: "required",
         }
    });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });
</script>
<script>
    function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(400)
                        .height(250);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
</script>

<!--code for page clear-->
<script>
    function refreshPage(){
    window.location.reload();
} 
</script>

<?php $db->disconnect(); ?>
