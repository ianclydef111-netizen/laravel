<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class CategoryController extends Controller {
    public function index(Request $request) {
        $query = Category::withCount('medicines');
        if ($request->filled('search')) $query->where('name', 'like', '%' . $request->search . '%');
        $categories = $query->paginate(15);
        return view('categories.index', compact('categories'));
    }

    public function create() { return view('categories.create'); }

    public function store(Request $request) {
        $request->validate(['name' => 'required|unique:categories', 'description' => 'required']);
        $category = Category::create($request->only('name', 'description'));
        
        // Only update the ID number if the column exists
        try {
            $idNumber = 'CAT' . str_pad($category->id, 3, '0', STR_PAD_LEFT);
            if (Schema::hasColumn('categories', 'category_id_number')) {
                $category->update(['category_id_number' => $idNumber]);
            }
        } catch (\Exception $e) {
            // Column doesn't exist yet - that's OK, migrations will add it
        }
        
        return redirect()->route('categories.index')->with('success', 'Category created (ID: ' . $category->category_id_number_display . ').');
    }

    public function edit(Category $category) { return view('categories.edit', compact('category')); }

    public function update(Request $request, Category $category) {
        $request->validate(['name' => 'required|unique:categories,name,' . $category->id, 'description' => 'required']);
        $category->update($request->only('name', 'description'));
        return redirect()->route('categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category) {
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }

    public function show(Category $category) {
        $category->load(['medicines' => function($query) {
            $query->with(['supplier', 'category']);
        }]);
        return view('categories.show', compact('category'));
    }
}
