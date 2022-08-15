<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
// session_start();
$daily_transaction_id = $_GET['id'];
?>
<section class="content-header">
    <h1>View Daily Transaction</h1>
    <?php echo isset($error['add_menu']) ? $error['add_menu'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
<div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Daily Transaction Details</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                    <table class="table table-bordered">
                        <?php
                        $sql = "SELECT * FROM daily_transaction WHERE id = $daily_transaction_id";
                        $db->sql($sql);
                        $res = $db->getResult();
                        $num = $db->numRows();
                        if($num >= 1){
                            $sql = "SELECT *,daily_transaction.id AS id FROM daily_transaction,dealers WHERE dealers.id=daily_transaction.dealer_id AND daily_transaction.id = $daily_transaction_id";
                            $db->sql($sql);
                            $res = $db->getResult();
                            ?>
                            <tr>
                                <th style="width: 200px">ID</th>
                                <td><?php echo $res[0]['id'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Name</th>
                                <td><?php echo $res[0]['name'] ?></td>
                            </tr>
                            <?php
                            $sql = "SELECT * FROM daily_transaction WHERE dealer_id=" . $res[0]['dealer_id'] . "";
                            $db->sql($sql);
                            $resad = $db->getResult();
                            $index = 1;
                            foreach ($resad as $row) {
                            ?>
                            <tr>
                               <th style="width:200px;color:blue;">Transaction  <?php echo $index ?></th>
                            </tr>
                            <tr>
                                <td><?php echo '<b>Date :</b> '.$row['date'].'<br>'.'<b>Type :</b> '.$row['type'].'<br>'.'<b>Category :</b> '.$row['category']; ?></td>
                                <td><span style="font-size:20px;color:red;">Details:</span> <br><?php echo '<b>Weight :</b> '.$row['type'].'<br>'.'<b>Stone Weight :</b> '.$row['stone_weight'].'<br>'.'<b>Wastage :</b> '.$row['wastage'].'<br>'.'<b>Touch :</b> '.$row['touch']; ?></td>
                                <td><span style="font-size:20px;color:#eb34d2;">Others: </span> <br><?php echo '<b>Rate :</b> '.$row['rate'].'<br>'.'<b>GST :</b> '.$row['gst'].'<br>'.'<b>Amount :</b> '.$row['amount']; ?></td>
                            </tr>
                            <?php
                            $index++;
                            }
                            ?>
                        <?php
                        }
                        ?>
                
    
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <a href="dailytransactions.php" class="btn btn-sm btn-default btn-flat pull-left">Back</a>
                    </div>
                </div><!-- /.box -->
            </div>
        </div>
</section>
<div class="separator"> </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
   
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });
    
</script>

