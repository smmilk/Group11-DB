<?php 
$con=mysqli_connect("localhost","root","","sithotel") or die('DATABASE connection failed');
require 'vendor/autoload.php'; // include Composer's autoloader
// MongoDB connection
$client = new MongoDB\Client("mongodb+srv://user:inf2003@cluster0.bijbknu.mongodb.net/");
$feedbackCollection = $client->sithotel->feedback;
?>