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
        $type= $db->escapeString($fn->xss_clean($_POST['type']));
        $method= $db->escapeString($fn->xss_clean($_POST['method']));

        if (empty($name)) {
            $error['name'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($type)) {
            $error['type'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($method)) {
            $error['method'] = " <span class='label label-danger'>Required!</span>";
        }
       

        if ( !empty($name) && !empty($type) && !empty($method))
        {
                $sql = "INSERT INTO suspense_account (name,type,method) VALUES ('$name','$type','$method')";
                $db->sql($sql);
                $users_result = $db->getResult();
                if (!empty($users_result)) {
                    $users_result = 0;
                } else {
                    $users_result = 1;
                }
                if ($users_result == 1) {
                    $sql = "SELECT id FROM suspense_account ORDER BY id DESC LIMIT 1";
                    $db->sql($sql);
                    $res = $db->getResult();
                    $suspense_account_id = $res[0]['id'];
                    for ($i = 0; $i < count($_POST['weight']); $i++) {

                            $name1 = $db->escapeString($fn->xss_clean($_POST['name'][$i]));
                            $weight = $db->escapeString($fn->xss_clean($_POST['weight'][$i]));                    
                            $sql = "INSERT INTO suspense_account_variant (suspense_account_id,name,weight) VALUES('$suspense_account_id','$name','$weight')";
                            $db->sql($sql);
                            $suspense_result = $db->getResult();
                    }
                    if (!empty($suspense_result)) {
                        $suspense_result = 0;
                    } else {
                        $suspense_result = 1;
                    }
                    $error['add_menu'] = "<section class='content-header'>
                                                    <span class='label label-success'>Suspense Account Added Successfully</span>
                                                    <h4><small><a  href='suspense.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Suspense Account</a></small></h4>
                                                     </section>";
                }
                else {
                        $error['add_menu'] = " <span class='label label-danger'>Failed</span>";
                    }
                
            }
        }
            
?>
<section class="content-header">
    <h1>Add New Suspense Account</h1>
    <?php echo isset($error['add_menu']) ? $error['add_menu'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
    <div class="row">
        <div class="col-md-10">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form id='add_suspense_form' method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="form-group col-md-4">
                                    <label style="margin-right:10px;" class="control-label">Type</label>
                                        <div id="type" class="btn-group">
                                            <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                                <input type="radio" name="type" value="Weight" checked> Weight
                                            </label>
                                            <label class="btn btn-info" data-toggle-class="btn-danger" data-toggle-passive-class="btn-default">
                                                <input type="radio" name="type" value="Cash"> Cash
                                            </label>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-4'>
                                        <input type="text"  id="name" name="name" placeholder="Enter Name" class="form-control" required>
                                </div>
                                <div class="col-md-1">
                                   
                                    <input type="submit" class="btn-primary btn" value="View" name="btnView" />&nbsp;
                                </div>
                            </div>
                        </div>
                        <br>
                        <?php if(isset($_POST['btnView'])){ 
                            ?>

                        <div class="row">
                            <div class="form-group">
                                <div class="form-group col-md-4">
                                    <label style="margin-right:10px;" class="control-label">Method</label>
                                       <div id="method">
                                            <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                                <input type="radio" name="method" value="Inward" checked> Inward
                                            </label>
                                            <label class="btn btn-info" data-toggle-class="btn-danger" data-toggle-passive-class="btn-default">
                                                <input type="radio" name="method" value="Outward"> Outward
                                            </label>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <br>


                        <div  id="packate_div"  >
                            <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Name</label> 
                                                <input type="text" class="form-control" name="name[]"  />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Weight</label> 
                                                <input type="number" onblur="findTotal()" class="weight form-control"  name="weight[]" />
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
                        <div class="row">
                                <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Total</label> 
                                                <input type="text" class="form-control" name="total" id="totalweightsum" readonly/>
                                            </div>

                                </div>
                            </div>
                        <br>
                        </div>
                        <div class="box-footer">
                            <input type="submit" class="btn-primary btn" value="Save" name="btnAdd" />&nbsp;
                            <input type="reset" class="btn-danger btn" value="Clear" id="btnClear" />
                        </div>
                </form>
                <?php } ?>
                        <div  class="hide" id="add_packate_div"  >
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Name</label> 
                                                <input type="text" class="form-control" name="name[]" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Weight</label> 
                                                <input type="number" onblur="findTotal()" class="weight form-control" id="weight" name="weight[]"/>
                                            </div>
                                        </div>
                                        <div class="col-md-1" style="display: grid;">
                                            <label>Remove</label>
                                            <a class="remove text-danger" style="cursor: pointer;"><i class="fa fa-times fa-2x"></i></a>
                                        </div>
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
    $('#add_suspense_form').validate({

        ignore: [],
        debug: false,
        rules: {
            name: "required",
            type: "required",
            inward: "required",
            outward: "required",
            total: "required",

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
    });

</script>
<!--Sript for adding total sum of weight-->
<script>
    function findTotal(){
    var arr = document.getElementsByClassName('weight');
    var tot=0;
    for(var i=0;i<arr.length;i++){
        if(parseFloat(arr[i].value))
            tot += parseFloat(arr[i].value);
    }
    document.getElementById('totalweightsum').value = tot;
}
</script>

<?php $db->disconnect(); ?>