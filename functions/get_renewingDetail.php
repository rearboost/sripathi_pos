<?php
	error_reporting(0);
	include("../include/config.php");

	$customer = $_POST['customer'];

	$get_Cid = mysqli_query($conn, "SELECT * FROM customer WHERE name='$customer'");
	$cutomData = mysqli_fetch_assoc($get_Cid);
	$customer_id = $cutomData['id'];

	$get_paw = mysqli_query($conn,"SELECT * FROM mortgage  WHERE customerID = '$customer_id' AND status = 1");

	$data = mysqli_fetch_array($get_paw); 

	$M_id 			 = $data['M_id'];
	$mortgageDate 	 = $data['mortgageDate'];
	$rescueDate 	 = $data['rescueDate'];
	$interestRate 	 = $data['interestRate'];
	$timePeriod 	 = $data['timePeriod'];
	$mortgageAdvance = $data['mortgageAdvance'];
	
	$check_no = mysqli_query($conn,"SELECT * FROM (SELECT * FROM renewing WHERE renewing.pawningID = '$M_id') V ORDER BY V.id DESC LIMIT 1;");
    $data1 = mysqli_fetch_array($check_no); 
    $renewCount = mysqli_num_rows($check_no);

	$renewDate 		  = $data1['renewDate'];
	$total_paid  	  = $data1['total_paid'];
	$renewAmt   	  = $data1['renewAmt'];
	
	if($renewCount==0)
	{
		$newAmount  = $mortgageAdvance;	
		$total_paid = 0;	
		$pre_date 	= $mortgageDate;	
	}
	else
	{
	   	$newAmount 	= $renewAmt;
	   	$total_paid = $total_paid;	
	   	$pre_date   = $renewDate;
	}

	//$myObj->mortgageAdvance = $mortgageAdvance;
	$myObj->M_id 			= $M_id;
	$myObj->timePeriod 		= $timePeriod;
	$myObj->interestRate 	= $interestRate;
	$myObj->rescueDate 	 	= $rescueDate;
	$myObj->newAmount 		= $newAmount;
	$myObj->total_paid 		= $total_paid;
	$myObj->pre_date 	 	= $pre_date;

	$myJSON = json_encode($myObj);

	echo $myJSON;

?>