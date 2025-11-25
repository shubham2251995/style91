<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\ShippingMethod;
use App\Models\ShippingZone;

class ShippingManager extends Component
{
    public $activeTab = 'methods'; // methods or zones
    
    // For shipping methods
    public $methodId;
    public $name = '';
    public $description = '';
    public $type = 'flat_rate';
    public $cost = 0;
    public $minOrderAmount = null;
    public $estimatedDaysMin = 3;
    public $estimatedDaysMax = 7;
    public $isActive = true;
    
    public $isMethodModalOpen = false;
    
    // For shipping zones
    public $zoneId;
    public $zoneName = '';
    public $countries = [];
    public $states = [];
    public $postcodes = [];
    public $isZoneActive = true;
    public $isZoneModalOpen = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'type' => 'required|in:flat_rate,free_shipping,local_pickup',
        'cost' => 'required|numeric|min:0',
        'estimatedDaysMin' => 'required|integer|min:1',
        'estimatedDaysMax' => 'required|integer|min:1',
    ];

    public function openMethodModal($id = null)
    {
        if ($id) {
            $method = ShippingMethod::findOrFail($id);
            $this->methodId = $method->id;
            $this->name = $method->name;
            $this->description = $method->description;
            $this->type = $method->type;
            $this->cost = $method->cost;
            $this->minOrderAmount = $method->min_order_amount;
            $this->estimatedDaysMin = $method->estimated_days_min;
            $this->estimatedDaysMax = $method->estimated_days_max;
            $this->isActive = $method->is_active;
        }
        $this->isMethodModalOpen = true;
    }

    public function closeMethodModal()
    {
        $this->isMethodModalOpen = false;
        $this->reset(['methodId', 'name', 'description', 'type', 'cost', 'minOrderAmount', 'estimatedDaysMin', 'estimatedDaysMax', 'isActive']);
    }

    public function saveMethod()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'cost' => $this->cost,
            'min_order_amount' => $this->minOrderAmount,
            'estimated_days_min' => $this->estimatedDaysMin,
            'estimated_days_max' => $this->estimatedDaysMax,
            'is_active' => $this->isActive,
        ];

        if ($this->methodId) {
            ShippingMethod::findOrFail($this->methodId)->update($data);
            session()->flash('message', 'Shipping method updated successfully.');
        } else {
            ShippingMethod::create($data);
            session()->flash('message', 'Shipping method created successfully.');
        }

        $this->closeMethodModal();
    }

    public function deleteMethod($id)
    {
        ShippingMethod::findOrFail($id)->delete();
        session()->flash('message', 'Shipping method deleted successfully.');
    }

    public function toggleMethodStatus($id)
    {
        $method = ShippingMethod::findOrFail($id);
        $method->update(['is_active' => !$method->is_active]);
    }

    public function openZoneModal($id = null)
    {
        if ($id) {
            $zone = ShippingZone::findOrFail($id);
            $this->zoneId = $zone->id;
            $this->zoneName = $zone->name;
            $this->countries = $zone->countries ?? [];
            $this->states = $zone->states ?? [];
            $this->postcodes = $zone->postcodes ?? [];
            $this->isZoneActive = $zone->is_active;
        }
        $this->isZoneModalOpen = true;
    }

    public function closeZoneModal()
    {
        $this->isZoneModalOpen = false;
        $this->reset(['zoneId', 'zoneName', 'countries', 'states', 'postcodes', 'isZoneActive']);
    }

    public function saveZone()
    {
        $this->validate([
            'zoneName' => 'required|string|max:255',
        ]);

        $data = [
            'name' => $this->zoneName,
            'countries' => $this->countries,
            'states' => $this->states,
            'postcodes' => $this->postcodes,
            'is_active' => $this->isZoneActive,
        ];

        if ($this->zoneId) {
            ShippingZone::findOrFail($this->zoneId)->update($data);
            session()->flash('message', 'Shipping zone updated successfully.');
        } else {
            ShippingZone::create($data);
            session()->flash('message', 'Shipping zone created successfully.');
        }

        $this->closeZoneModal();
    }

    public function deleteZone($id)
    {
        ShippingZone::findOrFail($id)->delete();
        session()->flash('message', 'Shipping zone deleted successfully.');
    }

    public function render()
    {
        $methods = ShippingMethod::orderBy('display_order')->get();
        $zones = ShippingZone::all();

        return view('livewire.admin.shipping-manager', [
            'methods' => $methods,
            'zones' => $zones,
        ]);
    }
}
