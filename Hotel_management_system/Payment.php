<?php 
include('Menu Bar.php');
if($eid=="")
{
header('location:Login.php');
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
  <div class="container"style="padding-top: 30px;padding-bottom: 20px;">
    <div class="row">
     <form class="form-horizontal-center" method="post">
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
                 <input type="text" name="expmonth" class="form-control" required/>
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
                 <input type="submit" value="Proceed to Pay" name="update" class="btn btn-primary"/>
          </div>
        </div>
      </div>
	  
    </div>
<!--User Profile Update Query-->
        </form>
      </div>
   </div>
 </div>
<?php
include('Footer.php')
?>
</body>
</html>