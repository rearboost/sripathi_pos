<?php
	error_reporting(0);
	include("../include/config.php");

	$customer_name = $_POST['customerID'];

	$sql = mysqli_query($conn, "SELECT * FROM customer WHERE name='$customer_name'");

	$data  =mysqli_fetch_assoc($sql);

	$id 	 = $data['id'];
	$address = $data['address'];
	$nic 	 = $data['nic'];
	$contact = $data['contact'];

	$myobj->id 		= $id;
	$myobj->address = $address;
	$myobj->nic 	= $nic;
	$myobj->contact = $contact;

	$myJSON = json_encode($myobj);
	echo $myJSON;
?>