<?php 
$i=1;
$sql=mysqli_query($con,"select * from Account where account_id=$i");
while($res=mysqli_fetch_assoc($sql))
{
?>
<!DOCTYPE html>
<html>
<head>
	<title>SIT Hotels</title>
	<link href="https://fonts.googleapis.com/css?family=Baloo+Bhai" rel="stylesheet">
</head>
<body>
<h1 style="background-color:#ed2553;border-radius:50px;text-align:center;font-family: 'Baloo Bhai', cursive;box-shadow:5px 5px 9px black;text-shadow:2px 2px #fff;">Admin Profile</h1><br>
<center><img src="../image/devlop/img2.png"style="width:180px;height:180px;background-color:blue;"class="img-circle"></center>
<div class="container"style="width:100%;">
  <form action="/action_page.php">
    <div class="form-group">
      <label for="email">Name:</label>
       <input type="text" id="username" value="<?php echo $res['name']; ?>" class="form-control" name="name" readonly="readonly"/>
    </div>
    <div class="form-group">
      <label for="pwd">Email:</label>
      <input type="text" class="form-control" id="pwd"  name="pwd"value="<?php echo $res['email']; ?>"readonly="readonly">
    </div>
  </form>
</div>
<?php 	
}
?>
</body>
</html>