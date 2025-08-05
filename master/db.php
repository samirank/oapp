<?php
/**
 * Database Configuration
 * 
 * This file handles database connection and configuration.
 * For production, use environment variables for sensitive data.
 */

// Database configuration
$server = $_ENV['DB_HOST'] ?? "localhost";
$dbname = $_ENV['DB_NAME'] ?? "oapp";
$user = $_ENV['DB_USER'] ?? "oapp";
$pwd = $_ENV['DB_PASS'] ?? "cZ5sVh8hXr8M7JmB";

// Set error reporting for development (disable in production)
if ($_ENV['APP_ENV'] !== 'production') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// Establish database connection
try {
    $con = mysqli_connect($server, $user, $pwd, $dbname);
    
    // Check connection
    if (mysqli_connect_errno()) {
        throw new Exception("Failed to connect to MySQL: " . mysqli_connect_error());
    }
    
    // Set charset to UTF-8
    mysqli_set_charset($con, "utf8mb4");
    
    // Set timezone (adjust as needed)
    mysqli_query($con, "SET time_zone = '+00:00'");
    
} catch (Exception $e) {
    // Log error (in production, log to file instead of displaying)
    if ($_ENV['APP_ENV'] === 'production') {
        error_log("Database connection failed: " . $e->getMessage());
        die("Database connection failed. Please try again later.");
    } else {
        die("Database connection failed: " . $e->getMessage());
    }
}

/**
 * Helper function to safely execute queries
 * 
 * @param string $sql The SQL query to execute
 * @param array $params Parameters for prepared statement (optional)
 * @return mysqli_result|bool Query result
 */
function executeQuery($con, $sql, $params = []) {
    if (!empty($params)) {
        $stmt = mysqli_prepare($con, $sql);
        if ($stmt === false) {
            throw new Exception("Query preparation failed: " . mysqli_error($con));
        }
        
        // Bind parameters
        $types = str_repeat('s', count($params)); // Assume all strings for now
        mysqli_stmt_bind_param($stmt, $types, ...$params);
        
        $result = mysqli_stmt_execute($stmt);
        if ($result === false) {
            throw new Exception("Query execution failed: " . mysqli_stmt_error($stmt));
        }
        
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    } else {
        $result = mysqli_query($con, $sql);
        if ($result === false) {
            throw new Exception("Query execution failed: " . mysqli_error($con));
        }
        return $result;
    }
}

/**
 * Helper function to escape strings for safe database insertion
 * 
 * @param string $string The string to escape
 * @return string Escaped string
 */
function escapeString($con, $string) {
    return mysqli_real_escape_string($con, trim($string));
}

/**
 * Helper function to validate and sanitize input
 * 
 * @param mixed $input The input to validate
 * @param string $type The type of validation (email, phone, name, etc.)
 * @return mixed Validated input or false if invalid
 */
function validateInput($input, $type = 'string') {
    $input = trim($input);
    
    switch ($type) {
        case 'email':
            return filter_var($input, FILTER_VALIDATE_EMAIL) ? $input : false;
        case 'phone':
            return preg_match('/^[0-9+\-\s\(\)]{10,15}$/', $input) ? $input : false;
        case 'name':
            return preg_match('/^[a-zA-Z\s]{2,50}$/', $input) ? $input : false;
        case 'username':
            return preg_match('/^[a-zA-Z0-9_]{3,20}$/', $input) ? $input : false;
        case 'password':
            return strlen($input) >= 6 ? $input : false;
        default:
            return $input;
    }
}
?>