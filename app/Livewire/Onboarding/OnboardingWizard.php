<?php

namespace App\Livewire\Onboarding;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class OnboardingWizard extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $totalSteps = 4;
    
    // Step 1: Profile Setup
    public $avatar;
    public $bio;
    public $phone;
    public $date_of_birth;
    public $gender;
    
    // Step 2: Style Preferences
    public $style_preferences = [];
    public $favorite_categories = [];
    
    // Step 3: Size Preferences
    public $top_size;
    public $bottom_size;
    public $shoe_size;
    public $fit_preference;
    
    // Step 4: Notifications
    public $email_notifications = true;
    public $order_updates = true;
    public $new_arrivals = false;
    public $promotions = false;

    public function mount()
    {
        $user = auth()->user();
        
        // Resume from saved step
        if ($user->onboarding_step > 0 && !$user->onboarding_completed) {
            $this->currentStep = $user->onboarding_step;
        }
        
        // Load existing data
        $this->bio = $user->bio;
        $this->phone = $user->phone;
        $this->date_of_birth = $user->date_of_birth?->format('Y-m-d');
        $this->gender = $user->gender;
        $this->style_preferences = $user->style_preferences ?? [];
        
        if ($user->size_preferences) {
            $this->top_size = $user->size_preferences['top'] ?? null;
            $this->bottom_size = $user->size_preferences['bottom'] ?? null;
            $this->shoe_size = $user->size_preferences['shoe'] ?? null;
            $this->fit_preference = $user->size_preferences['fit'] ?? 'regular';
        }
        
        if ($user->notification_preferences) {
            $this->email_notifications = $user->notification_preferences['email'] ?? true;
            $this->order_updates = $user->notification_preferences['orders'] ?? true;
            $this->new_arrivals = $user->notification_preferences['new_arrivals'] ?? false;
            $this->promotions = $user->notification_preferences['promotions'] ?? false;
        }
    }

    public function nextStep()
    {
        $this->saveCurrentStep();
        
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
            auth()->user()->update(['onboarding_step' => $this->currentStep]);
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function skipOnboarding()
    {
        auth()->user()->update([
            'onboarding_completed' => true,
            'onboarding_completed_at' => now(),
        ]);
        
        return redirect()->route('home');
    }

    private function saveCurrentStep()
    {
        $user = auth()->user();
        
        switch ($this->currentStep) {
            case 1:
                $this->saveProfileSetup();
                break;
            case 2:
                $this->saveStylePreferences();
                break;
            case 3:
                $this->saveSizePreferences();
                break;
            case 4:
                $this->saveNotificationPreferences();
                break;
        }
        
        $user->updateProfileCompletion();
    }

    private function saveProfileSetup()
    {
        $data = [
            'bio' => $this->bio,
            'phone' => $this->phone,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
        ];

        if ($this->avatar) {
            $path = $this->avatar->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        auth()->user()->update($data);
    }

    private function saveStylePreferences()
    {
        auth()->user()->update([
            'style_preferences' => $this->style_preferences
        ]);
    }

    private function saveSizePreferences()
    {
        auth()->user()->update([
            'size_preferences' => [
                'top' => $this->top_size,
                'bottom' => $this->bottom_size,
                'shoe' => $this->shoe_size,
                'fit' => $this->fit_preference,
            ]
        ]);
    }

    private function saveNotificationPreferences()
    {
        auth()->user()->update([
            'notification_preferences' => [
                'email' => $this->email_notifications,
                'orders' => $this->order_updates,
               'new_arrivals' => $this->new_arrivals,
                'promotions' => $this->promotions,
            ]
        ]);
    }

    public function completeOnboarding()
    {
        $this->saveCurrentStep();
        
        $user = auth()->user();
        $user->completeOnboarding();
        $user->updateProfileCompletion();
        
        session()->flash('onboarding_success', 'Welcome to Style91! You\'ve earned 100 loyalty points! 🎉');
        
        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.onboarding.onboarding-wizard')
            ->layout('components.layouts.minimal');
    }
}
