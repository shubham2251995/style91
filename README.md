# Style91 E-Commerce Platform

Professional streetwear e-commerce platform built with Laravel 11, Livewire 3, and Tailwind CSS.

## 🚀 Quick Start

```bash
# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate --seed

# Build assets
npm run dev

# Start server
php artisan serve
```

Visit: `http://localhost:8000`

**Default Admin:**
- Email: admin@style91.com  
- Password: password

## 📚 Documentation

- [Deployment Guide](docs/DEPLOYMENT.md) - Production deployment instructions
- [Troubleshooting](docs/TROUBLESHOOTING.md) - Common issues and fixes

## ✨ Features

- **E-Commerce Core:** Products, Variants, Cart, Checkout
- **Marketing:** Flash Sales, Coupons, Referrals
- **Customer:** Loyalty Points, Wishlist, Profile
- **Admin:** Complete management dashboard
- **Plugin Architecture:** 50+ modular features

## 🛠 Tech Stack

- Laravel 11.x
- Livewire 3.x
- Tailwind CSS
- Alpine.js
- MySQL

## 📦 Deployment

See [docs/DEPLOYMENT.md](docs/DEPLOYMENT.md) for detailed shared hosting instructions.

```bash
# Generate sitemap
php artisan sitemap:generate

# Optimize for production
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
npm run build
```

## 🔧 Development

```bash
# Run tests
php artisan test

# Generate sitemap
php artisan sitemap:generate

# Clear caches
php artisan optimize:clear
```

## 📄 License

MIT License

## 🤝 Support

For issues, email support@style91.com

---

*Built with ❤️ for modern e-commerce*
