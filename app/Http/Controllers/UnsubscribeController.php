<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UnsubscribeController extends Controller
{
    /**
     * Show the unsubscribe confirmation page.
     */
    public function show(string $id): View|RedirectResponse
    {
        $contact = Contact::find($id);

        if (! $contact) {
            return redirect()->route('home')
                ->with('error', 'Invalid unsubscribe link.');
        }

        return view('unsubscribe.show', [
            'contact' => $contact,
        ]);
    }

    /**
     * Confirm the unsubscribe action.
     */
    public function confirm(string $id): RedirectResponse
    {
        $contact = Contact::find($id);

        if (! $contact) {
            return redirect()->route('home')
                ->with('error', 'Invalid unsubscribe link.');
        }

        $contact->update([
            'do_not_contact' => true,
        ]);

        return redirect()->route('unsubscribe.resubscribe', $contact->id)
            ->with('success', 'You have been unsubscribed successfully.');
    }

    /**
     * Show the resubscribe page.
     */
    public function resubscribe(string $id): View|RedirectResponse
    {
        $contact = Contact::find($id);

        if (! $contact) {
            return redirect()->route('home')
                ->with('error', 'Invalid link.');
        }

        return view('unsubscribe.resubscribe', [
            'contact' => $contact,
        ]);
    }

    /**
     * Confirm the resubscribe action.
     */
    public function resubscribeConfirm(string $id): RedirectResponse
    {
        $contact = Contact::find($id);

        if (! $contact) {
            return redirect()->route('home')
                ->with('error', 'Invalid link.');
        }

        $contact->update([
            'do_not_contact' => false,
        ]);

        return redirect()->route('unsubscribe.resubscribe.success', $contact->id);
    }

    /**
     * Show the resubscribe success page.
     */
    public function resubscribeSuccess(string $id): View|RedirectResponse
    {
        $contact = Contact::find($id);

        if (! $contact) {
            return redirect()->route('home')
                ->with('error', 'Invalid link.');
        }

        return view('unsubscribe.resubscribe-success', [
            'contact' => $contact,
        ]);
    }
}
