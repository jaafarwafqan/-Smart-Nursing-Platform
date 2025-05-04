<?php

namespace App\Http\Controllers;

use App\Contracts\CampaignServiceInterface;
use App\Models\Campaign;
use App\Models\Branch;
use App\Http\Requests\StoreCampaignRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

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
    public function index(): View
    {
        $query = Campaign::query()
            ->when(request('search'),     fn ($q, $s) => $q->whereFullText('title', $s))
            ->when(request('branch_id'),  fn ($q, $b) => $q->where('branch_id', $b))
            ->with('branch')              // تأكّد أن العلاقة branch معرَّفة
            ->latest();

        $campaigns = $query->paginate(10);

        return view('campaigns.index', [
            'campaigns' => $campaigns,
            'branches'  => Branch::pluck('name', 'id'),
        ]);
    }

    /* ───────────────────────────────
       إنشاء حملة
    ─────────────────────────────── */
    public function create(): View
    {
        return view('campaigns.create', [
            'branches' => Branch::pluck('name', 'id'),
            'campaign' => null,           // ليُعاد استخدام form‑partial
        ]);
    }

    public function store(StoreCampaignRequest $request): RedirectResponse
    {
        $campaign = $this->service->create($request->validated());

        return to_route('campaigns.show', $campaign)
            ->withSuccess('تمّت إضافة الحملة بنجاح');
    }

    /* ───────────────────────────────
       عرض حملة منفردة
    ─────────────────────────────── */


    /* ───────────────────────────────
       تعديل حملة
    ─────────────────────────────── */
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
}
