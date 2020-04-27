<?php
session_start();
include_once('connection.php');
if (isset($_POST['joinUser'])) {

    if ($conn) {
      $firstname = $_POST['firstName'];
      $lastname = $_POST['lastName'];
      $businessName = $_POST['busiName'];
      $password = $_POST['password'];
      $mission = $_POST['userBusInfo'];
      $address = $_POST['address'];
      $phone = $_POST['phone'];
      $email = $_POST['email'];
      $date = date("Y/m/d");
      $time = date('H:i:s');
        $insertJoinningUser = "INSERT INTO users(firstName,lastName,username,password,role,place,phone,email,usersPic,status)VALUES('$firstname','$lastname','$businessName','$password','regular','$address',$phone,'$email','default.png','NP')";

        if ($conn->query($insertJoinningUser)==true) {
              $selectUserId = "SELECT users_id from users where email = '$email'";
              if ($conn->query($selectUserId)==true) {
                    $resultId = $conn->query($selectUserId);
                    $userId = $resultId->fetch_array();
                    $insertUserProfile = "INSERT INTO profile(users_id,businessInfo,mission,status)VALUES($userId[0],'Enter business information for $businessName','$mission','NP')";
                    if ($conn->query($insertUserProfile)==true) {
                      $selectProfileId = "SELECT profile_id from profile where users_id = '$userId[0]'";
                      if ($conn->query($selectProfileId)==true) {
                          $resultProfileId = $conn->query($selectProfileId);
                          $userProfileId = $resultProfileId->fetch_array();

                          $insertUserBusiness = "INSERT INTO business(profile_id,category,particularBusinessName,particularBusinessDescription,time,date,status)
                          VALUES($userProfileId[0],'NC','business 1','description for business 1','$time','$date','NP')";
                          if ($conn->query($insertUserBusiness)==true) {
                              header('location:index.php?success="Joined successfull please login to update business information"');
                          }
                          else {
                            die('error on creating business'.$insertUserBusiness.'</br>'.$conn->error);
                          }
                      }
                      else {
                        die('error selecting profile'.$selectProfileId.'</br>'.$conn->error);
                      }

                    }else {
                      die('erro on creating profile'.$insertUserProfile.'</br>'.$conn->error);
                    }

              }else {
                die('erro on selecting user'.$selectUserId.'</br>'.$conn->error);
              }

        }else {
          die('Error in joinning');
        }
    }


}
else {
  header('location:../index.php?error=Cant access this page!!!');
}








 ?>
