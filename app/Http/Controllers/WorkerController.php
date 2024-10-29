<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Worker;
use App\Models\Media;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WorkerController extends Controller
{
    public function index()
    {
        $workers = Worker::with('media')->orderBy('created_at', 'desc')->get();
        return Inertia::render('Workers/Index', ['workers' => $workers]);
    }

    public function create()
    {
        return Inertia::render('Admin/Workers/Create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp|max:10240',
            'contract_type' => 'nullable|string|max:255',
            'job_titles' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'residence' => 'nullable|string|max:255',
            'availability_start' => 'nullable|date',
            'availability_end' => 'nullable|date',
            'has_car' => 'nullable|boolean',
            'work_experience' => 'nullable|string',
            'languages' => 'nullable|string|max:255',
            'has_hccp_certificate' => 'nullable|boolean',
            'education' => 'nullable|string|max:255',
        ], [
            'profile_picture.max' => 'L\'immagine non può superare i 10MB',
            'profile_picture.mimes' => 'Il file deve essere un\'immagine (jpg, jpeg, png, gif, webp)',
            'name.max' => 'Il nome non può superare i 255 caratteri',
            'contract_type.max' => 'Errore nel tipo di contratto',
            'job_titles.max' => 'I titoli di lavoro non possono superare i 255 caratteri',
            'residence.max' => 'La residenza non può superare i 255 caratteri',
            'languages.max' => 'Le lingue non possono superare i 255 caratteri',
            'education.max' => 'L\'istruzione non può superare i 255 caratteri',
        ]);

        $worker = Worker::create([
            'name' => $validatedData['name'],
            'contract_type' => $validatedData['contract_type'],
            'job_titles' => $validatedData['job_titles'],
            'description' => $validatedData['description'],
            'residence' => $validatedData['residence'],
            'availability_start' => $validatedData['availability_start'],
            'availability_end' => $validatedData['availability_end'],
            'has_car' => $validatedData['has_car'],
            'work_experience' => $validatedData['work_experience'],
            //'languages' => 'test',
            'has_hccp_certificate' => $validatedData['has_hccp_certificate'],
            'education' =>  $validatedData['education'],
        ]);

        if ($request->hasFile('profile_picture')) {
            $this->handleProfilePicture($worker, $request->file('profile_picture'));
        }

        return redirect()->route('admin.workers.index')->with('message', 'Worker created successfully');
    }

    public function edit(Worker $worker)
    {
        $worker->load('media');
        return Inertia::render('Admin/Workers/Edit', [
            'worker' => $worker
        ]);
    }

    public function update(Request $request, Worker $worker)
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'contract_type' => 'nullable|string|max:255',
            'job_titles' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'residence' => 'nullable|string|max:255',
            'availability_start' => 'nullable|date',
            'availability_end' => 'nullable|date',
            'has_car' => 'boolean',
            'work_experience' => 'nullable|string',
            'languages' => 'nullable|string|max:255',
            'has_hccp_certificate' => 'boolean',
            'education' => 'nullable|string|max:255',
        ]);

        $worker->update($validatedData);

        if ($request->hasFile('profile_picture')) {
            $this->handleProfilePicture($worker, $request->file('profile_picture'));
        } elseif ($request->boolean('remove_existing_image')) {
            $this->removeProfilePicture($worker);
        }

        return redirect()->route('admin.workers.index')->with('message', 'Worker updated successfully');
    }

    public function destroy(string $id)
    {
        $worker = Worker::findOrFail($id);
        $worker->delete();

        return redirect()->route('admin.workers.index')->with('message', 'Worker successfully deleted.');
    }

    private function determineFileType($mimeType) {
        if (in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
            return 'image';
        } elseif (in_array($mimeType, ['video/mp4'])) {
            return 'video';
        } else {
            return 'document';
        }
    }

    private function handleProfilePicture(Worker $worker, $file)
    {
        // Delete existing profile picture if any
        if ($worker->media()->exists()) {
            $existingMedia = $worker->media()->first();
            Storage::disk('public')->delete($existingMedia->filepath);
            $existingMedia->delete();
        }

        // Store new profile picture
        $path = $file->store('workers', 'public');

        $media = new Media([
            'filepath' => $path,
            'filetype' => $this->determineFileType($file->getClientMimeType()),
            'filename' => $file->getClientOriginalName(),
        ]);
        
        $worker->media()->save($media);
    }

    private function removeProfilePicture(Worker $worker)
    {
        if ($worker->media()->exists()) {
            $existingMedia = $worker->media()->first();
            Storage::disk('public')->delete($existingMedia->filepath);
            $existingMedia->delete();
        }
    }
}
