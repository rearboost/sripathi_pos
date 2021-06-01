<?php
// Database Connection
require '../include/config.php';
//  Update Function 
if(isset($_POST['price_update'])){

    $item        = $_POST['item'];
    $measurement = $_POST['measurement'];
    $price       = $_POST['price'];

    $today = new DateTime(null, new DateTimeZone('Asia/Colombo'));
    $Update_date = $today->format('Y-m-d');

    $check= mysqli_query($conn, "SELECT * FROM material_stock WHERE item_name='$item' AND   measurement='$measurement' AND price='$price' AND update_date='$Update_date' ");
    $count = mysqli_num_rows($check);

    if($count==0){

        $edit = "UPDATE material_stock 
                            SET price   ='$price',
                                update_date= '$Update_date'
                            WHERE item_name='$item' AND measurement='$measurement'";

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

?>