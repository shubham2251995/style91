# CRITICAL: Clear Database Before Installation

The installer is experiencing caching issues. **You MUST manually clear the database before running the installer.**

## Quick Fix (Choose ONE):

### Option 1: Use phpMyAdmin/cPanel (RECOMMENDED)
1. Login to phpMyAdmin or cPanel
2. Select your database (e.g., `style91`)
3. Click "Check All" to select all tables
4. From dropdown, select "Drop"
5. Click "Yes" to confirm
6. Run installer at `/install`

### Option 2: Use Command Line
```bash
php artisan db:reset
```
When prompted, type `yes` and press Enter.

### Option 3: Create Fresh Database
1. Create a new database (e.g., `style91_fresh`)
2. In installer form, use the new database name
3. Complete installation

## Why This Is Happening

The `dropAllTables()` method in the installer is being cached by PHP's OPcache or the web server. Even though the code has been updated, the server is still executing the old version.

## After Clearing Database

1. Visit `/install`
2. Fill in the form
3. Installation will complete successfully
4. You'll be redirected to the homepage

## Permanent Fix

After installation completes, run:
```bash
php artisan optimize:clear
```

This clears all caches and prevents future caching issues.
