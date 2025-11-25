<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\NewsletterSubscriber;

class NewsletterManager extends Component
{
    use WithPagination;

    public $subject;
    public $message;
    public $showModal = false;

    protected $rules = [
        'subject' => 'required|string',
        'message' => 'required|string',
    ];

    public function openSendModal()
    {
        $this->reset(['subject', 'message']);
        $this->showModal = true;
    }

    public function sendNewsletter()
    {
        $this->validate();

        // Mock sending email
        // In a real app, you'd queue a job here
        
        $count = NewsletterSubscriber::where('is_subscribed', true)->count();
        
        session()->flash('message', "Newsletter queued for sending to {$count} subscribers.");
        $this->showModal = false;
    }

    public function delete($id)
    {
        NewsletterSubscriber::findOrFail($id)->delete();
    }

    public function render()
    {
        $subscribers = NewsletterSubscriber::latest()->paginate(20);

        return view('livewire.admin.newsletter-manager', [
            'subscribers' => $subscribers,
        ]);
    }
}
