# Style91 E-commerce Platform

## Overview
Style91 is a feature-complete, production-ready e-commerce platform built with Laravel 12 and Livewire 3. It includes comprehensive features for managing products, orders, customers, returns, and more.

## Features

### Core E-commerce
- ✅ Multi-step checkout process
- ✅ Guest and authenticated checkout
- ✅ Product variants (size, color, etc.)
- ✅ Shopping cart with session persistence
- ✅ Payment gateway integration (Razorpay, Cashfree, COD)
- ✅ Order tracking and management
- ✅ Coupon system with validation
- ✅ Shipping cost calculator

### Customer Features
- ✅ User accounts and profiles
- ✅ Order history
- ✅ Wishlist
- ✅ Address management
- ✅ Password change
- ✅ Return requests
- ✅ Loyalty points tracking
- ✅ Flash sales

### Admin Panel
- ✅ Comprehensive dashboard with analytics
- ✅ Product management (with variants)
- ✅ Order management with status tracking
- ✅ Customer management
- ✅ Return request processing
- ✅ Stock adjustment interface
- ✅ Coupon management
- ✅ Payment gateway configuration
- ✅ Shipping method setup
- ✅ sitesettings and theme customization

### Advanced Features
- ✅ Plugin system for modular features
- ✅ Abandoned cart recovery emails
- ✅ SEO optimization (meta tags, schema.org, canonical URLs)
- ✅ Google Analytics integration
- ✅ Image optimization service (optional)
- ✅ Email notifications for all events
- ✅ Low stock alerts
- ✅ Top products analytics

## Installation

### Requirements
- PHP >= 8.2
- MySQL >= 5.7 or MariaDB >= 10.3
- Composer
- Node.js & NPM

### Step 1: Clone Repository
```bash
git clone https://github.com/yourusername/style91.git
cd style91
```

### Step 2: Install Dependencies
```bash
composer install
npm install
```

### Step 3: Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` file with your database credentials:
```
DB_DATABASE=style91
DB_USERNAME=root
DB_PASSWORD=yourpassword
```

### Step 4: Run Migrations
```bash
php artisan migrate --seed
```

### Step 5: Build Assets
```bash
npm run build
```

### Step 6: Start Development Server
```bash
php artisan serve
```

Visit `http://localhost:8000` to see your application.

## Configuration

### Payment Gateways
Add your payment gateway credentials in `.env`:
```
RAZORPAY_KEY_ID=your_key_id
RAZORPAY_KEY_SECRET=your_secret

CASHFREE_APP_ID=your_app_id
CASHFREE_SECRET_KEY=your_secret
```

### Email Configuration
Configure SMTP settings in `.env`:
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.yourprovider.com
MAIL_PORT=587
MAIL_USERNAME=your@email.com
MAIL_PASSWORD=yourpassword
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@style91.com"
```

### Google Analytics (Optional)
```
GOOGLE_ANALYTICS_ID=GA-XXXXXXXXX
GOOGLE_TAG_MANAGER_ID=GTM-XXXXXXX
```

## Scheduled Tasks

Add this to your cron (for abandoned cart emails):
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

In `app/Console/Kernel.php`, add:
```php
protected function schedule(Schedule $schedule)
{
    $schedule->command('cart:process-abandoned')->hourly();
}
```

## Queue Workers (Recommended for Production)

Start queue worker for background jobs:
```bash
php artisan queue:work --queue=default
```

For production, use Supervisor:
```ini
[program:style91-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=2
```

## Optional: Image Optimization

To enable image upload with optimization, install Intervention/Image:
```bash
composer require intervention/image
```

Then configure in `.env`:
```
IMAGE_STORAGE_DISK=public
IMAGE_STORAGE_PATH=uploads
```

## Security

### Production Checklist
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Set `APP_ENV=production` in `.env`  
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Set up SSL certificate (HTTPS)
- [ ] Configure proper file permissions
- [ ] Enable firewall
- [ ] Set up automated backups
- [ ] Configure error monitoring (Sentry)

### File Permissions
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## Admin Access

After installation, create an admin user:
```bash
php artisan tinker
```

Then run:
```php
$admin = new App\Models\User();
$admin->name = 'Admin';
$admin->email = 'admin@style91.com';
$admin->password = Hash::make('password');
$admin->role = 'admin';
$admin->save();
```

Access admin panel at: `http://yourdomain.com/admin`

## Testing

Run automated tests:
```bash
php artisan test
```

## Troubleshooting

### Clear All Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Storage Link
If images aren't showing:
```bash
php artisan storage:link
```

### Migration Issues
Drop all tables and re-migrate (⚠️ WARNING: This will delete all data):
```bash
php artisan migrate:fresh --seed
```

## Support

For issues or questions:
- Email: support@style91.com
- GitHub Issues: [https://github.com/shubham2251995/style91/issues](https://github.com/shubham2251995/style91/issues)

## License

This project is proprietary software. All rights reserved.

## Credits

Built with:
- [Laravel 12](https://laravel.com)
- [Livewire 3](https://livewire.laravel.com)
- [TailwindCSS](https://tailwindcss.com)

---

**Version:** 1.0.0  
**Last Updated:** November 2025
