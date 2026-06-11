<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $publishers = Publisher::latest()->paginate(10);
        return view('pages.admin.publishers.index', compact('publishers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.publishers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:publishers,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        Publisher::create($request->all());

        return redirect()->route('admin.publisher.index')
            ->with('success', 'Publisher created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Publisher $publisher)
    {
        return view('pages.admin.publishers.show', compact('publisher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publisher $publisher)
    {
        return view('pages.admin.publishers.edit', compact('publisher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Publisher $publisher)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:publishers,email,' . $publisher->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $publisher->update($request->all());

        return redirect()->route('admin.publishers.index')
            ->with('success', 'Publisher updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();

        return redirect()->route('admin.publishers.index')
            ->with('success', 'Publisher deleted successfully.');
    }
}
