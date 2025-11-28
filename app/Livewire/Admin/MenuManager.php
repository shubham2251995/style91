<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Support\Str;

class MenuManager extends Component
{
    public $menus;
    public $selectedMenu;
    public $menuItems = [];
    
    // Menu Form
    public $menuName;
    public $menuLocation;
    
    // Item Form
    public $itemTitle;
    public $itemUrl;
    public $itemRoute;
    public $itemParentId;
    public $itemOrder = 0;
    public $itemTarget = '_self';
    public $editingItemId = null;

    public function mount()
    {
        $this->refreshMenus();
    }

    public function refreshMenus()
    {
        $this->menus = Menu::all();
        if ($this->selectedMenu) {
            $this->selectMenu($this->selectedMenu->id);
        } elseif ($this->menus->isNotEmpty()) {
            $this->selectMenu($this->menus->first()->id);
        }
    }

    public function selectMenu($menuId)
    {
        $this->selectedMenu = Menu::with('items.children')->find($menuId);
        $this->menuItems = $this->selectedMenu ? $this->selectedMenu->items()->whereNull('parent_id')->with('children')->get() : [];
    }

    public function createMenu()
    {
        $this->validate([
            'menuName' => 'required|string|max:255',
            'menuLocation' => 'nullable|string|max:255',
        ]);

        Menu::create([
            'name' => $this->menuName,
            'slug' => Str::slug($this->menuName),
            'location' => $this->menuLocation,
        ]);

        $this->menuName = '';
        $this->menuLocation = '';
        $this->refreshMenus();
    }

    public function deleteMenu($menuId)
    {
        Menu::find($menuId)->delete();
        $this->selectedMenu = null;
        $this->refreshMenus();
    }

    public function saveItem()
    {
        $this->validate([
            'itemTitle' => 'required|string|max:255',
            'itemUrl' => 'nullable|string|max:255',
            'itemRoute' => 'nullable|string|max:255',
        ]);

        if ($this->editingItemId) {
            $item = MenuItem::find($this->editingItemId);
            $item->update([
                'title' => $this->itemTitle,
                'url' => $this->itemUrl,
                'route' => $this->itemRoute,
                'parent_id' => $this->itemParentId ?: null,
                'order' => $this->itemOrder,
                'target' => $this->itemTarget,
            ]);
        } else {
            MenuItem::create([
                'menu_id' => $this->selectedMenu->id,
                'title' => $this->itemTitle,
                'url' => $this->itemUrl,
                'route' => $this->itemRoute,
                'parent_id' => $this->itemParentId ?: null,
                'order' => $this->itemOrder,
                'target' => $this->itemTarget,
            ]);
        }

        $this->resetItemForm();
        $this->selectMenu($this->selectedMenu->id);
    }

    public function editItem($itemId)
    {
        $item = MenuItem::find($itemId);
        $this->editingItemId = $item->id;
        $this->itemTitle = $item->title;
        $this->itemUrl = $item->url;
        $this->itemRoute = $item->route;
        $this->itemParentId = $item->parent_id;
        $this->itemOrder = $item->order;
        $this->itemTarget = $item->target;
    }

    public function deleteItem($itemId)
    {
        MenuItem::find($itemId)->delete();
        $this->selectMenu($this->selectedMenu->id);
    }

    public function resetItemForm()
    {
        $this->editingItemId = null;
        $this->itemTitle = '';
        $this->itemUrl = '';
        $this->itemRoute = '';
        $this->itemParentId = '';
        $this->itemOrder = 0;
        $this->itemTarget = '_self';
    }

    public function render()
    {
        return view('livewire.admin.menu-manager');
    }
}
