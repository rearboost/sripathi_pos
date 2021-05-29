    <?php
        // Database Connection
        require '../include/config.php';

           // Row Add Function 
        if(isset($_POST['addrow'])){

            $product_name = $_POST['product_name'];
            $quantity = $_POST['quantity'];
            $warranty = $_POST['warranty'];
            $serial_no = $_POST['serial_no'];

            $get_price = "SELECT B.max_price AS price , B.stock_quantity AS stock , A.ID AS post_id 
                            FROM wp_posts A 
                            INNER JOIN wp_wc_product_meta_lookup B
                            ON A.ID = B.product_id WHERE A.post_title = '$product_name'";

            $result_price = mysqli_query($conn,$get_price);
            $check = mysqli_num_rows($result_price);

            if(!empty($check)){

                $row = mysqli_fetch_assoc($result_price);
                $price  = $row['price'];
                $stock  = $row['stock']-1;
                $post_id  = $row['post_id'];

                $meta_key = "_regular_price";
                $get_discount = "SELECT * FROM wpss_postmeta WHERE post_id='$post_id' AND meta_key ='$meta_key'";
                $result_discount = mysqli_query($conn,$get_discount);
                $check_count = mysqli_num_rows($result_discount);
                if($check_count>0){
                    $discount  = $result_discount['meta_value']-$price;
                }else{
                    $discount  = "0.00";
                }
                
            }else{

                $get_price2 = "SELECT max_price AS price , stock_qty AS stock , discount
                            FROM dashboard_items  
                            WHERE item = '$product_name'";

                $result_price2 = mysqli_query($conn,$get_price2);
                $row2 = mysqli_fetch_assoc($result_price2);
                $price  = $row2['price'];
                $stock  = $row2['stock']-1;
                $discount  = $row2['discount'];
            }

            $sql ="SELECT * FROM temp_pos WHERE product= '$product_name'";
            $result=mysqli_query($conn,$sql);
            $row_get = mysqli_fetch_assoc($result);
            $count =mysqli_num_rows($result);
            $stock_quantity = $row_get['stock_quantity'];

            $stockEmptyCode = 0;

            $amount = $quantity * $price;
            $discount = $discount * $quantity;

            if($stock>0){

                if($count==0){
                
                    $sql_temp = "INSERT INTO  temp_pos (product,warranty,serial_no,qty,price,discount,amount,stock_quantity) VALUES ('$product_name','$warranty','$serial_no','$quantity','$price','$discount','$amount','$stock')";
                    $result_temp = mysqli_query($conn,$sql_temp);
                
                }else{

                    if($stock_quantity>0){

                        $sql_temp = "UPDATE temp_pos
                        SET qty = qty + $quantity, amount = amount + $amount , discount= discount + $discount ,stock_quantity = stock_quantity - $quantity
                        WHERE product= '$product_name'";
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
            $credit_period = $_POST['credit_period'];
            $customer = $_POST['customer'];
            $billing_address = $_POST['billing_address'];
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

            $sql_invoice = "INSERT INTO  invoice (total,discount,payment,credit_period,customer,billing_address,date,payment_type,bank,cheque_no,cheque_dueDate,card_type,card_no) VALUES ('$total','$discount','$payment','$credit_period','$customer','$billing_address','$date','$payment_type','$bank','$cheque_no','$due_date','$card_type','$card_no')";
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
                    $qty=$row['qty'];
                    $price=$row['price'];
                    $discount=$row['discount'];
                    $amount=$row['amount'];
                    $warranty=$row['warranty'];
                    $serial_no=$row['serial_no'];

                    $sql_invoice_items = "INSERT INTO invoice_items (invoice_id,product,warranty,serial_no,qty,price,discount,amount) VALUES ('$invoice_id','$product','$warranty','$serial_no','$qty','$price','$discount','$amount')";
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