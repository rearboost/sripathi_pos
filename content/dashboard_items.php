<!DOCTYPE html>
<html lang="en">
  <?php
    // Database Connection
    require '../include/config.php';

     // Get Update Form Data
    if(isset($_GET['view_id'])){

        $view_id = $_GET['view_id'];

        $sql=mysqli_query($conn,"SELECT * FROM dashboard_items WHERE item_id='$view_id'");  
        $numRows = mysqli_num_rows($sql); 
        if($numRows > 0) {
          while($row = mysqli_fetch_assoc($sql)) {

            $item_id      = $row['item_id'];
            $item         = $row['item'];
            $min_price    = $row['min_price'];
            $max_price    = $row['max_price'];
            $discount    = $row['discount'];
            $stock_qty    = $row['stock_qty'];
            $stock_status = $row['stock_status'];

            if(!empty($stock_qty)){
              $stock_qty    = $row['stock_qty'];
            }else{
              $stock_qty    = 0;
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
                      <li><a href="#"> | ITEMS</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <!-- Page Title Header Ends-->
            <form class="form-sample" id="itemForm">
              <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                        <p class="card-description">Item Info</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Item</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="item" value="<?php if(isset($_GET['view_id'])){ echo $item;} ?>" placeholder="Item name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Stock</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="stock_qty" id="stock_qty" value="<?php if(isset($_GET['view_id'])){ echo $stock_qty;} ?>" placeholder="0" readonly/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Min Price </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="min_price" value="<?php if(isset($_GET['view_id'])){ echo $min_price;} ?>" placeholder="0.00" required/>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Max Price </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="max_price" value="<?php if(isset($_GET['view_id'])){ echo $max_price;} ?>" placeholder="0.00" required/>
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                              <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Discount</label>
                              <div class="col-sm-9">
                                  <input type="text" class="form-control" name="discount" id="discount" placeholder="0" value="<?php if(isset($_GET['view_id'])){ echo $discount;} ?>"/>
                              </div>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Stock In</label>
                              <div class="col-sm-9">
                                  <input type="text" class="form-control" name="stock_in" id="stock_in" onkeyup="TotalStock()" value="0" placeholder="0" required/>
                              </div>
                              </div>
                          </div>                        
                      </div>

                       <div class="row">

                        <div class="col-md-6">
                              <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Stock Status</label>
                              <div class="col-sm-9">
                                  <select class="form-control" id="stock_status" name="stock_status" required="">
                                    <?php

                                        if(isset($_GET['view_id'])){
                                        echo "<option value = ".$stock_status.">" . $stock_status . "</option>";
                                        }
                                        echo "<option value=''>--Select Status--</option>";
                                        ?>
                                        <option value="instock">instock</option>
                                        <option value="outofstock">outofstock</option>
                                        <option value="onbackorder">onbackorder</option>
                                        
                                </select>
                              </div>
                              </div>
                          </div>
                        </div>
                    

                       <?php if (isset($_GET['view_id'])): ?>
                          <input type="hidden" class="form-control" name="view_id" id="view_id" value="<?php if(isset($_GET['view_id'])){ echo $view_id;} ?>" />
                          <input type="hidden" class="form-control" name="update" value="update" />
                          <button type="submit" class="btn btn-info btn-fw">UPDATE</button>
                          <button type="button" onclick="cancelForm()" class="btn btn-primary btn-fw">Cancel</button>
                      <?php else: ?>
                          <input type="hidden" class="form-control" name="add" value="add" />
                          <button type="submit" class="btn btn-success mr-2">Save</button>
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
                    <h4 class="card-title">All Items</h4>
                    
                    <div class="table-responsive">          
                    <table id="myTable" class="table table-bordered">
                      <thead>
                        <tr>
                          <th> # </th>
                          <th>Item</th>
                          <th>Stock</th>
                          <th>Min Price </th>
                          <th>Max Price</th>
                          <th>Discount</th>
                          <th>Status</th>
                          <th>Edit</th>
                          <th>Delete</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $sql=mysqli_query($conn,"SELECT * FROM dashboard_items");
                          
                          $numRows = mysqli_num_rows($sql); 
                    
                          if($numRows > 0) {
                            $i = 1;
                            while($row = mysqli_fetch_assoc($sql)) {

                            $item         = $row['item'];
                            $min_price    = $row['min_price'];   
                            $max_price    = $row['max_price'];
                            $discount     = $row['discount'];
                            $stock_qty    = $row['stock_qty'];
                            $stock_status = $row['stock_status'];

                              echo ' <tr>';
                              echo ' <td>'.$i.' </td>';
                              echo ' <td>'.$item.' </td>';
                              echo ' <td>'.$stock_qty.' </td>';
                              echo ' <td>'.$min_price.' </td>';
                              echo ' <td>'.$max_price.' </td>';
                              echo ' <td>'.$discount.' </td>';
                              echo ' <td>'.$stock_status.' </td>';

                              echo '<td class="td-center"><button type="button" onclick="editForm('.$row["item_id"].')" class="btn btn-info btn-fw">Edit</button></td>';

                              echo '<td class="td-center"><button type="button" onclick="confirmation(event,'.$row["item_id"].')" class="btn btn-secondary btn-fw">Delete</button></td>';

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


    function TotalStock(){

        // var stock= $('#stock_qty_hidden').val();
        //alert(stock)
        var stock_in= $('#stock_in').val();

        if(numberRegex.test(stock_in)){

        //  var total = (Number(stock)+Number(stock_in))
          $('#stock_in').val(stock_in);

        }else{

          if(stock_in!=''){
              swal({
              title: "Stock must be Number !",
              text: "Validation",
              icon: "error",
              button: "Ok !",
              });
              $('#stock_in').val('');
              // $('#stock_qty').val('');
          }
        }
    }
  
    ////////////////////// Form Submit Add  /////////////////////////////

    $(function () {

        $('#itemForm').on('submit', function (e) {

          e.preventDefault();

              $.ajax({
                type: 'post',
                url: '../controller/item_controller.php',
                data: $('#itemForm').serialize(),
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
                          setTimeout(function(){ cancelForm(); }, 1500);
                    }
                }
              });

        });
      });

    function confirmation(e,id) {
        var answer = confirm("Are you sure, you want to permanently delete this record?")
      if (!answer){
        e.preventDefault();
        return false;
      }else{
        myFunDelete(id)
      }
    }

    function myFunDelete(id){

      $.ajax({
            url:"../controller/item_controller.php",
            method:"POST",
            data:{removeID:id},
            success:function(data){
                swal({
                title: "Good job !",
                text: "Successfully Removerd",
                icon: "success",
                button: "Ok !",
                });
                setTimeout(function(){ location.reload(); }, 2500);
                window.location.href = "dashboard_items.php";
            }
      });
    }

    function editForm(id){
        window.location.href = "dashboard_items.php?view_id=" + id;
    }

    function cancelForm(){
        window.location.href = "dashboard_items.php";
    }

</script>




