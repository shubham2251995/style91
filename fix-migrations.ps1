# Migration Fix Script
# This script will safely run all pending migrations

Write-Host "Style91 - Migration Fix Script" -ForegroundColor Cyan
Write-Host "================================" -ForegroundColor Cyan
Write-Host ""

# Step 1: Check current migration status
Write-Host "Step 1: Checking migration status..." -ForegroundColor Yellow
php artisan migrate:status

Write-Host ""
Write-Host "Step 2: Running migrations with force flag..." -ForegroundColor Yellow

# Run migrations
$result = php artisan migrate --force 2>&1
Write-Host $result

if ($LASTEXITCODE -eq 0) {
    Write-Host "Migrations completed successfully!" -ForegroundColor Green
}
else {
    Write-Host "Migration failed. Trying individual migrations..." -ForegroundColor Yellow
    
    # Try running specific migrations
    php artisan migrate --path=database/migrations/2025_11_27_071500_fix_products_table_schema.php --force
    php artisan migrate --path=database/migrations/2025_11_27_070000_add_checkout_fields_to_orders_table.php --force
}

Write-Host ""
Write-Host "Step 3: Final migration status..." -ForegroundColor Yellow
php artisan migrate:status

Write-Host ""
Write-Host "Migration fix script completed!" -ForegroundColor Green
