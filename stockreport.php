<?php
session_start();
header("Expires: on, 01 Jan 1970 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
// start session

// set time for session timeout
$currentTime = time() + 25200;
$expired = 3600;

// if session not set go to login page
if (!isset($_SESSION['user'])) {
    header("location:index.php");
}

// if current time is more than session timeout back to login page
if ($currentTime > $_SESSION['timeout']) {
    session_destroy();
    header("location:index.php");
}

// destroy previous session timeout and create new one
unset($_SESSION['timeout']);
$_SESSION['timeout'] = $currentTime + $expired;

?>

<?php include "header.php"; ?>
<html>

<head>
    <title>Goldplus | <?= $settings['app_name'] ?> - Dashboard</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!--- stylesheets --->
    <style>
        .small-box{
            border-radius:10px;
            background-color:white;
            border:2px solid #ccc;
        }
        h2{
            font-size:20px;
            font-weight:900;
            color:#2e2a29;
        }
        .small-box h3{
            font-size:50px!important;
        }
       
    </style>
</head>

<body>
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1 style="font-size:30px;font-weight:600;">Stock Report</h1>
            <ol class="breadcrumb">
                <li>
                    <a href="home.php"> <i class="fa fa-home"></i> Home</a>
                </li>
            </ol>
        </section>
<?php
if ($permissions['stockreport']['read'] == 1) {
?>
        <section class="content">
            <div class="row">
                <div class="col-lg-4 col-xs-6">
                    <a href="">
                        <div class="small-box">
                            <div class="inner">
                            <h2 class="text-center">916 Closing</h2>
                                <h3 class="text text-success text-center"> &#8377;<?php
                                $sql = "SELECT kdm FROM openingmaster";
                                $db->sql($sql);
                                $res = $db->getResult();
                                echo $res[0]['kdm'];
                                ?></h3>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-xs-6">
                    <a href="">
                        <div class="small-box">
                            <div class="inner">
                            <h2 class="text-center">Metal Closing</h2>
                                <h3 class="text text-success text-center"> &#8377;<?php
                                $sql = "SELECT metal FROM openingmaster";
                                $db->sql($sql);
                                $res = $db->getResult();
                                echo $res[0]['metal'];
                                ?></h3>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-xs-6">
                    <a href="">
                        <div class="small-box">
                            <div class="inner">
                            <h2 class="text-center">Katcha Closing</h2>
                                <h3 class="text text-success text-center"> &#8377;<?php
                                $sql = "SELECT katcha FROM openingmaster";
                                $db->sql($sql);
                                $res = $db->getResult();
                                echo $res[0]['katcha'];
                                ?></h3>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-xs-6">
                    <a href="">
                        <div class="small-box" >
                            <div class="inner">
                            <h2 class="text-center">Cash On Hand</h2>
                                <h3 class="text text-success text-center"> &#8377;<?php
                                $sql = "SELECT cash_hand FROM openingmaster";
                                $db->sql($sql);
                                $res = $db->getResult();
                                echo $res[0]['cash_hand'];
                                ?></h3>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-xs-6">
                    <a href="">
                        <div class="small-box" >
                            <div class="inner">
                            <h2 class="text-center">Total Pure Balance</h2>
                                <h3 class="text text-success text-center"> &#8377;<?php
                                $sql = "SELECT katcha FROM openingmaster";
                                $db->sql($sql);
                                $res = $db->getResult();
                                echo $res[0]['katcha'];
                                ?></h3>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-xs-6">
                    <a href="">
                        <div class="small-box">
                            <div class="inner">
                            <h2 class="text-center" >Total Cash Balance</h2>
                                <h3 class="text text-danger text-center"> &#8377;<?php
                                $sql = "SELECT katcha FROM openingmaster";
                                $db->sql($sql);
                                $res = $db->getResult();
                                echo $res[0]['katcha'];
                                ?></h3>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
                
        </section>
        <?php } else { ?>
    <div class="alert alert-danger topmargin-sm" style="margin-top: 20px;">You have no permission to view stock report.</div>
<?php } ?>
    </div>
   
</body>

</html>
<?php include "footer.php"; ?>