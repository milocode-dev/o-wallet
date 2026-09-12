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
            'type' => 'string|required',
        ]);

        $validatedData['user_id'] = Auth::user()->id;

        Category::create($validatedData);

        return redirect('category');
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
        $validatedData = $request->validate([
            'name' => 'string|required',
            'type' => 'string|required',
        ]);

        $category = Category::findOrFail($id);
        $category->update($validatedData);

        return redirect('category');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return redirect('category');
    }
}
