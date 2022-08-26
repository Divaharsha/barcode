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

    if ($permissions['dailytransaction']['update'] == 1) {
        $name = $db->escapeString($fn->xss_clean($_POST['name']));
        $error = array();
    
        
        if (empty($name)) {
            $error['name'] = " <span class='label label-danger'>Required!</span>";
        }
    
            
    
        if ( !empty($name))
        {
            $date = $db->escapeString($fn->xss_clean($_POST['date']));
            $type = $db->escapeString($fn->xss_clean($_POST['type']));
            $category = $db->escapeString($fn->xss_clean($_POST['category'])); 
            $weight = $db->escapeString($fn->xss_clean($_POST['weight']));
            $stone_weight = $db->escapeString($fn->xss_clean($_POST['stone_weight']));
            $wastage = $db->escapeString($fn->xss_clean($_POST['wastage']));
            $touch = $db->escapeString($fn->xss_clean($_POST['touch']));
            $rate = $db->escapeString($fn->xss_clean($_POST['rate']));
            $gst = $db->escapeString($fn->xss_clean($_POST['gst']));
            $amount = $db->escapeString($fn->xss_clean($_POST['amount']));
            $mc = $db->escapeString($fn->xss_clean($_POST['mc']));
            $purity = $db->escapeString($fn->xss_clean($_POST['purity']));
            $sql = "UPDATE `daily_transaction` SET `date` = '$date', `type` = '$type', `category` = '$category', `weight` = '$weight', `stone_weight` = '$stone_weight', `wastage` = '$wastage', `touch` = '$touch', `rate` = '$rate', `gst` = '$gst', `amount` = '$amount', `mc` = '$mc', `purity` = '$purity' WHERE `daily_transaction`.`id` = $ID";
            $db->sql($sql);
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

} 


// create array variable to store previous data
$data = array();


$sql_query = "SELECT * FROM daily_transaction dt,goldsmith_master gm WHERE dt.id = '$ID'";
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
        <?php if ($permissions['dailytransaction']['update'] == 0) { ?>
                <div class="alert alert-danger">You have no permission to update daily transaction.</div>
            <?php } ?>
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
										<input type="text" class="form-control" name="name" value="<?php echo $res[0]['name'] ?>" readonly>
									 </div>
								</div>
						   </div>
						   <hr>
                           <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group packate_div">
                                                    <label for="exampleInputEmail1"> Date</label> <i class="text-danger asterik">*</i>
                                                    <input type="date" class="form-control" name="date" value="<?php echo $res[0]['date'] ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group packate_div">
                                                    <label for="exampleInputEmail1">Type</label> 
                                                    <select id='type' name="type" class='form-control' required>
                                                    <option value="">Select</option>
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
                                            <div class="col-md-3">
                                                <div class="form-group packate_div">
                                                    <label for="exampleInputEmail1">Category</label> 
                                                    <select id='category' name="category" class='form-control' required>
                                                                <?php
                                                                $sql = "SELECT * FROM `brand`";
                                                                $db->sql($sql);

                                                                $result = $db->getResult();
                                                                foreach ($result as $value) {
                                                                ?>
                                                                    <option value='<?= $value['category'] ?>' <?=$res[0]['category'] == $value['category'] ? ' selected="selected"' : '';?>><?= $value['category'] ?></option>
                                                                <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group packate_div">
                                                        <label for="exampleInputEmail1">Weight</label> 
                                                        <input type="number" class="form-control" name="weight" value="<?php echo $res[0]['weight'] ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group packate_div">
                                                        <label for="exampleInputEmail1">Stone Weight</label> 
                                                        <input type="number" class="form-control" name="stone_weight" value="<?php echo $res[0]['stone_weight'] ?>"  />
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group packate_div">
                                                        <label for="exampleInputEmail1">Wastage</label>
                                                        <input type="number" class="form-control" name="wastage" value="<?php echo $res[0]['wastage'] ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group packate_div">
                                                        <label for="exampleInputEmail1">Touch</label> 
                                                        <input type="number" class="form-control" name="touch" value="<?php echo $res[0]['touch'] ?>"  />
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group packate_div">
                                                    <label for="exampleInputEmail1">Purity(gram)</label>
                                                    <input type="number" class="form-control" value="<?php echo $res[0]['purity'] ?>" name="purity" id="purity" readonly />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-group packate_div">
                                                            <label for="exampleInputEmail1">Rate</label>
                                                            <input type="number" class="form-control" name="rate" value="<?php echo $res[0]['rate'] ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group packate_div">
                                                            <label for="exampleInputEmail1"> GST</label> 
                                                            <input type="number" class="form-control" name="gst" value="<?php echo $res[0]['gst'] ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group packate_div">
                                                            <label for="exampleInputEmail1">Amount</label> 
                                                            <input type="number" class="form-control" name="amount" value="<?php echo $row['amount'] ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group packate_div">
                                                            <label for="exampleInputEmail1">MC</label> 
                                                            <input type="number" class="form-control" name="mc" value="<?php echo $row['mc'] ?>" />
                                                        </div>
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
<?php $db->disconnect(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        var max_fields = 7;
        var wrapper = $("#packate_div");
        var add_button = $("#add_packate_variation");

        var x = 1;
        $(add_button).click(function (e) {
            e.preventDefault();
            if (x < max_fields) {
                x++;
				$(wrapper).append('<div class="row">' + '<div class="row"><div class="col-md-3"><div class="form-group"><label for="date">Date</label>' + '<input type="date" class="form-control" name="insert_date[]" ></div></div>' +'<div class="col-md-3"><div class="form-group"><label for="type">Type</label>' + '<select id=type name="insert_type[]" class=form-control><option value="none">Select</option>'+'<?php
                                                            $sql = "SELECT * FROM `types`";
                                                            $db->sql($sql);
                                                            $result = $db->getResult();
                                                            foreach ($result as $value) {
                                                                echo '<option value="' . $value['id'] . '">' . $value['type'] . '</option>';
                                                            }
                                                            ?>'+
                                                            '</select></div></div>'+ '<div class="col-md-3"><div class="form-group"><label for="type">Category</label>' + '<select id=category name="insert_category[]" class=form-control>'+'<?php
                                                            $sql = "SELECT * FROM `brand`";
                                                            $db->sql($sql);
                                                            $result = $db->getResult();
                                                            foreach ($result as $value) {
                                                                echo '<option value="' . $value['category'] . '">' . $value['category'] . '</option>';
                                                            }
                                                            ?>'+'</select></div></div></div>' +'<div class="col-md-2"><div class="form-group"><label for="weight">Weight</label>' + '<input type="number" class="form-control" name="insert_weight[]"></div></div>'+'<div class="col-md-2"><div class="form-group"><label for="stone_weight">Stone Weight</label>' + '<input type="number" class="form-control" name="insert_stone_weight[]"></div></div>'+'<div class="col-md-2"><div class="form-group"><label for="wastage">Wastage</label>' + '<input type="number" class="form-control" name="insert_wastage[]" ></div></div>'+'<div class="col-md-2"><div class="form-group"><label for="touch">Touch</label>' + '<input type="number" class="form-control" name="insert_touch[]"></div></div>'+'<div class="col-md-2"><div class="form-group"><label for="rate">Rate</label>' + '<input type="number" class="form-control" name="insert_rate[]" ></div></div>'+'<div class="col-md-2"><div class="form-group"><label for="gst">GST</label>' + '<input type="number" class="form-control" name="insert_gst[]"  ></div></div>'+'<div class="col-md-2"><div class="form-group"><label for="amount">Amount</label>' + '<input type="number" class="form-control" name="insert_amount[]" ></div></div>'+'<div class="col-md-2"><div class="form-group"><label for="mc">MC</label>' + '<input type="number" class="form-control" name="insert_mc[]"></div></div>' + '<div class="col-md-1" style="display: grid;"><label>Remove</label><a class="remove text-danger" style="cursor: pointer;"><i class="fa fa-times fa-2x"></i></a></div>'+'</div><hr>');
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
<script>
    $(document).on('click', '.remove_variation', function() {
        if ($(this).data('id') == 'data_delete') {
            if (confirm('Are you sure? Want to delete this row')) {
                var id = $(this).closest('div.row').find("input[id='daily_transaction_id']").val();
                $.ajax({
                    url: 'public/db-operation.php',
                    type: "post",
                    data: 'id=' + id + '&delete_variant=1',
                    success: function(result) {
                        if (result) {
                            location.reload();
                        } else {
                            alert("Variant not deleted!");
                        }
                    }
                });
            }
        } else {
            $(this).closest('.row').remove();
        }
    });
</script>

