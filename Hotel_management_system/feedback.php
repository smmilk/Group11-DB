<?php
include('Menu Bar.php');
include('connection.php');

if($eid == "") {
    header('location:Login.php');
}
$bi=$_GET['booking_id'];

$sql = mysqli_query($con, "select * from account where email='$eid' "); 
$result = mysqli_fetch_assoc($sql);

extract($_REQUEST);
error_reporting(1);

use MongoDB\BSON\UTCDateTime;
$utcdatetime = new UTCDateTime();
$datetime = $utcdatetime->toDateTime();
$timezone = new DateTimeZone('Asia/Shanghai'); // UTC+8 timezone

// Change the timezone of the DateTime object
$datetime->setTimezone($timezone);

if (isset($savedata)) {
  $insertOneResult = $feedbackCollection->insertOne([
    'feedback_id' => $bi,
    'guest_name' => $n,
    'feedback_text' => $comment,
    'rating' => $rate,
    'timestamp' => $datetime->format('D, d M Y H:i')
  ]);
  echo "<script>
  alert('Thank you for your feedback!');
  window.location.href='order.php';
  </script>";
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
  <style>
    .rate {
    float: left;
    height: 46px;
    padding: 0 10px;
    }
    .rate:not(:checked) > input {
        position:absolute;
        top:-9999px;
    }
    .rate:not(:checked) > label {
        float:right;
        width:1em;
        overflow:hidden;
        white-space:nowrap;
        cursor:pointer;
        font-size:30px;
        color:#ccc;
    }
    .rate:not(:checked) > label:before {
        content: '★ ';
    }
    .rate > input:checked ~ label {
        color: #ffc700;    
    }
    .rate:not(:checked) > label:hover,
    .rate:not(:checked) > label:hover ~ label {
        color: #deb217;  
    }
    .rate > input:checked + label:hover,
    .rate > input:checked + label:hover ~ label,
    .rate > input:checked ~ label:hover,
    .rate > input:checked ~ label:hover ~ label,
    .rate > label:hover ~ input:checked ~ label {
        color: #c59b08;
    }
  </style>
</head>
<body style="margin-top:50px;">
  <?php
  include('Menu Bar.php');
  ?>
  <div class="container" style="padding-top:100px;padding-bottom:100px;">
    <div class="col-sm-8 text-center" style="margin-left:150px;margin-right:150px;">
      <div class="panel panel-primary">
        <div class="panel-heading">Feedback</div>
        <div class="panel-body">
          <?php echo @$msg; ?>
          <div class="feedback">
            <form method="post">
              <div class="form-group">
                <h4 align="left">Name:</h4>
                <input type="text" name="n" value="<?php echo $result['name']; ?>" class="form-control"placeholder="Enter Your Name"required>
              </div>
              <div class="form-group">
                <h4 align="left">Email:</h4>
                <input type="Email" name="e" value="<?php echo $result['email']; ?>" readonly="readonly" class="form-control"placeholder="Email"required>
              </div>
              <div class="form-group">
                <h4 align="left">Mobile Number:</h4>
                <input type="Number" name="mob" value="<?php echo $result['mobile']; ?>" readonly="readonly" class="form-control"placeholder="Mobile Number"required>
              </div>
              <div class="form-group">
                <h4 align="left">Comments:</h4>
                <textarea type="Text" name="comment" class="form-control"placeholder="Type Your Comments"required></textarea>
              </div>
              <div class="form-group">
                <div class="rate">
                    <input type="radio" id="star5" name="rate" value="5" />
                    <label for="star5" title="5 stars">5 stars</label>
                    <input type="radio" id="star4" name="rate" value="4" />
                    <label for="star4" title="4 stars">4 stars</label>
                    <input type="radio" id="star3" name="rate" value="3" />
                    <label for="star3" title="3 stars">3 stars</label>
                    <input type="radio" id="star2" name="rate" value="2" />
                    <label for="star2" title="2 stars">2 stars</label>
                    <input type="radio" id="star1" name="rate" value="1" />
                    <label for="star1" title="1 star">1 star</label>
                </div>
              </div>
              <input type="submit" value="Submit" name="savedata" class="btn btn-primary btn-group-justified"required>
            </form>     
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include('Footer.php') ?>

</body>
</html>