<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Fix products table: decode JSON strings in text fields
     */
    public function up(): void
    {
        // Get all products
        $products = DB::table('products')->get();
        
        foreach ($products as $product) {
            $updates = [];
            
            // Check and fix name field
            if ($this->isJsonString($product->name)) {
                $decoded = json_decode($product->name, true);
                $updates['name'] = is_array($decoded) && isset($decoded['name']) ? $decoded['name'] : $product->name;
            }
            
            // Check and fix description field  
            if ($this->isJsonString($product->description)) {
                $decoded = json_decode($product->description, true);
                $updates['description'] = is_array($decoded) && isset($decoded['description']) ? $decoded['description'] : $product->description;
            }
            
            // Check and fix slug field
            if ($this->isJsonString($product->slug)) {
                $decoded = json_decode($product->slug, true);
                $updates['slug'] = is_array($decoded) && isset($decoded['slug']) ? $decoded['slug'] : $product->slug;
            }
            
            // Update if there are fixes
            if (!empty($updates)) {
                DB::table('products')
                    ->where('id', $product->id)
                    ->update($updates);
            }
        }
    }
    
    /**
     * Check if a string is JSON
     */
    private function isJsonString($string): bool
    {
        if (!is_string($string) || empty($string)) {
            return false;
        }
        
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    public function down(): void
    {
        // No rollback needed
    }
};
