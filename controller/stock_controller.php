<?php
    // Database Connection
    require '../include/config.php';

    //  Add Function 
    if(isset($_POST['add'])){

        $item_name     = $_POST['item_name'];
        $weight        = $_POST['weight'];
        $weight_in     = $_POST['weight_in'];
        $measurement   = $_POST['measurement'];
        $note          = $_POST['note'];

        $check= mysqli_query($conn, "SELECT * FROM material_stock WHERE item_name='$item_name' AND measurement='$measurement' AND weight='$weight_in' AND note='$note'");
	    $count = mysqli_num_rows($check);

        if($count==0){

            $insert = "INSERT INTO material_stock (item_name,measurement,weight,note) VALUES ('$item_name','$measurement','$weight_in','$note')";
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
        $item_name     = $_POST['item_name'];
        $weight        = $_POST['weight'];
        $weight_in     = $_POST['weight_in'];
        $measurement   = $_POST['measurement'];
        $note          = $_POST['note'];

        $check= mysqli_query($conn, "SELECT * FROM material_stock WHERE item_name='$item_name' AND measurement='$measurement' AND weight='$weight' AND note='$note'");
	    $count = mysqli_num_rows($check);

        if($count==0){

            $edit = "UPDATE material_stock 
                                SET weight  = weight + '$weight_in', 
                                    note= '$note'
                                WHERE id=$id";

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

        $id     = $_POST['removeID'];
        $query  ="DELETE FROM material_stock WHERE id='$id'";
        $result = mysqli_query($conn,$query);
        if($result){
            echo  1;
        }else{
            echo  mysqli_error($conn);		
        }
    }


?>