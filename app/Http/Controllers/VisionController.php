<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Vision;
class VisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $visions = Vision::get();
        return Inertia::render('Admin/Visions/Index', [
            'visions' => $visions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Visions/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        $vision = Vision::findOrFail($id);
        return Inertia::render('Admin/Visions/Edit', [
            'vision' => $vision
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $vision = Vision::findOrFail($id);
    
        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'desc' => 'nullable|string|max:255',
            'icon' => 'nullable|string'
        ]);
    
        $vision->update($validatedData);
        return redirect()->route('admin.visions.index')->with('success', 'Vision updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
