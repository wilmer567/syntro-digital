<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Principle;
use App\Models\ProcessStep;
use App\Models\Project;
use App\Models\Service;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin overview dashboard.
     */
    public function index(): View
    {
        $stats = [
            'services_count' => Service::count(),
            'services_active' => Service::where('is_active', true)->count(),
            'projects_count' => Project::count(),
            'projects_active' => Project::where('is_active', true)->count(),
            'principles_count' => Principle::count(),
            'process_count' => ProcessStep::count(),
            'messages_count' => ContactMessage::count(),
            'messages_unread' => ContactMessage::where('is_read', false)->count(),
        ];

        $recentMessages = ContactMessage::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentMessages'));
    }
}
