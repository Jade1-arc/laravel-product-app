# Deployment Guide - Laravel 10 Product Management System

This guide provides detailed instructions for deploying the Laravel 10 Product Management System to different hosting environments.

## 🚀 Quick Deployment Checklist

- [ ] Environment configuration
- [ ] Database setup
- [ ] File permissions
- [ ] Storage link creation
- [ ] Cache optimization
- [ ] SSL certificate (production)
- [ ] Security headers
- [ ] Performance optimization

## 📦 Shared Hosting (cPanel)

### Step 1: Prepare Your Application

1. **Optimize for Production**
   ```bash
   # In your local development environment
   composer install --optimize-autoloader --no-dev
   npm run build
   ```

2. **Create Production Environment File**
   ```env
   APP_NAME="Product Management System"
   APP_ENV=production
   APP_KEY=your-generated-key
   APP_DEBUG=false
   APP_URL=https://yourdomain.com
   
   LOG_CHANNEL=stack
   LOG_DEPRECATIONS_CHANNEL=null
   LOG_LEVEL=error
   
   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   
   BROADCAST_DRIVER=log
   CACHE_DRIVER=file
   FILESYSTEM_DISK=local
   QUEUE_CONNECTION=sync
   SESSION_DRIVER=file
   SESSION_LIFETIME=120
   ```

### Step 2: Upload Files

1. **Upload via FTP/SFTP**
   - Upload all project files to `public_html/`
   - **Important:** Move contents of `public/` folder to the root of `public_html/`

2. **File Structure on Server**
   ```
   public_html/
   ├── index.php
   ├── .htaccess
   ├── css/
   ├── js/
   ├── images/
   └── storage/ (symlink)
   ```

### Step 3: Database Setup

1. **Create Database in cPanel**
   - Go to MySQL Databases
   - Create new database
   - Create database user
   - Assign user to database

2. **Run Migrations**
   ```bash
   # Via SSH or cPanel Terminal
   cd /home/username/public_html
   php artisan migrate --force
   php artisan db:seed --force
   ```

### Step 4: Configure Application

1. **Set File Permissions**
   ```bash
   chmod -R 755 storage
   chmod -R 755 bootstrap/cache
   chmod 644 .env
   ```

2. **Create Storage Link**
   ```bash
   php artisan storage:link
   ```

3. **Optimize Application**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan optimize
   ```

### Step 5: Security Configuration

1. **Update .htaccess** (if needed)
   ```apache
   <IfModule mod_rewrite.c>
       RewriteEngine On
       RewriteRule ^(.*)$ public/$1 [L]
   </IfModule>
   
   # Security Headers
   <IfModule mod_headers.c>
       Header always set X-Content-Type-Options nosniff
       Header always set X-Frame-Options DENY
       Header always set X-XSS-Protection "1; mode=block"
       Header always set Referrer-Policy "strict-origin-when-cross-origin"
   </IfModule>
   ```

## 🖥️ VPS Deployment (Ubuntu + Nginx)

### Step 1: Server Preparation

1. **Update System**
   ```bash
   sudo apt update && sudo apt upgrade -y
   ```

2. **Install Required Packages**
   ```bash
   sudo apt install nginx php8.1-fpm php8.1-mysql php8.1-mbstring php8.1-xml php8.1-curl php8.1-gd php8.1-zip php8.1-cli php8.1-common php8.1-mysql php8.1-opcache php8.1-readline php8.1-mbstring php8.1-xml php8.1-gd php8.1-curl unzip git curl
   ```

3. **Install Composer**
   ```bash
   curl -sS https://getcomposer.org/installer | php
   sudo mv composer.phar /usr/local/bin/composer
   ```

4. **Install Node.js & NPM**
   ```bash
   curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
   sudo apt-get install -y nodejs
   ```

### Step 2: Database Setup

1. **Install MySQL**
   ```bash
   sudo apt install mysql-server
   sudo mysql_secure_installation
   ```

2. **Create Database and User**
   ```sql
   CREATE DATABASE laravel_product_app;
   CREATE USER 'laravel_user'@'localhost' IDENTIFIED BY 'strong_password';
   GRANT ALL PRIVILEGES ON laravel_product_app.* TO 'laravel_user'@'localhost';
   FLUSH PRIVILEGES;
   ```

### Step 3: Application Deployment

1. **Clone Repository**
   ```bash
   cd /var/www
   sudo git clone https://github.com/your-repo/laravel-product-app.git
   sudo chown -R www-data:www-data laravel-product-app
   ```

2. **Install Dependencies**
   ```bash
   cd laravel-product-app
   composer install --optimize-autoloader --no-dev
   npm install
   npm run build
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure Environment File**
   ```env
   APP_NAME="Product Management System"
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://yourdomain.com
   
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel_product_app
   DB_USERNAME=laravel_user
   DB_PASSWORD=strong_password
   ```

5. **Run Migrations and Seeders**
   ```bash
   php artisan migrate --force
   php artisan db:seed --force
   ```

6. **Set Permissions**
   ```bash
   sudo chown -R www-data:www-data /var/www/laravel-product-app
   sudo chmod -R 755 /var/www/laravel-product-app
   sudo chmod -R 775 /var/www/laravel-product-app/storage
   sudo chmod -R 775 /var/www/laravel-product-app/bootstrap/cache
   ```

7. **Create Storage Link**
   ```bash
   php artisan storage:link
   ```

### Step 4: Nginx Configuration

1. **Create Nginx Site Configuration**
   ```bash
   sudo nano /etc/nginx/sites-available/laravel-product-app
   ```

2. **Add Configuration**
   ```nginx
   server {
       listen 80;
       server_name yourdomain.com www.yourdomain.com;
       root /var/www/laravel-product-app/public;
       
       add_header X-Frame-Options "SAMEORIGIN";
       add_header X-Content-Type-Options "nosniff";
       add_header X-XSS-Protection "1; mode=block";
       add_header Referrer-Policy "strict-origin-when-cross-origin";
       
       index index.php index.html index.htm;
       
       charset utf-8;
       
       # Handle Laravel Routes
       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }
       
       # Handle PHP Files
       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
           fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
           include fastcgi_params;
           fastcgi_hide_header X-Powered-By;
       }
       
       # Deny Access to Hidden Files
       location ~ /\. {
           deny all;
       }
       
       # Deny Access to Sensitive Files
       location ~* \.(env|log|sql|md|txt)$ {
           deny all;
       }
       
       # Optimize Static Files
       location ~* \.(jpg|jpeg|png|gif|ico|css|js|pdf|txt)$ {
           expires 1y;
           add_header Cache-Control "public, immutable";
       }
       
       # Security Headers
       location ~* \.(css|js|png|jpg|jpeg|gif|ico|svg)$ {
           expires 1y;
           add_header Cache-Control "public, immutable";
           add_header X-Content-Type-Options nosniff;
       }
   }
   ```

3. **Enable Site**
   ```bash
   sudo ln -s /etc/nginx/sites-available/laravel-product-app /etc/nginx/sites-enabled/
   sudo nginx -t
   sudo systemctl reload nginx
   ```

### Step 5: SSL Certificate (Let's Encrypt)

1. **Install Certbot**
   ```bash
   sudo apt install certbot python3-certbot-nginx
   ```

2. **Obtain SSL Certificate**
   ```bash
   sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
   ```

3. **Auto-renewal**
   ```bash
   sudo crontab -e
   # Add this line:
   0 12 * * * /usr/bin/certbot renew --quiet
   ```

### Step 6: Performance Optimization

1. **PHP-FPM Optimization**
   ```bash
   sudo nano /etc/php/8.1/fpm/php.ini
   ```
   
   Update these values:
   ```ini
   memory_limit = 256M
   upload_max_filesize = 10M
   post_max_size = 10M
   max_execution_time = 300
   opcache.enable=1
   opcache.memory_consumption=128
   opcache.interned_strings_buffer=8
   opcache.max_accelerated_files=4000
   opcache.revalidate_freq=2
   opcache.fast_shutdown=1
   ```

2. **Restart PHP-FPM**
   ```bash
   sudo systemctl restart php8.1-fpm
   ```

3. **Application Optimization**
   ```bash
   cd /var/www/laravel-product-app
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan optimize
   ```

## 🔧 Docker Deployment

### Dockerfile
```dockerfile
FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory
COPY . .

# Install dependencies
RUN composer install --optimize-autoloader --no-dev
RUN npm install && npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www/storage
RUN chmod -R 755 /var/www/bootstrap/cache

# Expose port 9000
EXPOSE 9000

CMD ["php-fpm"]
```

### docker-compose.yml
```yaml
version: '3'
services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: laravel_app
    restart: unless-stopped
    working_dir: /var/www
    volumes:
      - ./:/var/www
      - ./docker/php/local.ini:/usr/local/etc/php/conf.d/local.ini
    networks:
      - laravel_network

  webserver:
    image: nginx:alpine
    container_name: laravel_nginx
    restart: unless-stopped
    ports:
      - "80:80"
    volumes:
      - ./:/var/www
      - ./docker/nginx/conf.d/:/etc/nginx/conf.d/
    networks:
      - laravel_network

  db:
    image: mysql:8.0
    container_name: laravel_db
    restart: unless-stopped
    environment:
      MYSQL_DATABASE: laravel_product_app
      MYSQL_ROOT_PASSWORD: your_mysql_root_password
      MYSQL_PASSWORD: your_mysql_password
      MYSQL_USER: your_mysql_user
    volumes:
      - dbdata:/var/lib/mysql
    networks:
      - laravel_network

networks:
  laravel_network:
    driver: bridge

volumes:
  dbdata:
    driver: local
```

## 🔒 Security Checklist

### Production Security Measures

- [ ] **Environment Variables**
  - `APP_DEBUG=false`
  - `APP_ENV=production`
  - Strong database passwords

- [ ] **File Permissions**
  - Storage: 775
  - Bootstrap/cache: 775
  - .env: 644

- [ ] **Security Headers**
  - X-Frame-Options
  - X-Content-Type-Options
  - X-XSS-Protection
  - Referrer-Policy

- [ ] **SSL/TLS**
  - HTTPS redirect
  - HSTS headers
  - Secure cookies

- [ ] **Database Security**
  - Strong passwords
  - Limited user privileges
  - Regular backups

- [ ] **Application Security**
  - CSRF protection enabled
  - Input validation
  - File upload restrictions
  - Rate limiting (optional)

## 📊 Performance Monitoring

### Monitoring Tools

1. **Laravel Telescope** (Development)
   ```bash
   composer require laravel/telescope --dev
   php artisan telescope:install
   php artisan migrate
   ```

2. **Laravel Horizon** (Queue Monitoring)
   ```bash
   composer require laravel/horizon
   php artisan horizon:install
   ```

3. **Server Monitoring**
   - CPU usage
   - Memory usage
   - Disk space
   - Network traffic

### Performance Optimization

1. **Caching**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

2. **Database Optimization**
   - Add indexes to frequently queried columns
   - Use database query caching
   - Optimize slow queries

3. **Image Optimization**
   - Use WebP format
   - Implement lazy loading
   - CDN for static assets

## 🚨 Troubleshooting

### Common Issues

1. **500 Internal Server Error**
   ```bash
   # Check logs
   tail -f /var/log/nginx/error.log
   tail -f /var/log/php8.1-fpm.log
   
   # Check permissions
   sudo chown -R www-data:www-data /var/www/laravel-product-app
   sudo chmod -R 755 /var/www/laravel-product-app/storage
   ```

2. **Database Connection Issues**
   ```bash
   # Test database connection
   php artisan tinker
   DB::connection()->getPdo();
   
   # Check database service
   sudo systemctl status mysql
   ```

3. **Storage Link Issues**
   ```bash
   # Remove existing link
   rm public/storage
   
   # Create new link
   php artisan storage:link
   ```

4. **Permission Issues**
   ```bash
   # Fix ownership
   sudo chown -R www-data:www-data /var/www/laravel-product-app
   
   # Fix permissions
   sudo find /var/www/laravel-product-app -type f -exec chmod 644 {} \;
   sudo find /var/www/laravel-product-app -type d -exec chmod 755 {} \;
   sudo chmod -R 775 storage bootstrap/cache
   ```

### Debug Mode

For troubleshooting, temporarily enable debug mode:
```env
APP_DEBUG=true
APP_LOG_LEVEL=debug
```

**Remember to disable debug mode in production!**

## 📈 Maintenance

### Regular Maintenance Tasks

1. **Daily**
   - Check error logs
   - Monitor disk space
   - Verify backups

2. **Weekly**
   - Update dependencies
   - Review security logs
   - Performance monitoring

3. **Monthly**
   - Security updates
   - Database optimization
   - SSL certificate renewal

### Backup Strategy

1. **Database Backups**
   ```bash
   # Create backup script
   mysqldump -u username -p database_name > backup_$(date +%Y%m%d_%H%M%S).sql
   ```

2. **File Backups**
   ```bash
   # Backup application files
   tar -czf laravel_backup_$(date +%Y%m%d).tar.gz /var/www/laravel-product-app
   ```

3. **Automated Backups**
   ```bash
   # Add to crontab
   0 2 * * * /path/to/backup_script.sh
   ```

---

**For additional support, refer to the main README.md file or create an issue in the repository.** 