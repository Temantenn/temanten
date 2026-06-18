<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use Illuminate\Http\Request;

class ThemeController extends Controller
{

    public function index()
    {
        $themes = Theme::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('themes.catalog', compact('themes'));
    }

    public function show($slug)
    {
        $theme = Theme::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Theme detail pages render full invitation templates which need $invitation data.
        // Redirect to the working demo route instead.
        return redirect()->route('demo.show', ['theme' => $theme->slug]);
    }
}
