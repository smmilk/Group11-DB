<script>
	function delRoom(id)
	{
		if(confirm("You want to delete this Room ?"))
		{
			window.location.href='delete_room.php?id='+id;	
		}
	}
</script>
<table class="table table-bordered table-striped table-hover">
	<h1>Room Details</h1><hr>
	<tr>
		<td colspan="10"><a href="dashboard.php?option=add_rooms" class="btn btn-primary">Add New Rooms</a></td>
	</tr>
	<tr style="height:40">
		<th>ID</th>
		<th>Image</th>
		<th>Room Type</th>
		<th>Price</th>
		<th>Details</th>
		<th>Current Occupant (Booking ID)</th>
		<th>Last Checked Out Guest (Booking ID)</th>
		<th>Quantity</th>
		<th>Update</th>
		<th>Delete</th>
	</tr>
	<?php 
	$i=1;
	$sql=mysqli_query($con,"select * from rooms");
	while($res=mysqli_fetch_assoc($sql))
	{
		$id=$res['room_id'];	
		$img=$res['image'];
		$path="../image/rooms/$img";
		
		// Get current occupants
		$currentOccupants = array();
		$currentDate = date("Y-m-d");
		$currentOccupantQuery = mysqli_query($con, "SELECT * FROM booking 
			WHERE room_id = $id AND check_in_date <= '$currentDate' AND check_out_date >= '$currentDate'");

		while ($currentRes = mysqli_fetch_assoc($currentOccupantQuery)) {
			$accountId = $currentRes['account_id'];
			$currentGuestQuery = mysqli_query($con, "SELECT * FROM account WHERE account_id = $accountId");
			$currentGuest = mysqli_fetch_assoc($currentGuestQuery);
			$currentOccupants[] = $currentGuest['name'] . " (" . $currentRes['booking_id'] . ")";
		}

		// Get last checked-out guest
		$lastCheckedOutGuests = array();
		$lastCheckedOutQuery = mysqli_query($con, "SELECT * FROM booking 
			WHERE room_id = $id AND check_out_date <= '$currentDate' 
			ORDER BY check_out_date DESC");

		while ($lastCheckedOutRes = mysqli_fetch_assoc($lastCheckedOutQuery)) {
			$accountId = $lastCheckedOutRes['account_id'];
			$lastCheckedOutGuestQuery = mysqli_query($con, "SELECT * FROM account WHERE account_id = $accountId");
			$lastCheckedOutGuest = mysqli_fetch_assoc($lastCheckedOutGuestQuery);
			$lastCheckedOutGuests[] = $lastCheckedOutGuest['name'] . " (" . $lastCheckedOutRes['booking_id'] . ")";
		}

	?>
		<tr>
			<td><?php echo $i; $i++; ?></td>
			<td><img src="<?php echo $path;?>" width="50" height="50"/></td>
			<td><?php echo $res['type']; ?></td>
			<td><?php echo $res['price']; ?></td>
			<td><?php echo $res['details']; ?></td>
			<td><?php echo !empty($currentOccupants) ? implode("<br>", $currentOccupants) : "NIL"; ?></td>
			<td><?php echo !empty($lastCheckedOutGuests) ? implode("<br>", $lastCheckedOutGuests) : "NIL"; ?></td>
			<td><?php echo $res['quantity']; ?></td>
			<td><a href="dashboard.php?option=update_room&id=<?php echo $id; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
			<td><a href="#" onclick="delRoom('<?php echo $id; ?>')"><span class="glyphicon glyphicon-remove" style='color:red'></span></a></td>
		</tr>	
	<?php 	
	}
	?>	
</table>
