<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
?>
<?php

if (isset($_GET['id'])) {
    $ID = $db->escapeString($_GET['id']);
} else {
    return false;
    exit(0);
}

if (isset($_POST['btnEdit'])) {

    // if ($permissions['dailytransaction']['update'] == 1) {
        $name = $db->escapeString($fn->xss_clean($_POST['name']));
        $date = $db->escapeString($fn->xss_clean($_POST['date']));
        $type = $db->escapeString($fn->xss_clean($_POST['type']));
        $subcategory_id = $db->escapeString($fn->xss_clean($_POST['subcategory_id'])); 
        $weight = (isset($_POST['weight']) && !empty($_POST['weight'])) ? $db->escapeString($fn->xss_clean($_POST['weight'])) : "0";
        $stone_weight = (isset($_POST['stone_weight']) && !empty($_POST['stone_weight'])) ? $db->escapeString($fn->xss_clean($_POST['stone_weight'])) : "0";
        $wastage = (isset($_POST['wastage']) && !empty($_POST['wastage'])) ? $db->escapeString($fn->xss_clean($_POST['wastage'])) : "0";
        $touch = (isset($_POST['touch']) && !empty($_POST['touch'])) ? $db->escapeString($fn->xss_clean($_POST['touch'])) : "0";
        $rate = $db->escapeString($fn->xss_clean($_POST['rate']));
        $gst = $db->escapeString($fn->xss_clean($_POST['gst']));
        $amount = $db->escapeString($fn->xss_clean($_POST['amount']));
        $mc = $db->escapeString($fn->xss_clean($_POST['mc']));
        $purity = (isset($_POST['purity']) && !empty($_POST['purity'])) ? $db->escapeString($fn->xss_clean($_POST['purity'])) : "0";   
        $error = array();
    
        
        if (empty($name)) {
            $error['name'] = " <span class='label label-danger'>Required!</span>";
        }
    
            
    
        if ( !empty($name))
        {            
            if($type=='Credit Sales'){
                $sql = "UPDATE `daily_transaction` SET `goldsmith_master_id`='$name',`date` = '$date', `type` = '$type', `subcategory_id` = '$subcategory_id', `weight` = '$weight', `stone_weight` = '$stone_weight', `wastage` = '$wastage', `touch` = '$touch', `rate` = '$rate', `gst` = '$gst', `amount` = '$amount', `mc` = '$mc', `purity` = '$purity' WHERE `daily_transaction`.`id` = $ID";
                $db->sql($sql);
            }
            elseif($type=='Credit Purchase'){
                $sql = "UPDATE `daily_transaction` SET `goldsmith_master_id`='$name',`date` = '$date', `type` = '$type', `subcategory_id` = '$subcategory_id', `weight` = '$weight', `stone_weight` = '$stone_weight', `wastage` = '$wastage', `touch` = '$touch', `rate` = '$rate', `gst` = '$gst', `amount` = '$amount', `mc` = '$mc', `purity` = '$purity' WHERE `daily_transaction`.`id` = $ID";
                $db->sql($sql);
            }
            else{
                $sql = "UPDATE `daily_transaction` SET `goldsmith_master_id`='$name',`date` = '$date', `type` = '$type',`subcategory_id` = '',`weight` = '$weight', `stone_weight` = '$stone_weight', `wastage` = '$wastage',`rate` = '$rate', `gst` = '$gst', `amount` = '$amount', `mc` = '$mc', `purity` = '$purity' WHERE `daily_transaction`.`id` = $ID";
                $db->sql($sql);
            }
            $update_result = $db->getResult();
                 $update_result = $db->getResult();
                if (!empty($res)) {
                    $update_result = 0;
                } else {
                    $update_result = 1;
                }
    
                // check update result
                if ($update_result == 1) {
                    $error['update_transaction'] = " <section class='content-header'><span class='label label-success'>Daily Transactions updated Successfully</span></section>";
                } else {
                    $error['update_transaction'] = " <span class='label label-danger'>Failed to update</span>";
                }
            }

    }

// create array variable to store previous data
$data = array();


$sql_query = "SELECT * FROM `daily_transaction` dt WHERE dt.id = '$ID'";
$db->sql($sql_query);
$res = $db->getResult();

if (isset($_POST['btnCancel'])) { ?>
	<script>
		window.location.href = "dailytransactions.php";
	</script>
<?php } ?>
<section class="content-header">
	<h1>
		Edit Daily Transaction<small><a href='dailytransactions.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Daily Transactions</a></small></h1>
	<small><?php echo isset($error['update_transaction']) ? $error['update_transaction'] : ''; ?></small>
	<ol class="breadcrumb">
		<li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
	</ol>
</section>
<section class="content">
	<!-- Main row -->

	<div class="row">
		<div class="col-md-12">
        <!-- <?php if ($permissions['dailytransaction']['update'] == 0) { ?>
                <div class="alert alert-danger">You have no permission to update daily transaction.</div>
            <?php } ?> -->
			<!-- general form elements -->
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Edit Daily Transaction</h3>
				</div><!-- /.box-header -->
				<!-- form start -->
				<form id="edit_transaction_form" method="post" enctype="multipart/form-data">
					<div class="box-body">
						   <div class="row">
							    <div class="form-group">
                                    <div class="col-md-4">
										<label for="exampleInputEmail1">Name</label><?php echo isset($error['name']) ? $error['name'] : ''; ?>
                                        <select id='name' name="name" class='form-control' required>
                                                <?php
                                                $sql = "SELECT * FROM `goldsmith_master`";
                                                $db->sql($sql);
                                                $result = $db->getResult();
                                                foreach ($result as $value) {
                                                ?>
												   <option value='<?= $value['id'] ?>' <?= $value['id']==$res[0]['goldsmith_master_id'] ? 'selected="selected"' : '';?>><?= $value['name'] ?></option>
                                                <?php } ?>
                                        </select>								
                            	    </div>
								</div>
						   </div>
						   <br>
                           <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"> Date</label> <i class="text-danger asterik">*</i>
                                        <input type="date" class="form-control" name="date" value="<?php echo $res[0]['date'] ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Type</label> 
                                        <select id='type' name="type" class='form-control' required>
                                        <option value="none">Select</option>
                                                    <?php
                                                    $sql = "SELECT * FROM `types`";
                                                    $db->sql($sql);

                                                    $result = $db->getResult();
                                                    foreach ($result as $value) {
                                                    ?>
                                                        <option value='<?= $value['type'] ?>' <?=$res[0]['type'] == $value['type'] ? ' selected="selected"' : '';?>><?= $value['type'] ?></option>
                                                    <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group" id="old_subcategories">
                                        <?php
                                        if($res[0]['type']=='Credit Purchase' || $res[0]['type']=='Credit Sales'){
                                            ?>
                                        <label for="exampleInputEmail1">Subcategory</label> 
                                        <select id='subcategory_id' name="subcategory_id" class='form-control' required>
                                                    <?php
                                                    $sql = "SELECT id,name FROM `subcategories`";
                                                    $db->sql($sql);
                                                    $result = $db->getResult();
                                                    foreach ($result as $value) {
                                                    ?>
                                                        <option value='<?= $value['id'] ?>' <?=$res[0]['subcategory_id'] == $value['id'] ? ' selected="selected"' : '';?>><?= $value['name'] ?></option>
                                                    <?php } ?>
                                        </select>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                       <?php
                                        if($res[0]['type']=='Credit Purchase' || $res[0]['type']=='Credit Sales'){
                                            ?>
                                        <div class="form-group" id="old_touchname">
                                            <label for="exampleInputEmail1">Touch</label> 
                                            <input type="number" class="form-control" name="touch" value="<?php echo $res[0]['touch'] ?>" readonly />
                                        </div>
                                        <?php } ?>
                                </div>
                            </div>
                            <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group" id="subcategories" style="display:none">
                                            <label for="exampleInputEmail1">Subcategory</label> <i class="text-danger asterik">*</i>
                                            <select id='subcategory_id' name="subcategory_id" class='form-control'>
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
                                    <div class="col-md-4">
                                        <div class="form-group" id="touchname" style="display:none">
                                            <label for="exampleInputEmail1">Touch</label><i class="text-danger asterik">*</i>
                                            <input type="number" class="form-control" name="touch" id="touch" readonly />
                                        </div>
                                    </div>
                            </div>
                            <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Weight</label> 
                                            <input type="number" class="form-control" name="weight" value="<?php echo $res[0]['weight'] ?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Stone Weight</label> 
                                            <input type="number" class="form-control" name="stone_weight" value="<?php echo $res[0]['stone_weight'] ?>"  />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Wastage</label>
                                            <input type="number" class="form-control" name="wastage" value="<?php echo $res[0]['wastage'] ?>" />
                                        </div>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Purity(gram)</label>
                                        <input type="number" class="form-control" value="<?php echo $res[0]['purity'] ?>" name="purity" id="purity" readonly />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Rate</label>
                                        <input type="number" class="form-control" name="rate" value="<?php echo $res[0]['rate'] ?>" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"> GST</label> 
                                        <input type="number" class="form-control" name="gst" value="<?php echo $res[0]['gst'] ?>" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Amount</label> 
                                        <input type="number" class="form-control" name="amount" value="<?php echo $res[0]['amount'] ?>" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">MC</label> 
                                        <input type="number" class="form-control" name="mc" value="<?php echo $res[0]['mc'] ?>" />
                                    </div>
                                </div>
                            </div>
	
                            </div><!-- /.box-body -->
                       
					<div class="box-footer">
						<button type="submit" class="btn btn-primary" name="btnEdit">Update</button>
					
					</div>
				</form>
			</div><!-- /.box -->
		</div>
	</div>
</section>

<div class="separator"> </div>
<script>
    $("#type").change(function() {
        type = $("#type").val();
        if(type == "Credit Purchase"){
            $("#subcategories").show();
            $("#touchname").show();
            $("#old_subcategories").hide();
            $("#old_touchname").hide();

        }
        if(type == "Credit Sales"){
            $("#subcategories").show();
            $("#touchname").show();
            $("#old_subcategories").hide();
            $("#old_touchname").hide();
        }
        if(type == "Metal Issue"){
            $("#subcategories").hide();
            $("#touchname").hide();
            $("#old_subcategories").hide();
            $("#old_touchname").hide();

        }
        if(type == "Metal Receipt"){
            $("#subcategories").hide();
            $("#touchname").hide();
            $("#old_subcategories").hide();
            $("#old_touchname").hide();
        } 
          if(type == "Cash Credit"){
            $("#subcategories").hide();
            $("#touchname").hide();
            $("#old_subcategories").hide();
            $("#old_touchname").hide();

        }
        if(type == "Cash Debit"){
            $("#subcategories").hide();
            $("#touchname").hide();
            $("#old_subcategories").hide();
            $("#old_touchname").hide();
        }
        if(type == "none"){
            $("#subcategories").hide();
            $("#touchname").hide();
            $("#old_subcategories").hide();
            $("#old_touchname").hide();
        }
    });
</script>
<?php $db->disconnect(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<!-- <script>
    $(document).ready(function () {
        $('#name').select2({
        width: 'element',
        placeholder: 'Type in name to search',

    });
    });

</script> -->