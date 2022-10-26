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
       

        if ( !empty($name))
        {
                $sql = "SELECT * FROM `goldsmith_master` WHERE `name` = '$name'";
                $db->sql($sql);
                $users_result = $db->getResult();
                if (!empty($users_result)) {
                    $users_result = 0;
                } else {
                    $users_result = 1;
                }
                if ($users_result == 1) {
                    $sql = "SELECT id FROM goldsmith_master ORDER BY id DESC LIMIT 1";
                    $db->sql($sql);
                    $res = $db->getResult();
                    for ($i = 0; $i < count($_POST['date']); $i++) {
    
                        $purity = (isset($_POST['purity'][$i]) && !empty($_POST['purity'][$i])) ? $db->escapeString($fn->xss_clean($_POST['purity'][$i])) : "0";
                        $weight = (isset($_POST['weight'][$i]) && !empty($_POST['weight'][$i])) ? $db->escapeString($fn->xss_clean($_POST['weight'][$i])) : "0";
                        $stone_weight = (isset($_POST['stone_weight'][$i]) && !empty($_POST['stone_weight'][$i])) ? $db->escapeString($fn->xss_clean($_POST['stone_weight'][$i])) : "0";
                        $wastage = (isset($_POST['wastage'][$i]) && !empty($_POST['wastage'][$i])) ? $db->escapeString($fn->xss_clean($_POST['wastage'][$i])) : "0";
                        $touch = (isset($_POST['touch'][$i]) && !empty($_POST['touch'][$i])) ? $db->escapeString($fn->xss_clean($_POST['touch'][$i])) : "0";
                        $date = $db->escapeString($fn->xss_clean($_POST['date'][$i]));
                        $type = $db->escapeString($fn->xss_clean($_POST['type'][$i]));
                        $category = $db->escapeString($fn->xss_clean($_POST['category'][$i])); 
                        $rate = $db->escapeString($fn->xss_clean($_POST['rate'][$i]));
                        $gst = $db->escapeString($fn->xss_clean($_POST['gst'][$i]));
                        $amount = $db->escapeString($fn->xss_clean($_POST['amount'][$i]));
                        $mc = $db->escapeString($fn->xss_clean($_POST['mc'][$i]));
                        $sql = "INSERT INTO daily_transaction (goldsmith_master_id,date,type,category,weight,stone_weight,wastage,touch,rate,gst,amount,mc,purity) VALUES('$name','$date','$type','$category','$weight','$stone_weight','$wastage','$touch','$rate','$gst','$amount','$mc','$purity')";
                        $db->sql($sql);
                        $daily_transaction_result = $db->getResult();
                    }
                    if (!empty($daily_transaction_result)) {
                        $daily_transaction_result = 0;
                    } else {
                        $daily_transaction_result = 1;
                    }
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
    <h1>Add Daily Transaction</h1>
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
                                <div class='col-md-3'>
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
                        <hr>
                        <div style="padding-left:15px;" id="packate_div"  >
                            <div class="row">
                                <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Date</label> 
                                                <input type="date" id="date" class="form-control" name="date[]" required />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Type</label> 
                                                <select id='type' name="type[]" class='form-control' required>
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
                                        <div class="col-md-3">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Category</label> 
                                                <select id='category' name="category[]" class='form-control' required>
                                                            <?php
                                                            $sql = "SELECT * FROM `brand`";
                                                            $db->sql($sql);

                                                            $result = $db->getResult();
                                                            foreach ($result as $value) {
                                                            ?>
                                                                <option value='<?= $value['category'] ?>'><?= $value['category'] ?></option>
                                                            <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                </div>
                                <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Weight</label> 
                                                <input type="number" class="form-control weight" name="weight[]" id = "weight" required />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Stone Weight</label> 
                                                <input type="number" class="form-control" name="stone_weight[]" required />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Wastage</label>
                                                <input type="number" class="form-control" name="wastage[]" required />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Touch</label> 
                                                <input type="number" class="form-control" name="touch[]" required />
                                            </div>
                                        </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Purity(gram)</label>
                                                <input type="number" class="form-control" value="0" name="purity[]" id="purity" readonly />
                                            </div>
                                        </div>
                                </div>
                                <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Rate</label>
                                                <input type="number" class="form-control" name="rate[]" required />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1"> GST</label> 
                                                <input type="number" class="form-control" name="gst[]" required />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Amount</label> 
                                                <input type="number" class="form-control" name="amount[]" required />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">MC</label> 
                                                <input type="number" class="form-control" name="mc[]" required />
                                            </div>
                                        </div>
                                </div>
                                <div class="col-md-1">
                                    <label>Variation</label>
                                    <a class="add_packate_variation" title="Add variation of product" style="cursor: pointer;"><i class="fa fa-plus-square-o fa-2x"></i></a>
                                </div>
                                <div id="variations">
                                </div>
                            </div>
                        </div>
                        <br>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <input type="submit" class="btn-primary btn" value="Add" name="btnAdd" />&nbsp;
                        <input type="reset" class="btn-danger btn" value="Clear" id="btnClear" />
                    </div>
                </form>
                <div class="hide" style="padding-left:15px;" id="add_packate_div"  >
                            <div class="row">
                                <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Date</label> 
                                                <input type="date" class="form-control" name="date[]" required />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Type</label> 
                                                <select id='type' name="type[]" class='form-control' required>
                                                <option value="none">Select</option>
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
                                        <div class="col-md-3">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Category</label> 
                                                <select id='category' name="category[]" class='form-control' required>
                                                            <?php
                                                            $sql = "SELECT * FROM `brand`";
                                                            $db->sql($sql);

                                                            $result = $db->getResult();
                                                            foreach ($result as $value) {
                                                            ?>
                                                                <option value='<?= $value['category'] ?>'><?= $value['category'] ?></option>
                                                            <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                </div>
                                <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Weight</label> 
                                                <input type="number" class="form-control weight" name="weight[]" id = "weight" required />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Stone Weight</label> 
                                                <input type="number" class="form-control" name="stone_weight[]" required />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Wastage</label>
                                                <input type="number" class="form-control" name="wastage[]" required />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Touch</label> 
                                                <input type="number" class="form-control" name="touch[]" required />
                                            </div>
                                        </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Purity(gram)</label>
                                                <input type="number" class="form-control" value="0" name="purity[]" id="purity" readonly />
                                            </div>
                                        </div>
                                </div>
                                <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Rate</label>
                                                <input type="number" class="form-control" name="rate[]" required />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1"> GST</label> 
                                                <input type="number" class="form-control" name="gst[]" required />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Amount</label> 
                                                <input type="number" class="form-control" name="amount[]" required />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">MC</label> 
                                                <input type="number" class="form-control" name="mc[]" required />
                                            </div>
                                        </div>
                                </div>
                                <div class="col-md-1" style="display: grid;">
                                    <label>Remove</label>
                                    <a class="remove text-danger" style="cursor: pointer;"><i class="fa fa-times fa-2x"></i></a></div>
                            </div>
                        </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<div class="separator"> </div>


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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        var max_fields = 8;
        var wrapper = $("#packate_div");
        var add_button = $(".add_packate_variation");

        var x = 1;
        $(add_button).click(function (e) {
            e.preventDefault();
            if (x < max_fields) {
                x++;
                $(wrapper).append($("#add_packate_div").html());
            } else {
                alert('You Reached the limits')
            }
        });

        $(wrapper).on("click", ".remove", function (e) {
            e.preventDefault();
            $(this).closest('.row').remove();
            x--;
        })
        $('#name').select2({
        width: 'element',
        placeholder: 'Type in name to search',

    });
    });

</script>
<script>
    document.getElementById('date').valueAsDate = new Date();
</script>
<!-- <script>
    $(document).on('input', '.weight', function(){
        let weight = $('#weight').val();
        $('#purity').val(weight);


    });
</script> -->

<?php $db->disconnect(); ?>