<?php include('master/head.php'); ?>
<td class="content">
<?php if(isset($_SESSION['msg'])){
	echo $_SESSION['msg'];
	unset($_SESSION['msg']);
}
?>

<?php if ($_SESSION['log_role']=="admin"): ?>
	<!-- Admin Dashboard -->
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