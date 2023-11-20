<!DOCTYPE html>
<html>
<head>
<title>SIT Hotels</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <link href="css/style.css"rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet">
</head>
<body style="margin-top:50px;">
	<?php
      include('Menu Bar.php')
  ?><br><br><br>
	<div class="container-fluid"style="margin-top:2%;">
		<div class="continer">
			<div class="row">
				<div class="col-sm-2"></div>
				<div class="col-sm-7" style="padding-bottom:30px;">
					
<?php 
include('connection.php');
$room_id=$_GET['room_id'];
$sql=mysqli_query($con,"select * from Rooms where room_id='$room_id' ");
$res=mysqli_fetch_assoc($sql);
?>
    <img src="image/rooms/<?php echo $res['image']; ?>"style="width:850px;">
		<h2 class="Ac_Room_Text"><?php echo $res['type']; ?></h2>
    <h3 class="Ac_Room_Text">$<?php echo $res['price']; ?> per night</h3></br>
		<p class="text-justify">
      <?php echo $res['details']; ?>
</p>
    <div class="row">
      <h2>Ratings & Feedback</h2>
        <?php
        // MySQL query to get a list of booking_id based on room_id
        $bookingIdQuery = "SELECT id FROM Booking WHERE room_id = $room_id";
        $bookingIdResult = mysqli_query($con, $bookingIdQuery);

        // Fetch feedback for each booking_id
        while ($bookingIdRow = mysqli_fetch_assoc($bookingIdResult)) {
          $bookingId = $bookingIdRow['id'];

          // MongoDB query to get feedback for the specific booking_id
          $feedbackQuery = ['booking_id' => "$bookingId"];
          $feedbackData = $feedbackCollection->find($feedbackQuery);

          foreach ($feedbackData as $feedback) {
            echo "<p><strong>Guest Name:</strong> {$feedback['guest_name']}</p>";
            echo "<p><strong>Feedback Text:</strong> {$feedback['feedback_text']}</p>";
            echo "<p><strong>Rating:</strong> {$feedback['rating']}</p>";
            echo "<p><strong>Timestamp:</strong> {$feedback['timestamp']}</p>";
            echo "<hr>";
          }
        }
        ?>
    </div>
    <div class="row">
      <h2>Amenities & Facilities</h2>
      <img src="image/icon/wifi.png"class="img-responsive">
      <a href="Login.php" class="btn btn-danger">Book Now</a><br><br>
      </div>
	</div>
				<div class="col-sm-3">
					<div class="panel panel-primary">
					<div class="panel-heading">
						<h4 align="center">Room Types</h4>
					</div><br>
					<div class="panel-body-right text-center">
    <!-- Fetch Mysql Database Select Query Room Details -->
						<?php
            include('connection.php');
            $sql1=mysqli_query($con,"select * from Rooms");
           while($result1= mysqli_fetch_assoc($sql1))
           {

            ?>
            <a href="room_details.php?room_id=<?php echo $result1['room_id']; ?>"><?php echo $result1['type']; ?></a><hr>
            <?php } ?>
    <!-- Fetch Mysql Database Select Query Room Details -->
    					
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
  <?php
      include('footer.php')
  ?>
</body>
</html>
