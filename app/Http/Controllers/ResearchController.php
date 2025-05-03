<?php

namespace App\Http\Controllers;

use App\Models\researches;
use App\Models\Branch;
use App\Services\ResearchService;
use App\Http\Requests\StoreResearchRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ResearchController extends Controller
{
    public function __construct(private ResearchService $service)
    {
        $this->authorizeResource(researches::class, 'researches');
    }

    public function index(): View
    {
        $researches = researches::with('branch')->latest()->paginate(10);
        return view('researches.index', compact('researches'));
    }

    public function create(): View
    {
        $branches = Branch::pluck('name','id');
        return view('researches.create', compact('branches'));
    }

    public function store(StoreResearchRequest $request): RedirectResponse
    {
        $researches = $this->service->create($request->validated());
        return to_route('researches.show', $researches)->withSuccess('تمّت الإضافة');
    }

    public function edit(researches $researches): View
    {
        $branches = Branch::pluck('name', 'id');
        return view('researches.edit', compact('researches', 'branches'));
    }

    public function update(StoreResearchRequest $request, researches $researches): RedirectResponse
    {
        $this->service->update($researches, $request->validated());
        return back()->withSuccess('تمّ التعديل');
    }

    public function destroy(researches $researches): RedirectResponse
    {
        $this->service->delete($researches);
        return to_route('researches.index')->withSuccess('تمّ الحذف');
    }
}
