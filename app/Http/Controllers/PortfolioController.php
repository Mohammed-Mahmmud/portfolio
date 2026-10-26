<?php

namespace App\Http\Controllers;

use App\Mail\NewContactMessage;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Message;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SkillGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function home(): View
    {
        $projects = Project::query()->visible()->get();

        return view('portfolio.home', [
            'profile' => Profile::current(),
            'experiences' => Experience::query()->visible()->get(),
            'featured' => $projects->where('is_featured', true)->values(),
            'others' => $projects->where('is_featured', false)->values(),
            'skillGroups' => SkillGroup::query()->visible()->get(),
            'education' => Education::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function archive(): View
    {
        return view('portfolio.archive', [
            'profile' => Profile::current(),
            'projects' => Project::query()->visible()->get(),
        ]);
    }

    public function project(Project $project): View
    {
        abort_unless($project->is_visible, 404);

        return view('portfolio.project', [
            'profile' => Profile::current(),
            'project' => $project,
        ]);
    }

    public function contact(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'subject' => ['nullable', 'string', 'max:190'],
            'body' => ['required', 'string', 'max:5000'],
            'website' => ['prohibited'],
        ]);

        $message = Message::create($data);

        // The message is already saved, so a mail failure must not break the form for the visitor.
        if ($recipient = config('mail.contact_to') ?: Profile::current()->email) {
            defer(fn () => rescue(fn () => Mail::to($recipient)->send(new NewContactMessage($message))));
        }

        return redirect()->to(url()->previous().'#contact')->with('contact_sent', true);
    }
}
