# Style91 Shared Hosting Deployment Guide

## Prerequisites
- PHP 8.1 or higher
- MySQL/MariaDB database
- Composer installed locally
- SSH access (optional but recommended)
- SSL certificate (Let's Encrypt recommended)

## Deployment Steps

### 1. Prepare Local Environment

```bash
# Optimize for production
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Build frontend assets
npm install
npm run build
```

### 2. Upload Files

Upload all files EXCEPT:
- `.env` (will create on server)
- `node_modules/`
- `.git/`
- `storage/logs/*` (keep directory structure)
- `storage/framework/cache/*`
- `storage/framework/sessions/*`
- `storage/framework/views/*`

**Directory Structure on Shared Hosting:**
```
/home/username/
├── public_html/          (Point domain here OR move contents from /public)
├── style91/              (Application root - keep outside public_html for security)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/          (Contents go to public_html)
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   └── vendor/
```

### 3. Configure Public Directory

**Option A: Domain Points to public_html**
Move contents of `/public` directory to `/public_html`:
```bash
mv public/* ../public_html/
mv public/.htaccess ../public_html/
```

Update `index.php` in public_html:
```php
// Change this line:
require __DIR__.'/../vendor/autoload.php';
// To:
require __DIR__.'/../style91/vendor/autoload.php';

// Change this line:
$app = require_once __DIR__.'/../bootstrap/app.php';
// To:
$app = require_once __DIR__.'/../style91/bootstrap/app.php';
```

**Option B: Subdomain/Subfolder**
Create a `.htaccess` in public_html redirecting to `/public`.

### 4. File Permissions

```bash
cd /home/username/style91
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

### 5. Environment Configuration

Create `.env` file in application root:

```env
APP_NAME="Style91"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://yourdomain.com

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
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

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

Generate application key via SSH:
```bash
php artisan key:generate
```

Or manually generate a random 32-character string and add to .env:
```
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
```

### 6. Database Setup

Run migrations via SSH:
```bash
php artisan migrate --force
php artisan db:seed --force
```

If no SSH access, use phpMyAdmin:
1. Export local database
2. Import to production database
3. Update configuration

### 7. Storage Symlink

Via SSH:
```bash
php artisan storage:link
```

Without SSH, create manual symlink or move storage/app/public to public/storage.

### 8. Clear Caches

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### 9. Security Checklist

- [ ] APP_DEBUG=false in .env
- [ ] APP_ENV=production in .env
- [ ] Database credentials secure
- [ ] .env file permissions: 600
- [ ] Remove .git directory
- [ ] SSL certificate installed
- [ ] Force HTTPS redirect
- [ ] Disable directory listing

### 10. Force HTTPS (Add to .htaccess)

```apache
# Force HTTPS
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

### 11. Post-Deployment Testing

Test these flows:
- [ ] Homepage loads
- [ ] Admin login (/admin)
- [ ] User registration
- [ ] Product pages
- [ ] Add to cart
- [ ] Checkout process
- [ ] Image uploads work
- [ ] Email sending (test order confirmation)

### 12. Optimization

Set up cron jobs (if available):
```bash
# Laravel scheduler
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## Troubleshooting

### 500 Internal Server Error
- Check `.htaccess` exists in public directory
- Verify file permissions
- Check error logs (usually in /logs or accessible via cPanel)
- Ensure PHP version is 8.1+

### Database Connection Errors
- Verify DB credentials in .env
- Check if database exists
- Ensure database user has proper privileges

### Storage/Symlink Issues
- Manually create symlink or move files
- Check storage directory permissions (775)

### Assets Not Loading
- Verify `APP_URL` in .env matches your domain
- Clear browser cache
- Check asset paths in view source

## Performance Tips

1. **Enable OPcache** (via php.ini or cPanel)
2. **Use Redis/Memcached** for sessions and cache (if available)
3. **CDN for static assets** (Cloudflare free tier)
4. **Optimize images** before upload
5. **Enable Gzip compression** in .htaccess

## Support

For issues specific to your hosting provider:
- cPanel: Contact hosting support for PHP version, permissions
- Plesk: Check application logs in hosting panel
- Custom: Refer to hosting provider documentation

## Version Control

To update the site:
1. Make changes locally
2. Test thoroughly
3. Run build/cache commands
4. Upload changed files only
5. Run migrations if database changed
6. Clear caches
