<?php 
include('../../connection.php');

$id=$_GET['id'];
$sql=mysqli_query($con,"select * from image_gallery where id='$id' ");
$res=mysqli_fetch_assoc($sql);
$img=$res['image'];
unlink("../image/image gallery/$img");

if(mysqli_query($con,"delete from image_gallery where id='$id' "))
{
header('location:../dashboard.php?option=image_gallery');	
}

?>