<?php 
include('Menu Bar.php');
include('connection.php');
if($eid=="")
{
header('location:Login.php');
}
$sql= mysqli_query($con,"select * from Account where email='$eid' "); 
$result=mysqli_fetch_assoc($sql);
$sqltype=mysqli_query($con,"select * from rooms");
//print_r($result);
extract($_REQUEST);
error_reporting(1);
if(isset($savedata))
{
  $sql= mysqli_query($con,"select * from Booking where email='$email' and room_type='$room_type' ");
  if(mysqli_num_rows($sql)) 
  {
  $msg= "<h1 style='color:red'>You have already booked this room</h1>";    
  }
  else
  {

   $sql="insert into booking(account_id,room_id,check_in_date,check_out_date) 
  values('','','$ctime','$codate')";
   if(mysqli_query($con,$sql))
   {
   $msg= "<h1 style='color:blue'>You have Successfully booked this room</h1><h2><a href='order.php'>View </a></h2>"; 
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
            <input type="submit"value="Next" id="next-button" onclick="toggle()" class="btn btn-danger"required/></br>
          </div>
        </div>
      </form>
    </div>
    <div class="row">
      <!--Payment Form Starts Here-->
      <form class="form-horizontal" method="post" id="payment-form" style="display:none;">
        <h1>Payment Due: $</h1>
        <div class="col-sm-6">
          <div class="control-label col-sm-4">
            <h4>Accepted Cards:</h4>
            <h4>Name on Card:</h4>
            <h4>Credit Card No.:</h4>
          </div>
          <div class="col-sm-8">
            <i class="fa fa-cc-visa" style="color:navy;font-size:36px"></i>
            <i class="fa fa-cc-amex" style="color:blue;font-size:36px"></i>
            <i class="fa fa-cc-mastercard" style="color:red;font-size:36px"></i>
            <i class="fa fa-cc-discover" style="font-size:36px"></i>
            <input type="text" name="nameoncard" class="form-control"required>
            <input type="number" name="ccnumber" class="form-control"required>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="control-label col-sm-4">
            <h4>Exp Month:</h4>
            <h4>Exp Year:</h4>
            <h4>CVV:</h4>
          </div>
          <div class="col-sm-8">  
            <input type="text" name="expmonth" class="form-control"required>
            <input type="text" name="expyear" class="form-control"required>
            <input type="number" name="cvv" class="form-control"required>
            <input type="button"value="Back"id="back-button" class="btn btn-danger" required/>
            <input type="submit"value="Proceed to Pay" name="savedata" class="btn btn-danger"required/>
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
<script>
$(document).ready(function() {
  // Function to validate the booking form
  function validateBookingForm() {
      var isValid = true;

      // Validate each field in the booking form
      $('#booking-form input, #booking-form select').each(function() {
          if ($(this).prop('required') && $(this).val() === '') {
              isValid = false;
          }
      });

      // Validate the checkout date
      var checkInDate = new Date($('#booking-form input[name="cdate"]').val());
      var checkOutDate = new Date($('#booking-form input[name="codate"]').val());

      if (checkOutDate <= checkInDate) {
          isValid = false;
      }

      return isValid;
  }

  // Function to toggle between booking form and payment form
  function toggleForms() {
      if (validateBookingForm()) {
          // Disable input fields and select elements in the booking form
          $('#booking-form input, #booking-form select').prop('readonly', true).prop('disabled', true);
          //$('#booking-form').hide();
          $('#payment-form').show();
      } else {
          alert('Please fill in all required fields and ensure the checkout date is after the check-in date.');
      }
  }

  // Back button click event to go back to the booking form
  $('#back-button').click(function() {
      // Enable input fields and select elements in the booking form
      $('#booking-form input, #booking-form select').prop('readonly', false).prop('disabled', false);
      //$('#booking-form').show();
      $('#payment-form').hide();
  });

  // Booking form submission event (you may need to adjust this based on your needs)
  $('#booking-form').submit(function(event) {
      event.preventDefault(); // Prevent the form from submitting
      toggleForms(); // Proceed to payment form
  });

  // You can add additional validation for the payment form if needed

});
</script>