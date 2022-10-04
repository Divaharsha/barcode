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
<style>
    .box{
        background-color:#f0dec8;
    }
    .box-header{
        background-color:#d97406;
    }
    .box-header h5{
        color:white;
        font-weight:900;
    }
    .invoice{
        background-color:none;
    }
    h4{
        font-weight:600;
        color:black;
    }
    table,th{
        border:3px solid black!important;
        text-align:center;
    }
    td{
        text-align:center;
        border:2px solid black;

    }
    #bottom{
        margin-right:50px;
    }
   
</style>
<section class="content-header">
    <h1>Invoice</h1>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
        <div class="row">
            <div class="col-sm-12 col-md-10">
                <div class="box">
                    <div class="box-header clearfix">
                        <h5>Goldplus</h5>
                    </div>
                    <h4 class="text-center">Invoice No: 546238</h4><br>

                    <div class="col-xs-4">
                        <h4>From:</h4>
                        <address>
                            <strong><?= $settings['app_name']; ?></strong><br>
                            East Street, IOB Bank(opposite),<br>
                            Madurai,Tamilnadu,<br>
                            India <br>
                            <b>STD:</b>+0431 45672 <br>
                            <b>FAX:</b> (503)767

                        </address>
                    </div><!-- /.col -->
                    <div class="col-xs-4">
                        <h4>Buyer:</h4><br>
                        <address>
                            AK Thangamaligai,<br>
                            Tamilnadu,
                            India <br>
                            <b>STD:</b>+04536 71818<br>
                            <b>Mobile No:</b>+91 778493994
                        </address>
                    </div><!-- /.col -->
                    <div class="col-xs-4 text-center">
                        <address>
                            <br>
                            <br>
                            <br>
                            DATE : 22-10-2022<br>
                            TIME : 10:20 AM
                        </address>
                    </div><!-- /.col -->
                            

                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table">
                                    <tr>
                                        <th style="width:100px">QTY</th>
                                        <th style="width:300px">Description</th>
                                        <th style="width: 200px">HSN/SAC</th>
                                        <th style="width: 200px">Rate</th>
                                        <th style="width:50px">Per</th>
                                        <th style="width:250px">Amount</th>
                                      
                                    </tr>
                                    <tr style="height:200px">
                                         <td>6</td>
                                         <td>RINGS</td>
                                         <td>7113</td>
                                         <td>5017.48</td>
                                         <td>gm</td>
                                         <td><span class="col-xs-1">₹</span>88,157.12</td>
                                    </tr>
                                    <tr class="noBorder">
                                         <td></td>
                                         <td></td>
                                         <td></td>
                                         <td>50</td>
                                         <td></td>
                                         <td><span class="col-xs-1">₹</span>  300.00</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div id="bottom" class="text-right">
                           <b style="margin-right:20px;"> CGST 1.5%</b><span  style="margin-right:50px;">₹ </span>1308.05 <br> 
                           <b style="margin-right:17px;"> GST  1.5%</b> <span  style="margin-right:50px;">₹ </span>1308.05 <br>
                           <b style="margin-right:28px;"> CGST   9%</b><span  style="margin-right:65px;">₹ </span>27.00 <br>
                           <b style="margin-right:25px;"> GST    9%</b><span  style="margin-right:65px;">₹ </span>27.00 <br>
                           <b style="margin-right:40px;"> Subtotal</b><span  style="margin-right:40px;">₹ </span> 91,127.22 <br>
                           <b style="margin-right:20px;"> Round off</b><span  style="margin-right:75px;">₹ </span> 0.78 <br>
                        </div>
                        <h4 class="text-center" style="border-top:2px solid black;border-bottom:2px solid black;float:right;background-color:#d97406;padding:6px;">TOTAL =<span style="margin-left:29px;margin-right:23px;color:white"><b style="margin-right:40px;"> ₹</b> 91,128.00</span></h4>
                               <div class="row no-print">
                                    <div class="col-xs-12">
                                        <form><button type='button' value='Print this page' onclick='printpage();' class="btn btn-default"><i class="fa fa-print"></i> Print</button>
                                        </form>
                                        <script>
                                            function printpage() {
                                                var is_chrome = function() {
                                                    return Boolean(window.chrome);
                                                }
                                                if (is_chrome) {
                                                    window.print();
                                                    setTimeout(function() {
                                                        window.close();
                                                    }, 10000);
                                                    //give them 10 seconds to print, then close
                                                } else {
                                                    window.print();
                                                    window.close();
                                                }
                                            }
                                        </script>
                                    </div>
                                </div>

                    </div>
                    <!--/box-body--->
                </div>
            </div>
        
        </div>
</section>
<div class="separator"> </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
