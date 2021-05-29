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
                      <li><a href="#"> | Mortgage Section</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <!-- Page Title Header Ends-->
            <form class="form-sample" id="mortgageAdd">
              <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                    <h4 class="card-title">Mortage Form</h4>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Date of mortgage</label>
                                <div class="col-sm-9">
                                  <input type="date" class="form-control" name="mortageDate" value="<?php if(isset($_GET['view_id'])){ echo $mortageDate;}else{echo date("Y-m-d");} ?>"/>
                                </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Date of rescue</label>
                                <div class="col-sm-9">
                                  <input type="date" class="form-control" name="rescueDate" value="<?php if(isset($_GET['view_id'])){ echo $rescueDate;} ?>"/>
                                </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Customer</label>
                                    <div class="col-sm-8">
                                    <input list="brow" class="form-control" id="customer" required>
                                      <datalist id="brow">
                                        <?php
                                            $custom = "SELECT * FROM customer";
                                            $result = mysqli_query($conn,$custom);
                                            $numRows = mysqli_num_rows($result); 
                            
                                            if($numRows > 0) {
                                                while($row = mysqli_fetch_assoc($result)) {
                                                    echo '<option value ="'.$row["name"].'">';
                                                }
                                            }
                                        ?>
                                      </datalist> 
                                    </div>

                                    <div class="col-sm-1 size">
                                        <i class="fa fa-plus-circle pointer" onclick="customerForm()"></i>   
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Address</label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" id="address" readonly required>
                                    <input type="hidden" class="form-control" name="customerID" id="customerID">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">NIC</label>
                                    <div class="col-sm-4">
                                    <input type="text" class="form-control" id="nic" readonly required>
                                    </div>

                                    <label class="col-sm-1.5 col-form-label">Tel &nbsp; &nbsp; </label>
                                    <div class="col-sm-3.5">
                                    <input type="text" class="form-control" id="contact" readonly required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Item Details</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="itemDetail" rows="5" placeholder="Short description about this item.."><?php if(isset($_GET['view_id'])){ echo $itemDetail;} ?></textarea>
                                    <?php
                                    $get_id = mysqli_query($conn, "SELECT M_id FROM mortgage ORDER BY M_id DESC LIMIT 1");

                                    $data = mysqli_fetch_assoc($get_id);

                                    $next_id = $data['M_id']+1;
                                    ?>
                                    <input type="hidden" id="mid" value="<?php echo $next_id; ?>">
                                </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Weight </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="weight" value="<?php if(isset($_GET['view_id'])){ echo $weight;} ?>" placeholder="weight"/>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Interest rate </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name ="interestRate" value="<?php if(isset($_GET['view_id'])){ echo $interestRate;} ?>" placeholder="per month(%)"/>
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Time period</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="timePeriod" value="<?php if(isset($_GET['view_id'])){ echo $timePeriod;} ?>" maxlength="10" minlength="8" placeholder="dd/mm/yyyy"/ onkeyup="this.value=this.value.replace(/^(\d\d)(\d)$/g,'$1/$2').replace(/^(\d\d\/\d\d)(\d+)$/g,'$1/$2').replace(/[^\d\/]/g,'')">
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Mortgage advance</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name ="mortageAdvance" value="<?php if(isset($_GET['view_id'])){ echo $mortageAdvance;} ?>" placeholder="LKR.0.00"/>
                            </div>
                            </div>
                        </div>
                        </div>

                       <!-- <?php // if (isset($_GET['view_id'])): ?>
                          <input type="hidden" class="form-control" name="view_id" id="view_id" value="<?php // if(isset($_GET['view_id'])){ echo $view_id;} ?>" /> -->
                          <input type="hidden" class="form-control" name="req_add" value="req_add" />
                          <button type="submit" class="btn btn-info btn-fw">PRINT</button>
                          <button type="button" onclick="cancelForm()" class="btn btn-primary btn-fw">Cancel</button>
                      <!-- <?php // else: ?>
                      <?php // endif ?> -->
                  
                    </div>
                  </div>
                </div>
              </div>                
            </form>

            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Mortage details</h4>
                    
                    <div class="table-responsive">          
                    <table id="myTable" class="table table-bordered">
                      <thead>
                        <tr>
                          <th> # </th>
                          <th>Customer</th>
                          <th>Mortgage Date</th>
                          <th>Rescue Date </th>
                          <th>Weight(mg)</th>
                          <th>Interest Rate(%)</th>
                          <th>Time Period</th>
                          <th>Mortgage Advance</th>
                          <th>Print</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $sql=mysqli_query($conn,"SELECT * FROM customer C INNER JOIN mortgage M ON C.id=M.customerID ORDER BY M_id DESC");
                          
                          $numRows = mysqli_num_rows($sql); 
                    
                          if($numRows > 0) {
                            $i = 1;
                            while($row = mysqli_fetch_assoc($sql)) {

                            $name            = $row['name'];
                            $mortgageDate    = $row['mortgageDate'];   
                            $rescueDate      = $row['rescueDate'];
                            $itemDetail      = $row['itemDetail'];
                            $weight          = $row['weight'];
                            $interestRate    = $row['interestRate'];
                            $timePeriod      = $row['timePeriod'];
                            $mortgageAdvance = $row['mortgageAdvance'];

                              echo ' <tr>';
                              echo ' <td>'.$i.' </td>';
                              echo ' <td>'.$name.' </td>';
                              echo ' <td>'.$mortgageDate.' </td>';
                              echo ' <td>'.$rescueDate.' </td>';
                              //echo ' <td>'.$itemDetail.' </td>';
                              echo ' <td>'.$weight.' </td>';
                              echo ' <td>'.$interestRate.' </td>';
                              echo ' <td>'.$timePeriod.' </td>';
                              echo ' <td>'.$mortgageAdvance.' </td>';
                              //echo '<td class="td-center"><button type="button" onclick="editForm('.$row["M_id"].')" class="btn btn-info btn-fw">Edit</button></td>';
                              
                              echo '<td class="td-center"><button type="button" onclick="printForm('.$row["M_id"].')" name="print" class="btn btn-primary btn-fw">PRINT</button></td>';
                              
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
    
    //var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;

    $('#customer').on('change',function(){

        var customerID = this.value;
        $.ajax({
            type: 'post',
            url: '../functions/get_customerDetail.php',
            data: {customerID:customerID},
            success: function (response) {

                var obj = JSON.parse(response);

                var id      = obj.id
                var address = obj.address
                var nic     = obj.nic
                var contact = obj.contact

                $('#customerID').val(id);
                $('#address').val(address);
                $('#nic').val(nic);
                $('#contact').val(contact);

            }
        });
    });

    ////////////////////// Form Submit Add  /////////////////////////////

    $(function () {

        $('#customerAdd').on('submit', function (e) {

          e.preventDefault();

          $.ajax({
            type: 'post',
            url: '../controller/customer_controller.php',
            data: $('#customerAdd').serialize(),
            success: function (data) {
                  if(data==0){

                    swal({
                      title: "Can't Duplication !",
                      text: "Customer",
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

    ///////////////////////////////////////////////////

    $(function () {

        $('#mortgageAdd').on('submit', function (e) {

          e.preventDefault();

          var mid= $('#mid').val();

              $.ajax({
                type: 'post',
                url: '../controller/mortgage_controller.php',
                data: $('#mortgageAdd').serialize(),
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
                          //setTimeout(function(){window.open('receipt?id='+mid, '_blank'); }, 100);

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
      window.open('receipt?id='+id, '_blank');

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

    function customerForm(){
        $('#myModal').modal('show');
    }


</script>

<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Customer Register</h4>
        </div>
        <div class="modal-body">
          <div class="card">
            <div class="card-body">
            <!-- <h4 class="card-title">Customer Register</h4> -->
            <!-- <p class="card-description"> Basic form elements </p> -->
            <form class="forms-sample" id="customerAdd">
                <div class="form-group">
                <label for="exampleInputName1">Name</label>
                <input type="text" class="form-control" name="name" placeholder="customer name here.." required>
                </div>
                <div class="form-group">
                <label for="exampleTextarea1">Address</label>
                <textarea class="form-control" name="address" rows="2" placeholder="customer address here.."></textarea>
                </div>
                <div class="form-group">
                <label for="exampleInputEmail3">NIC No</label>
                <input type="text" class="form-control" name="nic" required>
                </div>
                <div class="form-group">
                <label for="exampleInputName1">Tel No</label>
                <input type="number" class="form-control" name="contact" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "10" minlength="10"required>
                </div>
                <input type="hidden" class="form-control" name="add" value="add" />
                <button type="submit" class="btn btn-success mr-2">Submit</button>
                <!-- <button class="btn btn-light">Cancel</button> -->
            </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


