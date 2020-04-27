<?php
session_start();
include_once('../connection.php');
if (isset($_SESSION['user'])) {
  $user = $_SESSION['user'];
    if ($conn) {
        if (isset($_POST['btnUPdateUserInfo'])) {
          $firstName = $_POST['editFirstName'];
          $lastName = $_POST['editLastName'];
          $place = $_POST['editPlace'];
          $phone = $_POST['editPhone'];
          $email = $_POST['editEmail'];
          $secret = $_POST['secretId'];


            $updateUserInf = "UPDATE users SET firstName = '$firstName', lastName = '$lastName',place = '$place', phone = $phone, email = '$email'
              WHERE users_id = $secret";
              if ($conn->query($updateUserInf)==true) {
                  header('location:profile.php?success="Information updated successfull"');
              }else {
                die("Error in updating user's information".$updateUserInf."</br>".$conn->error);
              }
        }
        elseif (isset($_POST['btnUpdateUserMore'])) {
            $businessInfor = $_POST['businesInfoEdit'];
            $mission = $_POST['missionEdit'];
            $secretId2 = $_POST['secretProfile'];

            $updateUserInfMore = "UPDATE profile SET businessInfo = '$businessInfor', mission = '$mission'
              WHERE profile_id = $secretId2";
              if ($conn->query($updateUserInfMore)==true) {
                  header('location:profile.php?success="Information updated successfull"');
              }else {
                die("Error in updating user's information".$updateUserInfMore."</br>".$conn->error);
              }
        }

        elseif (isset($_POST['uploadFile'])) {
                  $file_name=$_FILES['file']['name'];
                  $file_type = $_FILES['file']['type'];
                  $file_size = $_FILES['file']['size'];
                  $file_location = $_FILES['file']['tmp_name'];
                  $folder_destination = '../userImage/';
                  $user_id = $_POST['users_id'];

                  $file = rand(1000,100000)."-".$file_name;
                  // new file size in KB
                  $new_size = $file_size/1024;
                  // make file name in lower c;ase
                  $new_file_name = strtolower($file);
                  $final_file=str_replace(' ','-',$new_file_name);

                  if(move_uploaded_file($file_location,$folder_destination.$final_file))
                  {
                   $data_name=$conn->real_escape_string($final_file);
                         //$data_size=$conn->real_escape_string($new_size);
                         //$o=$conn->real_escape_string($new_file_name);
                        // $date=$db->real_escape_string($_POST["date"]);

                         $updatePic="UPDATE users SET usersPic ='$data_name' where users_id='$user_id'";
                         if ($conn->query($updatePic)==true) {
                           header("location:profile.php?success=picture updated successfull");
                         }
                         else{
                           die("Error failed".$updatePic."<br>".$conn->error);
                         }

                  }
                  else{
                    header("location:profile.php?Error = in uploading picture");
                  }


        }elseif (isset($_POST['btnBusiness'])) {
            $businessName = $_POST['businessName'];
            $businessDescription = $_POST['businessDescription'];
            $profileId = $_POST['profileId'];
            $date = date("Y/m/d");
            $time = date('H:i:s');

            $createBusiness = "INSERT INTO business(profile_id,particularBusinessName,particularBusinessDescription,time,date,status)
            VALUES($profileId,'$businessName','$businessDescription','$time','$date','NP')";
            if ($conn->query($createBusiness)==true) {
                header("location:profile.php?success=Business created  successfull");
            }
        }


        else {
            header("location:profile.php?Error = error in creating business");
        }


  }
  else {
    header('location:profile.php?error="No Connection found!!"');
  }
}
  else {
    header('location:../index.php?error=You are not logged in yet !!');
  }









 ?>
