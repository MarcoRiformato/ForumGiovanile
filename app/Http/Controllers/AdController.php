<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Ad;
use App\Models\Media;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ads = Ad::with('media')->get();
        return Inertia::render('Admin/Ads/Indexo', [
            'ads' => $ads
        ]);
    }    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Ads/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $validatedData = $request->validate([
        'title' => 'nullable|string|max:255',
        'link_url' => 'nullable|string|max:1024',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date',
        'priority' => 'nullable|integer',
        'image' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:10240', // max 10MB
      ]);
    
      $ad = Ad::create([
        'title' => $validatedData['title'],
        'link_url' => $validatedData['link_url'],
        'start_date' => $validatedData['start_date'],
        'end_date' => $validatedData['end_date'],
        'priority' => $validatedData['priority']
      ]);
    
      if ($request->hasFile('image')) {
        $file = $request->file('image');
        $path = $file->store('ads', 'public');
    
        $media = new Media([
          'filepath' => $path,
          'filetype' => $this->determineFileType($file->getClientMimeType()),
          'filename' => $file->getClientOriginalName(),
          'ad_id' => $ad->id,
        ]);
            
        $ad->media()->save($media);
      }
    
      return redirect()->route('admin.ads.index');
    }

    private function determineFileType($mimeType) {
      if (in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif'])) {
          return 'image';
      } elseif (in_array($mimeType, ['video/mp4'])) {
          return 'video';
      } else {
          return 'document';
      }
  }
    
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ad $ad)
    {
      {
        return Inertia::render('Admin/Ads/Edit', [
            'ad' => $ad
        ]);
      }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ad $ad)
    {
        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'link_url' => 'nullable|string|max:1024',
            'priority' => 'nullable|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);
    
        $ad->update([
            'title' => $validatedData['title'],
            'link_url' => $validatedData['link_url'],
            'priority' => $validatedData['priority'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
        ]);
    
        return redirect()->route('admin.ads.index')->with('message', 'Pubblicità modificata');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      $ad = Ad::findOrFail($id);
      $ad->delete();

      return redirect()->route('admin.ads.index')->with('message', 'Document successfully deleted.');
    }
}
