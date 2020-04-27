<?php
session_start();
include_once('../connection.php');
if (isset($_SESSION['user'])) {
  $user = $_SESSION['user'];


  $selectId = "SELECT users_id from users where username = '$user'";
  $resultId = $conn->query($selectId);
  $rowId = $resultId->fetch_array();

  $uId = $rowId[0];

  $selectIdBusFromProfile = "SELECT particularBusinessName,particularBusinessDescription,pictureName,businessLink,
  gallery.date,gallery.time,business_id from gallery inner join business using(business_id) inner join profile using(profile_id)
   where users_id = $uId";

   $selectIdBusFromProfileFrist = "SELECT particularBusinessName,particularBusinessDescription,pictureName,businessLink,
   gallery.date,gallery.time,business_id from gallery inner join business using(business_id) inner join profile using(profile_id)
    where users_id = $uId";


    $resultSelectBusFromProfileFirst = $conn->query($selectIdBusFromProfileFrist);
    $rowcount = $resultSelectBusFromProfileFirst->num_rows;
    $rowFirst = $resultSelectBusFromProfileFirst->fetch_array();



   $resultSelectBusFromProfile = $conn->query($selectIdBusFromProfile);


   function getbusinessComments($conn,$Id)
   {
      $selectBusComments="SELECT comment,comments.date,comments.time
      from comments inner join business using (business_id) where comments.business_id = $Id";

      $resultSet = $conn->query($selectBusComments);
      while ($rowBusComments = $resultSet->fetch_array()) {?>
        <!-- Comments List -->
        <div class="comments">
        <!-- Comment -->
        <div class="comment" >


        <!-- Comment Box -->
        <div class="comment-box">
          <div class="comment-text"> <?php echo $rowBusComments[0];?> </div>
          <div class="comment-footer">
            <div class="comment-info">

              <span class="comment-date"><?php echo $rowBusComments[1]." ".$rowBusComments[2];?></span>
            </div>

            <div class="comment-actions">
              <a href="#">Reply</a>
            </div>
          </div>
        </div>
        </div>


        </div>
      <?php
      }
   }


}
else {
  header('location:../index.php?error=You are not logged in yet !!');
}


 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Home </title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../bootstrap/css/dropdowns.css">
    <link rel="stylesheet" href="../../bootstrap/css/downNav.css">
    <link rel="stylesheet" href="../../bootstrap/css/loginInput.css">

    <link rel="stylesheet" href="../../bootstrap/css/styles.css">
    <link rel="stylesheet" href="../../bootstrap/css/userHome.css">
    <!-- <=============================================================================>
    ==================================FONT AWESOME ================================== -->
    <link rel="stylesheet" href="../../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../../fontawesome/css/brands.min.css">
    <link rel="stylesheet" href="../../fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../../fontawesome/css/regular.min.css">
    <link rel="stylesheet" href="../../fontawesome/css/solid.min.css">
    <link rel="stylesheet" href="../../fontawesome/css/svg-with-js.min.css">
    <link rel="stylesheet" href="../../fontawesome/css/v4-shims.min.css">
    <title>User</title>
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
        <div class="row">
            <div class="col-md-12">
              <nav id="main-navbar">
              <ul>
                <li><a href="../index.php"> <i class="fa fa-home" style="color:#73264d;"></i>Dashboard</a></li>
                <li><a href="users.php"> <i class="fa fa-home" style="color:#73264d;"></i> Home</a></li>
                <li><a href="profile.php"><i class="fa fa-user"  style="color:#73264d;"></i> Profile</a></li>
                <li><a href="feedback.php"><i class="fa fa-user"  style="color:#73264d;"></i> Feedbacks</a></li>
                <li><a href="suggestion.php"><i class="fa fa-user"  style="color:#73264d;"></i> Suggestions</a></li>
                <li><a href="../admin/adminCollection.php"><i class="fa fa-envelope listIcon" ></i> Collection</a></li>



                <li>
                  <form class="" action="../logout.php" method="post">
                      <button type="submit" class="moreInvincible"><i class="fa fa-sign-out"  style="color:#73264d;"></i> logout</button>
                  </form>


                </li>
              </ul>
              </nav>
            </div>

        </div>

    </div>

      <?php
          if ($rowcount==0) {?>
            <h1 class="text-center ringBell">YOUR BUSINESS HAVE NOT FINISHED BEING SETUP</h1>
        <?php
      }else {?>
        <div class="container-fluid">
          <?php

             while ($rowBusFromProfile = $resultSelectBusFromProfile->fetch_array()) {?>
                  <button type="button" onclick="submitBusinessAjax(this)" style="float:right;width:90px;"  name="<?php echo $rowBusFromProfile[6]; ?>"><?php echo $rowBusFromProfile[0];?></button>

           <?php
             }
           ?>
            <div class="dataCenter">
            <div class="row ">


                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 bigPictureIfrmae" >


                                <iframe width="100%" class="iframePic usersIframe" height="400px" frameborder="0" src="<?php echo $rowFirst[3];?>" ></iframe>

                                <form class="" action="usersHandler.php" method="post">
                                  <div class="formWorkInfor">
                                    <div class="form-group">

                                      <input type="text" style="color:black;" name="businessName" value="<?php echo $rowFirst[0];?>">
                                       <textarea id="comments" class="input-textarea"  name="busineDescription" placeholder="Enter your Descriptions here...">
                                         <?php echo $rowFirst[1]; ?>
                                       </textarea>
                                     </div>

                                     <br>
                                     <div class="form-group">
                                       <button type="submit" name="btnUpdateBus" value="<?php echo $rowFirst[6]; ?>" id="submit">update</button><br>
                                     </div>
                                  </div>
                                </form>




                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 bigPictureIfrmae" >
                      <div class="comments-app" >


                          <!-- From -->
                          <div class="comment-form">
                          <!-- Comment Avatar -->
                          <div class="comment-avatar">
                          <img src="../userImageWork/<?php echo $rowFirst[2] ?>">
                          </div>


                          <form class="form" action="usersHandler.php" method="post" name="form">
                          <div class="form-row">

                            <textarea
                                      class="input"
                                      name="commentMessage"
                                      ng-model="cmntCtrl.comment.text"
                                      placeholder="Add comment..."
                                      rows="3"
                                      required>
                            </textarea>
                            <input type="hidden" name="business_id" value="<?php echo $rowFirst[6]; ?>">
                          </div>

                          <div class="form-row">
                            <input type="submit" name="btnAddComments" value="Add Comment">
                          </div>
                          </form>
                          </div>

                            <?php
                              $busId = $rowFirst[6];
                              getbusinessComments($conn,$busId);
                             ?>
                          </div>

                    </div>

                  </div>

            </div>
            <div id="responseBusiness">

            </div>
        </div>
      <?php
      }
       ?>


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
    <script type="text/javascript" src="../../bootstrap/js/users.js"></script>
    <script type="text/javascript" src="../../bootstrap/js/adminModal.js"></script>

  </body>
</html>
