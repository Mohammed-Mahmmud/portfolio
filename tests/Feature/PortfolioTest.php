<?php

namespace Tests\Feature;

use App\Mail\NewContactMessage;
use App\Models\Message;
use App\Models\Project;
use App\Models\User;
use Database\Seeders\PortfolioSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
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
