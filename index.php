<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sripathi Jewellers - Login</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="./assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="./assets/vendors/iconfonts/ionicons/dist/css/ionicons.css">
    <link rel="stylesheet" href="./assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="./assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="./assets/vendors/css/vendor.bundle.addons.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="./assets/css/shared/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="./assets/images/favicon.ico" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
          <div class="row w-100">
            <div class="col-lg-4 mx-auto">
              <div class="auto-form-wrapper">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" >
                  <div class="form-group">
                    <label class="label">Username</label>
                    <div class="input-group">
                      <input type="text" name="username" class="form-control" placeholder="Username">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="label">Password</label>
                    <div class="input-group">
                      <input type="password" name="password" class="form-control" placeholder="*********">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary submit-btn btn-block">Login</button>
                  </div>
                  <div class="form-group d-flex justify-content-between">
                    <div class="form-check form-check-flat mt-0">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" checked> Keep me signed in </label>
                    </div>
                    <a href="#" class="text-small forgot-password text-black">Forgot Password</a>
                  </div>
                  <!-- <div class="form-group">
                    <button class="btn btn-block g-login">
                      <img class="mr-3" src="./src/assets/images/file-icons/icon-google.svg" alt="">Log in with Google</button>
                  </div> -->
                  <!-- <div class="text-block text-center my-3">
                    <span class="text-small font-weight-semibold">Not a member ?</span>
                    <a href="register.html" class="text-black text-small">Create new account</a>
                  </div> -->
                </form>
              </div>
              <ul class="auth-footer">
                <li>
                  <a href="#">Conditions</a>
                </li>
                <li>
                  <a href="#">Help</a>
                </li>
                <li>
                  <a href="#">Terms</a>
                </li>
              </ul>
              <p class="footer-text text-center">copyright © 2021 #. All rights reserved.</p>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="./assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="./assets/vendors/js/vendor.bundle.addons.js"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="./assets/js/shared/off-canvas.js"></script>
    <!-- <script src="./src/assets/js/shared/misc.js"></script> -->
    <!-- endinject -->
    <!-- <script src="./assets/js/shared/jquery.cookie.js" type="text/javascript"></script> -->
  </body>
</html>

<!-- ligin php code strat -->
<?php
   require 'include/config.php';
   if($_SERVER["REQUEST_METHOD"] == "POST")
   {
        
        // username and password sent from form
        $user = $_POST['username'];

        $password = $_POST['password'];
        $password =md5($password);

         $sql ="SELECT * FROM user WHERE username= '$user' and password = '$password'";
         $result=mysqli_query($conn,$sql);
         $row = mysqli_fetch_assoc($result);
         $count =mysqli_num_rows($result); // if uname/pass correct it returns must be 1 ro
         
         if($count == 1 )
         {
            session_regenerate_id();
            $_SESSION['user_role'] = $row['user_role'];
            $_SESSION['username'] = $user;
            session_write_close();

            if($row['user_role']==2){
              //header('Location: content/progress.php');
              echo "<script type='text/javascript'>window.location = \"content/renewing.php\"</script>";
             }else{
              //header('Location: content/home.php');
              echo "<script type='text/javascript'>window.location = \"content/mortgage.php\"</script>";
             }
        
                 
         }
         else
         {
            echo "<script type='text/javascript'>alert('Incorrect Credentials, Try again...');window.location = \"index.php\"</script>";
         }
   }
?>
<!-- ligin php code end -->





