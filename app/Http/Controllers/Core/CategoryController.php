<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Core\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $categories = Category::latest()->paginate(15);

        return view('core.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('core.categories.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        Category::create($request->validated());

        return redirect()->route('core.categories.index')
            ->with('success', __('Category created successfully.'));
    }



    /**
     * Return resource in storage
     *
     * @param Category $category
     * @return Category
     */
    public function show(Category $category) : Category
    {
        return $category;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): View
    {
        return view('core.categories.form', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());

        return redirect()->route('core.categories.index')
            ->with('success', __('Category updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('core.categories.index')
            ->with('success', __('Category deleted successfully.'));
    }
}
