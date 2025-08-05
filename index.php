<?php
/**
 * Online Appointment System - Home Page
 * 
 * Main landing page for the appointment booking system
 */

session_start();
require_once 'config.php';
require_once 'includes/functions.php';
require_once 'master/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Book appointments with doctors and schedule laboratory tests online">
    <meta name="keywords" content="appointment, doctor, laboratory, medical, healthcare">
    <title><?php echo APP_NAME; ?> - Book Appointments Online</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo generateCSRFToken(); ?>">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-hospital-alt me-2"></i>
                <?php echo APP_NAME; ?>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">
                            <i class="fas fa-home me-1"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">
                            <i class="fas fa-info-circle me-1"></i>About
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <?php if (isLoggedIn()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">
                                <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i><?php echo sanitizeOutput(getCurrentUsername()); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="profile.php">
                                    <i class="fas fa-user-edit me-1"></i>Profile
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="logout.php">
                                    <i class="fas fa-sign-out-alt me-1"></i>Logout
                                </a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">
                                <i class="fas fa-sign-in-alt me-1"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-light btn-sm ms-2" href="patientreg.php">
                                <i class="fas fa-user-plus me-1"></i>Register
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section bg-gradient-primary text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">
                        Book Appointments Online
                    </h1>
                    <p class="lead mb-4">
                        Conveniently schedule appointments with doctors and laboratory tests from the comfort of your home. 
                        Our online appointment system makes healthcare accessible and efficient.
                    </p>
                    <?php if (!isLoggedIn()): ?>
                        <a href="patientreg.php" class="btn btn-light btn-lg me-3">
                            <i class="fas fa-user-plus me-2"></i>Register Now
                        </a>
                        <a href="login.php" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    <?php endif; ?>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image text-center">
                        <i class="fas fa-hospital-user" style="font-size: 15rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Booking Section -->
    <section class="booking-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="section-title">Book Your Appointment</h2>
                    <p class="text-muted">Choose from our available services</p>
                </div>
            </div>
            
            <div class="row g-4">
                <!-- Doctor Booking -->
                <div class="col-lg-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <div class="mb-4">
                                <i class="fas fa-user-md text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h4 class="card-title">Book Doctor Appointment</h4>
                            <p class="card-text">Find and book appointments with qualified doctors by department.</p>
                            
                            <form action="results.php" method="POST" class="mt-4">
                                <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                                <div class="mb-3">
                                    <label for="department" class="form-label">Select Department</label>
                                    <select class="form-select" name="symptom" id="department" required>
                                        <option value="" disabled selected>Choose a department...</option>
                                        <?php 
                                        $result = mysqli_query($con, "SELECT * FROM departments ORDER BY dept_name");
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) { 
                                        ?>
                                            <option value="<?php echo sanitizeOutput($row['dept_id']); ?>">
                                                <?php echo sanitizeOutput($row['dept_name']); ?>
                                            </option>
                                        <?php 
                                            }
                                        } 
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" name="search_doc" class="btn btn-primary w-100">
                                    <i class="fas fa-search me-2"></i>Find Doctors
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Laboratory Booking -->
                <div class="col-lg-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <div class="mb-4">
                                <i class="fas fa-flask text-success" style="font-size: 3rem;"></i>
                            </div>
                            <h4 class="card-title">Book Laboratory Test</h4>
                            <p class="card-text">Schedule various laboratory tests and examinations.</p>
                            
                            <form action="schedule.php" method="GET" class="mt-4">
                                <div class="mb-3">
                                    <label for="lab_test" class="form-label">Select Laboratory Test</label>
                                    <select class="form-select" name="test_id" id="lab_test" required>
                                        <option value="" disabled selected>Choose a test...</option>
                                        <?php 
                                        $result = mysqli_query($con, "SELECT * FROM lab_test ORDER BY lab_test");
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) { 
                                        ?>
                                            <option value="<?php echo sanitizeOutput($row['lab_test_id']); ?>">
                                                <?php echo sanitizeOutput($row['lab_test']); ?>
                                            </option>
                                        <?php 
                                            }
                                        } 
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-calendar-plus me-2"></i>Schedule Test
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section bg-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="section-title">Why Choose Our System?</h2>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="text-center">
                        <i class="fas fa-clock text-primary mb-3" style="font-size: 2.5rem;"></i>
                        <h5>24/7 Availability</h5>
                        <p class="text-muted">Book appointments anytime, anywhere with our online system.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <i class="fas fa-shield-alt text-success mb-3" style="font-size: 2.5rem;"></i>
                        <h5>Secure & Private</h5>
                        <p class="text-muted">Your health information is protected with industry-standard security.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <i class="fas fa-mobile-alt text-info mb-3" style="font-size: 2.5rem;"></i>
                        <h5>Mobile Friendly</h5>
                        <p class="text-muted">Access our system from any device with responsive design.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><?php echo APP_NAME; ?></h5>
                    <p class="text-muted">
                        This Online Appointment Management System is developed by the students of IGNOU 
                        as a mini project for the course MCS-044.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted mb-0">
                        &copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>
    <!-- Custom JS -->
    <script src="js/security.js"></script>
    
    <script>
        // Add CSRF token to all forms
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            forms.forEach(form => {
                if (!form.querySelector('input[name="csrf_token"]')) {
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = 'csrf_token';
                    csrfInput.value = csrfToken;
                    form.appendChild(csrfInput);
                }
            });
        });
    </script>
</body>
</html>