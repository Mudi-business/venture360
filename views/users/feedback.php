<?php
session_start();
include_once('../connection.php');

if (isset($_SESSION['user'])) {
  $user = $_SESSION['user'];
  $selectUserId = "SELECT users_id from users where username = '$user'";
  $resultSetId = $conn->query($selectUserId);
  $rowUserId = $resultSetId->fetch_array();
  $uId = $rowUserId[0];

  $fetchFirstUsertDAta = "select users_id,profile_id,business_id,firstName,lastName,username,place,
  phone,email,businessInfo,mission,category,usersPic,users.status from users natural join profile natural join business where role = 'admin'";
  $resultQuery = $conn->query($fetchFirstUsertDAta);
  $firstUser = $resultQuery->fetch_array();

  $fetchAllUsers = "SELECT business.business_id,particularBusinessName from business inner join  profile using (profile_id) where users_id = $uId";
  $resultFetchUsers = $conn->query($fetchAllUsers);

  $selectFeedback = "SELECT particularBusinessName,feedback,feedback.time,feedback.date,feedback.status from feedback inner join business using(business_id) inner join profile using (users_id) where users_id = $uId";
  $resultFeedback = $conn->query($selectFeedback);

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

    <link rel="stylesheet" href="../../bootstrap/css/userFeedback.css">

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

        <div class="row">
            <div class="col-md-12" >

              <nav id="main-navbar" class="navHelper">
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

            <div class="search tex-center">
            	<input type="text" name="q" class="searchbox" placeholder="Search work">
            </div>
        </div>
</div>
<div class="container-fluid">
        <div class="row ">

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

                  <h5 class="header FAheader"><i class="fa fa-list" aria-hidden="true"></i>Feedback & Suggestions</h5>
              </br>
                  <div class="SuggestionsGive">

                    <?php
                      $num = 1;
                      while ($rowFeedback = $resultFeedback->fetch_array()) {
                        if ($rowFeedback[4]=='Pending') {?>
                          <div class="rollout" data-mark="<?php echo $num ?>">
                            <h3><?php echo $rowFeedback[0] ?></h3>
                            <div style="background-color:#ffffff;">
                                <?php echo $rowFeedback[1] ?>
                              </div>

                              <small><?php echo $rowFeedback[3]." ".$rowFeedback[2]; ?></small>
                          </div>
                        <?php
                      }else {?>
                        <div class="rolloutMe" data-mark="<?php echo $num ?>">
                          <h3><?php echo $rowFeedback[0] ?></h3>
                          <div style="background-color:#ffffff;">
                              <?php echo $rowFeedback[1] ?>
                            </div>

                            <small><?php echo $rowFeedback[3]." ".$rowFeedback[2]; ?></small>
                        </div>
                      <?php
                        }
                        ?>


                    <?php
                      $num++;
                      }



                     ?>




                  </div>

            </div>
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <h5 class="header FAheader"><i class="fa fa-list" aria-hidden="true"></i>Create feedback</h5>
          </br></br>
            <!-- From -->
            <div class="comment-form">

            <form class="form" name="form" action="userFeedbackHandler.php" method="post">
            <div class="form-row">
              <textarea
                        class="input"
                        name="feedbackMessage"
                        ng-model="cmntCtrl.comment.text"
                        placeholder="Write a message..."
                        required>
            </textarea>
            </div>
            <input type="hidden" name="users_Id" value="<?php echo $uId; ?>">

            <div class="form-row">
              <select class="search-select "  name="business_id" onchange="fetchBusines(this)">
                  <option value="">Business</option>
                  <?php

                      while ($rowUsers = $resultFetchUsers->fetch_array()) {?>
                        <option value="<?php echo $rowUsers[0]?>" class="<?php echo $rowUsers[2]?>"><?php echo $rowUsers[1]?></option>
                    <?php
                      }


                   ?>

              </select>
              <div id="response">

              </div>

            </div>


            <div class="form-row">
              <input type="submit" name="btnFeedback" value="Create feedback">
            </div>
            </form>
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
    <script type="text/javascript" src="../../bootstrap/js/userFeedback.js"></script>
    <script type="text/javascript" src="../../bootstrap/js/appointmentCard.js"></script>
    <script type="text/javascript">

    </script>


  </body>
</html>
