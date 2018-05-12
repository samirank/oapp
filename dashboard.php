<?php include('master/head.php'); ?>
<td class="content">
<?php if(isset($_SESSION['msg'])){
	echo $_SESSION['msg'];
	unset($_SESSION['msg']);
} ?>
</td>
<?php include('master/foot.php'); ?>