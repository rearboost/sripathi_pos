    <?php
        // Database Connection
        require '../include/config.php';
        
        // Update Function 
        if(isset($_POST['req_add'])){

            $customer        = $_POST['customerID'];
            $mortageDate     = $_POST['mortageDate'];
            $rescueDate      = $_POST['rescueDate'];
            $itemDetail      = $_POST['itemDetail'];
            $weight          = $_POST['weight'];
            $interestRate    = $_POST['interestRate'];
            $timePeriod      = $_POST['timePeriod'];
            $mortageAdvance  = $_POST['mortageAdvance'];

            $check= mysqli_query($conn, "SELECT * FROM mortgage WHERE customerID='$customer' AND mortgageDate='$mortageDate' AND rescueDate='$rescueDate' AND itemDetail='$itemDetail' AND weight='$weight' AND interestRate='$interestRate' AND timePeriod='$timePeriod' AND mortgageAdvance='$mortageAdvance'");
		    $count = mysqli_num_rows($check);

            if($count==0){

                $insert = "INSERT INTO mortgage (customerID,mortgageDate,rescueDate,itemDetail,weight,interestRate,timePeriod,mortgageAdvance,status) VALUES ('$customer','$mortageDate','$rescueDate','$itemDetail','$weight','$interestRate','$timePeriod','$mortageAdvance',1)";

                $result = mysqli_query($conn,$insert);
                if($result){
                    echo  1;
                }else{
                    echo  mysqli_error($conn);		
                }

            }else{
                echo 0;
            }
        }

    ?>