
    <?php
        // Database Connection
        require '../include/config.php';
        //  Add Function 
        if(isset($_POST['req_add'])){

            $customer       = $_POST['customer'];
            $accessory      = $_POST['accessory'];
            $billing_address= $_POST['billing_address'];
            $brand          = $_POST['brand'];
            $model          = $_POST['model'];
            $serial_no      = $_POST['serial_no'];
            $request_date   = $_POST['request_date'];
            $delivery_date  = $_POST['delivery_date'];
            $job_desc       = $_POST['job_desc'];
            $advance        = $_POST['advance'];
            $service        = $_POST['service'];
            $status         = 'request';

            //$year = cur_date('Y');
            $today = new DateTime(null, new DateTimeZone('Asia/Colombo'));
            $year = $today->format('Y');

            $max_jobno = mysqli_query($conn,"SELECT * FROM jobs ORDER BY jobId DESC LIMIT 1");
            $data = mysqli_fetch_assoc($max_jobno);
            $numRows = mysqli_num_rows($max_jobno);
            if($numRows>0){
                $no = $data['jobId']+1;
            }else{
                $no = 1;
            }
            $job_no = $year . $no;

            $check= mysqli_query($conn, "SELECT * FROM jobs WHERE jobNo='$job_no' AND billing_address='$billing_address' AND accessory='$accessory' AND brand='$brand' AND model='$model' AND serial_no='$serial_no' AND request_date='$request_date' AND delivery_date='$delivery_date' AND job_desc='$job_desc' AND advance='$advance' AND service_cost='$service' AND customerId='$customer'");
		    $count = mysqli_num_rows($check);

            if($count==0){

                $insert = "INSERT INTO jobs (jobNo,billing_address,accessory,brand,model,serial_no,request_date,delivery_date,job_desc,advance,status,service_cost,customerId) VALUES ('$job_no','$billing_address','$accessory','$brand','$model','$serial_no','$request_date','$delivery_date','$job_desc','$advance','$status','$service','$customer')";
                $output = mysqli_query($conn,$insert);
                if($output){
                    echo  1;
                }else{
                    echo  mysqli_error($conn);		
                }
            }else{
                echo 0;
            }


            /////// send msg ////////

            $get_contact = mysqli_query($conn, "SELECT * FROM customer WHERE id='$customer'");
            $cus_data = mysqli_fetch_assoc($get_contact);

            if($customer=='1'){
                $split_values = explode(',', $billing_address);
                $customer_name = $split_values[0];
                $to = $split_values[1];

            }else{
                $customer_name = $cus_data['name'];
                $to = $cus_data['contact'];
            }

            $advanced = number_format($advance,2,'.',',');
            $estimate_amt = number_format($service,2,'.',',');

            $User_name ="Shadcomputers"; //Your Username 
            $Api_key = "5bbb49d5c63f487727f0"; //Your API Key 
            $Gateway_type = "2"; //Define Premium Gateway 
            $Sender_id = "Shadcom"; //Your Sender ID 
            $Message_type = "2"; //1 for Short SMS, 2 for Long SMS 
            $Country_code = "94"; //Country Code 
            $Number = $to; //Mobile Number Without 0 
            $message = "Hi ".$customer_name.", We are Received Your Repair [Job Note Number - ".$job_no."].Estimated Amount Rs.".$estimate_amt." Advance Rs.".$advanced." Your Status-request Job Will Be Completed ".$delivery_date.".Thank You, SHAD COMPUTERS"; //Your Message 

            $data = array( "user_name" => $User_name, "api_key" => $Api_key, "gateway_type" => $Gateway_type, "sender_id" => $Sender_id , "message_type" => $Message_type , "country_code" => $Country_code, "number" => $Number, "message" => $message ); 

            $data_string = json_encode($data); 

            $ch = curl_init('https://my.ipromo.lk/api/postsendsms/'); 
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', 'Content-Length: ' . strlen($data_string)) ); 
            curl_setopt($ch, CURLOPT_TIMEOUT, 5); 
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            //Execute Post 
            $result = curl_exec($ch); 
            //Close Connection 
            curl_close($ch); 
            echo $result; 
        }

        //  Update Function 
        if(isset($_POST['req_update'])){

            $id             = $_POST['view_id'];
            $customer       = $_POST['customer'];
            $accessory      = $_POST['accessory'];
            $billing_address= $_POST['billing_address'];
            $brand          = $_POST['brand'];
            $model          = $_POST['model'];
            $serial_no      = $_POST['serial_no'];
            $request_date   = $_POST['request_date'];
            $delivery_date  = $_POST['delivery_date'];
            $job_desc       = $_POST['job_desc'];
            $advance        = $_POST['advance'];
            $service        = $_POST['service'];
            $status         = $_POST['status'];

            $check= mysqli_query($conn, "SELECT * FROM jobs WHERE jobNo='$job_no' AND billing_address='$billing_address' AND accessory='$accessory' AND brand='$brand' AND model='$model' AND serial_no='$serial_no' AND request_date='$request_date' AND delivery_date='$delivery_date' AND job_desc='$job_desc' AND advance='$advance' AND service_cost='$service' AND customerId='$customer'");
		    $count = mysqli_num_rows($check);

            if($count==0){

                $edit = "UPDATE jobs 
                                    SET accessory   ='$accessory',
                                        billing_address  ='$billing_address',
                                        brand  ='$brand',
                                        model  ='$model',
                                        serial_no  ='$serial_no',
                                        request_date  ='$request_date',
                                        delivery_date  ='$delivery_date',
                                        job_desc  ='$job_desc',
                                        advance  ='$advance',
                                        service_cost  ='$service',
                                        status  ='$status',
                                        customerId  ='$customer'
                                    WHERE jobId=$id";

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

            $id    = $_POST['removeID'];
            $query ="DELETE FROM jobs WHERE jobId='$id'";
            $result = mysqli_query($conn,$query);
            if($result){
                echo  1;
            }else{
                echo  mysqli_error($conn);		
            }
        }

    ?>