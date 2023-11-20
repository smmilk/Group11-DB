
<table class="table table-bordered table-striped table-hover">
	<h1>Room Booking Details</h1><hr>
	<tr>
		<th>Booking ID</th>
		<th>Account ID</th>
		<th>Room ID</th>
		<th>Check in Date</th>
		<th>Check Out Date</th>
		<th>Cancel Order</th>
	</tr>

<?php 
$i=1;
$sql=mysqli_query($con,"select * from booking");
while($res=mysqli_fetch_assoc($sql))
{
$oid=$res['id'];

?>
<tr>
		<td><?php echo $res['booking_id']; ?></td>
		<td><?php echo $res['account_id']; ?></td>
		<td><?php echo $res['room_id']; ?></td>
		<td><?php echo $res['check_in_date']; ?></td>
		<td><?php echo $res['check_out_date']; ?></td>
		<td><a style="color:red" href="cancel_order.php?booking_id=<?php echo $oid; ?>">Cancel</a></td>
	</td>
	</tr>
<?php 	
}

?>	
</table>