<!DOCTYPE html>
<html lang="en">
  <?php
    // Database Connection
    require '../include/config.php';

     // Get Update Form Data
    if(isset($_GET['view_id'])){

        $view_id = $_GET['view_id'];

        $sql=mysqli_query($conn,"SELECT * FROM material_stock WHERE id='$view_id'");  
        $numRows = mysqli_num_rows($sql); 
        if($numRows > 0) {
          while($row = mysqli_fetch_assoc($sql)) {

            $item_id      = $row['id'];
            $item_name    = $row['item_name'];
            $measurement  = $row['measurement'];
            $weight       = $row['weight'];
            $note         = $row['note'];

            if(!empty($weight)){
              $weight    = $row['weight'];
            }else{
              $weight    = 0;
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
                      <li><a href="#"> | GOLD STOCK</a></li>
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
                      <p class="card-description">Gold Info</p>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Item name</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="item_name" value="<?php if(isset($_GET['view_id'])){ echo $item_name;} ?>" placeholder="Item name" required>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Weight</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="weight" id="weight" value="<?php if(isset($_GET['view_id'])){ echo $weight;} ?>" placeholder="0" readonly/>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Measurement</label>
                            <div class="col-sm-9">
                              <select class="form-control" name="measurement" id="measurement" required="">
                                <?php

                                if(isset($_GET['view_id'])){
                                echo "<option value = ".$measurement.">" . $measurement . "k</option>";
                                }
                                echo "<option value=''>Select measurement</option>";
                                ?>
                                <option value="9">9k</option>
                                <option value="12">12k</option>
                                <option value="14">14k</option>
                                <option value="16">16k</option>
                                <option value="18">18k</option>
                                <option value="20">20k</option>
                                <option value="21">21k</option>
                                <option value="22">22k</option>
                                <option value="24">24k</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Weight In (mg)</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="weight_in" id="weight_in" onkeyup="TotalWeight()" value="0" placeholder="0" required/>
                            </div>
                          </div>
                        </div>                   
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Note</label>
                        <div class="col-sm-9">
                          <textarea class="form-control" id="note" name="note" rows="4">
                            <?php
                            if(isset($_GET['view_id'])){ echo $note;}
                            ?>
                          </textarea>
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
                    <h4 class="card-title">All Stock Details</h4>
                    
                    <div class="table-responsive">          
                    <table id="myTable" class="table table-bordered">
                      <thead>
                        <tr>
                          <th> # </th>
                          <th>Item</th>
                          <th>measurement</th>
                          <th>Weight(mg)</th>
                          <th>Price</th>
                          <th>Note</th>
                          <th>Edit</th>
                          <th>Delete</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $sql=mysqli_query($conn,"SELECT * FROM material_stock");
                          
                          $numRows = mysqli_num_rows($sql); 
                    
                          if($numRows > 0) {
                            $i = 1;
                            while($row = mysqli_fetch_assoc($sql)) {

                            $item_name    = $row['item_name'];
                            $measurement  = $row['measurement'];
                            $weight       = $row['weight'];
                            $note         = $row['note'];
                            $price        = $row['price'];

                              echo ' <tr>';
                              echo ' <td>'.$i.' </td>';
                              echo ' <td>'.$item_name.' </td>';
                              echo ' <td>'.$measurement.'k </td>';
                              echo ' <td>'.$weight.' </td>';
                              echo ' <td>'.$price.' </td>';
                              echo ' <td>'.$note.' </td>';

                              echo '<td class="td-center"><button type="button" onclick="editForm('.$row["id"].')" class="btn btn-info btn-fw">Edit</button></td>';

                              echo '<td class="td-center"><button type="button" onclick="confirmation(event,'.$row["id"].')" class="btn btn-secondary btn-fw">Delete</button></td>';

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


    function TotalWeight(){

        var weight_in= $('#weight_in').val();

        if(numberRegex.test(weight_in)){

          $('#weight_in').val(weight_in);

        }else{

          if(weight_in!=''){
              swal({
              title: "Stock must be Number !",
              text: "Validation",
              icon: "error",
              button: "Ok !",
              });
              $('#weight_in').val('');
          }
        }
    }
  
    ////////////////////// Form Submit Add  /////////////////////////////

    $(function () {

        $('#itemForm').on('submit', function (e) {

          e.preventDefault();

              $.ajax({
                type: 'post',
                url: '../controller/stock_controller.php',
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
            url:"../controller/stock_controller.php",
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
                window.location.href = "stock.php";
            }
      });
    }

    function editForm(id){
        window.location.href = "stock.php?view_id=" + id;
    }

    function cancelForm(){
        window.location.href = "stock.php";
    }

</script>


