<?php
session_start();

if (isset($_SESSION['user'])) {
  $user = $_SESSION['user'];

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
    <link rel="stylesheet" href="../../bootstrap/css/adminReport.css">

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
            	   <h4>Reports</h4>
            </div>
        </div>

        <div class="row ">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="reportBtnDiv">
                  <button type="button" class="invincible reportBtn" name="button"><span class="badge badge-info badgeControll">Invoice <i class="fa fa-file"></i> </span></button>
                  <button type="button" class="invincible reportBtn" name="button"><span class="badge badge-info badgeControll">All users <i class="fa fa-file"></i> </span></button>
                  <button type="button" class="invincible reportBtn" name="button"><span class="badge badge-info badgeControll">All works <i class="fa fa-file"></i> </span></button>
                  <button type="button" class="invincible reportBtn" name="button"><span class="badge badge-info badgeControll">feedback & suggestion <i class="fa fa-file"></i> </span></button>
                  <button type="button" class="invincible reportBtn" name="button"><span class="badge badge-info badgeControll">most viewed works <i class="fa fa-file"></i> </span></button>


                </div>
                <div class="response">
                  <table class="rwd-table">
  <tr>
    <th>Header1</th>
    <th>Header2</th>
    <th>Header3</th>
    <th>Header4</th>
  </tr>
  <tr>
    <td>Content1</td>
    <td>Content1</td>
    <td>Content1</td>
    <td>Content1 </td>
  </tr>
  <tr>
    <td>Content2</td>
    <td>Content2</td>
    <td>Content2</td>
    <td>Content2 </td>
  </tr>
  <tr>
    <td>Content3</td>
    <td>Content3</td>
    <td>Content3</td>
    <td>Content3 </td>
  </tr>
</table>
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
    <script type="text/javascript" src="../../bootstrap/js/adminReport.js"></script>


  </body>
</html>
