
    <?php
        // Database Connection
        require '../include/config.php';

        //  Add Function 
        if(isset($_POST['add'])){

            $item          = $_POST['item'];
            $stock_in     = $_POST['stock_in'];
            $min_price     = $_POST['min_price'];
            $max_price     = $_POST['max_price'];
            $discount      = $_POST['discount'];
            $stock_status  = $_POST['stock_status'];

            $check= mysqli_query($conn, "SELECT * FROM dashboard_items WHERE item='$item' AND stock_qty='$stock_qty' AND min_price='$min_price' AND max_price='$max_price' AND stock_status='$stock_status'");
		    $count = mysqli_num_rows($check);

            if($count==0){

                $insert = "INSERT INTO dashboard_items (item,min_price,max_price,discount,stock_qty,stock_status) VALUES ('$item','$min_price','$max_price','$discount',$stock_in,'$stock_status')";
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

        //  Update Function 
        if(isset($_POST['update'])){

            $id            = $_POST['view_id'];
            $item          = $_POST['item'];
            $stock_in     = $_POST['stock_in'];
            $min_price     = $_POST['min_price'];
            $max_price     = $_POST['max_price'];
            $discount      = $_POST['discount'];
            $stock_status  = $_POST['stock_status'];

            $check= mysqli_query($conn, "SELECT * FROM dashboard_items WHERE item='$item' AND stock_qty='$stock_qty' AND min_price='$min_price' AND max_price='$max_price' AND stock_status='$stock_status'");
		    $count = mysqli_num_rows($check);

            if($count==0){

                $edit = "UPDATE dashboard_items 
                                    SET item   ='$item',
                                        stock_qty  = stock_qty + '$stock_in',
                                        min_price  ='$min_price',
                                        max_price  ='$max_price',
                                        discount ='$discount',  
                                        stock_status= '$stock_status'
                                    WHERE item_id=$id";

                $result = mysqli_query($conn,$edit);
                if($result){
                    echo  1;
                }else{
                    echo  mysqli_error($conn);		
                }

            }else{
                echo 0;
            }
        }

        //  Delete Function 
        if(isset($_POST['removeID'])){

            $id       = $_POST['removeID'];
            $query ="DELETE FROM dashboard_items WHERE item_id='$id'";
            $result = mysqli_query($conn,$query);
            if($result){
                echo  1;
            }else{
                echo  mysqli_error($conn);		
            }
        }


    ?>