<?php

namespace App\Livewire;

use Livewire\Component;

class ContactForm extends Component
{
    public string $name = '';
    public string $phone = '';
    public string $email = '';
    public string $subject = '';
    public string $message = '';

    public bool $sent = false;

    public function submit(): void
    {
        $this->validate([
            'name' => 'required|string|max:120',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:120',
            'subject' => 'nullable|string|max:150',
            'message' => 'required|string|max:2000',
        ]);

        // For the demo we simply acknowledge receipt. In production this would
        // dispatch a mail / store the message.
        logger()->info('İletişim formu', $this->only(['name', 'phone', 'email', 'subject', 'message']));

        $this->sent = true;
        $this->reset(['name', 'phone', 'email', 'subject', 'message']);
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
