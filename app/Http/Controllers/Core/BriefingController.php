<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Briefing;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BriefingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $briefings = Briefing::latest()->paginate(15);

        return view('core.briefings.index', compact('briefings'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Briefing $briefing): View
    {
        return view('core.briefings.show', compact('briefing'));
    }

    /**
     * Mark briefing as done.
     */
    public function markAsDone(Briefing $briefing): RedirectResponse
    {
        $briefing->update([
            'status' => 'done',
        ]);

        return redirect()->route('core.briefings.index')
            ->with('success', __('Briefing marked as done.'));
    }
}
