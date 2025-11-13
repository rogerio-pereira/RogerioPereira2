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
            $data['file'] = Storage::putFile('ebooks', $request->file('file'), 'public');
        }

        if ($request->hasFile('image')) {
            $data['image'] = Storage::putFile('ebooks/images', $request->file('image'), 'public');
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
            $data['file'] = Storage::putFile('ebooks', $request->file('file'), 'public');
        } else {
            unset($data['file']);
        }

        if ($request->hasFile('image')) {
            // Delete old image
            if ($ebook->image) {
                Storage::delete($ebook->image);
            }
            $data['image'] = Storage::putFile('ebooks/images', $request->file('image'), 'public');
        } else {
            unset($data['image']);
        }

        $ebook->update($data);

        return redirect()->route('core.ebooks.index')
            ->with('success', __('Ebook updated successfully.'));
    }

    /**
     * Download the ebook file.
     */
    public function download(Ebook $ebook)
    {
        if (!$ebook->file || !Storage::exists($ebook->file)) {
            abort(404, __('File not found.'));
        }

        return Storage::download($ebook->file);
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

        // Delete image if exists
        if ($ebook->image) {
            Storage::delete($ebook->image);
        }

        $ebook->delete();

        return redirect()->route('core.ebooks.index')
            ->with('success', __('Ebook deleted successfully.'));
    }
}
