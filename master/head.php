<?php include('session.php'); ?>
<html>
<head>
    <title>Online Appointment System</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:200,300,400,500,700" rel="stylesheet">
    <link href="css/style.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="css/datatables.min.css">
</head>
<body>
    <div id="container">
        <table id="wrap" cellspacing="0">
            <tr>
                <td colspan="2" id="header"><h1>Online Appointment System</h1></td>
            </tr>
            <tr>
                <td colspan="2" id="menu">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About</a></li>
                    </ul>
                    <div class="welcome-text">
                        Welcome, <?php echo $_SESSION['log_uname']; ?>
                    </div>
                    <div class="menu-right">  
                        <a id="logout-btn" href="logout.php">Logout</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td id="pane">
                    <ul>

                    	<!-- Admin Pane -->
                    	<?php if($_SESSION['log_role'] == "admin"){ ?>
                           <li><a href="dashboard.php">Dashboard</a></li>
                           <li><a href="departments.php">Departments</a></li>
                           <li><a href="doctors.php">Doctors</a></li>
                           <li><a href="bookings.php">Bookings</a></li>
                           <li class="menu-end-item"><a href="lab.php">Laboratory</a></li>
                           <?php } ?>


                           <!-- patient Pane -->
                           <?php if($_SESSION['log_role'] == "patient"){  ?>
                            <li><a href="dashboard.php">Dashboard</a></li>
                            <li><a href="bookings.php">Bookings</a></li>
                            <li><a href="profile.php">My profile</a></li>
                            <?php } ?>


                            <!-- Doctor Pane -->
                            <?php if($_SESSION['log_role'] == "doctor"){  ?>
                                <li><a href="dashboard.php">Dashboard</a></li>
                                <li><a href="bookings.php">Bookings</a></li>
                                <li><a href="profile.php">My profile</a></li>
                                <?php } ?>
                            </ul>
                        </td>