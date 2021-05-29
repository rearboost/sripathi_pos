<?php
include('../include/config.php');

  if(isset($_GET['msg_id'])){

    $msg_id = $_GET['msg_id'];
    $sql=mysqli_query($conn,"SELECT * FROM customer C INNER JOIN jobs J ON C.id=J.customerId WHERE jobId='$msg_id'");  
    $row = mysqli_fetch_assoc($sql);
    $status = $row['status'];
  }
?>
<!DOCTYPE html>
<html>
    <?php include('../include/head.php'); ?>
<body>
<div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <!-- include nav code here -->
      <?php  include('../include/nav.php');   ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <!-- include sidebar code here -->
        <?php  include('../include/sidebar.php');   ?>

        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <!-- Page Title Header Starts-->
            <div class="row page-title-header">
              <div class="col-12">
                <div class="page-header">
                  <h4 class="page-title">Dashboard</h4>
                  <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
                    <!-- <ul class="quick-links">
                      <li><a href="#">ICE Market data</a></li>
                      <li><a href="#">Own analysis</a></li>
                      <li><a href="#">Historic market data</a></li>
                    </ul>
                    <ul class="quick-links ml-auto">
                      <li><a href="#">Settings</a></li>
                      <li><a href="#">Analytics</a></li>
                      <li><a href="#">Watchlist</a></li>
                    </ul> -->
                  </div>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Ongoing Job Progress</h4>

                    <div class="table-responsive"> 
                    <table class="table">
                      <thead>
                        <tr>
                          <th> # </th>
                          <th> Customer </th>
                          <th> Order </th>
                          <th> Job </th>
                          <th> Progress </th>
                          <th> Deadline </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                          $sql=mysqli_query($conn,"SELECT * FROM customer C INNER JOIN jobs J ON C.id=J.customerId WHERE J.status='technician'");
                          
                          $numRows = mysqli_num_rows($sql); 
                    
                          if($numRows > 0) {
                            $i = 1;
                            while($row = mysqli_fetch_assoc($sql)) {

                            $name    = $row['name'];   
                            $order    = $row['jobNo'];   
                            $accessory   = $row['accessory'];
                            $progress = $row['progress'];
                            $delivery_date  = $row['delivery_date'];
                            //$day = $delivery_date->format('Y-m-d');

                              echo ' <tr>';
                              echo ' <td>'.$i.' </td>';
                              echo ' <td>'.$name.' </td>';
                              echo ' <td>'.$order.' </td>';
                              echo ' <td>'.$accessory.' </td>';

                            if($progress>=75){
                                echo ' <td>
                                <div class="progress">
                                  <div class="progress-bar bg-primary" role="progressbar" style="width:'.$progress.'%" aria-valuenow="'.$progress.'" aria-valuemin="0" aria-valuemax="100">
                                  </div>
                                </div> 
                                </td>';
                              }else if($progress>=50){
                                echo ' <td>
                                <div class="progress">
                                  <div class="progress-bar bg-success" role="progressbar" style="width:'.$progress.'%" aria-valuenow="'.$progress.'" aria-valuemin="0" aria-valuemax="100">
                                  </div>
                                </div> 
                                </td>';
                              }else if($progress>=25){
                                echo ' <td>
                                <div class="progress">
                                  <div class="progress-bar bg-warning" role="progressbar" style="width:'.$progress.'%" aria-valuenow="'.$progress.'" aria-valuemin="0" aria-valuemax="100">
                                  </div>
                                </div> 
                                </td>';
                              }else if($progress>=0){
                                echo ' <td>
                                <div class="progress">
                                  <div class="progress-bar bg-danger" role="progressbar" style="width:'.$progress.'%" aria-valuenow="'.$progress.'" aria-valuemin="0" aria-valuemax="100">
                                  </div>
                                </div> 
                                </td>';
                              }
                              echo ' <td>'.$delivery_date.'</td>';
                              echo ' </tr>';
                              $i++;
                            }
                          }
                        ?>
                      </tbody>
                    </table>
                    </div>
                  </div>
                </div>
              </div>

              <!-- <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="p-4 pr-5 border-bottom bg-light d-flex justify-content-between">
                    <h4 class="card-title mb-0">Job status chart</h4>
                    <id id="pie-chart-legend" class="mr-4"></id>
                  </div>
                  <div class="card-body d-flex">
                    <canvas class="my-auto" id="pieChart" height="130"></canvas>
                  </div>
                </div>
              </div>-->
            </div> 

            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">All Jobs</h4>
                    
                    <div class="table-responsive">          
                    <table id="myTable" class="table table-bordered">
                      <thead>
                        <tr>
                          <th> # </th>
                          <th>Customer</th>
                          <th>Order</th>
                          <th>Accessory </th>
                          <th>Job Desc</th>
                          <th>Request Date</th>
                          <th>Delivery Date</th>
                          <th>Status</th>
                          <!-- <th>SMS</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $sql=mysqli_query($conn,"SELECT * FROM customer C INNER JOIN jobs J ON C.id=J.customerId ORDER BY jobId DESC");
                          
                          $numRows = mysqli_num_rows($sql); 
                    
                          if($numRows > 0) {
                            $i = 1;
                            while($row = mysqli_fetch_assoc($sql)) {

                            $name    = $row['name'];   
                            $order    = $row['jobNo'];   
                            $accessory   = $row['accessory'];
                            $request_date = $row['request_date'];
                            $delivery_date  = $row['delivery_date'];
                            $job_desc   = $row['job_desc'];
                            $status = $row['status'];

                              echo ' <tr>';
                              echo ' <td>'.$i.' </td>';
                              echo ' <td>'.$name.' </td>';
                              echo ' <td>'.$order.' </td>';
                              echo ' <td>'.$accessory.' </td>';
                              echo ' <td>'.$job_desc.' </td>';
                              echo ' <td>'.$request_date.' </td>';
                              echo ' <td>'.$delivery_date.' </td>';
                              if($status=="request"){
                                echo ' <td><label class="badge badge-success">'."request".'</label> </td>';
                              }else if($status=="technician"){
                                echo ' <td><label class="badge badge-warning">'."in progress".'</label> </td>';
                              }else if($status=="complete"){
                                echo ' <td><label class="badge badge-primary">'."complete".'</label> </td>';
                              }else if($status=="dispatch"){
                                echo ' <td><label class="badge badge-info">'."dispatch".'</label> </td>';
                              }else if($status=="reject"){
                                echo ' <td><label class="badge badge-danger">'."reject".'</label> </td>';
                              }else if($status=="finish"){
                                echo ' <td><label class="badge badge-dark">'."finished".'</label> </td>';
                              }
                              
                              // echo '<td class="td-center"><button type="button" onclick="SendMsg('.$row["jobId"].')" class="btn btn-primary btn-fw" name="send">Send SMS</button></td>';
                              echo ' </tr>';
                              $i++;
                            }
                          }
                        ?>
                      </tbody>
                    </table>
                    </div>
                  </div>
                </div>
              </div>
             
             
            </div>

          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->

          <!-- include footer coe here -->
          <?php include('../include/footer.php');   ?>

          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    
    <!-- include footer coe here -->
    <?php include('../include/footer-js.php');   ?>
</body>
</html>

<script>
  // function SendMsg(id){
  //     window.location.href = "home.php?msg_id=" + id;
  // }
  $(document).ready( function () {
      $('#myTable').DataTable();
  });
</script>