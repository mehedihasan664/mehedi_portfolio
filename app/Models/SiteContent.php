<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteContent extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return ['content' => 'array'];
    }

    public static function defaults(): array
    {
        return [
            'meta_title' => 'Mehedi Hasan | Portfolio',
            'nav_skills' => 'Skills',
            'nav_projects' => 'Projects',
            'nav_education' => 'Education',
            'nav_experience' => 'Experience',
            'nav_contact' => 'Contact',
            'social_email_label' => 'Email',
            'footer_text' => 'Building reliable web experiences with clean code and thoughtful design.',
            'welcome_text' => 'Welcome to My Portfolio',
            'hire_button' => 'Hire Me',
            'whatsapp_button' => 'WhatsApp',
            'projects_button' => 'View Projects',
            'resume_button' => 'Resume',
            'availability_label' => 'Available',
            'availability_text' => 'Open to Laravel, MERN Stack & new technologies',
            'card_label' => 'Premium Portfolio',
            'card_status' => 'Open',
            'experience_stat_value' => '1+',
            'experience_stat_label' => 'Years Experience',
            'projects_stat_label' => 'Projects',
            'skills_stat_label' => 'Skills',
            'focus_stat_value' => '100%',
            'focus_stat_label' => 'Focus',
            'core_stack_label' => 'Core Stack',
            'core_stack_text' => 'PHP, Laravel, Livewire, Tailwind CSS, JavaScript, SQL, MySQL, Git, GitHub',
            'skills_eyebrow' => 'Technical strength',
            'skills_heading' => 'Skills',
            'services_eyebrow' => 'What I build',
            'services_heading' => 'Services',
            'projects_eyebrow' => 'Selected work',
            'projects_heading' => 'Projects',
            'featured_label' => 'Featured',
            'demo_label' => 'Live Demo',
            'github_label' => 'GitHub',
            'education_eyebrow' => 'Academic background',
            'education_heading' => 'Education',
            'experience_eyebrow' => 'Career path',
            'experience_heading' => 'Experience',
            'contact_eyebrow' => 'Start a project',
            'contact_heading' => 'Contact',
            'contact_description' => 'Tell me about your Laravel, Livewire, or custom web app idea.',
            'email_me_button' => 'Email Me',
            'email_me_subject' => 'Portfolio project inquiry',
            'contact_name_placeholder' => 'Name',
            'contact_email_placeholder' => 'Email',
            'contact_subject_placeholder' => 'Subject',
            'contact_message_placeholder' => 'Message',
            'contact_button' => 'Send Message',
            'contact_sending' => 'Sending...',
            'contact_success' => 'Message sent successfully. I will get back to you soon.',
        ];
    }

    public static function values(): array
    {
        return array_replace(static::defaults(), static::query()->first()?->content ?? []);
    }

    public static function saveValues(array $content): void
    {
        static::query()->updateOrCreate(['id' => 1], ['content' => $content]);
    }
}
