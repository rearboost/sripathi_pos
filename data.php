<?php
	
	//error_reporting(0);
	include("../include/config.php");

	$job_id = $_POST['id'];

	$jobs = mysqli_query($con,"SELECT * FROM jobs WHERE jobId= '$job_id'");

	$job_data = mysqli_fetch_array($jobs); 

	$advance 		= $job_data['advance'];
	$service_cost 	= $job_data['service_cost'];

	$parts = mysqli_query($con,"SELECT SUM(qty*price) as accessory FROM parts WHERE jobID= '$job_id' GROUP BY jobID ");

	$parts_data = mysqli_fetch_array($parts); 

	$accessory 		= $parts_data['accessory'];

	$myObj->advance 		 = $advance;
	$myObj->service_cost 	 = $service_cost;
	$myObj->accessory 		 = $accessory;

	$myJSON = json_encode($myObj);

	echo $myJSON;

?>