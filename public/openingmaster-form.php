<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

$res = $db->getResult();

$sql_query = "SELECT * FROM openingmaster WHERE id = 1";
$db->sql($sql_query);
$res= $db->getResult();

if (isset($_POST['btnAdd'])) {
        $error = array();
        $kdm = $db->escapeString($fn->xss_clean($_POST['kdm']));
        $metal = $db->escapeString($fn->xss_clean($_POST['metal']));
        $katcha = $db->escapeString($fn->xss_clean($_POST['katcha']));
        $cash_hand = $db->escapeString($fn->xss_clean($_POST['cash_hand']));
        
        if (empty($kdm)) {
            $error['kdm'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($metal)) {
            $error['metal'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($katcha)) {
            $error['katcha'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($cash_hand)) {
            $error['cash_hand'] = " <span class='label label-danger'>Required!</span>";
        }
       

        if ( !empty($kdm) && !empty($metal) && !empty($katcha) && !empty($cash_hand))
        {
            $sql = 'UPDATE openingmaster SET kdm="'.$kdm.'",metal="'.$metal.'",katcha="'.$katcha.'",cash_hand="'.$cash_hand.'",`update`=1 WHERE id=1';
               // $sql = "UPDATE openingmaster SET update = 1 WHERE id=1";
                $db->sql($sql);
                $openingmaster_result = $db->getResult();
                if (!empty($openingmaster_result)) {
                    $openingmaster_result = 0;
                } else {
                    $openingmaster_result = 1;
                }
                if ($openingmaster_result == 1) {
                    $error['add_menu'] = "<section class='content-header'>
                                                     <span class='label label-success'>Opening Master Added Successfully</span>
                                                     <h4><small><a  href='openingmaster.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Opening Master</a></small></h4>
                                                      </section>";
                } else {
                    $error['add_menu'] = " <span class='label label-danger'>Failed</span>";
                }
        }
    }
?>
<section class="content-header">
    <h1>Add Opening Master</h1>
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
                    <h3 class="box-title">Add Opening Master</h3>
                </div>
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form id='add_opening_master_form'  method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">916 KDM</label> <i class="text-danger asterik">*</i><?php echo isset($error['kdm']) ? $error['kdm'] : ''; ?>
                                    <input type="number" class="form-control" name="kdm" value="<?php echo $res[0]['kdm'] ?>">
                                </div>
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Metal</label> <i class="text-danger asterik">*</i><?php echo isset($error['metal']) ? $error['metal'] : ''; ?>
                                    <input type="number" class="form-control" name="metal" value="<?php echo $res[0]['metal'] ?>">
                                    
                                </div>
                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Katcha</label> <i class="text-danger asterik">*</i><?php echo isset($error['katcha']) ? $error['katcha'] : ''; ?>
                                    <input type="number" class="form-control" name="katcha" value="<?php echo $res[0]['katcha'] ?>">
                                </div>
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Cash on Hand</label> <i class="text-danger asterik">*</i><?php echo isset($error['cash_hand']) ? $error['cash_hand'] : ''; ?>
                                    <input type="number" class="form-control" name="cash_hand" value="<?php echo $res[0]['cash_hand'] ?>">
                                    
                                </div>
                            </div>

                        </div>
                        <br>
                        
                        </div>
                        <?php
                        if($res[0]['update']==0){
                            ?>
                            <div class="box-footer">
                                <button type="submit" name="btnAdd" class="btn btn-primary">Submit</button>
                            </div>
                            <?php
                        }
                        ?>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<div class="separator"> </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
    $('#add_opening_master_form').validate({

        ignore: [],
        debug: false,
        rules: {
            kdm: "required",
            metal: "required",
            katcha: "required",
            cash_hand: "required",
         }
    });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });

</script>
