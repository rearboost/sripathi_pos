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
            $job_no  = $row['jobNo'];
            $billing_address  = $row['billing_address'];
            $accessory   = $row['accessory'];
            $brand   = $row['brand'];
            $model   = $row['model'];
            $serial_no   = $row['serial_no'];
            $request_date = $row['request_date'];
            $delivery_date  = $row['delivery_date'];
            $job_desc   = $row['job_desc'];
            $advance   = $row['advance'];
            $user_desc = $row['user_desc'];
            $service_cost = $row['service_cost'];
            $discount = $row['discount'];
            $cash_payment = $row['cash_payment'];
            $credit_payment = $row['credit_payment'];

            $sql_p=mysqli_query($conn,"SELECT SUM(qty*price) as Ad_amount FROM jobs J LEFT JOIN parts P ON J.jobId=P.jobID  WHERE J.jobID='$view_id' GROUP BY P.jobID");
                            
            while($row1 = mysqli_fetch_assoc($sql_p)) {

                $Ad_amount = $row1['Ad_amount'];
                if(empty($Ad_amount)){
                    $Ad_amount=0;
                }
                $amount = $service_cost+$Ad_amount;

                $total_amount = $amount-$advance;
            }
          }
        }
    }
    if(isset($_GET['bill_id'])){

        $bill_id = $_GET['bill_id'];

        $sql=mysqli_query($conn,"UPDATE jobs SET status='finish' WHERE jobId='$bill_id'");  
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
                      <li><a href="#"> POS</a></li>
                      <li><a href="#"> BILLING SERVICES</a></li>
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
                    <h4 class="card-title">Dispatch Jobs</h4>
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

                                                    if($customerName != $row['name']){
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
                                <label class="col-sm-3 col-form-label">Billing Address * Guest Customer purpose only</label>
                                <div class="col-sm-9">
                                  <textarea class="form-control" name="billing_address" rows="3" placeholder="Ex: Mr.Rashmika,
771234567,
N0:01,Galle rd,Panadura"><?php if(isset($_GET['view_id'])){ echo $billing_address;} ?></textarea>
                                </div>
                              </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">IMEI/Serial #</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" name="serial_no" placeholder="Serial #" value="<?php if(isset($_GET['view_id'])){ echo $serial_no;} ?>" readonly>
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
                            <label class="col-sm-3 col-form-label">Service Cost</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="service_cost" value="<?php if(isset($_GET['view_id'])){ echo $service_cost;} ?>" placeholder="LKR 0.00" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Other Cost</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="Ad_amount" value="<?php if(isset($_GET['view_id'])){ echo $Ad_amount;} ?>" placeholder="LKR 0.00" readonly/>
                                </div>
                            </div>
                        </div>
                        </div>

                        <?php if (isset($_GET['view_id'])): ?>
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Gross amount</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="amount" id="amount" value="<?php if(isset($_GET['view_id'])){ echo number_format($amount,2,'.',',');} ?>" placeholder="LKR 0.00" readonly/>
                                    <input type="hidden" name="amount_hidden" id="amount_hidden" value="<?php if(isset($_GET['view_id'])){echo $amount ;} ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Advanced</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="advance" id="advance" value="<?php if(isset($_GET['view_id'])){ echo $advance;} ?>" placeholder="LKR 0.00" readonly/>
                                </div>
                            </div>
                        </div>
                        </div>

                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Discount</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="discount" id="discount" onkeyup="TotalCalc()" value="<?php if(isset($_GET['view_id'])){ echo $discount;} ?>" placeholder="LKR 0.00" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Payable Amt</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="total_amount" id="total_amount" value="<?php if(isset($_GET['view_id'])){ echo $total_amount;} ?>" placeholder="LKR 0.00" readonly/>
                                </div>
                            </div>
                        </div>    
                        </div>

                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Cash Paid</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="cash_payment" id="cash" onkeyup="CreditCalc()" placeholder="LKR 0.00" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Credit</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name ="credit_payment" id="credit" placeholder="LKR 0.00" required/>
                                </div>
                            </div>
                        </div>
                        </div>

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
                          <input type="hidden" class="form-control" id="job_no" name="job_no" value="<?php if(isset($_GET['view_id'])){ echo $job_no;} ?>" />          
                          </div> <br><br>          
                          <!-- end -->

                        <?php else: ?>
                        <?php endif ?>


                       <?php if (isset($_GET['view_id'])): ?>
                          <input type="hidden" class="form-control" name="view_id" id="view_id" value="<?php if(isset($_GET['view_id'])){ echo $view_id;} ?>" />
                          <input type="hidden" class="form-control" name="req_update" value="req_update" />
                          <button type="submit" class="btn btn-info btn-fw">PRINT</button>
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
                    <h4 class="card-title">Ready To Dispatch</h4>
                    
                    <div class="table-responsive">          
                    <table id="myTable" class="table table-bordered">
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
                          <th>PUSH</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $sql=mysqli_query($conn,"SELECT * FROM customer C INNER JOIN jobs J ON C.id=J.customerId WHERE J.status='dispatch'");
                          
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
                            $payable_amt = $row['payable_amt'];

                              echo ' <tr>';
                              echo ' <td>'.$i.' </td>';
                              echo ' <td>'.$name.' </td>';
                              echo ' <td>'.$order.' </td>';
                              echo ' <td>'.$accessory.' </td>';
                              echo ' <td>'.$request_date.' </td>';
                              echo ' <td>'.$delivery_date.' </td>';
                              echo ' <td>'.$job_desc.' </td>';
                              echo '<td class="td-center"><button type="button" onclick="editForm('.$row["jobId"].')" class="btn btn-info btn-fw">Edit</button></td>';
                              if($payable_amt>0){
                              echo '<td class="td-center"><button type="button" onclick="pushForm('.$row["jobId"].')" name="push" class="btn btn-primary btn-fw">Finished</button></td>';
                              }else{
                              echo '<td class="td-center"><button type="button" onclick="pushForm('.$row["jobId"].')" name="push" class="btn btn-primary btn-fw" disabled>Finished</button></td>';
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
    
    var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;


    function TotalCalc(){

        var gross= $('#amount_hidden').val();
        var advance= $('#advance').val();
        var discount= $('#discount').val();

        if(numberRegex.test(discount)){

          var total = (Number(gross) - (Number(advance)+Number(discount))).toFixed(2)
          $('#total_amount').val(total);

        }else{

          if(discount!=''){
              swal({
              title: "Discount must be Number !",
              text: "Validation",
              icon: "error",
              button: "Ok !",
              });
              $('#discount').val('');
              var total = (Number(gross) - Number(advance)).toFixed(2)
              $('#total_amount').val(total);
          }
        }
    }

    function CreditCalc(){

        var total= $('#total_amount').val();
        var cash= $('#cash').val();
        
        if(numberRegex.test(cash)){

          var credit = (Number(total) - Number(cash)).toFixed(2)
          $('#credit').val(credit);

        }else{

          if(cash!=''){
              swal({
              title: "Payment must be Number !",
              text: "Validation",
              icon: "error",
              button: "Ok !",
              });
              $('#cash').val('');
              $('#credit').val(total);
          }
        }

    }
  
    ////////////////////// Form Submit Add  /////////////////////////////

    $(function () {

        $('#requestAdd').on('submit', function (e) {

          e.preventDefault();

          var job_id= $('#job_id').val();

              $.ajax({
                type: 'post',
                url: '../controller/dispatch_controller.php',
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
                          //setTimeout(function(){ location.reload(); }, 2500);
                          setTimeout(function(){window.open('invoice_print?id='+job_id, '_blank'); }, 100);

                          setTimeout(function(){ location.reload(); }, 2500);
                    }
                }
              });


        });
      });

    function editForm(id){
        window.location.href = "billing_service.php?view_id=" + id;
    }

    function cancelForm(){
        window.location.href = "billing_service.php";
    }

    function pushForm(id) {

      $.ajax({
        url:"../controller/dispatch_controller.php",
        method:"POST",
        data:{addfinish_job_edit:id},
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

    // print bill //////
    function printForm(id){
      window.open('invoice_print?id='+id, '_blank');

      // window.onafterprint = function(){
      //   //alert(id)
      //   window.location.href = "billing_service.php?bill_id=" + id;
      //   // $(window).off(window.onafterprint);
      //   // console.log('Print Dialog Closed..');
      // };
    }

    // function printForm(){

    //     var invoice  ="invoice";
    
    //     var amount= $('#amount').val();
    //     var discount= $('#discount').val();
    //     var total_amount= $('#total_amount').val();
    //     var cash= $('#cash_payment  ').val();
    //     var credit= $('#credit_payment').val();
    //     var job_id= $('#job_id').val();
    //     var job_no= $('#job_no').val();

    //     //if(payment!='' && numberRegex.test(payment)){

    //         $.ajax({
    //             type: 'post',
    //             url: '../controller/dispatch_controller.php',
    //             data: {invoice:invoice,amount:amount,discount:discount,total_amount:total_amount,cash:cash,credit:credit},
    //             success: function (data) {

    //                 setTimeout(function(){window.open('print?id='+inv_id, '_blank'); }, 100);

    //                 setTimeout(function(){ location.reload(); }, 2500);

    //             } 
    //         });  
    //     //}
    // }




</script>




