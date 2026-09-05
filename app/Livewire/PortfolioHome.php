<?php

namespace App\Livewire;

use App\Mail\ContactMessageReceived;
use App\Models\AdminCredential;
use App\Models\ContactMessage;
use App\Models\Education;
use App\Models\Experience;
use App\Models\PortfolioProfile;
use App\Models\Project;
use App\Models\Service;
use App\Models\SiteContent;
use App\Models\Skill;
use App\Models\SocialLink;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Throwable;

class PortfolioHome extends Component
{
    public string $name = '';

    public string $email = '';

    public string $subject = '';

    public string $message = '';

    public function sendMessage(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'subject' => ['nullable', 'string', 'max:180'],
            'message' => ['required', 'string', 'max:3000'],
        ]);

        $contactMessage = ContactMessage::create($validated);

        try {
            Mail::to(AdminCredential::email())->send(new ContactMessageReceived($contactMessage));
        } catch (Throwable $exception) {
            Log::error('Contact notification email could not be sent.', [
                'contact_message_id' => $contactMessage->id,
                'exception' => $exception,
            ]);
        }

        $this->reset(['name', 'email', 'subject', 'message']);
        session()->flash('contact_status', SiteContent::values()['contact_success']);
    }

    public function render()
    {
        $content = SiteContent::values();

        return view('livewire.portfolio-home', [
            'content' => $content,
            'profile' => PortfolioProfile::query()->first() ?? new PortfolioProfile,
            'skills' => Skill::query()->where('is_visible', true)->orderBy('sort_order')->orderBy('name')->get(),
            'services' => Service::query()->where('is_visible', true)->orderBy('sort_order')->get(),
            'projects' => Project::query()->where('is_visible', true)->orderByDesc('is_featured')->orderBy('sort_order')->get(),
            'experiences' => Experience::query()->where('is_visible', true)->orderBy('sort_order')->get(),
            'educations' => Education::query()->where('is_visible', true)->orderBy('sort_order')->get(),
            'socialLinks' => SocialLink::query()->where('is_visible', true)->orderBy('sort_order')->get(),
        ])->layout('layouts.app', ['title' => $content['meta_title']]);
    }
}
