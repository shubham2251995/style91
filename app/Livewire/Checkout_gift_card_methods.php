    public function applyGiftCard()
    {
        $this->giftCardError = '';

        $card = GiftCard::where('code', $this->giftCardCode)->first();

        if (!$card) {
            $this->giftCardError = 'Invalid gift card code';
            return;
        }

        if (!$card->isValid()) {
            $this->giftCardError = $card->isExpired() ? 'Gift card expired' : 'Gift card inactive';
            return;
        }

        if ($card->balance <= 0) {
            $this->giftCardError = 'Gift card has no balance';
            return;
        }

        $this->appliedGiftCard = $card;
        session()->flash('success', 'Gift card applied! Balance: $' . number_format($card->balance, 2));
    }

    public function removeGiftCard()
    {
        $this->appliedGiftCard = null;
        $this->giftCardCode = '';
        $this->giftCardError = '';
    }

    public function getGiftCardDiscountProperty()
    {
        if (!$this->appliedGiftCard) return 0;
        
        $subtotal = $this->getSubtotalProperty();
        $couponDiscount = $this->getCouponDiscountProperty();
        $afterCoupon = $subtotal - $couponDiscount;
        
        return min($this->appliedGiftCard->balance, $afterCoupon);
    }
