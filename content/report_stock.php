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
                      <li><a href="#"> | REPORT</a></li>
                      <li><a href="#"> | STOCK REPORT</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <!-- Page Title Header Ends-->
            <div class="col-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                    <h4 class="card-title">Stock report</h4>
                    <!-- <p class="card-description"> Horizontal form layout </p> -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Stock Status</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="status" id="status" required>
                                            <option value="" Selected>--Select Status--</option>
                                            <?php
                                                $status = "SELECT DISTINCT(stock_status) FROM wp_wc_product_meta_lookup";
                                                $result = mysqli_query($conn,$status);
                                                $numRows = mysqli_num_rows($result); 
                                
                                                if($numRows > 0) {
                                                while($row = mysqli_fetch_assoc($result)) {
                                                  echo '<option value ="'.$row["stock_status"].'">' . $row["stock_status"] . '</option>';
                                                    
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
            
            <form class="forms-sample" id="profit_form">

                <input type="hidden" value ='<?php echo $_GET['view_id']; ?>' name="status">

                <div class="col-lg-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                        <center><b><h5>Stock Status - <?php echo $_GET['view_id']; ?></h5></b></center>
                        <br>
                    
                    
                        <div class="row">
                    
                        <?php 

                          $status = $_GET['view_id'];

                          $sql=mysqli_query($conn,"SELECT * FROM wp_posts A RIGHT JOIN wp_wc_product_meta_lookup B ON A.ID=B.product_id WHERE B.stock_status='$status'"); 
                    
                        ?>

                       <!-- <h4 class="card-title">Materials</h4> -->
                        <div class="table-responsive">
                            <div id="printablediv">
                            <table class="table table-bordered" id="costing_bom_table">
                                <thead>
                                    <tr>
                                    <th> # </th>
                                    <th>Product ID</th>
                                    <th>Product </th>
                                    <th>Min Price</th>
                                    <th>Max Price </th>
                                    <th>QTY </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    
                                    $numRows = mysqli_num_rows($sql); 
                                
                                    if($numRows > 0) {
                                        $i = 1;

                                        while($row = mysqli_fetch_assoc($sql)) {

                                        $product_id  = $row['product_id'];
                                        $post_title   = $row['post_title'];
                                        $min_price = $row['min_price'];
                                        $max_price = $row['max_price'];
                                        $stock_quantity = $row['stock_quantity'];

                                        if(empty($stock_quantity)){
                                            $stock_quantity=0;
                                        }


                                        echo ' <tr>';
                                        echo ' <td>'.$i.' </td>';
                                        echo ' <td>'.$product_id.' </td>';
                                        echo ' <td>'.$post_title.' </td>';
                                        echo ' <td>'.$min_price.' </td>';
                                        echo ' <td>'.$max_price.' </td>';
                                        echo ' <td>'.$stock_quantity.' </td>';
                                        echo ' </tr>';
                                        $i++;
                                        }
                                    }
                                    ?>
                                </tbody>
                                </tbody>
                            </table>
                            </div>
                            <br>
                             
                            <button type="button"  onclick="javascript:printDiv('printablediv');" class="btn btn-info btn-fw" >PRINT</button>                          
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
   
    ////////////// bpo_no get  ///////////////////////
    $("#status").on('change',function(){

      var status = $(this).val();
      if(status){     
        window.location.href = "report_stock.php?view_id=" + status;
      }
    });

    function cancelForm(){

        window.location.href = "report_stock.php";
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