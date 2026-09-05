<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PortfolioProfile extends Model
{
    protected $guarded = [];

    protected $appends = ['effective_whatsapp_number', 'portfolio_card_roles_list', 'profile_photo_url', 'professional_roles_list', 'whatsapp_url'];

    public function getEffectiveWhatsappNumberAttribute(): ?string
    {
        return $this->whatsapp_number ?: $this->phone;
    }

    public function getPortfolioCardRolesListAttribute(): array
    {
        $roles = preg_split('/\r\n|\r|\n/', (string) $this->portfolio_card_roles);
        $roles = array_values(array_filter(array_map('trim', $roles ?: [])));

        return $roles ?: ['Full Stack Developer', 'PHP & Laravel Developer'];
    }

    public function getProfessionalRolesListAttribute(): array
    {
        $roles = preg_split('/\r\n|\r|\n/', (string) $this->professional_roles);
        $roles = array_values(array_filter(array_map('trim', $roles ?: [])));

        return $roles ?: ['Software Engineer', $this->title ?: 'PHP & Laravel Developer'];
    }

    public function getProfilePhotoUrlAttribute(): ?string
    {
        if (! $this->profile_photo_path) {
            return null;
        }

        return Storage::disk('public')->url($this->profile_photo_path);
    }

    public function getWhatsappUrlAttribute(): ?string
    {
        if (! $this->effective_whatsapp_number) {
            return null;
        }

        $number = preg_replace('/\D+/', '', $this->effective_whatsapp_number);

        return $number ? 'https://wa.me/'.$number : null;
    }
}
