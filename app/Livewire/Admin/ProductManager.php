<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;
use App\Models\Tag;
use App\Models\ProductVariant;
use App\Models\VariantOption;
use Illuminate\Support\Str;

class ProductManager extends Component
{
    use WithPagination;

    public $isModalOpen = false;
    public $productId;
    public $name;
    public $slug;
    public $description;
    public $price;
    public $image_url;
    public $stock_quantity = 0;
    public $category_id;
    public $selectedTags = [];
    
    // Variants
    public $variantOptions = []; // [['name' => '', 'values' => '']]
    public $variants = []; // [['id' => null, 'sku' => '', 'price' => '', 'stock_quantity' => '', 'options' => []]]
    
    // Filters
    public $searchTerm = '';
    public $filterCategory = '';
    public $filterStatus = '';
    public $filterStock = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:products,slug',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'image_url' => 'nullable|url',
        'stock_quantity' => 'required|integer|min:0',
        'category_id' => 'nullable|exists:categories,id',
    ];

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function updatingFilterCategory()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->slug = '';
        $this->description = '';
        $this->price = '';
        $this->image_url = '';
        $this->stock_quantity = 0;
        $this->category_id = null;
        $this->selectedTags = [];
        $this->productId = null;
        $this->variantOptions = [];
        $this->variants = [];
    }

    public function addVariantOption()
    {
        $this->variantOptions[] = ['name' => '', 'values' => ''];
    }

    public function removeVariantOption($index)
    {
        unset($this->variantOptions[$index]);
        $this->variantOptions = array_values($this->variantOptions);
    }

    public function generateVariants()
    {
        $options = [];
        foreach ($this->variantOptions as $opt) {
            if (!empty($opt['name']) && !empty($opt['values'])) {
                $values = array_map('trim', explode(',', $opt['values']));
                if (count($values) > 0) {
                    $options[$opt['name']] = $values;
                }
            }
        }

        if (empty($options)) {
            return;
        }

        $combinations = [[]];
        foreach ($options as $name => $values) {
            $newCombinations = [];
            foreach ($combinations as $combination) {
                foreach ($values as $value) {
                    $newCombinations[] = $combination + [$name => $value];
                }
            }
            $combinations = $newCombinations;
        }

        // Merge with existing variants if possible, or create new ones
        foreach ($combinations as $combination) {
            // Check if this combination already exists in $this->variants
            $exists = false;
            foreach ($this->variants as $existing) {
                if ($existing['options'] == $combination) {
                    $exists = true;
                    break;
                }
            }

            if (!$exists) {
                $this->variants[] = [
                    'id' => null,
                    'sku' => $this->slug . '-' . implode('-', array_values($combination)),
                    'price' => $this->price,
                    'stock_quantity' => 0,
                    'options' => $combination,
                    'is_active' => true,
                ];
            }
        }
    }

    public function removeVariant($index)
    {
        unset($this->variants[$index]);
        $this->variants = array_values($this->variants);
    }

    public function store()
    {
        $rules = $this->rules;
        if ($this->productId) {
            $rules['slug'] = 'required|string|max:255|unique:products,slug,' . $this->productId;
        }

        $this->validate($rules);

        $product = Product::updateOrCreate(['id' => $this->productId], [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'image_url' => $this->image_url,
            'stock_quantity' => $this->stock_quantity,
            'category_id' => $this->category_id,
        ]);

        // Sync tags
        $product->tags()->sync($this->selectedTags);

        // Sync Variant Options
        $product->variantOptions()->delete();
        foreach ($this->variantOptions as $opt) {
            if (!empty($opt['name']) && !empty($opt['values'])) {
                $values = array_map('trim', explode(',', $opt['values']));
                $product->variantOptions()->create([
                    'name' => $opt['name'],
                    'values' => $values,
                ]);
            }
        }

        // Sync Variants
        // We need to be careful not to delete variants that are still in the list but maybe have ID null (new ones)
        // For simplicity, we can delete all and recreate, but that loses history/IDs if we want to keep them.
        // Better: Update existing, create new, delete missing.
        
        $keptIds = [];
        foreach ($this->variants as $v) {
            if (isset($v['id']) && $v['id']) {
                $variant = ProductVariant::find($v['id']);
                if ($variant) {
                    $variant->update([
                        'sku' => $v['sku'],
                        'price' => $v['price'] ?: null,
                        'stock_quantity' => $v['stock_quantity'],
                        'options' => $v['options'],
                        'is_active' => $v['is_active'] ?? true,
                    ]);
                    $keptIds[] = $variant->id;
                }
            } else {
                $variant = $product->variants()->create([
                    'sku' => $v['sku'],
                    'price' => $v['price'] ?: null,
                    'stock_quantity' => $v['stock_quantity'],
                    'options' => $v['options'],
                    'is_active' => $v['is_active'] ?? true,
                ]);
                $keptIds[] = $variant->id;
            }
        }
        $product->variants()->whereNotIn('id', $keptIds)->delete();

        session()->flash('message', $this->productId ? 'Product Updated Successfully.' : 'Product Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $product = Product::with('tags')->findOrFail($id);
        $this->productId = $id;
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->image_url = $product->image_url;
        $this->stock_quantity = $product->stock_quantity;
        $this->category_id = $product->category_id;
        $this->selectedTags = $product->tags->pluck('id')->toArray();

        // Load Variant Options
        $this->variantOptions = $product->variantOptions->map(function($opt) {
            return [
                'name' => $opt->name,
                'values' => implode(', ', $opt->values),
            ];
        })->toArray();

        // Load Variants
        $this->variants = $product->variants->map(function($v) {
            return [
                'id' => $v->id,
                'sku' => $v->sku,
                'price' => $v->price,
                'stock_quantity' => $v->stock_quantity,
                'options' => $v->options,
                'is_active' => $v->is_active,
            ];
        })->toArray();

        $this->openModal();
    }

    public function delete($id)
    {
        Product::find($id)->delete();
        session()->flash('message', 'Product Deleted Successfully.');
    }

    public function duplicate($id)
    {
        $product = Product::with('tags')->findOrFail($id);
        
        $newProduct = $product->replicate();
        $newProduct->name = $product->name . ' (Copy)';
        $newProduct->slug = $product->slug . '-copy-' . time();
        $newProduct->save();

        // Duplicate tags
        $newProduct->tags()->sync($product->tags->pluck('id'));

        session()->flash('message', 'Product Duplicated Successfully.');
    }

    public function updatedName($value)
    {
        if (!$this->productId) {
            $this->slug = Str::slug($value);
        }
    }

    public function render()
    {
        $query = Product::with(['category', 'tags']);

        // Search
        if ($this->searchTerm) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('slug', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $this->searchTerm . '%');
            });
        }

        // Filter by category
        if ($this->filterCategory) {
            $query->where('category_id', $this->filterCategory);
        }

        // Filter by stock status
        if ($this->filterStock === 'low') {
            $query->where('stock_quantity', '<', 10)->where('stock_quantity', '>', 0);
        } elseif ($this->filterStock === 'out') {
            $query->where('stock_quantity', 0);
        } elseif ($this->filterStock === 'in') {
            $query->where('stock_quantity', '>', 0);
        }

        $products = $query->latest()->paginate(20);

        return view('livewire.admin.product-manager', [
            'products' => $products,
            'categories' => Category::active()->orderBy('name')->get(),
            'allTags' => Tag::orderBy('name')->get(),
        ]);
    }
}
