<?php

namespace App\Services;

use App\Models\ShippingMethod;
use App\Models\ShippingZone;
use Illuminate\Support\Collection;

class ShippingService
{
    public function getAvailableMethods($country, $state = null, $postcode = null)
    {
        // 1. Find matching zones
        $matchingZones = ShippingZone::active()->get()->filter(function ($zone) use ($country, $state, $postcode) {
            return $zone->matchesAddress($country, $state, $postcode);
        });

        // 2. Get methods from matching zones
        $methods = collect();
        
        if ($matchingZones->isEmpty()) {
            // If no specific zone matches, return "Rest of World" or default methods if any
            // For now, we'll return methods that are NOT assigned to any zone (global defaults)
            // Or methods that are in a "Default" zone.
            // Let's assume methods without zones are global.
            $methods = ShippingMethod::active()->doesntHave('zones')->get();
        } else {
            foreach ($matchingZones as $zone) {
                foreach ($zone->shippingMethods as $method) {
                    if ($method->pivot->is_enabled) {
                        // Check if we already have this method (prioritize zone overrides?)
                        // For simplicity, we'll just add it.
                        // If a method is in multiple matching zones, we should pick the most specific one?
                        // Let's just collect all unique methods.
                        if (!$methods->contains('id', $method->id)) {
                            // Attach the pivot data (cost_override) to the method object for easy access
                            $method->cost_override = $method->pivot->cost_override;
                            $methods->push($method);
                        }
                    }
                }
            }
        }
        
        // If no zone-specific methods found, maybe fallback to global methods?
        if ($methods->isEmpty()) {
             $methods = ShippingMethod::active()->doesntHave('zones')->get();
        }

        return $methods->sortBy('display_order');
    }

    public function calculateCost(ShippingMethod $method, $country, $state = null, $postcode = null)
    {
        // Check if method has a zone override for this address
        // We need to find the zone again to be sure, or pass the zone context.
        // But simpler: just check if the method object already has cost_override set (from getAvailableMethods)
        // If not, we might need to re-fetch.
        
        if (isset($method->cost_override) && !is_null($method->cost_override)) {
             return $method->cost_override;
        }
        
        // Fallback: check zones again
        $matchingZones = ShippingZone::active()->get()->filter(function ($zone) use ($country, $state, $postcode) {
            return $zone->matchesAddress($country, $state, $postcode);
        });
        
        foreach ($matchingZones as $zone) {
            $zoneMethod = $zone->shippingMethods()->where('shipping_method_id', $method->id)->first();
            if ($zoneMethod && $zoneMethod->pivot->is_enabled && !is_null($zoneMethod->pivot->cost_override)) {
                return $zoneMethod->pivot->cost_override;
            }
        }

        return $method->cost;
    }
}
