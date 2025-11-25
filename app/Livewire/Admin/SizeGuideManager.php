<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\SizeGuide;
use App\Models\Category;

class SizeGuideManager extends Component
{
    public $sizeGuides;
    public $categories;
    public $isModalOpen = false;

    // Form fields
    public $sizeGuideId;
    public $categoryId;
    public $name;
    public $description;
    public $measurementUnit = 'cm';
    public $isActive = true;
    
    // Size chart data
    public $sizes = [];
    public $measurements = [];

    public function mount()
    {
        $this->loadSizeGuides();
        $this->categories = Category::all();
    }

    public function loadSizeGuides()
    {
        $this->sizeGuides = SizeGuide::with('category')->get();
    }

    public function createNew()
    {
        $this->reset(['sizeGuideId', 'categoryId', 'name', 'description', 'sizes', 'measurements']);
        $this->measurementUnit = 'cm';
        $this->isActive = true;
        
        // Initialize with common sizes
        $this->sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
        $this->measurements = [
            'chest' => array_fill(0, 6, ''),
            'waist' => array_fill(0, 6, ''),
            'hips' => array_fill(0, 6, ''),
            'length' => array_fill(0, 6, ''),
        ];
        
        $this->isModalOpen = true;
    }

    public function editSizeGuide($id)
    {
        $sizeGuide = SizeGuide::findOrFail($id);
        
        $this->sizeGuideId = $sizeGuide->id;
        $this->categoryId = $sizeGuide->category_id;
        $this->name = $sizeGuide->name;
        $this->description = $sizeGuide->description;
        $this->measurementUnit = $sizeGuide->measurement_unit;
        $this->isActive = $sizeGuide->is_active;
        
        // Load measurements
        $measurements = $sizeGuide->measurements ?? [];
        $this->sizes = array_keys($measurements);
        
        // Convert to editable format
        $this->measurements = [];
        foreach ($measurements as $size => $data) {
            foreach ($data as $key => $value) {
                if (!isset($this->measurements[$key])) {
                    $this->measurements[$key] = [];
                }
                $this->measurements[$key][] = $value;
            }
        }
        
        $this->isModalOpen = true;
    }

    public function saveSizeGuide()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'categoryId' => 'nullable|exists:categories,id',
            'measurementUnit' => 'required|in:cm,inches',
        ]);

        // Build measurements array
        $measurementsData = [];
        foreach ($this->sizes as $index => $size) {
            $measurementsData[$size] = [];
            foreach ($this->measurements as $key => $values) {
                if (isset($values[$index]) && $values[$index] !== '') {
                    $measurementsData[$size][$key] = $values[$index];
                }
            }
        }

        $data = [
            'category_id' => $this->categoryId,
            'name' => $this->name,
            'description' => $this->description,
            'measurements' => $measurementsData,
            'measurement_unit' => $this->measurementUnit,
            'is_active' => $this->isActive,
        ];

        if ($this->sizeGuideId) {
            SizeGuide::findOrFail($this->sizeGuideId)->update($data);
            session()->flash('message', 'Size guide updated successfully!');
        } else {
            SizeGuide::create($data);
            session()->flash('message', 'Size guide created successfully!');
        }

        $this->closeModal();
        $this->loadSizeGuides();
    }

    public function deleteSizeGuide($id)
    {
        SizeGuide::findOrFail($id)->delete();
        session()->flash('message', 'Size guide deleted successfully!');
        $this->loadSizeGuides();
    }

    public function toggleStatus($id)
    {
        $sizeGuide = SizeGuide::findOrFail($id);
        $sizeGuide->update(['is_active' => !$sizeGuide->is_active]);
        $this->loadSizeGuides();
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->reset(['sizeGuideId', 'categoryId', 'name', 'description', 'sizes', 'measurements']);
    }

    public function render()
    {
        return view('livewire.admin.size-guide-manager');
    }
}
