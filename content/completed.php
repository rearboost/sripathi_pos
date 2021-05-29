<!DOCTYPE html>
<html lang="en">
  <?php
    // Database Connection
    require '../include/config.php';

     // Get Update Form Data
    if(isset($_GET['view_id'])){

        $view_id = $_GET['view_id'];

        $sql=mysqli_query($conn,"SELECT * FROM customer C INNER JOIN jobs J ON C.id=J.customerId WHERE J.jobId='$view_id'");  
        $numRows = mysqli_num_rows($sql); 
        if($numRows > 0) {
          while($row = mysqli_fetch_assoc($sql)) {

            $id  = $row['id'];
            $customerName  = $row['name'];
            $accessory   = $row['accessory'];
            $brand   = $row['brand'];
            $model   = $row['model'];
            $request_date = $row['request_date'];
            $delivery_date  = $row['delivery_date'];
            $job_desc   = $row['job_desc'];
            $advance   = $row['advance'];
            $user_desc = $row['user_desc'];
            $service_cost = $row['service_cost'];

            $sql_p=mysqli_query($conn,"SELECT * FROM jobs J LEFT JOIN parts P ON J.jobId=P.jobID  WHERE J.jobID='$view_id'");
                            
            while($row1 = mysqli_fetch_assoc($sql_p)) {

                $parts = $row1['parts'];
                $imei = $row1['imei'];
                $qty = $row1['qty'];
                $price = $row1['price'];
            }
          }
        }
    }

  ?>
  <!-- include head code here -->
  <?php  include('../include/head.php');   ?>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <body>
    <div class="container-scroller">
      <!-- partial:../../partials/_navbar.html -->
      <!-- include nav code here -->
      <?php  include('../include/nav.php');   ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_sidebar.html -->
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
                    <ul class="quick-links">
                      <li><a href="#"> JOBS</a></li>
                      <li><a href="#"> COMPLETED JOBS</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <!-- Page Title Header Ends-->
            <form class="form-sample" id="requestAdd">
              <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                    <h4 class="card-title">Completed Jobs</h4>
                        <p class="card-description">Job Info</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Customer</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="customer" name="customer" readonly>
                                            <?php
                                                $custom = "SELECT * FROM customer";
                                                $result = mysqli_query($conn,$custom);
                                                $numRows = mysqli_num_rows($result); 

                                                if(isset($_GET['view_id'])){
                                                echo "<option value = ".$id.">" . $customerName . "</option>";
                                                }
                                                echo "<option value=''>--Select Customer--</option>";
                                                if($numRows > 0) {
                                                while($row = mysqli_fetch_assoc($result)) {
                                                    if(isset($_GET['view_id'])){

                                                    if($buyerName != $row['name']){
                                                        echo "<option value = ".$row['id'].">" . $row['name'] . "</option>";
                                                    }

                                                    }else{
                                                    echo "<option value = ".$row['id'].">" . $row['name'] . "</option>";
                                                    }
                                                }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Accessory</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name ="accessory" value="<?php if(isset($_GET['view_id'])){ echo $accessory;} ?>" placeholder="Accessorry name" readonly/>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Brand </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name ="brand" value="<?php if(isset($_GET['view_id'])){ echo $brand;} ?>" placeholder="brand" readonly/>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Model </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name ="model" value="<?php if(isset($_GET['view_id'])){ echo $model;} ?>" placeholder="model" readonly/>
                            </div>
                            </div>
                        </div>
                        </div>
                        
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Request Date </label>
                            <div class="col-sm-9">
                                <input type="Date" class="form-control" name ="request_date" value="<?php if(isset($_GET['view_id'])){ echo $request_date;} ?>" readonly/>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Delivery Date </label>
                            <div class="col-sm-9">
                                <input type="Date" class="form-control" name ="delivery_date" value="<?php if(isset($_GET['view_id'])){ echo $delivery_date;} ?>" readonly/>
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Job Description</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="job_desc" rows="4" placeholder="Short description about this job.." readonly><?php if(isset($_GET['view_id'])){ echo $job_desc;} ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">User Description</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="user_desc" rows="4" placeholder="Technician purpose only.." readonly><?php if(isset($_GET['view_id'])){ echo $user_desc;} ?></textarea>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Advanced</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name ="advance" value="<?php if(isset($_GET['view_id'])){ echo $advance;} ?>" placeholder="LKR 0.00" readonly/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Service Cost</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name ="service_cost" value="<?php if(isset($_GET['view_id'])){ echo $service_cost;} ?>" placeholder="LKR 0.00" required/>
                                </div>
                            </div>
                        </div>
                        </div>

                        <?php if (isset($_GET['view_id'])): ?>
                        <p>Added accessories Info :</p>
                        <div id="here">
                          <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Part</th>
                                    <th>IMEI</th>
                                    <th>QTY</th>
                                    <th>PRICE</th> 
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    $sql_temp=mysqli_query($conn,"SELECT * FROM parts WHERE jobID='$view_id'");
                                    
                                      $numRows = mysqli_num_rows($sql_temp); 
                                
                                      if($numRows > 0) {
                                        
                                        $i = 1;
                              
                                        while($row = mysqli_fetch_assoc($sql_temp)) {

                                          $parts = $row['parts'];
                                          $imei   = $row['imei'];
                                          $qty   = $row['qty'];
                                          $price   = $row['price'];
                                          $id   = $row['id'];

                                          echo ' <tr>';
                                          echo ' <td>'.$i.' </td>';
                                          echo ' <td>'.$parts.' </td>';
                                          echo ' <td>'.$imei.' </td>';
                                          echo ' <td>'.$qty.' </td>';
                                          echo ' <td>'.$price.' </td>';
                                          echo ' </tr>';
                                          $i++;

                                        }
                                      }
                                      
                                    ?>
                                  </tbody>

                            </table>
                          </div> 
                          
                          <input type="hidden" class="form-control" id="job_id" name="job_id" value="<?php if(isset($_GET['view_id'])){ echo $view_id;} ?>" />          
                          </div> <br><br>          
                          <!-- end -->

                        <?php else: ?>
                        <?php endif ?>


                       <?php if (isset($_GET['view_id'])): ?>
                          <input type="hidden" class="form-control" name="view_id" value="<?php if(isset($_GET['view_id'])){ echo $view_id;} ?>" />
                          <input type="hidden" class="form-control" name="req_update" value="req_update" />
                          <button type="submit" class="btn btn-info btn-fw">Update</button>
                          <button type="button" onclick="cancelForm()" class="btn btn-primary btn-fw">Cancel</button>
                      <?php else: ?>
                      <?php endif ?>
                  
                    </div>
                  </div>
                </div>
              </div>                
            </form>

            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Completed Job Data</h4>
                    
                    <div class="table-responsive">          
                    <table  id="myTable" class="table table-bordered">
                      <thead>
                        <tr>
                          <th> # </th>
                          <th>Customer</th>
                          <th>Order</th>
                          <th>Accessory </th>
                          <th>Request Date</th>
                          <th>Delivery Date</th>
                          <th>Job Desc</th>
                          <th>Edit</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $sql=mysqli_query($conn,"SELECT * FROM customer C INNER JOIN jobs J ON C.id=J.customerId WHERE J.status='complete'");
                          
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
                            $user_desc = $row['user_desc'];
                            $service_cost = $row['service_cost'];
                            $jobId = $row['jobId'];

                            $cost =mysqli_query($conn, "SELECT SUM(qty*price) as acessories_cost FROM parts WHERE jobID='$jobId'");
                            $cost_data = mysqli_fetch_assoc($cost);
                            $acessories_cost = $cost_data['acessories_cost'];

                              echo ' <tr>';
                              echo ' <td>'.$i.' </td>';
                              echo ' <td>'.$name.' </td>';
                              echo ' <td>'.$order.' </td>';
                              echo ' <td>'.$accessory.' </td>';
                              echo ' <td>'.$request_date.' </td>';
                              echo ' <td>'.$delivery_date.' </td>';
                              echo ' <td>'.$job_desc.' </td>';
                              echo '<td class="td-center"><button type="button" onclick="editForm('.$row["jobId"].')" class="btn btn-info btn-fw">Edit</button></td>';
                              if($service_cost>'0.00' || $acessories_cost>'0.00'){
                                echo '<td class="td-center"><button type="button" onclick="pushForm('.$row["jobId"].')" class="btn btn-success btn-fw">Dispatched</button></td>';
                              }else{
                                echo '<td class="td-center"><button type="button" onclick="pushForm('.$row["jobId"].')" class="btn btn-success btn-fw" disabled>Dispatched</button></td>';
                              }
                              
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
            <!-- content-wrapper ends -->
            <!-- partial:../../partials/_footer.html -->
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
    $(document).ready( function () {
      $('#myTable').DataTable();
    });
  
    /////////////////////////////////////////////////// Form Submit Add  

    $(function () {

        $('#requestAdd').on('submit', function (e) {

          e.preventDefault();

          $.ajax({
            type: 'post',
            url: '../controller/complete_controller.php',
            data: $('#requestAdd').serialize(),
            success: function (data) {

                if(data==0){

                    swal({
                      title: "Can't Duplication !",
                      text: "Jobs",
                      icon: "error",
                      button: "Ok !",
                    });

                }else{

                    swal({
                      title: "Good job !",
                      text: "Successfully Submited",
                      icon: "success",
                      button: "Ok !",
                      });
                      setTimeout(function(){ location.reload(); }, 2500);
                }
            }
          });

        });
      });

    function editForm(id){
        window.location.href = "completed.php?view_id=" + id;
    }

    function cancelForm(){
        window.location.href = "completed.php";
    }

    function pushForm(id) {

      $.ajax({
        url:"../controller/complete_controller.php",
        method:"POST",
        data:{adddispatch_job_edit:id},
        success:function(data){

          if(data==0){

              swal({
                title: "Can't Push to next level!",
                text: "Incompleted",
                icon: "error",
                button: "Ok !",
              });

          }else{

              swal({
                title: "Good job !",
                text: "Successfully pushed",
                icon: "success",
                button: "Ok !",
                });
                setTimeout(function(){ location.reload(); }, 2500);
          }
        }
     });
   }


  </script>




