<?php

namespace Tests\Feature;

use App\Mail\ContactMessageReceived;
use App\Livewire\Admin\Dashboard;
use App\Models\AdminCredential;
use App\Models\Education;
use App\Models\PortfolioProfile;
use App\Models\SiteContent;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_renders_portfolio_sections(): void
    {
        PortfolioProfile::query()->create([
            'name' => 'Mehedi Hasan',
            'title' => 'Laravel Developer',
            'professional_roles' => "Software Engineer\nPHP & Laravel Developer",
            'email' => 'hello@example.com',
            'tagline' => 'Premium Laravel portfolio',
            'whatsapp_number' => '+880 1712 345678',
        ]);

        Education::query()->create([
            'level' => 'University',
            'institution' => 'Your University Name',
            'degree' => 'BSc in Computer Science',
            'is_visible' => true,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Mehedi Hasan')
            ->assertSee('Software Engineer')
            ->assertSee('PHP &amp; Laravel Developer', false)
            ->assertSee('mailto:hello@example.com?subject=Portfolio%20project%20inquiry', false)
            ->assertSee('Welcome to My Portfolio')
            ->assertSee('data-animated-name', false)
            ->assertSee('data-mobile-menu-toggle', false)
            ->assertSee('All rights reserved.')
            ->assertSee('id="experience"', false)
            ->assertSee('Education')
            ->assertSee('WhatsApp');
    }

    public function test_profile_phone_is_used_when_whatsapp_number_is_empty(): void
    {
        $profile = new PortfolioProfile(['phone' => '+880 1607 089531']);

        $this->assertSame('+880 1607 089531', $profile->effective_whatsapp_number);
        $this->assertSame('https://wa.me/8801607089531', $profile->whatsapp_url);
    }

    public function test_contact_message_is_saved_and_emailed_to_admin(): void
    {
        Mail::fake();
        config(['portfolio.admin_email' => 'admin@example.com']);

        Livewire::test(\App\Livewire\PortfolioHome::class)
            ->set('name', 'Rahim Client')
            ->set('email', 'rahim@example.com')
            ->set('subject', 'Laravel project')
            ->set('message', 'I need a portfolio website.')
            ->call('sendMessage')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'rahim@example.com',
            'message' => 'I need a portfolio website.',
        ]);

        Mail::assertSent(ContactMessageReceived::class, function (ContactMessageReceived $mail): bool {
            return $mail->hasTo('admin@example.com')
                && $mail->hasReplyTo('rahim@example.com');
        });
    }

    public function test_admin_dashboard_requires_login(): void
    {
        $this->get('/admin')
            ->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_login_with_configured_password(): void
    {
        config([
            'portfolio.admin_email' => 'admin@example.com',
            'portfolio.admin_password' => 'secret-password',
        ]);

        $this->post('/admin/login', [
            'email' => 'admin@example.com',
            'password' => 'secret-password',
        ])
            ->assertRedirect(route('admin.dashboard'));

        $this->assertTrue(session('portfolio_admin'));
    }

    public function test_admin_can_request_and_use_password_reset(): void
    {
        Mail::fake();
        config(['portfolio.admin_email' => 'admin@example.com']);

        $this->post(route('admin.password.email'), ['email' => 'admin@example.com'])
            ->assertSessionHas('status');

        $this->assertDatabaseHas('password_reset_tokens', ['email' => 'admin@example.com']);

        $token = 'valid-reset-token';
        DB::table('password_reset_tokens')->where('email', 'admin@example.com')->update([
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        $this->post(route('admin.password.update'), [
            'email' => 'admin@example.com',
            'token' => $token,
            'password' => 'reset-password',
            'password_confirmation' => 'reset-password',
        ])->assertRedirect(route('admin.login'));

        $this->assertTrue(AdminCredential::credentialsMatch('admin@example.com', 'reset-password'));
        $this->assertDatabaseMissing('password_reset_tokens', ['email' => 'admin@example.com']);
    }

    public function test_admin_can_change_password_from_dashboard(): void
    {
        config(['portfolio.admin_password' => 'old-password']);

        $this->withSession(['portfolio_admin' => true]);

        Livewire::test(Dashboard::class)
            ->set('currentPassword', 'old-password')
            ->set('newPassword', 'new-password')
            ->set('newPasswordConfirmation', 'new-password')
            ->call('changePassword')
            ->assertHasNoErrors()
            ->assertSet('currentPassword', '')
            ->assertSet('newPassword', '')
            ->assertSet('newPasswordConfirmation', '');

        $this->assertTrue(AdminCredential::passwordMatches('new-password'));
        $this->assertFalse(AdminCredential::passwordMatches('old-password'));
    }

    public function test_admin_can_change_email_from_dashboard(): void
    {
        config([
            'portfolio.admin_email' => 'old@example.com',
            'portfolio.admin_password' => 'admin-password',
        ]);

        Livewire::test(Dashboard::class)
            ->assertSet('adminEmail', 'old@example.com')
            ->set('newAdminEmail', 'new@example.com')
            ->set('emailCurrentPassword', 'admin-password')
            ->call('changeAdminEmail')
            ->assertHasNoErrors()
            ->assertSet('adminEmail', 'new@example.com')
            ->assertSet('newAdminEmail', 'new@example.com')
            ->assertSet('emailCurrentPassword', '');

        $this->assertTrue(AdminCredential::credentialsMatch('new@example.com', 'admin-password'));
        $this->assertFalse(AdminCredential::credentialsMatch('old@example.com', 'admin-password'));
    }

    public function test_admin_can_update_public_site_content(): void
    {
        $content = SiteContent::defaults();
        $content['welcome_text'] = 'Welcome to My Dynamic Website';
        $content['contact_button'] = 'Contact Me Now';

        Livewire::test(Dashboard::class)
            ->set('content', $content)
            ->call('saveSiteContent')
            ->assertHasNoErrors();

        $this->get('/')
            ->assertOk()
            ->assertSee('Welcome to My Dynamic Website')
            ->assertSee('Contact Me Now');
    }

    public function test_admin_can_upload_profile_photo_from_processed_image_data(): void
    {
        Storage::fake('public');

        PortfolioProfile::query()->create([
            'name' => 'Mehedi Hasan',
            'title' => 'Laravel Developer',
            'tagline' => 'Premium Laravel portfolio',
        ]);

        $this->withSession(['portfolio_admin' => true])
            ->post(route('admin.profile-photo.upload'), [
                'profile_photo' => UploadedFile::fake()->image('photo.jpg'),
            ])
            ->assertRedirect(route('admin.dashboard'))
            ->assertSessionHas('admin_status', 'Profile photo uploaded.');

        $profile = PortfolioProfile::query()->first();

        $this->assertNotNull($profile->profile_photo_path);
        $this->assertSame('/storage/'.$profile->profile_photo_path, $profile->profile_photo_url);
        Storage::disk('public')->assertExists($profile->profile_photo_path);
    }
}
