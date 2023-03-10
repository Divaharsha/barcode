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
        $error = array();
        $date=date('Y-m-d H:i:s');
        $subcategory = $db->escapeString($fn->xss_clean($_POST['subcategory']));
        $goldsmith = $db->escapeString($fn->xss_clean($_POST['goldsmith']));
        $huid_number = $db->escapeString($fn->xss_clean($_POST['huid_number']));
        $entry_type = $db->escapeString($fn->xss_clean($_POST['entry_type']));

        $gross_weight = (isset($_POST['gross_weight']) && !empty($_POST['gross_weight'])) ? $db->escapeString($fn->xss_clean($_POST['gross_weight'])) : "0";  
        $size = (isset($_POST['size']) && !empty($_POST['size'])) ? $db->escapeString($fn->xss_clean($_POST['size'])) : "0";
        $stone_weight = (isset($_POST['stone_weight']) && !empty($_POST['stone_weight'])) ? $db->escapeString($fn->xss_clean($_POST['stone_weight'])) : "0";
        $net_weight = (isset($_POST['net_weight']) && !empty($_POST['net_weight'])) ? $db->escapeString($fn->xss_clean($_POST['net_weight'])) : "0";
        $wastage = (isset($_POST['wastage']) && !empty($_POST['wastage'])) ? $db->escapeString($fn->xss_clean($_POST['wastage'])) : "0";
        $cover_weight = (isset($_POST['cover_weight']) && !empty($_POST['cover_weight'])) ? $db->escapeString($fn->xss_clean($_POST['cover_weight'])) : "0";
        $tag_weight = (isset($_POST['tag_weight']) && !empty($_POST['tag_weight'])) ? $db->escapeString($fn->xss_clean($_POST['tag_weight'])) : "0";    
        $stone_pieces = (isset($_POST['stone_pieces']) && !empty($_POST['stone_pieces'])) ? $db->escapeString($fn->xss_clean($_POST['stone_pieces'])) : "0";
        $stone_charges = (isset($_POST['stone_charges']) && !empty($_POST['stone_charges'])) ? $db->escapeString($fn->xss_clean($_POST['stone_charges'])) : "0";
        $status = $db->escapeString($fn->xss_clean($_POST['status']));
        $pair = $db->escapeString($fn->xss_clean($_POST['pair']));
        $new_pair_size = $db->escapeString($fn->xss_clean($_POST['new_pair_size']));
        $pair_size = (isset($_POST['pair_size']) && !empty($_POST['pair_size'])) ? $db->escapeString($fn->xss_clean($_POST['pair_size'])) : "0";    
        $seller_id = (isset($_POST['seller_ids'])) ? $fn->xss_clean_array($_POST['seller_ids']) : "";
        $seller_ids = "";
        if (!empty($seller_id)) {
            $seller_ids = implode(",", $seller_id);
            $seller_ids = $db->escapeString($seller_ids);
        }
 

              
        if (empty($subcategory)) {
            $error['subcategory'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($goldsmith)) {
            $error['goldsmith'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($huid_number)) {
            $error['huid_number'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($tag_weight)) {
            $error['tag_weight'] = " <span class='label label-danger'>Required!</span>";
        }
       

        if ( !empty($subcategory) && !empty($goldsmith) && !empty($huid_number)  && !empty($tag_weight))
        {

            if ($_FILES['image']['size'] != 0 && $_FILES['image']['error'] == 0 && !empty($_FILES['image'])) {
				//image isn't empty and update the image
				$old_image = $db->escapeString($_POST['old_image']);
				$extension = pathinfo($_FILES["image"]["name"])['extension'];
		
				$result = $fn->validate_image($_FILES["image"]);
				$target_path = 'upload/products/';
				
				$filename = microtime(true) . '.' . strtolower($extension);
				$full_path = $target_path . "" . $filename;
				if (!move_uploaded_file($_FILES["image"]["tmp_name"], $full_path)) {
					echo '<p class="alert alert-danger">Can not upload image.</p>';
					return false;
					exit();
				}
				if (!empty($old_image)) {
					unlink($old_image);
				}
				$upload_image = 'upload/products/' . $filename;
				$sql = "UPDATE products SET `image`='" . $upload_image . "' WHERE `id`=" . $ID;
				$db->sql($sql);
			}
            $sql = "SELECT category_id FROM subcategories WHERE category_id='$subcategory'";
            $db->sql($sql);
            $res = $db->getResult();
            $category_id = $res[0]['category_id'];

            if($entry_type=='Order Entry'){
                        $sql = "UPDATE products SET category_id='$category_id',subcategory_id='$subcategory',goldsmith_id='$goldsmith',huid_number='$huid_number',entry_type='$entry_type',sellers='$seller_ids',gross_weight='$gross_weight',size='$size',stone_weight='$stone_weight',net_weight='$net_weight',wastage='$wastage',cover_weight='$cover_weight',tag_weight='$tag_weight',stone_pieces='$stone_pieces',stone_charges='$stone_charges',date=NULL,pair='$pair',pair_size='$pair_size',status='$status' WHERE id=$ID";
                        $db->sql($sql);
            }
            else{
                $sql = "UPDATE products SET category_id='$category_id',subcategory_id='$subcategory',goldsmith_id='$goldsmith',huid_number='$huid_number',entry_type='$entry_type',sellers='$seller_ids',gross_weight='$gross_weight',size='$size',stone_weight='$stone_weight',net_weight='$net_weight',wastage='$wastage',cover_weight='$cover_weight',tag_weight='$tag_weight',stone_pieces='$stone_pieces',stone_charges='$stone_charges',date='$date',pair='$pair',pair_size='$pair_size',status='$status' WHERE id=$ID";
                $db->sql($sql);
            }
            if(!empty($new_pair_size)){
                $sql = "UPDATE products SET pair_size='$new_pair_size' WHERE id=$ID";
                $db->sql($sql);
            }

            $product_result = $db->getResult();
            if (!empty($product_result)) {
                $product_result = 0;
            } else {
                $product_result = 1;
            }
            if ($product_result == 1) {
                $error['update_product'] = "<section class='content-header'>
                                                <span class='label label-success'>Product Updated Successfully</span>
                                                <h4><small><a  href='products.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Products</a></small></h4>
                                                    </section>";
            } else {
                $error['update_product'] = " <span class='label label-danger'>Failed</span>";
            }

        }
    }

$data = array();

$sql_query = "SELECT * FROM `products` WHERE id = '$ID'";
$db->sql($sql_query);
$res = $db->getResult();

?>
<section class="content-header">
    <h1>Edit Product</h1>
    <?php echo isset($error['update_product']) ? $error['update_product'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                </div>
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form id='edit_product_form' method="post" enctype="multipart/form-data">
                    <div class="box-body">
                    <input type="hidden" id="old_image" name="old_image"  value="<?= $res[0]['image']; ?>">
                        <div class="row">
                            <div class="form-group">
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
													<option value='<?= $value['id'] ?>' <?= $value['id']==$res[0]['subcategory_id'] ? 'selected="selected"' : '';?>><?= $value['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                </div>
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
													 <option value='<?= $value['id'] ?>' <?= $value['id']==$res[0]['goldsmith_id'] ? 'selected="selected"' : '';?>><?= $value['name'] ?></option>
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
                                    <input type="text" class="form-control" name="huid_number" value="<?php echo $res[0]['huid_number']; ?>">
                                </div>
                                <div class='col-md-5'>
                                    <label for="exampleInputEmail1">Entry Type</label> <i class="text-danger asterik">*</i><?php echo isset($error['entry_type']) ? $error['entry_type'] : ''; ?>
                                    <select id="entry_type" name="entry_type" class="form-control">
                                        <option value="Lot Entry"<?=$res[0]['entry_type'] == 'Lot Entry' ? ' selected="selected"' : '';?>>Lot Entry</option>
                                        <option value="Order Entry"<?=$res[0]['entry_type'] == 'Order Entry' ? ' selected="selected"' : '';?>>Order Entry</option>
                                    </select>   
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="seller_id" class="form-group" style="display:none">
                                    <label for='seller_id'>Select Seller/Buyer</label>
                                    <select name='seller_ids[]' id='seller_ids' class='form-control' multiple="multiple">
                                        <?php 
                                        $sql = 'select id,name from `goldsmith_master` ';
                                        $db->sql($sql);
                                        $result = $db->getResult();
                                        foreach ($result as $value) {
                                            $sellers = explode(',', $res[0]['sellers']);
                                            $selected = in_array($value['id'], $sellers) ? 'selected' : '';
                                        ?>
                                            <option value='<?= $value['id'] ?>' <?= $selected ?>><?= $value['name'] ?></option>
                                        <?php } ?>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">Gross Weight</label> <i class="text-danger asterik">*</i><?php echo isset($error['gross_weight']) ? $error['gross_weight'] : ''; ?>
                                    <input type="number" class="form-control" name="gross_weight" id="gross_weight"  value="<?php echo $res[0]['gross_weight']; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">Stone Weight</label> <i class="text-danger asterik">*</i><?php echo isset($error['stone_weight']) ? $error['stone_weight'] : ''; ?>
                                    <input type="number" class="form-control" name="stone_weight" id="stone_weight" value="<?php echo $res[0]['stone_weight']; ?>">
                                </div>
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Net Weight</label> <i class="text-danger asterik">*</i><?php echo isset($error['net_weight']) ? $error['net_weight'] : ''; ?>
                                    <input type="number" class="form-control" name="net_weight" id="net_weight"  value="<?php echo $res[0]['net_weight']; ?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Size</label> <i class="text-danger asterik">*</i><?php echo isset($error['size']) ? $error['size'] : ''; ?>
                                    <input type="number" class="form-control" name="size"  value="<?php echo $res[0]['size']; ?>">
                                </div>
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Stone Pieces</label> <i class="text-danger asterik">*</i><?php echo isset($error['stone_pieces']) ? $error['stone_pieces'] : ''; ?>
                                    <input type="number" class="form-control" name="stone_pieces"  value="<?php echo $res[0]['stone_pieces']; ?>">
                                </div>
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Stone Charges</label> <i class="text-danger asterik">*</i><?php echo isset($error['stone_charges']) ? $error['stone_charges'] : ''; ?>
                                    <input type="number" class="form-control" name="stone_charges"  value="<?php echo $res[0]['stone_charges']; ?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-3">
                                    <label for="exampleInputEmail1">Wastage</label> <i class="text-danger asterik">*</i><?php echo isset($error['wastage']) ? $error['wastage'] : ''; ?>
                                    <input type="number" class="form-control" name="wastage"  value="<?php echo $res[0]['wastage']; ?>">
                                </div>
                                <div class='col-md-3'>
                                    <label for="exampleInputEmail1">Cover Weight</label> <i class="text-danger asterik">*</i><?php echo isset($error['cover_weight']) ? $error['cover_weight'] : ''; ?>
                                    <input type="number" class="form-control" name="cover_weight"  value="<?php echo $res[0]['cover_weight']; ?>">
                                </div>
                                <div class='col-md-3'>
                                    <label for="">Pair</label> <i class="text-danger asterik">*</i> <?php echo isset($error['pair']) ? $error['pair'] : ''; ?><br>
                                    <select id="pair" name="pair" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Yes"<?=$res[0]['pair'] == 'Yes' ? ' selected="selected"' : '';?>>Yes</option>
                                        <option value="No"<?=$res[0]['pair'] == 'No' ? ' selected="selected"' : '';?>>No</option>
                                    </select>
                                </div>
                                <?php 
                                if($res[0]['pair']=='Yes'){?>
                                <div class='col-md-3' id="old_size">
                                    <label for="exampleInputEmail1">Pair Size</label> <i class="text-danger asterik">*</i><?php echo isset($error['pair_size']) ? $error['pair_size'] : ''; ?>
                                    <input type="number" class="form-control" name="pair_size" id="pair_size" value="<?php echo $res[0]['pair_size']; ?>">
                                </div>
                                <?php }?>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                               <div class='col-md-4' id="new_size" style="display:none;">
                                    <label for="exampleInputEmail1">Pair Size</label> <i class="text-danger asterik">*</i><?php echo isset($error['new_pair_size']) ? $error['new_pair_size'] : ''; ?>
                                    <input type="number" class="form-control" name="new_pair_size" id="new_pair_size">
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">Tag Weight</label> <i class="text-danger asterik">*</i><?php echo isset($error['tag_weight']) ? $error['tag_weight'] : ''; ?>
                                    <input type="text" class="form-control" name="tag_weight"  value="<?php echo $res[0]['tag_weight']; ?>">
                                </div>
                                <div class='col-md-54form-group'>
                                       <label >Status</label><i class="text-danger asterik">*</i><br>
                                        <div id="status" class="btn-group">
                                            <label class="btn btn-success" data-toggle-class="btn-default" data-toggle-passive-class="btn-default">
                                                <input type="radio" name="status" value="1" <?= ($res[0]['status'] == 1) ? 'checked' : ''; ?>>Approved
                                            </label>
                                            <label class="btn btn-danger" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                                <input type="radio" name="status" value="0" <?= ($res[0]['status'] == 0) ? 'checked' : ''; ?>> Not-Approved
                                            </label>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="fom-group">
                                <div class="col-md-6">
                                <label for="exampleInputFile">Image</label><i class="text-danger asterik">*</i>
                                        
                                        <input type="file" accept="image/png,  image/jpeg" onchange="readURL(this);"  name="image" id="image">
                                        <p class="help-block"><img id="blah" src="<?php echo $res[0]['image']; ?>" style="height:100px;max-width:100%" /></p>
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
<script>
    $(document).ready(function () {
        $('#goldsmith').select2({
        width: 'element',
        placeholder: 'Type in name to search',

    });
    });

</script>
<script>
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
            $("#seller_ids").val('');
        }
    });
</script>
<script>
    $("#pair").change(function() {
        pair = $("#pair").val();
        if(pair == "Yes"){
            $("#new_size").show();

        }
        else{
            $("#new_size").hide();
            $("#old_size").hide();
            $("#pair_size").val('');
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>