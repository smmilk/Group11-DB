<?php 
session_start();
error_reporting(1);
include('connection.php');
$eid = $_SESSION['create_account_logged_in'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>SIT Hotels</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <link href="css/style.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body style="margin-top:50px;">
  <?php
  include('Menu Bar.php');
  ?>
  <div class="container-fluid"><!--Primary Id-->
    <h1 class="text-center text-primary">Booking Details</h1><br>
    <div class="container">
      <div class="row">
        <table class="table table-striped table-bordered table-hover table-responsive" style="height:150px;">
          <tr>
            <th>Booking ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Mobile Number</th>
            <th>Country</th>
            <th>Room Type</th>
            <th>Check In Date</th>
            <th>Check Out Date</th>
            <th>Payment Amt</th>
            <th>Cancel</th>
            <th>Feedback</th>
          </tr>

          <?php 
          $query = "SELECT bd.booking_id, acc.name, acc.email, acc.mobile, acc.country, r.type AS room_type, bd.check_in_date, bd.check_out_date, p.payment_amount
                    FROM booking bd
                    INNER JOIN Payment p ON bd.booking_id = p.booking_id
                    INNER JOIN Account acc ON bd.account_id = acc.account_id
                    INNER JOIN Rooms r ON bd.room_id = r.room_id
                    WHERE acc.email = '$eid'";
          $result = mysqli_query($con, $query);

          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".$row['booking_id']."</td>";
            echo "<td>".$row['name']."</td>";
            echo "<td>".$row['email']."</td>";
            echo "<td>".$row['mobile']."</td>";
            echo "<td>".$row['country']."</td>";
            echo "<td>".$row['room_type']."</td>";
            echo "<td>".$row['check_in_date']."</td>";
            echo "<td>".$row['check_out_date']."</td>";
            echo "<td>".$row['payment_amount']."</td>";
            // Check if the current date is before one day of the check-in date
            $currentDate = date("Y-m-d");
            $cancelThreshold = date("Y-m-d", strtotime($row['check_in_date'] . " -1 day"));
            if ($currentDate < $cancelThreshold) {
                // Display "Cancel" link
                echo "<td><a href='cancel_order.php?order_id={$row['booking_id']}' style='color:Red'>Cancel</a></td>";
            } else {
                // Display a message indicating it's too late to cancel
                echo "<td><span style='color:Gray'>Cancellation Closed</span></td>";
            }
            // Check if the current date is past the checkout date
            if ($currentDate > $row['check_out_date']) {
              // Check if feedback has already been provided for the given booking ID
              $existingFeedback = $feedbackCollection->findOne(['feedback_id' => $row['booking_id']]);
              if ($existingFeedback) {
                echo "<td>";
                echo "<label style='color:Green'>Done</label>";
                echo "</td>";
              } else {
                // Feedback not provided
                $feedbackLink = "<a href='feedback.php?booking_id={$row['booking_id']}' style='color:Green'>Rate your stay</a>";
                echo "<td>";
                echo $feedbackLink;
                echo "</td>";
              }
            } else {
                echo "<td></td>"; // Leave the column empty if it's not yet time for feedback
            }
            echo "</tr>";
          }                         
          ?> 
        </table>
      </div>
    </div>
  </div>
  <?php
  include('Footer.php')
  ?>
</body>
</html>
