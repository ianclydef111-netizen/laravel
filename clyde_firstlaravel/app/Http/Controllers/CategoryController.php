<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller {
    public function index(Request $request) {
        $query = Category::withCount('medicines');
        if ($request->filled('search')) $query->where('name', 'like', '%' . $request->search . '%');
        $categories = $query->paginate(15);
        return view('categories.index', compact('categories'));
    }

    public function create() { return view('categories.create'); }

    public function store(Request $request) {
        $request->validate(['name' => 'required|unique:categories', 'description' => 'nullable']);
        $category = Category::create($request->only('name', 'description'));
        $category->category_id_number = 'CAT' . str_pad($category->id, 3, '0', STR_PAD_LEFT);
        $category->save();
        return redirect()->route('categories.index')->with('success', 'Category created (ID: ' . $category->category_id_number_display . ').');
    }

    public function edit(Category $category) { return view('categories.edit', compact('category')); }

    public function update(Request $request, Category $category) {
        $request->validate(['name' => 'required|unique:categories,name,' . $category->id, 'description' => 'nullable']);
        $category->update($request->only('name', 'description'));
        return redirect()->route('categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category) {
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }
}