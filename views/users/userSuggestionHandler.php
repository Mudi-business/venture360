<?php
session_start();
include_once('../connection.php');
if (isset($_SESSION['user'])) {
  $user = $_SESSION['user'];
    if ($conn){
    if (isset($_POST['btnSuggestion'])) {
          $suggestionM = $_POST['suggestionkMessage'];
          $userId = $_POST['users_Id'];
          $date = date("Y/m/d");
          $time = date('H:i:s');

          $status = 'Admin';

          $insertSuggestion = "INSERT INTO suggestions(users_id,suggestion,time,date,status)VALUES
            ($userId,'$suggestionM','$time','$date','$status')";
            if ($conn->query($insertSuggestion)==true) {
                  header("location:suggestion.php?success = Suggestions created successfull");
            }else {
              // header("location:profile.php?error = error in creating feedback");
              die("error ".$insertSuggestion."</br>".$conn->error);
            }
    }

    }else {
      header("location:suggestion.php?error = error no connection");
    }
  }




 ?>
