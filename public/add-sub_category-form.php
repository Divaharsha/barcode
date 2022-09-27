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

if (isset($_POST['btnAdd'])) {
        $error = array();
        $category = $db->escapeString($fn->xss_clean($_POST['category']));
        $name = $db->escapeString($fn->xss_clean($_POST['name']));
       
        if (empty($category)) {
            $error['category'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($name)) {
            $error['name'] = " <span class='label label-danger'>Required!</span>";
        }

        if (!empty($category) && !empty($name))
        {
                $sql = "INSERT INTO subcategories (category_id,name) VALUES('$category','$name')";
                $db->sql($sql);
                $subcategory_result = $db->getResult();
                if (!empty($subcategory_result)) {
                    $subcategory_result = 0;
                } else {
                    $subcategory_result = 1;
                }
                if ($subcategory_result == 1) {
                    $error['add_subcategory'] = "<section class='content-header'>
                                                    <span class='label label-success'>Sub-category Added Successfully</span>
                                                    <h4><small><a  href='sub_categories.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Sub-categories</a></small></h4>
                                                     </section>";
                } else {
                    $error['add_subcategory'] = " <span class='label label-danger'>Failed</span>";
                }

            }else{
                $error['add_subcategory'] = " <span class='label label-danger'>Sub-category Already Exists</span>";

            }


        }

?>
<section class="content-header">
    <h1>Add New Sub-category</h1>
    <?php echo isset($error['add_subcategory']) ? $error['add_subcategory'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
    <div class="row">
        <div class="col-md-8">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form id='add_category_form' method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-6'>
                                    <label for="">Category</label> <i class="text-danger asterik">*</i>
                                        <select id='category' name="category" class='form-control' required>
                                            <option value="">--Select category--</option>
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
                                <div class='col-md-6'>
                                    <label for="exampleInputEmail1"> Name</label> <i class="text-danger asterik">*</i><?php echo isset($error['name']) ? $error['name'] : ''; ?>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>
                        </div>
                       

                    </div>
                    <!-- /.box-body -->
                 
                    <div class="box-footer">
                        <input type="submit" class="btn-primary btn" value="Add" name="btnAdd" />&nbsp;
                        <input type="reset" class="btn-danger btn" value="Clear" id="btnClear"/>
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
    $('#add_category_form').validate({

        ignore: [],
        debug: false,
        rules: {
            name: "required",
            category: "required",
         }
    });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });

</script>
