<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Principle;
use App\Models\ProcessStep;
use App\Models\Project;
use App\Models\Service;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin overview dashboard.
     */
    public function index(): View
    {
        $todayStart = Carbon::today();
        $sevenDaysAgo = Carbon::today()->subDays(6);

        $visitsTotal = Visit::count();
        $visitsUniqueTotal = Visit::distinct('ip_hash')->count('ip_hash');
        $visitsToday = Visit::where('created_at', '>=', $todayStart)->count();
        $visitsUniqueToday = Visit::where('created_at', '>=', $todayStart)->distinct('ip_hash')->count('ip_hash');
        $visitsWeek = Visit::where('created_at', '>=', $sevenDaysAgo)->count();

        // 7-day daily visits
        $dailyVisits = [];
        $maxDailyVisits = 1;
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $start = $date->copy()->startOfDay();
            $end = $date->copy()->endOfDay();
            $total = Visit::whereBetween('created_at', [$start, $end])->count();
            $unique = Visit::whereBetween('created_at', [$start, $end])->distinct('ip_hash')->count('ip_hash');

            if ($total > $maxDailyVisits) {
                $maxDailyVisits = $total;
            }

            $dailyVisits[] = [
                'day_label' => $date->format('d/m'),
                'day_name' => ucfirst($date->locale('es')->isoFormat('ddd')),
                'total' => $total,
                'unique' => $unique,
            ];
        }

        // Device breakdown
        $deviceCounts = Visit::selectRaw('device, count(*) as count')
            ->groupBy('device')
            ->pluck('count', 'device')
            ->toArray();

        $recentVisits = Visit::latest()->take(10)->get();

        $stats = [
            'services_count' => Service::count(),
            'services_active' => Service::where('is_active', true)->count(),
            'projects_count' => Project::count(),
            'projects_active' => Project::where('is_active', true)->count(),
            'principles_count' => Principle::count(),
            'process_count' => ProcessStep::count(),
            'messages_count' => ContactMessage::count(),
            'messages_unread' => ContactMessage::where('is_read', false)->count(),
            'visits_total' => $visitsTotal,
            'visits_unique_total' => $visitsUniqueTotal,
            'visits_today' => $visitsToday,
            'visits_unique_today' => $visitsUniqueToday,
            'visits_week' => $visitsWeek,
        ];

        $recentMessages = ContactMessage::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentMessages',
            'dailyVisits',
            'maxDailyVisits',
            'deviceCounts',
            'recentVisits'
        ));
    }
}
