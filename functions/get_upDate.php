<?php
	error_reporting(0);
	include("../include/config.php");

	$item = $_POST['item'];
	$measurement = $_POST['measurement'];

	$get_date = mysqli_query($conn,"SELECT update_date FROM material_stock WHERE item_name='$item' AND measurement='$measurement'");	

	$data    = mysqli_fetch_assoc($get_date);

	$upDate	 = $data['update_date'];

	$myObj->upDate  = $upDate;
	
	$myJSON = json_encode($myObj);

	echo $myJSON;

?>