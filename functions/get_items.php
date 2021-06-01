<?php	
	//error_reporting(0);
	require '../include/config.php';

	if(isset($_GET['item'])){	
		$item_name = $_GET['item'];

		$get_items = mysqli_query($conn, "SELECT measurement FROM material_stock WHERE item_name='$item_name'");
		$count = mysqli_num_rows($get_items);

		if($count>0){
			echo '<option selected="" disabled="">Select Item First</option>';
			while($row = mysqli_fetch_array($get_items)){
				echo '<option value ="'.$row['measurement'].'" >'.$row['measurement'].'k</option>';
			}
		}else{
			echo '<option>No measurements available</option>';
		}
		
	}else{
		echo '<h1> Error</h1>';
	}



?>