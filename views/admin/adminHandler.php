<?php
session_start();
include_once('connection.php');
  if ($conn) {
    if (isset($_POST['paymentMade'])) {

        if ($_POST['paymentChoice']=='F') {

          $amountDue = $_POST['amountDue'];
          $amountPaid= $_POST['amountPaid'];
          if ($amountDue == $amountPaid) {

            $profileIdWithUsersId = $_POST['busId'];
            $data = explode('/',$profileIdWithUsersId);
            $profileId = $data[0];
            $userId = $data[1];
            $paymentChoice = $_POST['paymentChoice'];
            $date = date("Y/m/d");
            $time = date('H:i:s');

              $selectBusinessId = " SELECT business_id from business where profile_id = '$profileId' ";
              if ($conn->query($selectBusinessId)==true) {
                  $result = $conn->query($selectBusinessId);
                  $businessId = $result->fetch_array();
                  $insertUserPayments = "INSERT INTO payments(business_id,amountDue,amountPaid,time,date,status)VALUES($businessId[0],'$amountDue','$amountPaid','$time','$date','$paymentChoice')";
                  if ($conn->query($insertUserPayments)==true) {

                        $updateProfileAndUser = "UPDATE users t1 JOIN profile t2 ON (t1.users_id = t2.users_id)
                        SET t1.status = 'Q',t2.status = 'P' WHERE t1.users_id = $userId";
                        if ($conn->query($updateProfileAndUser)==true) {
                              $updateBusiness = "UPDATE business SET status = 'P' WHERE profile_id = $profileId";
                              if ($conn->query($updateBusiness)==true ) {
                                  header('location:admin.php?success="Payments made successfull"');
                              }else {
                                die('Error in Updating status'.$updateBusiness.'</br>'.$conn->error);
                              }

                        }else {
                          die('Error in Updating status'.$updateProfileAndUser.'</br>'.$conn->error);
                        }


                  }else {
                    die('Error in Payments'.$insertUserPayments.'</br>'.$conn->error);
                  }

              }
              else {
                die('Error in businessId'.$insertUserPayments.'</br>'.$conn->error);
              }
          }
          else {
            header('location:admin.php?error="Payment submitted is not Full"');
          }
        }
        //IF USERS MAKE HALF PAYMENTS
        else if($_POST['paymentChoice']=='H'){
          $amountDue = $_POST['amountDue'];
          $amountPaid= $_POST['amountPaid'];
          if ($amountDue>$amountPaid) {
            $profileIdWithUsersId = $_POST['busId'];
            $data = explode('/',$profileIdWithUsersId);
            $profileId = $data[0];
            $userId = $data[1];
            $paymentChoice = $_POST['paymentChoice'];
            $date = date("Y/m/d");
            $time = date('H:i:s');

              $selectBusinessId = " SELECT business_id from business where profile_id = '$profileId' ";
              if ($conn->query($selectBusinessId)==true) {
                  $result = $conn->query($selectBusinessId);
                  $businessId = $result->fetch_array();
                  $insertUserPayments = "INSERT INTO payments(business_id,amountDue,amountPaid,time,date,status)VALUES($businessId[0],'$amountDue','$amountPaid','$time','$date','$paymentChoice')";
                  if ($conn->query($insertUserPayments)==true) {

                        $updateProfileAndUser = "UPDATE users t1 JOIN profile t2 ON (t1.users_id = t2.users_id)
                        SET t1.status = 'QHP',t2.status = 'HP' WHERE t1.users_id = $userId";
                        if ($conn->query($updateProfileAndUser)==true) {
                              $updateBusiness = "UPDATE business SET status = 'HP' WHERE profile_id = $profileId";
                              if ($conn->query($updateBusiness)==true ) {
                                  header('location:admin.php?success="Payments made successfull"');
                              }else {
                                die('Error in Updating status'.$updateBusiness.'</br>'.$conn->error);
                              }

                        }else {
                          die('Error in Updating status'.$updateProfileAndUser.'</br>'.$conn->error);
                        }


                  }else {
                    die('Error in Payments'.$insertUserPayments.'</br>'.$conn->error);
                  }

              }
              else {
                die('Error in businessId'.$insertUserPayments.'</br>'.$conn->error);
              }
          }else {
            header('location:admin.php?error="Payment is not Half payment!!!"');
          }
        }
        elseif ($_POST['paymentChoice']=='FP') {

          $amountDueHalf = $_POST['amountDueHalf'];
          $amountPaidHalf = $_POST['amountPaidHalf'];
          if ($amountDueHalf == $amountPaidHalf) {
            $userIdHalf = $_POST['user'];
            $profileIdHalf = $_POST['profile'];
            $businessIdHalf = $_POST['business'];
            $paymentIdHalf = $_POST['payments'];
            $paymentChoiceHalft = $_POST['paymentChoice'];
            $dateHalf = date("Y/m/d");
            $timeHalf = date('H:i:s');


                  $updateUserPaymentsHalf = "UPDATE payments SET amountDue = $amountDueHalf,amountPaid=$amountPaidHalf,time='$timeHalf',date='$dateHalf',status='$paymentChoiceHalft'
                    WHERE business_id = $businessIdHalf";
                  if ($conn->query($updateUserPaymentsHalf)==true) {

                        $updateProfileAndUserHalf = "UPDATE users t1 JOIN profile t2 ON (t1.users_id = t2.users_id)
                        SET t1.status = 'Q',t2.status = 'FP' WHERE t1.users_id = $userIdHalf";
                        if ($conn->query($updateProfileAndUserHalf)==true) {
                              $updateBusinessHalf = "UPDATE business SET status = 'FP' WHERE profile_id = $profileIdHalf";
                              if ($conn->query($updateBusinessHalf)==true ) {
                                  header('location:admin.php?success="Payments made successfull"');
                              }else {
                                die('Error in Updating status'.$updateBusinessHalf.'</br>'.$conn->error);
                              }

                        }else {
                          die('Error in Updating status'.$updateProfileAndUserHalf.'</br>'.$conn->error);
                        }


                  }else {
                    die('Error in Payments'.$updateUserPaymentsHalf.'</br>'.$conn->error);
                  }



          }
          else {
            header('location:admin.php?error="Payment submitted is not Full"');
          }
        }


    }
    elseif (isset($_POST['uploadFile'])=='gallery') {
              $file_name=$_FILES['file']['name'];
              $file_type = $_FILES['file']['type'];
              $file_size = $_FILES['file']['size'];
              $file_location = $_FILES['file']['tmp_name'];
              $folder_destination = '../userImageWork/';
              $date = date("Y/m/d");
              $time = date('H:i:s');

              $linkImage=$_POST['linkToDisplay'];
              $user_id = $_POST['users_id'];

              $cateG = $_POST['busCatId'];
              $businessTypeId = $_POST['selectSelected'];
              $subCateG =$_POST['businessSubCat'];

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

                    $insertGallery = "INSERT INTO gallery(business_id,pictureName,time,date,businessLink,status)
                    VALUES($businessTypeId,'$data_name','$time','$date','$linkImage','PP')";
                    if ($conn->query($insertGallery)==true) {
                          $updateBusinessCategory="UPDATE business SET category =$cateG,subCategory = $subCateG where business_id=$businessTypeId";
                          if ($conn->query($updateBusinessCategory)==true) {
                            header("location:admin.php?success=business posted  successfull");
                          }
                          else{
                            // header("location:admin.php?error=Error in updating category");
                            die("Error failed".$updateBusinessCategory."<br>".$conn->error);
                          }
                    }else {
                      // die("Error failed".$insertGallery."<br>".$conn->error);
                     header("location:admin.php?error=Error in creating gallery");
                    }

              }
              else{
                header("location:admin.php?Error = in uploading picture");
              }


    }
    elseif (isset($_POST['btnSendInvoice'])) {
        $users_id = $_POST['users_id'];
        $businessName = $_POST['businessName'];
        $email = $_POST['email'];
        $sentDate = $_POST['sentDate'];
        $dueDate = $_POST['dueDate'];
        $customerNote = $_POST['customerN'];
        $service = $_POST['service'];
        $amountPaid = $_POST['amountPaid'];
        $discount = $_POST['discountValue'];
        $subtotal = $_POST['subtotal'];
        $taxInclusive = $_POST['taxInclusive'];
        $totalAmountPaid = $_POST['totalAmountPaid'];
        $time = date('H:i:s');

        $insertinvoice = "INSERT INTO invoice(users_id,businessName,email,date,customerNote,service,amount,discount,subtotal,
        Tax,Total,time,status,dueDate)VALUES($users_id,'$businessName','$email','$sentDate','$customerNote','$service',$amountPaid,$discount,
        $subtotal,$taxInclusive,$totalAmountPaid,'$time','S','$dueDate')";
        if ($conn->query($insertinvoice)==true) {
              header("location:admin.php?success = invoice sent successfull");
        }else {
          header("location:admin.php?Error = in creating invoice");
          // die("Error failed".$insertinvoice."<br>".$conn->error);
        }



    }
    else {
      header('location:admin.php?error="No request made!!"');
    }
  }
    else {
      header('location:admin.php?error="No connection made!!"');
    }










 ?>
