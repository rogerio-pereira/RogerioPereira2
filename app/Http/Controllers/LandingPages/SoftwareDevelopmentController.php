<?php

namespace App\Http\Controllers\LandingPages;

use App\Events\NewLead;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactFormRequest;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SoftwareDevelopmentController extends Controller
{
    public function index(): View
    {
        return view('landing-pages/software-development/index');
    }

    public function store(ContactFormRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $contact = Contact::updateOrCreate(
            ['email' => $validated['email']],
            [
                'name' => $validated['name'],
                'phone' => $validated['phone'] ?? null,
                'do_not_contact' => false,
                'software_development' => true,
            ]
        );

        // Dispatches NewLead event which has two listeners:
        // - NewLeadSlackListener: sends Slack notification
        // - NewLeadEmailListener: queues email to lead
        NewLead::dispatch($contact, 'software-development');

        return redirect()->route('software-development.thank-you')
            ->with('success', 'Thank you! Check your email for next steps.');
    }

    public function thanks(): View
    {
        return view('landing-pages/software-development/thank-you');
    }
}
