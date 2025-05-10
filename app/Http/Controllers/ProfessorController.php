<?php

namespace App\Http\Controllers;

use App\Contracts\ProfessorServiceInterface;
use App\Imports\ProfessorsImport;
use App\Models\Professor;
use App\Models\Research;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use App\Exports\ProfessorsExport;

class ProfessorController extends Controller
{
    public function __construct(private ProfessorServiceInterface $service)
    {
        $this->authorizeResource(Professor::class, 'professor');
    }

    public function index(Request $request)
    {
        $allowedSorts = ['id', 'name', 'gender', 'academic_rank', 'college', 'department', 'phone', 'email'];
        $sort = $request->get('sort_by', 'id');
        $direction = $request->get('sort_dir', 'desc');

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }

        $professors = Professor::query()
            ->when($request->input('search'), fn($q, $s) => $q->where('name', 'like', "%$s%"))
            ->orderBy($sort, $direction)
            ->paginate(20);

        $stats = [
            'total'      => Professor::count(),
            'professors' => Professor::where('academic_rank', 'أستاذ')->count(),
            'assistants' => Professor::where('academic_rank', 'أستاذ مساعد')->count(),
            'female'     => Professor::where('gender', 'انثى')->count(),
        ];

        return view('professors.index', compact('professors', 'stats'));
    }

    public function create()
    {
        return view('professors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:ذكر,انثى',
            'academic_rank' => 'required|string|max:255',
            'college' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'research_interests' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'notes' => 'nullable|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $professor = $this->service->create($validated);

        return redirect()->route('professors.index')
            ->with('success', 'تم إضافة الأستاذ بنجاح');
    }

    public function show(Professor $professor)
    {
        $professor->load(['researches', 'professorResearches']);
        return view('professors.show', compact('professor'));
    }

    public function edit(Professor $professor)
    {
        return view('professors.edit', compact('professor'));
    }

    public function update(Request $request, Professor $professor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:ذكر,انثى',
            'academic_rank' => 'required|string|max:255',
            'college' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'research_interests' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'notes' => 'nullable|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $this->service->update($professor, $validated);

        return redirect()->route('professors.index')
            ->with('success', 'تم تحديث بيانات الأستاذ بنجاح');
    }

    public function destroy(Professor $professor)
    {
        $this->service->delete($professor);

        return redirect()->route('professors.index')
            ->with('success', 'تم حذف الأستاذ بنجاح');
    }

    // استيراد الأساتذة من Excel (واجهة رفع الملف)
    public function importForm()
    {
        return view('professors.import');
    }

    // تنفيذ الاستيراد
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv',
        ]);

        try {
            Excel::import(new ProfessorsImport, $request->file('file'));
            return back()->withSuccess('تم الاستيراد بنجاح.');
        } catch (ValidationException $e) {
            $errors = collect($e->failures())->map(function($f){
                return "الصف {$f->row()}: " . implode('، ', $f->errors());
            });
            return back()->withErrors($errors->all());
        }
    }

    // تصدير الأساتذة إلى Excel
    public function export()
    {
        // return Excel::download(new ProfessorsExport, 'professors.xlsx');
        return response()->json(['message' => 'تم التصدير (نموذج)']);
    }

    // ربط أستاذ ببحث
    public function attachResearch(Request $request, Professor $professor)
    {
        $data = $request->validate([
            'research_id' => 'required|exists:researches,id',
            'role' => 'nullable|string',
        ]);
        $professor->researches()->attach($data['research_id'], [
            'role' => $data['role'] ?? null,
        ]);
        return redirect()->route('professors.show', $professor)->with('success', 'تم ربط البحث بالأستاذ');
    }
}
