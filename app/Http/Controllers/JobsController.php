<?php

namespace App\Http\Controllers;
use App\Models\Jobs;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JobsController extends Controller
{
    public function index()
    {
        $jobs = Jobs::orderBy('created_at', 'desc')->get();
        return Inertia::render('Jobs/Index', [
            'jobs' => $jobs
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Jobs/Create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'lavoro' => 'nullable|string|max:255',
            'azienda' => 'nullable|string|max:255',
            'luogo' => 'nullable|string|max:255',
            'descrizione' => 'nullable|string',
            'stipendio' => 'nullable|string|max:255',
        ]);        

        Jobs::create($validatedData);

        return redirect()->route('admin.jobs.index')->with('message', 'Job successfully created.');
    }

    public function edit(string $id)
    {
        $job = Jobs::findOrFail($id);
        return Inertia::render('Admin/Jobs/Edit', [
            'job' => $job
        ]);
    }

    public function update(Request $request, string $id)
    {
        $job = Jobs::findOrFail($id);

        $validatedData = $request->validate([
            'lavoro' => 'nullable|string|max:255',
            'azienda' => 'nullable|string|max:255',
            'luogo' => 'nullable|string|max:255',
            'descrizione' => 'nullable|string',
            'stipendio' => 'nullable|string|max:255',
        ]);

        $job->update($validatedData);

        return redirect()->route('admin.jobs.index')->with('message', 'Job successfully updated.');
    }

    public function destroy(string $id)
    {
        $job = Jobs::findOrFail($id);
        $job->delete();

        return redirect()->route('jobs.index')->with('message', 'job successfully deleted.');
    }

}
