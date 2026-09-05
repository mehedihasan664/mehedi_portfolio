<?php

namespace Database\Seeders;

use App\Models\Experience;
use App\Models\Education;
use App\Models\PortfolioProfile;
use App\Models\Project;
use App\Models\Service;
use App\Models\SiteContent;
use App\Models\Skill;
use App\Models\SocialLink;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        SiteContent::query()->updateOrCreate(['id' => 1], ['content' => SiteContent::defaults()]);

        User::factory()->create([
            'name' => 'Mehedi Hasan',
            'email' => 'mehedi@example.com',
        ]);

        PortfolioProfile::query()->updateOrCreate([], [
            'name' => 'Mehedi Hasan',
            'title' => 'PHP & Laravel Developer',
            'professional_roles' => "Software Engineer\nWeb Developer\nPHP & Laravel Developer",
            'portfolio_card_roles' => "Full Stack Developer\nPHP & Laravel Developer",
            'tagline' => 'I create clean, responsive, database-driven web applications with Laravel, Livewire, and Tailwind CSS.',
            'bio' => 'Adaptable Software Engineer experienced in PHP and Laravel, with a strong interest in MERN Stack and the flexibility to work with technologies based on company requirements.',
            'email' => 'hello@example.com',
            'phone' => '+880 1XXXXXXXXX',
            'whatsapp_number' => '+880 1XXXXXXXXX',
            'location' => 'Dhaka, Bangladesh',
            'resume_url' => null,
        ]);

        collect([
            ['PHP', 90], ['Laravel', 88], ['Tailwind CSS', 86], ['JavaScript', 80],
            ['SQL', 84], ['MySQL', 84], ['Git', 82], ['GitHub', 82],
        ])->each(fn ($skill, $index) => Skill::query()->updateOrCreate(
            ['name' => $skill[0]],
            ['level' => $skill[1], 'category' => 'Development', 'sort_order' => $index, 'is_visible' => true],
        ));

        collect([
            ['Laravel Web Apps', 'Custom Laravel applications with clean architecture, database design, authentication, dashboards, and deployment-ready structure.', 'Laravel'],
            ['Livewire Admin Panels', 'Interactive admin panels to manage content, projects, messages, and business data without heavy frontend complexity.', 'Livewire'],
            ['Responsive UI', 'Fast, mobile-friendly interfaces built with Tailwind CSS and practical UX patterns for real users.', 'UI'],
        ])->each(fn ($service, $index) => Service::query()->updateOrCreate(
            ['title' => $service[0]],
            ['description' => $service[1], 'icon' => $service[2], 'sort_order' => $index, 'is_visible' => true],
        ));

        Project::query()->updateOrCreate(['title' => 'Personal Portfolio CMS'], [
            'description' => 'A Laravel, Livewire, and Tailwind CSS portfolio website with an admin panel to control profile, skills, projects, services, links, and messages.',
            'tech_stack' => 'Laravel, Livewire, Tailwind CSS, SQLite/MySQL',
            'image_url' => null,
            'demo_url' => null,
            'github_url' => null,
            'is_featured' => true,
            'is_visible' => true,
            'sort_order' => 0,
        ]);

        Experience::query()->updateOrCreate(['role' => 'Laravel Developer', 'company' => 'Freelance'], [
            'period' => '2025 - Present',
            'description' => 'Building portfolio websites, dashboards, content management features, and custom Laravel applications for clients.',
            'sort_order' => 0,
            'is_visible' => true,
        ]);

        collect([
            [
                'Bachelor of Science (B.Sc.) in Computer Science and Engineering (CSE)',
                'American International University-Bangladesh (AIUB)',
                'B.Sc. in CSE',
                '2021 - 2025',
                null,
                "Studied core Computer Science subjects including Software Engineering, Database Systems, Data Structures & Algorithms, Web Development, and Networking.\nCompleted academic projects using PHP, Laravel, MySQL, HTML, CSS, JavaScript, and Tailwind CSS.",
            ],
            [
                'Higher Secondary Certificate (HSC)',
                'Notre Dame College, Mymensingh',
                'Science',
                'Graduated: 2019',
                null,
                'Completed Higher Secondary education with a focus on Science.',
            ],
            [
                'Secondary School Certificate (SSC)',
                'Nabarun Public School',
                'Science',
                'Graduated: 2017',
                null,
                'Successfully completed Secondary School education with a Science background.',
            ],
        ])->each(fn ($education, $index) => Education::query()->updateOrCreate(
            ['level' => $education[0]],
            [
                'institution' => $education[1],
                'degree' => $education[2],
                'period' => $education[3],
                'result' => $education[4],
                'description' => $education[5],
                'sort_order' => $index,
                'is_visible' => true,
            ],
        ));

        collect([
            ['GitHub', 'https://github.com/'],
            ['LinkedIn', 'https://www.linkedin.com/'],
            ['Email', 'mailto:hello@example.com'],
        ])->each(fn ($link, $index) => SocialLink::query()->updateOrCreate(
            ['label' => $link[0]],
            ['url' => $link[1], 'sort_order' => $index, 'is_visible' => true],
        ));
    }
}
