<?php

namespace App\Http\Controllers\LandingPages;

use App\Events\NewLead;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactFormRequest;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AutomationController extends Controller
{
    public function index(): View
    {
        return view('landing-pages/automation/index');
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
                'automation' => true,
            ]
        );

        NewLead::dispatch($contact, 'automation');

        return redirect()->route('automation.thank-you')
            ->with('success', 'Thank you! Check your email for the free guide.');
    }

    public function thanks(): View
    {
        return view('landing-pages/automation/thank-you');
    }
}
