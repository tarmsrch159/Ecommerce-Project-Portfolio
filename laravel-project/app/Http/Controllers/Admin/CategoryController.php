<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    //

    public function index()
    {
        return view('admin.categories.index')->with([
            'categories' => Category::latest()->get()
        ]);
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(AddCategoryRequest $request)
    {
        if ($request->validated()) {
            $data = $request->validated();
            $data['slug'] = Str::slug($request->name);
            Category::create($data);
            return redirect()->route('admin.categories.index')->with([
                'success' => 'Category added successfully'
            ]);
        }
    }

    public function show(Category $category)
    {
        abort(404);
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit')->with([
            'category' => $category
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        if ($request->validated()) {
            $data = $request->validated();
            $data['slug'] = Str::slug($request->name);
            $category->update($data);
            return redirect()->route('admin.categories.index')->with([
                'success' => 'Category updated successfully'
            ]);
        }
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with([
            'success' => 'Category deleted successfully'
        ]);
    }
}
