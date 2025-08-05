<?php
/**
 * Security Functions
 * 
 * Additional security measures and middleware for the application
 */

require_once 'config.php';

/**
 * Initialize security headers
 */
function initSecurityHeaders() {
    // Prevent clickjacking
    header('X-Frame-Options: DENY');
    
    // Prevent MIME type sniffing
    header('X-Content-Type-Options: nosniff');
    
    // Enable XSS protection
    header('X-XSS-Protection: 1; mode=block');
    
    // Referrer policy
    header('Referrer-Policy: strict-origin-when-cross-origin');
    
    // Content Security Policy
    $csp = "default-src 'self'; " .
           "script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; " .
           "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; " .
           "font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; " .
           "img-src 'self' data: https:; " .
           "connect-src 'self'; " .
           "frame-ancestors 'none';";
    
    header("Content-Security-Policy: $csp");
    
    // HSTS (HTTP Strict Transport Security) - only in production
    if (isProduction()) {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
    }
}

/**
 * Rate limiting for login attempts
 * 
 * @param string $identifier IP address or username
 * @param int $maxAttempts Maximum attempts allowed
 * @param int $lockoutTime Lockout time in seconds
 * @return bool True if allowed, false if blocked
 */
function checkRateLimit($identifier, $maxAttempts = MAX_LOGIN_ATTEMPTS, $lockoutTime = LOCKOUT_TIME) {
    $attemptsFile = 'logs/login_attempts.json';
    $attempts = [];
    
    if (file_exists($attemptsFile)) {
        $attempts = json_decode(file_get_contents($attemptsFile), true) ?: [];
    }
    
    $now = time();
    $identifierKey = md5($identifier);
    
    // Clean old attempts
    if (isset($attempts[$identifierKey])) {
        $attempts[$identifierKey] = array_filter($attempts[$identifierKey], function($timestamp) use ($now, $lockoutTime) {
            return ($now - $timestamp) < $lockoutTime;
        });
    }
    
    // Check if blocked
    if (isset($attempts[$identifierKey]) && count($attempts[$identifierKey]) >= $maxAttempts) {
        return false;
    }
    
    // Add current attempt
    if (!isset($attempts[$identifierKey])) {
        $attempts[$identifierKey] = [];
    }
    $attempts[$identifierKey][] = $now;
    
    // Save attempts
    if (!is_dir('logs')) {
        mkdir('logs', 0755, true);
    }
    file_put_contents($attemptsFile, json_encode($attempts));
    
    return true;
}

/**
 * Clear rate limit for successful login
 * 
 * @param string $identifier IP address or username
 */
function clearRateLimit($identifier) {
    $attemptsFile = 'logs/login_attempts.json';
    if (file_exists($attemptsFile)) {
        $attempts = json_decode(file_get_contents($attemptsFile), true) ?: [];
        $identifierKey = md5($identifier);
        unset($attempts[$identifierKey]);
        file_put_contents($attemptsFile, json_encode($attempts));
    }
}

/**
 * Validate and sanitize input data
 * 
 * @param array $data Input data array
 * @param array $rules Validation rules
 * @return array Validated and sanitized data
 */
function validateInput($data, $rules) {
    $validated = [];
    $errors = [];
    
    foreach ($rules as $field => $rule) {
        $value = $data[$field] ?? null;
        
        // Required check
        if (isset($rule['required']) && $rule['required'] && empty($value)) {
            $errors[$field] = ucfirst($field) . ' is required';
            continue;
        }
        
        // Skip validation if not required and empty
        if (empty($value) && !isset($rule['required'])) {
            continue;
        }
        
        // Type validation
        if (isset($rule['type'])) {
            switch ($rule['type']) {
                case 'email':
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $errors[$field] = 'Invalid email format';
                    }
                    break;
                case 'phone':
                    if (!preg_match('/^[0-9+\-\s\(\)]{10,15}$/', $value)) {
                        $errors[$field] = 'Invalid phone number format';
                    }
                    break;
                case 'date':
                    if (!isValidDate($value)) {
                        $errors[$field] = 'Invalid date format';
                    }
                    break;
                case 'int':
                    if (!is_numeric($value) || (int)$value != $value) {
                        $errors[$field] = 'Must be a valid integer';
                    }
                    break;
                case 'float':
                    if (!is_numeric($value)) {
                        $errors[$field] = 'Must be a valid number';
                    }
                    break;
            }
        }
        
        // Length validation
        if (isset($rule['min_length']) && strlen($value) < $rule['min_length']) {
            $errors[$field] = ucfirst($field) . ' must be at least ' . $rule['min_length'] . ' characters';
        }
        
        if (isset($rule['max_length']) && strlen($value) > $rule['max_length']) {
            $errors[$field] = ucfirst($field) . ' must be no more than ' . $rule['max_length'] . ' characters';
        }
        
        // Pattern validation
        if (isset($rule['pattern']) && !preg_match($rule['pattern'], $value)) {
            $errors[$field] = ucfirst($field) . ' format is invalid';
        }
        
        // Custom validation
        if (isset($rule['custom']) && is_callable($rule['custom'])) {
            $customResult = $rule['custom']($value);
            if ($customResult !== true) {
                $errors[$field] = $customResult;
            }
        }
        
        // Sanitize if no errors
        if (!isset($errors[$field])) {
            $validated[$field] = sanitizeInput($value, $rule['sanitize'] ?? 'string');
        }
    }
    
    return [
        'data' => $validated,
        'errors' => $errors
    ];
}

/**
 * Sanitize input value
 * 
 * @param mixed $value Input value
 * @param string $type Sanitization type
 * @return mixed Sanitized value
 */
function sanitizeInput($value, $type = 'string') {
    switch ($type) {
        case 'email':
            return filter_var(trim($value), FILTER_SANITIZE_EMAIL);
        case 'url':
            return filter_var(trim($value), FILTER_SANITIZE_URL);
        case 'int':
            return (int)$value;
        case 'float':
            return (float)$value;
        case 'string':
        default:
            return trim(strip_tags($value));
    }
}

/**
 * Generate secure random token
 * 
 * @param int $length Token length
 * @return string Random token
 */
function generateSecureToken($length = 32) {
    return bin2hex(random_bytes($length / 2));
}

/**
 * Hash sensitive data
 * 
 * @param string $data Data to hash
 * @return string Hashed data
 */
function hashSensitiveData($data) {
    return hash('sha256', $data . config('APP_KEY', 'default_key'));
}

/**
 * Verify sensitive data hash
 * 
 * @param string $data Original data
 * @param string $hash Hash to verify
 * @return bool True if valid
 */
function verifySensitiveData($data, $hash) {
    return hash_equals(hashSensitiveData($data), $hash);
}

/**
 * Log security events
 * 
 * @param string $event Event description
 * @param array $data Additional data
 * @param string $level Log level
 */
function logSecurityEvent($event, $data = [], $level = 'info') {
    $logData = [
        'timestamp' => date('Y-m-d H:i:s'),
        'event' => $event,
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
        'user_id' => getCurrentUserId(),
        'data' => $data
    ];
    
    logMessage(json_encode($logData), $level);
}

/**
 * Check if request is from allowed origin
 * 
 * @param array $allowedOrigins Array of allowed origins
 * @return bool True if allowed
 */
function checkOrigin($allowedOrigins = []) {
    if (empty($allowedOrigins)) {
        $allowedOrigins = [BASE_URL];
    }
    
    $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
    return in_array($origin, $allowedOrigins);
}

/**
 * Prevent session fixation
 */
function preventSessionFixation() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!isset($_SESSION['created'])) {
        $_SESSION['created'] = time();
    } else if (time() - $_SESSION['created'] > 1800) {
        // Regenerate session ID every 30 minutes
        session_regenerate_id(true);
        $_SESSION['created'] = time();
    }
}

/**
 * Validate file upload
 * 
 * @param array $file File array from $_FILES
 * @param array $allowedTypes Allowed MIME types
 * @param int $maxSize Maximum file size in bytes
 * @return array Validation result
 */
function validateFileUpload($file, $allowedTypes = [], $maxSize = MAX_FILE_SIZE) {
    $errors = [];
    
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'File upload failed';
        return ['valid' => false, 'errors' => $errors];
    }
    
    if ($file['size'] > $maxSize) {
        $errors[] = 'File size exceeds maximum allowed size';
    }
    
    if (!empty($allowedTypes)) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        if (!in_array($mimeType, $allowedTypes)) {
            $errors[] = 'File type not allowed';
        }
    }
    
    // Check for malicious content
    $content = file_get_contents($file['tmp_name']);
    if (preg_match('/<\?php|<script|javascript:/i', $content)) {
        $errors[] = 'File contains potentially malicious content';
    }
    
    return [
        'valid' => empty($errors),
        'errors' => $errors
    ];
}

/**
 * Initialize security measures
 */
function initSecurity() {
    initSecurityHeaders();
    preventSessionFixation();
    
    // Set secure session parameters
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_secure', isProduction() ? 1 : 0);
    ini_set('session.cookie_samesite', 'Strict');
}

// Initialize security when this file is included
initSecurity();
?>