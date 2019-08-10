<?php

if(!isset($_POST['submit'])) { //if one try to access createcampaign.inc.php without access
    header("Location: ../createCampaign.php");
    exit();
} else {

    include_once 'dbh.inc.php'; //creating connection to database

    $campaignName = $_POST['campaignName'];
    $campaignType = $_POST['campaignType'];
    $campaignDays = $_POST['campaignDays'];
    $campaignAmount = $_POST['campaignAmount'];
    $campaignDescription = $_POST['campaignDescription'];
    $camapignPhone = $_POST['phone'];

    // error handling
    if(!preg_match("/^[a-zA-Z'. -]+$/", $campaignName)) {    
        header("Location: ../createCampaign.php?campaign=invalidname");
        exit();
    } else {
        // check if there is already a campaign with same inputted campaignName by the organizer
        $sql = "SELECT * FROM campaigns WHERE campaign_name = '$campaignName'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0) {
            header("Location: ../createCampaign.php?campaign=camapignNameTaken");
            exit();
        } else {
             // insert the input value into database
             $sql = "INSERT INTO campaigns(campaign_name, campaign_type, campaign_days, campaign_amount, campaign_description,camapignPhone) VALUES('$campaignName','$campaignType',$campaignDays,$campaignAmount,'$campaignDescription',$camapignPhone);";
             $insertSuccess = mysqli_query($conn, $sql);
// to-do
             // if campaign input data successfully inserted in database then redirect him to success page with link of organizer profile
             if($insertSuccess) {
                echo "<h1>inserted into database</h1>";
             } else {
                 echo $conn->error;
             }
        }
    }

}