<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="../../bootstrap/css/adminModal.css">
    <style media="screen">
    #custormerNote{
      resize: none;
      border:1px solid white;
    }
    </style>
  </head>
  <body>

        <?php
            include_once('connection.php');
            if (isset($_POST['businessName'])){?>
              <select class="search-select " name="selectSelected" onchange="selectSelected(this)" id ="response" required>

                <option value="">Business name</option>
                <?php

              $profileId = $_POST['businessName'];
              $fetchBusinessData = "SELECT business_id,particularBusinessName from business where profile_id = $profileId";
              $resultBusinessData = $conn->query($fetchBusinessData);

              while ($rowBusiness = $resultBusinessData->fetch_array()) {?>
                <option value="<?php echo $rowBusiness[0]?>" id="businessCateg"><?php echo $rowBusiness[1]?></option>
            <?php
              }
              ?>

              </select>
          <?php
        }elseif (isset($_POST['categoryId'])) {?>
          <select class="search-select " name="businessSubCat"  id ="response2" required>

            <option value="">sub categories</option>
            <?php

          $categoryId = $_POST['categoryId'];
          $fetchSubCategories = "SELECT subCategory_id,subCategory from subCategory where categories_id = $categoryId";
          $resultFetchSubCategories = $conn->query($fetchSubCategories);

          while ($rowSubCategory = $resultFetchSubCategories->fetch_array()) {?>
            <option value="<?php echo $rowSubCategory[0]?>" id="businessCateg"><?php echo $rowSubCategory[1]?></option>
        <?php
          }
          ?>

          </select>


      <?php
    }elseif (isset($_POST['invoice'])) {
        $usersPaidId = $_POST['invoice'];
        $fetchUsesDatas="SELECT particularBusinessName,email,amountPaid from business
        inner join profile using(profile_id) inner join users using (users_id)
        inner join payments using (business_id)
         where users_id = $usersPaidId and ( payments.status = 'F' or payments.status = 'FP')";
        $resultFetchUsersData = $conn->query($fetchUsesDatas);
        while ($rowUsersDatas = $resultFetchUsersData->fetch_array()) {?>
          <div id="modal-window"  class="shadow " >
            <form class="" action="adminHandler.php" method="POST">


            <div class="main-modal align-items-center " >
              <div class="row ">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-12">
                    <input type="hidden" name="users_id" value="<?php echo $usersPaidId; ?>">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-12">
                  <div class="invoiceHeader">
                    <h2 class="invoiceTag"><i class="fas fa-file-invoice"></i> INV</h2>
                    <img src="../images/venture.jpg" id="invoicePic">
                    <h2 class="invoiceTag">ICE</h2>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-12">

                </div>
              </div>
              <div class="row ">
                  <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 customerInfo">
                        <h5 class="invoiceFor text-left">Invoice for</h5>
                        <h6 class="text-left">[<?php echo $rowUsersDatas[0]; ?>]</h6>
                        <h6 class="text-left">[<?php echo $rowUsersDatas[1]; ?>]</h6>
                        <input type="hidden" name="businessName" value="<?php echo $rowUsersDatas[0]; ?>">
                        <input type="hidden" name="email" value="<?php echo $rowUsersDatas[1]; ?>">
                  </div>
                  <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

                  </div>
                  <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 invoiceData">
                        <h5 class="invoiceFor text-right">Invoice number: [1]</h5>
                        <h6 class="text-right">Sent:[ <small > <input id="sentTime" type="text" readonly name="sentDate" value=""> </small> ]</h6>

                        <h6 class="text-right">Due date:[ <small><input type="date" required name="dueDate" value=""></small> ]</h6>
                  </div>

              </div>

              <div class="notForCustomer" id="customerNote" >
                  <textarea name="customerN" id="custormerNote" required rows="1" cols="90" placeholder="Note for custormer"></textarea>
              </div>


              <div class="invoiceTableInfo">
                    <table >
                        <tr id="trHead">
                            <td>Service</td>
                            <td>Amount</td>
                            <td>Discount</td>
                            <td>Subtotal</td>
                        </tr>
                        <tr>
                          <td>
                            <select class=""required name="service">
                              <option value="">choose service</option>
                              <option value="First">First</option>
                              <option value="Second">Second</option>
                          </select>
                        </td>
                          <td><input class="inputInvoice readonly" readonly type="text" id="amountPaid" name="amountPaid" value="<?php echo $rowUsersDatas[2]; ?>"></td>
                          <td><input class="inputInvoice "  type="text" required oninput="calculateDiscount(this)" name="discountValue" id="discountValue" value=""></td>
                          <td><input class="inputInvoice readonly" readonly type="text"  name="subtotal" id="subtotal" value=""></td>
                        </tr>
                    </table>
                    <div class="row ">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">

                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="Tax">
                              <label for="">Tax</label>  <input class="inputInvoice" required oninput="calculateTax(this)" type="text" id="taxInclusive" name="taxInclusive" value="">
                            </div>
                            <div class="totalAmount">
                                <label for="">Total amount</label>  <input class="inputInvoice readonly" readonly type="text" id="totalAmountPaid" name="totalAmountPaid" value="">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">

                        </div>
                    </div>
              </div>

              <div class="invoiceButtons">
                <button type="submit" id="btnSendInvoice" name="btnSendInvoice" class="btn btn-success btnInvoice" >
                  Send invoice
                </button>
                <button type="button" class="btn btn-info btnInvoice">
                  Print invoice
                </button>
                <button  type="button" class="btn btn-danger btnInvoice" onclick="closeM()">
                  Cancel
                </button>
              </div>

            </div>
            </form>

          </div>

      <?php
        }

    }elseif (isset($_POST['businessIdComments'])) {
          $busCommentId = $_POST['businessIdComments'];
          $message = $_POST['message'];
          $date = date("Y/m/d");
          $time = date('H:i:s');

          $insertComment = "INSERT INTO comments(business_id,comment,time,date,status)VALUES($busCommentId,'$message','$time','$date','NS')";
          if ($conn->query($insertComment)==true) {
              $slectComments = "SELECT comment,time,date from comments where business_id = $busCommentId";
              if ($conn->query($slectComments)) {
                  $resultFetchComments = $conn->query($slectComments);
                  while ($rowComments = $resultFetchComments->fetch_array()) {?>
                    <div class="comment">
                    <div class="comment-box">
                      <div class="comment-text">
                        <?php echo $rowComments[0] ?>
                      <div class="comment-footer">
                        <div class="comment-info">

                          <span class="comment-date"><?php echo $rowComments[2]." ".$rowComments[1];?></span>
                        </div>

                        <div class="comment-actions">
                          <a href="#">Reply</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                </br>

                  <?php
                  }

              }else {
                die("error".$slectComments."</br>".$conn->error);
              }
          }else {
            die("error".$insertComment."</br>".$conn->error);
          }
    }

         ?>


  <script type="text/javascript">

         setInterval(myTimer, 1000);
    function myTimer() {
         var d = new Date(); // for now
           d.getHours(); // => 9
           d.getMinutes(); // =>  30
           d.getSeconds();
           var time = d.getHours()+":"+d.getMinutes()+":"+d.getSeconds();
            document.getElementById('sentTime').value=d;
            // console.log(d.date());
     }

     function calculateDiscount(object){
        if (object.name=="discountValue") {
            var totalValue = document.getElementById('amountPaid').value;
            var discount = object.value;

            var calculateValue = (totalValue * discount) / 100;
            var subtotal = totalValue - calculateValue;
            document.getElementById('subtotal').value=subtotal;
        }
     }
     function calculateTax(object){
        if (object.name=="taxInclusive") {
            var taxInclusive = object.value;
            var subtotal = document.getElementById('subtotal').value;

            var calculateValue = (subtotal * taxInclusive) / 100;
            var totalAmountPaid = parseInt(subtotal) + parseInt(calculateValue);
            document.getElementById('totalAmountPaid').value=totalAmountPaid;
        }
     }

     function closeM(){

         let m= document.getElementById('modal-window');
         // m.classList.remove("showModal");
         m.style.display="none";

     }
  </script>

  </body>
</html>
