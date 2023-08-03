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
        $campaigns = Campaign::orderBy('created_at', 'desc')->get();
    
        return Inertia::render('SelezionaCampagna', [
            'campaigns' => $campaigns
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('CreateCampaign');
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

        return redirect()->route('campaigns.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);
        return Inertia::render('ShowCampaign', [
            'campaign' => $campaign
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);
        return Inertia::render('EditCampaign', [
            'campaign' => $campaign
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCampaignRequest $request, $id)
    {
        $campaign = Campaign::find($id);
    
        $campaign->update([
            'title' => $request->title,
            'description' => $request->description,
            'testingCampaign' => $request->testingCampaign,
            'status' => $request->status,
            'startingDate' => $request->startingDate,
            'endDate' => $request->endDate
        ]);
    
        return redirect()->route('campaigns.index')->with('message', 'Campagna modificata');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($campaign_id)
    {
        
        $campaign = Campaign::find($campaign_id);
        $campaign->delete();

        return redirect()->route('campaigns.index');

    }
}
