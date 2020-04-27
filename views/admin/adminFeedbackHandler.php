<?php
session_start();
include_once('connection.php');
if (isset($_SESSION['user'])) {
  $user = $_SESSION['user'];
    if ($conn){
    if (isset($_POST['btnFeedback'])) {
          $feedbackM = $_POST['feedbackMessage'];
          $userId = $_POST['users_id'];
          $date = date("Y/m/d");
          $time = date('H:i:s');
          $businessId = $_POST['selectSelected'];
          $status = 'Pending';

          $insertFeedback = "INSERT INTO feedback(users_id,business_id,feedback,time,date,status)VALUES
            ($userId,$businessId,'$feedbackM','$time','$date','$status')";
            if ($conn->query($insertFeedback)==true) {
                  header("location:adminFeedback.php?success = Feedback created successfull");
            }else {
              // header("location:adminFeedback.php?error = error in creating feedback");
              die("error ".$insertFeedback."</br>".$conn->error);
            }
    }

    }else {
      header("location:adminFeedback.php?error = error no connection");
    }
  }




 ?>
