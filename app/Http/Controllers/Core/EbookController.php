<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Core\EbookRequest;
use App\Models\Category;
use App\Models\Ebook;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EbookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $ebooks = Ebook::with('category')->latest()->paginate(15);

        return view('core.ebooks.index', compact('ebooks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('core.ebooks.form', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EbookRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $data['file'] = Storage::putFile('ebooks', $file);
        }

        Ebook::create($data);

        return redirect()->route('core.ebooks.index')
            ->with('success', __('Ebook created successfully.'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ebook $ebook): View
    {
        $categories = Category::orderBy('name')->get();

        return view('core.ebooks.form', compact('ebook', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EbookRequest $request, Ebook $ebook): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            // Delete old file
            if ($ebook->file) {
                Storage::delete($ebook->file);
            }
            $file = $request->file('file');
            $data['file'] = Storage::putFile('ebooks', $file);
        } else {
            unset($data['file']);
        }

        $ebook->update($data);

        return redirect()->route('core.ebooks.index')
            ->with('success', __('Ebook updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ebook $ebook): RedirectResponse
    {
        // Delete file if exists
        if ($ebook->file) {
            Storage::delete($ebook->file);
        }

        $ebook->delete();

        return redirect()->route('core.ebooks.index')
            ->with('success', __('Ebook deleted successfully.'));
    }
}
