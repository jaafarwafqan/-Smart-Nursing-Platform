<?php

namespace App\Http\Controllers;

use App\Models\Research;
use App\Models\Student;
use App\Models\Professor;
use App\Models\Journal;
use App\Services\ResearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ResearchesExport;
use App\Models\Branch;

class ResearchController extends Controller
{
    public function __construct(private ResearchService $service)
    {
        $this->authorizeResource(Research::class, 'research');
    }

    public function index(Request $request)
    {
        $query = Research::query()
            ->searchByTitle($request->input('title'))
            ->byPublicationStatus($request->input('publication_status'))
            ->byResearchType($request->input('research_type'));

        // فلاتر البحث
        if ($request->filled('professor')) {
            $query->whereHas('professors', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->professor . '%');
            });
        }
        if ($request->filled('student')) {
            $query->whereHas('students', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->student . '%');
            });
        }
        if ($request->filled('journal_type')) {
            $query->whereHas('journals', function ($q) use ($request) {
                if ($request->journal_type == 'local') $q->where('type', 'local');
                if ($request->journal_type == 'international') $q->where('type', 'international');
                if ($request->journal_type == 'scopus') $q->where('type', 'international')->where('is_scopus_indexed', true);
                if ($request->journal_type == 'clarivate') $q->where('type', 'international')->where('is_clarivate_indexed', true);
            });
        }

        // إحصائيات
        $stats = [
            'total' => Research::count(),
            'in_progress' => Research::where('status', 'in_progress')->count(),
            'completed' => Research::where('status', 'completed')->count(),
            'cancelled' => Research::where('status', 'cancelled')->count(),
        ];

        $researches = $query->with(['students', 'professors', 'journals'])->latest()->paginate(10)->withQueryString();
        return view('researches.index', compact('researches', 'stats'));
    }

    public function create()
    {
        $branches = Branch::pluck('name', 'id');
        $students = Student::all();
        $professors = Professor::all();
        $journals = Journal::all();
        $isProfessorView = request('view') === 'professors';

        return view('researches.create', compact('branches', 'students', 'professors', 'journals', 'isProfessorView'));
    }

    public function store(Request $request)
    {
        $isProfessorView = $request->query('view') === 'professors';
        $rules = [
            'title' => 'required|string|max:255',
            'abstract' => 'nullable|string',
            'keywords' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'notes' => 'nullable|string',
            'professors' => 'required|array',
            'professors.*' => 'exists:professors,id',
            'professor_roles' => 'required|array',
            'research_type' => 'required|in:qualitative,quantitative',
            'publication_status' => 'required|in:draft,submitted,under_review,accepted,published',
            'completion_percentage' => 'required|integer|min:0|max:100',
            'journals' => 'nullable|array',
            'journals.*' => 'exists:journals,id',
        ];
        if (!$isProfessorView) {
            $rules['students'] = 'required|array';
            $rules['students.*'] = 'exists:students,id';
            $rules['student_roles'] = 'required|array';
        }
        $validated = $request->validate($rules);
        $extra = [
            'isProfessorView' => $isProfessorView,
            'student_roles' => $validated['student_roles'] ?? [],
            'professor_roles' => $validated['professor_roles'],
        ];
        $this->service->create($validated, $extra);
        return redirect()->route('researches.index', ['view' => $isProfessorView ? 'professors' : null])
            ->with('success', 'تم إنشاء البحث بنجاح');
    }

    public function show(Research $research)
    {
        $research->load(['students', 'professors', 'journals']);
        return view('researches.show', compact('research'));
    }

    public function edit(Research $research)
    {
        $research->load(['students', 'professors', 'journals']);
        $students = Student::all();
        $professors = Professor::all();
        $journals = Journal::all();
        return view('researches.edit', compact('research', 'students', 'professors', 'journals'));
    }

    public function update(Request $request, Research $research)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'nullable|string',
            'keywords' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'notes' => 'nullable|string',
            'students' => 'required|array',
            'students.*' => 'exists:students,id',
            'student_roles' => 'required|array',
            'professors' => 'required|array',
            'professors.*' => 'exists:professors,id',
            'professor_roles' => 'required|array',
            'research_type' => 'required|in:qualitative,quantitative',
            'publication_status' => 'required|in:draft,submitted,under_review,accepted,published',
            'completion_percentage' => 'required|integer|min:0|max:100',
            'journals' => 'nullable|array',
            'journals.*' => 'exists:journals,id',
        ]);
        $extra = [
            'student_roles' => $validated['student_roles'],
            'professor_roles' => $validated['professor_roles'],
        ];
        $this->service->update($research, $validated, $extra);
        return redirect()->route('researches.index')
            ->with('success', 'تم تحديث البحث بنجاح');
    }

    public function destroy(Research $research)
    {
        $this->service->delete($research);
        return redirect()->route('researches.index')
            ->with('success', 'تم حذف البحث بنجاح');
    }

    public function download(Research $research)
    {
        if (!$research->file_path) {
            return back()->with('error', 'لا يوجد ملف للبحث');
        }
        return Storage::download($research->file_path);
    }

    public function export()
    {
        return Excel::download(new ResearchesExport, 'researches.xlsx');
    }
}
