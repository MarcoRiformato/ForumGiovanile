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
            'profile_picture' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp|max:10240',
            'contract_type' => 'nullable|string|max:255',
            'job_titles' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'residence' => 'nullable|string|max:255',
            'availability' => 'nullable|date',
            'has_car' => 'boolean',
            'work_experience' => 'nullable|string',
            'languages' => 'nullable|string|max:255',
            'has_hccp_certificate' => 'boolean',
            'education' => 'nullable|string|max:255',
        ]);

        $worker = Worker::create([
            'name' => $validatedData['name'],
            'contract_type' => $validatedData['contract_type'],
            'job_titles' => $validatedData['job_titles'],
            'description' => $validatedData['description'],
            'residence' => $validatedData['residence'],
            'availability' => $validatedData['availability'],
            'has_car' => $validatedData['has_car'],
            'work_experience' => $validatedData['work_experience'],
            'languages' => $validatedData['languages'],
            'has_hccp_certificate' => $validatedData['has_hccp_certificate'],
            'education' => $validatedData['education'],
        ]);

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $path = $file->store('workers', 'public');

            $media = new Media([
                'filepath' => $path,
                'filetype' => $this->determineFileType($file->getClientMimeType()),
                'filename' => $file->getClientOriginalName(),
                'worker_id' => $worker->id,
            ]);

            $media->save();
            $worker->media()->attach($media);
        }

        return redirect()->route('admin.workers.index');
    }

    private function determineFileType($mimeType) {
        if (in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
            return 'image';
        } else {
            return 'document';
        }
    }

    // Implement edit, update, and destroy methods here
}