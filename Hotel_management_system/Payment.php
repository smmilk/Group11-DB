<?php 
include('Menu Bar.php');
include('connection.php');
if($eid=="")
{
header('location:Login.php');
}
// Retrieve booking information from the database
$booking_id = $_GET['booking_id'];
$booking_query = mysqli_query($con, "SELECT * FROM booking WHERE booking_id='$booking_id'");
$booking_info = mysqli_fetch_assoc($booking_query);

// Retrieve room information
$room_id = $booking_info['room_id'];
$room_query = mysqli_query($con, "SELECT * FROM rooms WHERE room_id='$room_id'");
$room_info = mysqli_fetch_assoc($room_query);

// Calculate total payment
$check_in_date = strtotime($booking_info['check_in_date']);
$check_out_date = strtotime($booking_info['check_out_date']);
$number_of_nights = ceil(($check_out_date - $check_in_date) / (60 * 60 * 24)); // Calculate number of nights

$total_payment = $number_of_nights * $room_info['price'];

// Display the total payment message
$msg = "<h1 style='color:blue'>Total Payment: $$total_payment</h1>";

if (isset($_POST['pay'])) {
  // Insert payment data into the Payment table
  $payment_date = date("Y-m-d"); // Current date

  $insertPaymentQuery = "INSERT INTO Payment (booking_id, payment_date, payment_amount) 
                        VALUES ('$booking_id', '$payment_date', '$total_payment')";

  if (mysqli_query($con, $insertPaymentQuery)) {
      // Redirect to order.php after successful payment
      header("Location: order.php");
      exit();
  } else {
      echo "Error: " . mysqli_error($con);
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
</head>
<body style="margin-top:50px;">
<div class="container-fluid"id="primary"style="padding-top: 50px;padding-bottom: 50px;"><!--Primary Id-->
  <center><h1 style="background-color:#ed2553;border-radius:50px;font-family: 'Baloo Bhai', cursive;box-shadow:5px 5px 9px blue;text-shadow:2px 2px#000;display:inline-block;">Payment</h1></center><br>
  <center><?php echo @$msg; ?></center>
  <div class="container"style="padding-top: 30px;padding-bottom: 20px;">
    <div class="row">
     <form class="form-horizontal-center" onsubmit="return validateCreditCard();" method="post">
       <div style="margin-right: 150px;margin-left: 150px;">
          <div class="form-group">
           <div class="row">
              <div class="control-label col-sm-4"><h4>Accepted Cards:</h4></div>
                <div class="col-sm-8">
                <i class="fa fa-cc-visa" style="color:navy;font-size:36px"></i>
              <i class="fa fa-cc-amex" style="color:blue;font-size:36px"></i>
              <i class="fa fa-cc-mastercard" style="color:red;font-size:36px"></i>
              <i class="fa fa-cc-discover" style="font-size:36px"></i>
          </div>
        </div>
      </div>

      <div class="form-group">
           <div class="row">
              <div class="control-label col-sm-4"><h4>Name on Card:</h4></div>
                <div class="col-sm-8">
                 <input type="text" name="nameoncard" class="form-control" required>
          </div>
        </div>
      </div>
      <div class="form-group">
           <div class="row">
              <div class="control-label col-sm-4"><h4>Credit Card No.:</h4></div>
                <div class="col-sm-8">
                 <input type="text" name="ccnumber" class="form-control" required/>
          </div>
        </div>
      </div>
      <div class="form-group">
           <div class="row">
              <div class="control-label col-sm-4"><h4>Exp Month:</h4></div>
                <div class="col-sm-8">
                 <select class="form-control" name="expmonth"required>
                  <option>January</option>
                  <option>February</option>
                  <option>March</option>
                  <option>April</option>
                  <option>May</option>
                  <option>June</option>
                  <option>July</option>
                  <option>August</option>
                  <option>September</option>
                  <option>October</option>
                  <option>November</option>
                  <option>December</option>
                 </select>
          </div>
        </div>
      </div>
      <div class="form-group">
           <div class="row">
              <div class="control-label col-sm-4"><h4>Exp Year:</h4></div>
                <div class="col-sm-8">
                 <input type="text" name="expyear" class="form-control" required/>
          </div>
        </div>
      </div>
      <div class="form-group">
           <div class="row">
              <div class="control-label col-sm-4"><h4>CVV:</h4></div>
                <div class="col-sm-8" style="margin-top: 15px">
                <input type="number" name="cvv" class="form-control" required/>
          </div>
        </div>
      </div><br>
      
      <div class="form-group">
           <div class="row">
              <div class="control-label col-sm-5"></div>
                <div class="col-sm-7	">
                 <input type="submit" value="Pay" name="pay" class="btn btn-primary"/>
          </div>
        </div>
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