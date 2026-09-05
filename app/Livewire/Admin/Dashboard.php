<?php

namespace App\Livewire\Admin;

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
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Dashboard extends Component
{
    public string $section = 'profile';

    public array $profile = [];

    public array $skill = [];

    public array $service = [];

    public array $project = [];

    public array $experience = [];

    public array $education = [];

    public array $social = [];

    public array $content = [];

    public string $currentPassword = '';

    public string $newPassword = '';

    public string $newPasswordConfirmation = '';

    public string $adminEmail = '';

    public string $newAdminEmail = '';

    public string $emailCurrentPassword = '';

    public ?int $editingSkill = null;

    public ?int $editingService = null;

    public ?int $editingProject = null;

    public ?int $editingExperience = null;

    public ?int $editingEducation = null;

    public ?int $editingSocial = null;

    public function mount(): void
    {
        $this->loadProfile();
        $this->resetForms();
        $this->adminEmail = AdminCredential::email();
        $this->newAdminEmail = $this->adminEmail;
        $this->content = SiteContent::values();
    }

    public function loadProfile(): void
    {
        $profile = PortfolioProfile::query()->firstOrCreate([], [
            'name' => 'Mehedi Hasan',
            'title' => 'Laravel Developer',
            'tagline' => 'I build fast, clean, and maintainable web applications.',
            'bio' => 'A PHP and Laravel developer focused on practical, polished web products.',
            'email' => 'hello@example.com',
            'phone' => '+880 1XXXXXXXXX',
            'location' => 'Dhaka, Bangladesh',
        ]);

        $this->profile = $profile->only(['name', 'title', 'professional_roles', 'portfolio_card_roles', 'tagline', 'bio', 'email', 'phone', 'whatsapp_number', 'location', 'resume_url', 'profile_photo_path']);
    }

    public function saveProfile(): void
    {
        $validated = $this->validate([
            'profile.name' => ['required', 'string', 'max:120'],
            'profile.title' => ['required', 'string', 'max:160'],
            'profile.professional_roles' => ['required', 'string', 'max:1000'],
            'profile.portfolio_card_roles' => ['required', 'string', 'max:1000'],
            'profile.tagline' => ['required', 'string', 'max:220'],
            'profile.bio' => ['nullable', 'string', 'max:3000'],
            'profile.email' => ['nullable', 'email', 'max:160'],
            'profile.phone' => ['nullable', 'string', 'max:80'],
            'profile.whatsapp_number' => ['nullable', 'string', 'max:80'],
            'profile.location' => ['nullable', 'string', 'max:140'],
            'profile.resume_url' => ['nullable', 'url', 'max:255'],
        ]);

        $profile = PortfolioProfile::query()->firstOrFail();
        $data = $validated['profile'];

        $profile->update($data);
        $this->loadProfile();
        session()->flash('admin_status', 'Profile updated.');
    }

    public function deleteProfilePhoto(): void
    {
        $profile = PortfolioProfile::query()->firstOrFail();

        if ($profile->profile_photo_path) {
            Storage::disk('public')->delete($profile->profile_photo_path);
        }

        $profile->update(['profile_photo_path' => null]);
        $this->loadProfile();
        session()->flash('admin_status', 'Profile photo deleted.');
    }

    public function saveSkill(): void
    {
        $data = $this->validate([
            'skill.name' => ['required', 'string', 'max:80'],
            'skill.level' => ['required', 'integer', 'min:1', 'max:100'],
            'skill.category' => ['required', 'string', 'max:80'],
            'skill.sort_order' => ['required', 'integer', 'min:0'],
            'skill.is_visible' => ['boolean'],
        ])['skill'];

        Skill::query()->updateOrCreate(['id' => $this->editingSkill], $data);
        $this->resetSkill();
    }

    public function editSkill(int $id): void
    {
        $this->editingSkill = $id;
        $this->skill = Skill::findOrFail($id)->only(['name', 'level', 'category', 'sort_order', 'is_visible']);
    }

    public function deleteSkill(int $id): void
    {
        Skill::destroy($id);
    }

    public function saveService(): void
    {
        $data = $this->validate([
            'service.title' => ['required', 'string', 'max:120'],
            'service.description' => ['required', 'string', 'max:1000'],
            'service.icon' => ['nullable', 'string', 'max:60'],
            'service.sort_order' => ['required', 'integer', 'min:0'],
            'service.is_visible' => ['boolean'],
        ])['service'];

        Service::query()->updateOrCreate(['id' => $this->editingService], $data);
        $this->resetService();
    }

    public function editService(int $id): void
    {
        $this->editingService = $id;
        $this->service = Service::findOrFail($id)->only(['title', 'description', 'icon', 'sort_order', 'is_visible']);
    }

    public function deleteService(int $id): void
    {
        Service::destroy($id);
    }

    public function saveProject(): void
    {
        $data = $this->validate([
            'project.title' => ['required', 'string', 'max:140'],
            'project.description' => ['required', 'string', 'max:1400'],
            'project.tech_stack' => ['nullable', 'string', 'max:220'],
            'project.image_url' => ['nullable', 'url', 'max:255'],
            'project.demo_url' => ['nullable', 'url', 'max:255'],
            'project.github_url' => ['nullable', 'url', 'max:255'],
            'project.sort_order' => ['required', 'integer', 'min:0'],
            'project.is_featured' => ['boolean'],
            'project.is_visible' => ['boolean'],
        ])['project'];

        Project::query()->updateOrCreate(['id' => $this->editingProject], $data);
        $this->resetProject();
    }

    public function editProject(int $id): void
    {
        $this->editingProject = $id;
        $this->project = Project::findOrFail($id)->only(['title', 'description', 'tech_stack', 'image_url', 'demo_url', 'github_url', 'sort_order', 'is_featured', 'is_visible']);
    }

    public function deleteProject(int $id): void
    {
        Project::destroy($id);
    }

    public function saveExperience(): void
    {
        $data = $this->validate([
            'experience.role' => ['required', 'string', 'max:120'],
            'experience.company' => ['required', 'string', 'max:120'],
            'experience.period' => ['required', 'string', 'max:120'],
            'experience.description' => ['nullable', 'string', 'max:1200'],
            'experience.sort_order' => ['required', 'integer', 'min:0'],
            'experience.is_visible' => ['boolean'],
        ])['experience'];

        Experience::query()->updateOrCreate(['id' => $this->editingExperience], $data);
        $this->resetExperience();
    }

    public function editExperience(int $id): void
    {
        $this->editingExperience = $id;
        $this->experience = Experience::findOrFail($id)->only(['role', 'company', 'period', 'description', 'sort_order', 'is_visible']);
    }

    public function deleteExperience(int $id): void
    {
        Experience::destroy($id);
    }

    public function saveEducation(): void
    {
        $data = $this->validate([
            'education.level' => ['required', 'string', 'max:80'],
            'education.institution' => ['required', 'string', 'max:160'],
            'education.degree' => ['nullable', 'string', 'max:160'],
            'education.period' => ['nullable', 'string', 'max:120'],
            'education.result' => ['nullable', 'string', 'max:120'],
            'education.description' => ['nullable', 'string', 'max:1200'],
            'education.sort_order' => ['required', 'integer', 'min:0'],
            'education.is_visible' => ['boolean'],
        ])['education'];

        Education::query()->updateOrCreate(['id' => $this->editingEducation], $data);
        $this->resetEducation();
    }

    public function editEducation(int $id): void
    {
        $this->editingEducation = $id;
        $this->education = Education::findOrFail($id)->only(['level', 'institution', 'degree', 'period', 'result', 'description', 'sort_order', 'is_visible']);
    }

    public function deleteEducation(int $id): void
    {
        Education::destroy($id);
    }

    public function saveSocial(): void
    {
        $data = $this->validate([
            'social.label' => ['required', 'string', 'max:80'],
            'social.url' => ['required', 'url', 'max:255'],
            'social.sort_order' => ['required', 'integer', 'min:0'],
            'social.is_visible' => ['boolean'],
        ])['social'];

        SocialLink::query()->updateOrCreate(['id' => $this->editingSocial], $data);
        $this->resetSocial();
    }

    public function editSocial(int $id): void
    {
        $this->editingSocial = $id;
        $this->social = SocialLink::findOrFail($id)->only(['label', 'url', 'sort_order', 'is_visible']);
    }

    public function deleteSocial(int $id): void
    {
        SocialLink::destroy($id);
    }

    public function markMessageRead(int $id): void
    {
        ContactMessage::findOrFail($id)->update(['is_read' => true]);
    }

    public function deleteMessage(int $id): void
    {
        ContactMessage::destroy($id);
    }

    public function changePassword(): void
    {
        $this->validate([
            'currentPassword' => ['required', 'string'],
            'newPassword' => ['required', 'string', 'min:8', 'confirmed:newPasswordConfirmation'],
        ], [
            'newPassword.confirmed' => 'The new password confirmation does not match.',
        ]);

        if (! AdminCredential::passwordMatches($this->currentPassword)) {
            $this->addError('currentPassword', 'The current password is incorrect.');

            return;
        }

        AdminCredential::changePassword($this->newPassword);
        $this->reset(['currentPassword', 'newPassword', 'newPasswordConfirmation']);
        session()->flash('admin_status', 'Admin password changed successfully.');
    }

    public function changeAdminEmail(): void
    {
        $validated = $this->validate([
            'newAdminEmail' => ['required', 'email', 'max:255'],
            'emailCurrentPassword' => ['required', 'string'],
        ]);

        if (! AdminCredential::passwordMatches($this->emailCurrentPassword)) {
            $this->addError('emailCurrentPassword', 'The current password is incorrect.');

            return;
        }

        AdminCredential::changeEmail($validated['newAdminEmail']);
        $this->adminEmail = AdminCredential::email();
        $this->newAdminEmail = $this->adminEmail;
        $this->emailCurrentPassword = '';
        session()->flash('admin_status', 'Admin email changed successfully.');
    }

    public function saveSiteContent(): void
    {
        $rules = [];

        foreach (array_keys(SiteContent::defaults()) as $key) {
            $rules['content.'.$key] = ['required', 'string', 'max:2000'];
        }

        $validated = $this->validate($rules);
        SiteContent::saveValues($validated['content']);
        $this->content = SiteContent::values();
        session()->flash('admin_status', 'Website content updated successfully.');
    }

    public function logout()
    {
        session()->forget('portfolio_admin');

        return redirect()->route('admin.login');
    }

    public function resetForms(): void
    {
        $this->resetSkill();
        $this->resetService();
        $this->resetProject();
        $this->resetExperience();
        $this->resetEducation();
        $this->resetSocial();
    }

    public function resetSkill(): void
    {
        $this->editingSkill = null;
        $this->skill = ['name' => '', 'level' => 80, 'category' => 'Development', 'sort_order' => 0, 'is_visible' => true];
    }

    public function resetService(): void
    {
        $this->editingService = null;
        $this->service = ['title' => '', 'description' => '', 'icon' => '', 'sort_order' => 0, 'is_visible' => true];
    }

    public function resetProject(): void
    {
        $this->editingProject = null;
        $this->project = ['title' => '', 'description' => '', 'tech_stack' => '', 'image_url' => '', 'demo_url' => '', 'github_url' => '', 'sort_order' => 0, 'is_featured' => false, 'is_visible' => true];
    }

    public function resetExperience(): void
    {
        $this->editingExperience = null;
        $this->experience = ['role' => '', 'company' => '', 'period' => '', 'description' => '', 'sort_order' => 0, 'is_visible' => true];
    }

    public function resetEducation(): void
    {
        $this->editingEducation = null;
        $this->education = ['level' => 'Bachelor of Science (B.Sc.) in Computer Science and Engineering (CSE)', 'institution' => '', 'degree' => '', 'period' => '', 'result' => '', 'description' => '', 'sort_order' => 0, 'is_visible' => true];
    }

    public function resetSocial(): void
    {
        $this->editingSocial = null;
        $this->social = ['label' => '', 'url' => '', 'sort_order' => 0, 'is_visible' => true];
    }

    public function render()
    {
        return view('livewire.admin.dashboard', [
            'skills' => Skill::query()->orderBy('sort_order')->get(),
            'services' => Service::query()->orderBy('sort_order')->get(),
            'projects' => Project::query()->orderBy('sort_order')->get(),
            'experiences' => Experience::query()->orderBy('sort_order')->get(),
            'educations' => Education::query()->orderBy('sort_order')->get(),
            'socialLinks' => SocialLink::query()->orderBy('sort_order')->get(),
            'messages' => ContactMessage::query()->latest()->get(),
            'counts' => [
                'projects' => Project::count(),
                'skills' => Skill::count(),
                'messages' => ContactMessage::where('is_read', false)->count(),
            ],
        ])->layout('layouts.app', ['title' => 'Portfolio Admin']);
    }
}
