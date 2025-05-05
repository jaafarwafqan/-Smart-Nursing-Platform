<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\StatisticsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Branch;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $statistics = $this->buildStatistics($year);
        return view('dashboard.index', compact('year', 'statistics'));
    }

    public function statistical(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $statistics = $this->buildStatistics($year);
        return view('dashboard.statistical', compact('year', 'statistics'));
    }

    private function buildStatistics($year)
    {
        $branches =  [
            'فرع تمريض البالغين', 'فرع أساسيات التمريض', 'فرع صحة الأم والوليد', 'فرع صحة المجتمع',
            'فرع تمريض الأطفال', 'فرع تمريض الصحة النفسية', 'فرع العلوم الأساسية', 'نشاطات طلابية',
            'برنامج حكومي', 'التعليم المستمر', 'العلمية', 'الإرشاد النفسي', 'التأهيل والتوظيف',
            'شؤون المرأة', 'حقوق الإنسان', 'الدراسات العليا'
        ];

        $eventTypesList = [
            'مؤتمر علمي', 'ندوة علمية', 'ورشة عمل', 'نشاط تعليمي مبتكر', 'مشروع بحثي',
            'تعاون دولي', 'خدمة مجتمعية', 'تطوير مناهج', 'نشر كتاب أو فصل', 'براءة اختراع',
            'استشارات علمية', 'أطروحة أو رسالة', 'حلقة نقاشية', 'زيارات ميدانية'
        ];

        /* الفعاليات حسب الفرع ونوع الفعالية */
        $eventsByBranchAndType = Event::select(
            'branches.name  as branch',
            'event_type',
            DB::raw('COUNT(*) as total')
        )
            ->join('branches', 'events.branch_id', '=', 'branches.id')
            ->whereYear('event_datetime', $year)
            ->groupBy('branches.name', 'event_type')
            ->get();

        /* الحملات حسب الفرع */
        $campaignsByBranch = Campaign::select(
            'branches.name  as branch',
            DB::raw('COUNT(*) as total')
        )
            ->join('branches', 'campaigns.branch_id', '=', 'branches.id')
            ->whereYear('campaigns.created_at', $year)
            ->groupBy('branches.name')
            ->get();

        $colors = [
            'فرع تمريض البالغين' => ['border' => 'border-green-600', 'icon' => 'text-green-600 fa-user-md'],
            'فرع أساسيات التمريض' => ['border' => 'border-blue-600', 'icon' => 'text-blue-600 fa-book-medical'],
            'فرع صحة الأم والوليد' => ['border' => 'border-pink-500', 'icon' => 'text-pink-500 fa-baby'],
            'فرع صحة المجتمع' => ['border' => 'border-indigo-600', 'icon' => 'text-indigo-600 fa-people-group'],
            'فرع تمريض الأطفال' => ['border' => 'border-yellow-500', 'icon' => 'text-yellow-500 fa-child'],
            'فرع تمريض الصحة النفسية' => ['border' => 'border-purple-600', 'icon' => 'text-purple-600 fa-brain'],
            'فرع العلوم الأساسية' => ['border' => 'border-red-500', 'icon' => 'text-red-500 fa-flask'],
            'نشاطات طلابية' => ['border' => 'border-orange-500', 'icon' => 'text-orange-500 fa-users-line'],
            'برنامج حكومي' => ['border' => 'border-cyan-500', 'icon' => 'text-cyan-500 fa-landmark'],
            'التعليم المستمر' => ['border' => 'border-teal-600', 'icon' => 'text-teal-600 fa-graduation-cap'],
            'العلمية' => ['border' => 'border-amber-600', 'icon' => 'text-amber-600 fa-microscope'],
            'الإرشاد النفسي' => ['border' => 'border-fuchsia-500', 'icon' => 'text-fuchsia-500 fa-comments'],
            'التأهيل والتوظيف' => ['border' => 'border-lime-600', 'icon' => 'text-lime-600 fa-handshake'],
            'شؤون المرأة' => ['border' => 'border-rose-500', 'icon' => 'text-rose-500 fa-person-dress'],
            'حقوق الإنسان' => ['border' => 'border-emerald-600', 'icon' => 'text-emerald-600 fa-scale-balanced'],
            'الدراسات العليا' => ['border' => 'border-violet-600', 'icon' => 'text-violet-600 fa-user-graduate']
        ];

        $statistics = collect();

        foreach ($branches as $branch) {
            $eventTypesCount = [];
            foreach ($eventTypesList as $type) {
                $count = $eventsByBranchAndType->firstWhere(fn($row) => $row->branch === $branch && $row->event_type === $type);
                $eventTypesCount[$type] = $count ? $count->total : 0;
            }

            $eventTotal = array_sum($eventTypesCount);
            $campaignData = $campaignsByBranch->firstWhere('branch', $branch);
            $campaignTotal = $campaignData ? $campaignData->total : 0;

            $statistics->push([
                'branch' => $branch,
                'types' => $eventTypesCount,
                'events_total' => $eventTotal,
                'campaigns_total' => $campaignTotal,
                'color' => $colors[$branch]['border'] ?? 'border-gray-500',
                'icon_color' => $colors[$branch]['icon'] ?? 'text-blue-500 fa-chart-pie',
            ]);
        }

        return $statistics->sortByDesc('events_total')->values();
    }

    public function export(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $statistics = $this->buildStatistics($year);
        return Excel::download(new StatisticsExport($statistics), "statistics_{$year}.xlsx");
    }

    public function report(Request $request)
    {
        $query = Event::query();

        if ($request->has('branch') && $request->branch != '') {
            $query->where('branch_id', $request->branch);
        }
        if ($request->has('from_date') && $request->from_date != '') {
            $query->whereDate('event_datetime', '>=', $request->from_date);
        }
        if ($request->has('to_date') && $request->to_date != '') {
            $query->whereDate('event_datetime', '<=', $request->to_date);
        }

        $events = $query->with('branch')->orderBy('event_datetime', 'desc')->paginate(10);
        $eventTypes = Event::distinct()->pluck('event_type');
        $branches = Branch::all();

        return view('dashboard.report', compact('events', 'eventTypes', 'branches'));
    }

    private function getStatistics($year)
    {
        $statistics = [];
        $branches = Branch::all();

        foreach ($branches as $branch) {
            $eventsQuery = Event::where('branch_id', $branch->id);
            $campaignsQuery = Campaign::where('branch_id', $branch->id);

            if ($year != 'all') {
                $eventsQuery->whereYear('event_datetime', $year);
                $campaignsQuery->where(function($query) use ($year) {
                    $query->whereYear('start_date', $year)
                          ->orWhereYear('end_date', $year);
                });
            }

            $statistics[] = [
                'branch' => $branch->name,
                'events_total' => $eventsQuery->count(),
                'campaigns_total' => $campaignsQuery->count(),
                'active_campaigns' => $campaignsQuery->where('status', 'جارية')->count(),
                'completed_campaigns' => $campaignsQuery->where('status', 'مكتملة')->count(),
                'planned_campaigns' => $campaignsQuery->where('status', 'مخطط لها')->count(),
                'total_campaign_participants' => $campaignsQuery->sum('participants'),
            ];
        }

        return $statistics;
    }
}
