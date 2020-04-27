
    <?php include_once('../connection.php');
          if (isset($_POST['businessId'])) {
                $busId = $_POST['businessId'];

                $selectIdBusFromProfileFrist = "SELECT particularBusinessName,particularBusinessDescription,pictureName,businessLink,
                gallery.date,gallery.time,business_id from gallery inner join business using(business_id) inner join profile using(profile_id)
                 where business.business_id = $busId";

                 $resultSelectBusFromProfileFirst = $conn->query($selectIdBusFromProfileFrist);
                 $rowFirst = $resultSelectBusFromProfileFirst->fetch_array();

          }
          function getbusinessComments($conn,$Id)
          {
             $selectBusComments="SELECT comment,comments.date,comments.time
             from comments inner join business using (business_id) where comments.business_id = $Id";

             $resultSet = $conn->query($selectBusComments);
             while ($rowBusComments = $resultSet->fetch_array()) {?>
               <!-- Comments List -->
               <div class="comments">
               <!-- Comment -->
               <div class="comment" >


               <!-- Comment Box -->
               <div class="comment-box">
                 <div class="comment-text"> <?php echo $rowBusComments[0];?> </div>
                 <div class="comment-footer">
                   <div class="comment-info">

                     <span class="comment-date"><?php echo $rowBusComments[1]." ".$rowBusComments[2];?></span>
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



    ?>
    <div class="fromAjax">
      <div class="row">


      <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 bigPictureIfrmae" >


                  <iframe width="100%" class="iframePic usersIframe" height="400px" frameborder="0" src="<?php echo $rowFirst[3];?>" ></iframe>

                  <form class="" action="usersHandler.php" method="post">
                    <div class="formWorkInfor">
                      <div class="form-group">

                        <input type="text" style="color:black;" name="businessName" value="<?php echo $rowFirst[0];?>">
                         <textarea id="comments" class="input-textarea" name="busineDescription" placeholder="Enter your Descriptions here...">
                           <?php echo $rowFirst[1]; ?>
                         </textarea>
                       </div>

                       <br>
                       <div class="form-group">
                         <button type="submit" name="btnUpdateBus" value="<?php echo $rowFirst[6]; ?>" id="submit">update</button><br>
                       </div>
                    </div>
                  </form>




      </div>
      <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 bigPictureIfrmae" >
        <div class="comments-app" >


            <!-- From -->
            <div class="comment-form">
            <!-- Comment Avatar -->
            <div class="comment-avatar">
            <img src="../userImageWork/<?php echo $rowFirst[2] ?>">
            </div>


            <form class="form" action="usersHandler.php" method="post" name="form">
            <div class="form-row">

              <textarea
                        class="input"
                        name="commentMessage"
                        ng-model="cmntCtrl.comment.text"
                        placeholder="Add comment..."
                        rows="3"
                        required>
              </textarea>
              <input type="hidden" name="business_id" value="<?php echo $rowFirst[6]; ?>">
            </div>

            <div class="form-row">
              <input type="submit" name="btnAddComments" value="Add Comment">
            </div>
            </form>
            </div>

              <?php
                $busId = $rowFirst[6];
                getbusinessComments($conn,$busId);
               ?>
            </div>

      </div>
    </div>
  </div>
