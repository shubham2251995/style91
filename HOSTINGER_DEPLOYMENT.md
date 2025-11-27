# Hostinger Shared Hosting Deployment Guide

## Pre-Deployment Checklist

### 1. Verify PHP Version
Hostinger supports PHP 8.0+. Ensure you select **PHP 8.2** in your hosting panel:
- Login to Hostinger control panel (hPanel)
- Go to **Advanced → PHP Configuration**
- Select **PHP 8.2** or higher

### 2. Database Setup
1. Create MySQL database in hPanel
2. Note down:
   - Database name
   - Username
   - Password
   - Host (usually `localhost`)

---

## Step-by-Step Deployment

### Step 1: Prepare Files Locally

**Clean your project:**
```bash
cd c:\xampp\htdocs\style91

# Remove development dependencies
composer install --no-dev --optimize-autoloader

# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

**Create ZIP archive:**
```bash
# Exclude these folders/files:
- node_modules/
- vendor/ (will reinstall on server)
- .git/
- .env (will create fresh)
- storage/logs/*
- storage/framework/cache/*
- storage/framework/sessions/*
- storage/framework/views/*
```

### Step 2: Upload to Hostinger

**Method 1: File Manager (Recommended)**
1. Login to Hostinger hPanel
2. Go to **File Manager**
3. Navigate to `public_html` folder
4. Create a folder called `laravel` (or your app name)
5. Upload ZIP and extract

**Method 2: FTP**
```
Host: ftp.yourdomain.com
Username: your_ftp_user
Password: your_ftp_password
Port: 21
```

Upload to: `/public_html/laravel/`

### Step 3: Install Dependencies

**Via SSH (if available):**
```bash
cd ~/public_html/laravel
composer install --no-dev --optimize-autoloader
```

**If SSH not available:**
- Upload the `vendor` folder from local (ZIP it first)
- Or contact Hostinger support to run composer

### Step 4: Configure .env

Create `.env` file in `/public_html/laravel/`:

```env
APP_NAME="Style91"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

# Mail (Hostinger SMTP)
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=your@email.com
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"

# Payment Gateways
RAZORPAY_KEY_ID=your_key
RAZORPAY_KEY_SECRET=your_secret

CASHFREE_APP_ID=your_app_id
CASHFREE_SECRET_KEY=your_secret
CASHFREE_ENV=production

# Google Analytics
GOOGLE_ANALYTICS_ID=
GOOGLE_TAG_MANAGER_ID=

SESSION_DRIVER=file
QUEUE_CONNECTION=database
```

### Step 5: Generate Application Key

**Via SSH:**
```bash
php artisan key:generate
```

**Without SSH:**
Generate locally and copy the key:
```bash
php artisan key:generate --show
```
Then paste into `.env` file: `APP_KEY=base64:...`

### Step 6: Point Domain to Public Folder

**CRITICAL:** Laravel apps need root pointing to `public` folder.

**Option A: Using .htaccess (Recommended for Hostinger)**

Create `.htaccess` in `/public_html/`:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ laravel/public/$1 [L]
</IfModule>
```

**Option B: Change Document Root**
1. In hPanel, go to **Domains**
2. Click **Manage** on your domain
3. Change **Document Root** to: `/public_html/laravel/public`

### Step 7: Run Migrations

**Via SSH:**
```bash
cd ~/public_html/laravel
php artisan migrate --force --seed
```

**Without SSH:**
Create `install.php` in `public` folder:
```php
<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->call('migrate', ['--force' => true]);

echo "Migrations completed!";
// Delete this file after running
```

Access: `https://yourdomain.com/install.php`  
**Then delete this file immediately for security!**

### Step 8: Set Permissions

**Via SSH:**
```bash
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage/framework
chmod -R 775 storage/logs
```

**Via File Manager:**
- Right-click `storage` folder → Permissions → 755
- Right-click `bootstrap/cache` → Permissions → 755

### Step 9: Storage Link

**Via SSH:**
```bash
php artisan storage:link
```

**Without SSH:**
Create symlink manually via File Manager:
- In `public` folder, create folder named `storage`
- This should link to `../storage/app/public`

Or use this script (`create-storage-link.php` in public):
```php
<?php
$target = $_SERVER['DOCUMENT_ROOT'].'/../storage/app/public';
$link = $_SERVER['DOCUMENT_ROOT'].'/storage';

if (!file_exists($link)) {
    symlink($target, $link);
    echo "Storage link created!";
} else {
    echo "Storage link already exists!";
}
// Delete this file after running
```

### Step 10: Optimize for Production

**Via SSH:**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**Without SSH:**
Create `optimize.php`:
```php
<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->call('config:cache');
$kernel->call('route:cache');
$kernel->call('view:cache');

echo "Optimization complete!";
// Delete this file after running
```

---

## Hostinger-Specific Configuration

### Email (Using Hostinger SMTP)

Hostinger provides free email accounts. Use these settings:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=your@yourdomain.com
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
```

### Cron Jobs for Scheduled Tasks

1. In hPanel, go to **Advanced → Cron Jobs**
2. Add new cron job:
   - **Type:** Custom
   - **Minute:** `*`
   - **Hour:** `*`
   - **Day:** `*`
   - **Month:** `*`
   - **Weekday:** `*`
   - **Command:**
     ```
     cd ~/public_html/laravel && /usr/bin/php artisan schedule:run >> /dev/null 2>&1
     ```

### Database Backups

1. Go to **Databases → phpMyAdmin**
2. Export database regularly
3. Or set up automated backups in hPanel

---

## Common Issues & Solutions

### Issue 1: 500 Internal Server Error
**Solution:**
1. Check `.htaccess` exists in `public` folder
2. Verify file permissions (755 for storage)
3. Check `.env` file is configured correctly
4. Enable error display temporarily:
   ```php
   // In public/index.php, add before $app:
   ini_set('display_errors', 1);
   error_reporting(E_ALL);
   ```

### Issue 2: "Please provide a valid cache path"
**Solution:**
```bash
chmod -R 775 storage/framework/cache
chmod -R 775 storage/framework/sessions
chmod -R 775 storage/framework/views
chmod -R 775 bootstrap/cache
```

### Issue 3: Images not displaying
**Solution:**
1. Ensure storage link exists
2. Check file permissions on `storage/app/public`
3. Verify `APP_URL` in `.env` matches your domain

### Issue 4: Database connection failed
**Solution:**
1. Verify database credentials in `.env`
2. Ensure database exists
3. Check if user has permissions
4. Try `127.0.0.1` instead of `localhost` for DB_HOST

### Issue 5: Composer not available
**Solution:**
Contact Hostinger support to:
- Enable SSH access
- Run composer install via support ticket
- Or upload vendor folder from local

---

## Security Checklist

After deployment:
- [ ] Delete `install.php`, `optimize.php`, `create-storage-link.php`
- [ ] Verify `APP_DEBUG=false` in `.env`
- [ ] Verify `APP_ENV=production` in `.env`
- [ ] Files outside `public` are not accessible via browser
- [ ] SSL certificate installed (Hostinger provides free SSL)
- [ ] Force HTTPS redirect

**Force HTTPS (.htaccess in public folder):**
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Force HTTPS
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
    
    # Laravel routing
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

---

## Performance Tips for Shared Hosting

### 1. Enable OPcache
In hPanel → PHP Configuration → Enable OPcache

### 2. Use Database Caching
```env
CACHE_DRIVER=database
```
Then run:
```bash
php artisan cache:table
php artisan migrate
```

### 3. Optimize Autoloader
```bash
composer dump-autoload --optimize --classmap-authoritative
```

### 4. Session Driver
Use database instead of file:
```env
SESSION_DRIVER=database
```

### 5. Queue Processing
For abandoned carts and emails:
```bash
# Run this via cron every minute
php artisan queue:work --stop-when-empty
```

---

## Post-Deployment Testing

1. **Homepage:** https://yourdomain.com
2. **Admin Panel:** https://yourdomain.com/admin
3. **Test Checkout:** Complete a test order
4. **Test Email:** Register a new user
5. **Test Return:** Submit a return request
6. **Check Analytics:** Verify GA is tracking

---

## Support

**Hostinger Support:**
- Live Chat: Available 24/7
- Email: support@hostinger.com
- Knowledge Base: https://support.hostinger.com

**Common Hostinger Links:**
- hPanel: https://hpanel.hostinger.com
- phpMyAdmin: Access via hPanel → Databases
- File Manager: Access via hPanel → Files

---

## Maintenance

### Weekly Tasks
- Check error logs: `storage/logs/laravel.log`
- Database backup
- Review failed queue jobs

### Monthly Tasks
- Update dependencies (on staging first)
- Review and optimize database
- Check disk space usage
- Security audit

---

**Deployment Checklist Summary:**
1. ✅ Upload files to `/public_html/laravel/`
2. ✅ Install composer dependencies
3. ✅ Configure `.env` file
4. ✅ Generate APP_KEY
5. ✅ Point domain to public folder
6. ✅ Run migrations
7. ✅ Set file permissions
8. ✅ Create storage link
9. ✅ Cache config/routes/views
10. ✅ Set up cron jobs
11. ✅ Enable SSL
12. ✅ Test all features

**Estimated Deployment Time:** 30-60 minutes

Good luck with your deployment! 🚀
