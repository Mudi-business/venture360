<?php
session_start();
include_once('connection.php');
if (isset($_SESSION['user'])) {
  $user = $_SESSION['user'];


  $selectCategories = "SELECT categories_id,category from categories";
  $resultCategories = $conn->query($selectCategories);

  function fetchSubCategories($catId){
    try {
      $conn = new mysqli('localhost','root','',"venture360");

    } catch (Exception $e) {
      echo "error".$e;
      exit();
    }
    $subCateg = "SELECT subCategory_id,subCategory from subCategory inner join categories using(categories_id) where categories_id = $catId";
    $resultSubCateg = $conn->query($subCateg);

    while ($rowSubCateg = $resultSubCateg->fetch_array() ) {?>
        <div class="option" data-type="firstOption"> <a href="adminCollection.php?col=<?php echo $rowSubCateg[0]; ?>"><?php echo $rowSubCateg[1]; ?></a> </div>
  <?php
    }
  }

  if (isset($_GET['col'])) {
        $catId = $_GET['col'];
        $varCollection = "SELECT particularBusinessName,particularBusinessDescription,
        categories.category,pictureName,businessLink,gallery.date,subCategory.subCategory,business_id from business
         inner join gallery using(business_id)
        inner join categories on categories.categories_id = business.category
        inner join subCategory on subCategory.subCategory_id = business.subCategory  where subCategory.subCategory_id  = $catId";

        $resultVarColloection = $conn->query($varCollection);
  }

  function getComments($businessIdCom){
    try {
      $conn = new mysqli('localhost','root','',"venture360");

    } catch (Exception $e) {
      echo "error".$e;
      exit();
    }
    $selectCom = "SELECT comment,time,date from comments where business_id = $businessIdCom";
    $resultCom = $conn->query($selectCom);
    while ($rowCom=$resultCom->fetch_array()) {?>
      <div class="comment">
      <!-- Comment Avatar -->
      <!-- Comment Box -->
      <div class="comment-box">
        <div class="comment-text">
          <?php echo $rowCom[0]; ?>
        <div class="comment-footer">
          <div class="comment-info">

            <span class="comment-date"> <?php echo $rowCom[2]." ".$rowCom[1];?> </span>
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
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../bootstrap/css/dropdowns.css">
    <link rel="stylesheet" href="../../bootstrap/css/downNav.css">
    <link rel="stylesheet" href="../../bootstrap/css/animatedSearch.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="../../bootstrap/css/styles.css">
    <link rel="stylesheet" href="../../bootstrap/css/adminCollection.css">
    <link rel="stylesheet" href="../../bootstrap/css/modal.css">

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

          </div>
      </div>
      </div>

        <div class="container-fluid">

            <div class="row ">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                  <?php if (isset($_GET['col'])) {?>
                    <a href="adminCollection.php" style="float:left;">back</a>
                  <?php
                  }
                  ?>
                  <section id="particularWorks" class="card-row">

                          <?php
                              if (isset($_GET['col'])) {

                              $modNumber=0;
                              while ($rowCollection = $resultVarColloection->fetch_array()) {?>

                                <article class="card">

                                   <em><?php echo $rowCollection[2]; ?></em><small><?php echo $rowCollection[6]; ?></small>
                                  <img src="../userImageWork/<?php echo $rowCollection[3]; ?>" id="collectionImage" alt="image loading" />
                                  <h3 id="businessNameC"><?php echo $rowCollection[0]; ?></h3>

                                  <p>
                                    <?php echo $rowCollection[1]; ?>
                                  </p>
                                  <small><?php echo $rowCollection[5]; ?></small>
                                  <button type="button" id="btnComments" onclick="btnComments(this)" value="<?php echo $modNumber;?>"  class="moreInvincible btnComments" name="<?php echo $rowCollection[7]; ?>"> <i class="fa fa-comments"></i> </button>
                                  <div class="commentsDiv" id="commentsDiv<?php echo $modNumber;?>">



                                        <!-- From -->


                                        <form class="form" name="form" action="adminFeedbackHandler.php" method="post">

                                        <div class="form-row">
                                          <textarea id="commentsMessage"
                                                    class="input"
                                                    name="commentsMessage"

                                                    placeholder="Write a message..."
                                                    required>
                                        </textarea>
                                        </div>




                                        <div class="form-row">
                                          <button type="button"  name="btnComments" onclick="fetchBusines(this)" value="<?php echo $rowCollection[7]; ?>">comment</button>
                                        </div>
                                        </form>

                                        <div class="fetchComments">
                                          <?php
                                          $busIdCom = $rowCollection[7];
                                          getComments($busIdCom);


                                           ?>

                                          <div id="responseComment">

                                          </div>
                                        </div>
                                      </div>
                                  <button type="button" id="read_info<?php echo $modNumber;?>" name="<?php echo $modNumber;?>" onclick="getReadInfo(this)" class="button invincible" >Preview</button>
                                  <!-- <a href="#" class="button">Preview</a> -->
                                </article>

                                <div id="modal<?php echo $modNumber;?>" class="modal">


                                  <div class="modalP">

                                      <div class="modalData">
                                        <iframe src="<?php echo $rowCollection[4]; ?>" width="1550px" height="580px;"></iframe>
                                        <button id="close<?php echo $modNumber;?>" type="button" class="buttonJoin">close</button>
                                      </div>

                                  </div>

                                </div>
                            <?php
                                $modNumber++;
                              }
                                }


                           ?>


                  </section>

                      <?php
                          if (!isset($_GET['col'])) {?>
                            <div id="categoriesList" class="categoriesList">
                              <?php

                                  while ($rowCateogries = $resultCategories->fetch_array()) {
                                      $categoryIdToSub = $rowCateogries[0];
                                    ?>

                                    <div class="select" style="float:left" >

                                      <div class="selectBtn" id="chosenData" style="color:black;" data-type="firstOption"><?php echo $rowCateogries[1];?></div>
                                        <div class="selectDropdown">
                                          <?php
                                          fetchSubCategories($categoryIdToSub);
                                           ?>

                                        </div>
                                    </div>
                                <?php
                                  }

                               ?>



                            </div>
                        <?php
                          }
                       ?>

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
    <script type="text/javascript" src="../../bootstrap/js/adminCollection.js"></script>
    <script type="text/javascript" src="../../bootstrap/js/modal.js"></script>
    <script type="text/javascript">

    </script>

  </body>
</html>
