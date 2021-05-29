<!DOCTYPE html>
<html lang="en">
 <?php
    // Database Connection
    require '../include/config.php';
  ?>
  <!-- include head code here -->
  <?php  include('../include/head.php');   ?>
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
                      <li><a href="#"> REPORT</a></li>
                      <li><a href="#"> JOB STATUS REPORT</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <!-- Page Title Header Ends-->
            <div class="col-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                    <h4 class="card-title">Job Status report</h4>
                    <!-- <p class="card-description"> Horizontal form layout </p> -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Status</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="status" id="status" required>
                                            <option value="">--Select Status--</option>
                                            <?php
                                                $custom = "SELECT DISTINCT(status) FROM jobs";
                                                $result = mysqli_query($conn,$custom);
                                                $numRows = mysqli_num_rows($result); 
                                
                                                if($numRows > 0) {
                                                    while($row = mysqli_fetch_assoc($result)) {
                                                    echo '<option value ="'.$row["status"].'">' . $row["status"] . '</option>';
                                                    
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <button type="button" onclick="cancelForm()" class="btn btn-warning btn-fw">Cancel</button>                        
                            </div>
                        </div>
                  </div>
                </div>
            </div>
            <br>

            <?php if (isset($_GET['view_id'])): ?>
            
            <form class="forms-sample" id="report_form">

                <input type="hidden" value ='<?php echo $_GET['view_id']; ?>' name="status">

                <div class="col-lg-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                        <center><b><h5>Status - <?php echo $_GET['view_id']; ?></h5></b></center>
                        <br>
                        <div class="row">
                    
                        <?php 

                          $state = $_GET['view_id'];
                        //   $sql_buyerName=mysqli_query($conn,"SELECT * FROM po_entering WHERE status='$poNo'");
                        //   $row_buyerName= mysqli_fetch_assoc($sql_buyerName);
                        //   $bpo_no = $row_buyerName['bpo_no'];

                          $sql=mysqli_query($conn,"SELECT * FROM customer C INNER JOIN jobs J ON C.id=J.customerId WHERE J.status='$state'"); 
                    
                        ?>

                       <!-- <h4 class="card-title">Materials</h4> -->
                        <div class="table-responsive">
                            <div id="printablediv">
                            <table class="table table-bordered" id="costing_bom_table">
                                <thead>
                                    <tr>
                                    <th> # </th>
                                    <th>Name </th>
                                    <th>accessory</th>
                                    <!-- <th>job_desc </th> -->
                                    <th>request_date</th>
                                    <th>delivery_date </th>
                                    <!-- <th>user_desc </th> -->
                                    <th>service_cost </th>
                                    <th>acessories_cost </th>
                                    <th>Amount </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    
                                    $numRows = mysqli_num_rows($sql); 
                                
                                    if($numRows > 0) {
                                        $i = 1;

                                        while($row = mysqli_fetch_assoc($sql)) {

                                        $value = 0;
                                        $name  = $row['name'];
                                        $accessory   = $row['accessory'];
                                        $job_desc = $row['job_desc'];
                                        $request_date = $row['request_date'];
                                        $delivery_date = $row['delivery_date'];
                                        $user_desc = $row['user_desc'];
                                        $service_cost = $row['service_cost'];
                                        $jobId = $row['jobId'];


                                        $cost =mysqli_query($conn, "SELECT SUM(qty*price) as acessories_cost FROM parts WHERE jobID='$jobId'");
                                        $cost_data = mysqli_fetch_assoc($cost);
                                        $acessories_cost = $cost_data['acessories_cost'];

                                        if(empty($acessories_cost)){
                                          $acessories_cost=0.00;
                                        }

                                        $value =number_format(($service_cost+$acessories_cost), 2, '.', ',');

                                        echo ' <tr>';
                                        echo ' <td>'.$i.' </td>';
                                        echo ' <td>'.$name.' </td>';
                                        echo ' <td>'.$accessory.' </td>';
                                        //echo ' <td>'.$job_desc.' </td>';
                                        echo ' <td>'.$request_date.' </td>';
                                        echo ' <td>'.$delivery_date.' </td>';
                                        //echo ' <td>'.$user_desc.' </td>';
                                        echo ' <td>'.$service_cost.' </td>';
                                        echo ' <td>'.number_format($acessories_cost, 2, '.', ',').' </td>';
                                        echo ' <td>'.$value.' </td>';
                                        echo ' </tr>';
                                        $i++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            </div>
                            <br>
                             
                            <button type="button"  onclick="javascript:printDiv('printablediv');" class="btn btn-info btn-fw" >PRINT</button>   
                            <br>
                            <br>                       
                        </div> 
                   </div>
                 </div>
               </div>
              </div>
            </form>
           <?php else: ?>

           <?php endif ?>
            
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
   
    ////////////// status get  ///////////////////////
    $("#status").on('change',function(){

      var status = $(this).val();
      if(status){     
        window.location.href = "report_jobs.php?view_id=" + status;
      }
    });

    function cancelForm(){

        window.location.href = "report_jobs.php";
    }

    function printDiv(divID)
    {
     
        //Get the HTML of div
        var divElements = document.getElementById(divID).innerHTML;
        //Get the HTML of whole page
        var oldPage = document.body.innerHTML;

        //Reset the page's HTML with div's HTML only
        document.body.innerHTML =
            "<html><head><title></title></head><body>" +
            divElements + "</body>";

        //Print Page
        window.print();

        //Restore orignal HTML
        document.body.innerHTML = oldPage;

    }


  </script>