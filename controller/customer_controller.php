
    <?php
        // Database Connection
        require '../include/config.php';


        // view all
        if(isset($_POST['view_id']))
       {
         $val =$_POST['view_id'];
         $query_obj ="SELECT * FROM customer WHERE id='".$val."'";
         $result_obj =mysqli_query($conn,$query_obj);

         $object_obj =mysqli_fetch_object($result_obj);
         echo json_encode($object_obj);

       }

        //  Add Function 
        if(isset($_POST['add'])){

            $name      = $_POST['name'];
            $address   = $_POST['address'];
            $nic       = $_POST['nic'];
            $contact   = $_POST['contact'];

            $check= mysqli_query($conn, "SELECT * FROM customer WHERE name='$name' AND address='$address' AND nic='$nic' AND contact='$contact'");
		    $count = mysqli_num_rows($check);

            if($count==0){

                $insert = "INSERT INTO customer (name,address,nic,contact) VALUES ('$name','$address','$nic','$contact')";
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

            $id      = $_POST['edit_id'];
            $name    = $_POST['name'];
            $address = $_POST['address'];
            $nic   = $_POST['nic'];
            $contact = $_POST['contact'];

            $check= mysqli_query($conn, "SELECT * FROM customer WHERE name='$name' AND address='$address' AND nic='$nic' AND contact='$contact'");
		    $count = mysqli_num_rows($check);

            if($count==0){

                $edit = "UPDATE customer 
                                    SET name   ='$name',
                                        address  ='$address',
                                        nic  ='$nic',
                                        contact  ='$contact'
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

            $id       = $_POST['removeID'];
            $query ="DELETE FROM customer WHERE id='$id'";
            $result = mysqli_query($conn,$query);
            if($result){
                echo  1;
            }else{
                echo  mysqli_error($conn);		
            }
        }

    ?>