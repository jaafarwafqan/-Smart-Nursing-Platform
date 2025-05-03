<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Branch;
use App\Services\CampaignService;
use App\Http\Requests\StoreCampaignRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CampaignController extends Controller
{
    public function __construct(private CampaignService $service)
    {
        $this->authorizeResource(Campaign::class, 'campaign');
    }

    public function index(): View
    {
        $campaigns = Campaign::with('branch')->latest()->paginate(10);
        return view('campaigns.index', compact('campaigns'));
    }

    public function create(): View
    {
        $branches = Branch::pluck('name', 'id');
        return view('campaigns.create', compact('branches'));
    }

    public function store(StoreCampaignRequest $request): RedirectResponse
    {
        $campaign = $this->service->create($request->validated());
        return to_route('campaigns.show', $campaign)->withSuccess('تمّت الإضافة');
    }

    public function show(Campaign $campaign): View
    {
        return view('campaigns.show', compact('campaign'));
    }

    public function edit(Campaign $campaign): View
    {
        $branches = Branch::pluck('name', 'id');
        return view('campaigns.edit', compact('campaign', 'branches'));
    }

    public function update(StoreCampaignRequest $request, Campaign $campaign): RedirectResponse
    {
        $this->service->update($campaign, $request->validated());
        return back()->withSuccess('تمّ التعديل');
    }

    public function destroy(Campaign $campaign): RedirectResponse
    {
        $this->service->delete($campaign);
        return to_route('campaigns.index')->withSuccess('تمّ الحذف');
    }
}
