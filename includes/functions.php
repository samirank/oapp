<?php
/**
 * Common Functions
 * 
 * Utility functions used throughout the application
 */

require_once 'config.php';

/**
 * Check if user is logged in
 * 
 * @return bool True if logged in, false otherwise
 */
function isLoggedIn() {
    return isset($_SESSION['log_id']) && !empty($_SESSION['log_id']);
}

/**
 * Check if user has specific role
 * 
 * @param string $role Role to check
 * @return bool True if user has role, false otherwise
 */
function hasRole($role) {
    return isset($_SESSION['log_role']) && $_SESSION['log_role'] === $role;
}

/**
 * Check if user is admin
 * 
 * @return bool True if admin, false otherwise
 */
function isAdmin() {
    return hasRole('admin');
}

/**
 * Check if user is doctor
 * 
 * @return bool True if doctor, false otherwise
 */
function isDoctor() {
    return hasRole('doctor');
}

/**
 * Check if user is patient
 * 
 * @return bool True if patient, false otherwise
 */
function isPatient() {
    return hasRole('patient');
}

/**
 * Get current user ID
 * 
 * @return int|null User ID or null if not logged in
 */
function getCurrentUserId() {
    return $_SESSION['log_id'] ?? null;
}

/**
 * Get current username
 * 
 * @return string|null Username or null if not logged in
 */
function getCurrentUsername() {
    return $_SESSION['log_uname'] ?? null;
}

/**
 * Get current user role
 * 
 * @return string|null User role or null if not logged in
 */
function getCurrentUserRole() {
    return $_SESSION['log_role'] ?? null;
}

/**
 * Require authentication
 * 
 * @param string $redirectUrl URL to redirect to if not authenticated
 */
function requireAuth($redirectUrl = 'login.php') {
    if (!isLoggedIn()) {
        redirect($redirectUrl);
    }
}

/**
 * Require specific role
 * 
 * @param string $role Required role
 * @param string $redirectUrl URL to redirect to if not authorized
 */
function requireRole($role, $redirectUrl = 'dashboard.php') {
    requireAuth();
    if (!hasRole($role)) {
        redirect($redirectUrl);
    }
}

/**
 * Require admin role
 * 
 * @param string $redirectUrl URL to redirect to if not admin
 */
function requireAdmin($redirectUrl = 'dashboard.php') {
    requireRole('admin', $redirectUrl);
}

/**
 * Display flash message
 * 
 * @param string $type Message type (success, error, warning, info)
 * @param string $message Message content
 */
function setFlashMessage($type, $message) {
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}

/**
 * Get and clear flash message
 * 
 * @return array|null Flash message array or null if no message
 */
function getFlashMessage() {
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

/**
 * Display flash message HTML
 * 
 * @return string HTML for flash message or empty string
 */
function displayFlashMessage() {
    $flash = getFlashMessage();
    if (!$flash) {
        return '';
    }
    
    $type = $flash['type'];
    $message = sanitizeOutput($flash['message']);
    
    $alertClass = match($type) {
        'success' => 'alert-success',
        'error' => 'alert-danger',
        'warning' => 'alert-warning',
        'info' => 'alert-info',
        default => 'alert-info'
    };
    
    return "<div class='alert {$alertClass} alert-dismissible fade show' role='alert'>
                {$message}
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            </div>";
}

/**
 * Validate email address
 * 
 * @param string $email Email to validate
 * @return bool True if valid, false otherwise
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate phone number
 * 
 * @param string $phone Phone number to validate
 * @return bool True if valid, false otherwise
 */
function isValidPhone($phone) {
    return preg_match('/^[0-9+\-\s\(\)]{10,15}$/', $phone);
}

/**
 * Validate date
 * 
 * @param string $date Date to validate
 * @param string $format Date format
 * @return bool True if valid, false otherwise
 */
function isValidDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

/**
 * Format currency
 * 
 * @param float $amount Amount to format
 * @param string $currency Currency symbol
 * @return string Formatted currency
 */
function formatCurrency($amount, $currency = '$') {
    return $currency . number_format($amount, 2);
}

/**
 * Generate pagination links
 * 
 * @param int $currentPage Current page number
 * @param int $totalPages Total number of pages
 * @param string $baseUrl Base URL for pagination
 * @return string HTML for pagination
 */
function generatePagination($currentPage, $totalPages, $baseUrl) {
    if ($totalPages <= 1) {
        return '';
    }
    
    $html = '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';
    
    // Previous button
    if ($currentPage > 1) {
        $html .= '<li class="page-item"><a class="page-link" href="' . $baseUrl . '?page=' . ($currentPage - 1) . '">Previous</a></li>';
    }
    
    // Page numbers
    for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++) {
        $active = $i === $currentPage ? ' active' : '';
        $html .= '<li class="page-item' . $active . '"><a class="page-link" href="' . $baseUrl . '?page=' . $i . '">' . $i . '</a></li>';
    }
    
    // Next button
    if ($currentPage < $totalPages) {
        $html .= '<li class="page-item"><a class="page-link" href="' . $baseUrl . '?page=' . ($currentPage + 1) . '">Next</a></li>';
    }
    
    $html .= '</ul></nav>';
    return $html;
}

/**
 * Calculate total pages
 * 
 * @param int $totalItems Total number of items
 * @param int $itemsPerPage Items per page
 * @return int Total number of pages
 */
function calculateTotalPages($totalItems, $itemsPerPage = ITEMS_PER_PAGE) {
    return ceil($totalItems / $itemsPerPage);
}

/**
 * Get current page number
 * 
 * @return int Current page number
 */
function getCurrentPage() {
    return max(1, (int)($_GET['page'] ?? 1));
}

/**
 * Get offset for database queries
 * 
 * @param int $page Page number
 * @param int $itemsPerPage Items per page
 * @return int Offset
 */
function getOffset($page, $itemsPerPage = ITEMS_PER_PAGE) {
    return ($page - 1) * $itemsPerPage;
}

/**
 * Truncate text to specified length
 * 
 * @param string $text Text to truncate
 * @param int $length Maximum length
 * @param string $suffix Suffix to add if truncated
 * @return string Truncated text
 */
function truncateText($text, $length = 100, $suffix = '...') {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . $suffix;
}

/**
 * Generate random password
 * 
 * @param int $length Password length
 * @return string Random password
 */
function generatePassword($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $password;
}

/**
 * Hash password
 * 
 * @param string $password Plain text password
 * @return string Hashed password
 */
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

/**
 * Verify password
 * 
 * @param string $password Plain text password
 * @param string $hash Hashed password
 * @return bool True if password matches, false otherwise
 */
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * Get user-friendly time ago
 * 
 * @param string $datetime Datetime string
 * @return string Time ago string
 */
function timeAgo($datetime) {
    $time = time() - strtotime($datetime);
    
    if ($time < 60) {
        return 'just now';
    } elseif ($time < 3600) {
        $minutes = floor($time / 60);
        return $minutes . ' minute' . ($minutes > 1 ? 's' : '') . ' ago';
    } elseif ($time < 86400) {
        $hours = floor($time / 3600);
        return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
    } elseif ($time < 2592000) {
        $days = floor($time / 86400);
        return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
    } elseif ($time < 31536000) {
        $months = floor($time / 2592000);
        return $months . ' month' . ($months > 1 ? 's' : '') . ' ago';
    } else {
        $years = floor($time / 31536000);
        return $years . ' year' . ($years > 1 ? 's' : '') . ' ago';
    }
}

/**
 * Check if request is AJAX
 * 
 * @return bool True if AJAX request, false otherwise
 */
function isAjaxRequest() {
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

/**
 * Send JSON response
 * 
 * @param mixed $data Data to send
 * @param int $statusCode HTTP status code
 */
function sendJsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit();
}

/**
 * Get file extension
 * 
 * @param string $filename Filename
 * @return string File extension
 */
function getFileExtension($filename) {
    return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
}

/**
 * Check if file type is allowed
 * 
 * @param string $filename Filename
 * @param array $allowedTypes Allowed file types
 * @return bool True if allowed, false otherwise
 */
function isAllowedFileType($filename, $allowedTypes = ALLOWED_FILE_TYPES) {
    $extension = getFileExtension($filename);
    return in_array($extension, $allowedTypes);
}

/**
 * Upload file
 * 
 * @param array $file File array from $_FILES
 * @param string $destination Destination directory
 * @param array $allowedTypes Allowed file types
 * @return array Result array with success status and filename/error message
 */
function uploadFile($file, $destination = UPLOAD_PATH, $allowedTypes = ALLOWED_FILE_TYPES) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'Upload failed'];
    }
    
    if ($file['size'] > MAX_FILE_SIZE) {
        return ['success' => false, 'message' => 'File too large'];
    }
    
    if (!isAllowedFileType($file['name'], $allowedTypes)) {
        return ['success' => false, 'message' => 'File type not allowed'];
    }
    
    if (!is_dir($destination)) {
        mkdir($destination, 0755, true);
    }
    
    $filename = uniqid() . '_' . $file['name'];
    $filepath = $destination . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        return ['success' => true, 'filename' => $filename];
    } else {
        return ['success' => false, 'message' => 'Failed to move uploaded file'];
    }
}
?>