<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Worker;
use App\Models\Media;
use Inertia\Inertia;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    public function index()
    {
        $workers = Worker::orderBy('created_at', 'desc')->get();
        return Inertia::render('Workers/Index', ['workers' => $workers]);
    }

    public function create()
    {
        return Inertia::render('Admin/Workers/Create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'profile_picture' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:10240',
            // Add validation rules for other fields
        ]);

        $worker = Worker::create($validatedData);

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $path = $file->store('workers', 'public');

            $media = new Media([
                'filepath' => $path,
                'filetype' => 'image',
                'filename' => $file->getClientOriginalName(),
                'worker_id' => $worker->id,
            ]);

            $worker->media()->save($media);
        }

        return redirect()->route('admin.workers.index');
    }

    // Implement edit, update, and destroy methods here
}