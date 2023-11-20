<?php 
include('connection.php');
$oid=$_GET['order_id'];
$q=mysqli_query($con,"delete from booking where booking_id='$oid' ");
if($q)
{
header('location:order.php');
}
?>