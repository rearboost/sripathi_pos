    <?php
        // Database Connection
        require '../include/config.php';

           // Row Add Function 
        if(isset($_POST['addrow'])){

            $product_name = $_POST['product_name'];
            $measurement = $_POST['measurement'];
            $weight = $_POST['weight'];

            $get_price = "SELECT * 
                            FROM material_stock 
                            WHERE item_name = '$product_name' AND measurement='$measurement'";

            $result_price = mysqli_query($conn,$get_price);
            //$check = mysqli_num_rows($result_price);


            $row = mysqli_fetch_assoc($result_price);
            $price  = $row['price'];
            //$weight  = $row['weight']-1;
            $tot_weight  = $row['weight']-$weight;

            $sql ="SELECT * FROM temp_pos WHERE product= '$product_name' AND measurement='$measurement'";
            $result=mysqli_query($conn,$sql);
            $row_get = mysqli_fetch_assoc($result);
            $count =mysqli_num_rows($result);
            $stock_weight = $row_get['stock_weight'];

            $stockEmptyCode = 0;

            $amount = $weight * $price;

            if($tot_weight>0){

                if($count==0){
                
                    $sql_temp = "INSERT INTO  temp_pos (product,measurement,weight,price,amount,stock_weight) VALUES ('$product_name','$measurement','$weight','$price','$amount','$tot_weight')";
                    $result_temp = mysqli_query($conn,$sql_temp);
                
                }else{

                    if($stock_weight>0){

                        $sql_temp = "UPDATE temp_pos
                        SET weight = weight + $weight, amount = amount + $amount, stock_weight = stock_weight - $weight
                        WHERE product= '$product_name' AND measurement='$measurement'";
                        $result_temp = mysqli_query($conn,$sql_temp);
                    }else{

                        $stockEmptyCode = 2 ;
                    } 
                }

                if($stockEmptyCode==0){

                    $sql ="SELECT SUM(amount) AS amount FROM temp_pos";
                    $result=mysqli_query($conn,$sql);
                    $row_get = mysqli_fetch_assoc($result);
                    $amount = $row_get['amount'];
                   
                    echo $amount;

                }else{
                    //echo  mysqli_error($con);		
                    $stockEmptyCode = 2;
                    echo $stockEmptyCode;
                }

            }else{
                $stockEmptyCode = 2;
                echo $stockEmptyCode;
            }
        }

        /////////Add function from dashboard items

        // Table Empty Function 
        if(isset($_POST['tmpEmpty'])){
            
            $empty_temp = "TRUNCATE temp_pos;";
            mysqli_query($conn,$empty_temp);   
        }

        // Remove  Function 
        if(isset($_POST['removeRow'])){
            
            $id = $_POST['id'];
            $remove_temp = "DELETE FROM temp_pos WHERE id='$id'";
            mysqli_query($conn,$remove_temp);

            $sql ="SELECT SUM(amount) AS amount FROM temp_pos";
            $result=mysqli_query($conn,$sql);
            $row_get = mysqli_fetch_assoc($result);
            $amount = $row_get['amount'];
            
            echo $amount;
    
        }

        //////////////////////////////////////////////////////////////

        // Save Function 
        if(isset($_POST['save'])){

            $total = $_POST['total'];
            $discount = $_POST['discount'];
            $payment = $_POST['payment'];
            $customer = $_POST['customer'];
            $date = $_POST['date'];

            $payment_type = $_POST['payment_type'];
            $bank = $_POST['bank'];
            $cheque_no = $_POST['cheque_no'];
            $due_date = $_POST['due_date'];
            $card_type = $_POST['card_type'];
            $card_no = $_POST['card_no'];

            if($payment_type=='cash' || $payment_type=='credit' || $payment_type=='cheque'){
                $card_type = '';
            }else{
                $card_type = $_POST['card_type'];
            }

            $sql_invoice = "INSERT INTO  invoice (total,discount,payment,customer,date,payment_type,bank,cheque_no,cheque_dueDate,card_type,card_no) VALUES ('$total','$discount','$payment','$customer','$date','$payment_type','$bank','$cheque_no','$due_date','$card_type','$card_no')";
            mysqli_query($conn,$sql_invoice);

            $sql ="SELECT id FROM invoice ORDER BY id DESC LIMIT 1";
            $result=mysqli_query($conn,$sql);
            $row_get = mysqli_fetch_assoc($result);
            $invoice_id = $row_get['id'];

            $sql_temp=mysqli_query($conn,"SELECT * FROM temp_pos");

            $numRows = mysqli_num_rows($sql_temp); 

            if($numRows > 0) {

                while($row = mysqli_fetch_assoc($sql_temp)) {

                    $product=$row['product'];
                    $measurement=$row['measurement'];
                    $weight=$row['weight'];
                    $price=$row['price'];
                    $amount=$row['amount'];

                    $sql_invoice_items = "INSERT INTO invoice_items (invoice_id,product,measurement,weight,price,amount) VALUES ('$invoice_id','$product','$measurement','$weight','$price','$amount')";
                    mysqli_query($conn,$sql_invoice_items);
                }
            }

            if($result){
                
                echo $invoice_id;

            }else{
                echo  mysqli_error($conn);		
            }
        }
       
    ?>