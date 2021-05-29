

<?php
$User_name ="Shadcomputers"; //Your Username 
$Api_key = "5bbb49d5c63f487727f0"; //Your API Key
$Gateway_type = "1"; //Define Economy Gateway 
$Country_code = "94"; //Country Code
$Number = "778693641"; //Mobile Number Without 0 
$message = "Test Message"; //Your Message
$data = array(
"user_name" => $User_name,
"api_key" => $Api_key,
"gateway_type" => $Gateway_type, 
"country_code" => $Country_code, 
"number" => $Number,
"message" => $message
);
$data_string = json_encode($data);
$ch = curl_init('https://my.ipromo.lk/api/postsendsms/'); curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string); curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json',
'Content-Length: ' . strlen($data_string)) );
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
//Execute Post
$result = curl_exec($ch);
?>