<?php

namespace Tests\Feature;

use App\Filament\Resources\Messages\Pages\ListMessages;
use App\Filament\Resources\Projects\Pages\ListProjects;
use App\Filament\Widgets\LatestMessages;
use App\Filament\Widgets\MessagesChart;
use App\Filament\Widgets\PortfolioStats;
use App\Filament\Widgets\ProjectsByCategoryChart;
use App\Mail\ContactReply;
use App\Mail\NewContactMessage;
use App\Models\Message;
use App\Models\Profile;
use App\Models\Project;
use App\Models\User;
use App\Models\SkillGroup;
use Database\Seeders\AdditionalProjectsSeeder;
use Database\Seeders\EInvoicingSeeder;
use Database\Seeders\PortfolioSeeder;
use Database\Seeders\ProjectImagesSeeder;
use Illuminate\Support\Facades\Storage;
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

    public function test_e_invoicing_seeder_is_additive_and_idempotent(): void
    {
        $profileBefore = Profile::query()->first();
        $groupsBefore = SkillGroup::query()->count();

        $this->seed(EInvoicingSeeder::class);
        $this->seed(EInvoicingSeeder::class);

        $group = SkillGroup::query()->where('name', 'E-Invoicing & Tax Compliance')->sole();
        $this->assertContains('Saudi ZATCA Phase 2 (FATOORA)', $group->items);
        $this->assertContains('B2B Clearance', $group->items);
        $this->assertContains('B2C Reporting', $group->items);
        $this->assertContains('Egypt ETA E-Invoicing', $group->items);
        $this->assertSame($groupsBefore + 1, SkillGroup::query()->count());
        $this->assertNotContains('ETA E-Invoicing', SkillGroup::query()->where('name', 'Fintech & Payments')->value('items'));

        $expertise = Profile::query()->first()->expertise;
        $titles = array_column($expertise, 'title');
        $this->assertSame(1, array_count_values($titles)['E-Invoicing Compliance']);
        $this->assertSame(count($profileBefore->expertise) + 1, count($expertise));
        $this->assertSame('E-Invoicing Compliance', $titles[array_search('Payments & Billing', $titles) + 1]);

        $erp = Project::query()->where('slug', 'multi-tenant-erp-system')->sole();
        $eta = Project::query()->where('slug', 'egypt-eta-e-invoicing')->sole();
        $zatca = Project::query()->where('slug', 'zatca-e-invoicing-integration')->sole();
        $this->assertSame([$erp->sort_order + 1, $erp->sort_order + 2], [$eta->sort_order, $zatca->sort_order]);
        $this->assertSame(Project::query()->count(), Project::query()->distinct()->count('sort_order'));
        $this->get('/projects/egypt-eta-e-invoicing')->assertOk()
            ->assertSee('tax-based discount')
            ->assertSee('USB token')
            ->assertSee('e-Receipts')
            ->assertSee('GS1 / EGS');
        $this->assertContains('ETA e-Receipt', $group->items);

        $this->get('/')->assertOk()->assertSee('Saudi ZATCA Phase 2 (FATOORA)')->assertSee('ZATCA E-Invoicing Integration');
        $this->get('/projects/zatca-e-invoicing-integration')->assertOk()->assertSee('Clearance API')->assertSee('Reporting API');
    }

    public function test_e_invoicing_seeder_keeps_admin_changes_to_the_project(): void
    {
        $this->seed(EInvoicingSeeder::class);
        Project::query()->where('slug', 'zatca-e-invoicing-integration')->update(['is_featured' => true, 'image' => 'projects/zatca.png']);

        $this->seed(EInvoicingSeeder::class);

        $project = Project::query()->where('slug', 'zatca-e-invoicing-integration')->sole();
        $this->assertTrue($project->is_featured);
        $this->assertSame('projects/zatca.png', $project->image);
    }

    public function test_project_images_seeder_fills_only_projects_without_an_image(): void
    {
        Storage::fake('public');
        Project::query()->where('slug', 'maharat')->update(['image' => 'projects/my-own-upload.png']);

        $this->seed(ProjectImagesSeeder::class);

        $this->assertSame('projects/e-shef.jpg', Project::query()->where('slug', 'e-shef')->value('image'));
        Storage::disk('public')->assertExists('projects/e-shef.jpg');
        $this->assertSame('projects/my-own-upload.png', Project::query()->where('slug', 'maharat')->value('image'));
        Storage::disk('public')->assertMissing('projects/maharat.jpg');
        $this->assertNull(Project::query()->where('slug', 'swyyp-platform')->value('image'));
    }

    public function test_additional_projects_seeder_adds_nile_future_once_with_its_image(): void
    {
        Storage::fake('public');

        $this->seed(AdditionalProjectsSeeder::class);
        $this->seed(AdditionalProjectsSeeder::class);
        $this->seed(ProjectImagesSeeder::class);

        $project = Project::query()->where('slug', 'nile-future')->sole();
        $exam = Project::query()->where('slug', 'stc-exam-system-nile-future')->sole();

        $this->assertSame($exam->sort_order + 1, $project->sort_order);
        $this->assertSame('https://nilefuture.org', $project->url);
        $this->assertSame('projects/nile-future.jpg', $project->image);
        $this->assertSame('projects/bawarq.jpg', Project::query()->where('slug', 'bawarq')->value('image'));
        $this->get('/projects/nile-future')->assertOk()->assertSee('onshore drilling');
    }

    public function test_admin_avatar_uses_the_profile_photo(): void
    {
        Profile::query()->update(['avatar' => 'profile/me.jpg']);
        $user = User::factory()->create();

        $this->assertSame(asset('storage/profile/me.jpg'), $user->getFilamentAvatarUrl());
        $this->actingAs($user)->get('/admin')->assertOk()->assertSee('storage/profile/me.jpg', escape: false);
    }

    public function test_projects_table_shows_the_live_url(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(ListProjects::class)
            ->searchTable('bawarq')
            ->assertSee('bawarq.org')
            ->assertSee('https://bawarq.org', escape: false);
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

    public function test_project_toggle_columns_save_from_the_table(): void
    {
        $this->actingAs(User::factory()->create());
        $project = Project::query()->where('is_featured', false)->firstOrFail();

        Livewire::test(ListProjects::class)
            ->call('updateTableColumnState', 'is_featured', (string) $project->getKey(), true)
            ->assertNotified('Saved')
            ->call('updateTableColumnState', 'is_visible', (string) $project->getKey(), false)
            ->assertNotified('Saved');

        $project->refresh();
        $this->assertTrue($project->is_featured);
        $this->assertFalse($project->is_visible);
    }

    public function test_reply_modal_emails_the_sender_and_marks_replied(): void
    {
        Mail::fake();
        $this->actingAs(User::factory()->create());
        $message = Message::create(['name' => 'Sara Recruiter', 'email' => 'sara@company.com', 'subject' => 'Backend role', 'body' => 'Are you open to a role?']);

        Livewire::test(ListMessages::class)
            ->mountTableAction('reply', $message)
            ->assertTableActionDataSet(['subject' => 'Re: Backend role']);

        Livewire::test(ListMessages::class)
            ->callTableAction('reply', $message, data: [
                'subject' => 'Re: Backend role',
                'body' => "Hi Sara,\n\nYes, happy to talk.",
            ])
            ->assertHasNoTableActionErrors()
            ->assertNotified('Reply sent');

        Mail::assertSent(ContactReply::class, function (ContactReply $mail) {
            $html = $mail->render();

            return $mail->hasTo('sara@company.com')
                && $mail->hasSubject('Re: Backend role')
                && $mail->hasFrom(config('mail.from.address'), 'Mohamed Khater')
                && str_contains($html, 'happy to talk')
                && str_contains($html, 'Are you open to a role?')
                && str_contains($html, 'Senior Laravel Backend Engineer')
                && ! str_contains($html, 'All rights reserved');
        });

        $this->assertNotNull($message->refresh()->replied_at);
        $this->assertNotNull($message->read_at);
    }

    public function test_failed_reply_is_reported_and_not_marked_replied(): void
    {
        $this->actingAs(User::factory()->create());
        $message = Message::create(['name' => 'A', 'email' => 'a@example.com', 'body' => 'Hi']);
        Mail::shouldReceive('to')->andThrow(new \RuntimeException('Connection refused'));

        Livewire::test(ListMessages::class)
            ->callTableAction('reply', $message, data: ['subject' => 'Re: Hi', 'body' => 'Hello'])
            ->assertNotified('Reply not sent');

        $this->assertNull($message->refresh()->replied_at);
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
