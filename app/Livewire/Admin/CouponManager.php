<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Coupon;

class CouponManager extends Component
{
    use WithPagination;

    public $isModalOpen = false;
    public $couponId;
    public $code;
    public $type = 'percentage';
    public $value;
    public $minimum_order = 0;
    public $usage_limit;
    public $expires_at;
    public $is_active = true;

    protected $rules = [
        'code' => 'required|string|max:255|unique:coupons,code',
        'type' => 'required|in:percentage,fixed',
        'value' => 'required|numeric|min:0',
        'minimum_order' => 'nullable|numeric|min:0',
        'usage_limit' => 'nullable|integer|min:1',
        'expires_at' => 'nullable|date',
        'is_active' => 'boolean',
    ];

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
        $this->code = '';
        $this->type = 'percentage';
        $this->value = '';
        $this->minimum_order = 0;
        $this->usage_limit = null;
        $this->expires_at = '';
        $this->is_active = true;
        $this->couponId = null;
    }

    public function store()
    {
        $rules = $this->rules;
        if ($this->couponId) {
            $rules['code'] = 'required|string|max:255|unique:coupons,code,' . $this->couponId;
        }

        $this->validate($rules);

        Coupon::updateOrCreate(['id' => $this->couponId], [
            'code' => strtoupper($this->code),
            'type' => $this->type,
            'value' => $this->value,
            'minimum_order' => $this->minimum_order ?? 0,
            'usage_limit' => $this->usage_limit,
            'expires_at' => $this->expires_at,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', $this->couponId ? 'Coupon Updated Successfully.' : 'Coupon Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        $this->couponId = $id;
        $this->code = $coupon->code;
        $this->type = $coupon->type;
        $this->value = $coupon->value;
        $this->minimum_order = $coupon->minimum_order;
        $this->usage_limit = $coupon->usage_limit;
        $this->expires_at = $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : '';
        $this->is_active = $coupon->is_active;

        $this->openModal();
    }

    public function delete($id)
    {
        Coupon::find($id)->delete();
        session()->flash('message', 'Coupon Deleted Successfully.');
    }

    public function toggleActive($id)
    {
        $coupon = Coupon::find($id);
        $coupon->is_active = !$coupon->is_active;
        $coupon->save();
    }

    public function render()
    {
        $coupons = Coupon::latest()->paginate(20);

        return view('livewire.admin.coupon-manager', [
            'coupons' => $coupons,
        ]);
    }
}
