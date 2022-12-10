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
?>
<?php
if (isset($_POST['btnAdd'])) {
        $error = array();
        $from_weight = $db->escapeString($fn->xss_clean($_POST['from_weight']));
        $to_weight = $db->escapeString($fn->xss_clean($_POST['to_weight']));
        $weight = $db->escapeString($fn->xss_clean($_POST['weight']));


        
        if (empty($from_weight)) {
            $error['from_weight'] = " <span class='label label-danger'>Required!</span>";
        }
         
        if (empty($to_weight)) {
            $error['to_weight'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($weight)) {
            $error['weight'] = " <span class='label label-danger'>Required!</span>";
        }
       

        if ( !empty($from_weight) && !empty($to_weight) && !empty($weight))
        {
                $sql = "INSERT INTO master_weight (from_weight,to_weight,weight) VALUES('$from_weight','$to_weight','$weight')";
                $db->sql($sql);
                $weight_result = $db->getResult();
                if (!empty($weight_result)) {
                    $weight_result = 0;
                } else {
                    $weight_result = 1;
                }
                if ($weight_result == 1) {
                    $error['add_menu'] = "<section class='content-header'>
                    <span class='label label-success'> Master Weight Added Successfully</span>
                    <h4><small><a  href='master_weight.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Master Weights</a></small></h4>
                    </section>";
                }
                else {
                    $error['add_menu'] = " <span class='label label-danger'>Failed</span>";

                }
        }else{
                $error['add_menu'] = " <span class='label label-danger'> Master Weight Already Exists</span>";

            }
    }
?>
<section class="content-header">
    <h1>Add Master Weight</h1>
    <?php echo isset($error['add_menu']) ? $error['add_menu'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form id='add_weight_form' method="post" enctype="multipart/form-data">
                    <div class="box-body">
                            <div class="form-group">
                                    <label for="exampleInputEmail1"> From Weight</label> <i class="text-danger asterik">*</i><?php echo isset($error['from_weight']) ? $error['from_weight'] : ''; ?>
                                    <input type="text" class="form-control" name="from_weight" required>
                            </div>
                            <div class="form-group">
                                    <label for="exampleInputEmail1"> To Weight</label> <i class="text-danger asterik">*</i><?php echo isset($error['to_weight']) ? $error['to_weight'] : ''; ?>
                                    <input type="text" class="form-control" name="to_weight" required>
                            </div>
                            <div class="form-group">
                                    <label for="exampleInputEmail1"> Weight</label> <i class="text-danger asterik">*</i><?php echo isset($error['weight']) ? $error['weight'] : ''; ?>
                                    <input type="text" class="form-control" name="weight" required>
                            </div>
                        
                    </div>
                    <!-- /.box-body -->
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
    $('#add_weight_form').validate({

        ignore: [],
        debug: false,
        rules: {
        from_weight = "required",
        weight = "required",
        to_weight ="required",
         }
    });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });

</script>

