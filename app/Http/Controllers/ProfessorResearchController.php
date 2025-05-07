<?php

namespace App\Http\Controllers;

use App\Models\ProfessorResearch;
use App\Models\Professor;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfessorResearchController extends Controller
{
    public function index(Request $request)
    {
        $query = ProfessorResearch::query();

        // تطبيق الفلاتر
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('professor')) {
            $query->whereHas('professors', function ($q) use ($request) {
                $q->where('professors.id', $request->professor);
            });
        }

        if ($request->filled('research_type')) {
            $query->where('research_type', $request->research_type);
        }

        if ($request->filled('publication_status')) {
            $query->where('publication_status', $request->publication_status);
        }

        if ($request->filled('completion_status')) {
            if ($request->completion_status === 'completed') {
                $query->where('completion_percentage', 100);
            } elseif ($request->completion_status === 'in_progress') {
                $query->where('completion_percentage', '<', 100);
            }
        }

        if ($request->filled('date_range')) {
            $dates = explode(' - ', $request->date_range);
            if (count($dates) === 2) {
                $query->whereBetween('start_date', $dates);
            }
        }

        // إحصائيات عامة
        $totalResearches = ProfessorResearch::count();
        $inProgressResearches = ProfessorResearch::where('completion_percentage', '<', 100)->count();
        $completedResearches = ProfessorResearch::where('completion_percentage', 100)->count();
        $publishedResearches = ProfessorResearch::where('publication_status', ProfessorResearch::PUBLICATION_PUBLISHED)->count();
        $totalProfessors = Professor::count();
        $activeProfessors = Professor::whereHas('professorResearches')->count();

        $scopusIndexed = \App\Models\ProfessorResearch::whereHas('journals', function($q) {
            $q->where('is_scopus_indexed', true);
        })->count();
        $clarivateIndexed = \App\Models\ProfessorResearch::whereHas('journals', function($q) {
            $q->where('is_clarivate_indexed', true);
        })->count();

        $researches = $query->with(['professors', 'journals'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $professors = Professor::orderBy('name')->get();
        $journals = Journal::orderBy('name')->get();

        return view('professor-researches.index', compact(
            'researches',
            'professors',
            'journals',
            'totalResearches',
            'inProgressResearches',
            'completedResearches',
            'publishedResearches',
            'totalProfessors',
            'activeProfessors',
            'scopusIndexed',
            'clarivateIndexed'
        ));
    }

    public function create()
    {
        $branches = \App\Models\Branch::pluck('name', 'id');
        $professors = Professor::orderBy('name')->get();
        $journals = Journal::orderBy('name')->get();

        return view('professor-researches.create', compact('branches', 'professors', 'journals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'title' => 'required|string|max:255',
            'research_type' => 'required|in:' . implode(',', [ProfessorResearch::TYPE_QUALITATIVE, ProfessorResearch::TYPE_QUANTITATIVE]),
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'publication_status' => 'required|in:' . implode(',', [
                ProfessorResearch::PUBLICATION_DRAFT,
                ProfessorResearch::PUBLICATION_SUBMITTED,
                ProfessorResearch::PUBLICATION_UNDER_REVIEW,
                ProfessorResearch::PUBLICATION_ACCEPTED,
                ProfessorResearch::PUBLICATION_PUBLISHED
            ]),
            'completion_percentage' => 'required|integer|min:0|max:100',
            'abstract' => 'required|string',
            'keywords' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'notes' => 'nullable|string',
            'professors' => 'required|array|min:1',
            'professors.*' => 'exists:professors,id',
            'professor_roles' => 'required|array|min:1',
            'professor_roles.*' => 'required|string|max:255',
            'journals' => 'nullable|array',
            'journals.*.name' => 'required|string',
            'journals.*.type' => 'required|string|in:local,international,scopus,clarivate',
            'journals.*.id' => 'nullable|exists:journals,id',
        ]);

        // رفع الملف إذا تم اختياره
        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('professor-researches', 'public');
        }

        // إنشاء البحث
        $research = ProfessorResearch::create($validated);

        // إرفاق الأساتذة
        foreach ($request->professors as $index => $professorId) {
            $research->professors()->attach($professorId, [
                'role' => $request->professor_roles[$index]
            ]);
        }

        // إرفاق المجلات (مع إنشاء المجلات الجديدة إذا لم يوجد id)
        $journalIds = [];
        if ($request->filled('journals')) {
            foreach ($request->input('journals', []) as $journalData) {
                if (isset($journalData['id']) && !empty($journalData['id'])) {
                    $journalIds[] = $journalData['id'];
                } else {
                    $journal = Journal::firstOrCreate([
                        'name' => $journalData['name'],
                        'type' => $journalData['type'],
                    ]);
                    $journalIds[] = $journal->id;
                }
            }
            $research->journals()->attach($journalIds);
        }

        return redirect()->route('professor-researches.index')
            ->with('success', 'تم إضافة البحث بنجاح');
    }

    public function show(ProfessorResearch $professorResearch)
    {
        $professorResearch->load(['professors', 'journals']);
        return view('professor-researches._form', compact('professorResearch'));
    }

    public function edit(ProfessorResearch $professorResearch)
    {
        $branches = \App\Models\Branch::pluck('name', 'id');
        $professors = Professor::orderBy('name')->get();
        $journals = Journal::orderBy('name')->get();
        $professorResearch->load(['professors', 'journals']);

        return view('professor-researches.edit', compact('professorResearch', 'branches', 'professors', 'journals'));
    }

    public function update(Request $request, ProfessorResearch $professorResearch)
    {
        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'title' => 'required|string|max:255',
            'research_type' => 'required|in:' . implode(',', [ProfessorResearch::TYPE_QUALITATIVE, ProfessorResearch::TYPE_QUANTITATIVE]),
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'publication_status' => 'required|in:' . implode(',', [
                ProfessorResearch::PUBLICATION_DRAFT,
                ProfessorResearch::PUBLICATION_SUBMITTED,
                ProfessorResearch::PUBLICATION_UNDER_REVIEW,
                ProfessorResearch::PUBLICATION_ACCEPTED,
                ProfessorResearch::PUBLICATION_PUBLISHED
            ]),
            'completion_percentage' => 'required|integer|min:0|max:100',
            'abstract' => 'required|string',
            'keywords' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'notes' => 'nullable|string',
            'professors' => 'required|array|min:1',
            'professors.*' => 'exists:professors,id',
            'professor_roles' => 'required|array|min:1',
            'professor_roles.*' => 'required|string|max:255',
            'journals' => 'nullable|array',
            'journals.*' => 'exists:journals,id'
        ]);

        // رفع الملف إذا تم اختياره
        if ($request->hasFile('file')) {
            // حذف الملف القديم إذا وجد
            if ($professorResearch->file_path) {
                Storage::disk('public')->delete($professorResearch->file_path);
            }
            $validated['file_path'] = $request->file('file')->store('professor-researches', 'public');
        }

        // تحديث البحث
        $professorResearch->update($validated);

        // تحديث الأساتذة
        $professorResearch->professors()->detach();
        foreach ($request->professors as $index => $professorId) {
            $professorResearch->professors()->attach($professorId, [
                'role' => $request->professor_roles[$index]
            ]);
        }

        // تحديث المجلات
        $professorResearch->journals()->sync($request->journals ?? []);

        return redirect()->route('professor-researches.index')
            ->with('success', 'تم تحديث البحث بنجاح');
    }

    public function destroy(ProfessorResearch $professorResearch)
    {
        // حذف الملف إذا وجد
        if ($professorResearch->file_path) {
            Storage::disk('public')->delete($professorResearch->file_path);
        }

        $professorResearch->delete();

        return redirect()->route('professor-researches.index')
            ->with('success', 'تم حذف البحث بنجاح');
    }
}
