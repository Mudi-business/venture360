<?php
session_start();
include_once('../connection.php');

if (isset($_SESSION['user'])) {
  $user = $_SESSION['user'];

  $selectUserId = "SELECT users_id from users where username = '$user'";
  $resultSetId = $conn->query($selectUserId);
  $rowUserId = $resultSetId->fetch_array();
  $uId = $rowUserId[0];

  $fetchFirstUsertDAta = "SELECT users.users_id,profile.profile_id, business.business_id,firstName,lastName,
  username,place,phone,email,businessInfo,mission,category,usersPic,users.status
  from users inner join profile using (users_id) inner join business using (profile_id) where users.users_id= $uId";
  $resultQuery = $conn->query($fetchFirstUsertDAta);
  $firstUser = $resultQuery->fetch_array();

  $fetchAllUsers = "SELECT business.business_id,
  particularBusinessName from business inner join profile using (profile_id) where users_id = $uId";
  $resultFetchUsers = $conn->query($fetchAllUsers);

  $fetchAppointments = "SELECT username,meetingDate,meetingTime,meetingPlace,phone,usersPic,appointment.status from users inner join appointment using(users_id) where users_id = $uId ";
  // SELECT particularBusinessName,feedback,feedback.time,feedback.date from feedback inner join business using (business_id) where users_id =$uId
  $resultAppointments = $conn->query($fetchAppointments);

  $selectCategories = "SELECT categories_id,category from categories";
  $resultCategories = $conn->query($selectCategories);

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

    <link rel="stylesheet" href="../../bootstrap/css/userProfile.css">
      <link rel="stylesheet" href="../../bootstrap/css/appointmentCard.css">
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
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">

                <div class="ProfilePic">
                  <form class="" action="userProfileHandler.php" method="post" enctype="multipart/form-data">
                    <label for="userImage"> <input id="userImage" type="file" style="display:none" accept="image/*"  name="file" value="">
                      <img class="userImage" src="../userImage/<?php echo $firstUser[12]; ?>" alt="image">
                    </label></br></br>
                    <input type="hidden" name="users_id" value="<?php echo $firstUser[0]; ?>">
                    <input type="submit" name="uploadFile" class="" value="upload image" />
                  </form>
                </div></br></br>
                <div id="userInfor" class="userInfor">
                  <button type="button" class="invincible colorGround" onclick="editFirstUserData(this)" name="btnEdit"> <i class="fa fa-edit"></i> </button></br>
                  <div class="userProfileData">
                    <div class="row ">
                      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <h5 class="labelText ">First name</h5>
                      </div>
                      <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                         <span class="labelInfo"><?php echo $firstUser[3]; ?></span>
                      </div>
                    </div>

                  </div>
                  <div class="userProfileData">
                    <div class="row ">
                      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <h5 class="labelText ">Last name</h5>
                      </div>
                      <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                         <span class="labelInfo"><?php echo $firstUser[4]; ?></span>
                      </div>
                    </div>

                  </div>
                  <div class="userProfileData">
                    <div class="row ">
                      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <h5 class="labelText ">Business Name</h5>
                      </div>
                      <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                         <span class="labelInfo"><?php echo $firstUser[5]; ?></span>
                      </div>
                    </div>

                  </div>
                  <div class="userProfileData">
                    <div class="row ">
                      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <h5 class="labelText ">Place</h5>
                      </div>
                      <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                         <span class="labelInfo"><?php echo $firstUser[6]; ?></span>
                      </div>
                    </div>

                  </div>
                  <div class="userProfileData">
                    <div class="row ">
                      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <h5 class="labelText ">Phone</h5>
                      </div>
                      <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                         <span class="labelInfo"><?php echo $firstUser[7]; ?></span>
                      </div>
                    </div>

                  </div>
                  <div class="userProfileData">
                    <div class="row ">
                      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <h5 class="labelText ">Email</h5>
                      </div>
                      <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                         <span class="labelInfo"><?php echo $firstUser[8]; ?></span>
                      </div>
                    </div>

                  </div>
              </div>
                  <div id="formEditFirstUserData"class="formEditFirstUserData" style="display:none;">
                    <form class="form" name="form" action="userProfileHandler.php" method="post">
                      <div class="userProfileData">
                        <div class="row ">
                          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <h5 class="labelText ">First name</h5>
                          </div>
                          <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                             <span class="labelInfo"><input type="text" name="editFirstName" value="<?php echo $firstUser[3]; ?>"></span>
                          </div>
                        </div>

                      </div>
                      <div class="userProfileData">
                        <div class="row ">
                          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <h5 class="labelText ">Last name</h5>
                          </div>
                          <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                             <span class="labelInfo"><input type="text" name="editLastName" value="<?php echo $firstUser[4]; ?>"></span>
                          </div>
                        </div>

                      </div>
                      <div class="userProfileData">
                        <div class="row ">
                          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <h5 class="labelText ">Business name</h5>
                          </div>
                          <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                             <span class="labelInfo"><input type="text" readonly name="editBusinessName" value="<?php echo $firstUser[5]; ?>"></span>
                          </div>
                        </div>

                      </div>

                        <div class="userProfileData">
                          <div class="row ">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                              <h5 class="labelText ">Place</h5>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                               <span class="labelInfo"><input type="text" name="editPlace" value="<?php echo $firstUser[6]; ?>"></span>
                            </div>
                          </div>

                        </div>
                        <div class="userProfileData">
                          <div class="row ">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                              <h5 class="labelText ">Phone</h5>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                               <span class="labelInfo"><input type="text" name="editPhone" value="<?php echo $firstUser[7]; ?>"></span>
                            </div>
                          </div>

                        </div>

                        <div class="userProfileData">
                          <div class="row ">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                              <h5 class="labelText ">Email</h5>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                               <span class="labelInfo"><input type="text" name="editEmail" value="<?php echo $firstUser[8]; ?>"></span>
                            </div>
                          </div>

                        </div>
                        <input type="hidden" name="secretId" value="<?php echo $firstUser[0]; ?>">


                      <button type="submit" name="btnUPdateUserInfo">Update</button>
                      <button type="button" onclick="editFirstUserData(this)" name="btnRevertEdit">Cancel</button>
                    </form>
                  </div>

                    <button type="button" id="read_info" class="invincible moreFirstUserData" name="button">More about <?php echo $firstUser[5]; ?></button>


            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
              <div id="modal" class="modal">
                <button type="button" id="edtUserMoreDataBtn"  name="btnEditMore" onclick="editSecondUserData(this)" class="invincible floatRight colorGround"> <i class="fa fa-edit "></i> </button>
                <div class="modalP">

                    <div class="modalData">
                      <h6>More about <?php echo $firstUser[5];?>
                    </h6>
                    <div id="edtUserMoreData" class="userMoreData" >
                      <div class="businessInformation">
                        <h5 class="header FAheader"><i class="fa fa-usser" aria-hidden="true"></i>Business information</h5></br></br>
                          <h6 for=""><?php echo $firstUser[9]?></h6>
                      </div>
                      <div class="adminMission">
                          <h5 class="header FAheader"><i class="fa fa-usser" aria-hidden="true"></i>Mission</h5></br></br>
                          <h6 for=""><?php echo $firstUser[10]?></h6>
                      </div>
                      <button id="close" type="button" class="buttonJoin">Done</button>

                    </div>
                    <div id="editUserMoreDataEdit" class="editUserMoreDataEdit" style="display:none;">
                    <form class="form" name="form" action="userProfileHandler.php" method="post">
                      <div class="businessInformation">
                        <h5 class="header FAheader"><i class="fa fa-usser" aria-hidden="true"></i>Business information</h5>


                          <textarea
                                    class="input"
                                    name="businesInfoEdit"
                                    ng-model="cmntCtrl.comment.text"
                                    placeholder="Add data..."
                                    required>
                                    <?php echo $firstUser[9]?>
                        </textarea>


                      </div>
                      <div class="adminMission">
                          <h5 class="header FAheader"><i class="fa fa-usser" aria-hidden="true"></i>Mission</h5>
                          <textarea
                                    class="input"
                                    name="missionEdit"
                                    ng-model="cmntCtrl.comment.text"
                                    placeholder="Add data..."
                                    required>
                                    <?php echo $firstUser[10]?>
                        </textarea>
                      </div>
                      <input type="hidden" name="secretProfile" value="<?php echo $firstUser[1]?>">

                      <button  type="submit"  class="btn btn-success" name="btnUpdateUserMore" class="buttonUpdate">Update</button>
                      <button  type="button" class="btn btn-warning" onclick="editSecondUserData(this)" name="btnRevertEditMore" class="buttonCancelUpdate">Cancel</button>
                    </form>
                    </div>


                    </div>


                    <!-- <form class="" action="indexHandler.php" method="post">

                      <input type="text" class="input" placeholder="First name" name="firstName" value="">
                      <input type="text" class="input" placeholder="Last name" name="lastName" value="">
                      <input type="text" class="input" placeholder="Business name" name="busiName" value="">
                      <input type="hidden" name="userBusInfo" value="Please Enter your business mission">
                      <input type="email" class="input" placeholder="Email" name="email" value="">
                      <input type="text" class="input" placeholder="Address" name="address" value="">
                      <input type="text" class="input" placeholder="Phone" name="phone" value="">
                      <input type="password" class="input" placeholder="Password" name="" value="">
                      <input type="password" class="input" placeholder="Confirm password" name="password" value="">
                      <button type="submit" class="buttonJoin" name="joinUser">Join</button>
                      <button id="close" type="button" class="buttonJoin">Close</button>
                    </form> -->
                </div>

              </div>
                  <h5 class="header FAheader"><i class="fa fa-list" aria-hidden="true"></i>Appointments</h5>
              </br>
                  <div class="SuggestionsGive">

                    <?php
                        $numRotation = 1;
                        while ($rowAppointments = $resultAppointments->fetch_array()) {?>
                      <div class="rollout" data-mark="<?php echo $numRotation; ?>">

                          <h3 style="float:right;"><?php echo $rowAppointments[0]; ?></h3>
                          <img class="imageAppointment" src="../userImage/<?php echo $rowAppointments[5];?> " alt="image loading">

                          <div class="row mixedData" style="height:30px;">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                              <h5 class="labelText ">Address</h5>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                               <span class="labelInfo"><?php echo $rowAppointments[3]; ?></span>
                            </div>
                          </div>
                          <div class="row mixedData" style="height:30px;">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                              <h5 class="labelText ">Phone</h5>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                               <span class="labelInfo"><?php echo $rowAppointments[4]; ?></span>
                            </div>
                          </div>
                          <div class="row mixedData" style="height:30px;">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                              <h5 class="labelText ">Date</h5>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                               <span class="labelInfo"><?php echo $rowAppointments[1]; ?></span>
                            </div>
                          </div>
                          <div class="row mixedData" style="height:30px;">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                              <h5 class="labelText ">Time</h5>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                               <span class="labelInfo"><?php echo $rowAppointments[2]; ?></span>
                            </div>
                          </div>

                      </div>
                      <?php
                      $numRotation++;
                    }
                       ?>

                  </div>

            </div>
          <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">



            <div class="adminPosts">
                <div class="postTittle tex-center">


                    <form class="" action="userProfileHandler.php" method="post" style="margin-top:2em;">
                      <h5 class="header FAheader"><i class="fa fa-database" aria-hidden="true"></i>Business</h5>
                      <input type="text" class="inputAppointment"  name="businessName" placeholder="Business name.." value="">
                      <input type="hidden" name="profileId" value="<?php echo $firstUser[1]; ?>">
                      <textarea name="name" placeholder="Business description" rows="3" cols="37"></textarea>
                    </div>
                    <div class="postBody text-center">

                    </div>

                    <div class="postFooter text-center">
                        <button type="submit" class="btn btn-success moreBtn floatLeft"name="btnBusiness">Create Business</button>
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
    <script type="text/javascript" src="../../bootstrap/js/userProfile.js"></script>
    <script type="text/javascript" src="../../bootstrap/js/appointmentCard.js"></script>


  </body>
</html>
