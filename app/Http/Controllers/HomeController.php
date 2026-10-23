<?php

namespace App\Http\Controllers;

use App\Models\Principle;
use App\Models\ProcessStep;
use App\Models\Project;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the home/landing page with dynamic data.
     */
    public function index(): View
    {
        $settings = SiteSetting::allAsKeyMap();
        $services = Service::where('is_active', true)->orderBy('order')->get();
        $principles = Principle::where('is_active', true)->orderBy('order')->get();
        $processSteps = ProcessStep::where('is_active', true)->orderBy('order')->get();
        $projects = Project::with('images')->where('is_active', true)->orderBy('order')->get();

        return view('welcome', compact('settings', 'services', 'principles', 'processSteps', 'projects'));
    }
}
