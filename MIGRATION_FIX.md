# Migration Fix Applied

## Issue
Migration error during installation:
```
SQLSTATE[42S22]: Column not found: 1054 Unknown column 'shipping_phone' in 'orders'
```

## Root Cause
Migration `2025_11_27_070000_add_checkout_fields_to_orders_table.php` was trying to add `shipping_cost` column AFTER `shipping_phone`, but `shipping_phone` was being added later in the same migration.

## Fix Applied
Reordered column additions:
1. ✅ Add `shipping_phone` first
2. ✅ Then add `shipping_cost` after it
3. ✅ All other columns follow in proper order

## How to Apply This Fix

### If Installation Failed:
1. Drop your database or clear all tables
2. Re-run the installer
3. Migration should now complete successfully

### Via SSH/Terminal:
```bash
cd /path/to/your/project
php artisan migrate:fresh --force
```

### Without SSH (Manual):
1. Go to phpMyAdmin
2. Drop all tables (or drop entire database and recreate)
3. Re-run the installer at: yourdomain.com/installer

## Status
✅ **FIXED** - Migration order corrected, installation should now work smoothly.
