<?php
session_start();
include_once('connection.php');

if (isset($_SESSION['user'])) {
  $user = $_SESSION['user'];
  $fetchFirstUsertDAta = "select users_id,profile_id,business_id,firstName,lastName,username,place,
  phone,email,businessInfo,mission,category,usersPic,users.status from users natural join profile natural join business where role = 'admin'";
  $resultQuery = $conn->query($fetchFirstUsertDAta);
  $firstUser = $resultQuery->fetch_array();

  $fetchAllUsers = "SELECT users_id,username,profile_id from users inner join profile using(users_id) where role !='admin' and users.status ='Q'";
  $resultFetchUsers = $conn->query($fetchAllUsers);

  $selectSuggestion = " SELECT suggestion,date,time from suggestions where status = 'Admin';";
  $resultSuggestions = $conn->query($selectSuggestion);

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

    <link rel="stylesheet" href="../../bootstrap/css/adminSuggestion.css">

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
            	<input type="text" name="q" class="searchbox" placeholder="Search work">
            </div>
        </div>
</div>
<div class="container-fluid">
        <div class="row ">
          <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">

          </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

                  <h5 class="header FAheader"><i class="fa fa-list" aria-hidden="true"></i>User's suggestions</h5>
              </br>
                  <div class="SuggestionsGive">

                    <?php
                      $num = 1;
                      while ($rowSuggestions = $resultSuggestions->fetch_array()) {?>

                        <div class="rolloutMe" data-mark="<?php echo $num ?>">

                          <div style="background-color:#ffffff;">
                              <?php echo $rowSuggestions[0] ?>
                            </div>

                            <small><?php echo $rowSuggestions[1]." ".$rowSuggestions[2]; ?></small>
                        </div>


                    <?php
                      $num++;
                      }



                     ?>




                  </div>

            </div>
          <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">

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
    <script type="text/javascript" src="../../bootstrap/js/adminSuggestion.js"></script>
    <script type="text/javascript" src="../../bootstrap/js/appointmentCard.js"></script>



  </body>
</html>
