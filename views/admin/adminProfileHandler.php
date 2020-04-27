<?php
session_start();
include_once('connection.php');
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
                  header('location:adminProfile.php?success="Information updated successfull"');
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
                  header('location:adminProfile.php?success="Information updated successfull"');
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
                           header("location:adminProfile.php?success=picture updated successfull");
                         }
                         else{
                           die("Error failed".$updatePic."<br>".$conn->error);
                         }

                  }
                  else{
                    header("location:adminProfile.php?Error = in uploading picture");
                  }


        }
        elseif (isset($_POST['btnAppointment'])) {
            $usersId = $_POST['users_id'];
            $meetingDate = $_POST['meetingDate'];
            $meetingTime = $_POST['meetingTime'];
            $meetingPlace = $_POST['meetingPlace'];
            $date = date("Y/m/d");
            $time = date('H:i:s');
            $status = 'NA';

            $insertAppointment = " INSERT INTO appointment(users_id,meetingDate,meetingTime,meetingPlace,time,date,status)
            VALUES($usersId,'$meetingDate','$meetingTime','$meetingPlace','$time','$date','$status')";
            if ($conn->query($insertAppointment)==true) {
                header("location:adminProfile.php?success = Appointment made successfull");
            }else {
              header("location:adminProfile.php?Error = Error in appointment made");
            }
        }elseif (isset($_POST['btnCategory'])) {
            $category = $_POST['businessCategory'];
            $date = date("Y/m/d");
            $time = date('H:i:s');
            $userId = $_POST['usersId'];
            $insertCategory = "INSERT INTO categories(users_id,category,date,time,status)VALUES($userId,'$category','$date','$time','A')";
            if ($conn->query($insertCategory)==true) {
                header("location:adminProfile.php?success = Category created successfull");
            }else {
              header("location:adminProfile.php?Error = Error in creating business category");

            }

        }
        elseif (isset($_POST['btnSubCategory'])) {
            $subCategory = $_POST['subCategory'];
            $date = date("Y/m/d");
            $time = date('H:i:s');
            $categoryId = $_POST['category_id'];
            $insertCategory = "INSERT INTO subCategory(subCategory,time,date,status,categories_id)
            VALUES('$subCategory','$time','$date','A',$categoryId)";
            if ($conn->query($insertCategory)==true) {
                header("location:adminProfile.php?success = sub category created successfull");
            }else {
              header("location:adminProfile.php?Error = Error in creating sub category");

            }

        }
        else {
            header('location:adminProfile.php?error="No request found!!"');
        }


  }
  else {
    header('location:adminProfile.php?error="No Connection found!!"');
  }
}
  else {
    header('location:../index.php?error=You are not logged in yet !!');
  }









 ?>
