<table class="table table-bordered table-striped table-hover">
	<h1>User Registration</h1><hr>
	<tr>
		<th>Account ID</th>
		<th>Name</th>
		<th>Email</th>
		<th>Password</th>
		<th>Mobile</th>
		<th>Gender</th>
		<th>Country</th>
	</tr>
	<?php 
$i=1;
$sql=mysqli_query($con,"select * from account");
while($res=mysqli_fetch_assoc($sql))
{
?>
<tr>
		<td><?php echo $res['account_id']; ?></td>
		<td><?php echo $res['name']; ?></td>
		<td><?php echo $res['email']; ?></td>
		<td><?php echo $res['password']; ?></td>
		<td><?php echo $res['mobile']; ?></td>
		<td><?php echo $res['gender']; ?></td>
		<td><?php echo $res['country']; ?></td>
	</td>
	</tr>	
<?php 	
}
?>	