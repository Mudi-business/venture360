<?php

session_start();
include_once('../connection.php');
if (isset($_SESSION['user'])) {
  $user = $_SESSION['user'];
  if ($conn) {
      if (isset($_POST['btnUpdateBus'])) {
        $businesseId = $_POST['btnUpdateBus'];
        $businessName = $_POST['businessName'];
        $businessDescription = $_POST['busineDescription'];

        $updateBusiness = "UPDATE business SET
         particularBusinessName = '$businessName',particularBusinessDescription = '$businessDescription'
         where business_id = $businesseId";
         if ($conn->query($updateBusiness)==true) {
            header("location:users.php?success= update made successfull");
         }else {
           header("location:users.php?error= error in updating business");
           // die("error".$updateBusiness."</br>".$conn->error);
         }
      }elseif (isset($_POST['btnAddComments'])) {
          $business_id = $_POST['business_id'];
          $cMessage = $_POST['commentMessage'];
          $date = date("Y/m/d");
          $time = date('H:i:s');
          $insertComment = "INSERT INTO comments(business_id,comment,date,time,status)VALUES
          ($business_id,'$cMessage','$date','$time','NS')";
          if ($conn->query($insertComment)==true) {
            header("location:users.php?success= comments created successfull");
          }else {
              header("location:users.php?error = error in creating comments");
              // die("error".$insertComment."</br>".$conn->error);
          }
      }
  }
}
 ?>
