<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

$res = $db->getResult();
$id = $_SESSION['id'];


if (isset($_POST['btnAdd'])) {
    if ($permissions['openmaster']['create'] == 1) {
            $error = array();
            $ornament_stock = $db->escapeString($fn->xss_clean($_POST['ornament_stock']));
            $pure = $db->escapeString($fn->xss_clean($_POST['pure']));
            $digital_closing_stock = $db->escapeString($fn->xss_clean($_POST['digital_closing_stock']));
            $cash_hand = $db->escapeString($fn->xss_clean($_POST['cash_hand']));
            
            if (empty($ornament_stock)) {
                $error['ornament_stock'] = " <span class='label label-danger'>Required!</span>";
            }
            if (empty($pure)) {
                $error['pure'] = " <span class='label label-danger'>Required!</span>";
            }
            if (empty($digital_closing_stock)) {
                $error['digital_closing_stock'] = " <span class='label label-danger'>Required!</span>";
            }
            if (empty($cash_hand)) {
                $error['cash_hand'] = " <span class='label label-danger'>Required!</span>";
            }
        

            if ( !empty($ornament_stock) && !empty($pure) && !empty($digital_closing_stock) && !empty($cash_hand))
            {
                $sql = "UPDATE openingmaster SET admin_id='$id',ornament_stock='$ornament_stock',pure='$pure',digital_closing_stock='$digital_closing_stock',cash_hand='$cash_hand' WHERE admin_id=1";
                    $db->sql($sql);
                    $openingmaster_result = $db->getResult();
                    if (!empty($openingmaster_result)) {
                        $openingmaster_result = 0;
                    } else {
                        $openingmaster_result = 1;
                    }
                    if ($openingmaster_result == 1) {
                        $error['add_menu'] = "<section class='content-header'>
                                                        <span class='label label-success'>Opening Master Updated Successfully</span>
                                                        
                                                        </section>";
                    } else {
                        $error['add_menu'] = " <span class='label label-danger'>Failed</span>";
                    }
            }
        }
}
    $sql_query = "SELECT * FROM openingmaster WHERE admin_id = $id";
    $db->sql($sql_query);
    $res= $db->getResult();
    $num = $db->numRows($res);
?>
<section class="content-header">
    <h1>Opening Master</h1>
    <?php echo isset($error['add_menu']) ? $error['add_menu'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
        <?php if ($permissions['openmaster']['create'] == 0) { ?>
                <div class="alert alert-danger">You have no permission to create opening master.</div>
            <?php } ?>
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form id='add_opening_master_form'  method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Ornament stock</label> <i class="text-danger asterik">*</i><?php echo isset($error['ornament_stock']) ? $error['ornament_stock'] : ''; ?>
                                    <input type="number" class="form-control" name="ornament_stock" value="<?php echo $res[0]['ornament_stock'] ?>">
                                </div>
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Metal Pure</label> <i class="text-danger asterik">*</i><?php echo isset($error['pure']) ? $error['pure'] : ''; ?>
                                    <input type="number" class="form-control" name="pure" value="<?php echo $res[0]['pure'] ?>">
                                    
                                </div>
                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Digital Closing stock</label> <i class="text-danger asterik">*</i><?php echo isset($error['digital_closing_stock']) ? $error['digital_closing_stock'] : ''; ?>
                                    <input type="number" class="form-control" name="digital_closing_stock" value="<?php echo $res[0]['digital_closing_stock'] ?>">
                                </div>
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Cash on Hand</label> <i class="text-danger asterik">*</i><?php echo isset($error['cash_hand']) ? $error['cash_hand'] : ''; ?>
                                    <input type="number" class="form-control" name="cash_hand" value="<?php echo $res[0]['cash_hand'] ?>">
                                    
                                </div>
                            </div>

                        </div>
                        <br>
                        
                        </div>
                        <div class="box-footer">
                                <button type="submit" name="btnAdd" class="btn btn-primary">Submit</button>
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
    $('#add_opening_master_form').validate({

        ignore: [],
        debug: false,
        rules: {
            ornament_stock: "required",
            pure: "required",
            digital_closing_stock: "required",
            cash_hand: "required",
         }
    });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });

</script>
