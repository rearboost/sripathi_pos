<?php
	error_reporting(0);
	include("../include/config.php");

	$customer_name = $_POST['customer'];

	$sql = mysqli_query($conn, "SELECT * FROM customer C INNER JOIN mortgage M ON C.id=M.customerID WHERE C.name='$customer_name'");

	$data  =mysqli_fetch_assoc($sql);

	$name 	 		= $data['name'];
	$nic 	 		= $data['nic'];
	$mortgageDate 	= $data['mortgageDate'];
	$rescueDate 	= $data['rescueDate'];
	$itemDetail 	= $data['itemDetail'];
	$weight 		= $data['weight'];
	$interestRate 	= $data['interestRate'];
	$timePeriod 	= $data['timePeriod'];
	$mortgageAdvance= $data['mortgageAdvance'];
	$M_id			= $data['M_id'];

	$Payment = mysqli_query($conn, "SELECT * FROM renewing WHERE pawningID='$M_id'");
	$detail = mysqli_fetch_assoc($Payment);
	$count = mysqli_num_rows($Payment);

	
	$last_date = $detail['renewDate'];
	$RenewAmt = $detail['renewAmt'];
	$TotalPaid = $detail['total_paid'];
	


	
?>
<table border="0">
	<tr><th>Customer </th><td><?php echo  ' : '. $name . ' [' . $nic . ']'; ?></td></tr>
	<tr><th>Pawning Date </th><td><?php echo  ' : '. $mortgageDate; ?></td></tr>
	<tr><th>Rescue Date </th><td><?php echo  ' : '. $rescueDate; ?></td></tr>
	<tr><th>Item Details </th><td><?php echo  ' : '. $itemDetail; ?></td></tr>
	<tr><th>Weight </th><td><?php echo  ' : '. $weight; ?></td></tr>
	<tr><th>Interest Rate </th><td><?php echo  ' : '. $interestRate; ?></td></tr>
	<tr><th>Time period </th><td><?php echo  ' : '. $timePeriod; ?></td></tr>
	<tr><th>Advance </th><td><?php echo  ' : '. $mortgageAdvance; ?></td></tr>
</table>

<br>
	<p><strong>Renewing Details</strong></p>
	<?php
	if($count==0){
		echo '<p><center>No available renewings..</center></p>';
	}else{
	?>

<table border="0">
	<tr><th>Last Renewing On</th><td><?php echo  ' : '. $last_date; ?></td></tr>
	<tr><th>Renew Amount</th><td><?php echo  ' : '. $RenewAmt; ?></td></tr>
	<tr><th>Total Paid</th><td><?php echo  ' : '. $TotalPaid; ?></td></tr>
</table>

	<?php } ?>
<!-- <p><strong> Customer : </strong><?php //echo $name . ' [' . $nic . ']'; ?> </p>
<p><strong> Pawning Date : </strong><?php //echo $mortgageDate; ?> </p>
<p><strong> Rescue Date : </strong><?php //echo $rescueDate; ?> </p>
<p><strong> Item Details : </strong><?php //echo $itemDetail; ?> </p>
<p><strong> Weight : </strong><?php //echo $weight; ?> </p>
<p><strong> Interest Rate : </strong><?php //echo $interestRate; ?> </p>
<p><strong> Time period : </strong><?php //echo $timePeriod; ?> </p>
<p><strong> Advance : </strong><?php //echo $mortgageAdvance; ?> </p> -->