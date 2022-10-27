<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;


if (isset($_POST['btnAdd'])) {
      

        $sql = "SELECT id FROM goldsmith_master ORDER BY id DESC LIMIT 1";
        $db->sql($sql);
        $res = $db->getResult();
        $goldsmith_master_id = $res[0]['id'];
        for ($i = 0; $i < count($_POST['subcategory_id']); $i++) {
            $subcategory_id = $db->escapeString(($_POST['subcategory_id'][$i]));
            $touch = (isset($_POST['touch'][$i]) && !empty($_POST['touch'][$i])) ? $db->escapeString($fn->xss_clean($_POST['touch'][$i])) : "0";
            $sql = "INSERT INTO goldsmith_master_variant (goldsmith_master_id,subcategory_id,touch) VALUES('$goldsmith_master_id','" . $subcategory_id . "','$touch')";
            $db->sql($sql);
            $tab_result = $db->getResult();
        }
        if (!empty($tab_result)) {
            $tab_result = 0;
        } else {
            $tab_result = 1;
        }
        if($tab_result==1){
            $error['add_menu'] = "<section class='content-header'>
            <span class='label label-success'>Dealer Goldsmith Master Added Successfully</span>
            <h4><small><a  href='goldsmithmasters.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Goldsmith Master</a></small></h4>
            </section>";

        }else {
        $error['add_menu'] = " <span class='label label-danger'>Failed</span>";

    }
}

?>
<section class="content-header">
    <h1>Update Touch</h1>
    <?php echo isset($error['add_menu']) ? $error['add_menu'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                </div>
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form id='edit_category_form' method="post" enctype="multipart/form-data">
                    <div class="box-body">
                    <?php
                            $sql = "SELECT id,name FROM `subcategories`";
                            $db->sql($sql);
                            $result = $db->getResult();
                            foreach ($result as $value) {
                            ?>
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-6'>
                                    <label for="exampleInputEmail1"> Subcategory</label> <i class="text-danger asterik">*</i><?php echo isset($error['name']) ? $error['name'] : ''; ?>
                                    <input type="text" class="form-control" value="<?php echo $value['name']?>" readonly>
                                    <input type="hidden" class="form-control" name="subcategory_id[]" value="<?php echo $value['id']?>" readonly>

                                </div>
                                <div class='col-md-6'>
                                    <label for="exampleInputEmail1"> Touch</label> <i class="text-danger asterik">*</i><?php echo isset($error['name']) ? $error['name'] : ''; ?>
                                    <input type="text" class="form-control" name="touch[]"  required>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        
                     </div><!-- /.box-body -->
                    
                     <div class="box-footer">
                        <input type="submit" class="btn-primary btn" value="Update Touch" name="btnAdd" />&nbsp;
                        <input type="reset" class="btn-danger btn" value="Clear" id="btnClear" />
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<div class="separator"> </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>