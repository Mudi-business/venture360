<?php
session_start();
include_once('../connection.php');
if (isset($_SESSION['user'])) {
  $user = $_SESSION['user'];
    if ($conn){
    if (isset($_POST['btnFeedback'])) {
          $feedbackM = $_POST['feedbackMessage'];
          $userId = $_POST['users_Id'];
          $date = date("Y/m/d");
          $time = date('H:i:s');
          $businessId = $_POST['business_id'];
          $status = 'Admin';

          $insertFeedback = "INSERT INTO feedback(users_id,business_id,feedback,time,date,status)VALUES
            ($userId,$businessId,'$feedbackM','$time','$date','$status')";
            if ($conn->query($insertFeedback)==true) {
                  header("location:feedback.php?success = Feedback created successfull");
            }else {
              // header("location:profile.php?error = error in creating feedback");
              die("error ".$insertFeedback."</br>".$conn->error);
            }
    }

    }else {
      header("location:feedback.php?error = error no connection");
    }
  }




 ?>
