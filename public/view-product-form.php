<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
// session_start();
$product_id = $_GET['id'];
$sql = "SELECT *,products.id AS id,categories.name AS category_name,subcategories.name AS subcategory_name,goldsmith_master.name AS goldsmith_name FROM products,subcategories,goldsmith_master,categories WHERE products.subcategory_id=subcategories.id AND subcategories.category_id=categories.id AND products.goldsmith_id=goldsmith_master.id  AND products.id = $product_id";
$db->sql($sql);
$res = $db->getResult();
?>
<section class="content-header">
    <h1>View Product Details</h1>
    <?php echo isset($error['add_menu']) ? $error['add_menu'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
    <div class="row">
                <div class="box">
                    <div class="box-header clearfix">
                        <a href="products.php" class="btn btn-md btn-info btn-flat pull-left">Back</a>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="col-md-6">
                           <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px">ID</th>
                                    <td><?php echo $res[0]['id'] ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 200px">Category</th>
                                    <td><?php echo $res[0]['category_name'] ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 200px">Sub-category</th>
                                    <td><?php echo $res[0]['subcategory_name'] ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 200px">HUID Number</th>
                                    <td><?php echo $res[0]['huid_number'] ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 200px">Gross Weight</th>
                                    <td><?php echo $res[0]['gross_weight'] ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 200px">Size</th>
                                    <td><?php echo $res[0]['size'] ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 200px">Stone Weight</th>
                                    <td><?php echo $res[0]['stone_weight'] ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 200px">Net Weight</th>
                                    <td><?php echo $res[0]['net_weight'] ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 200px">Wastage</th>
                                    <td><?php echo $res[0]['wastage'] ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 200px">Cover Weight</th>
                                    <td><?php echo $res[0]['cover_weight'] ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 200px">Tag Weight</th>
                                    <td><?php echo $res[0]['tag_weight'] ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 200px">Status</th>
                                    <td>
                                        <?php 
                                        if($res[0]['status']==0){ ?>
                                        <p class="text text-danger" style="font-weight:bold;">Not-Approved</p>
                                        <?php
                                        }
                                        else if($res[0]['status']==1){?>
                                        <p class="text text-success" style="font-weight:bold;">Approved</p>
                                        <?php
                                        }
                                        else{
                                            ?>
                                    <?php
                                        }
                                        ?>

                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                           <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px">Goldsmith Name</th>
                                    <td><?php echo $res[0]['goldsmith_name'] ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 200px">Mobile Number</th>
                                    <td><?php echo $res[0]['mobile'] ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 200px">Email</th>
                                    <td><?php echo $res[0]['email'] ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 200px">Address</th>
                                    <td><?php echo $res[0]['address'] ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 200px">Place</th>
                                    <td><?php echo $res[0]['place'] ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 200px">Open Cash Debit</th>
                                    <td><?php echo $res[0]['open_cash_debit'] ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 200px">Open Cash Credit</th>
                                    <td><?php echo $res[0]['open_cash_credit'] ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 200px">Open Pure Debit</th>
                                    <td><?php echo $res[0]['open_pure_debit'] ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 200px">Open Pure Credit</th>
                                    <td><?php echo $res[0]['open_pure_credit'] ?></td>
                                </tr>
                            </table>
                         </div>
                       
                    </div><!-- /.box-body -->

            </div><!--box--->
    </div>
</section>
<div class="separator"> </div>

