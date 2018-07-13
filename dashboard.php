<?php include('master/head.php'); ?>
<td class="content">
<?php if(isset($_SESSION['msg'])){
	echo $_SESSION['msg'];
	unset($_SESSION['msg']);
}
?>

<?php if ($_SESSION['log_role']=="admin"): ?>
		<div class="card-container">
			<div class="card bg-purple-light">
				<div class="card-title"></div>
				<div class="card-content">52</div>
				<div class="card-link"><a href="">agdchgk</a></div>
			</div>
			
			<div class="card bg-purple-light">
				<div class="card-title"></div>
				<div class="card-content">52</div>
				<div class="card-link">View all bookings</div>
			</div>
		</div>
<?php endif ?>


<?php if ($_SESSION['log_role']=="patient"): ?>
	<!-- Patient Dashboard -->
<?php endif ?>


<?php if ($_SESSION['log_role']=="doctor"): ?>
	<!-- Doctor Dashboard -->
<?php endif ?>

<?php if ($_SESSION['log_role']=="laboratorian"): ?>
	<!-- Laboratorian Dashboard -->
<?php endif ?>


</td>
<?php include('master/foot.php'); ?>