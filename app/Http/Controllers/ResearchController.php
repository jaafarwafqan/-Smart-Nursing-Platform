<?php

namespace App\Http\Controllers;

use App\Models\Research;
use App\Models\Branch;
use App\Http\Requests\StoreResearchRequest;
use App\Services\ResearchService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ResearchController extends Controller
{
    public function __construct(private ResearchService $service)
    {
        $this->authorizeResource(Research::class, 'research');
    }

    public function index(): View
    {
        $stats = [
            'total'      => Research::count(),
            'pending'    => Research::where('status', 'pending')->count(),
            'inprogress' => Research::where('status', 'inprogress')->count(),
            'completed'  => Research::where('status', 'completed')->count(),
            'cancelled'  => Research::where('status', 'cancelled')->count(),
            'rejected'   => Research::where('status', 'rejected')->count(),
        ];
        $researches = Research::with('branch')->latest()->paginate(10);
        return view('researches.index', compact('researches', 'stats'));
    }

    public function create(): View
    {
        $branches = Branch::pluck('name', 'id');
        return view('researches.create', compact('branches'));
    }

    public function store(StoreResearchRequest $request): RedirectResponse
    {
        $research = $this->service->create($request->validated());
        return to_route('researches.show', $research)->withSuccess('تمّت الإضافة');
    }

    public function edit(Research $research): View
    {
        $branches = Branch::pluck('name', 'id');
        return view('researches.edit', compact('research', 'branches'));
    }

    public function update(StoreResearchRequest $request, Research $research): RedirectResponse
    {
        $this->service->update($research, $request->validated());
        return back()->withSuccess('تمّ التعديل');
    }

    public function destroy(Research $research): RedirectResponse
    {
        $this->service->delete($research);
        return to_route('researches.index')->withSuccess('تمّ الحذف');
    }
}
