<?php

namespace Tests\Feature;

use App\Filament\Widgets\LatestMessages;
use App\Filament\Widgets\MessagesChart;
use App\Filament\Widgets\PortfolioStats;
use App\Filament\Widgets\ProjectsByCategoryChart;
use App\Mail\NewContactMessage;
use App\Models\Message;
use App\Models\Profile;
use App\Models\Project;
use App\Models\User;
use Database\Seeders\PortfolioSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Filament\Auth\Pages\EditProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        $this->seed(PortfolioSeeder::class);
    }

    public function test_public_pages_render(): void
    {
        $this->get('/')->assertOk()->assertSee('Mohamed Khater')->assertSee('Gap Cloud');
        $this->get('/archive')->assertOk()->assertSee('TrioAPI');
        $this->get('/projects/multi-tenant-erp-system')->assertOk()->assertSee('Key highlights');
    }

    public function test_years_plus_sign_follows_the_checkbox(): void
    {
        Profile::query()->update(['years_experience' => 7, 'years_experience_plus' => true]);
        $this->get('/')->assertSee('7+ years building');

        Profile::query()->update(['years_experience_plus' => false]);
        $this->get('/')->assertSee('7 years building')->assertDontSee('7+ years building');
    }

    public function test_hidden_project_returns_404(): void
    {
        Project::query()->where('slug', 'bawarq')->update(['is_visible' => false]);

        $this->get('/projects/bawarq')->assertNotFound();
    }

    public function test_contact_form_stores_message(): void
    {
        $this->post('/contact', [
            'name' => 'Recruiter',
            'email' => 'recruiter@example.com',
            'subject' => 'Role',
            'body' => 'Hello there',
        ])->assertRedirect()->assertSessionHas('contact_sent');

        $this->assertDatabaseHas('messages', ['email' => 'recruiter@example.com']);
    }

    public function test_contact_form_rejects_honeypot(): void
    {
        $this->post('/contact', [
            'name' => 'Bot',
            'email' => 'bot@example.com',
            'body' => 'spam',
            'website' => 'http://spam.test',
        ])->assertSessionHasErrors('website');

        $this->assertSame(0, Message::query()->count());
    }

    public function test_admin_pages_render(): void
    {
        Message::create(['name' => 'A', 'email' => 'a@example.com', 'body' => 'Hi']);
        $this->actingAs(User::factory()->create());

        foreach (['/admin', '/admin/profiles', '/admin/experiences', '/admin/projects', '/admin/skill-groups', '/admin/education', '/admin/messages'] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_dashboard_widgets_render(): void
    {
        $this->actingAs(User::factory()->create());

        foreach ([PortfolioStats::class, MessagesChart::class, ProjectsByCategoryChart::class, LatestMessages::class] as $widget) {
            Livewire::test($widget)->assertOk();
        }

        Message::create(['name' => 'A', 'email' => 'a@example.com', 'body' => 'Hi']);

        $this->assertSame(1, array_sum(Message::weeklyCounts()));
        Livewire::test(LatestMessages::class)->assertCanSeeTableRecords(Message::all());
    }

    public function test_admin_can_change_email_and_password(): void
    {
        $user = User::factory()->create(['email' => 'old@example.com', 'password' => 'old-password']);
        $this->actingAs($user);

        $this->get('/admin/profile')->assertOk();

        Livewire::test(EditProfile::class)
            ->fillForm([
                'email' => 'new@example.com',
                'password' => 'New-strong-pass-123',
                'passwordConfirmation' => 'New-strong-pass-123',
                'currentPassword' => 'old-password',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $user->refresh();
        $this->assertSame('new@example.com', $user->email);
        $this->assertTrue(Hash::check('New-strong-pass-123', $user->password));
    }

    public function test_changing_password_requires_current_password(): void
    {
        $user = User::factory()->create(['password' => 'old-password']);
        $this->actingAs($user);

        Livewire::test(EditProfile::class)
            ->fillForm([
                'password' => 'New-strong-pass-123',
                'passwordConfirmation' => 'New-strong-pass-123',
                'currentPassword' => 'wrong-password',
            ])
            ->call('save')
            ->assertHasFormErrors(['currentPassword']);

        $this->assertTrue(Hash::check('old-password', $user->refresh()->password));
    }

    public function test_contact_form_emails_the_owner(): void
    {
        Mail::fake();
        config(['mail.contact_to' => 'owner@example.com']);
        $this->withoutDefer();

        $this->post('/contact', [
            'name' => 'Recruiter',
            'email' => 'recruiter@example.com',
            'body' => 'Hello there',
        ])->assertRedirect();

        Mail::assertSent(NewContactMessage::class, fn (NewContactMessage $mail) => $mail->hasTo('owner@example.com')
            && $mail->hasReplyTo('recruiter@example.com'));
    }
}
