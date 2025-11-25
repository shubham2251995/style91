<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SizeGuide extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'measurements',
        'fit_recommendations',
        'measurement_unit',
        'is_active',
    ];

    protected $casts = [
        'measurements' => 'array',
        'fit_recommendations' => 'array',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function getSizeRecommendation($measurements)
    {
        // Simple fit finder logic
        if (!$this->fit_recommendations || !is_array($measurements)) {
            return null;
        }

        // Compare user measurements with size chart
        foreach ($this->measurements as $size => $sizeData) {
            $matches = true;
            foreach ($measurements as $key => $value) {
                if (isset($sizeData[$key])) {
                    $min = $sizeData[$key]['min'] ?? $sizeData[$key] - 2;
                    $max = $sizeData[$key]['max'] ?? $sizeData[$key] + 2;
                    
                    if ($value < $min || $value > $max) {
                        $matches = false;
                        break;
                    }
                }
            }
            
            if ($matches) {
                return $size;
            }
        }

        return null;
    }
}
