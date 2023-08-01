<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Http\Requests\StoreCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;
use Inertia\Inertia;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campaigns = Campaign::all();
    
        return Inertia::render('SelezionaCampagna', [
            'campaigns' => $campaigns
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('NuovaCampagna');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCampaignRequest $request)
    {
        $campaign = Campaign::create([
            'title' => $request->title,
            'description' => $request->description,
            'testingCampaign' => $request->testingCampaign,
            'status' => $request->status,
            'startingDate' => $request->startingDate,
            'endDate' => $request->endDate
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCampaignRequest $request, Campaign $campaign)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign)
    {
        //
    }
}
