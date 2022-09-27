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
        $subcategory = $db->escapeString($fn->xss_clean($_POST['subcategory']));
        $goldsmith = $db->escapeString($fn->xss_clean($_POST['goldsmith']));
        $huid_number = $db->escapeString($fn->xss_clean($_POST['huid_number']));
        $gross_weight = $db->escapeString($fn->xss_clean($_POST['gross_weight']));
        $size = $db->escapeString($fn->xss_clean($_POST['size']));
        $stone_weight = $db->escapeString($fn->xss_clean($_POST['stone_weight']));
        $net_weight = $db->escapeString($fn->xss_clean($_POST['net_weight']));
        $wastage = $db->escapeString($fn->xss_clean($_POST['wastage']));
        $cover_weight = $db->escapeString($fn->xss_clean($_POST['cover_weight']));
        $tag_weight = $db->escapeString($fn->xss_clean($_POST['tag_weight']));
        $status = $db->escapeString($fn->xss_clean($_POST['status']));

        
              
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
            $error['sizq'] = " <span class='label label-danger'>Required!</span>";
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
        if (empty($tag_weight)) {
            $error['tag_weight'] = " <span class='label label-danger'>Required!</span>";
        }
       

        if ( !empty($subcategory) && !empty($goldsmith) && !empty($huid_number) && !empty($gross_weight)&& !empty($size) && !empty($stone_weight) && !empty($net_weight) && !empty($wastage) && !empty($cover_weight) && !empty($tag_weight))
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

            $sql = "UPDATE products SET subcategory_id='$subcategory',goldsmith_id='$goldsmith',huid_number='$huid_number',gross_weight='$gross_weight',size='$size',stone_weight='$stone_weight',net_weight='$net_weight',wastage='$wastage',cover_weight='$cover_weight',tag_weight='$tag_weight',status='$status' WHERE id=$ID";
            $db->sql($sql);
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
													<option value='<?= $value['id'] ?>' <?= $value['id']==$res[0]['subcategory_id'] ? 'selected="selected"' : '';?>><?= $value['name'] ?></option>
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
													 <option value='<?= $value['id'] ?>' <?= $value['id']==$res[0]['goldsmith_id'] ? 'selected="selected"' : '';?>><?= $value['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                </div>
                                <div class='col-md-5'>
                                    <label for="exampleInputEmail1"> HUID Number</label> <i class="text-danger asterik">*</i><?php echo isset($error['huid_number']) ? $error['huid_number'] : ''; ?>
                                    <input type="text" class="form-control" name="huid_number" value="<?php echo $res[0]['huid_number']; ?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-5">
                                    <label for="exampleInputEmail1">Gross Weight</label> <i class="text-danger asterik">*</i><?php echo isset($error['gross_weight']) ? $error['gross_weight'] : ''; ?>
                                    <input type="number" class="form-control" name="gross_weight"  value="<?php echo $res[0]['gross_weight']; ?>">
                                </div>
                                <div class='col-md-5'>
                                    <label for="exampleInputEmail1">Size</label> <i class="text-danger asterik">*</i><?php echo isset($error['size']) ? $error['size'] : ''; ?>
                                    <input type="number" class="form-control" name="size"  value="<?php echo $res[0]['size']; ?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-5">
                                    <label for="exampleInputEmail1">Stone Weight</label> <i class="text-danger asterik">*</i><?php echo isset($error['stone_weight']) ? $error['stone_weight'] : ''; ?>
                                    <input type="number" class="form-control" name="stone_weight"  value="<?php echo $res[0]['stone_weight']; ?>">
                                </div>
                                <div class='col-md-5'>
                                    <label for="exampleInputEmail1">Net Weight</label> <i class="text-danger asterik">*</i><?php echo isset($error['net_weight']) ? $error['net_weight'] : ''; ?>
                                    <input type="number" class="form-control" name="net_weight"  value="<?php echo $res[0]['net_weight']; ?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-5">
                                    <label for="exampleInputEmail1">Wastage</label> <i class="text-danger asterik">*</i><?php echo isset($error['wastage']) ? $error['wastage'] : ''; ?>
                                    <input type="number" class="form-control" name="wastage"  value="<?php echo $res[0]['wastage']; ?>">
                                </div>
                                <div class='col-md-5'>
                                    <label for="exampleInputEmail1">Cover Weight</label> <i class="text-danger asterik">*</i><?php echo isset($error['cover_weight']) ? $error['cover_weight'] : ''; ?>
                                    <input type="number" class="form-control" name="cover_weight"  value="<?php echo $res[0]['cover_weight']; ?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-5">
                                    <label for="exampleInputEmail1">Tag Weight</label> <i class="text-danger asterik">*</i><?php echo isset($error['tag_weight']) ? $error['tag_weight'] : ''; ?>
                                    <input type="text" class="form-control" name="tag_weight"  value="<?php echo $res[0]['tag_weight']; ?>">
                                </div>
                                <div class='col-md-5 form-group'>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>