<?php 
include('Menu Bar.php');
include('connection.php');

if($eid == "") {
    header('location:Login.php');
}

$sql = mysqli_query($con, "select * from account where email='$eid' "); 
$result = mysqli_fetch_assoc($sql);
$sqltype = mysqli_query($con, "select * from rooms");

extract($_REQUEST);
error_reporting(1);

if (isset($savedata)) {
  // Validate check-in and check-out dates
  $cdate_timestamp = strtotime(date('Y-m-d', strtotime($cdate)));
  $codate_timestamp = strtotime(date('Y-m-d', strtotime($codate)));

  if ($cdate_timestamp >= $codate_timestamp) {
      $msg = "<h1 style='color:red'>Invalid date range: Check-in date must be before check-out date</h1>";
  } else {
      // Check availability
      $roomid = mysqli_query($con, "SELECT room_id FROM rooms WHERE type='$room_type'");
      $resroomid = mysqli_fetch_assoc($roomid);

      // SQL query to check room availability
      $checkAvailabilityQuery = "
      SELECT
          r.room_id,
          r.type,
          r.price,
          r.details,
          r.image,
          r.quantity - COALESCE(b.quantity_booked, 0) AS available_quantity
      FROM
          Rooms r
      LEFT JOIN (
          SELECT
              room_id,
              COUNT(*) AS quantity_booked
          FROM
              Booking
          WHERE
              check_out_date > '$cdate' AND check_in_date < '$codate'
          GROUP BY
              room_id
      ) b ON r.room_id = b.room_id
      WHERE
          r.type = '$room_type'
      GROUP BY
          r.room_id, r.type, r.price, r.details, r.image, r.quantity
      HAVING
          available_quantity > 0;
      ";


      $availabilityResult = mysqli_query($con, $checkAvailabilityQuery);
      $availability = mysqli_fetch_assoc($availabilityResult);

      if ($availability['available_quantity'] <= 0) {
          $msg = "<h1 style='color:red'>Sorry, the selected room type is not available for the specified date range</h1>";
      } else {
          // Save data into the booking table
          $sql = "INSERT INTO booking(account_id, room_id, check_in_date, check_out_date) 
                  VALUES ('{$result['account_id']}', '{$availability['room_id']}', '$cdate', '$codate')";

          if (mysqli_query($con, $sql)) {
              // Get the ID of the last inserted booking
              $booking_id = mysqli_insert_id($con);

              // Redirect to Payment.php with the booking ID as a parameter
              header("Location: Payment.php?booking_id=$booking_id");
              exit(); // Ensure that no further code is executed after the redirect
          } else {
              $msg = "<h1 style='color:red'>Error saving booking data: " . mysqli_error($con) . "</h1>";
          }
      }
  }
}
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
  <link href="css/style.css"rel="stylesheet"/>
 <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script type="text/javascript">
    window.onload=function(){
      var today = new Date().toISOString().split('T')[0];
      document.getElementsByName("cdate")[0].setAttribute('min', today);
      document.getElementsByName("codate")[0].setAttribute('min', today);
    }
  </script>
</head>
<body style="margin-top:50px;">
  <?php
  include('Menu Bar.php');
  ?>
<div class="container-fluid text-center"id="primary"style="padding-top: 50px;padding-bottom: 50px;"><!--Primary Id-->
  <h1>Booking Form</h1></br>
  <div class="container">
    <div class="row">
      <?php echo @$msg; ?>
      <!--Booking Form Starts Here-->
      <form class="form-horizontal" method="post" id="booking-form">
        <div class="col-sm-6">
          <div class="control-label col-sm-4">
            <h4>Name:</h4>
            <h4>Email:</h4>
            <h4>Mobile:</h4>
            <h4>Country:</h4>
          </div>
          <div class="col-sm-8">
            <input type="text" value="<?php echo $result['name']; ?>" class="form-control" name="name" placeholder="Enter Your Name"required></br>
            <input type="email" value="<?php echo $result['email']; ?>" readonly="readonly" class="form-control" name="email"  placeholder="Enter Your Email"required/> </br>         
            <input type="number" value="<?php echo $result['mobile']; ?>" class="form-control" name="phone" placeholder="Enter Your Phone Number"required></br>
            <input type="text" class="form-control" readonly="readonly"  value="<?php echo $result['country']; ?>" name="country" placeholder="Enter Your Country Name"required></br>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="control-label col-sm-4">
            <h4>Room Type:</h4>
            <h4>Check In Date:</h4>
            <h4>Check Out Date:</h4>
          </div>
          <div class="col-sm-8">
            <select class="form-control" name="room_type"required>
              <?php while ($restype = mysqli_fetch_array($sqltype,MYSQLI_ASSOC)):;?>
              <option value="<?php echo $restype["type"];?>"><?php echo $restype["type"];?></option>
              <?php endwhile; ?>
            </select></br>
            <input type="date" name="cdate" class="form-control" onkeydown="return false" required></br>
            <input type="date" name="codate" class="form-control" onkeydown="return false" required></br>
            <input type="submit"value="Proceed to Payment"name="savedata" class="btn btn-danger"required/></br>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php
include('Footer.php')
?>
</body>
</html> 