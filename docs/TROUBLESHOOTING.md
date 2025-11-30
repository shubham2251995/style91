# Troubleshooting Guide

## Common Installation Issues

### Database Connection Errors

**Issue:** "Access denied for user"
**Solution:** 
1. Verify database credentials in `.env`
2. Ensure database user has ALL PRIVILEGES
3. Try `localhost` instead of `127.0.0.1` (or vice versa)

**Issue:** "Unknown database"
**Solution:** Create the database first via phpMyAdmin or cPanel

### Migration Issues

**Issue:** "Duplicate table" errors
**Solution:**
```bash
# Drop all tables and re-run
php artisan migrate:fresh --seed
```

**Issue:** Tables already exist
**Solution:** The installer auto-detects this and skips migrations

### Storage/Upload Issues

**Issue:** Images not uploading
**Solution:**
```bash
php artisan storage:link
```

If symlink fails (shared hosting):
- Create `public/storage` manually
- Copy contents from `storage/app/public`

### Session Expired During Install

**Issue:** "Session expired" error during installation
**Solution:** 
- Use the same browser tab
- Don't refresh during installation
- Clear browser cookies if issue persists

### Homepage JSON Error

**Issue:** "Unexpected token '<'" on homepage
**Solution:**
1. Ensure `.env` is configured correctly
2. Run: `php artisan config:clear`
3. Check `APP_URL` matches your domain

### 500 Internal Server Error

**Post-Installation 500 Errors:**
1. Check `.env` file exists and is configured
2. Verify file permissions:
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```
3. Clear all caches:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

### Plugin Manager Empty

**Issue:** No plugins showing
**Solution:** Plugins auto-initialize on first access to `/admin/plugins`

### Clear Database Before Fresh Install

If you need to start completely fresh:

```bash
# Via Artisan
php artisan migrate:fresh

# Via cPanel/phpMyAdmin
# Drop all tables manually
# Re-run installer at /install
```

## Shared Hosting Specific

### mod_rewrite not working

**Solution:** Ensure `.htaccess` exists in `public/` directory with:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^ index.php [L]
</IfModule>
```

### PHP Version Issues

**Requirement:** PHP 8.1 or higher
**Solution:** Change PHP version in cPanel → Select PHP Version

### Composer Not Found

**Solution:** 
- Use hosting's built-in composer
- Or upload `composer.phar` and run: `php composer.phar install`

### Node/NPM Not Available

**Solution:** Build assets locally, upload `public/build` directory

## Performance Issues

### Slow Page Load

**Solutions:**
1. Enable OPcache in php.ini
2. Run: `php artisan config:cache`
3. Run: `php artisan route:cache`
4. Use Redis for sessions (if available)

### Database Queries Slow

**Solutions:**
1. Add indexes to frequently queried columns
2. Enable MySQL query cache
3. Use eager loading in queries

## Email Issues

### Emails Not Sending

**Check:**
1. MAIL_* settings in `.env`
2. Test with: Log driver first (MAIL_DRIVER=log)
3. Check storage/logs for email logs

## Contact Support

For persistent issues:
- Email: support@style91.com
- Include: Laravel log from `storage/logs/laravel.log`
