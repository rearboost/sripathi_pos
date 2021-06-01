<?php
include('../include/config.php');
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
                    <ul class="quick-links">
                      <li><a href="#"> | SETTINGS</a></li>
                      <li><a href="#"> PRICE SETTING</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <!-- Page Title Header Ends-->
            <div class="row">
              <div class="col-md-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                    <div class="col-md-6">
                      <h3 class="card-title">Update Price</h3>
                      <form class="form-sample" id="priceUpdate">
                        
                        <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Item</label>
                        <div class="col-sm-9">
                          <select class="form-control" name="item" id="item" required>
                              <option value="">--Select Item--</option>
                              <?php
                                  $item = "SELECT DISTINCT(item_name)AS item_name FROM material_stock";
                                  $result = mysqli_query($conn,$item);
                                  $numRows = mysqli_num_rows($result); 
                  
                                    if($numRows > 0) {
                                      while($row = mysqli_fetch_assoc($result)) {
                                        echo '<option value = "'.$row["item_name"].'"> '. $row['item_name'] .' </option>';
                                      }
                                    }
                              ?>
                          </select>
                        </div>
                        </div>

                        <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Measurement</label>
                        <div class="col-sm-9">
                          <select class="form-control" name="measurement" id="measurement" required>
                            <option value="">--Select Item First--</option>
                          </select>
                        </div>
                        </div>

                        <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Price</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="price" id="price" required>
                        </div>
                        </div>

                        <input type="hidden" class="form-control" name="price_update" value="price_update" />
                        <button type="submit" class="btn btn-info btn-fw">UPDATE</button>    
                      </form>
                      </div><!-- end column1-->

                    </div><!-- end row-->
                  </div>
                </div>
              </div>
            </div>
          </div>

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

    
  $(document).ready(function(){
      
    ////////////// get measurements ///////////////////////
    $("#item").on('change',function(){
      var item = $(this).val();
      if(item){
        
        $.get(
          "../functions/get_items.php",
          {item:item},
          function (data) { 
            //alert(item)
            $('#measurement').html(data);
          }
        );
           
      }else{
        $('#measurement').html('<option>Select Item First</option>');
      }
    });

  });

    $(function () {

        $('#priceUpdate').on('submit', function (e) {

          e.preventDefault();

              $.ajax({
                type: 'post',
                url: '../controller/price_controller.php',
                data: $('#priceUpdate').serialize(),
                success: function (data) {

                    if(data==0){

                        swal({
                          title: "Can't Duplication !",
                          text: "Items",
                          icon: "error",
                          button: "Ok !",
                        });

                    }else{

                        swal({
                          title: "Good job !",
                          text: "Successfully Updated",
                          icon: "success",
                          button: "Ok !",
                          });

                          setTimeout(function(){ location.reload(); }, 2500);
                    }
                }
              });


        });
      });



</script>



