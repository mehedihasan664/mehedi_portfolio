<div class="portfolio-page bg-[linear-gradient(180deg,#09090b_0%,#111827_42%,#09090b_100%)]">
    <header class="sticky top-0 z-30 border-b border-white/10 bg-zinc-950/80 shadow-[0_12px_40px_rgba(0,0,0,.28)] backdrop-blur-xl">
        <nav class="relative mx-auto flex max-w-[88rem] items-center justify-between px-5 py-4">
            <a href="#top" class="group leading-tight">
                <span class="block text-lg font-bold text-white">{{ $profile->name ?: 'Mehedi Hasan' }}</span>
                <span class="mt-1 block text-[0.68rem] font-bold uppercase tracking-[0.18em] text-teal-300 transition group-hover:text-teal-200">{{ $profile->professional_roles_list[0] }}</span>
            </a>
            <div class="hidden items-center gap-6 text-sm font-semibold text-zinc-300 md:flex">
                <a href="#skills" class="hover:text-teal-300">{{ $content['nav_skills'] }}</a>
                <a href="#projects" class="hover:text-teal-300">{{ $content['nav_projects'] }}</a>
                <a href="#education" class="hover:text-teal-300">{{ $content['nav_education'] }}</a>
                <a href="#experience" class="hover:text-teal-300">{{ $content['nav_experience'] }}</a>
                <a href="#contact" class="text-teal-300 hover:text-teal-200">{{ $content['nav_contact'] }}</a>
            </div>
            <button type="button" data-mobile-menu-toggle aria-expanded="false" aria-controls="mobile-navigation" aria-label="Open navigation menu" class="inline-flex h-10 w-10 items-center justify-center rounded-md border border-teal-300/40 text-teal-200 md:hidden">
                <svg data-menu-icon="open" aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5">
                    <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" />
                </svg>
                <svg data-menu-icon="close" aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="hidden h-5 w-5">
                    <path stroke-linecap="round" d="m6 6 12 12M18 6 6 18" />
                </svg>
            </button>
            <div id="mobile-navigation" data-mobile-menu class="absolute left-5 right-5 top-full hidden rounded-lg border border-white/10 bg-zinc-950/95 p-3 shadow-2xl backdrop-blur-xl md:hidden">
                <div class="grid gap-1 text-sm font-semibold text-zinc-200">
                    <a href="#skills" class="rounded-md px-4 py-3 hover:bg-white/10 hover:text-teal-200">{{ $content['nav_skills'] }}</a>
                    <a href="#experience" class="rounded-md px-4 py-3 hover:bg-white/10 hover:text-teal-200">{{ $content['nav_experience'] }}</a>
                    <a href="#projects" class="rounded-md px-4 py-3 hover:bg-white/10 hover:text-teal-200">{{ $content['nav_projects'] }}</a>
                    <a href="#education" class="rounded-md px-4 py-3 hover:bg-white/10 hover:text-teal-200">{{ $content['nav_education'] }}</a>
                    <a href="#contact" class="rounded-md bg-teal-300/10 px-4 py-3 text-teal-200">{{ $content['nav_contact'] }}</a>
                </div>
            </div>
        </nav>
    </header>

    <main id="top">
        <section class="mx-auto grid min-h-[88vh] max-w-[88rem] content-center items-start gap-12 px-5 py-16 md:grid-cols-[1.08fr_0.92fr]">
            <div>
                <p class="hero-welcome text-2xl font-black uppercase tracking-[0.2em] text-teal-300 md:text-3xl">{{ $content['welcome_text'] }}</p>
                <div class="mt-5 inline-flex items-center gap-2 rounded-full border border-teal-300/25 bg-teal-300/10 px-4 py-2 text-sm font-semibold text-teal-100 shadow-[0_12px_34px_rgba(20,184,166,.12)]">
                    <span class="h-2 w-2 rounded-full bg-teal-300"></span>
                    {{ $profile->location ?: 'Dhaka, Bangladesh' }}
                </div>
                @php($heroName = $profile->name ?: 'Mehedi Hasan')
                <h1 class="hero-name mt-6 text-6xl font-black leading-none text-white md:text-8xl xl:text-9xl" aria-label="{{ $heroName }}" data-animated-name>
                    <span aria-hidden="true">
                        @php($letterIndex = 0)
                        @foreach (preg_split('/\s+/', trim($heroName)) as $word)
                            <span class="hero-name-word block whitespace-nowrap">
                                @foreach (mb_str_split($word) as $letter)
                                    <span class="hero-name-letter" style="--letter-index: {{ $letterIndex }}">{{ $letter }}</span>
                                    @php($letterIndex++)
                                @endforeach
                            </span>
                        @endforeach
                    </span>
                </h1>
                <p class="mt-6 flex flex-wrap items-center gap-x-3 gap-y-1 text-2xl font-semibold text-teal-200 md:text-3xl">
                    @foreach ($profile->professional_roles_list as $role)
                        @if (! $loop->first)<span class="text-zinc-500">|</span>@endif
                        <span>{{ $role }}</span>
                    @endforeach
                </p>
                <p class="mt-5 max-w-2xl text-lg leading-8 text-zinc-300 md:text-xl">{{ $profile->tagline }}</p>
                <div class="mt-9 flex flex-wrap gap-3">
                    <a href="#contact" class="rounded-md bg-teal-300 px-6 py-3 font-bold text-zinc-950 shadow-[0_18px_45px_rgba(45,212,191,.22)] hover:bg-teal-200">{{ $content['hire_button'] }}</a>
                    <a href="#projects" class="rounded-md border border-white/15 bg-white/[0.04] px-6 py-3 font-bold text-zinc-100 hover:border-sky-300 hover:text-sky-200">{{ $content['projects_button'] }}</a>
                    @if ($profile->resume_url)
                        <a href="{{ $profile->resume_url }}" target="_blank" class="rounded-md border border-amber-300/30 px-6 py-3 font-bold text-amber-100 hover:border-amber-200">{{ $content['resume_button'] }}</a>
                    @endif
                </div>
                <div class="mt-9 flex flex-wrap gap-3">
                    @foreach ($socialLinks->reject(fn ($link) => strcasecmp($link->label, 'Email') === 0) as $link)
                        <a href="{{ $link->url }}" target="_blank" class="rounded-full border border-teal-300/60 px-4 py-2 text-sm font-semibold text-white transition hover:border-teal-200 hover:bg-teal-300/15 {{ strcasecmp($link->label, 'GitHub') === 0 ? 'social-github' : '' }}">{{ $link->label }}</a>
                    @endforeach
                    @if ($profile->whatsapp_url)
                        <a href="{{ $profile->whatsapp_url }}" target="_blank" rel="noopener" class="rounded-full border border-teal-300/60 px-4 py-2 text-sm font-semibold text-white transition hover:border-teal-200 hover:bg-teal-300/10">{{ $content['whatsapp_button'] }}</a>
                    @endif
                    @if ($profile->email)
                        <a href="mailto:{{ $profile->email }}?subject={{ rawurlencode($content['email_me_subject']) }}" class="rounded-full border border-teal-300/60 px-4 py-2 text-sm font-semibold text-white transition hover:border-teal-200 hover:bg-teal-300/10">{{ $content['social_email_label'] }}</a>
                    @endif
                </div>
            </div>

            <div class="w-full max-w-lg justify-self-center overflow-hidden rounded-lg bg-white/[0.06] shadow-2xl shadow-black/30 md:justify-self-end">
                <div class="relative bg-zinc-900">
                    @if ($profile->profile_photo_url)
                        <img src="{{ $profile->profile_photo_url }}" alt="{{ $profile->name ?: 'Mehedi Hasan' }}" class="aspect-[4/3] w-full object-cover object-[center_22%]">
                    @else
                        <div class="flex aspect-[4/3] w-full items-center justify-center bg-[linear-gradient(135deg,#0f172a,#134e4a,#18181b)] text-3xl font-black text-zinc-200">
                            {{ collect(explode(' ', $profile->name ?: 'Mehedi Hasan'))->map(fn ($part) => mb_substr($part, 0, 1))->take(2)->join('') }}
                        </div>
                    @endif
                    <div class="absolute bottom-4 left-4 rounded-md border border-white/10 bg-zinc-950/75 px-4 py-3 backdrop-blur">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-teal-200">{{ $content['availability_label'] }}</p>
                        <p class="mt-1 text-sm font-semibold text-white">{{ $content['availability_text'] }}</p>
                    </div>
                </div>
                <div class="p-6">
                <div class="flex items-center justify-between gap-4 border-b border-white/10 pb-5">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-teal-200">{{ $content['card_label'] }}</p>
                        <p class="mt-2 flex flex-wrap items-center gap-x-2 gap-y-1 text-xl font-bold leading-snug text-white md:text-2xl">
                            @foreach ($profile->portfolio_card_roles_list as $role)
                                @if (! $loop->first)<span class="text-teal-300">|</span>@endif
                                <span>{{ $role }}</span>
                            @endforeach
                        </p>
                    </div>
                    <span class="rounded-full bg-emerald-400/15 px-3 py-1 text-sm font-semibold text-emerald-200">{{ $content['card_status'] }}</span>
                </div>
                <p class="mt-6 leading-8 text-zinc-300">{{ $profile->bio }}</p>
                <div class="mt-6 grid grid-cols-2 gap-3 text-center sm:grid-cols-4">
                    <div class="rounded-md border border-white/10 bg-zinc-950/70 p-4">
                        <p class="text-2xl font-black text-white">{{ $content['experience_stat_value'] }}</p>
                        <p class="mt-1 text-xs text-zinc-500">{{ $content['experience_stat_label'] }}</p>
                    </div>
                    <div class="rounded-md border border-white/10 bg-zinc-950/70 p-4">
                        <p class="text-2xl font-black text-white">{{ $projects->count() }}+</p>
                        <p class="mt-1 text-xs text-zinc-500">{{ $content['projects_stat_label'] }}</p>
                    </div>
                    <div class="rounded-md border border-white/10 bg-zinc-950/70 p-4">
                        <p class="text-2xl font-black text-white">{{ $skills->count() }}+</p>
                        <p class="mt-1 text-xs text-zinc-500">{{ $content['skills_stat_label'] }}</p>
                    </div>
                    <div class="rounded-md border border-white/10 bg-zinc-950/70 p-4">
                        <p class="text-2xl font-black text-white">{{ $content['focus_stat_value'] }}</p>
                        <p class="mt-1 text-xs text-zinc-500">{{ $content['focus_stat_label'] }}</p>
                    </div>
                </div>
                <div class="mt-6 rounded-md border border-sky-300/15 bg-sky-300/10 p-4">
                    <p class="text-sm font-semibold text-sky-100">{{ $content['core_stack_label'] }}</p>
                    <p class="mt-2 leading-7 text-zinc-300">{{ $content['core_stack_text'] }}</p>
                </div>
                </div>
            </div>
        </section>

        <section id="skills" class="scroll-mt-20 border-y border-white/10 bg-white/[0.04] py-16">
            <div class="mx-auto max-w-[88rem] px-5">
                <p class="text-sm font-semibold uppercase tracking-[0.22em] text-teal-300">{{ $content['skills_eyebrow'] }}</p>
                <h2 class="mt-3 text-4xl font-bold">{{ $content['skills_heading'] }}</h2>
                <div class="mt-8 grid gap-4 md:grid-cols-2">
                    @foreach ($skills as $skill)
                        <div class="rounded-lg border border-white/10 bg-zinc-950/90 p-5 shadow-xl shadow-black/10">
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-lg font-semibold">{{ $skill->name }}</span>
                                <span class="text-sm font-semibold text-teal-200">{{ $skill->level }}%</span>
                            </div>
                            <div class="mt-4 h-2.5 rounded-full bg-white/10">
                                <div class="h-2.5 rounded-full bg-[linear-gradient(90deg,#2dd4bf,#38bdf8)]" style="width: {{ $skill->level }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="experience" class="mx-auto max-w-[88rem] scroll-mt-20 px-5 py-16">
            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-teal-300">{{ $content['experience_eyebrow'] }}</p>
            <h2 class="mt-3 text-4xl font-bold">{{ $content['experience_heading'] }}</h2>
            <div class="mt-8 space-y-4">
                @foreach ($experiences as $experience)
                    <article class="rounded-lg border border-white/10 bg-white/[0.05] p-6">
                        <p class="text-sm text-teal-300">{{ $experience->period }}</p>
                        <h3 class="mt-2 text-xl font-bold">{{ $experience->role }} &middot; {{ $experience->company }}</h3>
                        <p class="mt-3 leading-7 text-zinc-400">{{ $experience->description }}</p>
                    </article>
                @endforeach
            </div>
        </section>

        <section id="projects" class="scroll-mt-20 border-y border-white/10 bg-white/[0.04] py-16">
            <div class="mx-auto max-w-[88rem] px-5">
                <p class="text-sm font-semibold uppercase tracking-[0.22em] text-sky-200">{{ $content['projects_eyebrow'] }}</p>
                <h2 class="mt-3 text-4xl font-bold">{{ $content['projects_heading'] }}</h2>
                <div class="mt-8 grid gap-6 md:grid-cols-2">
                    @foreach ($projects as $project)
                        <article class="overflow-hidden rounded-lg border border-white/10 bg-zinc-950 shadow-2xl shadow-black/20">
                            <div class="aspect-video bg-zinc-900">
                                @if ($project->image_url)
                                    <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full items-center justify-center bg-[linear-gradient(135deg,#0f172a,#134e4a,#18181b)] text-lg font-bold text-zinc-200">{{ $project->title }}</div>
                                @endif
                            </div>
                            <div class="p-6">
                                <div class="flex items-start justify-between gap-4">
                                    <h3 class="text-xl font-bold">{{ $project->title }}</h3>
                                    @if ($project->is_featured)
                                        <span class="rounded-full bg-teal-400/15 px-3 py-1 text-xs font-semibold text-teal-200">{{ $content['featured_label'] }}</span>
                                    @endif
                                </div>
                                <p class="mt-3 leading-7 text-zinc-400">{{ $project->description }}</p>
                                <p class="mt-4 text-sm font-semibold text-zinc-500">{{ $project->tech_stack }}</p>
                                <div class="mt-5 flex gap-3 text-sm font-semibold">
                                    @if ($project->demo_url)<a target="_blank" href="{{ $project->demo_url }}" class="text-teal-300">{{ $content['demo_label'] }}</a>@endif
                                    @if ($project->github_url)<a target="_blank" href="{{ $project->github_url }}" class="text-zinc-300">{{ $content['github_label'] }}</a>@endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-[88rem] px-5 py-16">
            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-amber-200">{{ $content['services_eyebrow'] }}</p>
            <h2 class="mt-3 text-4xl font-bold">{{ $content['services_heading'] }}</h2>
            <div class="mt-8 grid gap-5 md:grid-cols-3">
                @foreach ($services as $service)
                    <article class="rounded-lg border border-white/10 bg-white/[0.05] p-6 shadow-xl shadow-black/10">
                        <p class="inline-flex rounded-md bg-teal-300/10 px-3 py-2 text-sm font-bold text-teal-200">{{ $service->icon ?: '{}' }}</p>
                        <h3 class="mt-5 text-xl font-bold">{{ $service->title }}</h3>
                        <p class="mt-3 leading-7 text-zinc-400">{{ $service->description }}</p>
                    </article>
                @endforeach
            </div>
        </section>

        <section id="education" class="scroll-mt-20 border-y border-white/10 bg-white/[0.04] py-16">
            <div class="mx-auto max-w-[88rem] px-5">
                <p class="text-sm font-semibold uppercase tracking-[0.22em] text-sky-200">{{ $content['education_eyebrow'] }}</p>
                <h2 class="mt-3 text-4xl font-bold">{{ $content['education_heading'] }}</h2>
                <div class="mt-8 grid gap-4 md:grid-cols-3">
                    @foreach ($educations as $education)
                        <article class="rounded-lg border border-white/10 bg-white/[0.05] p-6">
                            <p class="text-sm font-semibold text-teal-300">{{ $education->level }}</p>
                            <h3 class="mt-2 text-xl font-bold">{{ $education->institution }}</h3>
                            @if ($education->degree)
                                <p class="mt-2 text-zinc-300">{{ $education->degree }}</p>
                            @endif
                            <div class="mt-4 flex flex-wrap gap-2 text-sm">
                                @if ($education->period)
                                    <span class="rounded-full border border-white/10 px-3 py-1 text-zinc-400">{{ $education->period }}</span>
                                @endif
                                @if ($education->result)
                                    <span class="rounded-full border border-teal-300/20 bg-teal-300/10 px-3 py-1 text-teal-100">{{ $education->result }}</span>
                                @endif
                            </div>
                            @if ($education->description)
                                <ul class="mt-4 space-y-2 text-sm leading-6 text-zinc-400">
                                    @foreach (preg_split('/\r\n|\r|\n/', $education->description) as $line)
                                        @if (trim($line) !== '')
                                            <li class="flex gap-2"><span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-teal-300"></span><span>{{ trim($line, " \t\n\r\0\x0B-*") }}</span></li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="contact" class="scroll-mt-20 border-t border-white/10 bg-white/[0.04] py-16">
            <div class="mx-auto grid max-w-[88rem] gap-8 px-5 md:grid-cols-[0.8fr_1.2fr]">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-amber-200">{{ $content['contact_eyebrow'] }}</p>
                    <h2 class="mt-3 text-4xl font-bold">{{ $content['contact_heading'] }}</h2>
                    <p class="mt-4 leading-7 text-zinc-400">{{ $content['contact_description'] }}</p>
                    <div class="mt-6 space-y-2 text-zinc-300">
                        @if ($profile->email)
                            <p>
                                <a href="mailto:{{ $profile->email }}?subject={{ rawurlencode($content['email_me_subject']) }}" aria-label="Email {{ $profile->email }}" class="inline-flex items-center gap-2 hover:text-teal-200">
                                    <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5 text-teal-300">
                                        <rect x="2.5" y="4.5" width="19" height="15" rx="2" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m3.5 6 7.25 5.45a2.08 2.08 0 0 0 2.5 0L20.5 6" />
                                    </svg>
                                    <span>{{ $profile->email }}</span>
                                </a>
                            </p>
                        @endif
                        @if ($profile->phone)
                            <p>
                                <a href="tel:{{ preg_replace('/[^\d+]/', '', $profile->phone) }}" aria-label="Call {{ $profile->phone }}" class="inline-flex items-center gap-2 hover:text-teal-200">
                                    <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5 text-teal-300">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 16.42v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 1.12 3.7 2 2 0 0 1 3.11 1.5h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.68 2.8a2 2 0 0 1-.45 2.11L7.07 9.4a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.32 1.84.55 2.8.68A2 2 0 0 1 21 16.42Z" />
                                    </svg>
                                    <span>{{ $profile->phone }}</span>
                                </a>
                            </p>
                        @endif
                        @if ($profile->whatsapp_url)
                            <p>
                                <a href="{{ $profile->whatsapp_url }}" target="_blank" rel="noopener" aria-label="Open WhatsApp chat with {{ $profile->effective_whatsapp_number }}" class="inline-flex items-center gap-2 text-emerald-300 hover:text-emerald-200">
                                    <svg aria-hidden="true" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                                        <path d="M12.004 0h-.006C5.383 0 0 5.383 0 12c0 2.625.846 5.058 2.284 7.034L.789 23.485l4.601-1.474A11.892 11.892 0 0 0 12.004 24C18.617 24 24 18.615 24 12S18.617 0 12.004 0Zm6.985 16.956c-.293.825-1.453 1.509-2.378 1.709-.633.135-1.459.243-4.242-.911-3.56-1.475-5.853-5.095-6.032-5.33-.171-.235-1.439-1.917-1.439-3.655 0-1.738.883-2.584 1.239-2.948.293-.299.776-.435 1.239-.435.15 0 .285.007.406.014.356.015.534.036.769.598.293.705 1.004 2.45 1.09 2.628.086.178.172.42.05.655-.114.242-.214.349-.392.555-.178.207-.349.363-.527.585-.164.192-.349.399-.143.755.207.349.918 1.509 1.966 2.443 1.353 1.204 2.449 1.588 2.841 1.752.292.121.641.093.854-.135.271-.292.605-.776.947-1.253.242-.342.548-.385.868-.264.328.114 2.065.975 2.421 1.153.356.178.591.264.676.413.086.15.086.861-.207 1.631Z" />
                                    </svg>
                                    <span>{{ $profile->effective_whatsapp_number }}</span>
                                </a>
                            </p>
                        @endif
                    </div>
                    <div class="mt-6 flex flex-wrap gap-3">
                        @if ($profile->email)
                            <a href="mailto:{{ $profile->email }}?subject={{ rawurlencode($content['email_me_subject']) }}" class="inline-flex rounded-md border border-teal-300/30 bg-teal-300/10 px-5 py-3 font-bold text-teal-100 transition hover:border-teal-200 hover:bg-teal-300 hover:text-zinc-950">
                                {{ $content['email_me_button'] }}
                            </a>
                        @endif
                    </div>
                </div>
                <form wire:submit="sendMessage" class="rounded-lg border border-white/10 bg-zinc-950 p-6 shadow-2xl shadow-black/20">
                    @if (session('contact_status'))
                        <div class="mb-4 rounded-md bg-teal-400/10 p-3 text-sm text-teal-200">{{ session('contact_status') }}</div>
                    @endif
                    <div class="grid gap-4 md:grid-cols-2">
                        <input wire:model="name" placeholder="{{ $content['contact_name_placeholder'] }}" class="rounded-md border border-white/10 bg-zinc-900 px-4 py-3 outline-none focus:ring-2 focus:ring-teal-400">
                        <input wire:model="email" placeholder="{{ $content['contact_email_placeholder'] }}" class="rounded-md border border-white/10 bg-zinc-900 px-4 py-3 outline-none focus:ring-2 focus:ring-teal-400">
                    </div>
                    <input wire:model="subject" placeholder="{{ $content['contact_subject_placeholder'] }}" class="mt-4 w-full rounded-md border border-white/10 bg-zinc-900 px-4 py-3 outline-none focus:ring-2 focus:ring-teal-400">
                    <textarea wire:model="message" rows="5" placeholder="{{ $content['contact_message_placeholder'] }}" class="mt-4 w-full rounded-md border border-white/10 bg-zinc-900 px-4 py-3 outline-none focus:ring-2 focus:ring-teal-400"></textarea>
                    @error('*') <p class="mt-3 text-sm text-red-300">{{ $message }}</p> @enderror
                    <button wire:loading.attr="disabled" wire:target="sendMessage" class="mt-4 rounded-md bg-teal-300 px-6 py-3 font-bold text-zinc-950 hover:bg-teal-200 disabled:cursor-not-allowed disabled:opacity-60">
                        <span wire:loading.remove wire:target="sendMessage">{{ $content['contact_button'] }}</span>
                        <span wire:loading wire:target="sendMessage">{{ $content['contact_sending'] }}</span>
                    </button>
                </form>
            </div>
        </section>
    </main>

    <footer class="border-t border-white/10 bg-zinc-950/70">
        <div class="mx-auto flex max-w-[88rem] flex-col gap-4 px-5 py-8 text-sm text-zinc-400 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="font-bold text-white">{{ $profile->name ?: 'Mehedi Hasan' }}</p>
                <p class="mt-1">{{ $content['footer_text'] }}</p>
            </div>
            <p>&copy; {{ now()->year }} {{ $profile->name ?: 'Mehedi Hasan' }}. All rights reserved.</p>
        </div>
    </footer>
</div>
