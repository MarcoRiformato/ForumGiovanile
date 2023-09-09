<?php

namespace App\Http\Controllers;

use App\Models\HomeContent;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function update(Request $request, $id)
    {
        $homecontent = HomeContent::findOrFail($id);
    
        $validatedData = $request->validate([
            'main_title' => 'nullable|string|max:255',
            'sub_title' => 'nullable|string|max:255',
            'about_us' => 'nullable|string',
            'latest_news_title' => 'nullable|string|max:255',
            'latest_news_desc' => 'nullable|string',
            'our_vision_title' => 'nullable|string|max:255',
            'our_vision_desc' => 'nullable|string',
            'team_title' => 'nullable|string|max:255',
            'team_desc' => 'nullable|string',
        ]);
    
        $homecontent->update($validatedData);
        return redirect()->route('admin.dashboard')->with('success', 'Homepage updated successfully.');
    }
}
