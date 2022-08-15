<?php
$pincode=$_POST['pincode'];
$data=file_get_contents('http://postalpincode.in/api/pincode/'.$pincode);
$data=json_decode($data);
if(isset($data->PostOffice['1'])){
	// $arr['city']=$data->PostOffice[5]->Taluk;
	// $arr['state']=$data->PostOffice['0']->State;
	echo json_encode($data->PostOffice);
}else{
	echo 'no';
}
?>