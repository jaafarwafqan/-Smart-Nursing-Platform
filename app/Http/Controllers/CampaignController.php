<?php

namespace App\Http\Controllers;

use App\Contracts\CampaignServiceInterface;
use App\Models\Campaign;
use App\Models\Branch;
use App\Http\Requests\StoreCampaignRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    /**
     * @param CampaignServiceInterface $service
     */
    public function __construct(private CampaignServiceInterface $service)
    {
        $this->authorizeResource(Campaign::class, 'campaign');
    }

    /* ───────────────────────────────
       قائمة الحملات مع فلاتر بسيطة
    ─────────────────────────────── */
    public function index(Request $request): View
    {
        $query = Campaign::query()
            ->when($request->branch_id, fn($q, $v) => $q->where('branch_id', $v))
            ->when($request->search, fn($q, $v) => $q->where('campaign_title', 'like', "%$v%"))
            ->when($request->status, fn($q, $v) => $q->where('status', $v))
            ->when($request->start_date, fn($q, $v) => $q->whereDate('start_date', '>=', $v))
            ->when($request->end_date, fn($q, $v) => $q->whereDate('end_date', '<=', $v))
            ->orderBy($request->get('sort', 'start_date'), $request->get('direction', 'desc'));
        $campaigns = $query->paginate(15);

        $stats = [
            'total_campaigns'      => Campaign::count(),
            'pending_campaigns'    => Campaign::where('status', 'pending')->count(),
            'total_participants'   => Campaign::sum('participants_count'),
            'average_participants' => round(Campaign::avg('participants_count')),
        ];

        return view('campaigns.index', [
            'branches'  => Branch::pluck('name', 'id'),
            'stats'     => $stats,
            'campaigns' => $campaigns,
        ]);
    }

    public function create(): View
    {
        return view('campaigns.create', [
            'branches' => Branch::pluck('name', 'id'),
            'campaign' => null,
        ]);
    }

    public function store(StoreCampaignRequest $request): RedirectResponse
    {
        $campaign = $this->service->create($request->validated());

        return to_route('campaigns.index', $campaign)
            ->withSuccess('تمّت إضافة الحملة بنجاح');
    }

    public function edit(Campaign $campaign): View
    {
        return view('campaigns.edit', [
            'campaign' => $campaign,
            'branches' => Branch::pluck('name', 'id'),
        ]);
    }

    public function update(StoreCampaignRequest $request, Campaign $campaign): RedirectResponse
    {
        $this->service->update($campaign, $request->validated());

        return back()->withSuccess('تمّ تحديث الحملة');
    }

    /* ───────────────────────────────
       حذف حملة
    ─────────────────────────────── */
    public function destroy(Campaign $campaign): RedirectResponse
    {
        $this->service->delete($campaign);

        return to_route('campaigns.index')->withSuccess('تمّ حذف الحملة');
    }

    public function show(Campaign $campaign): View
    {
        return view('campaigns._form', [
            'campaign' => $campaign,
            'branches' => Branch::pluck('name', 'id'),
        ]);
    }
}
