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
if (isset($_GET['name'])) {
    $suspense_account_name = $db->escapeString($_GET['name']);
} else {
    return false;
    exit(0);
}
if (isset($_POST['btnAdd'])) {
    if ($permissions['suspenseaccount']['update'] == 1) {
        $error = array();
        $holder_name = $db->escapeString($fn->xss_clean($_POST['holder_name']));
        $type= $db->escapeString($fn->xss_clean($_POST['type']));
        $method= $db->escapeString($fn->xss_clean($_POST['method']));
        $suspense_account_id = $db->escapeString($fn->xss_clean($_POST['sus_id']));

        if (empty($holder_name)) {
            $error['holder_name'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($type)) {
            $error['type'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($method)) {
            $error['method'] = " <span class='label label-danger'>Required!</span>";
        }
       

        if ( !empty($holder_name) && !empty($type) && !empty($method))
        {
            if(empty($suspense_account_id)){
                $sql = "INSERT INTO suspense_account (holder_name,type) VALUES ('$holder_name','$type')";
                $db->sql($sql);
                $users_result = $db->getResult();
                $sql = "SELECT * FROM suspense_account ORDER BY id DESC LIMIT 1";
                $db->sql($sql);
                $sus_res = $db->getResult();
                $suspense_account_id = $sus_res[0]['id'];

            }
            if(isset($_POST['weight'])){
                for ($i = 0; $i < count($_POST['weight']); $i++) {

                    $name = $db->escapeString($fn->xss_clean($_POST['name'][$i]));
                    $weight = $db->escapeString($fn->xss_clean($_POST['weight'][$i]));  
                    $sus_var_id = $db->escapeString($fn->xss_clean($_POST['sus_var_id'][$i]));      
                    $sql = "UPDATE suspense_account_variant SET name='$name',weight='$weight' WHERE id =  $sus_var_id";                
                    $db->sql($sql);
                    $suspense_result = $db->getResult();
                }

            }

            if (
                isset($_POST['insert_name']) && isset($_POST['insert_weight'])){
                for ($i = 0; $i < count($_POST['insert_name']); $i++) {
                    $name = $db->escapeString($fn->xss_clean($_POST['insert_name'][$i]));
                    $weight = $db->escapeString($fn->xss_clean($_POST['insert_weight'][$i]));
                    $sql = "INSERT INTO suspense_account_variant (suspense_account_id,name,weight,method) VALUES('$suspense_account_id','$name','$weight','$method')";
                    $db->sql($sql);

                }

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
    }

}
            
?>
<section class="content-header">
    <h1>Edit Weight</h1>
    <?php echo isset($error['add_menu']) ? $error['add_menu'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
    <div class="row">
        <div class="col-md-10">
        <?php if ($permissions['suspenseaccount']['update'] == 0) { ?>
                <div class="alert alert-danger">You have no permission to create suspense account.</div>
            <?php } ?>
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>
                <form id='add_sus_form' method="post" enctype="multipart/form-data">
                <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-4'>
                                        <input type="text"  id="name" name="susname" placeholder="Enter Name" value="<?php echo $suspense_account_name?>" class="form-control" readonly required>
                                </div>
                                <div class='col-md-4'>
                                    <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                                <input type="radio" name="method" value="Inward" checked> Inward
                                            </label>
                                            <label class="btn btn-info" data-toggle-class="btn-danger" data-toggle-passive-class="btn-default">
                                                <input type="radio" name="method" value="Outward"> Outward
                                            </label>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-1">
                                   
                                   <input type="submit" class="btn-primary btn" value="View" name="btnView" />&nbsp;
                               </div>
                            </div>

                        </div>
                        <br>
                </form>

                <!-- /.box-header -->
                <!-- form start -->
                <form id='add_suspense_form' method="post" enctype="multipart/form-data">

                        <?php if(isset($_POST['btnView'])){ 
                            $susname = $db->escapeString($fn->xss_clean($_POST['susname']));
                            $method = $db->escapeString($fn->xss_clean($_POST['method']));
                            $type= 'Weight';
                            $sql_query = "SELECT * FROM suspense_account WHERE holder_name = '$susname' AND type = 'Weight'";
                            $db->sql($sql_query);
                            $ressus = $db->getResult();
                            $num = $db->numRows($ressus);
                            $ID = "";
                            if($num > 0){
                                $ID = $ressus[0]['id'];
                                $sql_query = "SELECT * FROM suspense_account_variant WHERE suspense_account_id =" . $ID;
                                $db->sql($sql_query);
                                $ressusvari = $db->getResult();

                            }

                            ?>
                            <input type="hidden" name="type" value="<?php echo $type?>">
                            <input type="hidden" name="sus_id" value="<?php echo $ID?>">
                            <input type="hidden" name="method" value="<?php echo $method?>">
                            
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group packate_div">
                                    <label for="exampleInputEmail1">Suspense Account Name</label> 
                                    <input type="text" class="form-control" name="holder_name" value="<?php echo $susname?>" readonly/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group packate_div">
                                    <label for="exampleInputEmail1">Method</label> 
                                    <input type="text" class="form-control" name="method" value="<?php echo $method?>" readonly/>
                                </div>
                            </div>
                        </div>
                        <br>
                        <?php
                        if($num > 0){
                            $i=0;
                            foreach ($ressusvari as $row) {?>
                                <div  id="packate_div"  >
                                    
                                    <div class="row packate_div">
                                    <input type="hidden" class="form-control" name="sus_var_id[]" id="sus_var_id" value='<?= $row['id']; ?>' />
        
                                        <div class="col-md-3">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Name</label> 
                                                <input type="text" class="form-control" name="name[]" value="<?php echo $row['name'] ?>"  />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Weight</label> 
                                                <input type="number" onblur="findTotal()" class="weight form-control" value="<?php echo $row['weight'] ?>"  name="weight[]" />
                                            </div>
                                        </div>
                                        <?php if ($i == 0) { ?>
                                            <div class="col-md-1">
                                                <label>Variation</label>
                                                <a class="add_packate_variation" title="Add variation of product" style="cursor: pointer;"><i class="fa fa-plus-square-o fa-2x"></i></a>
                                            </div>
                                        <?php } else { ?>
                                            <div class="col-md-1" style="display: grid;">
                                                <label>Remove</label>
                                                <a class="remove_variation text-danger" data-id="data_delete" title="Remove variation of product" style="cursor: pointer;"><i class="fa fa-times fa-2x"></i></a>
                                            </div>
                                        <?php } ?>                                
                                    </div>
                                     <?php $i++; } ?>   
                                </div>
                        <?php
                        }else{
                            ?>
                                <div id="add_pckate_div"  >
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Name</label> 
                                                <input type="text" class="form-control" name="insert_name[]" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Weight</label> 
                                                <input type="number" onblur="findTotal()" class="weight form-control" id="weight" name="insert_weight[]"/>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                                <label>Variation</label>
                                                <a class="add_packate_variation" title="Add variation of product" style="cursor: pointer;"><i class="fa fa-plus-square-o fa-2x"></i></a>
                                            </div>

                                    </div>
                                </div>
                            <?php
                        }
                        ?>


                        <div id="variations">
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
                                                <input type="text" class="form-control" name="insert_name[]" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group packate_div">
                                                <label for="exampleInputEmail1">Weight</label> 
                                                <input type="number" onblur="findTotal()" class="weight form-control" id="weight" name="insert_weight[]"/>
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

<script>
    $(document).on('click', '.remove_variation', function() {
        $(this).closest('.row').remove();
    });

</script>
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
        var wrapper = $("#variations");
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

<script>
        $(document).on('click', '.remove_variation', function() {
        if ($(this).data('id') == 'data_delete') {
            if (confirm('Are you sure? Want to delete this row')) {
                var id = $(this).closest('div.row').find("input[id='sus_var_id']").val();
                $.ajax({
                    url: 'public/db-operation.php',
                    type: "post",
                    data: 'id=' + id + '&delete_sus_weight=1',
                    success: function(result) {
                        if (result) {
                            location.reload();
                        } else {
                            alert("not deleted!");
                        }
                    }
                });
            }
        } else {
            $(this).closest('.row').remove();
        }
    });

</script>

<?php $db->disconnect(); ?>