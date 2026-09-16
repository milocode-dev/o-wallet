<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::where('user_id', auth()->id())->get();

        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categoryType = [
            'income' => 'Income',
            'expense' => 'Expense',
        ];

        return view('category.create', compact('categoryType'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'string|required',
            'type' => 'string|required|in:income,expense',
        ]);

        $validatedData['user_id'] = Auth::user()->id;

        Category::create($validatedData);

        return redirect()->route('category.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        if ($category->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak! Anda bukan pemilik kategori ini.');
        }

        $categoryType = [
            'income' => 'Income',
            'expense' => 'Expense',
        ];

        return view('category.edit', compact('category', 'categoryType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        if ($category->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak! Anda bukan pemilik kategori ini.');
        }

        $validatedData = $request->validate([
            'name' => 'string|required',
            'type' => 'string|required|in:income,expense',
        ]);

        $category->update($validatedData);

        return redirect()->route('category.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak! Anda bukan pemilik kategori ini.');
        }

        $category->delete();

        return redirect()->route('category.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
