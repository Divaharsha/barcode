<?php
	session_start();
	// set time for session timeout
	$currentTime = time() + 25200;
	$expired = 3600;
	
	
	// if current time is more than session timeout back to login page
	if($currentTime > $_SESSION['timeout']){
		session_destroy();
		header("location:index.php");
	}
	
	// destroy previous session timeout and create new one
	unset($_SESSION['timeout']);
	$_SESSION['timeout'] = $currentTime + $expired;
?>
<?php include "header.php";?>
<html>
<head>
<title>Add Product | <?=$settings['app_name']?> - Dashboard</title>
<style>
    .asterik {
    font-size: 20px;
    line-height: 0px;
    vertical-align: middle;
}
</style>
<!-- jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<!-- cropzee.js -->
	<script src="cropzee.js" defer></script>
	<!--  -->
	<style>
		.image-previewer {
			height: 300px;
			width: 300px;
			display: flex;
			border-radius: 10px;
			border: 1px solid lightgrey;
		}
	</style>
</head>
</body>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <?php include('public/add-product-form.php'); ?>
      </div><!-- /.content-wrapper -->
  </body>
</html>
<?php include "footer.php";?>