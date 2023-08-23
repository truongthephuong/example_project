<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     */
    public function index(): View
    {
        $categories = Categories::latest()->paginate(5);
        return view('category.index',compact('categories'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
        ]);

        Categories::create($request->all());
        return redirect()->route('categories.index')
                ->with('success','Categories created successfully.');
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Categories $categories): View
    {
        return view('category.show',compact('categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *      
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Categories $categories): View
    {
        return view('category.edit',compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categories $categories): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
        ]);

        $categories->update($request->all());
        return redirect()->route('category.index')
                        ->with('success','Categories updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categories $categories): RedirectResponse
    {
        $categories->delete();
        return redirect()->route('categories.index')
                        ->with('success','categories deleted successfully');
    }

}
