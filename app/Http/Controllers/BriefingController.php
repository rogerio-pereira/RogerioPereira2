<?php

namespace App\Http\Controllers;

use App\Events\BriefingSubmitted;
use App\Http\Requests\BriefingFormRequest;
use App\Models\Briefing;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BriefingController extends Controller
{
    public function create(): View
    {
        return view('briefing.create');
    }

    public function store(BriefingFormRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Convert the nested briefing array to the expected JSON structure
        $briefingData = [];
        if (isset($validated['briefing'])) {
            foreach ($validated['briefing'] as $section => $questions) {
                $briefingData['sections'][$section] = [];
                foreach ($questions as $key => $value) {
                    // Convert to [Question, Answer] format
                    $questionLabel = ucfirst(str_replace('_', ' ', $key));
                    $briefingData['sections'][$section][] = [$questionLabel, $value];
                }
            }
        }

        $briefing = Briefing::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'briefing' => $briefingData,
            'status' => 'new',
        ]);

        /*
         * Dispatch event (will call two listeners)
         *      BriefingEmailListener: sends confirmation email to user
         *      BriefingSlackListener: sends Slack notification
         */
        BriefingSubmitted::dispatch($briefing);

        return redirect()->route('briefing.thank-you')
            ->with('success', 'Thank you! We received your briefing and will analyze it soon.');
    }

    public function thanks(): View
    {
        return view('briefing.thank-you');
    }
}
