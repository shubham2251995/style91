<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressManager extends Component
{
    public $showForm = false;
    public $editingId = null;

    public $label = '';
    public $full_name = '';
    public $phone = '';
    public $address_line1 = '';
    public $address_line2 = '';
    public $city = '';
    public $state = '';
    public $zip_code = '';
    public $country = 'India';
    public $is_default = false;

    protected $rules = [
        'full_name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'address_line1' => 'required|string|max:500',
        'address_line2' => 'nullable|string|max:500',
        'city' => 'required|string|max:100',
        'state' => 'nullable|string|max:100',
        'zip_code' => 'required|string|max:20',
        'country' => 'required|string|max:100',
        'label' => 'nullable|string|max:50',
    ];

    public function openForm($id = null)
    {
        $this->resetForm();
        if ($id) {
            $address = Address::findOrFail($id);
            $this->editingId = $id;
            $this->fill($address->toArray());
        }
        $this->showForm = true;
    }

    public function closeForm()
    {
        $this->showForm = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editingId = null;
        $this->label = '';
        $this->full_name = Auth::user()->name ?? '';
        $this->phone = '';
        $this->address_line1 = '';
        $this->address_line2 = '';
        $this->city = '';
        $this->state = '';
        $this->zip_code = '';
        $this->country = 'India';
        $this->is_default = false;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'user_id' => Auth::id(),
            'label' => $this->label,
            'full_name' => $this->full_name,
            'phone' => $this->phone,
            'address_line1' => $this->address_line1,
            'address_line2' => $this->address_line2,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
            'country' => $this->country,
            'is_default' => $this->is_default,
        ];

        if ($this->editingId) {
            Address::find($this->editingId)->update($data);
            session()->flash('success', 'Address updated successfully!');
        } else {
            Address::create($data);
            session()->flash('success', 'Address added successfully!');
        }

        if ($this->is_default) {
            Address::setAsDefault(Auth::id(), $this->editingId ?? Address::latest()->first()->id);
        }

        $this->closeForm();
    }

    public function delete($id)
    {
        Address::findOrFail($id)->delete();
        session()->flash('success', 'Address deleted successfully!');
    }

    public function setDefault($id)
    {
        Address::setAsDefault(Auth::id(), $id);
        session()->flash('success', 'Default address updated!');
    }

    public function render()
    {
        $addresses = Address::where('user_id', Auth::id())->latest()->get();
        return view('livewire.address-manager', ['addresses' => $addresses]);
    }
}
