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
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect('/');
        }
        
        $election = Election::with('user')->where('status', 'open')->latest()->first();
    
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
            'max_votes' => 'nullable|integer|min:1',
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
            'max_votes' => 'nullable|integer|min:1',
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
            'max_votes' => $data['max_votes'],
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
        // Get IP from various possible headers that might be set by proxies/load balancers
        $ip = request()->header('X-Forwarded-For') // AWS Load Balancer, most proxies
            ?? request()->header('X-Real-IP')      // Nginx proxy
            ?? request()->header('CF-Connecting-IP') // Cloudflare
            ?? request()->ip();                     // Direct connection
        
        // If X-Forwarded-For contains multiple IPs, get the first one (original client)
        if (strpos($ip, ',') !== false) {
            $ip = trim(explode(',', $ip)[0]);
        }

        return Vote::where('election_id', $electionId)
                   ->where('ip_address', $ip)
                   ->exists();
    }

    /**
     * Display the specified resource.
     */
    public function showDynamic(string $id) {
        $election = Election::with('questions.candidates')->findOrFail($id);

        if (!auth()->check() || !auth()->user()->isAdmin()) {
            $now = \Carbon\Carbon::now();
            if ($election->start_date && $now->lt(\Carbon\Carbon::parse($election->start_date))) {
                return redirect('/');
            }
            if ($election->end_date && $now->gt(\Carbon\Carbon::parse($election->end_date))) {
                return redirect('/');
            }
            if ($election->status !== 'open') {
                return redirect('/');
            }
        }

        // Check if the user has already voted
        if ($this->hasVoted($election->id, request()->ip())) {
            return redirect()->route('elections.thanks')
                ->with('error', 'Hai già votato in questa elezione.');
        }

        return Inertia::render('Elections/ShowDynamic', [
            'election' => $election
        ]);
    }

    public function show(string $id)
    {
        $election = Election::with('questions.options', 'questions.candidates')
            ->findOrFail($id);

        if (!auth()->check() || !auth()->user()->isAdmin()) {
            $now = \Carbon\Carbon::now();
            if ($election->start_date && $now->lt($election->start_date)) {
                return redirect('/');
            }
            if ($election->end_date && $now->gt($election->end_date)) {
                return redirect('/');
            }
            if ($election->status !== 'open') {
                return redirect('/');
            }
        }

        // Check if the user has already voted
        if ($this->hasVoted($election->id, request()->ip())) {
            return redirect()->route('elections.thanks')->with('error', 'You have already voted in this election.');
        }

        return Inertia::render('Elections/Show', ['election'=> $election]);
    }

    public function storeVote(Request $request, Election $election)
    {
        // Use the same IP detection method
        $ip = request()->header('X-Forwarded-For')
            ?? request()->header('X-Real-IP')
            ?? request()->header('CF-Connecting-IP')
            ?? request()->ip();
        
        if (strpos($ip, ',') !== false) {
            $ip = trim(explode(',', $ip)[0]);
        }

        // Check if the user has already voted
        if ($this->hasVoted($election->id, $ip)) {
            return redirect()->route('elections.thanks')
                ->with('error', 'Hai già votato in questa elezione.');
        }

        // Validate that all questions have been answered
        $questions = $election->questions;
        $votes = $request->votes;
        
        // Create a map of question IDs from the submitted votes
        $answeredQuestionIds = collect($votes)->pluck('questionId')->toArray();
        
        // Check if any questions are missing answers
        foreach ($questions as $question) {
            if (!in_array($question->id, $answeredQuestionIds)) {
                return redirect()->back()
                    ->with('error', 'Per favore rispondi a tutte le domande.');
            }
        }

        // Process and store the votes
        foreach ($votes as $voteData) {
            $vote = new Vote();
            $vote->election_id = $election->id;
            $vote->question_id = $voteData['questionId'];
            $vote->ip_address = $ip;

            if ($voteData['type'] === 'candidate') {
                $vote->candidate_id = $voteData['selectedId'];
            } elseif ($voteData['type'] === 'writing') {
                if (empty(trim($voteData['selectedId']))) {
                    return redirect()->back()
                        ->with('error', 'Le risposte scritte non possono essere vuote.');
                }
                $vote->written_text = $voteData['selectedId'];
            } elseif ($voteData['type'] === 'option') {
                $vote->option_id = $voteData['selectedId'];
            }

            $vote->save();
        }

        return redirect()->route('elections.thanks')
            ->with('message', 'Grazie per il tuo voto!');
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
             'max_votes' => 'nullable|integer|min:1'
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
