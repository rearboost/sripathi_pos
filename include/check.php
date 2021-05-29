
<?php
    // if(empty($_SESSION['user_role']) || $_SESSION['user_role']==0){
    //    header('Location: ../index.php');
    // }

    session_start();
    $email= $_SESSION['username'];
    if(!isset($_SESSION['username'])){
    header('Location: ../index');
    }


?>
