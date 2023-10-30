<script>
	function delGallery(id)
	{
		if(confirm("You want to delete this image ?"))
		{
		window.location.href='image_gallery/delete_gallery.php?id='+id;	
		}
	}
</script>
<table class="table table-bordered table-striped table-hover">
	<tr>
	<td colspan="5"><a href="dashboard.php?option=add_gallery" class="btn btn-primary">Add New</a></td>
	</tr>
	<tr style="height:40">
		<th>Sr No</th>
		<th>Image</th>
		<th>Delete</th>
	</tr>
<?php 
$i=1;
$sql=mysqli_query($con,"select * from image_gallery");
while($res=mysqli_fetch_assoc($sql))
{
$id=$res['id'];	
$img=$res['image'];
$path="../image/image gallery/$img";
?>
<tr>
		<td><?php echo $i;$i++; ?></td>
		<td><img src="<?php echo $path;?>" width="100" height="100"/></td>
		<td><a href="#" onclick="delGallery('<?php echo $id; ?>')"><span class="glyphicon glyphicon-remove" style='color:red'></span></a></td>
	</tr>	
<?php 	
}
?>	
	
</table>