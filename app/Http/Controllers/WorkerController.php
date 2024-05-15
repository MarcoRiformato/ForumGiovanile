<?php

namespace App\Http\Controllers;
use App\Models\Worker;
use Inertia\Inertia;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    public function index()
    {
        $workers = Worker::orderBy('created_at', 'desc')->get();
        return Inertia::render('Workers/Index', [
            'workers' => $workers
        ]);
    }
}
