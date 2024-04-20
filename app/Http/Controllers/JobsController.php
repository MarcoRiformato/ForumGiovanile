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
}
