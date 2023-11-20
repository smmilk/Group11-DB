<?php 
include('../connection.php');
$oid=$_GET['booking_id'];
$q=mysqli_query($con,"delete from booking where booking_id='$oid' ");
if($q)
{
header('location:dashboard.php?option=booking_details');
}
?>