# Deployment Guide

This guide provides step-by-step instructions for deploying the Online Appointment System in different environments.

## Prerequisites

Before deploying, ensure you have:

- **Web Server**: Apache 2.4+ or Nginx 1.18+
- **PHP**: 7.4 or higher with required extensions
- **MySQL**: 5.7 or higher (or MariaDB 10.2+)
- **SSL Certificate**: For production deployments (recommended)

## Required PHP Extensions

Ensure the following PHP extensions are installed and enabled:

```bash
# Core extensions
php-mysqli
php-json
php-session
php-mbstring
php-xml
php-curl

# Optional but recommended
php-opcache
php-zip
php-gd
php-intl
```

## Installation Steps

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/online-appointment-system.git
cd online-appointment-system
```

### 2. Set Up Database

```bash
# Create database
mysql -u root -p -e "CREATE DATABASE oapp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Create database user (optional but recommended)
mysql -u root -p -e "CREATE USER 'oapp'@'localhost' IDENTIFIED BY 'your_secure_password';"
mysql -u root -p -e "GRANT ALL PRIVILEGES ON oapp.* TO 'oapp'@'localhost';"
mysql -u root -p -e "FLUSH PRIVILEGES;"

# Import schema
mysql -u oapp -p oapp < database/schema.sql
```

### 3. Configure Environment

#### Option A: Using Environment Variables (Recommended)

Create a `.env` file in the project root:

```env
# Application
APP_ENV=production
APP_NAME="Online Appointment System"
APP_VERSION=1.0.0

# Database
DB_HOST=localhost
DB_NAME=oapp
DB_USER=oapp
DB_PASS=your_secure_password

# Security
APP_KEY=your_32_character_random_key_here

# Email (for future use)
SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
SMTP_USER=your_email@gmail.com
SMTP_PASS=your_email_password
FROM_EMAIL=noreply@yourdomain.com
FROM_NAME="Online Appointment System"

# URLs
BASE_URL=https://yourdomain.com
```

#### Option B: Direct Configuration

Edit `config.php` and update the database settings:

```php
// Database settings
define('DB_HOST', 'localhost');
define('DB_NAME', 'oapp');
define('DB_USER', 'oapp');
define('DB_PASS', 'your_secure_password');
```

### 4. Set File Permissions

```bash
# Set directory permissions
chmod 755 .
chmod 755 css/
chmod 755 js/
chmod 755 images/

# Create and set permissions for logs directory
mkdir -p logs
chmod 755 logs
chmod 644 logs/*.log 2>/dev/null || true

# Create and set permissions for uploads directory
mkdir -p uploads
chmod 755 uploads

# Set web server user ownership (adjust as needed)
chown -R www-data:www-data .
```

### 5. Web Server Configuration

#### Apache Configuration

Create a virtual host configuration:

```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    ServerAlias www.yourdomain.com
    DocumentRoot /path/to/online-appointment-system
    
    <Directory /path/to/online-appointment-system>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/oapp_error.log
    CustomLog ${APACHE_LOG_DIR}/oapp_access.log combined
</VirtualHost>
```

Create `.htaccess` file in the project root:

```apache
# Security headers
Header always set X-Content-Type-Options nosniff
Header always set X-Frame-Options DENY
Header always set X-XSS-Protection "1; mode=block"

# Enable rewrite engine
RewriteEngine On

# Redirect to HTTPS (uncomment for production)
# RewriteCond %{HTTPS} off
# RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Prevent access to sensitive files
<Files "*.env">
    Require all denied
</Files>

<Files "*.log">
    Require all denied
</Files>

<Files "*.sql">
    Require all denied
</Files>

# Prevent directory listing
Options -Indexes

# Set default character set
AddDefaultCharset UTF-8

# Enable compression
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/plain
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/xml
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE application/xml
    AddOutputFilterByType DEFLATE application/xhtml+xml
    AddOutputFilterByType DEFLATE application/rss+xml
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/x-javascript
</IfModule>

# Cache static files
<IfModule mod_expires.c>
    ExpiresActive on
    ExpiresByType text/css "access plus 1 year"
    ExpiresByType application/javascript "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType image/ico "access plus 1 year"
    ExpiresByType image/icon "access plus 1 year"
    ExpiresByType text/plain "access plus 1 month"
    ExpiresByType application/pdf "access plus 1 month"
    ExpiresByType application/x-shockwave-flash "access plus 1 month"
</IfModule>
```

#### Nginx Configuration

```nginx
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    root /path/to/online-appointment-system;
    index index.php index.html;

    # Security headers
    add_header X-Content-Type-Options nosniff;
    add_header X-Frame-Options DENY;
    add_header X-XSS-Protection "1; mode=block";

    # Handle PHP files
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Prevent access to sensitive files
    location ~ /\.(env|log|sql)$ {
        deny all;
    }

    # Static file caching
    location ~* \.(css|js|png|jpg|jpeg|gif|ico|svg)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    # Main location block
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Logs
    access_log /var/log/nginx/oapp_access.log;
    error_log /var/log/nginx/oapp_error.log;
}
```

### 6. SSL Configuration (Production)

#### Using Let's Encrypt

```bash
# Install Certbot
sudo apt install certbot python3-certbot-apache

# Obtain certificate
sudo certbot --apache -d yourdomain.com -d www.yourdomain.com

# Auto-renewal
sudo crontab -e
# Add: 0 12 * * * /usr/bin/certbot renew --quiet
```

#### Manual SSL Configuration

```apache
<VirtualHost *:443>
    ServerName yourdomain.com
    DocumentRoot /path/to/online-appointment-system
    
    SSLEngine on
    SSLCertificateFile /path/to/your/certificate.crt
    SSLCertificateKeyFile /path/to/your/private.key
    SSLCertificateChainFile /path/to/your/chain.crt
    
    # Security headers
    Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
    
    # Rest of configuration...
</VirtualHost>
```

## Environment-Specific Configurations

### Development Environment

```php
// config.php
define('APP_ENV', 'development');
define('DB_HOST', 'localhost');
define('DB_NAME', 'oapp_dev');
define('DB_USER', 'root');
define('DB_PASS', '');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

### Staging Environment

```php
// config.php
define('APP_ENV', 'staging');
define('DB_HOST', 'staging-db.example.com');
define('DB_NAME', 'oapp_staging');
define('DB_USER', 'oapp_staging');
define('DB_PASS', 'staging_password');

// Disable error display
error_reporting(0);
ini_set('display_errors', 0);
```

### Production Environment

```php
// config.php
define('APP_ENV', 'production');
define('DB_HOST', 'production-db.example.com');
define('DB_NAME', 'oapp_prod');
define('DB_USER', 'oapp_prod');
define('DB_PASS', 'production_password');

// Security settings
error_reporting(0);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/var/log/php/error.log');
```

## Performance Optimization

### 1. PHP Optimization

Edit `php.ini`:

```ini
; Memory limit
memory_limit = 256M

; Max execution time
max_execution_time = 30

; Upload limits
upload_max_filesize = 10M
post_max_size = 10M

; OPcache settings
opcache.enable = 1
opcache.memory_consumption = 128
opcache.interned_strings_buffer = 8
opcache.max_accelerated_files = 4000
opcache.revalidate_freq = 2
opcache.fast_shutdown = 1
```

### 2. MySQL Optimization

Edit `my.cnf`:

```ini
[mysqld]
# Buffer settings
innodb_buffer_pool_size = 1G
innodb_log_file_size = 256M
innodb_flush_log_at_trx_commit = 2

# Query cache
query_cache_type = 1
query_cache_size = 64M

# Connection settings
max_connections = 200
```

### 3. Web Server Optimization

#### Apache

```apache
# Enable modules
a2enmod expires
a2enmod headers
a2enmod rewrite
a2enmod deflate

# MPM settings
<IfModule mpm_prefork_module>
    StartServers 5
    MinSpareServers 5
    MaxSpareServers 10
    MaxRequestWorkers 150
    MaxConnectionsPerChild 0
</IfModule>
```

#### Nginx

```nginx
# Worker processes
worker_processes auto;
worker_connections 1024;

# Gzip compression
gzip on;
gzip_vary on;
gzip_min_length 1024;
gzip_types text/plain text/css application/json application/javascript text/xml application/xml application/xml+rss text/javascript;
```

## Monitoring and Maintenance

### 1. Log Monitoring

Set up log rotation:

```bash
# /etc/logrotate.d/oapp
/path/to/online-appointment-system/logs/*.log {
    daily
    missingok
    rotate 30
    compress
    delaycompress
    notifempty
    create 644 www-data www-data
}
```

### 2. Database Backup

Create backup script:

```bash
#!/bin/bash
# backup.sh

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backups/oapp"
DB_NAME="oapp"
DB_USER="oapp"

# Create backup directory
mkdir -p $BACKUP_DIR

# Database backup
mysqldump -u $DB_USER -p $DB_NAME > $BACKUP_DIR/db_backup_$DATE.sql

# Compress backup
gzip $BACKUP_DIR/db_backup_$DATE.sql

# Remove old backups (keep last 30 days)
find $BACKUP_DIR -name "db_backup_*.sql.gz" -mtime +30 -delete

echo "Backup completed: db_backup_$DATE.sql.gz"
```

### 3. Health Checks

Create health check endpoint:

```php
// health.php
<?php
header('Content-Type: application/json');

$health = [
    'status' => 'healthy',
    'timestamp' => date('Y-m-d H:i:s'),
    'checks' => []
];

// Database check
try {
    require_once 'master/db.php';
    $result = mysqli_query($con, "SELECT 1");
    $health['checks']['database'] = 'ok';
} catch (Exception $e) {
    $health['checks']['database'] = 'error';
    $health['status'] = 'unhealthy';
}

// File system check
if (is_writable('logs/')) {
    $health['checks']['filesystem'] = 'ok';
} else {
    $health['checks']['filesystem'] = 'error';
    $health['status'] = 'unhealthy';
}

echo json_encode($health);
```

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Check database credentials in `config.php`
   - Verify MySQL service is running
   - Check firewall settings

2. **Permission Denied**
   - Ensure web server has read/write permissions
   - Check file ownership
   - Verify directory permissions

3. **500 Internal Server Error**
   - Check PHP error logs
   - Verify PHP extensions are installed
   - Check file permissions

4. **Session Issues**
   - Ensure session directory is writable
   - Check session configuration
   - Verify cookie settings

### Debug Mode

Enable debug mode for troubleshooting:

```php
// Add to config.php
define('DEBUG_MODE', true);

if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
}
```

## Security Checklist

- [ ] SSL certificate installed
- [ ] Database credentials secured
- [ ] File permissions set correctly
- [ ] Security headers configured
- [ ] Error reporting disabled in production
- [ ] Regular backups configured
- [ ] Firewall rules in place
- [ ] Monitoring and logging enabled
- [ ] Updates and patches applied
- [ ] Rate limiting configured

## Support

For deployment issues:

1. Check the logs in `logs/` directory
2. Review web server error logs
3. Verify all prerequisites are met
4. Test with a minimal configuration
5. Contact the development team

---

**Note**: This deployment guide assumes a Linux environment. Adjust commands and paths for Windows or macOS as needed.