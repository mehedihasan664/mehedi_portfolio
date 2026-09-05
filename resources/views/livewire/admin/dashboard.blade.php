<div class="min-h-screen bg-zinc-950 text-zinc-100">
    <aside class="fixed inset-y-0 left-0 hidden w-64 border-r border-white/10 bg-zinc-950 p-5 lg:block">
        <a href="{{ route('home') }}" target="_blank" rel="noopener" class="text-sm text-teal-300">View Website</a>
        <h1 class="mt-5 text-2xl font-semibold">Admin Panel</h1>
        <div class="mt-6 grid grid-cols-3 gap-2 text-center text-sm">
            <div class="rounded-md bg-white/[0.04] p-3"><b>{{ $counts['projects'] }}</b><span class="block text-zinc-500">Projects</span></div>
            <div class="rounded-md bg-white/[0.04] p-3"><b>{{ $counts['skills'] }}</b><span class="block text-zinc-500">Skills</span></div>
            <div class="rounded-md bg-white/[0.04] p-3"><b>{{ $counts['messages'] }}</b><span class="block text-zinc-500">Unread</span></div>
        </div>
        <nav class="mt-8 space-y-2">
            @foreach (['profile' => 'Profile', 'content' => 'Site Content', 'skills' => 'Skills', 'services' => 'Services', 'projects' => 'Projects', 'experience' => 'Experience', 'education' => 'Education', 'social' => 'Social Links', 'messages' => 'Messages', 'security' => 'Security'] as $key => $label)
                <button wire:click="$set('section', '{{ $key }}')" class="w-full rounded-md px-3 py-2 text-left text-sm {{ $section === $key ? 'bg-teal-400 text-zinc-950' : 'text-zinc-300 hover:bg-white/10' }}">{{ $label }}</button>
            @endforeach
        </nav>
        <button wire:click="logout" class="mt-8 w-full rounded-md border border-white/10 px-3 py-2 text-sm text-zinc-300 hover:border-red-300 hover:text-red-200">Logout</button>
    </aside>

    <main class="lg:pl-64">
        <div class="mx-auto max-w-6xl px-5 py-6">
            <div class="flex flex-wrap items-center justify-between gap-3 lg:hidden">
                <h1 class="text-2xl font-semibold">Admin Panel</h1>
                <div class="flex items-center gap-2">
                    <a href="{{ route('home') }}" target="_blank" rel="noopener" class="rounded-md bg-teal-400 px-3 py-2 text-sm font-semibold text-zinc-950">View Website</a>
                    <button wire:click="logout" class="rounded-md border border-white/10 px-3 py-2 text-sm">Logout</button>
                </div>
            </div>
            <div class="mt-4 flex gap-2 overflow-x-auto pb-2 lg:hidden">
                @foreach (['profile' => 'Profile', 'content' => 'Content', 'skills' => 'Skills', 'services' => 'Services', 'projects' => 'Projects', 'experience' => 'Experience', 'education' => 'Education', 'social' => 'Social', 'messages' => 'Messages', 'security' => 'Security'] as $key => $label)
                    <button wire:click="$set('section', '{{ $key }}')" class="shrink-0 rounded-md px-3 py-2 text-sm {{ $section === $key ? 'bg-teal-400 text-zinc-950' : 'bg-white/10 text-zinc-300' }}">{{ $label }}</button>
                @endforeach
            </div>

            @if (session('admin_status'))
                <div class="mt-5 rounded-md bg-teal-400/10 p-3 text-sm text-teal-200">{{ session('admin_status') }}</div>
            @endif

            <section class="mt-6 rounded-lg border border-white/10 bg-white/[0.04] p-5">
                @if ($section === 'profile')
                    <h2 class="text-2xl font-semibold">Profile</h2>
                    <div class="mt-6">
                        <label class="block text-sm font-semibold text-zinc-300">Profile Photo</label>
                        <div class="mt-3 flex flex-wrap items-center gap-4">
                            <div class="h-28 w-28 overflow-hidden rounded-md border border-white/10 bg-zinc-900">
                                @if (! empty($profile['profile_photo_path']))
                                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($profile['profile_photo_path']) }}" alt="Profile photo" data-profile-photo-preview class="h-full w-full object-cover object-[center_22%]">
                                @else
                                    <img src="" alt="Selected profile photo preview" data-profile-photo-preview class="hidden h-full w-full object-cover object-[center_22%]">
                                    <div data-profile-photo-empty class="flex h-full w-full items-center justify-center text-sm font-semibold text-zinc-500">No Photo</div>
                                @endif
                            </div>
                            <div class="min-w-64 flex-1">
                                <form action="{{ route('admin.profile-photo.upload') }}" method="POST" enctype="multipart/form-data" data-profile-photo-form class="flex flex-wrap gap-3">
                                    @csrf
                                    <input type="file" name="profile_photo" accept="image/jpeg,image/png,image/webp" data-profile-photo-input class="min-w-0 flex-1 rounded-md border border-white/10 bg-zinc-900 px-4 py-3 text-sm text-zinc-300 file:mr-4 file:rounded-md file:border-0 file:bg-teal-400 file:px-3 file:py-2 file:font-semibold file:text-zinc-950">
                                    <button type="submit" data-profile-photo-button class="rounded-md bg-teal-400 px-5 py-3 font-semibold text-zinc-950 disabled:cursor-not-allowed disabled:opacity-60">
                                        <span>Upload Photo</span>
                                    </button>
                                </form>
                                <p data-profile-photo-name class="mt-2 hidden text-xs text-teal-200"></p>
                                <p data-profile-photo-status class="mt-2 hidden text-xs text-teal-200"></p>
                                <p class="mt-2 text-xs text-zinc-500">JPG, PNG, or WebP. Large photos are automatically compressed below 2MB.</p>
                                @error('profile_photo') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                                @if (! empty($profile['profile_photo_path']))
                                    <button type="button" wire:click="deleteProfilePhoto" wire:confirm="Delete profile photo?" class="mt-3 rounded-md border border-red-400/30 px-4 py-2 text-sm font-semibold text-red-200 hover:border-red-300">Delete Photo</button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <form wire:submit="saveProfile" class="mt-6 grid gap-4 md:grid-cols-2">
                        <x-admin.input label="Name" model="profile.name" />
                        <x-admin.input label="Title" model="profile.title" />
                        <x-admin.textarea label="Professional Roles (one per line)" model="profile.professional_roles" class="md:col-span-2" />
                        <x-admin.textarea label="Portfolio Card Roles (one per line)" model="profile.portfolio_card_roles" class="md:col-span-2" />
                        <x-admin.input label="Tagline" model="profile.tagline" class="md:col-span-2" />
                        <x-admin.textarea label="Bio" model="profile.bio" class="md:col-span-2" />
                        <x-admin.input label="Email" model="profile.email" />
                        <x-admin.input label="Phone" model="profile.phone" />
                        <x-admin.input label="WhatsApp Number" model="profile.whatsapp_number" />
                        <x-admin.input label="Location" model="profile.location" />
                        <x-admin.input label="Resume URL" model="profile.resume_url" class="md:col-span-2" />
                        <button wire:loading.attr="disabled" wire:target="saveProfile" class="rounded-md bg-teal-400 px-5 py-3 font-semibold text-zinc-950 disabled:cursor-not-allowed disabled:opacity-60 md:col-span-2">
                            <span wire:loading.remove wire:target="saveProfile">Save Profile</span>
                            <span wire:loading wire:target="saveProfile">Saving...</span>
                        </button>
                    </form>
                @endif

                @if ($section === 'content')
                    <div>
                        <h2 class="text-2xl font-semibold">Site Content</h2>
                        <p class="mt-2 text-sm text-zinc-400">Public website-er fixed text gulo section-by-section edit korun.</p>

                        <form wire:submit="saveSiteContent" class="mt-6 space-y-6">
                            @php
                                $contentGroups = [
                                    'General & Navigation' => [
                                        'meta_title' => 'Browser/Page Title', 'nav_skills' => 'Skills Menu', 'nav_projects' => 'Projects Menu',
                                        'nav_education' => 'Education Menu', 'nav_experience' => 'Experience Menu', 'nav_contact' => 'Contact Menu',
                                        'social_email_label' => 'Social Email Label',
                                        'footer_text' => 'Footer Text',
                                    ],
                                    'Hero Buttons' => [
                                        'welcome_text' => 'Welcome Text', 'hire_button' => 'Hire Button', 'whatsapp_button' => 'WhatsApp Button',
                                        'projects_button' => 'Projects Button', 'resume_button' => 'Resume Button',
                                    ],
                                    'Profile Card' => [
                                        'availability_label' => 'Availability Label', 'availability_text' => 'Availability Text',
                                        'card_label' => 'Card Label', 'card_status' => 'Card Status',
                                        'experience_stat_value' => 'Experience Years Value', 'experience_stat_label' => 'Experience Years Label',
                                        'projects_stat_label' => 'Projects Stat Label', 'skills_stat_label' => 'Skills Stat Label',
                                        'focus_stat_value' => 'Focus Stat Value', 'focus_stat_label' => 'Focus Stat Label',
                                        'core_stack_label' => 'Core Stack Label', 'core_stack_text' => 'Core Stack Text',
                                    ],
                                    'Section Headings' => [
                                        'skills_eyebrow' => 'Skills Small Heading', 'skills_heading' => 'Skills Heading',
                                        'services_eyebrow' => 'Services Small Heading', 'services_heading' => 'Services Heading',
                                        'projects_eyebrow' => 'Projects Small Heading', 'projects_heading' => 'Projects Heading',
                                        'featured_label' => 'Featured Label', 'demo_label' => 'Demo Link Label', 'github_label' => 'GitHub Link Label',
                                        'education_eyebrow' => 'Education Small Heading', 'education_heading' => 'Education Heading',
                                        'experience_eyebrow' => 'Experience Small Heading', 'experience_heading' => 'Experience Heading',
                                    ],
                                    'Contact' => [
                                        'contact_eyebrow' => 'Contact Small Heading', 'contact_heading' => 'Contact Heading',
                                        'contact_description' => 'Contact Description', 'email_me_button' => 'Email Me Button',
                                        'email_me_subject' => 'Default Email Subject', 'contact_name_placeholder' => 'Name Placeholder',
                                        'contact_email_placeholder' => 'Email Placeholder', 'contact_subject_placeholder' => 'Subject Placeholder',
                                        'contact_message_placeholder' => 'Message Placeholder', 'contact_button' => 'Submit Button',
                                        'contact_sending' => 'Sending Text', 'contact_success' => 'Success Message',
                                    ],
                                ];
                            @endphp

                            @foreach ($contentGroups as $group => $fields)
                                <fieldset class="rounded-lg border border-white/10 bg-zinc-950/60 p-5">
                                    <legend class="px-2 text-lg font-bold text-teal-200">{{ $group }}</legend>
                                    <div class="grid gap-4 md:grid-cols-2">
                                        @foreach ($fields as $key => $label)
                                            @if (in_array($key, ['core_stack_text', 'contact_description', 'contact_success']))
                                                <x-admin.textarea :label="$label" :model="'content.'.$key" class="md:col-span-2" />
                                            @else
                                                <x-admin.input :label="$label" :model="'content.'.$key" />
                                            @endif
                                        @endforeach
                                    </div>
                                </fieldset>
                            @endforeach

                            <button wire:loading.attr="disabled" wire:target="saveSiteContent" class="w-full rounded-md bg-teal-400 px-5 py-3 font-semibold text-zinc-950 disabled:opacity-60">
                                <span wire:loading.remove wire:target="saveSiteContent">Save Site Content</span>
                                <span wire:loading wire:target="saveSiteContent">Saving...</span>
                            </button>
                        </form>
                    </div>
                @endif

                @if ($section === 'skills')
                    <x-admin.heading title="Skills" :editing="$editingSkill" />
                    <form wire:submit="saveSkill" class="mt-6 grid gap-4 md:grid-cols-5">
                        <x-admin.input label="Name" model="skill.name" />
                        <x-admin.input label="Category" model="skill.category" />
                        <x-admin.input label="Level" model="skill.level" type="number" />
                        <x-admin.input label="Order" model="skill.sort_order" type="number" />
                        <x-admin.checkbox label="Visible" model="skill.is_visible" />
                        <x-admin.form-actions reset="resetSkill" :editing="$editingSkill" />
                    </form>
                    <x-admin.table :items="$skills" edit="editSkill" delete="deleteSkill" :columns="['name' => 'Name', 'category' => 'Category', 'level' => 'Level', 'is_visible' => 'Visible']" />
                @endif

                @if ($section === 'services')
                    <x-admin.heading title="Services" :editing="$editingService" />
                    <form wire:submit="saveService" class="mt-6 grid gap-4 md:grid-cols-4">
                        <x-admin.input label="Title" model="service.title" />
                        <x-admin.input label="Icon" model="service.icon" />
                        <x-admin.input label="Order" model="service.sort_order" type="number" />
                        <x-admin.checkbox label="Visible" model="service.is_visible" />
                        <x-admin.textarea label="Description" model="service.description" class="md:col-span-4" />
                        <x-admin.form-actions reset="resetService" :editing="$editingService" />
                    </form>
                    <x-admin.table :items="$services" edit="editService" delete="deleteService" :columns="['title' => 'Title', 'description' => 'Description', 'is_visible' => 'Visible']" />
                @endif

                @if ($section === 'projects')
                    <x-admin.heading title="Projects" :editing="$editingProject" />
                    <form wire:submit="saveProject" class="mt-6 grid gap-4 md:grid-cols-3">
                        <x-admin.input label="Title" model="project.title" />
                        <x-admin.input label="Tech Stack" model="project.tech_stack" />
                        <x-admin.input label="Image URL" model="project.image_url" />
                        <x-admin.input label="Demo URL" model="project.demo_url" />
                        <x-admin.input label="GitHub URL" model="project.github_url" />
                        <x-admin.input label="Order" model="project.sort_order" type="number" />
                        <x-admin.checkbox label="Featured" model="project.is_featured" />
                        <x-admin.checkbox label="Visible" model="project.is_visible" />
                        <x-admin.textarea label="Description" model="project.description" class="md:col-span-3" />
                        <x-admin.form-actions reset="resetProject" :editing="$editingProject" />
                    </form>
                    <x-admin.table :items="$projects" edit="editProject" delete="deleteProject" :columns="['title' => 'Title', 'tech_stack' => 'Tech', 'is_featured' => 'Featured', 'is_visible' => 'Visible']" />
                @endif

                @if ($section === 'experience')
                    <x-admin.heading title="Experience" :editing="$editingExperience" />
                    <form wire:submit="saveExperience" class="mt-6 grid gap-4 md:grid-cols-4">
                        <x-admin.input label="Role" model="experience.role" />
                        <x-admin.input label="Company" model="experience.company" />
                        <x-admin.input label="Period" model="experience.period" />
                        <x-admin.input label="Order" model="experience.sort_order" type="number" />
                        <x-admin.checkbox label="Visible" model="experience.is_visible" />
                        <x-admin.textarea label="Description" model="experience.description" class="md:col-span-4" />
                        <x-admin.form-actions reset="resetExperience" :editing="$editingExperience" />
                    </form>
                    <x-admin.table :items="$experiences" edit="editExperience" delete="deleteExperience" :columns="['role' => 'Role', 'company' => 'Company', 'period' => 'Period', 'is_visible' => 'Visible']" />
                @endif

                @if ($section === 'education')
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div>
                            <h2 class="text-2xl font-semibold">Education</h2>
                            <p class="mt-2 text-sm text-zinc-400">Degree/title, institution, year, and bullet points ekhane manage korun.</p>
                        </div>
                        @if ($editingEducation)
                            <span class="rounded-full bg-amber-400/15 px-3 py-1 text-sm text-amber-200">Editing #{{ $editingEducation }}</span>
                        @endif
                    </div>

                    <form wire:submit="saveEducation" class="mt-6 rounded-lg border border-white/10 bg-zinc-950/70 p-5">
                        <div class="grid gap-4 md:grid-cols-2">
                            <x-admin.input label="Education Title" model="education.level" class="md:col-span-2" />
                            <x-admin.input label="Institution Name" model="education.institution" />
                            <x-admin.input label="Degree / Group" model="education.degree" />
                            <x-admin.input label="Year / Period" model="education.period" />
                            <x-admin.input label="Result / Status" model="education.result" />
                            <x-admin.input label="Order" model="education.sort_order" type="number" />
                            <x-admin.checkbox label="Visible" model="education.is_visible" />
                            <x-admin.textarea label="Description Bullets (one line per bullet)" model="education.description" class="md:col-span-2" />
                        </div>
                        <div class="mt-4">
                            <x-admin.form-actions reset="resetEducation" :editing="$editingEducation" />
                        </div>
                    </form>

                    <div class="mt-8 space-y-4">
                        @forelse ($educations as $item)
                            <article class="rounded-lg border border-white/10 bg-zinc-950 p-5">
                                <div class="flex flex-wrap items-start justify-between gap-4">
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-teal-300">{{ $item->period ?: 'No year set' }}</p>
                                        <h3 class="mt-2 text-xl font-bold text-white">{{ $item->level }}</h3>
                                        <p class="mt-2 font-semibold text-zinc-200">{{ $item->institution }}</p>
                                        @if ($item->degree)
                                            <p class="mt-1 text-sm text-zinc-400">{{ $item->degree }}</p>
                                        @endif
                                        @if ($item->result)
                                            <p class="mt-3 inline-flex rounded-full border border-teal-300/20 bg-teal-300/10 px-3 py-1 text-xs font-semibold text-teal-100">{{ $item->result }}</p>
                                        @endif
                                    </div>
                                    <div class="flex gap-2">
                                        <button wire:click="editEducation({{ $item->id }})" class="rounded-md border border-white/10 px-3 py-2 text-sm text-zinc-200">Edit</button>
                                        <button wire:click="deleteEducation({{ $item->id }})" wire:confirm="Delete this education item?" class="rounded-md border border-red-400/30 px-3 py-2 text-sm text-red-200">Delete</button>
                                    </div>
                                </div>
                                @if ($item->description)
                                    <ul class="mt-5 space-y-2 text-sm leading-6 text-zinc-300">
                                        @foreach (preg_split('/\r\n|\r|\n/', $item->description) as $line)
                                            @if (trim($line) !== '')
                                                <li class="flex gap-2"><span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-teal-300"></span><span>{{ trim($line, " \t\n\r\0\x0B-*") }}</span></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            </article>
                        @empty
                            <p class="text-zinc-400">No education items yet.</p>
                        @endforelse
                    </div>
                @endif

                @if ($section === 'social')
                    <x-admin.heading title="Social Links" :editing="$editingSocial" />
                    <form wire:submit="saveSocial" class="mt-6 grid gap-4 md:grid-cols-4">
                        <x-admin.input label="Label" model="social.label" />
                        <x-admin.input label="URL" model="social.url" />
                        <x-admin.input label="Order" model="social.sort_order" type="number" />
                        <x-admin.checkbox label="Visible" model="social.is_visible" />
                        <x-admin.form-actions reset="resetSocial" :editing="$editingSocial" />
                    </form>
                    <x-admin.table :items="$socialLinks" edit="editSocial" delete="deleteSocial" :columns="['label' => 'Label', 'url' => 'URL', 'is_visible' => 'Visible']" />
                @endif

                @if ($section === 'messages')
                    <h2 class="text-2xl font-semibold">Messages</h2>
                    <div class="mt-6 space-y-4">
                        @forelse ($messages as $message)
                            <article class="rounded-lg border border-white/10 bg-zinc-950 p-4">
                                <div class="flex flex-wrap items-start justify-between gap-3">
                                    <div>
                                        <p class="font-semibold">{{ $message->name }} <span class="text-sm font-normal text-zinc-500">{{ $message->email }}</span></p>
                                        <p class="mt-1 text-sm text-teal-300">{{ $message->subject ?: 'No subject' }}</p>
                                    </div>
                                    <div class="flex gap-2">
                                        @unless ($message->is_read)
                                            <button wire:click="markMessageRead({{ $message->id }})" class="rounded-md bg-teal-400 px-3 py-2 text-sm font-semibold text-zinc-950">Read</button>
                                        @endunless
                                        <button wire:click="deleteMessage({{ $message->id }})" wire:confirm="Delete this message?" class="rounded-md border border-red-400/30 px-3 py-2 text-sm text-red-200">Delete</button>
                                    </div>
                                </div>
                                <p class="mt-4 leading-7 text-zinc-300">{{ $message->message }}</p>
                                <p class="mt-3 text-xs text-zinc-500">{{ $message->created_at->format('M d, Y h:i A') }}</p>
                            </article>
                        @empty
                            <p class="text-zinc-400">No messages yet.</p>
                        @endforelse
                    </div>
                @endif

                @if ($section === 'security')
                    <div class="grid gap-8 lg:grid-cols-2">
                        <div>
                            <h2 class="text-2xl font-semibold">Change Admin Email</h2>
                            <p class="mt-2 text-sm text-zinc-400">The new email will be required for login and password reset.</p>

                            <form wire:submit="changeAdminEmail" class="mt-6 space-y-4">
                                <label class="block">
                                    <span class="text-sm font-medium text-zinc-300">Current Admin Email</span>
                                    <input type="email" value="{{ $adminEmail }}" readonly class="mt-2 w-full rounded-md border border-white/10 bg-zinc-900 px-4 py-3 text-zinc-400">
                                </label>
                                <x-admin.input label="New Admin Email" model="newAdminEmail" type="email" />
                                <x-admin.input label="Current Password" model="emailCurrentPassword" type="password" />
                                <button wire:loading.attr="disabled" wire:target="changeAdminEmail" class="w-full rounded-md bg-teal-400 px-5 py-3 font-semibold text-zinc-950 disabled:cursor-not-allowed disabled:opacity-60">
                                    <span wire:loading.remove wire:target="changeAdminEmail">Change Email</span>
                                    <span wire:loading wire:target="changeAdminEmail">Changing...</span>
                                </button>
                            </form>
                        </div>

                        <div>
                            <h2 class="text-2xl font-semibold">Change Admin Password</h2>
                            <p class="mt-2 text-sm text-zinc-400">Use at least 8 characters. You will use the new password the next time you log in.</p>

                            <form wire:submit="changePassword" class="mt-6 space-y-4">
                                <x-admin.input label="Current Password" model="currentPassword" type="password" />
                                <x-admin.input label="New Password" model="newPassword" type="password" />
                                <x-admin.input label="Confirm New Password" model="newPasswordConfirmation" type="password" />
                                <button wire:loading.attr="disabled" wire:target="changePassword" class="w-full rounded-md bg-teal-400 px-5 py-3 font-semibold text-zinc-950 disabled:cursor-not-allowed disabled:opacity-60">
                                    <span wire:loading.remove wire:target="changePassword">Change Password</span>
                                    <span wire:loading wire:target="changePassword">Changing...</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </section>
        </div>
    </main>
</div>
