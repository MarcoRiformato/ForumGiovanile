<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Worker;
use Inertia\Inertia;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    public function index()
    {
        $workers = Worker::orderBy('created_at', 'desc')->get();
        return Inertia::render('Admin/Workers/Index', ['workers' => $workers]);
    }

    public function create()
    {
        return Inertia::render('Admin/Workers/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|string|max:255',
            'contract_type' => 'nullable|string|max:255',
            'job_titles' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'residence' => 'nullable|string|max:255',
            'availability' => 'nullable|date',
            'has_car' => 'nullable|boolean',
            'work_experience' => 'nullable|string',
            'languages' => 'nullable|string|max:255',
            'has_hccp_certificate' => 'nullable|boolean',
            'education' => 'nullable|string|max:255',
        ]);

        Worker::create($validated);

        return redirect()->route('admin.workers.index')->with('success', 'Collaboratore creato con successo.');
    }

    // Implement edit, update, and destroy methods here
}