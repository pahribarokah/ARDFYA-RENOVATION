# Deployment dan Konfigurasi - Aplikasi Ardfya v2

## 1. Gambaran Umum Deployment

Aplikasi Ardfya v2 dapat di-deploy ke berbagai environment dengan konfigurasi yang fleksibel:

- **Development**: Local development dengan SQLite
- **Staging**: Testing environment dengan MySQL/PostgreSQL
- **Production**: Live server dengan optimasi penuh

## 2. System Requirements

### 2.1 Server Requirements

**Minimum Requirements:**
- **PHP**: 8.2 atau lebih tinggi
- **Web Server**: Apache 2.4+ atau Nginx 1.18+
- **Database**: MySQL 8.0+, PostgreSQL 13+, atau SQLite 3.35+
- **Memory**: 512MB RAM minimum, 1GB+ recommended
- **Storage**: 1GB free space minimum

**PHP Extensions Required:**
```bash
# Core extensions
php-cli
php-fpm
php-mysql (atau php-pgsql untuk PostgreSQL)
php-sqlite3
php-mbstring
php-xml
php-curl
php-zip
php-gd
php-intl
php-bcmath
php-json
php-tokenizer
php-fileinfo
php-openssl
```

**Node.js Requirements:**
- **Node.js**: 18.x atau lebih tinggi
- **NPM**: 9.x atau lebih tinggi

### 2.2 Development Environment

**Local Development Setup:**
```bash
# Clone repository
git clone https://github.com/your-repo/ardfya_v2.git
cd ardfya_v2

# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Create SQLite database
touch database/database.sqlite

# Run migrations and seeders
php artisan migrate --seed

# Build assets
npm run dev

# Start development server
composer run dev
```

**Development Scripts:**
```json
{
  "scripts": {
    "dev": "concurrently \"php artisan serve\" \"php artisan queue:listen\" \"npm run dev\"",
    "test": "php artisan config:clear && php artisan test"
  }
}
```

## 3. Environment Configuration

### 3.1 Environment Variables

**Basic Configuration (.env):**
```env
# Application
APP_NAME="Ardfya"
APP_ENV=production
APP_KEY=base64:your-generated-key
APP_DEBUG=false
APP_TIMEZONE=Asia/Jakarta
APP_URL=https://your-domain.com

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ardfya_production
DB_USERNAME=ardfya_user
DB_PASSWORD=secure_password

# Cache & Session
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@ardfya.com
MAIL_FROM_NAME="Ardfya"

# Pusher (Real-time)
PUSHER_APP_ID=your-pusher-app-id
PUSHER_APP_KEY=your-pusher-key
PUSHER_APP_SECRET=your-pusher-secret
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=ap1

# File Storage
FILESYSTEM_DISK=local
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

# Logging
LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error
```

### 3.2 Environment-Specific Configurations

**Development (.env.local):**
```env
APP_ENV=local
APP_DEBUG=true
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
MAIL_MAILER=log
PUSHER_APP_KEY=local-key
```

**Staging (.env.staging):**
```env
APP_ENV=staging
APP_DEBUG=true
DB_CONNECTION=mysql
DB_HOST=staging-db-host
LOG_LEVEL=debug
```

**Production (.env.production):**
```env
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=mysql
DB_HOST=production-db-host
LOG_LEVEL=error
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

## 4. Database Setup

### 4.1 Database Migration

**Initial Setup:**
```bash
# Create database
mysql -u root -p
CREATE DATABASE ardfya_production CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'ardfya_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON ardfya_production.* TO 'ardfya_user'@'localhost';
FLUSH PRIVILEGES;

# Run migrations
php artisan migrate --force

# Seed initial data
php artisan db:seed --class=DatabaseSeeder
```

**Migration Commands:**
```bash
# Check migration status
php artisan migrate:status

# Run specific seeder
php artisan db:seed --class=ServicesSeeder
php artisan db:seed --class=AdminSeeder

# Fresh migration (WARNING: destroys data)
php artisan migrate:fresh --seed
```

### 4.2 Database Backup Strategy

**Automated Backup Script:**
```bash
#!/bin/bash
# backup-database.sh

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/backups/ardfya"
DB_NAME="ardfya_production"
DB_USER="ardfya_user"
DB_PASS="secure_password"

# Create backup directory
mkdir -p $BACKUP_DIR

# Create backup
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/ardfya_backup_$DATE.sql

# Compress backup
gzip $BACKUP_DIR/ardfya_backup_$DATE.sql

# Remove backups older than 30 days
find $BACKUP_DIR -name "*.sql.gz" -mtime +30 -delete

echo "Backup completed: ardfya_backup_$DATE.sql.gz"
```

**Crontab Entry:**
```bash
# Daily backup at 2 AM
0 2 * * * /path/to/backup-database.sh
```

## 5. Web Server Configuration

### 5.1 Apache Configuration

**Virtual Host Configuration:**
```apache
<VirtualHost *:80>
    ServerName ardfya.com
    ServerAlias www.ardfya.com
    DocumentRoot /var/www/ardfya/public
    
    # Redirect to HTTPS
    RewriteEngine On
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</VirtualHost>

<VirtualHost *:443>
    ServerName ardfya.com
    ServerAlias www.ardfya.com
    DocumentRoot /var/www/ardfya/public
    
    # SSL Configuration
    SSLEngine on
    SSLCertificateFile /path/to/certificate.crt
    SSLCertificateKeyFile /path/to/private.key
    SSLCertificateChainFile /path/to/ca_bundle.crt
    
    # Laravel Configuration
    <Directory /var/www/ardfya/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    # Security Headers
    Header always set X-Content-Type-Options nosniff
    Header always set X-Frame-Options DENY
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
    
    # Logging
    ErrorLog ${APACHE_LOG_DIR}/ardfya_error.log
    CustomLog ${APACHE_LOG_DIR}/ardfya_access.log combined
</VirtualHost>
```

### 5.2 Nginx Configuration

**Server Block Configuration:**
```nginx
server {
    listen 80;
    server_name ardfya.com www.ardfya.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name ardfya.com www.ardfya.com;
    root /var/www/ardfya/public;
    index index.php index.html;
    
    # SSL Configuration
    ssl_certificate /path/to/certificate.crt;
    ssl_certificate_key /path/to/private.key;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE-RSA-AES256-GCM-SHA512:DHE-RSA-AES256-GCM-SHA512;
    ssl_prefer_server_ciphers off;
    
    # Security Headers
    add_header X-Content-Type-Options nosniff;
    add_header X-Frame-Options DENY;
    add_header X-XSS-Protection "1; mode=block";
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains";
    
    # Laravel Configuration
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    # Static Assets
    location ~* \.(css|js|png|jpg|jpeg|gif|ico|svg)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
    
    # Security
    location ~ /\.ht {
        deny all;
    }
    
    location ~ /\.env {
        deny all;
    }
    
    # Logging
    access_log /var/log/nginx/ardfya_access.log;
    error_log /var/log/nginx/ardfya_error.log;
}
```

## 6. Production Deployment

### 6.1 Deployment Script

**Automated Deployment Script:**
```bash
#!/bin/bash
# deploy.sh

set -e

PROJECT_DIR="/var/www/ardfya"
BACKUP_DIR="/var/backups/ardfya/deployments"
DATE=$(date +%Y%m%d_%H%M%S)

echo "Starting deployment..."

# Create backup
echo "Creating backup..."
mkdir -p $BACKUP_DIR
tar -czf $BACKUP_DIR/backup_$DATE.tar.gz -C $PROJECT_DIR .

# Pull latest code
echo "Pulling latest code..."
cd $PROJECT_DIR
git pull origin main

# Install/update dependencies
echo "Installing dependencies..."
composer install --no-dev --optimize-autoloader
npm ci
npm run build

# Clear and cache config
echo "Optimizing application..."
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Restart services
echo "Restarting services..."
sudo systemctl reload php8.2-fpm
sudo systemctl reload nginx

# Clear application cache
php artisan cache:clear
php artisan queue:restart

echo "Deployment completed successfully!"
```

### 6.2 Zero-Downtime Deployment

**Blue-Green Deployment Strategy:**
```bash
#!/bin/bash
# blue-green-deploy.sh

CURRENT_DIR="/var/www/ardfya"
NEW_DIR="/var/www/ardfya_new"
BACKUP_DIR="/var/www/ardfya_backup"

# Prepare new version
git clone https://github.com/your-repo/ardfya_v2.git $NEW_DIR
cd $NEW_DIR

# Setup new version
composer install --no-dev --optimize-autoloader
npm ci && npm run build
cp $CURRENT_DIR/.env .env
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

# Switch versions
mv $CURRENT_DIR $BACKUP_DIR
mv $NEW_DIR $CURRENT_DIR

# Restart services
sudo systemctl reload php8.2-fpm
sudo systemctl reload nginx

echo "Blue-green deployment completed!"
```

## 7. Performance Optimization

### 7.1 Application Optimization

**Production Optimizations:**
```bash
# Optimize autoloader
composer install --optimize-autoloader --no-dev

# Cache configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize for production
php artisan optimize

# Clear development caches
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```

### 7.2 Asset Optimization

**Build Process:**
```bash
# Production build
npm run build

# Analyze bundle size
npm run build -- --analyze
```

**Vite Production Config:**
```javascript
// vite.config.js
export default defineConfig({
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['alpinejs', 'axios'],
                    ui: ['bootstrap', '@popperjs/core']
                }
            }
        }
    }
});
```

## 8. Monitoring dan Logging

### 8.1 Application Monitoring

**Health Check Endpoint:**
```php
// routes/web.php
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now(),
        'version' => config('app.version'),
        'environment' => app()->environment(),
    ]);
});
```

**System Monitoring Script:**
```bash
#!/bin/bash
# monitor.sh

# Check application health
curl -f http://localhost/health || echo "Application health check failed"

# Check database connection
php artisan tinker --execute="DB::connection()->getPdo();" || echo "Database connection failed"

# Check queue workers
ps aux | grep "queue:work" | grep -v grep || echo "Queue workers not running"

# Check disk space
df -h | awk '$5 > 80 {print "Disk usage high: " $0}'
```

### 8.2 Log Management

**Log Rotation Configuration:**
```bash
# /etc/logrotate.d/ardfya
/var/www/ardfya/storage/logs/*.log {
    daily
    missingok
    rotate 52
    compress
    delaycompress
    notifempty
    create 644 www-data www-data
    postrotate
        /bin/kill -USR1 `cat /var/run/nginx.pid 2>/dev/null` 2>/dev/null || true
    endscript
}
```

## 9. Security Hardening

### 9.1 File Permissions

```bash
# Set proper ownership
sudo chown -R www-data:www-data /var/www/ardfya

# Set directory permissions
sudo find /var/www/ardfya -type d -exec chmod 755 {} \;

# Set file permissions
sudo find /var/www/ardfya -type f -exec chmod 644 {} \;

# Make artisan executable
sudo chmod +x /var/www/ardfya/artisan

# Secure sensitive directories
sudo chmod -R 750 /var/www/ardfya/storage
sudo chmod -R 750 /var/www/ardfya/bootstrap/cache
```

### 9.2 Environment Security

```bash
# Secure .env file
sudo chmod 600 /var/www/ardfya/.env
sudo chown www-data:www-data /var/www/ardfya/.env

# Remove sensitive files
rm -f /var/www/ardfya/.env.example
rm -f /var/www/ardfya/README.md
rm -rf /var/www/ardfya/.git
```

## 10. Maintenance Tasks

### 10.1 Regular Maintenance

**Daily Tasks:**
```bash
# Clear expired sessions
php artisan session:gc

# Clear old logs
find storage/logs -name "*.log" -mtime +30 -delete

# Optimize database
php artisan model:prune
```

**Weekly Tasks:**
```bash
# Update dependencies
composer update --no-dev
npm update

# Clear all caches
php artisan optimize:clear
php artisan optimize
```

**Monthly Tasks:**
```bash
# Database maintenance
php artisan db:monitor
mysql -e "OPTIMIZE TABLE users, projects, inquiries, contracts;"

# Security updates
apt update && apt upgrade
```

### 10.2 Backup and Recovery

**Full System Backup:**
```bash
#!/bin/bash
# full-backup.sh

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_ROOT="/var/backups/ardfya"

# Database backup
mysqldump -u ardfya_user -p ardfya_production > $BACKUP_ROOT/db_$DATE.sql

# Application backup
tar -czf $BACKUP_ROOT/app_$DATE.tar.gz -C /var/www ardfya

# Upload to cloud storage (optional)
# aws s3 cp $BACKUP_ROOT/db_$DATE.sql s3://your-backup-bucket/
# aws s3 cp $BACKUP_ROOT/app_$DATE.tar.gz s3://your-backup-bucket/
```

---

*Panduan deployment ini memberikan framework yang komprehensif untuk men-deploy dan maintain aplikasi Ardfya v2 di berbagai environment dengan fokus pada keamanan, performance, dan reliability.*
