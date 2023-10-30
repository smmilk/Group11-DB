<?php 
include('Menu Bar.php');
include('connection.php');
if($eid=="")
{
header('location:Login.php');
}
$sql= mysqli_query($con,"select * from create_account where email='$eid' "); 
$result=mysqli_fetch_assoc($sql);
//print_r($result);
extract($_REQUEST);
error_reporting(1);
if(isset($savedata))
{
  $sql= mysqli_query($con,"select * from room_booking_details where email='$email' and room_type='$room_type' ");
  if(mysqli_num_rows($sql)) 
  {
  $msg= "<h1 style='color:red'>You have already booked this room</h1>";    
  }
  else
  {

   $sql="insert into room_booking_details(name,email,phone,address,country,room_type,Occupancy,check_in_date,check_in_time,check_out_date) 
  values('$name','$email','$phone','$address','$country',
  '$room_type','$Occupancy','$cdate','$ctime','$codate')";
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
    function toggler(divId) { 
            $("#" + divId).toggle(); 
        } 
    function unhide() { 
            toggler('paymentdiv'); 
            toggler('toggleBtn'); 
        } 
  </script> 
</head>
<body style="margin-top:50px;">
  <?php
  include('Menu Bar.php');
  ?>
<div class="container-fluid text-center"id="primary"style="padding-top: 50px;padding-bottom: 50px;"><!--Primary Id-->
  <h1>Booking Form</h1><br>
  <div class="container">
    <div class="row">
      <?php echo @$msg; ?>
      <!--Form Containe Start Here-->
     <form class="form-horizontal" method="post">
       <div class="col-sm-6">
         <div class="form-group">
           <div class="row">
              <div class="control-label col-sm-4"><h4>Name:</h4></div>
                <div class="col-sm-8">
                 <input type="text" value="<?php echo $result['name']; ?>" class="form-control" name="name" placeholder="Enter Your Name"required>
          </div>
        </div>
      </div>

        <div class="form-group">
          <div class="row">
           <div class="control-label col-sm-4"><h4>Email:</h4></div>
          <div class="col-sm-8">
              <input type="email" value="<?php echo $result['email']; ?>" readonly="readonly" class="form-control" name="email"  placeholder="Enter Your Email"required/>
          </div>
        </div>
        </div>

        <div class="form-group">
          <div class="row">
           <div class="control-label col-sm-4"><h4>Mobile:</h4></div>
          <div class="col-sm-8">
              <input type="number" value="<?php echo $result['mobile']; ?>" class="form-control" name="phone" placeholder="Enter Your Phone Number"required>
          </div>
        </div>
        </div>

        <div class="form-group">
          <div class="row">
           <div class="control-label col-sm-4"><h4>Address:</h4></div>
          <div class="col-sm-8">
              <textarea name="address" class="form-control" readonly="readonly" placeholder="Enter Your Address"required><?php echo $result['address'];  ?></textarea>
          </div>
        </div>
        </div>

         <div class="form-group">
          <div class="row">
           <div class="control-label col-sm-4"><h4>Country:</h4></div>
          <div class="col-sm-8">
              <input type="text" class="form-control" readonly="readonly"  value="<?php echo $result['country']; ?>" name="country" placeholder="Enter Your Country Name"required>
          </div>
        </div>
        </div>
        </div>
           <div class="col-sm-6">
            <div class="form-group">
              <div class="row">
                <div class="control-label col-sm-5"><h4>Room Type:</h4></div>
                  <div class="col-sm-7">
                <select class="form-control" name="room_type"required>
                  <option>Deluxe Room</option>
                  <option>Luxurious Suite</option>
                  <option>Standard Room</option>
                  <option>Suite Room</option>
                  <option>Twin Deluxe Room</option>
               </select>
              </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="control-label col-sm-5"><h4>Check In Date:</h4></div>
                  <div class="col-sm-7">
                  <input type="date" name="cdate" class="form-control" required>
                  </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                 <div class="control-label col-sm-5"><h4>Check In Time:</h4></div>
                   <div class="col-sm-7">
                    <input type="time" name="ctime" class="form-control"required>
                  </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="control-label col-sm-5"><h4>Check Out Date:</h4></div>
                <div class="col-sm-7">
                  <input type="date" name="codate" class="form-control"required>
                </div> 
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <label class="control-label col-sm-5"><h4 id="top">Occupancy :</h4></label>
                <div class="col-sm-7">
                  <div class="radio-inline"><input type="radio" value="Single" name="Occupancy"required >Single</div>
                  <div class="radio-inline"><input type="radio" value="Coupe" name="Occupancy" required>Coupe</div>
                  <div class="radio-inline"><input type="radio" value="Family" name="Occupancy" required>Family</div>
                  <div class="radio-inline"><input type="radio" value="Booking for someone" name="Occupancy" required>Booking for someone</div>
                </div> 
              </div>
            </div>
            <input type="button"value="Next" id="toggleBtn"onClick="unhide()" class="btn btn-danger"required/>
          </div>
          </div>
          <div class="row" id="paymentdiv" style="padding-top:60px;padding-bottom:50px;display:none;">
            <div class="col-sm-6">
             <div class="form-group">
                <div class="row">
                  <div class="control-label col-sm-5"><h4>Accepted Cards:</h4></div>
                  <div class="col-sm-7">
                    <i class="fa fa-cc-visa" style="color:navy;font-size:36px"></i>
                    <i class="fa fa-cc-amex" style="color:blue;font-size:36px"></i>
                    <i class="fa fa-cc-mastercard" style="color:red;font-size:36px"></i>
                    <i class="fa fa-cc-discover" style="font-size:36px"></i>
                  </div> 
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="control-label col-sm-5"><h4>Name on Card:</h4></div>
                  <div class="col-sm-7">
                    <input type="text" name="nameoncard" class="form-control"required>
                  </div> 
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="control-label col-sm-5"><h4>Credit Card No.:</h4></div>
                  <div class="col-sm-7">
                    <input type="number" name="ccnumber" class="form-control"required>
                  </div> 
                </div>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <div class="row">
                  <div class="control-label col-sm-5"><h4>Exp Month:</h4></div>
                  <div class="col-sm-7">
                    <input type="text" name="expmonth" class="form-control"required>
                  </div> 
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="control-label col-sm-5"><h4>Exp Year:</h4></div>
                  <div class="col-sm-7">
                    <input type="text" name="expyear" class="form-control"required>
                  </div> 
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="control-label col-sm-5"><h4>CVV:</h4></div>
                  <div class="col-sm-7">
                    <input type="number" name="cvv" class="form-control"required>
                  </div> 
                </div>
              </div>
              <input type="submit"value="Proceed to Payment" name="savedata" class="btn btn-danger"required/>
            </div> 
          </form><br>
        </div>
      </div>
    </div>
  </div>
<?php
include('Footer.php')
?>
</body>
</html>
