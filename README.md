# Laravel 10 Product Management System

A complete Laravel 10 application with product management, user authentication, role-based access control, and API endpoints for mobile applications.

## 🚀 Features

### Core Features
- **User Authentication** with Laravel UI
- **Role-based Access Control** (Admin & User)
- **Product Management** (CRUD operations)
- **Category Management** (CRUD operations)
- **Image Upload** with Intervention Image
- **Search & Filter** functionality
- **Pagination** for better performance
- **SweetAlert** for delete confirmations
- **Responsive Design** with Bootstrap 5

### API Features
- **RESTful API** endpoints
- **Sanctum Authentication** for mobile apps
- **JSON responses** with proper structure
- **Image upload** via API

### Security Features
- **CSRF Protection**
- **Input Validation**
- **File Upload Security**
- **Role-based Middleware**
- **SQL Injection Prevention**

## 📋 Requirements

- PHP >= 8.1
- Composer
- MySQL/PostgreSQL/SQLite
- Node.js & NPM (for asset compilation)

## 🛠️ Installation

### 1. Clone the Repository
```bash
git clone <repository-url>
cd laravel-product-app
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Configuration
Edit `.env` file and configure your database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_product_app
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Run Migrations & Seeders
```bash
php artisan migrate
php artisan db:seed
```

### 6. Create Storage Link
```bash
php artisan storage:link
```

### 7. Compile Assets
```bash
npm run dev
```

### 8. Start Development Server
```bash
php artisan serve
```

## 👥 Default Users

After running the seeder, you'll have these default users:

### Admin User
- **Email:** admin@example.com
- **Password:** password
- **Role:** admin

### Regular User
- **Email:** user@example.com
- **Password:** password
- **Role:** user

## 📁 Project Structure

```
laravel-product-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ProductController.php
│   │   │   ├── CategoryController.php
│   │   │   ├── HomeController.php
│   │   │   └── Api/
│   │   │       ├── ProductController.php
│   │   │       └── CategoryController.php
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php
│   │       └── UserMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── Product.php
│       └── Category.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── layouts/
│       ├── products/
│       ├── categories/
│       └── auth/
└── routes/
    ├── web.php
    └── api.php
```

## 🔐 Authentication & Authorization

### User Roles
- **Admin:** Full access to all features
- **User:** Limited access (view products, dashboard)

### Middleware
- `auth` - Requires user to be logged in
- `admin` - Requires admin role
- `user` - Requires any authenticated user

## 🛍️ Product Management

### Features
- Create, Read, Update, Delete products
- Image upload with automatic resizing
- Category assignment
- Search by name/description
- Filter by category
- Pagination (10 items per page)

### Image Upload
- Supported formats: JPEG, PNG, JPG, GIF
- Max file size: 2MB
- Automatic resizing to 800x600px
- Stored in `storage/app/public/products/`

## 📱 API Endpoints

### Public Endpoints
```
GET /api/products - List all products
GET /api/products/{id} - Get specific product
GET /api/categories - List all categories
GET /api/categories/{id} - Get specific category with products
```

### Protected Endpoints (Admin Only)
```
POST /api/products - Create new product
PUT /api/products/{id} - Update product
DELETE /api/products/{id} - Delete product
```

### API Authentication
Use Laravel Sanctum for API authentication:
```bash
# Get token
POST /api/login
{
    "email": "admin@example.com",
    "password": "password"
}

# Use token in headers
Authorization: Bearer {token}
```

## 🎨 Frontend Features

### Bootstrap 5 Integration
- Responsive design
- Modern UI components
- Mobile-friendly interface

### SweetAlert2 Integration
- Beautiful confirmation dialogs
- Delete confirmations
- Success/error notifications

### Font Awesome Icons
- Consistent iconography
- Professional appearance

## 🚀 Deployment

### Shared Hosting (cPanel)

1. **Upload Files**
   - Upload all project files to `public_html/`
   - Move contents of `public/` to root directory

2. **Configure Environment**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://yourdomain.com
   ```

3. **Database Setup**
   - Create database in cPanel
   - Update `.env` with database credentials
   - Run migrations: `php artisan migrate --force`

4. **Optimize Application**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan optimize
   ```

### VPS (Ubuntu + Nginx)

1. **Server Setup**
   ```bash
   sudo apt update
   sudo apt install nginx php8.1-fpm php8.1-mysql php8.1-mbstring php8.1-xml php8.1-curl
   ```

2. **Nginx Configuration**
   ```nginx
   server {
       listen 80;
       server_name yourdomain.com;
       root /var/www/laravel-product-app/public;
       
       add_header X-Frame-Options "SAMEORIGIN";
       add_header X-Content-Type-Options "nosniff";
       
       index index.php;
       
       charset utf-8;
       
       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }
       
       location = /favicon.ico { access_log off; log_not_found off; }
       location = /robots.txt  { access_log off; log_not_found off; }
       
       error_page 404 /index.php;
       
       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
           fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
           include fastcgi_params;
       }
       
       location ~ /\.(?!well-known).* {
           deny all;
       }
   }
   ```

3. **Application Setup**
   ```bash
   cd /var/www/laravel-product-app
   composer install --optimize-autoloader --no-dev
   php artisan key:generate
   php artisan migrate --force
   php artisan storage:link
   chown -R www-data:www-data storage bootstrap/cache
   chmod -R 775 storage bootstrap/cache
   ```

4. **SSL Certificate**
   ```bash
   sudo apt install certbot python3-certbot-nginx
   sudo certbot --nginx -d yourdomain.com
   ```

## 🔧 Configuration

### File Upload Settings
Update `php.ini` for larger file uploads:
```ini
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 300
```

### Queue Configuration (Optional)
For better performance with image processing:
```bash
# Install Redis
sudo apt install redis-server

# Configure queue in .env
QUEUE_CONNECTION=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Start queue worker
php artisan queue:work
```

## 🛡️ Security Best Practices

### Implemented Security Features
- CSRF protection on all forms
- Input validation and sanitization
- File upload restrictions
- SQL injection prevention
- XSS protection
- Role-based access control

### Additional Recommendations
- Enable HTTPS
- Set secure headers
- Regular security updates
- Database backups
- Monitor error logs

## 🐛 Troubleshooting

### Common Issues

1. **Storage Link Not Working**
   ```bash
   php artisan storage:link
   # If fails, manually create symlink
   ln -s storage/app/public public/storage
   ```

2. **Permission Issues**
   ```bash
   chmod -R 775 storage bootstrap/cache
   chown -R www-data:www-data storage bootstrap/cache
   ```

3. **Image Upload Fails**
   - Check file permissions
   - Verify GD/Imagick extension
   - Check upload_max_filesize in php.ini

4. **Database Connection Issues**
   - Verify database credentials
   - Check database server status
   - Ensure proper database permissions

### Debug Mode
For development, enable debug mode in `.env`:
```env
APP_DEBUG=true
```

## 📊 Performance Optimization

### Production Optimizations
```bash
# Cache configurations
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

### Database Optimization
- Add indexes to frequently queried columns
- Use database query caching
- Optimize slow queries

### Image Optimization
- Images are automatically resized to 800x600px
- Consider using WebP format for better compression
- Implement lazy loading for product images

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🆘 Support

For support and questions:
- Create an issue in the repository
- Check the troubleshooting section
- Review Laravel documentation

---

**Built with ❤️ using Laravel 10**
