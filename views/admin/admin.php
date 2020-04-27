<?php
session_start();
include_once('connection.php');
if (isset($_SESSION['user'])) {
  $user = $_SESSION['user'];


  $selectJoinedUsers = "SELECT users_id,username,firstName,lastName,username,email,profile_id,particularBusinessName from users inner join profile using(users_id) inner join business using (profile_id) where  business.status = 'NP'";

  $selectFullPaidUsersAndHalfUsers = "SELECT users_id,username,firstName,lastName,username,email,profile_id,business_id,payment_id,amountDue,amountPaid,payments.status from users inner join profile using(users_id) inner join business using(profile_id) inner join payments using(business_id) where payments.status ='F' or payments.status = 'H' or payments.status = 'FP';";

  $fetchAllUsers = "SELECT users_id,username,profile_id from users inner join profile using(users_id) where role !='admin' and users.status ='Q'";
  $resultFetchUsers = $conn->query($fetchAllUsers);

  $fetchCategories = " SELECT categories_id,category from categories";
  $resultFetchCategory = $conn->query($fetchCategories);



}
else {
  header('location:../index.php?error=You are not logged in yet !!');
}


 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../bootstrap/css/dropdowns.css">
    <link rel="stylesheet" href="../../bootstrap/css/downNav.css">
    <link rel="stylesheet" href="../../bootstrap/css/animatedSearch.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="../../bootstrap/css/styles.css">
    <link rel="stylesheet" href="../../bootstrap/css/admin.css">
    <link rel="stylesheet" href="../../bootstrap/css/adminModal.css">
    <link rel="stylesheet" href="../../bootstrap/css/materialSearch.css">
    <!-- <=============================================================================>
    ==================================FONT AWESOME ================================== -->
    <link rel="stylesheet" href="../../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../../fontawesome/css/brands.min.css">
    <link rel="stylesheet" href="../../fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../../fontawesome/css/regular.min.css">
    <link rel="stylesheet" href="../../fontawesome/css/solid.min.css">
    <link rel="stylesheet" href="../../fontawesome/css/svg-with-js.min.css">
    <link rel="stylesheet" href="../../fontawesome/css/v4-shims.min.css">
    <title>Admin</title>
  </head>
  <body>

    <div class="container">
        <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">

              </div>
              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 defaultDiv" >
                <img src="../images/venture.jpg" id="logoPic">
              </div>
              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">

              </div>
        </div>
    </div>
    <div class="container">
      <div id="response3">

      </div>
        <div class="row">
            <div class="col-md-12" >

              <nav id="main-navbar" class="navHelper">
              <ul>
              <li><a href="../index.php"> <i class="fa fa-home listIcon" ></i> Dashboard</a></li>
              <li><a href="admin.php"> <i class="fa fa-home listIcon"></i> Home</a></li>
              <li><a href="adminProfile.php"><i class="fa fa-user listIcon"></i> Profile</a></li>
              <li><a href="adminFeedback.php"><i class="fa fa-envelope listIcon" ></i> Feedback</a></li>
              <li><a href="suggestion.php"><i class="fa fa-envelope listIcon" ></i> Suggestions</a></li>
              <li><a href="adminCollection.php"><i class="fa fa-envelope listIcon" ></i> Collection</a></li>

              <li><a href="adminReport.php"><i class="fa fa-database listIcon"></i> Reports</a></li>

              <li>
                <form class="" action="../logout.php" method="post">
                    <button type="submit" class="moreInvincible"><i class="fa fa-sign-out listIcon"></i> Logout</button>
                </form>


              </li>
              </ul>
              </nav>

            </div>

            <div class="search tex-center">
              <h6 class="businessName" style="color:<?php echo isset($_GET['error']) ? $color = 'red': $color='green'; ?>">
                <?php echo isset($_GET['error']) ? $statusMade = @$_GET['error']: $statusMade=@$_GET['success'];?></h6>
            	<input type="text" name="q" class="searchbox" placeholder="Search work">
            </div>
        </div>




        <div class="row rowUserPaiments">

              <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                  <h6 class="text-center userPaidPaymentsHeader"> <i class="fa fa-users"></i>Users joined & payments </h6>
                  <div class="row ">
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                      <?php
                          if ($conn->query($selectFullPaidUsersAndHalfUsers)==true) {
                                $resultHalfAndPaid = $conn->query($selectFullPaidUsersAndHalfUsers);
                                while ($rowHalfAndPaid = $resultHalfAndPaid->fetch_array()){
                                        if ($rowHalfAndPaid[11]=='H') {?>
                                          <h6 id="paidUser"><?php echo $rowHalfAndPaid[2]." ".$rowHalfAndPaid[3]; ?>
                                            <span class="badge badge-info">Half</span>
                                            <button type="button"  value="<?php echo $rowHalfAndPaid[0]; ?>" onclick="userPaymentTakeOverHalfPaid(this)" class="invincible halfPaidBtn" name="button">
                                              <i class="fas fa-dollar-sign moreP text-center"></i>
                                            </button>

                                            <div id="panelHalfPaid<?php echo $rowHalfAndPaid[0]; ?>" class="panel">
                                                  <fieldset name="">
                                                    <legend>Make payments</legend>

                                                    <form class="" action="adminHandler.php" method="post">
                                                      <div class="payMoney">B:<?php echo $rowHalfAndPaid[9]-$rowHalfAndPaid[10]?></div>

                                                      <input type="hidden" name="amountDueHalf" value="<?php echo $rowHalfAndPaid[9]-$rowHalfAndPaid[10]?>" id="amountDueToPaid"/>
                                                      <input type="hidden" name="paymentChoice" value="FP">
                                                      <input type="hidden" name="user" value="<?php echo $rowHalfAndPaid[0]?>">
                                                      <input type="hidden" name="profile" value="<?php echo $rowHalfAndPaid[6]?>">
                                                      <input type="hidden" name="business" value="<?php echo $rowHalfAndPaid[7]?>">
                                                      <input type="hidden" name="payments" value="<?php echo $rowHalfAndPaid[8]?>">
                                                      <input type="text" class="inputPayment payMoneyInputCheck" name="amountPaidHalf" required value="" placeholder="Enter full amount"></br>
                                                      <span id="amountHalfCheck"></span></br>
                                                      <button type="submit" class="invincible" name="paymentMade"> <span class="badge badge-success"><i class="fas fa-dollar-sign"></i> Finish payment</span></button>
                                                      <button type="reset" value="<?php echo $rowHalfAndPaid[0]; ?>" class="invincible" onclick="userCancelPaymentHalfPaid(this)" name="button"> <span class="badge badge-warning"><i class="far fa-times-circle"></i>  Cancel</span></button>

                                                    </form>
                                                  </fieldset>
                                            </div>
                                          </h6>
                                      <?php
                                        }
                                        elseif ($rowHalfAndPaid[11]=='F' or $rowHalfAndPaid[11]=='FP') {?>
                                          <h6 id="paidUser"><?php echo $rowHalfAndPaid[2]." ".$rowHalfAndPaid[3]; ?>
                                            <span class="badge badge-success">Full</span>

                                              <button type="button" name="<?php echo $rowHalfAndPaid[0]; ?>" class="invincible btnPayFull" id="btnFullPayment" onclick="fetchInvoice(this)"><i class="fas fa-file-invoice moreDone text-center"></i></button>

                                          </h6>
                                          <?php
                                        }


                                }
                          }


                       ?>



                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 joinedUsers" >

                          <?php
                              if ($conn->query($selectJoinedUsers)==true) {
                                $result = $conn->query($selectJoinedUsers);
                                while ($row = $result->fetch_array()) {?>
                                  <h6 id="joinedUser"><label class="businessName"><?php echo $row[2]." ".$row[3]; ?></label>
                                    <button type="button" class="invincible userInfoBtn" onclick="userInfoTakeOver(this)" name="button">
                                        <i class="fas fa-eye moreC"></i>
                                    </button>
                                    <button type="button" value="<?php echo $row[0];?>" class="invincible paymentBtn" name="button" onclick="userPaymentTakeOver(this)" >
                                        <i class="fas fa-dollar-sign moreP2" aria-hidden="true"></i>
                                    </button>
                                    <div id="panel<?php echo $row[0];?>" class="panel">
                                          <fieldset>
                                            <legend><?php echo $row[1]."--".$row[7]?></legend>
                                            <form class="" action="adminHandler.php" method="post">

                                                <div class="row ">
                                                  <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" >

                                                  </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                                      <div class="select">
                                                        <select class="" required name="paymentChoice" class="choicePayment">
                                                            <option value="">Payment type</option>
                                                            <option value="H">Half payment</option>
                                                            <option value="F">Full payment</option>
                                                        </select>
                                                      </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" s>

                                                    </div>
                                                </div>
                                              <input type="hidden" name="busId" value="<?php echo $row[6]."/".$row[0]; ?>">
                                              <input type="text" id='adAmount' required class="inputPayment" name="amountDue" value="" placeholder="Enter Amount Charged">
                                              <input type="text" id ='userAmount'required onmouseout="checkComparison(this)" class="inputPayment" name="amountPaid" value="" placeholder="Enter Amount Paid"></br>
                                              <span id="amountResult"></span></br>
                                              <button type="submit" class="invincible" name="paymentMade"> <span class="badge badge-success"><i class="fas fa-dollar-sign"></i> Pay</span></button>
                                              <button type="reset" value="<?php echo $row[0];?>" class="invincible" onclick="userCancelPayment(this)" name="button"> <span class="badge badge-warning"><i class="far fa-times-circle"></i>  Cancel</span></button>
                                                <button type="reset" value="<?php echo $row[0];?>" class="invincible" onclick="userCancelPayment(this)" name="button"> <span class="badge badge-danger"><i class="fa fa-trash" aria-hidden="true"></i>Disjoin</span></button>
                                            </form>
                                          </fieldset>
                                    </div>
                                 </h6>
                                <?php
                                }
                              }



                           ?>

                      </div>
                  </div>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <h6 class="text-center userPaidPaymentsHeader"> <i class="fa fa-users"></i>Posts </h6>
                    <div class="adminPosts">
                        <div class="postTittle tex-center">

                            <form class="" action="adminHandler.php" method="post" enctype="multipart/form-data">
                              <input type="text" class="inputPost"  name="linkToDisplay" placeholder="Display link.." value="">

                              <select class="search-select " id="users_id" name="users_id" onchange="fetchBusines(this)">
                                  <option value="">Owner's name</option>
                                  <?php

                                      while ($rowUsers = $resultFetchUsers->fetch_array()) {?>
                                        <option value="<?php echo $rowUsers[2]?>" id="busId" class="<?php echo $rowUsers[2]?>" ><?php echo $rowUsers[1]?></option>
                                    <?php
                                      }


                                   ?>

                              </select>

                              <div id="response">

                              </div>
                              <select class="search-select " id="busCatId" name="busCatId" onchange="fetchSubCategories(this)">
                                  <option value="">Categories</option>
                                  <?php

                                      while ($rowCategory = $resultFetchCategory->fetch_array()) {?>
                                        <option  onclick="checkD(this)" id="catId" value="<?php echo $rowCategory[0]?>" ><?php echo $rowCategory[1]?></option>
                                    <?php
                                      }


                                   ?>

                              </select>
                              <div id="response2">

                              </div>


                        </div>
                        <div class="postBody text-center">
                            <label for="uploadPic"><img id="uploadImage" src="../images/upload.png" alt=""></label>
                            <input type="file" name="file" value="" accept="image/*" id="uploadPic">
                        </div>

                        <div class="postFooter text-center">
                            <button type="submit" value="gallery" class="btn btn-success moreBtn" name="uploadFile">Post</button>
                        </div>
                        </form>

                    </div>
              </div>
        </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="../../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../../bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../bootstrap/js/dropdowns.js"></script>
    <!-- <=============================================================================>
    ==================================FONT AWESOME scripts ================================== -->
    <!-- <script type="text/javascript" src="../../fontawesome/js/all.min.js"></script>
    <script type="text/javascript" src="../../fontawesome/js/brands.min.js"></script>
    <script type="text/javascript" src="../../fontawesome/js/conflct-detection.min.js"></script>
    <script type="text/javascript" src="../../fontawesome/js/fontawesome.min.js"></script>
    <script type="text/javascript" src="../../fontawesome/js/regular.min.js"></script>
    <script type="text/javascript" src="../../fontawesome/js/solid.min.js"></script>
    <script type="text/javascript" src="../../fontawesome/js/v4-shims.min.js"></script> -->

    <script type="text/javascript" src="../../bootstrap/js/materialSearch.js"></script>
    <script type="text/javascript" src="../../bootstrap/js/admin.js"></script>
    <script type="text/javascript" src="../../bootstrap/js/adminModal.js"></script>


  </body>
</html>
