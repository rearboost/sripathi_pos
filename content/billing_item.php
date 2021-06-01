
<?php
include('../include/config.php');
?>
<!DOCTYPE html>
<html lang="en">

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
                      <li><a href="#"> BILLING ITEMS</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <!-- Page Title Header Ends-->
              <div class="row">
                <div class="col-lg-9 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                     <h1><strong>POS</strong></h1>
                      <form class="form-sample" id="productAdd">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                   <label class="col-sm-1.5 col-form-label">Item</label>
                                    <div class="col-sm-3">
                                      <!-- <input list="brow" class="form-control" id="product_name" required>
                                      <datalist id="brow">
                                        <?php

                                           // $product2 = "SELECT DISTINCT(item_name)as item_name FROM material_stock";
                                           // $result2 = mysqli_query($conn,$product2);
                                           // $numRows2 = mysqli_num_rows($result2); 
                            
                                           // if($numRows2 > 0) {
                                            //    while($row2 = mysqli_fetch_assoc($result2)) {
                                            //        echo '<option value ="'.$row2["item_name"].'">';
                                            //    }
                                            //}
                                        ?>
                                      </datalist>  -->
                                      <select class="form-control" name="product_name" id="product_name" required>
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
                                    <label class="col-sm-0.5 col-form-label">Measurement</label>
                                    <div class="col-sm-3">
                                      <select class="form-control" name="measurement" id="measurement" required>
                                        <option value="">--Select Item First--</option>
                                      </select>
                                    </div>
                                    <label class="col-sm-0.5 col-form-label">Weight</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="weight" name="weight" required>
                                        <input type="hidden" class="form-control" id="up_date" required>
                                    </div>
                                    <div class="col-sm-1 size">
                                        <i class="fa fa-plus-circle pointer" onclick="AddPro()"></i>   
                                    </div>
                                </div>
                            </div>
                        </div>  <!--end first row-->             
                        </form>

                        <div class="row">
	                        <div class="col-md-12" style="height: 240px; overflow-y: auto;">
                           <div id="here">
                              <div class="table-responsive">          
                                <table id="example" class="table table-bordered">
                                <thead>
                                  <tr>
                                    <th>Item</th>
                                    <th>Measurement</th>
                                    <th>Weight</th>
                                    <th>Price</th>
                                    <th>Amount</th>
                                    <th>DELETE</th>  
                                  </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql=mysqli_query($conn,"SELECT * FROM temp_pos");
                                    
                                      $numRows = mysqli_num_rows($sql); 
                                
                                      if($numRows > 0) {

                                        $total_amt = 0;
                                        
                                        while($row = mysqli_fetch_assoc($sql)) {

                                          $product = $row['product'];
                                          $measurement = $row['measurement'];
                                          $weight  = $row['weight'];
                                          $price   = $row['price'];
                                          $amount   = $row['amount'];
                                          $id   = $row['id'];
                                          echo ' <tr>';
                                          echo ' <td>'.$product.' </td>';
                                          echo ' <td>'.$measurement.' </td>';
                                          echo ' <td>'.$weight.' </td>';
                                          echo ' <td>'.$price.' </td>';
                                          echo ' <td>'.$amount.' </td>';
                                          echo '<td class="td-center"><button class="btn-edit" id="DeleteButton" onclick="removeForm('.$id.')">Delete</button></td>';
                                          echo ' </tr>';
                                           $total_amt = $total_amt + $amount;

                                        }
                                      }
                                    ?>
                                </tbody>
                                </table>
                              </div>
                           </div>
	                        </div>
                        </div><!-- end 2nd row-->

                        <br><br>

                        
                        <div class="row">
                          <div class="col-md-8">
                            <p>Payment Section</p>
                          </div>
                          <div class="col-md-4">
                            <?php

                                  $sql ="SELECT id FROM invoice ORDER BY id DESC LIMIT 1";
                                  $result=mysqli_query($conn,$sql);
                                  $row_get = mysqli_fetch_assoc($result);
                                  $count =mysqli_num_rows($result);

                                  if($count==0){
                                    $nextID = 1;
                                  }else{
                                    $nextID =$row_get['id']+1;
                                  }

                                ?>
                            
                                <input type="hidden" id="inv_id" value="<?php echo $nextID ?>">

                                <b><label class="col-sm-12 col-form-label">Invoice No - <?php echo sprintf('%05d', $nextID); ?></label></b>
                          </div>
                        </div>


                        <div class="row" style="border:1px solid #ddd; margin-bottom: 10px; padding-top: 10px; border-radius: 20px; margin: 0px 0px 20px 0px;">
                          <div class="col-md-3" >
                              <div class="form-group">
                                <label class="col-sm-12 col-form-label">Payment Type</label>
                                <div class="col-sm-12">
                                <select class="form-control" id="payment_type" name="payment_type">
                                  <option value="credit">Payment Type</option>
                                  <option value="cash">Cash</option>
                                  <option value="cheque">Cheque</option>
                                  <option value="card">Card</option>
                                </select>
                                </div>
                              </div>
                          </div>
                          <!--credit section-->
                          <div class="col-md-3 cheque_section" hidden>
                            <div class="form-group">
                              <label class="col-sm-8 col-form-label">Bank</label>
                                <div class="col-sm-12">
                                  <input type="text" class="form-control" name ="bank" id="bank" placeholder="Bank name"/>
                                </div>
                            </div>
                          </div>
                          <div class="col-md-3 cheque_section" hidden>
                            <div class="form-group">
                              <label class="col-sm-10 col-form-label">Cheque Number</label>
                                <div class="col-sm-12">
                                  <input type="text" class="form-control" name ="cheque_no" id="cheque_no" placeholder="Cheque No"/>
                                </div>
                            </div>
                          </div>
                          <div class="col-md-3 cheque_section" hidden>
                            <div class="form-group">
                              <label class="col-sm-8 col-form-label">Due Date</label>
                                <div class="col-sm-12">
                                  <input type="date" class="form-control" name ="due_date" id="due_date"/>
                                </div>
                            </div>
                          </div>
                          <!--card section-->
                          <div class="col-md-4 card_section" hidden>
                            <div class="form-group">
                                <label class="col-sm-6 col-form-label">&nbsp;&nbsp;Card Type</label>
                                <div class="row">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-4">
                                  <input type="radio" name ="card_type" id="card_type" value="visa"checked/>&nbsp;&nbsp;Visa
                                </div>
                                <div class="col-sm-5">
                                  <input type="radio" name ="card_type" id="card_type" value="master"/>&nbsp;&nbsp;Master
                                </div>
                                <div class="col-sm-1"></div>
                                </div>
                            </div>
                          </div>
                          <div class="col-md-5 card_section" hidden>
                            <div class="form-group">
                                <label class="col-sm-6 col-form-label">Card Number</label>
                                <div class="col-sm-12">
                                  <input type="text" class="form-control" name ="card_no" id="card_no" placeholder="Card Number" />
                                </div>
                            </div>
                          </div>
                        </div><!-- end 3rd row-->

                        <div class="row">
                            <div class="col-md-4" >
                                <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Gross</label>
                                    <div class="col-sm-8">
                                      <input type="text" class="form-control" name="gross" id="gross" placeholder="0.00" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Payment</label>
                                    <div class="col-sm-8">
                                      <input type="text" class="form-control" name ="payment" id="payment" onkeyup="paymentFun()"  placeholder="0.00" required/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-group row">
                                <!-- <label class="col-sm-3 col-form-label">Customer</label> -->
                                    <div class="col-sm-12">
                                      <input type="text" class="form-control"  name="customer" id="customer" placeholder="Customer Name here.."/>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end 3rd row-->

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Discount</label>
                                    <div class="col-sm-4">
                                      <input type="text" class="form-control" name ="discount" id="discount" onkeyup="myFunction()"  placeholder="0.00" />
                                    </div>
                                    <div class="col-sm-4">
                                      <input type="text" class="form-control" name ="discount_percentage" id="discount_percentage" onkeyup="myDis()"  placeholder="%" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Due</label>
                                    <div class="col-sm-8">
                                      <input type="text" class="form-control" name ="due" id="due"  placeholder="0.00" readonly/>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end 4th row-->

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Total</label>
                                    <div class="col-sm-8">
                                      <input type="text" class="form-control" style="font-weight: 600;" name="total" id="total"  placeholder="0.00" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Date</label>
                                    <div class="col-sm-8">
                                      <input type="date" class="form-control" name="date" id="date" value="<?php echo date("Y-m-d"); ?>"  required/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                              <button type="button"  onclick="printForm()" class="btn btn-primary" style="width: 58%;">PRINT</button>
                              <button type="button" onclick="cancelForm()" class="btn btn-primary" style="width: 38%;">CLOSE</button>
                            </div>
                        </div><!-- end 5th row-->
                    </div>
                  </div>
                </div>

                <div class="col-lg-3 grid-margin stretch-card">
                  <div class="card" style="padding:0px;width: 100%;height: 800px;overflow-x: hidden;overflow-y: auto; text-align: center;">
                    <div class="card-body">
                      <input type="text" id="myInput" placeholder="Search by names.." title="Type in a name" style="width: 100%; font-size: 14px; border:1px solid #ddd; border-radius:5px; padding: 10px; margin-bottom: 12px;">
                    	<div class="card-scroll">
                        <?php
                        $items= mysqli_query($conn,"SELECT * FROM material_stock");
                        $numRows = mysqli_num_rows($items); 
                    
                            if($numRows > 0) {
                              while($row = mysqli_fetch_assoc($items)) {

                            ?>
                            <div class="row pointer prod_name" style="margin-bottom: 5px;" id="<?php echo $row['item_name']?>">
                              <div class="card" style="padding: 15px 5px 5px 5px;border-radius: 15px; width: 600px;">
                                <h5><strong><?php echo $row['item_name'] . ' <label class="badge badge-primary">' .  $row['measurement'].'k</label>'; ?></strong></h5>
                                <p><?php echo 'Weight : ' . $row['weight'];?></p>
                              </div>
                            </div>

                        <?php
                              }
                            }else{
                              echo '<p class="">No items available..</label>';
                            }
                        ?>
                    		
                    	</div>
                    </div>
                  </div>
                </div>
              </div> <!-- END MAIN ROW-->

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
    $(document).ready(function(){
      $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".prod_name").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
      
      ////////////// get measurements ///////////////////////
      $("#product_name").on('change',function(){
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

    var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;

    $(document).ready(function() {
           tmpEmpty();

           $("#product_name").focus();
       // $("#credit_period").css({display: "none"});

          //Enter Key Events 
          $("#product_name").keypress(function(e){
              if (e.which == 13) 
              {
                  if($(this).val()=="+"){
                    $('#product_name').val("")
                    $("#discount").focus();
                  }else{
                    $("#quantity").focus();
                  }
              };
          });

          $("#quantity").keypress(function(e){
              if (e.which == 13) 
              {
                 $("#warranty").focus();
              };
          });

          $("#warranty").keypress(function(e){
              if (e.which == 13) 
              {
                 $("#serial_no").focus();
              };
          });

          $("#serial_no").keypress(function(e){
              if (e.which == 13) 
              {
                 AddPro();
              };
          });

          $("#discount").keypress(function(e){
              if (e.which == 13) 
              {
                 $("#payment").focus();
              };
          });

          $("#payment").keypress(function(e){
              if (e.which == 13) 
              {
                 $("#customer").focus();
              };
          });

          $("#customer").keypress(function(e){
              if (e.which == 13) 
              {
                 $("#billing_address").focus();
              };
          });
    });

    $('#payment_type').on('change',function(){
      var type = this.value;

      if(type=='cash'){
        $('.cheque_section').prop('hidden', true);
        $('.card_section').prop('hidden', true);
      }
      else if(type=='cheque')
      {
        $('.cheque_section').prop('hidden', false);
        $('.card_section').prop('hidden', true);

        $('#bank').prop('required', true);
        $('#cheque_no').prop('required', true);
        $('#due_date').prop('required', true);

      }
      else if(type=='card')
      {
        $('.cheque_section').prop('hidden', true);
        $('.card_section').prop('hidden', false);

        $('#card_no').prop('required', true);
      }


    });

    $('#measurement').on('change',function(){
      var item = $('#product_name').val();
      var measurement = this.value;

      $.ajax({

            type: 'post',
            url: '../functions/get_upDate.php',
            data: {item:item,measurement:measurement},
            success:function(response) {
              
              var obj = JSON.parse(response);

              var up_date  =  obj.upDate

              $('#up_date').val(up_date);
                    
                            
              } 
        });

    });

    //Discount On Change
    function myFunction(){

        var gross= $('#gross').val();
        var discount= $('#discount').val();

        if(numberRegex.test(discount)){

          var total = (Number(gross) - Number(discount)).toFixed(2)
          $('#total').val(total);

        }else{

          if(discount!=''){
              swal({
              title: "Discount must be Number !",
              text: "Validation",
              icon: "error",
              button: "Ok !",
              });
              $('#discount').val(0);
          }else{
            $('#discount').val(0);
          }
          myFunction();
        }
    }

    function myDis(){

       var gross= $('#gross').val();
       var discount_percentage= $('#discount_percentage').val();

        if(numberRegex.test(discount_percentage)){

          var discount = (Number(gross)*(Number(discount_percentage)/100)).toFixed(2);
          $('#discount').val(discount);
          myFunction();

        }else{

          if(discount_percentage!=''){
              swal({
              title: "Discount Percentage must be Number !",
              text: "Validation",
              icon: "error",
              button: "Ok !",
              });
              $('#discount').val(0);
              $('#discount_percentage').val(0);
          }else{
             $('#discount').val(0);
             $('#discount_percentage').val(0);
             
          }
          myFunction();
        }

    }

    function paymentFun(){

        var total= $('#total').val();
        var payment= $('#payment').val();
        
        if(numberRegex.test(payment)){

          var due = (Number(payment) - Number(total)).toFixed(2)
          $('#due').val(due);

          if(Number(payment)<Number(total)){
              $("#credit_period").css({display: "inherit"});
          }else{
              $("#credit_period").css({display: "none"});
          }

        }else{

          if(payment!=''){
              swal({
              title: "Payment must be Number !",
              text: "Validation",
              icon: "error",
              button: "Ok !",
              });
              $('#payment').val('');
          }
        }
    }

    // Data add to the Temp POS table                      
    function AddPro(){

      var addrow  ="addrow";

      var product_name= $('#product_name').val();
      var measurement= $('#measurement').val();
      var weight= $('#weight').val();

      var up_date= $('#up_date').val();
      var date= $('#date').val();

      // if(up_date!=date){
      //   alert('Price not yet updated');
      // }else{

      if(product_name!='' && measurement !='' && weight !=''){

       $.ajax({
            type: 'post',
            url: '../controller/billing_controller.php',
            data: {addrow:addrow,product_name:product_name,measurement:measurement,weight:weight},
            success: function (data) {

                if(data==2){

                   swal({
                      title: "Stock is Empty !",
                      text: "Empty",
                      icon: "error",
                      button: "Ok !",
                    });

                }else{

                    $('#product_name').val("")
                    $('#measurement').val("")
                    $('#weight').val("")
                    $('#up_date').val("")

                    $( "#here" ).load(window.location.href + " #here" );
                    $("#gross").val(data);
                    $("#total").val(data);
                    $("#product_name").focus();
                }            
              } 
        });     
      }
      //}
    }

    // $(".prod_name").click(function() {

    //   var addrow  ="addrow";

    //    $.ajax({
    //         type: 'post',
    //         url: '../controller/billing_controller.php',
    //         data: {addrow:addrow,product_name:this.id,quantity:1},
    //         success: function (data) {

    //             if(data==2){

    //                swal({
    //                   title: "Stock is Empty !",
    //                   text: "Empty",
    //                   icon: "error",
    //                   button: "Ok !",
    //                 });

    //             }else{
    //                 $("#here" ).load(window.location.href + " #here" );
    //                 $("#gross").val(data);
    //                 $("#total").val(data);
                    
    //             }
    //           } 
    //     });     
    // });

    ///////////////////////////////////

    function tmpEmpty() {

      var tmpEmpty  ="tmpEmpty";

        $.ajax({
            type: 'post',
            url: '../controller/billing_controller.php',
            data: {tmpEmpty:tmpEmpty},
            success: function (data) {

                 $( "#here" ).load(window.location.href + " #here" );
              } 
        });
    }

     /////////// Remove the Row 
    function removeForm(id){

        var removeRow  ="removeRow";

         $.ajax({
            type: 'post',
            url: '../controller/billing_controller.php',
            data: {removeRow:removeRow,id:id},
            success: function (data) {
                $( "#here" ).load(window.location.href + " #here" );
                $("#gross").val(data);
                $("#total").val(data)
              } 
        });
    }

     function printForm(){

        var save  ="save";

    
        var total= $('#total').val();
        var discount= $('#discount').val();
        var payment= $('#payment').val();
        var customer= $('#customer').val();
        var date= $('#date').val();
        var inv_id= $('#inv_id').val();

        //payment section
        var payment_type= $('#payment_type').val();
        var bank        = $('#bank').val();
        var cheque_no   = $('#cheque_no').val();
        var due_date    = $('#due_date').val();
        var card_type   = $('#card_type').val();
        var card_no     = $('#card_no').val();

        ///////

        if(payment!='' && numberRegex.test(payment)){

            $.ajax({
                type: 'post',
                url: '../controller/billing_controller.php',
                data: {save:save,total:total,discount:discount,payment:payment,date:date,customer:customer,payment_type:payment_type,bank:bank,cheque_no:cheque_no,due_date:due_date,card_type:card_type,card_no:card_no},
                success: function (data) {

                    //setTimeout(function(){window.open('print?id='+inv_id, '_blank'); }, 100);

                    setTimeout(function(){ location.reload(); }, 2500);

                } 
            });  
        }
    }

    function cancelForm(){

        window.location.href = "billing_item.php";
    }
     /////////////////////////////////////////////////////////////////

  </script>


<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


