<!DOCTYPE html>
<?php

//TUMEFUNGUA SESSION KWA AJILI YA KUWEZA KUWATAMBUA USER WETU KWENYE KILA PAGE
session_start();

include_once('connection.php');
if ($conn) {
  $users = " SELECT username,password,role FROM users inner join
  profile using(users_id) inner join business using (profile_id)
  where users.status !='NP' and profile.status !='NP' and business.status !='NP'";
  if ($conn->query($users)==true) {
    $result = $conn->query($users);
      while ($row = $result->fetch_array()) {

            if (!empty(@$_POST['userNa']) && !empty(@$_POST['userPa'])) {
              if (@$_POST['userNa']==$row[0] && @$_POST['userPa']==$row[1]) {
                  if ($row[2]=='admin') {
                      $_SESSION['user']=$row[0];
                      $_SESSION['role']=$row[2];
                      header('location:./admin/admin.php');
                  }
                  else if($row[2]=='regular'){
                      $_SESSION['user']=$row[0];
                      $_SESSION['role']=$row[2];
                      header('location:./users/users.php');
                  }

              }
              // else {
              //   header("location:index.php?error=wrong username or password");
              // }
            }

      }

  }
  else {
    die("query error".$users);
  }

  $selectAllWorksFirst = "SELECT pictureName,businessLink,particularBusinessName,gallery.date from gallery inner join business using(business_id) order by gallery_id desc;";
  $resultSelectAllWorksFirst = $conn->query($selectAllWorksFirst);
  $rowFirst = $resultSelectAllWorksFirst->fetch_array();

  $selectAllWorks = "SELECT pictureName,businessLink,particularBusinessName,gallery.date from gallery inner join business using(business_id) order by gallery_id desc;";
  $resultSelectAllWorks = $conn->query($selectAllWorks);

  $selectCategories = "SELECT categories_id,category from categories";
  $resultCategories = $conn->query($selectCategories);

    function getSubCategory($categ){
      try {
        $conn = new mysqli('localhost','root','',"venture360");

      } catch (Exception $e) {
        echo "error".$e;
        exit();
      }
        $cat = "SELECT subCategory_id,subCategory from subCategory inner join categories using(categories_id) where categories_id = $categ";
        $resultCateg = $conn->query($cat);
        while ($rowCat = $resultCateg->fetch_array()) {?>

          <li><a href="index.php?<?php echo $rowCat[0]; ?>"><?php echo $rowCat[1];?></a></li>

          <?php
        }
    }


      // $conn->close();
}


 ?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap/css/dropdowns.css">
    <link rel="stylesheet" href="../bootstrap/css/downNav.css">
    <link rel="stylesheet" href="../bootstrap/css/loginInput.css">
    <link rel="stylesheet" href="../bootstrap/css/sidebarRight.css">
    <link rel="stylesheet" href="../bootstrap/css/styles.css">
    <link rel="stylesheet" href="../bootstrap/css/index.css">
    <!-- <=============================================================================>
    ==================================FONT AWESOME ================================== -->
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../fontawesome/css/brands.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../fontawesome/css/regular.min.css">
    <link rel="stylesheet" href="../fontawesome/css/solid.min.css">
    <link rel="stylesheet" href="../fontawesome/css/svg-with-js.min.css">
    <link rel="stylesheet" href="../fontawesome/css/v4-shims.min.css">
  </head>
  <body>
    <div class="container">
        <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">

              </div>
              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 defaultDiv" >
                <img src="./images/venture.jpg" id="logoPic">
              </div>
              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">

              </div>
        </div>
    </div>






    <?php
        if (!isset($_SESSION['user'])) {?>
          <div class="usersLoginDiv">
              <h3 class="error"><?php echo @$_GET['error'];?></h3>
              <form class="form-inline loginForm" action="index.php" method="post">
                <div class="username">
                      <input type="text" name="userNa" class="usernameForm" placeholder="Enter profile name" value="">
                </div>
                <div class="password">
                    <input type="password" name="userPa" class="passwordForm" placeholder="Enter password"value="">
                </div>
                <button type="submit" class="loginSubmitButton" name="button">Login</button>
              </form>
          </div>
      <?php
    }
?>

    <div class="container-fluid containerDiv">
      <div id="modal" class="modal">
        <div class="modalP">
            <div class="modalData">
              <h6>By clicking join you agree to make business arrangement with us <i class="fa fa-users listIcon"  ></i> Or your
              account will be seized in a week if no arrangements done. Thank you and Welcome! </h6>
            </div>
            <form class="" action="indexHandler.php" method="post">

              <input type="text" class="input" placeholder="First name" name="firstName" value="">
              <input type="text" class="input" placeholder="Last name" name="lastName" value="">
              <input type="text" class="input" placeholder="Profile name" name="busiName" value="">
              <input type="hidden" name="userBusInfo" value="Please Enter your business mission">
              <input type="email" class="input" placeholder="Email" name="email" value="">
              <input type="text" class="input" placeholder="Address" name="address" value="">
              <input type="text" class="input" placeholder="Phone" name="phone" value="">
              <input type="password" class="input" placeholder="Password" name="" value="">
              <input type="password" class="input" placeholder="Confirm password" name="password" value="">
              <button type="submit" class="buttonJoin" name="joinUser">Join</button>
              <button id="close" type="button" class="buttonJoin">Close</button>
            </form>
        </div>

      </div>

          <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">

              </div>
              <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <nav id="main-navbar">
              <ul>
                <?php

                    if (@$_SESSION['role']=='admin') {?>
                      <li><a href="./admin/admin.php"> <i class="fa fa-home listIcon" ></i> Home</a></li>
                      <li><a href="./admin/adminProfile.php"><i class="fa fa-user listIcon"></i> Profile</a></li>
                      <li><a href="/admin/adminFeedback.php"><i class="fa fa-envelope listIcon" ></i> Inbox</a></li>

                      <li><a href="./admin/adminCollection.php"><i class="fa fa-envelope listIcon" ></i> Collection</a></li>

                      <li><a href="/admin/adminReport.php"><i class="fa fa-database listIcon"></i> Reports</a></li>
                      <li><a href="#"><i class="fa fa-search listIcon" ></i> Search</a></li>
                      <li>
                        <form class="" action="logout.php" method="post">
                            <button type="submit" class="moreInvincible"><i class="fa fa-sign-out listIcon"></i> Logout</button>
                        </form>


                      </li>
                      <?php
                    }

                    else if(@$_SESSION['role']=='regular'){?>

                      <li><a href="index.php"> <i class="fa fa-home" style="color:#73264d;"></i>Dashboard</a></li>
                      <li><a href="./users/users.php"> <i class="fa fa-home" style="color:#73264d;"></i> Home</a></li>
                      <li><a href="./users/profile.php"><i class="fa fa-user"  style="color:#73264d;"></i> Profile</a></li>
                      <li><a href="./users/feedback.php"><i class="fa fa-user"  style="color:#73264d;"></i> Feedbacks</a></li>
                      <li><a href="./users/suggestion.php"><i class="fa fa-user"  style="color:#73264d;"></i> Suggestions</a></li>
                      <li><a href="../admin/adminCollection.php"><i class="fa fa-envelope listIcon" ></i> Collection</a></li>



                      <li>
                        <form class="" action="logout.php" method="post">
                            <button type="submit" class="moreInvincible"><i class="fa fa-sign-out"  style="color:#73264d;"></i> logout</button>
                        </form>


                      </li>
                      <?php
                    }
                    else {?>

                      <li><button type="button" id="read_info" class=" invincible joinUser"><i class="fa fa-users listIcon"  ></i> Join</button></li>

                <?php
              }
                 ?>

              </ul>
            </nav>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">

              </div>
          </div>
          <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                    <div class="sidebarFloat" >

                      <ol class="rounded-list">
                        <?php
                            while ($rowWorks = $resultSelectAllWorks->fetch_array() ) {?>
                              <li>
                                <a href="index.php?work=<?php echo $rowWorks[1]; ?>">
                                <div class="posts">
                                      <img src="./userImageWork/<?php echo $rowWorks[0]; ?>" alt="image" id="dropingImages">
                                </div>
                              </a>
                            </li>
                          <?php
                            }
                         ?>

                      </ol>


                    </div>
                  </div>

                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 bigPictureIfrmae" >
                      <?php
                        if (isset($_GET['work'])) {?>
                          <iframe class="iframeData" width="100%" class="iframePic" height="400px" frameborder="0" src="<?php echo $_GET['work']; ?>" ></iframe>
                          <?php
                        }else {?>
                          <iframe class="iframeData" width="100%" class="iframePic" height="400px" frameborder="0" src="<?php echo $rowFirst[1];?>" ></iframe>
                      <?php
                        }
                      ?>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                      <div class="liveChat">
                            <div class="messageHolderChat">

                            </div>
                      </div>
                    </div>
          </div>

          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">

            </div>
              <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <nav id="navigation">
                      <!-- <a href="#" class="logo">Studio<span>+<span></a> -->
          <ul class="links">
            <!-- <li><a href="#">About</a></li> -->

            <?php
                while ($rowUsersCategory = $resultCategories->fetch_array()) {?>
                  <li class="dropdown"><a href="#" class="trigger-drop"><?php echo $rowUsersCategory[1]; ?><i class="arrow"></i></a>
                    <ul class="drop">
                      <?php
                        $categId = $rowUsersCategory[0];
                          getSubCategory($categId);
                       ?>
                    </ul>
                  </li>
              <?php

                }


             ?>


          </ul>
        </nav>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">

              </div>

          </div>
        </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../bootstrap/js/dropdowns.js"></script>
    <script type="text/javascript" src="../bootstrap/js/index.js"></script>
    <!-- <=============================================================================>
    ==================================FONT AWESOME scripts ================================== -->
    <!-- <script type="text/javascript" src="../fontawesome/js/all.min.js"></script>
    <script type="text/javascript" src="../fontawesome/js/brands.min.js"></script>
    <script type="text/javascript" src="../fontawesome/js/conflct-detection.min.js"></script>
    <script type="text/javascript" src="../fontawesome/js/fontawesome.min.js"></script>
    <script type="text/javascript" src="../fontawesome/js/regular.min.js"></script>
    <script type="text/javascript" src="../fontawesome/js/solid.min.js"></script>
    <script type="text/javascript" src="../fontawesome/js/v4-shims.min.js"></script> -->



  </body>
</html>
