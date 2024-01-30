<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\Election;
use App\Models\Vote;
use Illuminate\Http\Request;

class ElectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $election = Election::with('user')->find(6);
    
        return Inertia::render('IndexElections', [ 'election' => $election]);
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
    
        // Handle the questions, options, candidates, and writing
        foreach ($questions as $questionData) {
            $question = $election->questions()->create([
                'text' => $questionData['text'],
                'type' => $questionData['type'],
            ]);
    
            if ($questionData['type'] === 'options') {
                foreach ($questionData['options'] as $optionData) {
                    $question->options()->create(['text' => $optionData['text']]);
                }
            } elseif ($questionData['type'] === 'candidates') {
                foreach ($questionData['candidates'] as $candidateData) {
                    $question->candidates()->create([
                        'name' => $candidateData['name'],
                        'description' => $candidateData['description']
                    ]);
                }
            } elseif ($questionData['type'] === 'writing') {
                // For writing type, the text of the question is already saved
                // No need for additional data at this point
            }
        }
    
        // Clear the session data if needed
        $request->session()->forget(['election', 'questions']);
    
        return redirect()->route('admin.elections.index');
    }
    

    protected function hasVoted($electionId, $ipAddress) {
        return Vote::where('election_id', $electionId)->where('ip_address', $ipAddress)->exists();
    }

    /**
     * Display the specified resource.
     */
    public function showDynamic(string $id)
    {
        $election = Election::with('questions.options', 'questions.candidates')
            ->findOrFail($id);

        // Check if the user has already voted
        /*
        if ($this->hasVoted($election->id, request()->ip())) {
            return redirect()->route('elections.thanks')->with('error', 'You have already voted in this election.');
        }
        */

        return Inertia::render('Elections/Show', [
            'election' => $election
        ]);
    }

    public function show(string $id)
    {
        $election = Election::with('questions.options', 'questions.candidates')
            ->findOrFail($id);

        return Inertia::render('Elections/ShowDynamic', ['election'=> $election]);

        // Check if the user has already voted
        /*
        if ($this->hasVoted($election->id, request()->ip())) {
            return redirect()->route('elections.thanks')->with('error', 'You have already voted in this election.');
        }

        return Inertia::render('Elections/Show', [
            'election' => $election
        ]);*/
    }

    public function storeVote(Request $request, Election $election)
    {

        // Check if the user has already voted
        if (Vote::where('election_id', $election->id)->where('ip_address', $request->ip())->exists()) {
            // If they have already voted, redirect them with an error message
            return redirect()->route('elections.thanks')->with('error', 'You have already voted in this election.');
        }

        $votes = $request->votes;
        foreach ($votes as $voteData) {
            $questionId = $voteData['questionId'];
            $type = $voteData['type'];
            $selectedId = $voteData['selectedId'];
    
            $vote = new Vote();
            $vote->election_id = $election->id;
            $vote->question_id = $questionId;
            $vote->ip_address = $request->ip(); 
    
            if ($type === 'candidate') {
                $vote->candidate_id = $selectedId;
            } elseif ($type === 'writing') {
                $vote->written_text = $selectedId;
            } elseif ($type === 'option') {
                $vote->option_id = $selectedId;
            }
    
            $vote->save();
        }
    
        return redirect()->route('elections.thanks')->with('message', 'Thank you for your vote');
    }
    
    
    /**
     * Display the specified resource for admins.
     */
    public function showForAdmin(string $id)
    {
        $election = Election::with([
            'questions.options' => function($query) {
              $query->withCount('votes');
            },
            'questions.candidates' => function($query) {
              $query->withCount('votes');
            },
            'questions.votes' => function($query) {  
              $query->select('id', 'question_id', 'written_text');
            },
          ])->findOrFail($id);      
    
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
     
         // Updated validation rules
         $validatedData = $request->validate([
             'questions.*.text' => 'nullable|max:255',
             'questions.*.type' => 'nullable|in:options,candidates,writing',
             'questions.*.options.*.text' => 'required_if:questions.*.type,options|max:255',
             'questions.*.candidates.*.name' => 'required_if:questions.*.type,candidates|max:255',
             'questions.*.candidates.*.description' => 'nullable',
         ]);
     
         // Delete existing questions and related options and candidates
         $election->questions->each(function ($question) {
             $question->options()->delete();
             $question->candidates()->delete();
             $question->delete();
         });
     
         // Re-insert questions, options, and candidates
         if (array_key_exists('questions', $validatedData)) {
         foreach ($validatedData['questions'] as $questionData) {
             $question = $election->questions()->create([
                 'text' => $questionData['text'],
                 'type' => $questionData['type'],
             ]);
     
             if ($questionData['type'] === 'options') {
                 foreach ($questionData['options'] as $optionData) {
                     $question->options()->create(['text' => $optionData['text']]);
                 }
             } elseif ($questionData['type'] === 'candidates') {
                 foreach ($questionData['candidates'] as $candidateData) {
                     $question->candidates()->create([
                         'name' => $candidateData['name'],
                         'description' => $candidateData['description']
                     ]);
                 }
             } elseif ($questionData['type'] === 'writing') {
                 // No need to save additional fields for "writing" type
                 // You can put any logic here if you want to handle this type differently
             }
         }
        }
         return redirect()->route('admin.elections.index')->with('message', 'Election questions updated successfully.');
     }
     
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Election $election)
    {
        //
    }
}
