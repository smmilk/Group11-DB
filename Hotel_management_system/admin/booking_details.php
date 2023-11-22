<?php
// Delete bookings without corresponding payments
$deleteQuery = "
    DELETE FROM booking
    WHERE NOT EXISTS (
        SELECT 1
        FROM payment
        WHERE payment.booking_id = booking.booking_id
    )
";
mysqli_query($con, $deleteQuery);
?>
<table class="table table-bordered table-striped table-hover">
	<h1>Room Booking Details</h1><hr>
	<tr>
		<th>Booking ID</th>
		<th>Account Name</th>
		<th>Room Type</th>
		<th>Check in Date</th>
		<th>Check Out Date</th>
		<th>Cancel Order</th>
	</tr>

<?php 
$sql=mysqli_query($con,"SELECT booking.booking_id, account.name, rooms.type, booking.check_in_date, booking.check_out_date
FROM booking
JOIN account ON booking.account_id = account.account_id
JOIN rooms ON booking.room_id = rooms.room_id");
while($res=mysqli_fetch_assoc($sql))
{
$oid=$res['booking_id'];

?>
<tr>
		<td><?php echo $res['booking_id']; ?></td>
		<td><?php echo $res['name']; ?></td>
		<td><?php echo $res['type']; ?></td>
		<td><?php echo $res['check_in_date']; ?></td>
		<td><?php echo $res['check_out_date']; ?></td>
		<td><a style="color:red" href="cancel_order.php?booking_id=<?php echo $oid; ?>">Cancel</a></td>
	</td>
	</tr>
<?php 	
}

?>	
</table>