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
                      <li><a href="#"> | PAWNING SECTION</a></li>
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
                    <h4 class="card-title">Pawning Form</h4>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Date of pawning</label>
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
                                  <textarea class="form-control" name="itemDetail" rows="4" placeholder="Short description about this item.."><?php if(isset($_GET['view_id'])){ echo $itemDetail;} ?></textarea>
                                </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $get_id = mysqli_query($conn, "SELECT M_id FROM mortgage ORDER BY M_id DESC LIMIT 1");

                        $data = mysqli_fetch_assoc($get_id);

                        $next_id = $data['M_id']+1;
                        ?>
                        <input type="hidden" id="mid" value="<?php echo $next_id; ?>">

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
                                <input type="text" class="form-control" name="timePeriod" value="<?php if(isset($_GET['view_id'])){ echo $timePeriod;} ?>" maxlength="10" minlength="8" placeholder="dd/mm/yy"/ onkeyup="this.value=this.value.replace(/^(\d\d)(\d)$/g,'$1/$2').replace(/^(\d\d\/\d\d)(\d+)$/g,'$1/$2').replace(/[^\d\/]/g,'')">
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Advance Amount</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name ="mortageAdvance" value="<?php if(isset($_GET['view_id'])){ echo $mortageAdvance;} ?>" placeholder="LKR.0.00"/>
                            </div>
                            </div>
                        </div>
                        </div>

                          <input type="hidden" class="form-control" name="req_add" value="req_add" />
                          <button type="submit" class="btn btn-info btn-fw">PRINT</button>
                          <button type="button" onclick="cancelForm()" class="btn btn-primary btn-fw">Cancel</button>
                  
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
                          <th>NIC</th>
                          <th>Pawning Date</th>
                          <th>Rescue Date </th>
                          <th>Weight(mg)</th>
                          <th>Interest Rate(%)</th>
                          <th>Time Period</th>
                          <th>Advance</th>
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
                            $nic            = $row['nic'];
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
                              echo ' <td>'.$nic.' </td>';
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


    function cancelForm(){
        window.location.href = "mortgage.php";
    }

    // print bill //////
    function printForm(id){
      //window.open('receipt?id='+id, '_blank');
      window.location.href = "mortgage.php";
    }



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


