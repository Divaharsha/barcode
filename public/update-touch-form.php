<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

if (isset($_GET['id'])) {
    $ID = $db->escapeString($_GET['id']);
} else {
    return false;
    exit(0);
}
if (isset($_POST['btnAdd'])) {
    
        for ($i = 0; $i < count($_POST['subcategory_id']); $i++) {
            $subcategory_id = $db->escapeString(($_POST['subcategory_id'][$i]));
            $gmv_id = $db->escapeString(($_POST['gmv_id'][$i]));
            $touch = (isset($_POST['touch'][$i]) && !empty($_POST['touch'][$i])) ? $db->escapeString($fn->xss_clean($_POST['touch'][$i])) : "0";
            $sql = "SELECT id FROM goldsmith_master_variant WHERE id = '$gmv_id'";
            $db->sql($sql);
            $res = $db->getResult();
            $num = $db->numRows($res);
            if ($num >= 1) {
                $sql = "UPDATE `goldsmith_master_variant` SET `touch`='$touch' WHERE `id` = $gmv_id";
                $db->sql($sql);
                $tab_result = $db->getResult();


            }else{
                $sql = "INSERT INTO goldsmith_master_variant (goldsmith_master_id,subcategory_id,touch) VALUES('$ID','$subcategory_id','$touch')";
                $db->sql($sql);
                $tab_result = $db->getResult();


            }

        }
        $error['add_menu'] = "<section class='content-header'>
        <span class='label label-success'>Touch Updated Successfully</span>
        <h4><small><a  href='goldsmithmasters.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Goldsmith Master</a></small></h4>
        </section>";
}
$sql_query = "SELECT *,gmv.id AS id FROM `goldsmith_master_variant` gmv,`subcategories` sc WHERE gmv.subcategory_id = sc.id AND gmv.goldsmith_master_id = '$ID' ORDER BY gmv.subcategory_id ";
$db->sql($sql_query);
$res = $db->getResult();
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
                            $sql = "SELECT id,name FROM `subcategories` ORDER BY id ";
                            $db->sql($sql);
                            $result = $db->getResult();
                            for ($i = 0; $i < count($result); $i++) {
                            ?>
                            <input type="hidden" class="form-control" name="subcategory_id[]" value="<?php echo $result[$i]['id']?>" readonly>

                            <input type="hidden" class="form-control" name="gmv_id[]" value="<?php echo (isset($res[$i]['id'])) ? ($res[$i]['id']) : 0;?>">

                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-6'>
                                    <label for="exampleInputEmail1"> Subcategory</label> <i class="text-danger asterik">*</i><?php echo isset($error['name']) ? $error['name'] : ''; ?>
                                    <input type="text" class="form-control" value="<?php echo $result[$i]['name']?>" readonly>
                                    
                                </div>
                                <div class='col-md-6'>
                                    <label for="exampleInputEmail1"> Touch</label> <i class="text-danger asterik">*</i><?php echo isset($error['name']) ? $error['name'] : ''; ?>
                                    <input type="text" class="form-control" name="touch[]" value="<?php echo (isset($res[$i]['touch'])) ? ($res[$i]['touch']) : 0;?>"  required>
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