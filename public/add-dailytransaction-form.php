<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

$res = $db->getResult();

$sql_query = "SELECT value FROM settings WHERE variable = 'Currency'";
$pincode_ids_exc = "";
$db->sql($sql_query);
$res_cur = $db->getResult();

if (isset($_POST['btnAdd'])) {
    if ($permissions['dailytransaction']['create'] == 1) {
        $error = array();
        $name = $db->escapeString($fn->xss_clean($_POST['name']));
        $purity = (isset($_POST['purity']) && !empty($_POST['purity'])) ? $db->escapeString($fn->xss_clean($_POST['purity'])) : "0";
        $weight = (isset($_POST['weight']) && !empty($_POST['weight'])) ? $db->escapeString($fn->xss_clean($_POST['weight'])) : "0";
        $stone_weight = (isset($_POST['stone_weight']) && !empty($_POST['stone_weight'])) ? $db->escapeString($fn->xss_clean($_POST['stone_weight'])) : "0";
        $wastage = (isset($_POST['wastage']) && !empty($_POST['wastage'])) ? $db->escapeString($fn->xss_clean($_POST['wastage'])) : "0";
        $touch = (isset($_POST['touch']) && !empty($_POST['touch'])) ? $db->escapeString($fn->xss_clean($_POST['touch'])) : "0";
        $date = $db->escapeString($fn->xss_clean($_POST['date']));
        $type = $db->escapeString($fn->xss_clean($_POST['type']));
        $subcategory_id = $db->escapeString($fn->xss_clean($_POST['subcategory_id'])); 
        $rate = $db->escapeString($fn->xss_clean($_POST['rate']));
        $gst = $db->escapeString($fn->xss_clean($_POST['gst']));
        $amount = $db->escapeString($fn->xss_clean($_POST['amount']));
        $mc = $db->escapeString($fn->xss_clean($_POST['mc']));
       

        if ( !empty($name))
        {
                $sql = "INSERT INTO daily_transaction (goldsmith_master_id,date,type,subcategory,weight,stone_weight,wastage,touch,rate,gst,amount,mc,purity) VALUES('$name','$date','$type','$subcategory_id','$weight','$stone_weight','$wastage','$touch','$rate','$gst','$amount','$mc','$purity')";
                 $db->sql($sql);
                $users_result = $db->getResult();
                if (!empty($users_result)) {
                    $users_result = 0;
                } else {
                    $users_result = 1;
                }
                if ($users_result == 1) {
                    $error['add_menu'] = "<section class='content-header'>
                                                    <span class='label label-success'>Daily Transaction Added Successfully</span>
                                                    <h4><small><a  href='dailytransactions.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Daily Transactions</a></small></h4>
                                                     </section>";
                } else {
                    $error['add_menu'] = " <span class='label label-danger'>Failed</span>";
                }

            }

    }

}
?>
<section class="content-header">
    <h1>Add Daily Transaction <small><a href='dailytransactions.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Daily Transactions</a></small></h1>
    <?php echo isset($error['add_menu']) ? $error['add_menu'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
        <?php if ($permissions['dailytransaction']['create'] == 0) { ?>
                <div class="alert alert-danger">You have no permission to create daily transaction.</div>
            <?php } ?>
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form id='add_dailytransaction_form' method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1"> Name</label> <i class="text-danger asterik">*</i><?php echo isset($error['name']) ? $error['name'] : ''; ?>
                                    <select id='name' name="name" class='form-control' required>
                                        <?php
                                        $sql = "SELECT * FROM `goldsmith_master`";
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
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Date</label> <i class="text-danger asterik">*</i><?php echo isset($error['date']) ? $error['date'] : ''; ?>
                                        <input type="date" id="date" class="form-control" name="date" required />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Type</label> <i class="text-danger asterik">*</i>
                                        <select id='type' name="type" class='form-control' required>
                                        <option value="">Select</option>
                                                    <?php
                                                    $sql = "SELECT * FROM `types`";
                                                    $db->sql($sql);

                                                    $result = $db->getResult();
                                                    foreach ($result as $value) {
                                                    ?>
                                                        <option value='<?= $value['type'] ?>'><?= $value['type'] ?></option>
                                                    <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Subcategory</label> <i class="text-danger asterik">*</i>
                                        <select id='subcategory_id' name="subcategory_id" class='form-control' required>
                                                    <?php
                                                    $sql = "SELECT id,name FROM `subcategories`";
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
                        <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Weight</label> <i class="text-danger asterik">*</i><?php echo isset($error['weight']) ? $error['weight'] : ''; ?>
                                        <input type="number" class="form-control weight" name="weight" id = "weight" required />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Stone Weight</label> <i class="text-danger asterik">*</i><?php echo isset($error['stone_weight']) ? $error['stone_weight'] : ''; ?>
                                        <input type="number" class="form-control" name="stone_weight" required />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Wastage</label><i class="text-danger asterik">*</i><?php echo isset($error['wastage']) ? $error['wastage'] : ''; ?>
                                        <input type="number" class="form-control" name="wastage" required />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Touch</label><i class="text-danger asterik">*</i>
                                        <input type="number" class="form-control" name="touch" id="touch" readonly />
                                    </div>
                                </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Purity(gram)</label><i class="text-danger asterik">*</i>
                                        <input type="number" class="form-control" value="0" name="purity" id="purity" readonly />
                                    </div>
                                </div>
                        </div>
                        <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Rate</label><i class="text-danger asterik">*</i><?php echo isset($error['rate']) ? $error['rate'] : ''; ?>
                                        <input type="number" class="form-control" name="rate" required />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"> GST</label><i class="text-danger asterik">*</i><?php echo isset($error['gst']) ? $error['gst'] : ''; ?>
                                        <input type="number" class="form-control" name="gst" required />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group packate_div">
                                        <label for="exampleInputEmail1">Amount</label><i class="text-danger asterik">*</i><?php echo isset($error['amount']) ? $error['amount'] : ''; ?> 
                                        <input type="number" class="form-control" name="amount" required />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group packate_div">
                                        <label for="exampleInputEmail1">MC</label><i class="text-danger asterik">*</i><?php echo isset($error['mc']) ? $error['mc'] : ''; ?>
                                        <input type="number" class="form-control" name="mc" required />
                                    </div>
                                </div>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <input type="submit" class="btn-primary btn" value="Add" name="btnAdd" />&nbsp;
                        <input type="reset" class="btn-danger btn" value="Clear" id="btnClear" />
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<div class="separator"> </div>

<script>
    $(document).on('change', '#subcategory_id', function() {
        var parentid = $(this).parent().parent().parent( ".row" ).attr( "id");
        $("#touch").val("25");
        //$("#"+parentid+ " .touchname").val("25");
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
    $('#add_dailytransaction_form').validate({

        ignore: [],
        debug: false,
        rules: {
            name: "required",
            date: "required",
            type: "required",
            category: "required",
            weight: "required",
            stone_weight: "required",
            wastage: "required",
            touch: "required",
            rate: "required",

        }
    });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });
</script>
<script>
    $(document).ready(function () {
        $('#name').select2({
        width: 'element',
        placeholder: 'Type in name to search',

    });
    });

</script>
<script>
    document.getElementById('date').valueAsDate = new Date();
</script>
<script>
    $(document).on('change', '#subcategory_id', function() {
        var parentid = $(this).parent().parent().parent( ".row" ).attr( "id");
        $("#touch").val("25");
    });
</script>
<?php $db->disconnect(); ?>