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
        $error = array();
        $name = $db->escapeString($fn->xss_clean($_POST['name']));

        
        if (empty($name)) {
            $error['name'] = " <span class='label label-danger'>Required!</span>";
        }
       

        if ( !empty($name))
        {
                $sql = "INSERT INTO dealers (name) VALUES('$name')";
                $db->sql($sql);
                $users_result = $db->getResult();
                if (!empty($users_result)) {
                    $users_result = 0;
                } else {
                    $users_result = 1;
                }
                if ($users_result == 1) {
                    $sql = "SELECT id FROM dealers ORDER BY id DESC LIMIT 1";
                    $db->sql($sql);
                    $res = $db->getResult();
                    $dealer_id = $res[0]['id'];
                    for ($i = 0; $i < count($_POST['date']); $i++) {
    
                        $date = $db->escapeString($fn->xss_clean($_POST['date'][$i]));
                        $type = $db->escapeString($fn->xss_clean($_POST['type'][$i]));
                        $category = $db->escapeString($fn->xss_clean($_POST['category'][$i])); 
                        $weight = $db->escapeString($fn->xss_clean($_POST['weight'][$i]));
                        $stone_weight = $db->escapeString($fn->xss_clean($_POST['stone_weight'][$i]));
                        $wastage = $db->escapeString($fn->xss_clean($_POST['wastage'][$i]));
                        $touch = $db->escapeString($fn->xss_clean($_POST['touch'][$i]));
                        $rate = $db->escapeString($fn->xss_clean($_POST['rate'][$i]));
                        $gst = $db->escapeString($fn->xss_clean($_POST['gst'][$i]));
                        $amount = $db->escapeString($fn->xss_clean($_POST['amount'][$i]));
                        $mc = $db->escapeString($fn->xss_clean($_POST['mc'][$i]));
                        $sql = "INSERT INTO daily_transaction (dealer_id,date,type,category,weight,stone_weight,wastage,touch,rate,gst,amount,mc) VALUES('$dealer_id','$date','$type','$category','$weight','$stone_weight','$wastage','$touch','$rate','$gst','$amount','$mc')";
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
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Daily Transaction</h3>
                </div>
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
                                    <input type="text" class="form-control" name="name" required>
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
                                                <input type="number" class="form-control" name="weight[]" required />
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
                $(wrapper).append('<div class="row">' + '<div class="row"><div class="col-md-3"><div class="form-group"><label for="date">Date</label>' + '<input type="date" class="form-control" name="date[]" ></div></div>' +'<div class="col-md-3"><div class="form-group"><label for="type">Type</label>' + '<select id=type name="type[]" class=form-control><option value="none">Select</option><?php
                                                            $sql = "SELECT * FROM `types`";
                                                            $db->sql($sql);
                                                            $result = $db->getResult();
                                                            foreach ($result as $value) {
                                                            ?><option value="<?= $value['type'] ?>"><?= $value['type'] ?></option><?php } ?></select></div></div>'+ '<div class="col-md-3"><div class="form-group"><label for="type">Category</label>' + '<select id=category name="category[]" class=form-control><?php
                                                            $sql = "SELECT * FROM `brand`";
                                                            $db->sql($sql);
                                                            $result = $db->getResult();
                                                            foreach ($result as $value) {
                                                            ?><option value="<?= $value['category'] ?>"><?= $value['category'] ?></option><?php } ?></select></div></div></div>' +'<div class="col-md-2"><div class="form-group"><label for="weight">Weight</label>' + '<input type="number" class="form-control" name="weight[]"></div></div>'+'<div class="col-md-2"><div class="form-group"><label for="stone_weight">Stone Weight</label>' + '<input type="number" class="form-control" name="stone_weight[]"></div></div>'+'<div class="col-md-2"><div class="form-group"><label for="wastage">Wastage</label>' + '<input type="number" class="form-control" name="wastage[]" ></div></div>'+'<div class="col-md-2"><div class="form-group"><label for="touch">Touch</label>' + '<input type="number" class="form-control" name="touch[]"></div></div>'+'<div class="row"><div class="col-md-2"><div class="form-group"><label for="rate">Rate</label>' + '<input type="number" class="form-control" name="rate[]" ></div></div>'+'<div class="col-md-2"><div class="form-group"><label for="gst">GST</label>' + '<input type="number" class="form-control" name="gst[]"  ></div></div>'+'<div class="col-md-2"><div class="form-group"><label for="amount">Amount</label>' + '<input type="number" class="form-control" name="amount[]" ></div></div>'+'<div class="col-md-2"><div class="form-group"><label for="mc">MC</label>' + '<input type="number" class="form-control" name="mc[]"></div></div></div>' + '<div class="col-md-1" style="display: grid;"><label>Remove</label><a class="remove text-danger" style="cursor: pointer;"><i class="fa fa-times fa-2x"></i></a></div>'+'</div><hr>'); //add input box
            } else {
                alert('You Reached the limits')
            }
        });

        $(wrapper).on("click", ".remove", function (e) {
            e.preventDefault();
            $(this).closest('.row').remove();
            x--;
        })
    });
</script>
<?php $db->disconnect(); ?>