<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

if (isset($_GET['id'])) {
    $ID = $db->escapeString($fn->xss_clean($_GET['id']));
} else {
    // $ID = "";
    return false;
    exit(0);
}
$category_data = array();
$sql = "select id,name from categories order by id asc";
$db->sql($sql);
$category_data = $db->getResult();
$sql = "select * from subcategories";
$db->sql($sql);
$subcategory = $db->getResult();

if (isset($_POST['btnUpdate'])) {
    if ($permissions['goldsmithmaster']['update'] == 1) {
        $error = array();
        $name = $db->escapeString($fn->xss_clean($_POST['name']));
        $goldsmith_type = $db->escapeString($fn->xss_clean($_POST['goldsmith_type']));
        $mobile = $db->escapeString($fn->xss_clean($_POST['mobile']));
        $digital_signature_number = $db->escapeString($fn->xss_clean($_POST['digital_signature_number']));
        $gst_number =$db->escapeString($fn->xss_clean($_POST['gst_number']));
        $pan_number = $db->escapeString($fn->xss_clean($_POST['pan_number']));
        $email = $db->escapeString($fn->xss_clean($_POST['email']));
        $address=$db->escapeString($fn->xss_clean($_POST['address']));
        $place=$db->escapeString($fn->xss_clean($_POST['place']));
        $open_cash_debit = (isset($_POST['open_cash_debit']) && !empty($_POST['open_cash_debit'])) ? $db->escapeString($fn->xss_clean($_POST['open_cash_debit'])) : "0";
        $open_cash_credit = (isset($_POST['open_cash_credit']) && !empty($_POST['open_cash_credit'])) ? $db->escapeString($fn->xss_clean($_POST['open_cash_credit'])) : "0";
        $open_pure_debit = (isset($_POST['open_pure_debit']) && !empty($_POST['open_pure_debit'])) ? $db->escapeString($fn->xss_clean($_POST['open_pure_debit'])) : "0";
        $open_pure_credit = (isset($_POST['open_pure_credit']) && !empty($_POST['open_pure_credit'])) ? $db->escapeString($fn->xss_clean($_POST['open_pure_credit'])) : "0";        $open_pure_credit=$db->escapeString($fn->xss_clean($_POST['open_pure_credit']));

        
        if (empty($name)) {
            $error['name'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($goldsmith_type)) {
            $error['goldsmith_type'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($mobile)) {
            $error['mobile'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($digital_signature_number)) {
            $error['digital_signature_number'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($gst_number)) {
            $error['gst_number'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($pan_number)) {
            $error['pan_number'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($email)) {
            $error['email'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($address)) {
            $error['address'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($place)) {
            $error['place'] = " <span class='label label-danger'>Required!</span>";
        }
   

        if ( !empty($name) && !empty($goldsmith_type) && !empty($mobile) && !empty($digital_signature_number) && !empty($gst_number) && !empty($pan_number) && !empty($email) && !empty($address) && !empty($place))
        {
                $sql = "UPDATE goldsmith_master SET name='$name',goldsmith_type='$goldsmith_type',mobile='$mobile',digital_signature_number='$digital_signature_number',gst_number='$gst_number',pan_number='$pan_number',open_cash_debit='$open_cash_debit',open_cash_credit='$open_cash_credit',open_pure_debit='$open_pure_debit',open_pure_credit='$open_pure_credit',email='$email',address='$address',place='$place' WHERE id='$ID'";
                $db->sql($sql);
                $goldsmithmaster_result = $db->getResult();
                if (!empty($goldsmithmaster_result)) {
                    $goldsmithmaster_result = 0;
                } else {
                    $goldsmithmaster_result = 1;
                }
                if ($goldsmithmaster_result == 1) {
                    
				for ($i = 0; $i < count($_POST['subcategory_id']); $i++) {
					$goldsmith_master_id = $db->escapeString(($_POST['goldsmith_master_variant_id'][$i]));
					$subcategory_id = $db->escapeString(($_POST['subcategory_id'][$i]));
                    $touch = (isset($_POST['touch'][$i]) && !empty($_POST['touch'][$i])) ? $db->escapeString($fn->xss_clean($_POST['touch'][$i])) : "0";
					$sql = "UPDATE goldsmith_master_variant SET subcategory_id='$subcategory_id',touch='$touch' WHERE id =$goldsmith_master_id";
					$db->sql($sql);

				}
				if (
					isset($_POST['insert_subcategory_id']) && isset($_POST['insert_touch'])
				) {
					for ($i = 0; $i < count($_POST['insert_subcategory_id']); $i++) {
                        $subcategory_id = $db->escapeString(($_POST['insert_subcategory_id'][$i]));
                        $touch = (isset($_POST['insert_touch'][$i]) && !empty($_POST['insert_touch'][$i])) ? $db->escapeString($fn->xss_clean($_POST['insert_touch'][$i])) : "0";
						if (!empty($subcategory_id) && !empty($touch)) {
							$sql = "INSERT INTO goldsmith_master_variant (goldsmith_master_id,subcategory_id,touch) VALUES('$ID','$subcategory_id','$touch')";
							$db->sql($sql);

						}
					}
				}
                    $error['add_menu'] = "<section class='content-header'>
                                                    <span class='label label-success'>Dealer Goldsmith Master Updated Successfully</span>
                                                    <h4><small><a  href='goldsmithmasters.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Goldsmith Master</a></small></h4>
                                                     </section>";
                } else {
                    $error['add_menu'] = " <span class='label label-danger'>Failed</span>";
                }

        }
    }
    
}

$data = array();

$sql_query = "SELECT * FROM `goldsmith_master` WHERE id = '$ID'";
$db->sql($sql_query);
$res = $db->getResult();
foreach ($res as $row)
$data = $row;

$sql_query = "SELECT * FROM goldsmith_master_variant WHERE goldsmith_master_id =" . $ID;
$db->sql($sql_query);
$resslot = $db->getResult();

?>
<section class="content-header">
    <h1>Edit Dealer Goldsmith Master</h1>
    <?php echo isset($error['add_menu']) ? $error['add_menu'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
        <?php if ($permissions['goldsmithmaster']['update'] == 0) { ?>
                <div class="alert alert-danger">You have no permission to update goldsmith master.</div>
            <?php } ?>
            <div class="box box-primary">
                <div class="box-header with-border">
                </div>
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form id='edit_goldsmith_master_form' method="post" enctype="multipart/form-data">
                    <div class="box-body">
                            <div class="row">
                                    <div class="form-group">
                                        <div class='col-md-4'>
                                            <label for="exampleInputEmail1"> Name</label> <i class="text-danger asterik">*</i><?php echo isset($error['name']) ? $error['name'] : ''; ?>
                                            <input type="text" class="form-control" name="name" value="<?php echo $data['name']?>">
                                        </div>
                                        <div class='col-md-4'>
                                                <label for="">Goldsmith Type</label> <i class="text-danger asterik">*</i> <?php echo isset($error['goldsmith_type']) ? $error['goldsmith_type'] : ''; ?><br>
                                                <select id="goldsmith_type" name="goldsmith_type" class="form-control">
                                                    <option value="Both"<?=$data['goldsmith_type'] == 'Both' ? ' selected="selected"' : '';?>>Both</option>
                                                    <option value="Seller"<?=$data['goldsmith_type'] == 'Seller' ? ' selected="selected"' : '';?> >Seller</option>
                                                    <option value="Buyer" <?=$data['goldsmith_type'] == 'Buyer' ? ' selected="selected"' : '';?>>Buyer</option>
                                                </select>
                                        </div>
                                        <div class='col-md-4'>
                                            <label for="exampleInputEmail1">Payment Mobile Number</label> <i class="text-danger asterik">*</i><?php echo isset($error['mobile']) ? $error['mobile'] : ''; ?>
                                            <input type="number" class="form-control" name="mobile" value="<?php echo $data['mobile']?>">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                         <div class='col-md-4'>
                                            <label for="exampleInputEmail1">Digital Signature Number</label> <i class="text-danger asterik">*</i><?php echo isset($error['digital_signature_number']) ? $error['digital_signature_number'] : ''; ?>
                                            <input type="number" class="form-control" name="digital_signature_number" value="<?php echo $data['digital_signature_number']?>">
                                        </div>
                                        <div class='col-md-4'>
                                            <label for="exampleInputEmail1">GST Number</label> <i class="text-danger asterik">*</i><?php echo isset($error['gst_number']) ? $error['gst_number'] : ''; ?>
                                            <input type="text" class="form-control" name="gst_number" value="<?php echo $data['gst_number']?>">
                                        </div>
                                        <div class='col-md-4'>
                                            <label for="exampleInputEmail1">PAN Number</label> <i class="text-danger asterik">*</i><?php echo isset($error['pan_number']) ? $error['pan_number'] : ''; ?>
                                            <input type="text" class="form-control" name="pan_number" value="<?php echo $data['pan_number']?>">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div id="variations">
                                    <?php
                                    $i=0;
                                    foreach ($resslot as $row) {
                                        ?>
                                    <div id="packate_div">
                                        <div class="row">
                                        <input type="hidden" class="form-control" name="goldsmith_master_variant_id[]" id="goldsmith_master_variant_id" value='<?= $row['id']; ?>' />
                                            <div class="col-md-6">
                                                <div class="form-group packate_div">
                                                    <label for="exampleInputEmail1">Model</label> <i class="text-danger asterik">*</i>
                                                    <select id='subcategory_id' name="subcategory_id[]" class='form-control' required>
                                                        <option value="">Select</option>
                                                                <?php
                                                                $sql = "SELECT * FROM `subcategories`";
                                                                $db->sql($sql);
                                                                $result = $db->getResult();
                                                                foreach ($result as $value) {
                                                                ?>
                                                                <option value='<?= $value['id'] ?>' <?=$row['subcategory_id'] == $value['id'] ? ' selected="selected"' : '';?>><?= $value['name'] ?></option>
                                                                <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group packate_div">
                                                    <label for="exampleInputEmail1"> Touch</label> <i class="text-danger asterik">*</i>
                                                    <input type="text" class="form-control" name="touch[]" value="<?php echo $row['touch'] ?>" required />
                                                </div>
                                            </div>

                                            <?php if ($i == 0) { ?>
                                                    <div class='col-md-1'>
                                                        <label>Tab</label>
                                                        <a class="add_packate_variation" title="Add variation" style="cursor: pointer;color:white;"><button class="btn btn-warning">Add more</button></a>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="col-md-1" style="display: grid;">
                                                        <label>Tab</label>
                                                        <a class="remove_variation text-danger" data-id="data_delete" title="Remove variation of panchangam" style="cursor: pointer;color:white;"><button class="btn btn-danger">Remove</button></a>
                                                    </div>
                                                <?php } ?>
                                        </div>
                                    </div>
                                    <?php $i++; } ?> 
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <div class='col-md-3'>
                                            <label for="exampleInputEmail1">Open Cash Debit</label> <i class="text-danger asterik">*</i><?php echo isset($error['open_cash_debit']) ? $error['open_cash_debit'] : ''; ?>
                                            <input type="number" class="form-control" name="open_cash_debit" value="<?php echo $data['open_pure_debit']?>">
                                        </div>
                                        <div class='col-md-3'>
                                            <label for="exampleInputEmail1">Open Cash credit</label> <i class="text-danger asterik">*</i><?php echo isset($error['open_cash_credit']) ? $error['open_cash_credit'] : ''; ?>
                                            <input type="number" class="form-control" name="open_cash_credit" value="<?php echo $data['open_cash_credit']?>">
                                        </div>
                                        <div class='col-md-3'>
                                            <label for="exampleInputEmail1">Open Pure Debit</label> <i class="text-danger asterik">*</i><?php echo isset($error['open_pure_debit']) ? $error['open_pure_debit'] : ''; ?>
                                            <input type="number" class="form-control" name="open_pure_debit" value="<?php echo $data['open_pure_debit']?>">
                                        </div>
                                        <div class='col-md-3'>
                                            <label for="exampleInputEmail1">Open Pure Credit</label> <i class="text-danger asterik">*</i><?php echo isset($error['open_pure_credit']) ? $error['open_pure_credit'] : ''; ?>
                                            <input type="number" class="form-control" name="open_pure_credit" value="<?php echo $data['open_pure_credit']?>">
                                        </div>
                                    </div>    
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <div class='col-md-4'>
                                            <label for="exampleInputEmail1">Email Id</label> <i class="text-danger asterik">*</i><?php echo isset($error['email']) ? $error['email'] : ''; ?>
                                            <input type="email" class="form-control" name="email" value="<?php echo $data['email']?>">
                                        </div>
                                        <div class='col-md-4'>
                                            <label for="exampleInputEmail1">Address</label> <i class="text-danger asterik">*</i><?php echo isset($error['address']) ? $error['address'] : ''; ?>
                                            <input type="text" class="form-control" name="address" value="<?php echo $data['address']?>">
                                        </div>
                                        <div class='col-md-4'>
                                            <label for="exampleInputEmail1">Place</label> <i class="text-danger asterik">*</i><?php echo isset($error['place']) ? $error['place'] : ''; ?>
                                            <input type="text" class="form-control" name="place" value="<?php echo $data['place']?>">
                                        </div>
                                    </div>    
                                </div>

                        

                    </div><!-- /.box-body -->
                    
                    <div class="box-footer">
                        <input type="submit" class="btn-primary btn" value="Update" name="btnUpdate" />&nbsp;
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<div class="separator"> </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        var max_fields = 7;
        var wrapper = $("#packate_div");
        var add_button = $(".add_packate_variation");

        var x = 1;
        $(add_button).click(function (e) {
            e.preventDefault();
            if (x < max_fields) {
                x++;
				$(wrapper).append('<div class="row"><div class="col-md-6"><div class="form-group"><label for="subcategory_id">Subcategory</label>' + '<select id=subcategory_id name="insert_subcategory_id[]" class="form-control" required><option value="">Select</option>'+
																'<?php
                                                                $sql = "SELECT * FROM `subcategories`";
                                                                $db->sql($sql);
                                                                $resslot = $db->getResult();
																foreach ($resslot as  $row) {
																	echo "<option value=" . $row['id'] . ">" . $row['name'] . "</option>";
																}
																?>' 
															+'</select></div></div>'+'<div class="col-md-4"><div class="form-group"><label for="touch">Touch</label>'+'<input type="text" class="form-control" name="insert_touch[]" required /></div></div>'+'<div class="col-md-1" style="display:grid;"><label>Tab</label><a class="remove text-danger" style="cursor:pointer;color:white;"><button class="btn btn-danger">Remove</button></a></div>'+'</div>');
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
                var id = $(this).closest('div.row').find("input[id='goldsmith_master_variant_id']").val();
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