<?php 

if(isset($update))
{
	$imgNew=$_FILES['img']['name'];
	
	$sql="insert into image_gallery values('','$imgNew')";	
	
	if(mysqli_query($con,$sql))
	{
	move_uploaded_file($_FILES['img']['tmp_name'],"../image/image gallery/".$_FILES['img']['name']);	
	header('location:dashboard.php?option=image_gallery');	
	}
	
}
?>
<form method="post" enctype="multipart/form-data">
<table class="table table-bordered">
	<tr>	
		<th>Image</th>
		<td><input type="file" name="img" accept="image/*" class="form-control"/>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<input type="submit" class="btn btn-primary" value="Add new Image" name="update"/>
		</td>
	</tr>
</table> 
</form>