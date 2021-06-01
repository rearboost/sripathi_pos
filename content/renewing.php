<!DOCTYPE html>
<html lang="en">
  <?php
    // Database Connection
    require '../include/config.php';

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
                      <li><a href="#"> | RENEWING</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <!-- Page Title Header Ends-->
            <form class="form-sample" id="renewingForm">
              <div class="row">
                <div class="col-lg-7 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                    <h3 class="card-title">Renewing form</h3>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Date </label>
                                <div class="col-sm-9">
                                  <input type="date" class="form-control" name="renewDate" id="renewDate" value="<?php echo date("Y-m-d"); ?>"/>
                                </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Customer</label>
                                <div class="col-sm-9">
                                <input list="brow" class="form-control" id="customer" name="customer" required>
                                  <datalist id="brow">
                                    <?php
                                        $custom = "SELECT C.name FROM customer C INNER JOIN mortgage M ON C.id=M.customerID WHERE M.status='1'";
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
                            </div>
                            </div>
                          </div>
                          <?php
                          $get_id = mysqli_query($conn, "SELECT id FROM renewing ORDER BY id DESC LIMIT 1");

                          $data = mysqli_fetch_assoc($get_id);

                          $next_id = $data['id']+1;
                          ?>
                          <input type="hidden" id="rid" value="<?php echo $next_id; ?>"/>
                          <input type="hidden" name="mid" id="mid" />
                                

                        <div class="row">
                          <div class="col-md-12">
                              <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Interest </label>
                              <div class="col-sm-9">
                                  <input type="text" class="form-control" name="interest"  id="interest" placeholder="Interest"/>
                              </div>
                              </div>
                          </div>
                        </div>
                        <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Payment</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name ="payment" id ="payment"  placeholder="LKR.0.00"/>
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Renew Amount</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="renewAmt"  id="renewAmt" placeholder="LKR.0.00"/>
                                <input type="hidden" class="form-control" name="totalPaid"  id="totalPaid" placeholder="LKR.0.00"/>
                            </div>
                            </div>
                        </div>
                        </div>
                          <input type="hidden" class="form-control" name="add" value="add" />
                          <button type="submit" class="btn btn-info btn-fw">PRINT</button>
                          <button type="button" onclick="cancelForm()" class="btn btn-primary btn-fw">Cancel</button>
                      
                    </div>
                  </div>
                </div>

                <div class="col-lg-5 grid-margin stretch-card">
                  <div class="card" style="padding:0px;width: 100%;height: 400px;overflow-x: hidden;overflow-y: auto;">
                    <div class="card-body">
                      <h5 class="card-title" style="text-align: center;">Pawning Details..</h5>
                      <div class="card-scroll">
                        <div id="detail_section"></div>
                        
                      </div>
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
                          <th style="display:none;"> # </th>
                          <th> # </th>
                          <th>Customer</th>
                          <th>NIC</th>
                          <th>Renew Date</th>
                          <th>Payment </th>
                          <th>Total Paid</th>
                          <th>Renew Amount</th>                          
                          <th>Print</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $sql=mysqli_query($conn,"SELECT * FROM renewing ORDER BY id DESC");
                          
                          $numRows = mysqli_num_rows($sql); 
                    
                          if($numRows > 0) {
                            $i = 1;
                            while($row = mysqli_fetch_assoc($sql)) {

                            $pawningId      = $row['pawningID'];

                            $custom = mysqli_query($conn, "SELECT C.name as name,C.nic as nic FROM customer C INNER JOIN mortgage M ON C.id = M.customerID WHERE M.M_id='$pawningId' ");
                            $row1 = mysqli_fetch_assoc($custom);

                              $name     = $row1['name'];
                              $nic      = $row1['nic'];

                              $id         = $row['id'];
                              $renewDate  = $row['renewDate'];   
                              $payment    = $row['payment'];
                              $total_paid = $row['total_paid'];
                              $renewAmt   = $row['renewAmt'];

                              echo ' <tr>';
                              echo ' <td style="display:none;">'.$i.' </td>';
                              echo ' <td>'.$id.' </td>';
                              echo ' <td>'.$name.' </td>';
                              echo ' <td>'.$nic.' </td>';
                              echo ' <td>'.$renewDate.' </td>';
                              echo ' <td>'.$payment.' </td>';
                              echo ' <td>'.$total_paid.' </td>';
                              echo ' <td>'.$renewAmt.' </td>';
                              //echo '<td class="td-center"><button type="button" onclick="editForm('.$row["M_id"].')" class="btn btn-info btn-fw">Edit</button></td>';
                              
                              echo '<td class="td-center"><button type="button" onclick="printForm('.$row["id"].')" name="print" class="btn btn-primary btn-fw">PRINT</button></td>';
                              
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

        var currentDate = $('#renewDate').val();
        var customer = this.value;
        $.ajax({
            type: 'post',
            url: '../functions/get_renewingDetail.php',
            data: {customer:customer},
            success: function (response) {

                var obj = JSON.parse(response);

                var timePeriod   = obj.timePeriod
                var rescueDate   = obj.rescueDate
                var interestRate = obj.interestRate
                var newAmount    = obj.newAmount
                var total_paid   = obj.total_paid
                var pre_date     = obj.pre_date
                var M_id     = obj.M_id

                $('#mid').val(M_id);

                const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds

                const firstDate = new Date(pre_date);
                const secondDate = new Date(currentDate);

                const diffDays = Math.round(Math.abs((firstDate - secondDate) / oneDay)); 
                var months = Math.round(Number(diffDays)/30);

                // alert(months)
                var tot_interest = (Number(newAmount)*Number(interestRate/100)*Number(months)).toFixed(2);
                $('#interest').val(tot_interest);

            }
        });

        $.ajax({
              url:"pawning_details.php",
              method:"POST",
              data:{"customer":customer},
              success:function(data){
                $('#detail_section').html(data);
              }
        });
    });

    ///// calculate the renew amount /////////////////
    $('#payment').on('keyup',function(){

      var customer = $('#customer').val();
      var payment = this.value;
      var currentDate = $('#renewDate').val();

      $.ajax({
            type: 'post',
            url: '../functions/get_renewingDetail.php',
            data: {customer:customer},
            success: function (response) {

                var obj = JSON.parse(response);

                //alert(response);

                var interestRate = obj.interestRate
                var newAmount    = obj.newAmount
                var total_paid   = obj.total_paid
                var pre_date     = obj.pre_date

                const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds

                const firstDate = new Date(pre_date);
                const secondDate = new Date(currentDate);

                const diffDays = Math.round(Math.abs((firstDate - secondDate) / oneDay)); 
                var months = Math.round(Number(diffDays)/30);

                // alert(months)
                var tot_interest = (Number(newAmount)*Number(interestRate/100)*Number(months)).toFixed(2);
                var renewAmt = (Number(newAmount)+Number(tot_interest))-Number(payment).toFixed(2);
                var totalPaid = (Number(total_paid)+Number(payment)).toFixed(2);

                $('#renewAmt').val(renewAmt);
                $('#totalPaid').val(totalPaid);

            }
        });
    });

    ////////////////////// Form Submit Add  /////////////////////////////


    $(function () {

        $('#renewingForm').on('submit', function (e) {

          e.preventDefault();

          var rid= $('#rid').val();

            $.ajax({
              type: 'post',
              url: '../controller/renewing_controller.php',
              data: $('#renewingForm').serialize(),
              success: function (data) {

                swal({
                  title: "Good job !",
                  text: "Successfully Submited",
                  icon: "success",
                  button: "Ok !",
                  });
                  //setTimeout(function(){ location.reload(); }, 2500);
                  //setTimeout(function(){window.open('receipt?id='+rid, '_blank'); }, 100);

                  setTimeout(function(){ location.reload(); }, 2500);
                  
              }
            });


        });
      });


    function cancelForm(){
        window.location.href = "renewing.php";
    }

    // print bill //////
    function printForm(id){
      //window.open('receipt?id='+id, '_blank');
      window.location.href = "renewing.php";
    }


</script>