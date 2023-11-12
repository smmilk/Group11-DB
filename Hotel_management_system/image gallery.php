<!DOCTYPE html>
<html lang="en">
<head><!--Head Open  Here-->
  <title>SIT Hotels</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <link href="css/style.css"rel="stylesheet"/>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head> <!--Head Open  Here-->
<body style="margin-top:50px;"> 
  <?php
      include('Menu Bar.php')
  ?>
<div class="container">
  <h2 style="padding-bottom: 40px">Image Gallery</h2>
  <div class="row" style="padding-bottom: 100px">
    <?php
    $dir_gallery = "image/gallery/";
    $images = glob($dir_gallery."*.jpg");
    foreach($images as $image){
    ?>
     <div class="col-md-4">
      <div class="thumbnail">
        <a href="<?php echo $image; ?>" target="_blank">
          <img src="<?php echo $image; ?>" style="width:100%;height:160px;">
        </a>
      </div>
    </div> 
    <?php  }?>
  </div>
</div>
<?php
  include('Footer.php')
?>
</body>
</html>