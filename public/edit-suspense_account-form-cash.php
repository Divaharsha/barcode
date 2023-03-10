<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

$ID = $_GET['id'];


if (isset($_POST['btnUpdate'])) {

    if ($permissions['suspenseaccount']['create'] == 1) {
        $error = array();
        $name = $db->escapeString($fn->xss_clean($_POST['name']));
        $inward= $db->escapeString($fn->xss_clean($_POST['inward']));
        $outward= $db->escapeString($fn->xss_clean($_POST['outward']));
    
        if (empty($name)) {
            $error['name'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($inward)) {
            $error['inward'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($outward)) {
            $error['outward'] = " <span class='label label-danger'>Required!</span>";
        }
       

        if ( !empty($name) && !empty($inward) && !empty($outward))
        {

            $sql = "UPDATE `suspense_account_cash` SET `inward` = '$inward', `outward` = '$outward' WHERE `suspense_account_id` = '$ID'";
            $db->sql($sql);
            $users_result = $db->getResult();

            if (!empty($users_result)) {
                $users_result = 0;
            } else {
                $suspense_result = 1;
            }
            $error['add_menu'] = "<section class='content-header'>
                                            <span class='label label-success'>Cash Updated Successfully</span>
                                            <h4><small><a  href='suspense.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Suspense Account</a></small></h4>
                                            </section>";
                }
            }
}
$sql_query = "SELECT * FROM `suspense_account` WHERE id = '$ID'";
$db->sql($sql_query);
$res_acc = $db->getResult();
$sql_query = "SELECT * FROM suspense_account_cash WHERE suspense_account_id = '$ID'";
$db->sql($sql_query);
$res_cash = $db->getResult();
            
?>
<section class="content-header">
    <h1>Edit Cash</h1>
    <?php echo isset($error['add_menu']) ? $error['add_menu'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
    <div class="row">
        <div class="col-md-10">
        <?php if ($permissions['suspenseaccount']['create'] == 0) { ?>
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
                                    <label for="exampleInputEmail1">Name</label> 
                                    <input type="text"  id="name" name="name" placeholder="Enter Name" class="form-control" value="<?php echo $res_acc[0]['holder_name'];?>" readonly required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Inward</label> 
                                    <input type="number"  id="name" name="inward" placeholder="Enter Inward" class="form-control" value="<?php echo $res_cash[0]['inward'];?>" required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Outward</label> 
                                    <input type="number"  id="outward" name="outward" placeholder="Enter Outward" class="form-control" value="<?php echo $res_cash[0]['outward'];?>" required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-1">
                                   
                                   <input type="submit" class="btn-primary btn" value="Update" name="btnUpdate" />&nbsp;
                               </div>
                            </div>

                        </div>
                        <br>
                </form>
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

<?php $db->disconnect(); ?>