    <?php
        // Database Connection
        require '../include/config.php';
        
        // Update Function 
        if(isset($_POST['add'])){

            $renewDate = $_POST['renewDate'];
            $mid       = $_POST['mid'];
            $interest  = $_POST['interest'];
            $payment   = $_POST['payment'];
            $renewAmt  = $_POST['renewAmt'];
            $totalPaid = $_POST['totalPaid'];

            $splitValues = explode('-', $renewDate);
            $year = $splitValues[0];
            $month = $splitValues[1];

            $insert = "INSERT INTO renewing (renewDate,month,year,payment,dueInterest,total_paid,renewAmt,pawningID) VALUES ('$renewDate','$month','$year','$payment','$interest','$totalPaid','$renewAmt','$mid')";

            $result = mysqli_query($conn,$insert);
            if($result){
                echo  1;
            }else{
                echo  mysqli_error($conn);		
            }
            
        }

    ?>