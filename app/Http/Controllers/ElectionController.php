<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\Election;
use Illuminate\Http\Request;

class ElectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $elections = Election::with('user')->orderBy('created_at', 'desc')->get();
        return Inertia::render('IndexElections', [
            'elections' => $elections
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    // Step 1: Create Election Details
    public function createElectionDetails()
    {
        return Inertia::render('Admin/Elections/Create');
    }

    // Step 2: Store Election Details
    public function storeElectionDetails(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'nullable|max:255',
            'description' => 'nullable',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'status' => 'nullable',
        ]);

        session(['election' => $validatedData]);

        return redirect()->route('admin.elections.create.questions');
    }

    // Step 3: Create Questions
    public function createQuestions()
    {
        return Inertia::render('Admin/Elections/Questions');
    }

    // Step 4: Store Questions
    public function storeQuestions(Request $request)
    {
        $validatedData = $request->validate([
            'questions.*.text' => 'nullable|max:255',
            'questions.*.type' => 'nullable|in:options,candidates',
            'questions.*.options.*.text' => 'required_if:questions.*.type,options|max:255',
            'questions.*.candidates.*.name' => 'required_if:questions.*.type,candidates|max:255',
            'questions.*.candidates.*.description' => 'nullable',
        ]);

        session(['questions' => $validatedData['questions']]);

        return redirect()->route('admin.elections.review');
    }


    // Step 5: Review
    public function review()
    {
        $election = session('election');
        $questions = session('questions');
        return Inertia::render('Admin/Elections/Review', compact('election', 'questions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'status' => 'nullable|string',
            'questions' => 'nullable|json', 
        ]);        
    
        // Decode the JSON string for questions
        $questions = json_decode($data['questions'], true);
    
        // Create a new election
        $election = Election::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'status' => $data['status'],
        ]);
    
        // Handle the questions, options, and candidates
        foreach ($questions as $questionData) {
            $question = $election->questions()->create([
                'text' => $questionData['text'],
                'type' => $questionData['type'],
            ]);
    
            if ($questionData['type'] === 'options') {
                foreach ($questionData['options'] as $optionData) {
                    $question->options()->create(['text' => $optionData['text']]);
                }
            } else if ($questionData['type'] === 'candidates') {
                foreach ($questionData['candidates'] as $candidateData) {
                    $question->candidates()->create([
                        'name' => $candidateData['name'],
                        'description' => $candidateData['description']
                    ]);
                }
            }
        }
    
        // Clear the session data if needed
        $request->session()->forget(['election', 'questions']);
    
        return redirect()->route('admin.elections.index');
    }
    


    /**
     * Store a newly created resource in storage.
     */

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $election = Election::with('questions.options', 'questions.candidates')
            ->findOrFail($id);

        return Inertia::render('Elections/Show', [
            'election' => $election
        ]);
    }

    /**
     * Display the specified resource for admins.
     */
    public function showForAdmin(string $id)
    {
        $election = Election::with('questions.options', 'questions.candidates')
            ->findOrFail($id);

        return Inertia::render('Admin/Elections/Show', [
            'election' => $election
        ]);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function editStep1($id)
    {
        $election = Election::findOrFail($id);
        return Inertia::render('Admin/Elections/Edit_Step1', [
            'election' => $election
        ]);
    }
    
    public function editStep2($id)
    {
        $election = Election::with('questions.options', 'questions.candidates')->findOrFail($id);
        return Inertia::render('Admin/Elections/Edit_Step2', [
            'election' => $election
        ]);
    }

    /**
     * Update the specified resource in storage.
     */

     public function updateStep1(Request $request, $id)
     {
         $election = Election::findOrFail($id);
     
         $validatedData = $request->validate([
             'name' => 'nullable|max:255',
             'description' => 'nullable',
             'start_date' => 'nullable|date',
             'end_date' => 'nullable|date',
             'status' => 'nullable',
         ]);
     
         $election->update($validatedData);
     }
     

     public function updateStep2(Request $request, $id)
     {
         $election = Election::findOrFail($id);
     
         // Validate basic election details
         $validatedData = $request->validate([
             'questions.*.text' => 'nullable|max:255',
             'questions.*.type' => 'nullable|in:options,candidates',
             'questions.*.options.*.text' => 'required_if:questions.*.type,options|max:255',
             'questions.*.candidates.*.name' => 'required_if:questions.*.type,candidates|max:255',
             'questions.*.candidates.*.description' => 'nullable',
         ]);
     
         // Delete existing questions and related options and candidates
         $election->questions->each(function ($question) {
             $question->options()->delete(); // Delete related options
             $question->candidates()->delete(); // Delete related candidates
             $question->delete(); // Delete the question itself
         });
     
         // Re-insert questions, options, and candidates
         foreach ($validatedData['questions'] as $questionData) {
             $question = $election->questions()->create([
                 'text' => $questionData['text'],
                 'type' => $questionData['type'],
             ]);
     
             if ($questionData['type'] === 'options') {
                 foreach ($questionData['options'] as $optionData) {
                     $question->options()->create(['text' => $optionData['text']]);
                 }
             } else if ($questionData['type'] === 'candidates') {
                 foreach ($questionData['candidates'] as $candidateData) {
                     $question->candidates()->create([
                         'name' => $candidateData['name'],
                         'description' => $candidateData['description']
                     ]);
                 }
             }
         }
     
         return redirect()->route('admin.elections.index')->with('message', 'Document successfully deleted.');
     }
     
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Election $election)
    {
        //
    }
}
